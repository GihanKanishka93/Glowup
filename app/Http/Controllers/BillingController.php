<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\UpdateBillRequest;
use App\Models\Treatment;
use App\Models\Bill;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\BillItem;
use App\Models\Prescription;
use App\Models\Drug;
use App\Models\Services;
use App\Models\DosageTypes;
use App\Models\DurationTypes;
use App\Models\DurationWeeks;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\DataTables\billingDataTable;
use Illuminate\Support\Facades\Storage;
use App\Models\Dose;
use App\Services\BillingService;
use App\Mail\NextClinicReminderMail;
use App\Models\ReminderLog;
use Illuminate\Support\Facades\Mail;
use App\Mail\BillEmail;
use PDF;  // Use this alias if configured in aliases array

class BillingController extends Controller
{
    public function __construct(private readonly BillingService $billingService)
    {
    }


    /**
     * Display a listing of the resource.
     */
    public function index(billingDataTable $datatable)
    {
        $user = Auth::user();

        if ($user && $user->hasRole('Cashier')) {
            $today = Carbon::today();

            $queueBadgeEnabled = config('billing.queue_badge_enabled', true);

            $readyToPrint = 0;

            if ($queueBadgeEnabled) {
                $readyToPrint = Bill::query()
                    ->whereNull('bills.deleted_at')
                    ->whereDate('billing_date', '>=', $today)
                    ->where(function ($query) {
                        $query->whereNull('print_status')
                            ->orWhere('print_status', '!=', 1);
                    })
                    ->count();
            }

            $printedToday = Bill::query()
                ->whereNull('bills.deleted_at')
                ->where('print_status', 1)
                ->whereDate('updated_at', $today)
                ->count();

            $outstandingTotal = Bill::query()
                ->whereNull('bills.deleted_at')
                ->whereDate('billing_date', $today)
                ->where(function ($query) {
                    $query->whereNull('payment_status')
                        ->orWhere('payment_status', '!=', 1);
                })
                ->sum('total');

            $cashCollectedToday = Bill::query()
                ->whereNull('bills.deleted_at')
                ->where('payment_status', 1)
                ->whereDate('billing_date', $today)
                ->whereNotNull('payment_type')
                ->whereRaw('LOWER(payment_type) = ?', ['cash'])
                ->sum('total');

            $queueBills = Bill::with(['treatment.patient', 'treatment.doctor'])
                ->whereNull('bills.deleted_at')
                ->whereDate('billing_date', '>=', $today)
                ->where(function ($query) {
                    $query->whereNull('print_status')
                        ->orWhere('print_status', '!=', 1);
                })
                ->orderByDesc('created_at')
                ->limit(8)
                ->get()
                ->map(function ($bill) {
                    $bill->is_new = $bill->created_at && $bill->created_at->greaterThanOrEqualTo(Carbon::now()->subMinutes(60));
                    return $bill;
                });

            $newBillsCount = $queueBills->where('is_new', true)->count();

            $metrics = [
                'ready_to_print' => $queueBadgeEnabled ? $readyToPrint : 0,
                'printed_today' => $printedToday,
                'outstanding_total' => $outstandingTotal,
                'cash_collected_today' => $cashCollectedToday,
                'new_bills' => $newBillsCount,
            ];

            return $datatable->render('billing.cashier-dashboard', [
                'metrics' => $metrics,
                'queueBills' => $queueBills,
            ]);
        }

        return $datatable->render('billing.index');
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $drugs = Drug::all();
        $services = Services::all();
        $dosagetypes = DosageTypes::all();
        $dose = Dose::all();
        $durationtypes = DurationTypes::all();
        $durationweeks = DurationWeeks::all();

        $today = Carbon::today();

        $metrics = [
            'visits_today' => Treatment::whereDate('treatment_date', $today)->count(),
            'followups_today' => Treatment::whereDate('next_clinic_date', $today)->count(),
            'bills_today' => Bill::whereDate('billing_date', $today)->count(),
            'revenue_today' => Bill::whereDate('billing_date', $today)->sum('total'),
        ];

        $visitQueue = Treatment::with(['patient', 'doctor'])
            ->whereDate('treatment_date', $today)
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        // Auto-select doctor for authenticated users with medical roles
        $user = Auth::user();
        $authenticatedDoctorId = $user->doc_id;

        if (!$authenticatedDoctorId && ($user->hasRole('Doctor') || $user->hasRole('Head Doctor'))) {
            // Attempt fallback matching by email if doc_id isn't explicitly set
            $authenticatedDoctorId = Doctor::where('email', $user->email)->value('id');
        }



        $recentBills = Bill::with(['treatment.patient'])
            ->latest('billing_date')
            ->take(5)
            ->get();

        $lowStockItems = Services::whereColumn('stock_quantity', '<=', 'min_stock_level')
            ->where('min_stock_level', '>', 0)
            ->get();

        return view(
            "billing.create",
            compact(
                "patients",
                "doctors",
                "drugs",
                "services",
                "dosagetypes",
                "durationtypes",
                "dose",
                "durationweeks",
                "metrics",
                "visitQueue",

                "recentBills",
                "authenticatedDoctorId",
                "lowStockItems"
            )
        );
    }

