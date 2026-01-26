@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-2 text-gray-800"></h1>

    <div class="doctor-profile">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="{{ route('doctor.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <span class="badge bg-secondary">
                                Joined {{ optional($doctor->created_at)->format('d M Y') ?? '—' }}
                            </span>
                            <span class="badge bg-info text-dark">
                                Last Active {{ $lastActiveDate?->diffForHumans() ?? 'No treatments yet' }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-lg-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-white border-0">
                                        <h5 class="mb-0">Doctor Overview</h5>
                                    </div>
                                    <div class="card-body">
                                        <dl class="row mb-0 small">
                                            <dt class="col-5 text-muted">Doctor ID</dt>
                                            <dd class="col-7 fw-semibold text-uppercase">{{ $doctor->doctor_id }}</dd>

                                            <dt class="col-5 text-muted">Name</dt>
                                            <dd class="col-7 fw-semibold">{{ $doctor->name }}</dd>

                                            <dt class="col-5 text-muted">Gender</dt>
                                            <dd class="col-7 text-capitalize">{{ $doctor->gender == 1 ? 'Male' : 'Female' }}
                                            </dd>

                                            <dt class="col-5 text-muted">Designation</dt>
                                            <dd class="col-7">{{ $doctor->designation ?? '—' }}</dd>

                                            <dt class="col-5 text-muted">Status</dt>
                                            <dd class="col-7">
                                                <span class="badge bg-success-subtle text-success">Active</span>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-white border-0">
                                        <h5 class="mb-0">Contact & Logistics</h5>
                                    </div>
                                    <div class="card-body">
                                        <dl class="row mb-0 small">
                                            <dt class="col-5 text-muted">Phone</dt>
                                            <dd class="col-7">{{ $doctor->contact_no ?? '—' }}</dd>

                                            <dt class="col-5 text-muted">Email</dt>
                                            <dd class="col-7">{{ $doctor->email ?? '—' }}</dd>

                                            <dt class="col-5 text-muted">Address</dt>
                                            <dd class="col-7">{{ $doctor->address ?? '—' }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div
                                        class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Practice Snapshot</h5>
                                        @can('doctor-edit')
                                            <a href="{{ route('doctor.edit', $doctor->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit me-1"></i>Edit
                                            </a>
                                        @endcan
                                    </div>
                                    <div class="card-body small">
                                        <ul class="list-unstyled mb-3">
                                            <li class="d-flex justify-content-between mb-2">
                                                <span class="text-muted">Patients served</span>
                                                <strong>{{ $patientsServed }}</strong>
                                            </li>
                                            <li class="d-flex justify-content-between mb-2">
                                                <span class="text-muted">Total treatments</span>
                                                <strong>{{ $totalTreatments }}</strong>
                                            </li>
                                            <li class="d-flex justify-content-between mb-2">
                                                <span class="text-muted">Outstanding bills</span>
                                                <strong>{{ $outstandingBills }}</strong>
                                            </li>
                                            @php
                                                $nextFollowUpPet = $upcomingFollowUp?->patient?->name;
                                            @endphp
                                            <li class="d-flex justify-content-between">
                                                <span class="text-muted">Next follow-up</span>
                                                <strong>{{ $nextFollowUpDate?->format('d M Y') ?? 'None scheduled' }}</strong>
                                            </li>
                                        </ul>
                                        @if($nextFollowUpPet)
                                            <div class="alert alert-info py-2 px-3 mb-0">
                                                <small class="d-block"><strong>{{ $nextFollowUpPet }}</strong></small>
                                                <small class="text-muted">Upcoming follow-up</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Cases</h5>
                        <a href="{{ route('billing.index', ['search' => $doctor->doctor_id]) }}"
                            class="btn btn-sm btn-outline-secondary">View Billing Ledger</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Patient</th>
                                        <th scope="col">Complaint</th>
                                        <th scope="col">Next Visit</th>
                                        <th scope="col">Bill</th>
                                        <th scope="col" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($treatments as $treatment)
                                        <tr>
                                            <td>{{ $treatment->formatted_treatment_date ?? '—' }}</td>
                                            <td>{{ optional($treatment->patient)->name ?? '—' }}</td>
                                            <td>{{ $treatment->history_complaint ?: '—' }}</td>
                                            <td>{{ $treatment->formatted_next_visit ?? '—' }}</td>
                                            <td>
                                                @if($treatment->bill)
                                                    {{ optional($treatment->bill)->bill_no ?? '—' }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @if($treatment->bill)
                                                    <a href="{{ route('billing.show', $treatment->bill->id) }}"
                                                        class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-receipt me-1"></i>Bill
                                                    </a>
                                                @endif
                                                @if($treatment->patient_id)
                                                    <a href="{{ route('patient.show', $treatment->patient_id) }}"
                                                        class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-user me-1"></i>Client
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No treatments recorded for this
                                                doctor yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .doctor-profile {
            --surface: #ffffff;
            --surface-alt: #f8fafc;
            --text-primary: #1f2937;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --shadow-sm: 0 12px 24px rgba(15, 23, 42, 0.06);
            color: var(--text-primary);
        }

        .doctor-profile .card,
        .doctor-profile .card-body,
        .doctor-profile .card-header {
            background-color: var(--surface) !important;
            color: var(--text-primary);
        }

        .doctor-profile .card {
            border: 1px solid var(--border);
            border-radius: 1rem;
            box-shadow: var(--shadow-sm);
        }

        .doctor-profile .card-header {
            border-bottom: 1px solid var(--border);
            padding: 1rem 1.25rem;
        }

        .doctor-profile .card-body {
            padding: 1.25rem 1.5rem;
        }

        .doctor-profile dl dt {
            color: var(--text-muted);
            font-weight: 600;
        }

        .doctor-profile dl dd {
            color: var(--text-primary);
        }

        .doctor-profile .badge {
            background-color: rgba(29, 78, 216, 0.12);
            color: var(--primary);
        }

        .doctor-profile .badge.bg-info {
            background-color: rgba(14, 165, 233, 0.16) !important;
            color: var(--info-contrast) !important;
        }

        .doctor-profile .badge.bg-secondary {
            background-color: rgba(148, 163, 184, 0.18) !important;
            color: var(--text-primary) !important;
        }

        .doctor-profile .badge.bg-success-subtle {
            background-color: rgba(16, 185, 129, 0.16);
            color: var(--success);
        }

        .doctor-profile .table thead th {
            background-color: var(--surface-alt);
            border-bottom: 1px solid var(--border);
            color: var(--text-primary);
        }

        .doctor-profile .table tbody tr:nth-child(odd) {
            background-color: rgba(148, 163, 184, 0.12);
        }

        .doctor-profile .table tbody td {
            border-color: var(--border);
        }

        .doctor-profile .btn-outline-primary {
            color: var(--primary);
            border-color: var(--border);
        }

        .doctor-profile .btn-outline-primary:hover,
        .doctor-profile .btn-outline-primary:focus {
            background-color: var(--primary);
            border-color: var(--primary);
            color: var(--primary-contrast);
        }

        .doctor-profile .btn-outline-secondary {
            color: var(--text-muted);
            border-color: var(--border);
        }

        .doctor-profile .btn-outline-secondary:hover,
        .doctor-profile .btn-outline-secondary:focus {
            background-color: rgba(148, 163, 184, 0.16);
            border-color: rgba(148, 163, 184, 0.45);
            color: var(--text-primary);
        }

        .doctor-profile .alert-info {
            background-color: rgba(14, 165, 233, 0.12);
            border: 1px solid rgba(14, 165, 233, 0.35);
            color: var(--text-primary);
        }
    </style>
@endpush