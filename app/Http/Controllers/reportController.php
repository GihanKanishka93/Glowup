<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Pet;
use App\Models\Treatment;
use App\Models\Bill;
use App\Models\Services;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\DataTables\monthlyReportDataTable;
use App\DataTables\BillingReportDataTable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class reportController extends Controller
{



    public function dateDiffInDays($date1, $date2)
    {
        $diff = strtotime($date2) - strtotime($date1);
        return abs(round($diff / 86400));
    }

    public function monthlyReport(Request $request, monthlyReportDataTable $dataTable)
    {

        $pets = Pet::all();
        $doctors = Doctor::all();

        $selectedDoctorId = $request->input('doctor_id');
        $selectedPetId = $request->input('pet_id');

        $startDateInput = $request->input('start_date');
        $endDateInput = $request->input('end_date');

        $startDate = $startDateInput ? Carbon::parse($startDateInput) : Carbon::now()->startOfMonth();
        $endDate = $endDateInput ? Carbon::parse($endDateInput) : Carbon::now()->endOfMonth();

        $rangeStart = $startDate->copy()->startOfDay();
        $rangeEnd = $endDate->copy()->endOfDay();

        $filteredBillsQuery = Bill::query()
            ->whereNull('bills.deleted_at')
            ->whereBetween('bills.billing_date', [$rangeStart, $rangeEnd]);

        if (!empty($selectedDoctorId)) {
            $filteredBillsQuery->whereHas('treatment.doctor', function ($q) use ($selectedDoctorId) {
                $q->where('doctors.id', $selectedDoctorId)
                    ->whereNull('doctors.deleted_at');
            });
        }

        if (!empty($selectedPetId)) {
            $filteredBillsQuery->whereHas('treatment.pet', function ($q) use ($selectedPetId) {
                $q->where('pets.id', $selectedPetId)
                    ->whereNull('pets.deleted_at');
            });
        }

        $baseQuery = (clone $filteredBillsQuery);

        $billCount = (clone $baseQuery)->count();
        $billSum = (clone $baseQuery)->sum('total') ?? 0;

        $dailyBreakdownQuery = DB::table('bills as b')
            ->whereNull('b.deleted_at')
            ->whereBetween('b.billing_date', [$rangeStart, $rangeEnd]);

        if ($selectedDoctorId || $selectedPetId) {
            $dailyBreakdownQuery->leftJoin('treatments as t', function ($join) {
                $join->on('t.id', '=', 'b.treatment_id')
                    ->whereNull('t.deleted_at');
            });
        }

        if ($selectedDoctorId) {
            $dailyBreakdownQuery->leftJoin('doctors as d', function ($join) {
                $join->on('d.id', '=', 't.doctor_id')
                    ->whereNull('d.deleted_at');
            });
            $dailyBreakdownQuery->where('d.id', $selectedDoctorId);
        }

        if ($selectedPetId) {
            $dailyBreakdownQuery->leftJoin('pets as p', function ($join) {
                $join->on('p.id', '=', 't.pet_id')
                    ->whereNull('p.deleted_at');
            });
            $dailyBreakdownQuery->where('p.id', $selectedPetId);
        }

        $dailyBreakdown = $dailyBreakdownQuery
            ->selectRaw('DATE(b.billing_date) as billing_day, SUM(b.total) as total, COUNT(*) as count')
            ->groupBy('billing_day')
            ->orderBy('billing_day')
            ->get()
            ->map(function ($row) {
                $date = Carbon::parse($row->billing_day);
                return [
                    'day' => $date->toDateString(),
                    'label' => $date->format('M j'),
                    'total' => (float) $row->total,
                    'count' => (int) $row->count,
                ];
            })
            ->toArray();

        $doctorBreakdownQuery = DB::table('bills as b')
            ->leftJoin('treatments as t', function ($join) {
                $join->on('t.id', '=', 'b.treatment_id')
                    ->whereNull('t.deleted_at');
            })
            ->leftJoin('doctors as d', function ($join) {
                $join->on('d.id', '=', 't.doctor_id')
                    ->whereNull('d.deleted_at');
            })
            ->whereNull('b.deleted_at')
            ->whereBetween('b.billing_date', [$rangeStart, $rangeEnd]);

        if ($selectedPetId) {
            $doctorBreakdownQuery->leftJoin('pets as p', function ($join) {
                $join->on('p.id', '=', 't.pet_id')
                    ->whereNull('p.deleted_at');
            });
            $doctorBreakdownQuery->where('p.id', $selectedPetId);
        }

        if ($selectedDoctorId) {
            $doctorBreakdownQuery->where('d.id', $selectedDoctorId);
        }

        $doctorBreakdown = $doctorBreakdownQuery
            ->selectRaw('COALESCE(d.name, "Unassigned") as doctor_name, SUM(b.total) as total, COUNT(b.id) as count')
            ->groupBy('doctor_name')
            ->orderByDesc('total')
            ->limit(8)
            ->get()
            ->map(function ($row) {
                return [
                    'name' => $row->doctor_name,
                    'total' => (float) $row->total,
                    'count' => (int) $row->count,
                ];
            })
            ->toArray();

        if ($request->boolean('summary_only')) {
            return response()->json([
                'billCount' => $billCount,
                'billSum' => (float) $billSum,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'charts' => [
                    'daily' => $dailyBreakdown,
                    'doctors' => $doctorBreakdown,
                ],
            ]);
        }

        $dataTable->with([
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'doctor_id' => $selectedDoctorId,
            'pet_id' => $selectedPetId,
        ]);

        return $dataTable->render('reports.monthly-report', [
            'pets' => $pets,
            'doctors' => $doctors,
            'selectedDoctorId' => $selectedDoctorId,
            'selectedPetId' => $selectedPetId,
            'startDate' => $startDate->toDateString(),
            'endDate' => $endDate->toDateString(),
            'billCount' => $billCount,
            'billSum' => (float) $billSum,
            'dailyBreakdown' => $dailyBreakdown,
            'doctorBreakdown' => $doctorBreakdown,
        ]);
    }

    public function billingReport(Request $request, BillingReportDataTable $dataTable)
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

        // Fetch the count of billing records and total billing amount
        $billingStats = DB::table('bills') // Replace 'billings' with your billing table name
            ->select(DB::raw('COUNT(*) as total_records, SUM(total) as total_amount'))
            ->whereNull('bills.deleted_at')
            ->whereBetween('bills.billing_date', [
                Carbon::parse($start_date)->startOfDay(),
                Carbon::parse($end_date)->endOfDay(),
            ])
            ->first();

        $total_records = $billingStats->total_records;
        $total_amount = $billingStats->total_amount;


        // $patient = ($request->patient_id) ? patient::where('id', $request->patient_id)->first()->name : '';


        return $dataTable->with([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ])->render(
                'reports.index',
                compact(
                    'start_date',
                    'end_date',
                    'total_records',
                    'total_amount'
                )
            );

    }

    public function doctorReport(Request $request)
    {
        $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'doctor_id' => ['nullable', 'integer', 'exists:doctors,id'],
        ]);

        $startDateInput = $request->input('start_date');
        $endDateInput = $request->input('end_date');
        $selectedDoctorId = $request->input('doctor_id');

        $startDate = $startDateInput ? Carbon::parse($startDateInput) : Carbon::now()->startOfMonth();
        $endDate = $endDateInput ? Carbon::parse($endDateInput) : Carbon::now();
        $rangeStart = $startDate->copy()->startOfDay();
        $rangeEnd = $endDate->copy()->endOfDay();

        $doctors = Doctor::orderBy('name')->get();
        $servicesCatalog = Services::orderBy('name')->get();

        $invoiceRows = DB::table('doctors as d')
            ->select('d.id', 'd.name', DB::raw('COUNT(DISTINCT b.id) as invoice_count'))
            ->leftJoin('treatments as t', function ($join) {
                $join->on('t.doctor_id', '=', 'd.id')
                    ->whereNull('t.deleted_at');
            })
            ->leftJoin('bills as b', function ($join) use ($rangeStart, $rangeEnd) {
                $join->on('b.treatment_id', '=', 't.id')
                    ->whereNull('b.deleted_at')
                    ->where(function ($query) use ($rangeStart, $rangeEnd) {
                        $query->whereBetween('b.billing_date', [$rangeStart, $rangeEnd])
                            ->orWhere(function ($sub) use ($rangeStart, $rangeEnd) {
                                $sub->whereNull('b.billing_date')
                                    ->whereBetween('b.created_at', [$rangeStart, $rangeEnd]);
                            });
                    });
            })
            ->whereNull('d.deleted_at');

        if ($selectedDoctorId) {
            $invoiceRows->where('d.id', $selectedDoctorId);
        }

        $invoiceRows = $invoiceRows
            ->groupBy('d.id', 'd.name')
            ->get();

        $serviceCounts = DB::table('bill_items as bi')
            ->join('bills as b', function ($join) use ($rangeStart, $rangeEnd) {
                $join->on('b.id', '=', 'bi.bill_id')
                    ->whereNull('b.deleted_at')
                    ->where(function ($query) use ($rangeStart, $rangeEnd) {
                        $query->whereBetween('b.billing_date', [$rangeStart, $rangeEnd])
                            ->orWhere(function ($sub) use ($rangeStart, $rangeEnd) {
                                $sub->whereNull('b.billing_date')
                                    ->whereBetween('b.created_at', [$rangeStart, $rangeEnd]);
                            });
                    });
            })
            ->join('treatments as t', function ($join) {
                $join->on('t.id', '=', 'b.treatment_id')
                    ->whereNull('t.deleted_at');
            })
            ->join('doctors as d', function ($join) {
                $join->on('d.id', '=', 't.doctor_id')
                    ->whereNull('d.deleted_at');
            })
            ->whereNull('bi.deleted_at')
            ->when($selectedDoctorId, function ($query) use ($selectedDoctorId) {
                $query->where('d.id', $selectedDoctorId);
            })
            ->select(
                'd.id as doctor_id',
                'd.name as doctor_name',
                'bi.item_name',
                DB::raw('SUM(COALESCE(bi.item_qty, 1)) as service_count')
            )
            ->groupBy('d.id', 'd.name', 'bi.item_name')
            ->get();

        $doctorSummary = [];

        foreach ($invoiceRows as $row) {
            $doctorSummary[$row->id] = [
                'id' => $row->id,
                'name' => $row->name,
                'invoice_count' => (int) $row->invoice_count,
                'services' => [],
                'total_services' => 0,
            ];
        }

        foreach ($serviceCounts as $row) {
            if (!isset($doctorSummary[$row->doctor_id])) {
                $doctorSummary[$row->doctor_id] = [
                    'id' => $row->doctor_id,
                    'name' => $row->doctor_name,
                    'invoice_count' => 0,
                    'services' => [],
                    'total_services' => 0,
                ];
            }

            $count = (int) $row->service_count;
            $doctorSummary[$row->doctor_id]['services'][$row->item_name] = $count;
            $doctorSummary[$row->doctor_id]['total_services'] += $count;
        }

        if ($selectedDoctorId && !isset($doctorSummary[$selectedDoctorId])) {
            $selectedDoctor = $doctors->firstWhere('id', (int) $selectedDoctorId);
            if ($selectedDoctor) {
                $doctorSummary[$selectedDoctor->id] = [
                    'id' => $selectedDoctor->id,
                    'name' => $selectedDoctor->name,
                    'invoice_count' => 0,
                    'services' => [],
                    'total_services' => 0,
                ];
            }
        }

        $doctorSummaries = array_values(array_filter($doctorSummary, function ($row) use ($selectedDoctorId) {
            if ($selectedDoctorId) {
                return true;
            }

            return ($row['invoice_count'] ?? 0) > 0 || ($row['total_services'] ?? 0) > 0;
        }));

        $serviceNames = collect($servicesCatalog)
            ->pluck('name')
            ->merge($serviceCounts->pluck('item_name'))
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();

        $totalInvoices = collect($doctorSummaries)->sum('invoice_count');
        $totalServices = collect($doctorSummaries)->sum('total_services');
        $doctorCount = count($doctorSummaries);

        return view('reports.doctor-report', [
            'doctors' => $doctors,
            'serviceNames' => $serviceNames,
            'doctorSummaries' => $doctorSummaries,
            'startDate' => $rangeStart->toDateString(),
            'endDate' => $rangeEnd->toDateString(),
            'selectedDoctorId' => $selectedDoctorId,
            'totalInvoices' => $totalInvoices,
            'totalServices' => $totalServices,
            'doctorCount' => $doctorCount,
        ]);
    }

    public function doctorReportDetail(Request $request, Doctor $doctor)
    {
        if ($doctor->deleted_at) {
            throw new NotFoundHttpException();
        }

        $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $startDateInput = $request->input('start_date');
        $endDateInput = $request->input('end_date');

        $startDate = $startDateInput ? Carbon::parse($startDateInput) : Carbon::now()->startOfMonth();
        $endDate = $endDateInput ? Carbon::parse($endDateInput) : Carbon::now();
        $rangeStart = $startDate->copy()->startOfDay();
        $rangeEnd = $endDate->copy()->endOfDay();

        $baseBillQuery = DB::table('bills as b')
            ->join('treatments as t', function ($join) {
                $join->on('t.id', '=', 'b.treatment_id')
                    ->whereNull('t.deleted_at');
            })
            ->whereNull('b.deleted_at')
            ->where('t.doctor_id', $doctor->id)
            ->where(function ($query) use ($rangeStart, $rangeEnd) {
                $query->whereBetween('b.billing_date', [$rangeStart, $rangeEnd])
                    ->orWhere(function ($sub) use ($rangeStart, $rangeEnd) {
                        $sub->whereNull('b.billing_date')
                            ->whereBetween('b.created_at', [$rangeStart, $rangeEnd]);
                    });
            });

        $invoiceCount = (clone $baseBillQuery)->count(DB::raw('DISTINCT b.id'));

        $serviceCounts = DB::table('bill_items as bi')
            ->join('bills as b', function ($join) use ($rangeStart, $rangeEnd) {
                $join->on('b.id', '=', 'bi.bill_id')
                    ->whereNull('b.deleted_at')
                    ->where(function ($query) use ($rangeStart, $rangeEnd) {
                        $query->whereBetween('b.billing_date', [$rangeStart, $rangeEnd])
                            ->orWhere(function ($sub) use ($rangeStart, $rangeEnd) {
                                $sub->whereNull('b.billing_date')
                                    ->whereBetween('b.created_at', [$rangeStart, $rangeEnd]);
                            });
                    });
            })
            ->join('treatments as t', function ($join) {
                $join->on('t.id', '=', 'b.treatment_id')
                    ->whereNull('t.deleted_at');
            })
            ->whereNull('bi.deleted_at')
            ->where('t.doctor_id', $doctor->id)
            ->select(
                'bi.item_name',
                DB::raw('SUM(COALESCE(bi.item_qty, 1)) as service_count')
            )
            ->groupBy('bi.item_name')
            ->orderByDesc('service_count')
            ->get();

        $totalServices = (int) ($serviceCounts->sum('service_count') ?? 0);
        $topServices = $serviceCounts->take(10);

        $dailyActivity = (clone $baseBillQuery)
            ->selectRaw('DATE(COALESCE(b.billing_date, b.created_at)) as day')
            ->selectRaw('COUNT(DISTINCT b.id) as invoices')
            ->selectRaw('SUM(service_counts.total_service_for_bill) as services')
            ->leftJoin(DB::raw('(select bi.bill_id, SUM(COALESCE(bi.item_qty,1)) as total_service_for_bill from bill_items bi where bi.deleted_at IS NULL group by bi.bill_id) as service_counts'), 'service_counts.bill_id', '=', 'b.id')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $recentInvoices = (clone $baseBillQuery)
            ->leftJoin('pets as p', function ($join) {
                $join->on('p.id', '=', 't.pet_id')
                    ->whereNull('p.deleted_at');
            })
            ->select('b.id', 'b.billing_id', 'b.total', 'b.billing_date', 'p.name as pet_name')
            ->orderByDesc('b.billing_date')
            ->orderByDesc('b.created_at')
            ->limit(10)
            ->get();

        return view('reports.doctor-report-detail', [
            'doctor' => $doctor,
            'invoiceCount' => $invoiceCount,
            'totalServices' => $totalServices,
            'topServices' => $topServices,
            'serviceCounts' => $serviceCounts,
            'dailyActivity' => $dailyActivity,
            'recentInvoices' => $recentInvoices,
            'startDate' => $rangeStart->toDateString(),
            'endDate' => $rangeEnd->toDateString(),
        ]);
    }

    public function vaccinationSales(Request $request)
    {
        $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $startDateInput = $request->input('start_date');
        $endDateInput = $request->input('end_date');

        $startDate = $startDateInput ? Carbon::parse($startDateInput) : Carbon::now()->startOfYear();
        $endDate = $endDateInput ? Carbon::parse($endDateInput) : Carbon::now();

        $rangeStart = $startDate->copy()->startOfDay();
        $rangeEnd = $endDate->copy()->endOfDay();

        $vaccinationCounts = DB::table('vaccination_infos as vi')
            ->join('vaccinations as v', function ($join) {
                $join->on('v.id', '=', 'vi.vaccine_id')
                    ->whereNull('v.deleted_at');
            })
            ->join('treatments as t', function ($join) {
                $join->on('t.id', '=', 'vi.trement_id')
                    ->whereNull('t.deleted_at');
            })
            ->join('bills as b', function ($join) {
                $join->on('b.treatment_id', '=', 't.id')
                    ->whereNull('b.deleted_at');
            })
            ->whereNull('vi.deleted_at')
            ->where(function ($query) use ($rangeStart, $rangeEnd) {
                // Use billing_date when present, otherwise fall back to created_at.
                $query->whereBetween('b.billing_date', [$rangeStart, $rangeEnd])
                    ->orWhere(function ($sub) use ($rangeStart, $rangeEnd) {
                        $sub->whereNull('b.billing_date')
                            ->whereBetween('b.created_at', [$rangeStart, $rangeEnd]);
                    });
            })
            ->select('vi.vaccine_id', DB::raw('COUNT(vi.id) as vaccination_count'))
            ->groupBy('vi.vaccine_id');

        $serviceCounts = DB::table('bill_items as bi')
            ->join('bills as b', function ($join) {
                $join->on('b.id', '=', 'bi.bill_id')
                    ->whereNull('b.deleted_at');
            })
            ->join('vaccinations as v', function ($join) {
                // Match service name exactly to vaccine name
                $join->on('v.name', '=', 'bi.item_name')
                    ->whereNull('v.deleted_at');
            })
            ->whereNull('bi.deleted_at')
            ->where(function ($query) use ($rangeStart, $rangeEnd) {
                $query->whereBetween('b.billing_date', [$rangeStart, $rangeEnd])
                    ->orWhere(function ($sub) use ($rangeStart, $rangeEnd) {
                        $sub->whereNull('b.billing_date')
                            ->whereBetween('b.created_at', [$rangeStart, $rangeEnd]);
                    });
            })
            ->select('v.id as vaccine_id', DB::raw('COUNT(bi.id) as service_count'))
            ->groupBy('v.id');

        $vaccinationBreakdown = DB::table('vaccinations as v')
            ->whereNull('v.deleted_at')
            ->leftJoinSub($vaccinationCounts, 'vi_counts', function ($join) {
                $join->on('vi_counts.vaccine_id', '=', 'v.id');
            })
            ->leftJoinSub($serviceCounts, 'svc_counts', function ($join) {
                $join->on('svc_counts.vaccine_id', '=', 'v.id');
            })
            ->select(
                'v.name',
                DB::raw('COALESCE(vi_counts.vaccination_count, 0) as vaccination_count'),
                DB::raw('COALESCE(svc_counts.service_count, 0) as service_count'),
                DB::raw('(COALESCE(vi_counts.vaccination_count, 0) + COALESCE(svc_counts.service_count, 0)) as sold_count')
            )
            ->having('sold_count', '>', 0)
            ->orderByDesc('sold_count')
            ->get();

        $totalVaccinations = $vaccinationBreakdown->sum('sold_count');

        return view('reports.vaccination-sales', [
            'startDate' => $rangeStart->toDateString(),
            'endDate' => $rangeEnd->toDateString(),
            'vaccinationBreakdown' => $vaccinationBreakdown,
            'totalVaccinations' => $totalVaccinations,
        ]);
    }
}
