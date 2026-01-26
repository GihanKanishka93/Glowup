@extends('layouts.app')

@section('content')
    <x-list-page title="Billing Queue" subtitle="Focused view for payment & printing" class="cashier-dashboard">
        @php
            $readyCount = $metrics['ready_to_print'] ?? 0;
            $newCount = $metrics['new_bills'] ?? 0;
            $printedToday = $metrics['printed_today'] ?? 0;
            $outstanding = $metrics['outstanding_total'] ?? 0;
            $cashToday = $metrics['cash_collected_today'] ?? 0;
        @endphp
        <x-slot:actions>
            @can('bill-create')
                <a href="{{ route('billing.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>New Bill
                </a>
            @endcan
        </x-slot:actions>
        <div class="cashier-shell">
            <div class="row g-3">
                <div class="col-12 col-xl-3 col-md-6">
                    <div class="metric-card metric-ready">
                        <div class="metric-icon"><i class="fas fa-receipt"></i></div>
                        <div class="metric-copy">
                            <span class="metric-label">Ready To Print</span>
                            <span class="metric-value">{{ number_format($readyCount) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-3 col-md-6">
                    <div class="metric-card metric-new">
                        <div class="metric-icon"><i class="fas fa-bolt"></i></div>
                        <div class="metric-copy">
                            <span class="metric-label">New Bills (1 hr)</span>
                            <span class="metric-value">{{ number_format($newCount) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-3 col-md-6">
                    <div class="metric-card metric-printed">
                        <div class="metric-icon"><i class="fas fa-print"></i></div>
                        <div class="metric-copy">
                            <span class="metric-label">Printed Today</span>
                            <span class="metric-value">{{ number_format($printedToday) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-3 col-md-6">
                    <div class="metric-card metric-outstanding">
                        <div class="metric-icon"><i class="fas fa-wallet"></i></div>
                        <div class="metric-copy">
                            <span class="metric-label">Outstanding Balance</span>
                            <span class="metric-value">{{ number_format($outstanding, 2) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-3 col-md-6">
                    <div class="metric-card metric-cash subtle">
                        <div class="metric-icon"><i class="fas fa-coins"></i></div>
                        <div class="metric-copy">
                            <span class="metric-label">Cash Collected Today</span>
                            <span class="metric-value">{{ number_format($cashToday, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-xl-4">
                    <div class="card queue-card shadow-sm border-0 h-100">
                        <div class="card-header border-0 d-flex align-items-center justify-content-between">
                            <h6 class="mb-0">Ready To Print</h6>
                            <span class="badge rounded-pill text-bg-secondary">{{ $queueBills->count() }}</span>
                        </div>
                        <div class="card-body">
                            <ul class="cashier-queue list-unstyled mb-0">
                                @forelse($queueBills as $bill)
                                    <li class="cashier-queue-item {{ $bill->is_new ? 'is-new' : '' }}">
                                        <div class="queue-meta">
                                            <div class="queue-title">{{ $bill->billing_id }}</div>
                                            <div class="queue-subtitle">
                                                {{ $bill->treatment->patient->name ?? 'Unknown' }} ·
                                                {{ $bill->treatment->doctor->name ?? 'Doctor N/A' }}
                                                @if($bill->is_new)
                                                    <span class="badge queue-badge-new">New</span>
                                                @endif
                                            </div>
                                            <div class="queue-foot">
                                                {{ \Illuminate\Support\Carbon::parse($bill->billing_date)->format('d M Y') }} ·
                                                {{ number_format($bill->total ?? 0, 2) }}</div>
                                        </div>
                                        <div class="queue-actions btn-group">
                                            <a href="{{ route('billing.show', $bill->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Open bill">
                                                <i class="fas fa-folder-open"></i>
                                            </a>
                                            <a href="{{ route('billing.print', ['id' => $bill->id]) }}" target="_blank"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-print me-1"></i>Print
                                            </a>
                                            <form action="{{ route('billing.email', $bill->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm text-dark"
                                                    title="Email bill to owner">
                                                    <i class="fas fa-envelope"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @empty
                                    <li class="cashier-queue-item empty">No pending bills right now.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    <div class="card shadow-sm border-0 h-100 cashier-history-card">
                        <div class="card-header border-0 d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <h6 class="mb-0">Billing History</h6>
                            <div class="btn-group cashier-filter" role="group" aria-label="Filter bills">
                                <button type="button" class="btn btn-outline-primary btn-sm active"
                                    data-filter="ready">Ready to Print</button>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-filter="new">New</button>
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                    data-filter="printed">Printed</button>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-filter="unpaid">Awaiting
                                    Payment</button>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-filter="all">All</button>
                            </div>
                        </div>
                        <div class="card-body">
                            {!! $dataTable->table(['class' => 'table table-hover align-middle w-100', 'style' => 'width:100%'], true) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-list-page>
@endsection

@section('third_party_stylesheets')
<link href="{{ asset('plugin/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">
@stop

@section('third_party_scripts')
    <script src="{{ asset('plugin/datatable/jquery.dataTables.min.js') }}"></script>
    {!! $dataTable->scripts() !!}
@endsection

@push('styles')
    <style>
        .cashier-dashboard .list-toolbar {
            background: var(--surface);
            border-color: rgba(148, 163, 184, 0.3);
            box-shadow: var(--shadow-sm);
        }

        .cashier-dashboard .list-card {
            background: transparent;
            border: none;
            box-shadow: none;
        }

        .cashier-dashboard .list-card .card-body {
            padding: 0;
            background: transparent;
        }

        .cashier-shell {
            background: var(--surface);
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 1.25rem;
            padding: 1.75rem 1.75rem 1.5rem;
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.08);
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        body.theme-dark .cashier-shell {
            border-color: rgba(71, 85, 105, 0.45);
        }

        .cashier-dashboard .metric-card {
            display: flex;
            align-items: center;
            gap: .85rem;
            background: var(--surface);
            border-radius: 1rem;
            padding: 1.1rem 1.35rem;
            border: 1px solid rgba(148, 163, 184, 0.25);
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
        }

        .cashier-dashboard .metric-card .metric-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(29, 78, 216, 0.12);
            color: var(--primary);
            font-size: 1.1rem;
        }

        .cashier-dashboard .metric-card .metric-copy {
            display: flex;
            flex-direction: column;
            gap: .2rem;
        }

        .cashier-dashboard .metric-card .metric-label {
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--text-muted);
            font-weight: 600;
        }

        .cashier-dashboard .metric-card .metric-value {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .cashier-dashboard .metric-card.metric-ready .metric-icon {
            background: rgba(37, 99, 235, 0.12);
            color: var(--primary);
        }

        .cashier-dashboard .metric-card.metric-new .metric-icon {
            background: rgba(249, 115, 22, 0.12);
            color: #f97316;
        }

        .cashier-dashboard .metric-card.metric-printed .metric-icon {
            background: rgba(16, 185, 129, 0.12);
            color: #0f9f6d;
        }

        .cashier-dashboard .metric-card.metric-outstanding .metric-icon {
            background: rgba(78, 205, 196, 0.12);
            color: #0f766e;
        }

        .cashier-dashboard .metric-card.metric-cash .metric-icon {
            background: rgba(45, 212, 191, 0.12);
            color: #0d9488;
        }

        .queue-card {
            background: var(--surface);
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 1rem;
            box-shadow: var(--shadow-sm);
        }

        .queue-card .card-header {
            background: rgba(59, 130, 246, 0.08);
            color: var(--text-primary);
            border-radius: 1rem 1rem 0 0;
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        }

        .queue-card .card-body {
            padding: 1.25rem;
        }

        .cashier-queue {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }

        .cashier-queue-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.9rem 1rem;
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 0.9rem;
            background: var(--surface-alt);
            box-shadow: var(--shadow-sm);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .cashier-queue-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
        }

        .cashier-queue-item.empty {
            justify-content: center;
            color: var(--text-muted);
            font-style: italic;
        }

        .queue-meta {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .queue-title {
            font-weight: 700;
            color: var(--text-primary);
        }

        .queue-subtitle {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .queue-foot {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .queue-actions .btn {
            border-radius: 0.6rem;
        }

        .cashier-queue-item.is-new {
            border-color: rgba(37, 99, 235, 0.45);
            background: linear-gradient(130deg, rgba(59, 130, 246, 0.12), rgba(59, 130, 246, 0.22));
            box-shadow: 0 12px 24px rgba(30, 64, 175, 0.15);
        }

        .queue-badge-new {
            background: linear-gradient(135deg, #f97316, #f59e0b);
            color: #ffffff;
            font-size: 0.65rem;
            margin-left: .5rem;
        }

        .cashier-filter .btn {
            border-radius: 999px !important;
            border-color: rgba(148, 163, 184, 0.4);
            color: var(--text-primary);
        }

        .cashier-filter .btn.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            border-color: transparent;
            color: #fff;
        }

        .cashier-history-card {
            background: var(--surface);
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.25);
        }

        .cashier-history-card .card-header {
            background: rgba(59, 130, 246, 0.08);
            border-radius: 1rem 1rem 0 0;
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('.cashier-filter button');
            const tableName = 'billing-table';
            const filterMap = {
                ready: 'Ready',
                new: 'New',
                printed: 'Printed',
                unpaid: 'Unpaid',
                all: ''
            };

            const setActive = (target) => {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                if (target) {
                    target.classList.add('active');
                }
            };

            const applyFilter = (key) => {
                const term = filterMap[key] ?? '';
                const tableInstance = window.LaravelDataTables ? window.LaravelDataTables[tableName] : null;
                if (tableInstance) {
                    const statusColumnIndex = 6; // status column index
                    tableInstance.column(statusColumnIndex).search(term, false, false).draw();
                }
            };

            filterButtons.forEach(button => {
                button.addEventListener('click', function () {
                    setActive(this);
                    applyFilter(this.dataset.filter);
                });
            });

            // Apply default filter after table initialises
            const waitForTable = () => {
                const tableInstance = window.LaravelDataTables ? window.LaravelDataTables[tableName] : null;
                if (tableInstance) {
                    applyFilter('ready');
                } else {
                    setTimeout(waitForTable, 150);
                }
            };

            waitForTable();
        });
    </script>
@endpush