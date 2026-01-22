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
use PDF;  // Use this alias if configured in aliases array

class QuickBillController extends Controller
{
    public function index(billingDataTable $datatable)
    {
        return $datatable->render("quickbill.index");
    }

    public function create()
    {
        $services = Services::all();
        $doctors = Doctor::all();

        return view("quickbill.create", compact("services", "doctors"));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'billing_date' => 'required|date',
        ]);

        $maxId = Bill::max('id');
        $formattedId = str_pad(($maxId + 1), 4, '0', STR_PAD_LEFT);

        $billing = Bill::create([
            'billing_id' => $formattedId,
            'treatment_id' => 1,
            'billing_date' => $request->billing_date,
            'net_amount' => $request->net_total,
            'discount' => $request->discount,
            'total' => $request->grand_total,
            'bill_status' => 1,
            'bill_type' => 2,
        ]);

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

        $doctors = Doctor::all();

        $services = Services::all();

        $bill = Bill::findOrFail($bill_id);

        $billItems = BillItem::where('bill_id', $bill->id)->get();


        return view('quickbill.show', compact("doctors", "services", "bill", "billItems"));
    }
}