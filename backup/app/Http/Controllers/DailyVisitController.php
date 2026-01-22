<?php

namespace App\Http\Controllers;

use App\Models\admission;
use App\Models\dailyVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyVisitController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:daily-visit-list|daily-visit-create|daily-visit-edit|daily-visit-delete', ['only' => ['create']]);
         $this->middleware('permission:daily-visit-create|daily-visit-list', ['only' => ['create','store']]);
         $this->middleware('permission:daily-visit-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:daily-visit-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(admission $admission)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(admission $admission)
    { 
        return view('admition.daily-visit.create',compact('admission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(admission $admission, Request $request)
    {
        $request->validate([
            'visit_time'=>'required|date',
            'description'=>'required|min:2'
        ]);

        $admission->dailyvisit()->create([
            'user_id'=>Auth::user()->id,
            'visit_time'=>$request->visit_time,
            'description'=>$request->description
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(admission $admission, dailyVisit $daily_visit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(admission $admission, dailyVisit $daily_visit)
    {
        return view('admition.daily-visit.edit',compact('admission','daily_visit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(admission $admission,dailyVisit $daily_visit, Request $request )
    {
        $request->validate([
            'visit_time'=>'required|date',
            'description'=>'required|min:2'
        ]);

        $daily_visit->update([
            'user_id'=>Auth::user()->id,
            'visit_time'=>$request->visit_time,
            'description'=>$request->description
        ]);

        return redirect()->route('daily-visit.create',$admission->id)->with('message','Daily visit updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(admission $admission, dailyVisit $daily_visit)
    {
        
        $daily_visit->delete();
        return redirect()->route('daily-visit.create',$admission->id)->with('message','Daily visit deleted');
    }
}
