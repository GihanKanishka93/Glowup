<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\UpdateBillRequest;
use App\Models\Treatment;
use App\Models\Bill;
use App\Models\Doctor;
use App\Models\Pet;
use App\Models\BillItem;
use App\Models\Prescription;
use App\Models\VaccinationInfo;
use App\Models\Drug;
use App\Models\Vaccination;
use App\Models\Services;
use App\Models\DosageTypes;
use App\Models\DurationTypes;
use App\Models\DurationWeeks;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\DataTables\billingDataTable;
use Illuminate\Support\Facades\Storage;
use App\Models\PetCategory;
use App\Models\PetBreed;
use App\Models\Dose;
use App\Services\BillingService;
use App\Mail\NextClinicReminderMail;
use App\Mail\VaccinationReminderMail;
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

            $queueBills = Bill::with(['treatment.pet', 'treatment.doctor'])
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
        $pets = Pet::all();
        $doctors = Doctor::all();
        $petcategory = PetCategory::all();
        $breed = PetBreed::all();
        $drugs = Drug::all();
        $vaccine = Vaccination::all();
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

        $visitQueue = Treatment::with(['pet', 'doctor'])
            ->whereDate('treatment_date', $today)
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        $upcomingVaccinations = VaccinationInfo::with(['treatment.pet', 'vaccine'])
            ->whereNull('vaccination_infos.deleted_at')
            ->whereNotNull('next_vacc_date')
            ->whereBetween('next_vacc_date', [$today, (clone $today)->addDays(7)])
            ->whereHas('treatment', function ($query) {
                $query->whereNull('deleted_at')
                    ->whereHas('bill', function ($billQuery) {
                        $billQuery->whereNull('deleted_at');
                    })
                    ->whereHas('pet', function ($petQuery) {
                        $petQuery->whereNull('deleted_at');
                    });
            })
            ->orderBy('next_vacc_date')
            ->take(6)
            ->get();

        $recentBills = Bill::with(['treatment.pet'])
            ->latest('billing_date')
            ->take(5)
            ->get();

        return view(
            "billing.create",
            compact(
                "pets",
                "doctors",
                "petcategory",
                "breed",
                "drugs",
                "vaccine",
                "services",
                "dosagetypes",
                "durationtypes",
                "dose",
                "durationweeks",
                "metrics",
                "visitQueue",
                "upcomingVaccinations",
                "recentBills"
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
        $pet = $treatment?->pet;
        if (!$treatment || !$pet || empty($pet->owner_email)) {
            return;
        }

        $ownerEmail = $pet->owner_email;

        // Next clinic immediate email
        if (!empty($treatment->next_clinic_date)) {
            try {
                Mail::to($ownerEmail)->send(new NextClinicReminderMail($pet, $treatment));
                ReminderLog::create([
                    'reminder_type' => 'next_clinic',
                    'pet_id' => $pet->id,
                    'treatment_id' => $treatment->id,
                    'owner_email' => $ownerEmail,
                    'status' => 'sent',
                    'sent_at' => Carbon::now(),
                ]);
            } catch (\Throwable $e) {
                ReminderLog::create([
                    'reminder_type' => 'next_clinic',
                    'pet_id' => $pet->id,
                    'treatment_id' => $treatment->id,
                    'owner_email' => $ownerEmail,
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'sent_at' => Carbon::now(),
                ]);
            }
        }

        // Vaccination immediate emails (one per vaccination entry with next date)
        $vaccinations = $treatment->vaccinations ?? collect();
        foreach ($vaccinations as $vaccination) {
            if (empty($vaccination->next_vacc_date)) {
                continue;
            }
            try {
                Mail::to($ownerEmail)->send(new VaccinationReminderMail($pet, $vaccination));
                ReminderLog::create([
                    'reminder_type' => 'vaccination',
                    'pet_id' => $pet->id,
                    'treatment_id' => $treatment->id,
                    'vaccination_info_id' => $vaccination->id,
                    'owner_email' => $ownerEmail,
                    'status' => 'sent',
                    'sent_at' => Carbon::now(),
                ]);
            } catch (\Throwable $e) {
                ReminderLog::create([
                    'reminder_type' => 'vaccination',
                    'pet_id' => $pet->id,
                    'treatment_id' => $treatment->id,
                    'vaccination_info_id' => $vaccination->id,
                    'owner_email' => $ownerEmail,
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'sent_at' => Carbon::now(),
                ]);
            }
        }
    }

    /**
     * Persist pet/owner updates from the billing form without leaving the page.
     */
    public function savePetDetails(Request $request)
    {
        $validated = $request->validate([
            'pet' => ['required', 'integer', 'exists:pets,id'],
            'pet_id' => ['nullable', 'string', 'max:255'],
            'pet_name' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'integer'],
            'age' => ['nullable', 'integer'],
            'date_of_birth' => ['nullable', 'date'],
            'weight' => ['nullable', 'numeric'],
            'colour' => ['nullable', 'string', 'max:255'],
            'pet_category' => ['nullable', 'integer', 'exists:pet_categories,id'],
            'breed' => ['nullable', 'integer', 'exists:pet_breeds,id'],
            'remarks' => ['nullable', 'string'],
            'owner_name' => ['nullable', 'string', 'max:255'],
            'owner_contact' => ['nullable', 'string', 'max:25'],
            'owner_whatsapp' => ['nullable', 'string', 'max:25'],
            'address' => ['nullable', 'string'],
        ]);

        $pet = Pet::findOrFail($validated['pet']);

        $payload = [
            'pet_id' => $validated['pet_id'] ?? $pet->pet_id,
            'name' => $validated['pet_name'] ?? $pet->name,
            'gender' => $validated['gender'] ?? $pet->gender,
            'age_at_register' => $validated['age'] ?? $pet->age_at_register,
            'date_of_birth' => $validated['date_of_birth'] ?? $pet->date_of_birth,
            'weight' => $validated['weight'] ?? $pet->weight,
            'color' => $validated['colour'] ?? $pet->color,
            'pet_category' => $validated['pet_category'] ?? $pet->pet_category,
            'pet_breed' => $validated['breed'] ?? $pet->pet_breed,
            'remarks' => $validated['remarks'] ?? $pet->remarks,
            'owner_name' => $validated['owner_name'] ?? $pet->owner_name,
            'owner_contact' => $validated['owner_contact'] ?? $pet->owner_contact,
            'owner_whatsapp' => $validated['owner_whatsapp'] ?? $pet->owner_whatsapp,
            'owner_address' => $validated['address'] ?? $pet->owner_address,
        ];

        $filtered = array_filter(
            $payload,
            fn ($value) => $value !== null && $value !== ''
        );

        $pet->fill($filtered);

        if ($pet->isDirty()) {
            $pet->save();
        }

        return response()->json([
            'message' => 'Pet details saved',
            'pet' => $pet->fresh(),
        ]);
    }

    public function show($bill_id)
    {
        $pets = Pet::all();
        $doctors = Doctor::all();
        $petcategory = PetCategory::all();
        $breed = PetBreed::all();
        $drugs = Drug::all();
        $vaccine = Vaccination::all();
        $services = Services::all();
        $dosagetypes = DosageTypes::all();
        $durationtypes = DurationTypes::all();
        $durationweeks = DurationWeeks::all();

        $bill = Bill::findOrFail($bill_id);
        $treatment = Treatment::findOrFail($bill->treatment_id);
        $billItems = BillItem::where('bill_id', $bill->id)->get();
        $prescriptions = Prescription::where('trement_id', $bill->treatment_id)->get();
        $vaccinationInfo = VaccinationInfo::where('trement_id', $bill->treatment_id)->get();
        //$pet = Pet::findOrFail($bill->pet_id);


        return view('billing.show', compact("pets", "doctors", "petcategory", "breed", "drugs", "vaccine", "services", "dosagetypes", "durationtypes", "durationweeks", "bill", "treatment", "billItems", "prescriptions", "vaccinationInfo"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($bid)
    {
        $pets = Pet::all();
        $doctors = Doctor::all();
        $petcategory = PetCategory::all();
        $breed = PetBreed::all();
        $drugs = Drug::all();

        $services = Services::all();
        $dosagetypes = DosageTypes::all();
        $dose = Dose::all();
        $durationtypes = DurationTypes::all();
        $durationweeks = DurationWeeks::all();

        $bill = Bill::findOrFail($bid);
        $treatment = Treatment::findOrFail($bill->treatment_id);
        $billItems = BillItem::where('bill_id', $bill->id)->get();
        $pet_category_value = empty($treatment->pet->pet_category) ? 20 : $treatment->pet->pet_category;


        if ($pet_category_value != 20) {
            $vaccine = Vaccination::whereJsonContains('pet_category', (string) $pet_category_value)->get();
        } else {
            $vaccine = Vaccination::all();
        }

        // echo $treatment->pet->pet_category;
        // dd($vaccine);
        $prescriptions = Prescription::where('trement_id', $bill->treatment_id)->get();
        $vaccinationInfo = VaccinationInfo::where('trement_id', $bill->treatment_id)->get();
        //$pet = Pet::findOrFail($bill->pet_id);
        // echo "sadasd";
        // die;

        return view('billing.edit', compact("pets", "doctors", "petcategory", "breed", "drugs", "vaccine", "services", "dosagetypes", "durationweeks", "durationtypes", "dose", "bill", "treatment", "billItems", "prescriptions", "vaccinationInfo"));
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
        // Fetch billing data with related pet and treatment details
        $billing_data = Bill::with(['treatment.pet', 'treatment.doctor'])->where('id', $request->id)->firstOrFail();

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
            'pet' => $billing_data->treatment->pet,
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
        $billing = Bill::with(['treatment.pet', 'treatment.doctor', 'BillItems'])->findOrFail($id);
        $result = $this->emailBillInternal($billing);
        if ($result !== true) {
            return redirect()->back()->with('danger', $result);
        }
        return redirect()->back()->with('message', 'Bill emailed to owner.');
    }

    private function emailBillInternal(Bill $billing): bool|string
    {
        $pet = $billing->treatment?->pet;

        if (!$pet || empty($pet->owner_email)) {
            return 'Owner email is missing. Please add an email to send the bill.';
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
            'pet' => $billing->treatment->pet,
            'treatment' => $billing->treatment,
            'doctor' => $billing->treatment->doctor,
            'title' => 'Billing Details',
        ];

        set_time_limit(1200);
        $pdf = PDF::loadView('pdf', $data);
        $pdf->setPaper([0, 0, 340, 900], 'portrait');
        $pdfContent = $pdf->output();

        try {
            Mail::to($pet->owner_email)->send(new BillEmail($billing, $pdfContent));
        } catch (\Throwable $e) {
            return 'Failed to send email: ' . $e->getMessage();
        }

        return true;
    }

    public function printPrescription(Request $request)
    {
        // Fetch billing data with related pet and treatment details
        $billing_data = Bill::with(['treatment.pet', 'treatment.doctor', 'treatment.prescription'])->where('id', $request->id)->firstOrFail();
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
            'pet' => $billing_data->treatment->pet,
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

        VaccinationInfo::where('trement_id', $bill->treatment_id)->delete();

        // Soft delete the Bill itself
        $bill->delete();

        return redirect()->route('billing.index')->with('message', 'Bill deleted successfully');
    }



}
