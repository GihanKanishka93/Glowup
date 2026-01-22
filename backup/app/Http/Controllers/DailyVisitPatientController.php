<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admission;
use App\Models\patient;
use App\Models\PatientDailyVisit;
use Illuminate\Support\Facades\Auth;
class DailyVisitPatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(patient $patient,PatientDailyVisit $PatientDailyVisit){ 
      
    return view ('patients.daily-visit.create',compact('patient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(patient $patient, Request $request)
    {
        $request->validate([
          
            'remark' => 'nullable|string',
            'visit_time' => 'required|date', 
            'description' => 'required|string|min:2',
        ]);
        $patient->dailyVisitPatient()->create([
            'user_id'=>Auth::user()->id,
          
            'remark' => $request->remark,
            'visit_time' => $request->visit_time,
            'description' => $request->description,
        ]) ;
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(patient $patient, PatientDailyVisit $visit)
    { 
       
       return view('patients.daily-visit.edit',compact('patient','visit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(patient $patient, Request $request ,$visit)
    {
    
        $visit = PatientDailyVisit::find($visit);
       $visit->update([
            'user_id'=>Auth::user()->id,
          
            'remark' => $request->remark,
            'visit_time' => $request->visit_time,
            'description' => $request->description,
        ]) ;
        return redirect()->route('visit.create', $patient->id)->with('message','Counslor Note updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(patient $patient, PatientDailyVisit $visit)
    {
       

        $visit->delete();

        return redirect()->route('visit.create',$patient->id)->with('message','Counslor Note  deleted');
    }

    public function getVisitDetails($visitId)
{
   
    $visit = PatientDailyVisit::find($visitId);
    
    if (!$visit) {
        return response()->json(['error' => 'Visit not found'], 404);
    }
    //$formattedDate =  \Carbon\Carbon::parse($visit->visit_time)->format('Y-m-d');
    return response()->json([
        'date' =>  $visit->visit_time,
        'description' => $visit->description,
        'family_history' => $visit->family_history,
        'economic_status' => $visit->economic_status,
        'social_history' => $visit->social_history,
        'remark' => $visit->remark,
    ]);
}
}
