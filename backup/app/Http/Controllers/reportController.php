<?php

namespace App\Http\Controllers;


use App\Models\room;
use App\Models\patient;
use App\Models\district;
use App\Models\province;
use App\Models\admission;
use App\Models\occupancy;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\DataTables\districtWiseDataTable;
use App\DataTables\provinceWiseDataTable;
use App\DataTables\servedPeriodDataTable;
use App\DataTables\monthlyReportDataTable;
use App\DataTables\upcomingDischargesDataTable;

class reportController extends Controller
{
    public function age_group()
    {
        $patients = patient::select('age_at_register', DB::raw('count(*) as count'))
            ->groupBy('age_at_register')
            ->orderBy('age_at_register', 'asc') // Sorting in ascending order
            ->get();
        return view('reports.age-wise', compact('patients'));
    }

    public function districtWise(districtWiseDataTable $dataTable)
    {
        $searchValue = 'colombo';
        return $dataTable->with(['defaultSearch' => $searchValue])->render('reports.district-wise');
    }

    public function provinceWise(provinceWiseDataTable $dataTable)
    {
        // $province = province::all();
        //return view('reports.province-wise',compact('province'));
        $searchValue = 'colombo';
        return $dataTable->with(['defaultSearch' => $searchValue])->render('reports.province-wise');
    }

    public function servedPeriodes(Request $request)
    {
        $province = province::all();
        $patients = patient::all();
        $district = district::all();
        $room = room::all();
        return view('reports.served', compact('patients', 'province', 'district', 'room'));
    }

    // public function servedPeriodesReport(Request $request){
    //     dd($request);
    //     $request->validate(
    //         [
    //             'from_date'=>'required|date',
    //             'to_date'=>'required|date'
    //         ]
    //         );

    //        $admission = admission::whereBetween('created_at', [$request->from_date, $request->to_date])
    //         ->where('another_column', '=', 'some_value')
    //         ->get();
    //     return view('reports.served-periodes');
    // }

