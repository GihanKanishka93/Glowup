<?php

namespace App\Http\Controllers;

use Carbon\Carbon; 
use App\Models\floor; 
use App\Models\admission;
use App\Models\occupancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(request $request)
    {
        $floor = floor::where('id', '>', 1)->orderBy('number')->get();
        $date = [];
        $latestOccupancy = occupancy::latest()->first();
        if ($latestOccupancy) {
            $date = $latestOccupancy->date;
        } else {
            // Handle the case when no records are found
            $date = null; // Or set a default value
        }

        $date = $request->date ?? now()->toDateString();
        //get previos day
        $cbDay = Carbon::createFromFormat('Y-m-d', $date);
        $yesterday = $cbDay->subDay()->format('Y-m-d');
        //   echo $date.' '.$yesterday;
        //get previos day used room list
        $previos = occupancy::select('admission_id')
            ->where('date', '=', $yesterday)
            ->groupBy('admission_id')->get()->pluck('admission_id')
            ->toArray();

        $currentDay = occupancy::select('admission_id')
            ->where('date', '=', $date)
            ->groupBy('admission_id')->get()->pluck('admission_id')
            ->toArray();
        $YesterdayOccupancy = count($previos);
      $discharge =  admission::whereDate('date_of_check_out', '=',  $date)->count();
      $newAdmission =  admission::whereDate('date_of_check_in','=',$date)->count();
     //   $discharge = count(array_diff($previos, $currentDay));
     //   $newAdmission = count(array_diff($currentDay, $previos));  


        $dates = occupancy::select('date')->groupBy('date')->get();
        return view('home', compact('floor', 'date', 'dates', 'discharge', 'newAdmission', 'YesterdayOccupancy', 'yesterday'));
    }


    public function print(request $request)
    {
        $floor = floor::where('id', '>', 1)->orderBy('number')->get();
        $date = occupancy::latest()->first()->date;
        if ($request->date)
            $date = $request->date;
      //  $dates = occupancy::select('date')->groupBy('date')->get();
        $title = 'Daily Room Occupancy Report';


        $cbDay = Carbon::createFromFormat('Y-m-d', $date);
        $yesterday = $cbDay->subDay()->format('Y-m-d');
        //   echo $date.' '.$yesterday;
        //get previos day used room list
        $previos = occupancy::select('admission_id')
            ->where('date', '=', $yesterday)
            ->groupBy('admission_id')->get()->pluck('admission_id')
            ->toArray();

        $currentDay = occupancy::select('admission_id')
            ->where('date', '=', $date)
            ->groupBy('admission_id')->get()->pluck('admission_id')
            ->toArray();
        $YesterdayOccupancy = count($previos);
        //$discharge = count(array_diff($previos, $currentDay));
        // get diacharge form admission table
        $discharge =  admission::whereDate('date_of_check_out',$date)->count();
        $newAdmission =  admission::whereDate('date_of_check_in',$date)->count();
     //   $newAdmission = count(array_diff($currentDay, $previos));


        $data = [
            'date' => $date, 
            'floor' => $floor,
            'title'=>$title,
            'YesterdayOccupancy'=>$YesterdayOccupancy,
            'newAdmission'=>$newAdmission,
            'discharge'=>$discharge
        ];
        

        
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadView('pdf', $data);
        return $pdf->inline();

        //return $pdf->download($title.' at '.$date.'.pdf');
    }
}
