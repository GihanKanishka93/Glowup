<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Treatment;
use App\Models\Bill;
use App\Models\Doctor;
use App\Models\Pet;
use App\Models\BillItem;
use App\Models\Prescription;
use App\Models\Drug;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\DataTables\billingDataTable;
use Illuminate\Support\Facades\Storage;
use App\Models\PetCategory;
use App\Models\PetBreed;
use PDF;  // Use this alias if configured in aliases array

class BillingController extends Controller
{
    // ...

    /**
     * Display a listing of the resource.
     */
    public function index(billingDataTable $datatable)
    {
        return $datatable->render("billing.index");
    }

    public function create()
    {
        $pets = Pet::all();
        $doctors = Doctor::all();
        $petcategory = PetCategory::all();
        $breed = PetBreed::all();
        $drugs = Drug::all();

        return view("billing.create", compact("pets", "doctors", "petcategory", "breed", "drugs"));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'billing_date' => 'required|date',
        ]);

        if ($request->pet == '' && $request->pet_name) {
            $maxId = Pet::max('id');
            $formattedId = str_pad(($maxId + 1), 4, '0', STR_PAD_LEFT);

            $pet_data = Pet::create([
                'pet_id' => $formattedId,
                'name' => $request->pet_name,
                'gender' => $request->gender,
                'age_at_register' => $request->age,
                'date_of_birth' => $request->date_of_birth,
                'weight' => $request->weight,
                'color' => $request->colour,
                'pet_category' => $request->pet_category,
                'pet_breed' => $request->breed,
                'remarks' => $request->remarks,
                'owner_name' => $request->owner_name,
                'owner_contact' => $request->owner_contact,
                'owner_address' => $request->address,
            ]);
            $request->pet = $pet_data->id;
        }

        $maxId = Bill::max('id');
        $formattedId = str_pad(($maxId + 1), 4, '0', STR_PAD_LEFT);

        $treatment = Treatment::create([
            'pet_id' => $request->pet,
            'doctor_id' => $request->doctor,
            'history_complaint' => $request->history,
            'clinical_observation' => $request->remarks_t,
            'remarks' => $request->remarks_t,
            'next_clinic_date' => $request->next_treatment_date,
        ]);

        $billing = Bill::create([
            'billing_id' => $formattedId,
            'treatment_id' => $treatment->id,
            'billing_date' => $request->billing_date,
            'total' => $request->net_total,
            'tax_amount' => $request->discount,
            'net_amount' => $request->grand_total,
        ]);


        foreach ($request->drug_name as $key => $drug_name) {
            if ($drug_name != '') {
                Prescription::create([
                    'trement_id' => $treatment->id,
                    'drug_name' => $request->drug_name[$key],
                    'dosage' => $request->dosage[$key],
                    'duration' => $request->duration[$key]
                ]);
            }
        }

        foreach ($request->service_name as $key => $service_name) {
            if ($service_name != '') {
                BillItem::create([
                    'bill_id' => $billing->id,
                    'billing_date' => $request->billing_date,
                    'item_name' => $request->service_name[$key],
                    'item_qty' => $request->billing_qty[$key],
                    'unit_price' => $request->unit_price[$key],
                    'tax' => $request->tax[$key],
                    'total_price' => $request->last_price[$key],
                ]);
            }
        }

        return redirect()->route('billing.index')->with('message', 'Successfully completed');
    }

    public function show(Bill $bill)
    {
        return view('billing.show', compact('bill'));
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

        $bill = Bill::findOrFail($bid);
        $treatment = Treatment::findOrFail($bill->treatment_id);
        $billItems = BillItem::where('bill_id', $bill->id)->get();
        $prescriptions = Prescription::where('trement_id', $bill->treatment_id)->get();
        //$pet = Pet::findOrFail($bill->pet_id);
        // echo "sadasd";
        // die;

        return view('billing.edit', compact("pets", "doctors", "petcategory", "breed", "bill", "treatment", "billItems", "prescriptions"));
    }
    public function update(Request $request)
    {

    }

    public function print(Request $request)
    {
        // Fetch billing data with related pet and treatment details
        $billing_data = Bill::with(['treatment.pet', 'treatment.doctor'])->where('id', $request->id)->firstOrFail();

        // Hospital information
        $hospital_info = [
            'name' => 'Challenger Vet Animal Hospital',
            'address' => 'Kottawa, Sri Lanka',
            'phone' => '011-2197400'
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
            'title' => 'Billing Details'
        ];

        // Load the view and generate PDF

        $pdf = PDF::loadView('pdf', $data);
        $pdf->setPaper([0, 0, 340, 600], 'portrait');
        return $pdf->stream('billing_details.pdf');
    }


    public function printPrescription(Request $request)
    {
        // Fetch billing data with related pet and treatment details
        $billing_data = Bill::with(['treatment.pet', 'treatment.doctor', 'treatment.prescription'])->where('id', $request->id)->firstOrFail();
        $prescription_details = Prescription::where('trement_id', $billing_data->treatment_id)->get();
        // Hospital information
        $hospital_info = [
            'name' => 'Challenger Vet Animal Hospital',
            'address' => 'Kottawa, Sri Lanka',
            'phone' => '011-2197400'
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

        $pdf = PDF::loadView('pdf_prescription', $data);
        $pdf->setPaper([0, 0, 340, 600], 'portrait');
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

        // Soft delete the Bill itself
        $bill->delete();

        return redirect()->route('billing.index')->with('message', 'Bill deleted successfully');
    }

}