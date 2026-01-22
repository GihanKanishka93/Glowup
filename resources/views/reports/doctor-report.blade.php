@extends('layouts.app')

@section('content')
    @php
        $subtitle = 'From ' . $startDate . ' to ' . $endDate;
        $doctorCollection = collect($doctorSummaries);
        $topInvoicesDoctor = $doctorCollection->sortByDesc('invoice_count')->first();
        $topServicesDoctor = $doctorCollection->sortByDesc('total_services')->first();
        $serviceTotals = [];
        foreach ($doctorSummaries as $doctorRow) {
            foreach (($doctorRow['services'] ?? []) as $serviceName => $count) {
                $serviceTotals[$serviceName] = ($serviceTotals[$serviceName] ?? 0) + (int) $count;
            }
        }
        $topServiceList = collect($serviceTotals)->sortDesc()->take(6);
        $topServiceList = collect($serviceTotals)->sortDesc()->take(5);
    @endphp
    <x-list-page title="Doctor Reports" :back-route="url()->previous()" :subtitle="$subtitle" class="reports-doctor">
        <div class="report-shell">
            <div class="report-filters">
                <form id="doctorReportForm" action="{{ route('report.doctor-report') }}" method="get" class="row g-3 align-items-end">
                    @csrf
                    @method('GET')
                    <div class="col-12 d-flex justify-content-between align-items-center gap-2 flex-wrap mb-1">
                        <div>
                            <h6 class="mb-1">Filter by Date & Doctor</h6>
                            <p class="text-muted mb-0">Choose the window to count services and invoices.</p>
                        </div>
                        <div class="filter-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i>Apply
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="clearFilters">
                                <i class="fas fa-undo me-1"></i>Clear
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input
                            type="text"
                            id="start_date"
                            name="start_date"
                            class="datepicker form-control"
                            value="{{ old('start_date', $startDate) }}"
                            placeholder="YYYY-MM-DD"
                        >
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <label for="end_date" class="form-label">End Date</label>
                        <input
                            type="text"
                            id="end_date"
                            name="end_date"
                            class="datepicker form-control"
                            value="{{ old('end_date', $endDate) }}"
                            placeholder="YYYY-MM-DD"
                        >
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <label for="doctor_id" class="form-label">Doctor</label>
                        <select id="doctor_id" name="doctor_id" class="form-select select2" data-placeholder="Any Doctor">
                            <option value=""></option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}" @selected(old('doctor_id', $selectedDoctorId) == $doctor->id)>
                                    {{ $doctor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-3 report-metrics">
                <div class="col">
                    <div class="report-metric-card">
                        <div class="metric-icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="metric-copy">
                            <span class="metric-label">Invoices</span>
                            <span class="metric-value">{{ number_format($totalInvoices) }}</span>
                            <span class="metric-sub">All bills in this period</span>
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
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="metric-copy">
                            <span class="metric-label">Doctors Counted</span>
                            <span class="metric-value">{{ number_format($doctorCount) }}</span>
                            <span class="metric-sub">With activity in this range</span>
                        </div>
                    </div>
                </div>
            </div>

            @if ($doctorCollection->count() > 0)
                <div class="row g-3 report-insights">
                    <div class="col-12 col-xl-4">
                        <div class="insight-card">
                            <div class="insight-label">Most Invoices</div>
                            <div class="insight-value">
                                {{ $topInvoicesDoctor['name'] ?? 'N/A' }}
                            </div>
                            <div class="insight-meta">
                                <span class="badge bg-primary-soft">{{ number_format($topInvoicesDoctor['invoice_count'] ?? 0) }} invoices</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="insight-card">
                            <div class="insight-label">Most Services</div>
                            <div class="insight-value">
                                {{ $topServicesDoctor['name'] ?? 'N/A' }}
                            </div>
                            <div class="insight-meta">
                                <span class="badge bg-success-soft">{{ number_format($topServicesDoctor['total_services'] ?? 0) }} services</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="insight-card">
                            <div class="insight-label">Top Services</div>
                            <div class="insight-services">
                                @forelse ($topServiceList as $name => $count)
                                    <span class="service-chip">
                                        <span class="chip-name">{{ $name }}</span>
                                        <span class="chip-count">{{ number_format($count) }}</span>
                                    </span>
                                @empty
                                    <span class="text-muted">No services in this range.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="doctor-card-grid">
                    @forelse ($doctorSummaries as $row)
                        @php
                            $serviceCounts = collect($row['services'] ?? [])->sortDesc();
                            $topServicesForDoctor = $serviceCounts->take(3);
                            $otherServices = max(0, ($row['total_services'] ?? 0) - $topServicesForDoctor->sum());
                        @endphp
                        <a class="doctor-card" href="{{ route('report.doctor-report-detail', ['doctor' => $row['id'], 'start_date' => $startDate, 'end_date' => $endDate]) }}">
                            <div class="doctor-card-header">
                                <div>
                                    <div class="doctor-name">{{ $row['name'] ?? 'Unknown' }}</div>
                                    <div class="doctor-period text-muted">Invoices: {{ number_format($row['invoice_count'] ?? 0) }}</div>
                                </div>
                                <div class="doctor-total">
                                    <span class="label">Services</span>
                                    <span class="value">{{ number_format($row['total_services'] ?? 0) }}</span>
                                </div>
                            </div>
                            <ul class="doctor-services">
                                @forelse ($topServicesForDoctor as $serviceName => $count)
                                    <li>
                                        <span class="service-name">{{ $serviceName }}</span>
                                        <span class="service-count">{{ number_format($count) }}</span>
                                    </li>
                                @empty
                                    <li class="text-muted">No services recorded.</li>
                                @endforelse
                                @if ($otherServices > 0)
                                    <li class="service-other">+ {{ number_format($otherServices) }} other</li>
                                @endif
                            </ul>
                            <div class="doctor-card-cta">
                                <span>View performance</span>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                    @empty
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center text-muted py-4">
                                No doctor activity found for this range.
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="card shadow-sm border-0 report-table-card">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Full Table (export friendly)</h6>
                            <small class="text-muted">Includes every service column — scroll sideways if needed.</small>
                        </div>
                        <span class="badge bg-light text-dark">{{ $subtitle }}</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive service-table-scroll">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Doctor</th>
                                        <th scope="col" class="text-end">Invoices</th>
                                        <th scope="col" class="text-end">Total Services</th>
                                        @foreach ($serviceNames as $serviceName)
                                            <th scope="col" class="text-end">{{ $serviceName }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($doctorSummaries as $row)
                                        <tr>
                                            <td>
                                                <a href="{{ route('report.doctor-report-detail', ['doctor' => $row['id'], 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="doctor-link">
                                                    {{ $row['name'] ?? 'Unknown' }}
                                                </a>
                                            </td>
                                            <td class="text-end fw-semibold">{{ number_format($row['invoice_count'] ?? 0) }}</td>
                                            <td class="text-end fw-semibold">{{ number_format($row['total_services'] ?? 0) }}</td>
                                            @foreach ($serviceNames as $serviceName)
                                                <td class="text-end text-muted">
                                                    {{ number_format($row['services'][$serviceName] ?? 0) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ 3 + count($serviceNames) }}" class="text-center text-muted py-4">
                                                No doctor activity found for this range.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center text-muted py-4">
                        No doctor activity found for this range.
                    </div>
                </div>
            @endif
        </div>
    </x-list-page>
@endsection

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('plugin/select2/select2.min.css') }}">
@stop

@section('third_party_scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.js"></script>
    <script src="{{ asset('plugin/select2/select2.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr('.datepicker', {
                dateFormat: 'Y-m-d',
                allowInput: true,
            });

            const doctorSelect = $('#doctor_id');
            if (doctorSelect.length) {
                doctorSelect.select2({
                    placeholder: doctorSelect.data('placeholder') || 'Any Doctor',
                    allowClear: true,
                    width: '100%',
                });
            }

            const clearBtn = document.getElementById('clearFilters');
            const form = document.getElementById('doctorReportForm');
            const startInput = document.getElementById('start_date');
            const endInput = document.getElementById('end_date');

            clearBtn?.addEventListener('click', () => {
                startInput.value = '';
                endInput.value = '';
                if (doctorSelect.length) {
                    doctorSelect.val(null).trigger('change');
                }
                form.submit();
            });
        });
    </script>
