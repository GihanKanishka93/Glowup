<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\DataTables\billingDataTable;
use Illuminate\Support\Facades\Storage;
use App\Models\PetCategory;
use App\Models\PetBreed;
use App\Models\Dose;
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
        $vaccine = Vaccination::all();
        $services = Services::all();
        $dosagetypes = DosageTypes::all();
        $dose = Dose::all();
        $durationtypes = DurationTypes::all();


        return view("billing.create", compact("pets", "doctors", "petcategory", "breed", "drugs", "vaccine", "services", "dosagetypes", "durationtypes", "dose"));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'billing_date' => 'required|date',
            'doctor' => 'required',
            'pet_name' => 'required',
        ]);



        if ($request->pet == '' && $request->pet_name) {
            $maxId = Pet::max('id');
            // $formattedId = str_pad(($maxId + 1), 4, '0', STR_PAD_LEFT);
            $formattedId = 'CV' . str_pad(($maxId + 1), 4, '0', STR_PAD_LEFT);

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
                'owner_whatsapp' => $request->owner_whatsapp,
                'owner_address' => $request->address,
            ]);
            $request->pet = $pet_data->id;
        }


        $currentDateForQuery = date('Y-m-d');
        $currentDateFormatted = date('ymd');
        $maxId = Bill::whereDate('created_at', $currentDateForQuery)->count();
        $formattedId = $currentDateFormatted . str_pad(($maxId + 1), 3, '0', STR_PAD_LEFT);


        $treatment = Treatment::create([
            'pet_id' => $request->pet,
            'doctor_id' => $request->doctor,
            'history_complaint' => $request->history,
            'treatment_date' => $request->billing_date,
            'clinical_observation' => $request->remarks_t,
            'remarks' => $request->remarks_t,
            'next_clinic_date' => $request->next_treatment_date,

        ]);

        $billing = Bill::create([
            'billing_id' => $formattedId,
            'treatment_id' => $treatment->id,
            'billing_date' => $request->billing_date,
            'net_amount' => $request->net_total,
            'discount' => $request->discount,
            'total' => $request->grand_total,
            'bill_status' => 1,
            'bill_type' => 1,
        ]);


        foreach ($request->drug_name as $key => $drug_name) {
            if ($drug_name != '') {
                Prescription::create([
                    'trement_id' => $treatment->id,
                    'drug_name' => $request->drug_name[$key],
                    'dosage' => $request->dosage[$key],
                    'dose' => $request->dose[$key],
                    'duration' => $request->duration[$key]
                ]);
            }
        }

        foreach ($request->vaccine_name as $key => $vacc_name) {
            if ($vacc_name != '') {
                VaccinationInfo::create([
                    'trement_id' => $treatment->id,
                    'vaccine_id' => $request->vaccine_name[$key],
                    'next_vacc_date' => $request->vacc_duration[$key]
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

        if ($request->input('action') === 'save_and_print') {
            // Save and print logic
            // You can return a view or redirect to a route that handles the printing
            return redirect()->route('billing.print', $billing->id)->with('message', 'Successfully saved and ready to print');
        } else {
            // Just save logic
            return redirect()->route('billing.show', $billing->id)->with('message', 'Successfully completed');
        }

        // return redirect()->route('billing.index')->with('message', 'Successfully completed');
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

        $bill = Bill::findOrFail($bill_id);
        $treatment = Treatment::findOrFail($bill->treatment_id);
        $billItems = BillItem::where('bill_id', $bill->id)->get();
        $prescriptions = Prescription::where('trement_id', $bill->treatment_id)->get();
        $vaccinationInfo = VaccinationInfo::where('trement_id', $bill->treatment_id)->get();
        //$pet = Pet::findOrFail($bill->pet_id);


        return view('billing.show', compact("pets", "doctors", "petcategory", "breed", "drugs", "vaccine", "services", "dosagetypes", "durationtypes", "bill", "treatment", "billItems", "prescriptions", "vaccinationInfo"));
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

        return view('billing.edit', compact("pets", "doctors", "petcategory", "breed", "drugs", "vaccine", "services", "dosagetypes", "durationtypes", "dose", "bill", "treatment", "billItems", "prescriptions", "vaccinationInfo"));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'billing_date' => 'required|date',
            'doctor' => 'required',
        ]);

        $billing = Bill::findOrFail($id);
        $treatment = Treatment::findOrFail($billing->treatment_id);
        $pet = Pet::findOrFail($request->pet);

        $billing->update([
            'billing_date' => $request->billing_date,
            'net_amount' => $request->net_total,
            'discount' => $request->discount,
            'total' => $request->grand_total,
        ]);


        if ($request->pet_name) {

            $pet->update([
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
                'owner_whatsapp' => $request->owner_whatsapp,
                'owner_address' => $request->address,
            ]);

        }

        $treatment->update([
            'pet_id' => $request->pet,
            'doctor_id' => $request->doctor,
            'history_complaint' => $request->history,
            'treatment_date' => $request->billing_date,
            'clinical_observation' => $request->remarks_t,
            'remarks' => $request->remarks_t,
            'next_clinic_date' => $request->next_treatment_date,
        ]);

        // Update Prescriptions
        Prescription::where('trement_id', $treatment->id)->delete();
        foreach ($request->drug_name as $key => $drug_name) {
            if ($drug_name != '') {
                Prescription::create([
                    'trement_id' => $treatment->id,
                    'drug_name' => $request->drug_name[$key],
                    'dosage' => $request->dosage[$key],
                    'dose' => $request->dose[$key],
                    'duration' => $request->duration[$key]
                ]);
            }
        }

        // Update Vaccinations
        VaccinationInfo::where('trement_id', $treatment->id)->delete();
        foreach ($request->vaccine_name as $key => $vacc_name) {
            if ($vacc_name != '') {
                VaccinationInfo::create([
                    'trement_id' => $treatment->id,
                    'vaccine_id' => $request->vaccine_name[$key],
                    'next_vacc_date' => $request->vacc_duration[$key]
                ]);
            }
        }


        // Update Bill Items
        BillItem::where('bill_id', $billing->id)->delete();
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




        if ($request->input('action') === 'update_and_print') {
            return redirect()->route('billing.print', $billing->id)->with('message', 'Successfully Updated and ready to print');
        } else {
            return redirect()->route('billing.show', $billing->id)->with('message', 'Successfully updated');
        }

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

        // Soft delete the Bill itself
        $bill->delete();

        return redirect()->route('billing.index')->with('message', 'Bill deleted successfully');
    }



}
