<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Occupancy;
use App\Models\Treatment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function billingSummary(Request $request): JsonResponse
    {
        $start = $request->date('start_date', Carbon::now()->startOfMonth());
        $end = $request->date('end_date', Carbon::now()->endOfMonth());

        $query = Bill::whereBetween('billing_date', [$start, $end]);

        $summary = [
            'total_bills' => (clone $query)->count(),
            'total_revenue' => (clone $query)->sum('total'),
            'average_revenue' => (clone $query)->average('total'),
            'paid_bills' => (clone $query)->where('payment_status', 1)->count(),
            'outstanding_bills' => (clone $query)
                ->where(function ($billQuery) {
                    $billQuery->whereNull('payment_status')
                        ->orWhere('payment_status', '!=', 1);
                })
                ->count(),
        ];

        return response()->json($summary);
    }

    public function occupancySummary(Request $request): JsonResponse
    {
        $date = $request->date('date', Carbon::today());

        $dailyOccupancies = Occupancy::whereDate('date', $date);

        $summary = [
            'date' => $date->toDateString(),
            'total_records' => $dailyOccupancies->count(),
            'rooms_in_use' => $dailyOccupancies->whereNotNull('room_id')->distinct('room_id')->count('room_id'),
        ];

        return response()->json($summary);
    }

    public function treatmentFollowups(Request $request): JsonResponse
    {
        $date = $request->date('date', Carbon::today());

        $followups = Treatment::whereDate('next_clinic_date', $date)->with(['pet', 'doctor'])->get();

        return response()->json([
            'date' => $date->toDateString(),
            'count' => $followups->count(),
            'treatments' => $followups->map(fn ($treatment) => [
                'id' => $treatment->id,
                'pet' => optional($treatment->pet)->name,
                'doctor' => optional($treatment->doctor)->name,
                'remarks' => $treatment->remarks,
            ]),
        ]);
    }
}
