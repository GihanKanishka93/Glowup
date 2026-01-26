@extends('layouts.app')

@section('content')
    @php
        $subtitle = 'From ' . $startDate . ' to ' . $endDate;
    @endphp
    <x-list-page title="{{ $doctor->name }} — Performance" :back-route="route('report.doctor-report', ['start_date' => $startDate, 'end_date' => $endDate, 'doctor_id' => $doctor->id])" :subtitle="$subtitle" class="reports-doctor-detail">
        <div class="report-shell">
            <div class="row row-cols-1 row-cols-md-3 g-3 report-metrics">
                <div class="col">
                    <div class="report-metric-card">
                        <div class="metric-icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="metric-copy">
                            <span class="metric-label">Invoices</span>
                            <span class="metric-value">{{ number_format($invoiceCount) }}</span>
                            <span class="metric-sub">Bills handled in this range</span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="report-metric-card">
                        <div class="metric-icon metric-icon-success">
                            <i class="fas fa-briefcase-medical"></i>
                        </div>
                        <div class="metric-copy">
                            <span class="metric-label">Services Delivered</span>
                            <span class="metric-value">{{ number_format($totalServices) }}</span>
                            <span class="metric-sub">All service line items</span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="report-metric-card">
                        <div class="metric-icon metric-icon-muted">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="metric-copy">
                            <span class="metric-label">Avg. Services per Invoice</span>
                            <span class="metric-value">
                                {{ $invoiceCount > 0 ? number_format($totalServices / $invoiceCount, 2) : '0.00' }}
                            </span>
                            <span class="metric-sub">Quick utilization glance</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12 col-xl-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white border-0">
                            <h6 class="mb-0">Top Services</h6>
                            <small class="text-muted">Most delivered items</small>
                        </div>
                        <div class="card-body">
                            @if ($topServices->isEmpty())
                                <div class="text-muted text-center">No services recorded in this range.</div>
                            @else
                                <ul class="service-list">
                                    @foreach ($topServices as $row)
                                        <li>
                                            <span class="service-name">{{ $row->item_name }}</span>
                                            <span class="service-count">{{ number_format($row->service_count) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white border-0">
                            <h6 class="mb-0">Recent Invoices</h6>
                            <small class="text-muted">Last 10 in the range</small>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Billing ID</th>
                                        <th>Client</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-end">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentInvoices as $row)
                                        <tr>
                                            <td>{{ $row->billing_id }}</td>
                                            <td>{{ $row->patient_name ?? 'N/A' }}</td>
                                            <td class="text-end">{{ number_format($row->total ?? 0, 2) }}</td>
                                            <td class="text-end">{{ $row->billing_date ? \Illuminate\Support\Carbon::parse($row->billing_date)->toDateString() : 'N/A' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No invoices in this range.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">All Services by Count</h6>
                        <small class="text-muted">Every service item for this doctor</small>
                    </div>
                    <span class="badge bg-light text-dark">{{ $subtitle }}</span>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Service</th>
                                <th class="text-end">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($serviceCounts as $row)
                                <tr>
                                    <td>{{ $row->item_name }}</td>
                                    <td class="text-end fw-semibold">{{ number_format($row->service_count) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">No services recorded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-list-page>
@endsection

@push('styles')
    <style>
        .reports-doctor-detail .report-shell {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }
        .reports-doctor-detail .report-metric-card {
            border: 1px solid rgba(148, 163, 184, 0.35);
            border-radius: 12px;
            padding: 1rem;
            display: flex;
            gap: 0.75rem;
            align-items: center;
            background: #fff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }
        .reports-doctor-detail .metric-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
            font-size: 1.1rem;
        }
        .reports-doctor-detail .metric-icon-success {
            background: rgba(34, 197, 94, 0.12);
            color: #15803d;
        }
        .reports-doctor-detail .metric-icon-muted {
            background: rgba(100, 116, 139, 0.12);
            color: #475569;
        }
        .reports-doctor-detail .metric-label {
            display: block;
            font-size: 0.875rem;
            color: #64748b;
        }
        .reports-doctor-detail .metric-value {
            display: block;
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
        }
        .reports-doctor-detail .metric-sub {
            font-size: 0.85rem;
            color: #94a3b8;
        }
        .reports-doctor-detail .service-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .reports-doctor-detail .service-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(148, 163, 184, 0.12);
            border-radius: 10px;
            padding: 0.6rem 0.75rem;
        }
        .reports-doctor-detail .service-name {
            font-weight: 600;
            color: #0f172a;
        }
        .reports-doctor-detail .service-count {
            font-weight: 700;
            color: #475569;
        }
    </style>
@endpush