    public function store(StoreBillRequest $request)
    {
        $billing = $this->billingService->createFromRequest($request);
        $this->sendImmediateReminders($billing);

        $action = $request->input('action');

        if ($action === 'save_and_print') {
            return redirect()->route('billing.print', $billing->id)->with('message', 'Successfully saved and ready to print');
        }

        if ($action === 'save_and_email') {
            $result = $this->emailBillInternal($billing);
            if ($result !== true) {
                return redirect()->route('billing.show', $billing->id)->with('danger', $result);
            }
            return redirect()->route('billing.show', $billing->id)->with('message', 'Successfully saved and emailed the bill');
        }

        return redirect()->route('billing.show', $billing->id)->with('message', 'Successfully completed');

        // return redirect()->route('billing.index')->with('message', 'Successfully completed');
    }

    private function sendImmediateReminders(Bill $billing): void
    {
        $treatment = $billing->treatment;
        $patient = $treatment?->patient;
        if (!$treatment || !$patient || empty($patient->email)) {
            return;
        }

        $ownerEmail = $patient->email;

        // Next clinic immediate email
        if (!empty($treatment->next_clinic_date)) {
            try {
                Mail::to($ownerEmail)->send(new NextClinicReminderMail($patient, $treatment));
                ReminderLog::create([
                    'reminder_type' => 'next_clinic',
                    'patient_id' => $patient->id,
                    'treatment_id' => $treatment->id,
                    'owner_email' => $ownerEmail,
                    'status' => 'sent',
                    'sent_at' => Carbon::now(),
                ]);
            } catch (\Throwable $e) {
                ReminderLog::create([
                    'reminder_type' => 'next_clinic',
                    'patient_id' => $patient->id,
                    'treatment_id' => $treatment->id,
                    'owner_email' => $ownerEmail,
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'sent_at' => Carbon::now(),
                ]);
            }
        }


    }