    public function servedPeriodesReport(Request $request, servedPeriodDataTable $dataTable)
    {

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => [
                'required',
                'date',
                Rule::requiredIf($request->has('start_date')), // Require end date if start date is provided
                'after_or_equal:start_date', // Validate that end date is greater than or equal to start date
            ],
        ]);

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $patient = ($request->patient_id) ? patient::where('id', $request->patient_id)->first()->name : '';
        $room = ($request->room_id) ? room::where('id', $request->room_id)->first()->room_number : '';
        $district = ($request->district_id) ? district::where('id', $request->district_id)->first()->name_en : '';

        return $dataTable->with([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'patient_id' => $request->patient_id,
            'room_id' => $request->room_id,
            'district_id' => $request->district_id
        ])->render(
                'reports.index',
                compact(
                    'start_date',
                    'end_date',
                    'patient',
                    'room',
                    'district'
                )
            );

    }

    public function serve(request $request, servedPeriodDataTable $dataTable)
    {
        $from = $request->from;
        $to = $request->to;
        return $dataTable->render('reports.index');
    }

    public function upcomingDischarges(upcomingDischargesDataTable $dataTable)
    {
        $day_count = 3;
        $forward_day_count = $day_count + 1;
        $from_date = date('Y-m-d');
        //$toDate = date('Y-m-d', strtotime('+1 day'));
        $toDate = date('Y-m-d', strtotime("+$forward_day_count days"));
        $dis_toDate = date('Y-m-d', strtotime("+$day_count days"));

        return $dataTable->with(['from_date' => $from_date, 'to_date' => $toDate])->render(
            'reports.upcoming-discharges',
            compact(
                'from_date',
                'dis_toDate',
                'day_count'
            )
        );

    }

    public function upcomingDischargesReport(Request $request, upcomingDischargesDataTable $dataTable)
    {
        $this->validate(
            $request,
            [
                'backward_day_count' => 'required|numeric|min:1|max:99',
            ]
        );

        $backward_day_count = $request->query('backward_day_count', 3);

        $day_count = $backward_day_count;
        $forward_day_count = $day_count + 1;
        $from_date = date('Y-m-d');
        //$toDate = date('Y-m-d', strtotime('+1 day'));
        $toDate = date('Y-m-d', strtotime("+$forward_day_count days"));
        $dis_toDate = date('Y-m-d', strtotime("+$day_count days"));

        return $dataTable->with(['from_date' => $from_date, 'to_date' => $toDate])->render(
            'reports.upcoming-discharges',
            compact(
                'from_date',
                'dis_toDate',
                'day_count'
            )
        );
    }

    public function districtAdmissionsReport()
    {
        $to_date = Carbon::now()->format('Y-m-d');
        $from_date = Carbon::now()->subMonth()->format('Y-m-d');
        $report_type = 'p';
        $district = district::all();
        $admissions = admission::where('date_of_check_in', '>=', $from_date)
            ->where('date_of_check_in', '<=', Carbon::parse($to_date)->addDay())->get();
        $result = array();
        foreach ($admissions as $item) {

            if (isset($result[$item->patient->address->district_id])) {
                $result[$item->patient->address->district_id] += 1;
            } else {
                $result[$item->patient->address->district_id] = 1;
            }

        }

        $search_data = (object) [
            'start_date' => $from_date,
            'end_date' => $to_date,
            'report_type' => $report_type,
        ];

        return view('reports.district-admissions', compact('district', 'result', 'search_data'));

    }

    public function districtAdmissionsSearchReport(Request $request)
    {

        $to_date = $request->end_date;
        $from_date = $request->start_date;
        $district = district::all();
        // $admissions = admission::where('date_of_check_in', '>=', $from_date)
        //     ->where('date_of_check_in', '<=', Carbon::parse($to_date)->addDay())->get();


        $result = array();
        if ($request->rpt_type === 'a') {
            $admissions = admission::select('patient_id')
                ->where('date_of_check_in', '>=', $from_date)
                ->where('date_of_check_in', '<=', Carbon::parse($to_date)->addDay())
                ->get();

            foreach ($admissions as $item) {

                if (isset($result[$item->patient->address->district_id])) {
                    $result[$item->patient->address->district_id] += 1;
                    // $result[$item->patient->address->district_id] += (count(json_decode($item->parents)) + count($item->guests));
                } else {
                    $result[$item->patient->address->district_id] = 1;
                    // $result[$item->patient->address->district_id] = (count(json_decode($item->parents)) + count($item->guests));
                }


            }
        } else {
            $admissions = admission::select('patient_id')
                ->where('date_of_check_in', '>=', $from_date)
                ->where('date_of_check_in', '<=', Carbon::parse($to_date)->addDay())
                ->groupBy('patient_id')
                ->get();
            foreach ($admissions as $item) {

                if (isset($result[$item->patient->address->district_id])) {
                    $result[$item->patient->address->district_id] += 1;
                } else {
                    $result[$item->patient->address->district_id] = 1;
                }

                //echo $item->patient->id . " - " . $item->id . "<br/>";
            }
        }
        //dd($result);
        $search_data = (object) [
            'start_date' => $from_date,
            'end_date' => $to_date,
            'report_type' => $request->rpt_type,
        ];

        return view('reports.district-admissions', compact('district', 'result', 'search_data'));

    }

    public function avgLenOfStayReport()
    {
        $to_date = Carbon::now()->format('Y-m-d');
        $from_date = Carbon::now()->subMonth()->format('Y-m-d');

        $dateDiff = $this->dateDiffInDays($from_date, $to_date);

        $patients = occupancy::select('admission_id')
            ->where('date', '>=', $from_date)
            ->where('date', '<=', $to_date)
            ->where('type', '=', 'p')
            ->groupBy('admission_id')
            ->get();
        $dayCount = occupancy::select('id')
            ->where('date', '>=', $from_date)
            ->where('date', '<=', $to_date)
            ->where('type', '=', 'p')
            ->count();

        $patients_count = count($patients);
        if ($patients_count != 0) {
            $avg_len_of_stay = round($dayCount / $patients_count, 2);
        } else {
            $avg_len_of_stay = 0;
        }


        $search_data = (object) [
            'start_date' => $from_date,
            'end_date' => $to_date,
            'day_count' => $dayCount,
            'avg_len_of_stay' => $avg_len_of_stay,
            'dateDiff' => $dateDiff,
        ];

        return view('reports.avg-len-of-stay', compact('patients_count', 'search_data'));

    }

    public function avgLenOfStaySearchReport(Request $request)
    {

        $to_date = $request->end_date;
        $from_date = $request->start_date;

        $dateDiff = $this->dateDiffInDays($from_date, $to_date);

        $patients = occupancy::select('admission_id')
            ->where('date', '>=', $from_date)
            ->where('date', '<=', $to_date)
            ->where('type', '=', 'p')
            ->groupBy('admission_id')
            ->get();

        $dayCount = occupancy::select('id')
            ->where('date', '>=', $from_date)
            ->where('date', '<=', $to_date)
            ->where('type', '=', 'p')
            ->count();

        $patients_count = count($patients);

        if ($patients_count != 0) {
            $avg_len_of_stay = round($dayCount / $patients_count, 2);
        } else {
            $avg_len_of_stay = 0;
        }

        $search_data = (object) [
            'start_date' => $from_date,
            'end_date' => $to_date,
            'day_count' => $dayCount,
            'avg_len_of_stay' => $avg_len_of_stay,
            'dateDiff' => $dateDiff,
        ];

        return view('reports.avg-len-of-stay', compact('patients_count', 'search_data'));

    }

    public function dateDiffInDays($date1, $date2)
    {
        $diff = strtotime($date2) - strtotime($date1);
        return abs(round($diff / 86400));
    }

  // these two function for chart
  public function  admissionChart(){
    return view('reports.admission-rate-chart');
   }




   public function getAdmissionData(Request $request) {
    $start_date_input = $request->input('start_date');
    $end_date_input = $request->input('end_date'); 

    // Default to the past 30 days if no dates are provided
    if (!$start_date_input && !$end_date_input) {
        $start_date = Carbon::now()->subDays(30)->startOfDay();
        $end_date = Carbon::now()->endOfDay();
    } else {
        $start_date = Carbon::parse($start_date_input)->startOfDay();
        $end_date = Carbon::parse($end_date_input)->endOfDay();
    }
    $report_type = $request->input('rpt_type', 'a'); 
    
    $admissions = admission::query();

    // Apply the date range filter
    $admissions->whereBetween('date_of_check_in', [$start_date, $end_date]);

    if ($report_type === 'a') { // Daily report
        $admissions = $admissions->selectRaw('DATE(date_of_check_in) as day, COUNT(*) as count')
                                 ->groupBy('day')
                                 ->orderBy('day', 'asc')
                                 ->get();

        $categories = $admissions->pluck('day')->toArray();
        $admission_counts = $admissions->pluck('count')->toArray();
    } else { // Monthly report
        $admissions = $admissions->selectRaw('DATE_FORMAT(date_of_check_in, "%Y-%m") as month, COUNT(*) as count')
                                 ->groupBy('month')
                                 ->orderBy('month', 'asc')
                                 ->get();

        $categories = $admissions->pluck('month')->toArray();
        $admission_counts = $admissions->pluck('count')->toArray();
    }

    return response()->json([
        'categories' => $categories,
        'admission_counts' => $admission_counts,
    ]);
}

    public function monthlyReport(monthlyReportDataTable $dataTable){
            // $occupations = occupancy::select('type',DB::raw('count(*) as count'),
            // DB::raw('CONCAT(YEAR(date), "-", LPAD(MONTH(date), 2, "0")) as month_year')
            // )->groupBy('month_year', 'type')->get()->toArray();

            // $occupations =   occupancy::select(
            //     DB::raw('COUNT(*) as count'),
            //     DB::raw('CONCAT(YEAR(date), "-", LPAD(MONTH(date), 2, "0")) as month_year'),
            //     DB::raw('SUM(CASE WHEN type = "p" THEN 1 ELSE 0 END) as p_count'),
            //     DB::raw('SUM(CASE WHEN type = "f" THEN 1 ELSE 0 END) as f_count'),
            //     DB::raw('SUM(CASE WHEN type = "m" THEN 1 ELSE 0 END) as m_count'),
            //     DB::raw('SUM(CASE WHEN type IN ("o", "g") THEN 1 ELSE 0 END) as o_count')
            // )
            // ->groupBy('month_year')
            // ->orderBy('month_year','desc')
            // ->get()
            // ->toArray();
            // dd($occupations);

            return $dataTable->render('reports.monthly-report');
    }
}