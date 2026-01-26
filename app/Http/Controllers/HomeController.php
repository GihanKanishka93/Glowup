<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Room;
use App\Models\Services;

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
        if (Auth::user()->hasRole('Cashier')) {
            return redirect()->to('billing');
        } else {
            $floor = [];
            $lowStockItems = [];
            $date = $request->date ?? now()->toDateString();

            try {
                if (Schema::hasTable('rooms')) {
                    $floor = Room::all();
                }
                if (Schema::hasTable('services')) {
                    $lowStockItems = Services::whereColumn('stock_quantity', '<=', 'min_stock_level')
                        ->where('min_stock_level', '>', 0)
                        ->get();
                }
            } catch (\Exception $e) {
                // Handle case where database isn't fully migrated yet
            }

            return view('home', compact('floor', 'date', 'lowStockItems'));
        }

        //     $floor = floor::where('id', '>', 1)->orderBy('number')->get();
        //     $date = [];
        //     $latestOccupancy = occupancy::latest()->first();
        //     if ($latestOccupancy) {
        //         $date = $latestOccupancy->date;
        //     } else {
        //         // Handle the case when no records are found
        //         $date = null; // Or set a default value
        //     }

        //     $date = $request->date ?? now()->toDateString();
        //     //get previos day
        //     $cbDay = Carbon::createFromFormat('Y-m-d', $date);
        //     $yesterday = $cbDay->subDay()->format('Y-m-d');
        //     //   echo $date.' '.$yesterday;
        //     //get previos day used room list
        //     $previos = occupancy::select('admission_id')
        //         ->where('date', '=', $yesterday)
        //         ->groupBy('admission_id')->get()->pluck('admission_id')
        //         ->toArray();

        //     $currentDay = occupancy::select('admission_id')
        //         ->where('date', '=', $date)
        //         ->groupBy('admission_id')->get()->pluck('admission_id')
        //         ->toArray();
        //     $YesterdayOccupancy = count($previos);
        //   $discharge =  admission::whereDate('date_of_check_out', '=',  $date)->count();
        //   $newAdmission =  admission::whereDate('date_of_check_in','=',$date)->count();
        //  //   $discharge = count(array_diff($previos, $currentDay));
        //  //   $newAdmission = count(array_diff($currentDay, $previos));


        //     $dates = occupancy::select('date')->groupBy('date')->get();
        //     return view('home', compact('floor', 'date', 'dates', 'discharge', 'newAdmission', 'YesterdayOccupancy', 'yesterday'));
    }



}