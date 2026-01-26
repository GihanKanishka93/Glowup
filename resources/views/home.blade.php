@extends('layouts.app')

@section('content')
    <style>
        .dashboard-container {
            padding: 1.5rem;
        }

        .stat-card {
            border: none;
            border-radius: 16px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .activity-item {
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
        }

        .activity-item:hover {
            background-color: rgba(var(--primary-rgb), 0.03);
            border-left-color: var(--primary);
        }

        body.theme-dark .stat-card {
            background-color: var(--surface) !important;
            border: 1px solid var(--border) !important;
        }

        body.theme-dark .text-dark {
            color: var(--text) !important;
        }
    </style>

    <div class="dashboard-container container-fluid">
        <!-- Header Section -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-1 text-dark fw-bold">Clinic Intelligence Center</h1>
                <p class="text-muted mb-0">Operational overview for {{ now()->format('l, jS F Y') }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('billing.create') }}"
                    class="btn btn-primary d-none d-md-flex align-items-center gap-2 px-4 shadow-sm">
                    <i class="fas fa-plus"></i>
                    <span>New Billing</span>
                </a>
            </div>
        </div>

        <!-- Metrics Row -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon bg-primary-subtle text-primary">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small text-uppercase fw-bold mb-1">Total Patients</h6>
                                <h3 class="text-dark fw-bold mb-0">{{ number_format($stats['totalPatients'] ?? 0) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card stat-card shadow-sm h-100 border-start border-success border-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon bg-success-subtle text-success">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small text-uppercase fw-bold mb-1">Today's Revenue</h6>
                                <h3 class="text-dark fw-bold mb-0">Rs {{ number_format($stats['todayRevenue'] ?? 0, 0) }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon bg-info-subtle text-info">
                                <i class="fas fa-stethoscope"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small text-uppercase fw-bold mb-1">Consultations Today</h6>
                                <h3 class="text-dark fw-bold mb-0">{{ number_format($stats['todayConsultations'] ?? 0) }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon bg-warning-subtle text-warning">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small text-uppercase fw-bold mb-1">New Patients Today</h6>
                                <h3 class="text-dark fw-bold mb-0">{{ number_format($stats['newPatientsToday'] ?? 0) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Main Content: Activity Feed -->
            <div class="col-12 col-xl-8">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 16px;">
                    <div class="card-header bg-transparent border-0 py-4 px-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0 text-dark fw-bold">Recent Clinical Activity</h5>
                            <a href="{{ route('billing.index') }}"
                                class="btn btn-link text-primary fw-bold text-decoration-none p-0">View All</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if(count($recentActivity) > 0)
                            <div class="list-group list-group-flush">
                                @foreach($recentActivity as $bill)
                                    <div class="list-group-item activity-item py-4 px-4 border-0">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-wrapper">
                                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 48px; height: 48px;">
                                                        <i class="fas fa-file-invoice-dollar text-muted"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 text-dark fw-bold">
                                                        {{ $bill->treatment->patient->name ?? 'Unknown Patient' }}</h6>
                                                    <span class="text-muted small">
                                                        Bill #{{ $bill->billing_id }} • {{ $bill->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <h6 class="mb-0 text-dark fw-bold">Rs {{ number_format($bill->total, 2) }}</h6>
                                                <span
                                                    class="badge {{ $bill->payment_status == 1 ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} rounded-pill small">
                                                    {{ $bill->payment_status == 1 ? 'Paid' : 'Unpaid' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-ghost fa-3x text-light mb-3" style="opacity: 0.2"></i>
                                <h6 class="text-muted">No recent activity detected.</h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Content -->
            <div class="col-12 col-xl-4">
                <div class="d-flex flex-column gap-4">
                    <!-- Dashboard Stock Alerts -->
                    @include('billing.partials.stock-alerts')

                    <!-- Quick Navigation -->
                    <div class="card shadow-sm border-0"
                        style="border-radius: 16px; background: linear-gradient(135deg, #1c0442, #7b7ab7);">
                        <div class="card-body p-4">
                            <h6 class="text-white fw-bold mb-3">Quick Navigation</h6>
                            <div class="d-grid gap-2">
                                <a href="{{ route('patient.index') }}"
                                    class="btn btn-white text-dark fw-bold border-0 shadow-sm"
                                    style="background: rgba(255,255,255,0.9);">
                                    <i class="fas fa-users me-2"></i> Patient Directory
                                </a>
                                <a href="{{ route('doctor.index') }}"
                                    class="btn btn-white text-dark fw-bold border-0 shadow-sm"
                                    style="background: rgba(255,255,255,0.9);">
                                    <i class="fas fa-user-md me-2"></i> Specialist List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection