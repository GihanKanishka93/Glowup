<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Patient;
use App\Models\Admission;
use Illuminate\Support\Str;
use App\Models\Relationship;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\DataTables\admissionDataTable;
use Illuminate\Support\Facades\Storage;
use App\DataTables\admissionCheckOutDataTable;

class AdmissionController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:admission-list|admission-create|admission-edit|admission-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:admission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admission-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admission-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(admissionDataTable $datatable)
    {
        return $datatable->render("admition.index");
    }

    public function checkoutList(admissionCheckOutDataTable $datatable)
    {
        return $datatable->render("admition.past");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::whereNotIn('id', function ($query) {
            $query->select('room_id')
                ->from('admissions')
                ->whereNull('date_of_check_out');
        })
            ->whereNot('status', '30')
            ->get();


        $patients = Patient::whereNotIn('id', function ($query) {
            $query->select('patient_id')
                ->from('admissions')
                ->whereNull('date_of_check_out')
                ->whereNull('deleted_at');
        })->get();
        $relationships = Relationship::where('id', '>', 2)->get();

        $disreferred_ward = Admission::select('reffered_ward')->groupBy('reffered_ward')->orderBy('reffered_ward', 'asc')->get();
        $disreffered_counsultant = Admission::select('reffered_counsultant')->groupBy('reffered_counsultant')->orderBy('reffered_counsultant', 'asc')->get();

        //  $patients = Patient::all();
        return view("admition.create", compact("rooms", "patients", "relationships", "disreferred_ward", "disreffered_counsultant"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  dd($request->room_inventory);
        $this->validate(
            $request,
            [
                "patient" => "required|min:1",
                "type_of_service" => "required|min:0",
                "room" => "required|min:1",
                "agreement_file" => 'nullable|mimes:pdf|max:5120',
                "plan_to_check_out" => "required|after:now",
                'nic.*' => 'nullable|min:10|max:13',
                "reffered_ward" => "nullable|max:100",
                "reffered_counsultant" => "nullable|max:100",
                "treatment_history" => "nullable|array",
                "special_requirements" => "nullable|array",
                'parents' => 'required_without:name|array|min:1',
                'name' => 'required_without:parents|array|min:1',
                'name.*' => 'required_without:parents',
            ],
            [
                'parents.required' => 'Please select at least one parent (Father, Mother, or Guardian).',
                'name.required' => 'Please fill at least one person\'s name.',
                'name.*.required_without.parents' => 'Please fill at least one person\'s name.',
                'name.0.required_without' => 'Please select at least one parent (Father, Mother, Guardian or Other Name).',
            ]
        );

        $admissionDate = Carbon::parse($request->date_of_check_in); // Replace with the actual admission date
        $planned_checkoutDate = Carbon::parse($request->plan_to_check_out); // Replace with the actual checkout date

        $diffInDays = $admissionDate->diffInDays($planned_checkoutDate);

        $admission = Admission::create([
            'patient_id' => $request->patient,
            'type_of_service' => $request->type_of_service,
            'room_id' => $request->room,
            'date_of_check_in' => $request->date_of_check_in,
            'plan_to_check_out' => $request->plan_to_check_out,
            'created_by' => Auth::user()->id,
            'reffered_ward' => $request->reffered_ward,
            'reffered_counsultant' => $request->reffered_counsultant,
            'treatment_history' => json_encode($request->treatment_history),
            'special_requirements' => json_encode($request->special_requirements),
            'parents' => json_encode($request->parents),
            'number_of_days' => $diffInDays,
            'duration_of_stay' => $diffInDays

        ]);

        $admission->item()->attach($request->room_inventory);

        if ($request->hasFile('agreement_file')) {
            $pdfFile = $request->file('agreement_file');
            $fileName = Str::uuid() . '.' . $pdfFile->getClientOriginalExtension();
            $pdfFile->move(public_path('uploads'), $fileName);
            $filePath = 'uploads/' . $fileName;
            $admission->update(['agreement_file' => $filePath]);

        }

        $guestData = [];
        //  $patient = Patient::where('id',$request->patient)->first();



        foreach ($request->name as $key => $name) {
            if ($name != '') {
                $guestData[] = [
                    'name' => $name,
                    'nic' => $request->nic[$key],
                    'relationship_id' => 3,
                ];
            }
        }

        // Save guest details using createMany
        $admission->guests()->createMany($guestData);

        //update room availability
        $room = Room::find($request->room);
        $room->update(['status' => 20]);



        return redirect()->route('admission.index')
            ->withInput()
            ->with('message', 'New admission created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admission $admission)
    {
        return view('admition.show', compact('admission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admission $admission)
    {
        $rooms = Room::all();
        //  $patients = Patient::all();
        $relationships = Relationship::where('id', '>', 2)->get();

        $disreferred_ward = Admission::select('reffered_ward')->groupBy('reffered_ward')->orderBy('reffered_ward', 'asc')->get();
        $disreffered_counsultant = Admission::select('reffered_counsultant')->groupBy('reffered_counsultant')->orderBy('reffered_counsultant', 'asc')->get();

        return view('admition.edit', compact('admission', 'rooms', 'relationships', 'disreferred_ward', 'disreffered_counsultant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admission $admission)
    {
        $this->validate(
            $request,
            [
                //  "patient"=> "required|min:1",
                "room" => "required|min:1",
                "type_of_service" => "required|min:0",
                "agreement_file" => 'nullable|mimes:pdf|max:5120',
                "plan_to_check_out" => "required|date|after:" . $admission->date_of_check_in,
                'nic.*' => 'nullable|min:10|max:13',
                "reffered_ward" => "nullable|max:100",
                "reffered_counsultant" => "nullable|max:100",
                "treatment_history" => "nullable|array",
                "special_requirements" => "nullable|array",
                'parents' => 'required_without:name|array|min:1',
                'name' => 'required_without:parents|array|min:1',
                'name.*' => 'required_without:parents',

            ],
            [
                'parents.required' => 'Please select at least one parent (Father, Mother, or Guardian).',
                'name.required' => 'Please fill at least one person\'s name.',
                'name.*.required_without.parents' => 'Please fill at least one person\'s name.',
                'name.0.required_without' => 'Please select at least one parent (Father, Mother, Guardian or Other Name).',
            ]
        );

        $admission->update([
            'room_id' => $request->room,
            'type_of_service' => $request->type_of_service,
            'date_of_check_in' => $request->date_of_check_in,
            'plan_to_check_out' => $request->plan_to_check_out,
            'created_by' => null,
            'updated_by' => Auth::user()->id,
            'reffered_ward' => $request->reffered_ward,
            'reffered_counsultant' => $request->reffered_counsultant,
            'treatment_history' => json_encode($request->treatment_history),
            'special_requirements' => json_encode($request->special_requirements),
            'parents' => json_encode($request->parents)
        ]);

        $admission->item()->sync($request->room_inventory);

        if ($request->hasFile('agreement_file')) {
            $pdfFile = $request->file('agreement_file');
            $fileName = ($admission->agreement_file != '') ? explode('/', $admission->agreement_file)[1] :
                Str::uuid() . '.' . $pdfFile->getClientOriginalExtension();

            $pdfFile->move(public_path('uploads'), $fileName);
            $filePath = 'uploads/' . $fileName;
            $admission->update(['agreement_file' => $filePath]);

        }

        $guestData = $request->only(['name', 'nic', 'relationship']);
        foreach ($guestData['name'] as $key => $name) {
            if (!empty($name)) {
                $admission->guests()
                    ->updateOrCreate(
                        ['id' => $key], // If 'id' is the primary key of the Guest model
                        [
                            'name' => $name,
                            'nic' => $guestData['nic'][$key],
                            'relationship' => 3,
                        ]
                    );
            }

        }

        $room = Room::find($request->room);
        $room->update(['status' => 20]);

        return redirect()->route('admission.index')->with('message', 'New admission created');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admission $admission)
    {
        $admission->update([
            'deleted_by' => Auth::user()->id,
        ]);

        $admission->occupancy()->delete();

        //update room status
        $room = Room::find($admission->room_id);
        $room->update(['status' => 1]);

        if ($admission->agreement_file != '') {
            $fileToDelete = public_path($admission->agreement_file);
            if (file_exists($fileToDelete)) {
                unlink($fileToDelete);
            }
        }


        $admission->delete();
        //return redirect()->route('admission.index')->with('message', 'Admission deleted');
        return redirect()->back()->with('message', 'Admission deleted');
    }

    public function checkout(Request $request)
    {

        $request->validate([
            'remarks' => 'required|max:255',
            'dischargeDateTime' => 'required|date',
            'inventory_remarks' => 'nullable:max:255'
        ], [
            'remarks.required' => 'Please enter discharge note.',
            'remarks.max' => 'The discharge note must not exceed 255 characters.',
            'dischargeDateTime.required' => 'Please select discharge date and time.',
            'dischargeDateTime.date' => 'Invalid date format for discharge date and time.',
        ]);



        $admissionId = $request->input('admission_id');
        $admission = Admission::findOrFail($admissionId);
        $dischargeDateTime = $request->input('dischargeDateTime');

        //Update the number of stayed days basedon the actual dsicharge date
        $admission = Admission::find($admissionId);
        $admissionDate = Carbon::parse($admission->date_of_check_in); // Replace with the actual admission date
        $checkoutDate = Carbon::parse($dischargeDateTime); // Replace with the actual checkout date
        $diffInDays = $admissionDate->diffInDays($checkoutDate);

        $admission->update([
            'remarks' => $request->remarks,
            'date_of_check_out' => $dischargeDateTime,
            'updated_by' => Auth::user()->id,
            'created_by' => null,
            'number_of_days' => $diffInDays,
            'inventory_remarks' => $request->inventory_remarks
        ]);

        $admission->item()->updateExistingPivot($request->room_inventory, ['check_out' => 1]);

        $room = Room::find($admission->room_id);
        $room->update(['status' => 1]);
        return redirect()->route('admission.index')->with('message', 'Discharged Successfully');
    }

    public function getCheckoutInformation($id)
    {
        $admission = Admission::with('updatedBy')->find($id);
        if (!$admission) {
            return response()->json(['error' => 'Admission not found'], 404);
        }
        return response()->json($admission);
    }


    //  public function
    public function undoCheckout($admissionId)
    {
        $admission = Admission::find($admissionId);

        $room = Room::find($admission->room_id);

        if ($room->status == 20) {
            return redirect()->route('admission.checkout')->with('fail-message', 'This room is currently occupied !');
        }

        $admissionDate = Carbon::parse($admission->date_of_check_in); // Replace with the actual admission date
        $checkoutDate = Carbon::parse($admission->plan_to_check_out); // Replace with the actual checkout date
        $diffInDays = $admissionDate->diffInDays($checkoutDate);

        $admission->update([
            'date_of_check_out' => null,
            'updated_by' => Auth::user()->id,
            'number_of_days' => $diffInDays,
        ]);

        // $admission->item()->updateExistingPivot($request->room_inventory, ['check_out' => 1]);

        $room = Room::find($admission->room_id);
        $room->update(['status' => 0]);
        return redirect()->route('admission.checkout')->with('message', 'Undo Discharged Successfully');
    }

}