    /**
     * Persist client updates from the billing form without leaving the page.
     */
    public function saveClientDetails(Request $request)
    {
        $validated = $request->validate([
            'patient' => ['required', 'integer', 'exists:patients,id'],
            'nic' => ['nullable', 'string', 'max:20'],
            'mobile_number' => ['nullable', 'string', 'max:20'],
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'occupation' => ['nullable', 'string', 'max:100'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        $patient = Patient::findOrFail($validated['patient']);

        $patient->fill(array_filter($validated, fn($value) => $value !== null && $value !== ''));

        if ($patient->isDirty()) {
            $patient->save();
        }

        return response()->json([
            'message' => 'Client details saved',
            'patient' => $patient->fresh(),
        ]);
    }

    public function show($bill_id)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $drugs = Drug::all();
        $services = Services::all();
        $dosagetypes = DosageTypes::all();
        $durationtypes = DurationTypes::all();
        $durationweeks = DurationWeeks::all();

        $bill = Bill::findOrFail($bill_id);
        $treatment = Treatment::findOrFail($bill->treatment_id);
        $billItems = BillItem::where('bill_id', $bill->id)->get();
        $prescriptions = Prescription::where('trement_id', $bill->treatment_id)->get();

        return view('billing.show', compact("patients", "doctors", "drugs", "services", "dosagetypes", "durationtypes", "durationweeks", "bill", "treatment", "billItems", "prescriptions"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($bid)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $drugs = Drug::all();

        $services = Services::all();
        $dosagetypes = DosageTypes::all();
        $dose = Dose::all();
        $durationtypes = DurationTypes::all();
        $durationweeks = DurationWeeks::all();

        $lowStockItems = Services::whereColumn('stock_quantity', '<=', 'min_stock_level')
            ->where('min_stock_level', '>', 0)
            ->get();

        return view('billing.edit', compact("patients", "doctors", "drugs", "services", "dosagetypes", "durationweeks", "durationtypes", "dose", "bill", "treatment", "billItems", "prescriptions", "lowStockItems"));
    }
    public function update(UpdateBillRequest $request, $id)
    {
        $billing = Bill::findOrFail($id);
        $billing = $this->billingService->updateFromRequest($request, $billing);

        if ($request->input('action') === 'update_and_print') {
            return redirect()->route('billing.print', $billing->id)->with('message', 'Successfully Updated and ready to print');
        }

        return redirect()->route('billing.show', $billing->id)->with('message', 'Successfully updated');

    }

    public function print(Request $request)
    {
        // Fetch billing data with related patient and treatment details
        $billing_data = Bill::with(['treatment.patient', 'treatment.doctor'])->where('id', $request->id)->firstOrFail();

        // Hospital information
        $hospital_info = [
            'name' => 'Glow Up Skin Care & Cosmetics',
            'address' => 'Kottawa, Sri Lanka',
            'phone' => '070-3843481'
        ];

        // Prepare data for the view
        $data = [
            'hospital_info' => $hospital_info,
            'billing_data' => $billing_data,
            'billing_items' => $billing_data->BillItems,
            'date' => date('Y-m-d'),
            'patient' => $billing_data->treatment->patient,
            'treatment' => $billing_data->treatment,
            'doctor' => $billing_data->treatment->doctor,
            'title' => 'Billing Details',
        ];

        $billing_data->update([
            'print_status' => 1
        ]);

        // Load the view and generate PDF
        set_time_limit(1200); // Increase execution time limit
        $pdf = PDF::loadView('pdf', $data);
        $pdf->setPaper([0, 0, 340, 900], 'portrait');
        //$pdf->setPaper('A8', 'portrait');

        return $pdf->stream('billing_details.pdf');
    }

    public function emailBill(Request $request, $id)
    {
        $billing = Bill::with(['treatment.patient', 'treatment.doctor', 'BillItems'])->findOrFail($id);
        $result = $this->emailBillInternal($billing);
        if ($result !== true) {
            return redirect()->back()->with('danger', $result);
        }
        return redirect()->back()->with('message', 'Bill emailed to owner.');
    }

    private function emailBillInternal(Bill $billing): bool|string
    {
        $patient = $billing->treatment?->patient;

        if (!$patient || empty($patient->email)) {
            return 'Patient email is missing. Please add an email to send the bill.';
        }

        $hospital_info = [
            'name' => 'Glow Up Skin Care & Cosmetics',
            'address' => 'Kottawa, Sri Lanka',
            'phone' => '070-3843481'
        ];

        $data = [
            'hospital_info' => $hospital_info,
            'billing_data' => $billing,
            'billing_items' => $billing->BillItems,
            'date' => date('Y-m-d'),
            'patient' => $billing->treatment->patient,
            'treatment' => $billing->treatment,
            'doctor' => $billing->treatment->doctor,
            'title' => 'Billing Details',
        ];

        set_time_limit(1200);
        $pdf = PDF::loadView('pdf', $data);
        $pdf->setPaper([0, 0, 340, 900], 'portrait');
        $pdfContent = $pdf->output();

        try {
            Mail::to($patient->email)->send(new BillEmail($billing, $pdfContent));
        } catch (\Throwable $e) {
            return 'Failed to send email: ' . $e->getMessage();
        }

        return true;
    }

    public function printPrescription(Request $request)
    {
        // Fetch billing data with related patient and treatment details
        $billing_data = Bill::with(['treatment.patient', 'treatment.doctor', 'treatment.prescription'])->where('id', $request->id)->firstOrFail();
        $prescription_details = Prescription::where('trement_id', $billing_data->treatment_id)->get();
        // Hospital information
        $hospital_info = [
            'name' => 'Glow Up Skin Care & Cosmetics',
            'address' => 'Kottawa, Sri Lanka',
            'phone' => '070-3843481'
        ];

        // Prepare data for the view
        $data = [
            'hospital_info' => $hospital_info,
            'billing_data' => $billing_data,
            'billing_items' => $billing_data->BillItems,
            'date' => date('Y-m-d'),
            'patient' => $billing_data->treatment->patient,
            'treatment' => $billing_data->treatment,
            'prescription' => $prescription_details,
            'doctor' => $billing_data->treatment->doctor,
            'title' => 'Prescription Details'
        ];

        //dd($data);

        // Load the view and generate PDF
        set_time_limit(1200);
        $pdf = PDF::loadView('pdf_prescription', $data);
        $pdf->setPaper([0, 0, 640, 900], 'portrait');
        return $pdf->stream('pdf_prescription.pdf');
    }

    public function destroy($id)
    {
        // Find the bill by its ID
        $bill = Bill::findOrFail($id);

        // Restore stock levels before deletion
        $this->billingService->restoreStock($bill);

        // Update the deleted_by field for the bill
        $bill->update([
            'deleted_by' => Auth::user()->id,
        ]);

        // Soft delete related Treatment
        if ($bill->treatment) {
            $bill->treatment->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $bill->treatment->delete();
        }

        // Soft delete related BillItems
        foreach ($bill->billItems as $billItem) {
            $billItem->update([
                'deleted_by' => Auth::user()->id,
            ]);
            $billItem->delete();
        }



        // Soft delete the Bill itself
        $bill->delete();

        return redirect()->route('billing.index')->with('message', 'Bill deleted successfully');
    }



}
