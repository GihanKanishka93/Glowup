@extends('layouts.app')
@section('content')

    <h1 class="h3 mb-2 text-gray-800">
    </h1>

<div class="pet-profile">
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="{{ route('pet.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-secondary">Registered {{ optional($pet->created_at)->format('d M Y') ?? '—' }}</span>
                    <span class="badge bg-info text-dark">Last Update {{ optional($pet->updated_at)->diffForHumans() ?? '—' }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h5 class="mb-0">Client Snapshot</h5>
                            </div>
                            <div class="card-body">
                                <dl class="row mb-0 small">
                                    <dt class="col-5 text-muted">Client ID</dt>
                                    <dd class="col-7 fw-semibold">{{ $pet->pet_id }}</dd>

                                    <dt class="col-5 text-muted">Name</dt>
                                    <dd class="col-7 fw-semibold text-capitalize">{{ $pet->name }}</dd>

                                    <dt class="col-5 text-muted">Gender</dt>
                                    <dd class="col-7 text-capitalize">{{ $pet->gender == 1 ? 'Male' : 'Female' }}</dd>

                                    <dt class="col-5 text-muted">Date of Birth</dt>
                                    <dd class="col-7">{{ optional($pet->date_of_birth)->format('d M Y') ?? '—' }}</dd>

                                    <dt class="col-5 text-muted">Age at Register</dt>
                                    <dd class="col-7">{{ $pet->age_at_register ?? '—' }}</dd>

                                    <dt class="col-5 text-muted">Current Age</dt>
                                    <dd class="col-7">{{ $pet->current_age ?? '—' }}</dd>

                                    <dt class="col-5 text-muted">Weight</dt>
                                    <dd class="col-7">{{ $pet->weight ? $pet->weight.' kg' : '—' }}</dd>

                                    <dt class="col-5 text-muted">Skin Tone</dt>
                                    <dd class="col-7 text-capitalize">{{ $pet->color ?? '—' }}</dd>

                                    <dt class="col-5 text-muted">Skin Type</dt>
                                    <dd class="col-7">{{ optional($pet->petcategory)->name ?? '—' }}</dd>

                                    <dt class="col-5 text-muted">Skin Concern</dt>
                                    <dd class="col-7">{{ optional($pet->petbreed)->name ?? '—' }}</dd>

                                    <dt class="col-5 text-muted">Remarks</dt>
                                    <dd class="col-7">{{ $pet->remarks ?: 'None recorded' }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h5 class="mb-0">Contact Details</h5>
                            </div>
                            <div class="card-body">
                                <dl class="row mb-0 small">
                                    <dt class="col-5 text-muted">Primary Contact</dt>
                                    <dd class="col-7 fw-semibold">{{ $pet->owner_name ?? '—' }}</dd>

                                    <dt class="col-5 text-muted">Mobile</dt>
                                    <dd class="col-7">{{ $pet->owner_contact ?? '—' }}</dd>

                                    <dt class="col-5 text-muted">WhatsApp</dt>
                                    <dd class="col-7">{{ $pet->owner_whatsapp ?? '—' }}</dd>

                                    <dt class="col-5 text-muted">Email</dt>
                                    <dd class="col-7">{{ $pet->owner_email ?? '—' }}</dd>

                                    <dt class="col-5 text-muted">National ID</dt>
                                    <dd class="col-7">{{ $pet->owner_nic ?? '—' }}</dd>

                                    <dt class="col-5 text-muted">Address</dt>
                                    <dd class="col-7">{{ $pet->owner_address ?? '—' }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Quick Facts</h5>
                                @can('pet-edit')
                                    <a href="{{ route('pet.edit', $pet->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                @endcan
                            </div>
                            <div class="card-body small">
                                <ul class="list-unstyled mb-3">
                                    <li class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Treatments to date</span>
                                        <strong>{{ $treatments->count() }}</strong>
                                    </li>
                                    @php
                                        $lastVisit = $treatments->first();
                                        $lastVisitDate = $lastVisit && $lastVisit->treatment_date
                                            ? \Carbon\Carbon::parse($lastVisit->treatment_date)->format('d M Y')
                                            : '—';
                                        $nextVaccinationLabel = $nextVaccination ? ($nextVaccination->next_vacc_date
                                            ? \Carbon\Carbon::parse($nextVaccination->next_vacc_date)->format('d M Y')
                                            : null) : null;
                                    @endphp
                                    <li class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Last Visit</span>
                                        <strong>{{ $lastVisitDate }}</strong>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="text-muted">Outstanding Bills</span>
                                        <strong>{{ $outstandingBills }}</strong>
                                    </li>
                                </ul>
                                <div class="alert alert-info py-2 px-3 mb-0">
                                    <small class="mb-0 d-block"><strong>Next Follow-up</strong></small>
                                    <small class="text-muted">
                                        {{ $nextVaccination?->vaccine->name ?? 'No follow-up session scheduled' }}
                                        @if($nextVaccinationLabel)
                                            · due {{ $nextVaccinationLabel }}
                                        @endif
                                    </small>
                                </div>
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
                <h5 class="mb-0">Treatment History</h5>
                <a href="{{ route('billing.index', ['search' => $pet->pet_id]) }}" class="btn btn-sm btn-outline-secondary">View Related Bills</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Doctor</th>
                                <th scope="col">Complaint</th>
                                <th scope="col">Observations</th>
                                <th scope="col">Remarks</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($treatments as $treatment)
                                <tr>
                                    <td>{{ $treatment->treatment_date ? \Carbon\Carbon::parse($treatment->treatment_date)->format('d M Y') : '—' }}</td>
                                    <td>{{ optional($treatment->doctor)->name ?? '—' }}</td>
                                    <td>{{ $treatment->history_complaint ?: '—' }}</td>
                                    <td>{{ $treatment->clinical_observation ?: '—' }}</td>
                                    <td>{{ $treatment->remarks ?: '—' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('billing.show', $treatment->bill->id ?? 0) }}" class="btn btn-outline-primary btn-sm" @if(!optional($treatment->bill)->id) disabled @endif>
                                            <i class="fas fa-receipt me-1"></i>Bill
                                        </a>
                                        @if($treatment->id)
                                            <a href="{{ route('medical-history.show', ['id' => $treatment->pet_id]) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-notes-medical"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No treatments recorded yet.</td>
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
        .pet-profile {
            color: var(--text-primary);
        }
        .pet-profile .card,
        .pet-profile .card-body,
        .pet-profile .card-header {
            background-color: var(--surface) !important;
            color: var(--text-primary);
        }
        .pet-profile .card {
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            border-radius: 1rem;
        }
        .pet-profile .card-header {
            border-bottom: 1px solid var(--border);
            padding: 1rem 1.25rem;
        }
        .pet-profile .card-body {
            padding: 1.25rem 1.5rem;
        }
        .pet-profile .badge {
            background-color: rgba(29, 78, 216, 0.12);
            color: var(--primary);
        }
        .pet-profile .badge.bg-info {
            background-color: rgba(14, 165, 233, 0.16) !important;
            color: var(--info-contrast) !important;
        }
        .pet-profile .badge.bg-secondary {
            background-color: rgba(148, 163, 184, 0.18) !important;
            color: var(--text-primary) !important;
        }
        .pet-profile dl dt {
            font-weight: 600;
            color: var(--text-muted);
        }
        .pet-profile dl dd {
            color: var(--text-primary);
        }
        .pet-profile .table {
            margin: 0;
            color: var(--text-primary);
        }
        .pet-profile .table thead th {
            background-color: var(--surface-alt);
            border-bottom: 1px solid var(--border);
            color: var(--text-primary);
        }
        .pet-profile .table tbody tr {
            background-color: var(--surface);
        }
        .pet-profile .table tbody tr:nth-child(odd) {
            background-color: rgba(148, 163, 184, 0.12);
        }
        .pet-profile .table tbody td {
            border-color: var(--border);
        }
        .pet-profile .btn-outline-primary {
            color: var(--primary);
            border-color: var(--border);
        }
        .pet-profile .btn-outline-primary:hover,
        .pet-profile .btn-outline-primary:focus {
            background-color: var(--primary);
            border-color: var(--primary);
            color: var(--primary-contrast);
        }
        .pet-profile .btn-outline-secondary {
            color: var(--text-muted);
            border-color: var(--border);
        }
        .pet-profile .btn-outline-secondary:hover,
        .pet-profile .btn-outline-secondary:focus {
            background-color: rgba(148, 163, 184, 0.16);
            border-color: rgba(148, 163, 184, 0.45);
            color: var(--text-primary);
        }
        .pet-profile .alert-info {
            background-color: rgba(14, 165, 233, 0.12);
            border: 1px solid rgba(14, 165, 233, 0.35);
            color: var(--text-primary);
        }
        .pet-profile .list-unstyled strong {
            color: var(--text-primary);
        }
        .pet-profile .text-muted {
            color: var(--text-muted) !important;
        }
        .pet-profile .card.shadow-sm {
            box-shadow: var(--shadow-sm) !important;
        }
    </style>
@endpush
