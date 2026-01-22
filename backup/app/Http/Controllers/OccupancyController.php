<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\admission;
use App\Models\occupancy;
use Illuminate\Http\Request;
use App\DataTables\occupancyDataTable;

class OccupancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(occupancyDataTable $dataTable)
    {
        return $dataTable->render('occupancy.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $date = date('Y-m-d');
        $admssions = admission::WhereNull('date_of_check_out')->orderBy('room_id')->get();
        if ($request->date_occ) {
            $date = $request->date_occ;

            $admssions_ids = admission::select('id')->WhereDate('date_of_check_in', '<=', $date)
                ->where(function ($query) use ($date) {
                    $query->whereDate('date_of_check_out', '>', $date)
                        ->orWhereNull('date_of_check_out');
                })->groupBy('id')
                ->orderBy('room_id')->get();
                $admssions = admission::whereIn('id',$admssions_ids)->get();
        }

        $cbDay = Carbon::createFromFormat('Y-m-d', $date);
        $yesterday = $cbDay->subDay()->format('Y-m-d');

        foreach ($admssions as $key => $value) {
            $admssions[$key]['occ'] = occupancy::select('name')->where('date', $yesterday)->where('admission_id', '=', $value->id)->get()->pluck('name');
        }

        return view('occupancy.create', compact('admssions', 'date'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'date' => 'required|date|unique:occupancies,date,NULL,id,deleted_at,NULL',
                'room' => 'array'
            ],
            [
                'date.unique' => 'There\'s already a record for this date. Please edit the existing entry.',
            ]
        );

        $date = $request->date;
        $occupancy = array();
        foreach ($request->room as $room => $item) {
            $admission_id = $request->admission_id[$room];
            foreach ($item as $key => $value) {
                //    echo $key.'<br/>';
                //  print_r($value).'<br/>';
                //  print_r($item);
                if ($key == 'p')
                    $occupancy[] = array('room_id' => $room, 'admission_id' => $admission_id, 'type' => 'p', 'name' => $value, 'date' => $date);
                if ($key == 'f') {
                    $details = explode('|', $value);
                    $occupancy[] = array('room_id' => $room, 'admission_id' => $admission_id, 'type' => 'f', 'name' => $details[0], 'nic' => $details[1], 'phone' => $details[2], 'date' => $date);
                }
                if ($key == 'm') {
                    $details = explode('|', $value);
                    $occupancy[] = array('room_id' => $room, 'admission_id' => $admission_id, 'type' => 'm', 'name' => $details[0], 'nic' => $details[1], 'phone' => $details[2], 'date' => $date);
                }
                if ($key == 'g') {
                    $details = explode('|', $value);
                    $occupancy[] = array('room_id' => $room, 'admission_id' => $admission_id, 'type' => 'g', 'name' => $details[0], 'nic' => $details[1], 'phone' => $details[2], 'date' => $date);
                }
                if ($key == 'o') {
                    foreach ($value as $v) {
                        $details = explode('|', $v);
                        $occupancy[] = array('room_id' => $room, 'admission_id' => $admission_id, 'type' => 'o', 'name' => $details[0], 'nic' => $details[1], 'phone' => $details[2], 'date' => $date);
                    }
                }
            }
        }

        foreach ($occupancy as $occu) {
            occupancy::create($occu);
        }
        return redirect()->route('occupancy.index')->with('message', 'Updated');
    }

    /**
     * Display the specified resource.
     */
    public function show(occupancy $occupancy)
    {
        $occupancy = occupancy::where('date', $occupancy->date)->get();
        return view('occupancy.show', compact('occupancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(occupancy $occupancy)
    {
        $CurrentOccupancy = occupancy::select('room_id', 'type', 'date', 'id', 'admission_id')->where('date', $occupancy->date)->get();
        $admssions_ids = admission::select('id')->WhereDate('date_of_check_in', '<=', $occupancy->date)
            ->where(function ($query) use ($occupancy) {
                $query->whereDate('date_of_check_out', '>', $occupancy->date)
                    ->orWhereNull('date_of_check_out');
            })->groupBy('id')
            ->orderBy('room_id')->get();
            $admssions = admission::whereIn('id',$admssions_ids)->get();
          //  dd($admssions);
        foreach ($admssions as $key => $value) {
            $admssions[$key]['occ'] = occupancy::select('name')->where('date', $occupancy->date)->where('admission_id', '=', $value->id)->get()->pluck('name');
        }

       
        return view('occupancy.edit', compact('admssions', 'CurrentOccupancy'));

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, occupancy $occupancy)
    {
        $request->validate([
            'date' => 'required|date',
            'room' => 'array'
        ]);

        occupancy::whereDate('date', '=', $occupancy->date)->delete();

        $date = $request->date;
        $occupancy = array();
        foreach ($request->room as $room => $item) {
            $admission_id = $request->admission_id[$room];
            foreach ($item as $key => $value) {
                //    echo $key.'<br/>';
                //  print_r($value).'<br/>';
                //  print_r($item);
                if ($key == 'p')
                    $occupancy[] = array('room_id' => $room, 'admission_id' => $admission_id, 'type' => 'p', 'name' => $value, 'date' => $date);
                if ($key == 'f') {
                    $details = explode('|', $value);
                    $occupancy[] = array('room_id' => $room, 'admission_id' => $admission_id, 'type' => 'f', 'name' => $details[0], 'nic' => $details[1], 'phone' => $details[2], 'date' => $date);
                }
                if ($key == 'm') {
                    $details = explode('|', $value);
                    $occupancy[] = array('room_id' => $room, 'admission_id' => $admission_id, 'type' => 'm', 'name' => $details[0], 'nic' => $details[1], 'phone' => $details[2], 'date' => $date);
                }
                if ($key == 'g') {
                    $details = explode('|', $value);
                    $occupancy[] = array('room_id' => $room, 'admission_id' => $admission_id, 'type' => 'g', 'name' => $details[0], 'nic' => $details[1], 'phone' => $details[2], 'date' => $date);
                }
                if ($key == 'o') {
                    foreach ($value as $v) {
                        $details = explode('|', $v);
                        $occupancy[] = array('room_id' => $room, 'admission_id' => $admission_id, 'type' => 'o', 'name' => $details[0], 'nic' => $details[1], 'phone' => $details[2], 'date' => $date);
                    }
                }
            }
        }

        foreach ($occupancy as $occu) {
            occupancy::create($occu);
        }
        return redirect()->route('occupancy.index')->with('message', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(occupancy $occupancy)
    {
        occupancy::whereDate('date', '=', $occupancy->date)->delete();
        return redirect()->route('occupancy.index')->with('danger', 'Record deleted');
    }

}
