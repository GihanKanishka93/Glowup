@extends('layouts.app')

@section('content')
    @php
        $subtitle = 'From ' . $startDate . ' to ' . $endDate;
        $vaccineTypes = $vaccinationBreakdown->count();
    @endphp
    <x-list-page title="Vaccination Sales" :back-route="url()->previous()" :subtitle="$subtitle" class="reports-vaccination">
        <div class="report-shell">
            <div class="report-filters">
                <form id="vaccinationSalesForm" action="{{ route('report.vaccination-sales') }}" method="get" class="row g-3">
                    @csrf
                    @method('GET')
                    <div class="col-12">
                        <div class="filter-heading">
                            <div>
                                <h6 class="mb-1">Filter by Date</h6>
                                <p class="text-muted mb-0">Select the window to count vaccinations sold.</p>
                            </div>
                            <div class="filter-actions">
                                <button type="submit" class="btn btn-primary" id="filterBtn">
                                    <i class="fas fa-filter me-1"></i>Apply
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="clearFilters">
                                    <i class="fas fa-undo me-1"></i>Clear
                                </button>
                            </div>
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
                </form>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-3 report-metrics">
                <div class="col">
                    <div class="report-metric-card">
                        <div class="metric-icon">
                            <i class="fas fa-syringe"></i>
                        </div>
                        <div class="metric-copy">
                            <span class="metric-label">Total Vaccinations Sold</span>
                            <span class="metric-value">{{ number_format($totalVaccinations) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="report-metric-card">
                        <div class="metric-icon metric-icon-muted">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="metric-copy">
                            <span class="metric-label">Vaccine Types</span>
                            <span class="metric-value">{{ number_format($vaccineTypes) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 report-table-card">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Vaccinations Sold</h6>
                        <small class="text-muted">Grouped by vaccine name</small>
                    </div>
                    <span class="badge bg-light text-dark">{{ $subtitle }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Vaccine</th>
                                    <th scope="col" class="text-end">Vaccination Entries</th>
                                    <th scope="col" class="text-end">Service Entries</th>
                                    <th scope="col" class="text-end">Total Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($vaccinationBreakdown as $row)
                                    <tr>
                                        <td>{{ $row->name }}</td>
                                        <td class="text-end">{{ number_format($row->vaccination_count ?? 0) }}</td>
                                        <td class="text-end">{{ number_format($row->service_count ?? 0) }}</td>
                                        <td class="text-end fw-semibold">{{ number_format($row->sold_count) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            No vaccinations sold in this period.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-list-page>
@endsection

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.css">
@stop

@section('third_party_scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr('.datepicker', {
                dateFormat: 'Y-m-d',
                allowInput: true,
            });

            const clearBtn = document.getElementById('clearFilters');
            const form = document.getElementById('vaccinationSalesForm');
            const startInput = document.getElementById('start_date');
            const endInput = document.getElementById('end_date');

            clearBtn?.addEventListener('click', () => {
                startInput.value = '';
                endInput.value = '';
                form.submit();
            });
        });
    </script>
@stop

@push('page_styles')
    <style>
        .reports-vaccination .report-shell {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }
        .reports-vaccination .report-filters {
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.35);
            border-radius: 12px;
            padding: 1rem 1.25rem;
        }
        .reports-vaccination .filter-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
        }
        .reports-vaccination .filter-actions {
            display: flex;
            gap: 0.5rem;
        }
        .reports-vaccination .report-metric-card {
            border: 1px solid rgba(148, 163, 184, 0.35);
            border-radius: 12px;
            padding: 1rem;
            display: flex;
            gap: 0.75rem;
            align-items: center;
            background: #fff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }
        .reports-vaccination .metric-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
            font-size: 1.1rem;
        }
        .reports-vaccination .metric-icon-muted {
            background: rgba(100, 116, 139, 0.12);
            color: #475569;
        }
        .reports-vaccination .metric-label {
            display: block;
            font-size: 0.875rem;
            color: #64748b;
        }
        .reports-vaccination .metric-value {
            display: block;
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
        }
        .reports-vaccination .report-table-card .card-header {
            border-bottom: 1px solid rgba(148, 163, 184, 0.35);
        }
    </style>
@endpush