@stop

@push('styles')
    <style>
        .reports-doctor .report-shell {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }
        .reports-doctor .report-filters {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(59, 130, 246, 0.08));
            border: 1px solid rgba(148, 163, 184, 0.35);
            border-radius: 14px;
            padding: 1rem 1.25rem;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }
        .reports-doctor .filter-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
        }
        .reports-doctor .filter-actions {
            display: flex;
            gap: 0.5rem;
        }
        .reports-doctor .report-metric-card {
            border: 1px solid rgba(148, 163, 184, 0.35);
            border-radius: 12px;
            padding: 1rem;
            display: flex;
            gap: 0.75rem;
            align-items: center;
            background: #fff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }
        .reports-doctor .metric-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
            font-size: 1.1rem;
        }
        .reports-doctor .metric-icon-success {
            background: rgba(34, 197, 94, 0.12);
            color: #15803d;
        }
        .reports-doctor .metric-icon-muted {
            background: rgba(100, 116, 139, 0.12);
            color: #475569;
        }
        .reports-doctor .metric-label {
            display: block;
            font-size: 0.875rem;
            color: #64748b;
        }
        .reports-doctor .metric-value {
            display: block;
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
        }
        .reports-doctor .metric-sub {
            font-size: 0.85rem;
            color: #94a3b8;
        }
        .reports-doctor .service-table-scroll {
            overflow-x: auto;
        }
        .reports-doctor .service-table-scroll table {
            min-width: 720px;
        }
        .reports-doctor .report-table-card .card-header {
            border-bottom: 1px solid rgba(148, 163, 184, 0.35);
        }
        .reports-doctor .report-insights .insight-card {
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.35);
            border-radius: 12px;
            padding: 1rem;
            height: 100%;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }
        .reports-doctor .insight-label {
            font-size: 0.85rem;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }
        .reports-doctor .insight-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
        }
        .reports-doctor .insight-meta .badge {
            font-weight: 600;
        }
        .bg-primary-soft {
            background: rgba(79, 70, 229, 0.12);
            color: #4338ca;
        }
        .bg-success-soft {
            background: rgba(34, 197, 94, 0.14);
            color: #166534;
        }
        .reports-doctor .insight-services {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-top: 0.25rem;
        }
        .reports-doctor .service-chip {
            background: rgba(79, 70, 229, 0.08);
            color: #0f172a;
            border-radius: 999px;
            padding: 0.3rem 0.65rem;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            border: 1px solid rgba(79, 70, 229, 0.15);
        }
        .reports-doctor .service-chip .chip-name {
            font-weight: 600;
        }
        .reports-doctor .service-chip .chip-count {
            background: rgba(15, 23, 42, 0.08);
            border-radius: 999px;
            padding: 0.15rem 0.45rem;
            font-weight: 700;
            font-size: 0.8rem;
        }
        .reports-doctor .service-chip-muted {
            background: rgba(148, 163, 184, 0.2);
            color: #475569;
            border-color: rgba(148, 163, 184, 0.35);
        }
        .reports-doctor .doctor-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1rem;
        }
        .reports-doctor .doctor-card {
            text-decoration: none;
            color: inherit;
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 12px 36px rgba(15, 23, 42, 0.06);
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            transition: transform 0.1s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .reports-doctor .doctor-card:hover {
            transform: translateY(-3px);
            border-color: rgba(79, 70, 229, 0.55);
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.14);
        }
        .reports-doctor .doctor-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .reports-doctor .doctor-name {
            font-weight: 700;
            font-size: 1rem;
            color: #0f172a;
        }
        .reports-doctor .doctor-period {
            font-size: 0.85rem;
        }
        .reports-doctor .doctor-total {
            text-align: right;
        }
        .reports-doctor .doctor-total .label {
            display: block;
            font-size: 0.8rem;
            color: #64748b;
        }
        .reports-doctor .doctor-total .value {
            font-size: 1.1rem;
            font-weight: 800;
            color: #1f2937;
        }
        .reports-doctor .doctor-link {
            color: #1d4ed8;
            font-weight: 600;
            text-decoration: none;
        }
        .reports-doctor .doctor-link:hover {
            text-decoration: underline;
        }
        .reports-doctor .doctor-services {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }
        .reports-doctor .doctor-services li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(59, 130, 246, 0.07);
            border-radius: 10px;
            padding: 0.45rem 0.65rem;
            font-size: 0.92rem;
            border: 1px solid rgba(59, 130, 246, 0.18);
        }
        .reports-doctor .doctor-services .service-name {
            font-weight: 600;
            color: #0f172a;
        }
        .reports-doctor .doctor-services .service-count {
            font-weight: 700;
            color: #475569;
        }
        .reports-doctor .doctor-services .service-other {
            color: #475569;
            font-style: italic;
        }
        .reports-doctor .doctor-card-cta {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-weight: 600;
            color: #1d4ed8;
            margin-top: 0.1rem;
        }
        @media (max-width: 767px) {
            .reports-doctor .filter-heading {
                flex-direction: column;
                align-items: flex-start;
            }
            .reports-doctor .doctor-card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.35rem;
            }
            .reports-doctor .doctor-total {
                text-align: left;
            }
        }
    </style>
@endpush
