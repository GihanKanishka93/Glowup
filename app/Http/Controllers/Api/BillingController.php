<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\UpdateBillRequest;
use App\Http\Resources\BillResource;
use App\Models\Bill;
use App\Services\BillingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function __construct(private readonly BillingService $billingService)
    {
        $this->authorizeResource(Bill::class, 'billing');
    }

    public function index(Request $request): JsonResponse
    {
        $query = Bill::with(['treatment.pet', 'treatment.doctor', 'treatment.prescriptions', 'treatment.vaccinations', 'BillItems']);

        $query->filter(
            $request->only(['payment_status', 'bill_status', 'bill_type', 'billing_date']),
            ['payment_status', 'bill_status', 'bill_type', 'billing_date']
        )->sort(
            $request->query('sort'),
            ['billing_date', 'total', 'created_at']
        );

        $bills = $query->paginateRequest($request->integer('per_page'));

        return BillResource::collection($bills)->response();
    }

    public function store(StoreBillRequest $request): JsonResponse
    {
        $bill = $this->billingService->createFromRequest($request);

        return (new BillResource($bill))->response()->setStatusCode(201);
    }

    public function show(Bill $bill): JsonResponse
    {
        $bill->load(['treatment.pet', 'treatment.doctor', 'treatment.prescriptions', 'treatment.vaccinations', 'BillItems']);

        return (new BillResource($bill))->response();
    }

    public function update(UpdateBillRequest $request, Bill $bill): JsonResponse
    {
        $bill = $this->billingService->updateFromRequest($request, $bill);

        return (new BillResource($bill))->response();
    }

    public function destroy(Bill $bill): JsonResponse
    {
        $bill->delete();

        return response()->json(['message' => 'Bill deleted']);
    }
}
