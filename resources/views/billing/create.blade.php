@extends('layouts.app')
@section('content')
<div class="billing-dashboard container-fluid">
    <div class="row g-4 align-items-start billing-grid">
        <div class="col-12 col-xl-4 col-xxl-3 insight-column d-flex flex-column gap-4">
            @include('billing.partials.metrics')
            @include('billing.partials.upcoming-vaccinations')
            @include('billing.partials.recent-bills')
        </div>
        <div class="col-12 col-xl-8 col-xxl-9 workspace-column">
            <div class="card shadow-sm billing-workspace">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                        <div>
                            <h1 class="h4 mb-0 text-dark">In-Clinic Billing Workspace</h1>
                        </div>
                        <div class="bill-history" style="display: none;">
                            <a href="#" target="_blank" class="btn btn-primary btn-icon-split medical-history-btn" data-template="{{ route('medical-history.show', ['id' => 'PLACEHOLDER']) }}">
                                <span class="icon text-white-50">
                                    <i class="fas fa-notes-medical"></i>
                                </span>
                                <span class="text">Medical History</span>
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('billing.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="row g-4">
                        <div class="col-12 col-xxl-8">
                            <div class="billing-flow mb-4">
                                <nav class="billing-section-nav" aria-label="Billing sections">
                                    <a class="billing-nav-link is-current" href="#billing-section-patient">
                                        <span class="billing-nav-icon"><i class="fas fa-user"></i></span>
                                        Patient
                                    </a>
                                    <a class="billing-nav-link" href="#billing-section-clinical">
                                        <span class="billing-nav-icon"><i class="fas fa-stethoscope"></i></span>
                                        Clinical Notes
                                    </a>
                                    <a class="billing-nav-link" href="#billing-section-medication">
                                        <span class="billing-nav-icon"><i class="fas fa-pills"></i></span>
                                        Medication & Services
                                    </a>
                                    <a class="billing-nav-link" href="#billing-section-billing">
                                        <span class="billing-nav-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                                        Billing Summary
                                    </a>
                                </nav>
                                <div class="billing-sections">
                                <div id="billing-section-patient" class="billing-section">
                                    <h6 class="panel-title">Patient Snapshot</h6>
                                    <div class="panel-body">
                                        <div class="row g-3 patient-snapshot-grid">
                                            <x-forms.pet-selector
                                                :pets="$pets"
                                                column-class="col-12 col-lg-6"
                                                id="pet"
                                                name="pet"
                                                required
                                            />
                                            <div class="col-12 col-lg-6">
                                                <label for="doctor" class="form-label fw-semibold">
                                                    Doctor <span class="text-danger">*</span>
                                                </label>
                                                <select
                                                    name="doctor"
                                                    id="doctor"
                                                    class="select2 form-select @error('doctor') is-invalid @enderror"
                                                >
                                                    <option value=""></option>
                                                    @foreach ($doctors as $item)
                                                        <option value="{{ $item->id }}" @selected(old('doctor', Auth::user()->doc_id) == $item->id)>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('doctor')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-xl-3">
                                                <label for="pet_id" class="form-label fw-semibold">Client ID</label>
                                                <input
                                                    type="text"
                                                    class="form-control @error('pet_id') is-invalid @enderror"
                                                    id="pet_id"
                                                    name="pet_id"
                                                    value="{{ old('pet_id') }}"
                                                    readonly
                                                >
                                                @error('pet_id')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-xl-3">
                                                <label for="pet_name" class="form-label fw-semibold">
                                                    Client Name <span class="text-danger">*</span>
                                                </label>
                                                <input
                                                    type="text"
                                                    class="form-control @error('pet_name') is-invalid @enderror"
                                                    id="pet_name"
                                                    name="pet_name"
                                                    value="{{ old('pet_name') }}"
                                                >
                                                @error('pet_name')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-xl-3">
                                                <label for="date_of_birth" class="form-label fw-semibold">Date of Birth</label>
                                                <input
                                                    type="date"
                                                    class="form-control @error('date_of_birth') is-invalid @enderror"
                                                    id="date_of_birth"
                                                    name="date_of_birth"
                                                    value="{{ old('date_of_birth') }}"
                                                    max="{{ date('Y-m-d') }}"
                                                >
                                                @error('date_of_birth')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-xl-3">
                                                <label for="age" class="form-label fw-semibold">Age</label>
                                                <input
                                                    type="text"
                                                    class="form-control @error('age') is-invalid @enderror"
                                                    id="age"
                                                    name="age"
                                                    value="{{ old('age') }}"
                                                >
                                                @error('age')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-lg-4 mt-lg-2">
                                                <label for="pet_category" class="form-label fw-semibold">Skin Type</label>
                                                <select
                                                    name="pet_category"
                                                    id="pet_category"
                                                    class="select2 form-select @error('pet_category') is-invalid @enderror"
                                                    onchange="fetchVaccinations(this.value);"
                                                >
                                                    <option value=""></option>
                                                    @foreach ($petcategory as $item)
                                                        <option value="{{ $item->id }}" @selected(old('pet_category') == $item->id)>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('pet_category')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-lg-4 mt-lg-2">
                                                <label for="breed" class="form-label fw-semibold">Skin Concern</label>
                                                <select
                                                    name="breed"
                                                    id="breed"
                                                    class="select2 form-select @error('breed') is-invalid @enderror"
                                                >
                                                    <option value=""></option>
                                                    @foreach ($breed as $item)
                                                        <option value="{{ $item->id }}" @selected(old('breed') == $item->id)>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('breed')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-lg-4 mt-lg-2">
                                                <label for="gender" class="form-label fw-semibold">Gender</label>
                                                <select
                                                    name="gender"
                                                    id="gender"
                                                    class="select2 form-select @error('gender') is-invalid @enderror"
                                                >
                                                    <option value=""></option>
                                                    <option value="1" @selected(old('gender') == 1)>Male</option>
                                                    <option value="2" @selected(old('gender') == 2)>Female</option>
                                                </select>
                                                @error('gender')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="weight" class="form-label fw-semibold">Weight</label>
                                                <input
                                                    type="text"
                                                    class="form-control @error('weight') is-invalid @enderror"
                                                    id="weight"
                                                    name="weight"
                                                    value="{{ old('weight') }}"
                                                >
                                                @error('weight')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="colour" class="form-label fw-semibold">Colour</label>
                                                <input
                                                    type="text"
                                                    class="form-control @error('colour') is-invalid @enderror"
                                                    id="colour"
                                                    name="colour"
                                                    value="{{ old('colour') }}"
                                                >
                                                @error('colour')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="remarks" class="form-label fw-semibold">Remarks</label>
                                                <textarea
                                                    class="form-control @error('remarks') is-invalid @enderror"
                                                    id="remarks"
                                                    name="remarks"
                                                    rows="1"
                                                >{{ old('remarks') }}</textarea>
                                                @error('remarks')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="panel-divider"></div>
                                        <h6 class="panel-subtitle mt-3">Owner Information</h6>
                                        <div class="row g-3 patient-snapshot-grid">
                                            <div class="col-12 col-lg-6">
                                                <label for="owner_name" class="form-label fw-semibold">Name</label>
                                                <input
                                                    type="text"
                                                    class="form-control @error('owner_name') is-invalid @enderror"
                                                    id="owner_name"
                                                    name="owner_name"
                                                    value="{{ old('owner_name') }}"
                                                >
                                                @error('owner_name')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <x-forms.owner-contact
                                                id="owner_contact"
                                                name="owner_contact"
                                                :value="old('owner_contact')"
                                                column-class="col-12 col-lg-6"
                                            />
                                            <x-forms.owner-contact
                                                id="owner_whatsapp"
                                                name="owner_whatsapp"
                                                label="WhatsApp Number"
                                                :value="old('owner_whatsapp', '+94 ')"
                                                placeholder="+94 7X XXX XXXX"
                                                column-class="col-12 col-lg-6"
                                            />
                                            <div class="col-12 col-lg-6">
                                                <label for="owner_email" class="form-label fw-semibold">Email</label>
                                                <input
                                                    type="email"
                                                    class="form-control @error('owner_email') is-invalid @enderror"
                                                    id="owner_email"
                                                    name="owner_email"
                                                    value="{{ old('owner_email') }}"
                                                    placeholder="owner@example.com"
                                                >
                                                @error('owner_email')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="address" class="form-label fw-semibold">Address</label>
                                                <textarea
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    id="address"
                                                    name="address"
                                                    rows="2"
                                                >{{ old('address') }}</textarea>
                                                @error('address')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-2">
                                            <button type="button" class="btn btn-outline-primary d-inline-flex align-items-center gap-2" id="savePetDetailsBtn">
                                                <i class="fas fa-save"></i>
                                                <span>Save client details</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="billing-section-clinical" class="billing-section">
                                    <h6 class="panel-title">Clinical Notes</h6>
                                    <div class="panel-body">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="history" class="form-label fw-semibold">History / Complaint</label>
                                                <textarea
                                                    class="form-control @error('history') is-invalid @enderror"
                                                    id="history"
                                                    name="history"
                                                    rows="3"
                                                >{{ old('history') }}</textarea>
                                                @error('history')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="observation" class="form-label fw-semibold">Clinical Observation</label>
                                                <textarea
                                                    class="form-control @error('observation') is-invalid @enderror"
                                                    id="observation"
                                                    name="observation"
                                                    rows="3"
                                                >{{ old('observation') }}</textarea>
                                                @error('observation')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="remarks_t" class="form-label fw-semibold">Treatment Remarks</label>
                                                <textarea
                                                    class="form-control @error('remarks_t') is-invalid @enderror"
                                                    id="remarks_t"
                                                    name="remarks_t"
                                                    rows="3"
                                                >{{ old('remarks_t') }}</textarea>
                                                @error('remarks_t')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="billing-section-medication" class="billing-section">
                                    <h6 class="panel-title">Prescription & Vaccination</h6>
                                    <div class="panel-body">
                                        <h6 class="panel-subtitle">Prescription</h6>
                                        <div id="prescription" class="row g-3">
                                            <div class="col-12">
                                                <div class="row g-3 px-2">
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold text-uppercase small">Drug Name</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label fw-semibold text-uppercase small">Dose</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label fw-semibold text-uppercase small">Dosage</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label fw-semibold text-uppercase small">Duration</label>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                            </div>
                                            <div class="prescription-details col-12 base-prescription-row">
                                                <div class="row g-3 align-items-center prescription-row">
                                                    <div class="col-md-4">
                                                        <select name="drug_name[]" id="drug_name" class="select2 form-select drug_items @error('drug_name') is-invalid @enderror">
                                                            <option value=""></option>
                                                            @foreach ($drugs as $item)
                                                                <option value="{{ $item->name }}" @selected(old('drug_name') == $item->name)>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="dosage[]" id="dosage" class="select2 form-select dosage_types @error('dosage') is-invalid @enderror">
                                                            <option value=""></option>
                                                            @foreach ($dosagetypes as $item)
                                                                <option value="{{ $item->name }}" @selected(old('dosage') == $item->name)>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select name="dose[]" id="dose" class="select2 form-select duration_types @error('dose') is-invalid @enderror">
                                                            <option value=""></option>
                                                            @foreach ($dose as $item)
                                                                <option value="{{ $item->name }}" @selected(old('dose') == $item->name)>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="duration[]" id="duration" class="select2 form-select duration_types @error('duration') is-invalid @enderror">
                                                            <option value=""></option>
                                                            @foreach ($durationtypes as $item)
                                                                <option value="{{ $item->name }}" @selected(old('duration') == $item->name)>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1 d-flex justify-content-md-center gap-2 flex-nowrap prescription-actions">
                                                        <button type="button" class="btn btn-success btn-sm btn-icon-split" id="addPrescription">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm btn-icon-split ms-2 remove-prescription-row" title="Remove prescription row">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-trash"></i>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-divider"></div>
                                        <h6 class="panel-subtitle">Vaccination</h6>
                                        <div id="vaccination" class="row g-3">
                                            <div class="col-12">
                                                <div class="row g-3 px-2">
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold text-uppercase small">Vaccine Name</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label fw-semibold text-uppercase small">Next Vaccination Date</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label fw-semibold text-uppercase small">Interval</label>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                            </div>
                                            <div class="vaccination-details col-12 base-vaccination-row">
                                                <div class="row g-3 align-items-center vaccination-row">
                                                    <div class="col-md-4">
                                                        <select name="vaccine_name[]" id="vaccine_name" class="select2 form-select vaccine_item @error('vaccine_name') is-invalid @enderror">
                                                            <option value=""></option>
                                                            @foreach ($vaccine as $item)
                                                                <option value="{{ $item->id }}" data-price="{{ $item->price }}" @selected(old('vaccine_name') == $item->id)>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control datetimepicker" name="vacc_duration[]" value="{{ date('Y-m-d') }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select name="next_vacc_weeks[]" id="next_vacc_weeks" class="select2 form-select vaccine_item durationweek-width @error('next_vacc_weeks') is-invalid @enderror">
                                                            <option value="">Duration Slots</option>
                                                            @foreach ($durationweeks as $item)
                                                                <option value="{{ $item->name }}" @selected(old('next_treatment_weeks') == $item->name)>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1 d-flex justify-content-md-center gap-2 flex-nowrap vaccination-actions">
                                                        <button type="button" class="btn btn-success btn-sm btn-icon-split" id="addVaccination">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm btn-icon-split ms-2 remove-vaccination-row" title="Remove vaccination row">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-trash"></i>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-3 align-items-end mt-3">
                                            <div class="col-12 col-lg-4">
                                                <label for="next_treatment_date" class="form-label fw-semibold">Next Treatment Date</label>
                                                <input
                                                    type="text"
                                                    class="form-control datetimepicker @error('next_treatment_date') is-invalid @enderror"
                                                    id="next_treatment_date"
                                                    name="next_treatment_date"
                                                    step="60"
                                                    value="{{ old('next_treatment_date') }}"
                                                    placeholder="Select when follow-up is needed"
                                                >
                                                <div class="form-text">Select when follow-up is needed.</div>
                                                @error('next_treatment_date')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label class="form-label fw-semibold d-block">Recommended Interval</label>
                                                <div id="duration-weeks" class="radio-button-group">
                                                    @foreach ($durationweeks as $item)
                                                        <label class="radio-button">
                                                            <input type="radio" name="next_treatment_weeks" value="{{ $item->name }}" @checked(old('next_treatment_weeks') == $item->name)>
                                                            <span>{{ $item->name }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="billing_date" class="form-label fw-semibold">Billing Date</label>
                                                <input
                                                    type="text"
                                                    class="form-control datetimepicker @error('billing_date') is-invalid @enderror"
                                                    id="billing_date"
                                                    name="billing_date"
                                                    step="60"
                                                    value="{{ Date('Y-m-d') }}"
                                                >
                                                @error('billing_date')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="billing-section-billing" class="billing-section">
                                    <h6 class="panel-title">Billing & Checkout</h6>
                                    <div class="panel-body">
                                        <h6 class="panel-subtitle">Billable Services</h6>
                                        <div class="row g-3 px-2">
                                            <div class="col-md-4">
                                                <span class="form-label fw-semibold text-uppercase small">Service Name</span>
                                            </div>
        
                                            <div class="col-md-1">
                                                <span class="form-label fw-semibold text-uppercase small">Qty</span>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="form-label fw-semibold text-uppercase small">Unit Price</span>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="form-label fw-semibold text-uppercase small">Discount (%)</span>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="form-label fw-semibold text-uppercase small">Total</span>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>

                                        <div id="serviceDetails" class="row g-3">
                                            <div class="service-detail col-12 base-service-row">
                                                <div class="row g-3 align-items-center service-row">
                                                    <div class="col-md-4">
                                                        <select name="service_name[]" id="service_name" class="select2 form-select service_item @error('service_name') is-invalid @enderror">
                                                            <option value=""></option>
                                                            @foreach ($services as $item)
                                                                <option value="{{ $item->name }}" @selected(old('service_name') == $item->name)>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <input type="text" class="form-control" name="billing_qty[]" placeholder="">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" name="unit_price[]" placeholder="">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" name="tax[]" placeholder="">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" class="form-control" name="last_price[]" placeholder="">
                                                    </div>
                                                    <div class="col-md-1 d-flex justify-content-md-center gap-2 flex-nowrap service-actions">
                                                        <button type="button" class="btn btn-success btn-sm btn-icon-split" id="addService">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>
                                                    <button type="button" class="btn btn-danger btn-sm btn-icon-split ms-2 remove-service-row" title="Remove service row">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-trash"></i>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        @error('parents')
                                            <div class="alert alert-danger mt-3" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                        @error('name.0')
                                            <div class="alert alert-danger mt-3" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror

                                        <hr class="my-4" />

                                        <div class="row g-3 justify-content-end">
                                            <div class="col-12 col-lg-8 d-flex justify-content-end flex-wrap gap-3 custom-buttons-container">
                                                <a href="{{ route('billing.index') }}" class="btn btn-outline-secondary mb-2">
                                                    <span class="text">Cancel</span>
                                                </a>
                                                <div class="d-flex gap-2 flex-wrap mb-2">
                                                    <button type="submit" name="action" value="save" class="btn btn-primary btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-save"></i>
                                                        </span>
                                                        <span class="text">Save</span>
                                                    </button>
                                                    <button type="submit" name="action" value="save_and_print" class="btn btn-primary btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-print"></i>
                                                        </span>
                                                        <span class="text">Save & Print</span>
                                                    </button>
                                                </div>
                                                <div class="w-100"></div>
                                                <div class="d-flex justify-content-end w-100">
                                                    <button type="submit" name="action" value="save_and_email" class="btn btn-warning btn-icon-split" style="background-color:#f59e0b;border-color:#f59e0b;color:#0b1a39;">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-envelope"></i>
                                                        </span>
                                                        <span class="text">Save & Email</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xxl-4">
                            <div class="card shadow-sm sticky-card">
                                <div class="card-header border-0 pb-0">
                                    <h6 class="mb-0 text-uppercase text-muted small">Billing Summary</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label" for="net_total">Net Total</label>
                                        <input type="text" class="form-control" name="net_total" id="net_total">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="discount">Discount</label>
                                        <input type="number" class="form-control" name="discount" id="discount" value="0">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="grand_total">Grand Total</label>
                                        <input type="text" class="form-control" name="grand_total" id="grand_total">
                                    </div>
                                    <div class="bg-light rounded-3 p-3 small text-muted summary-hints">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Next Visit</span>
                                            <span id="summaryNextTreatment">—</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Vaccination Due</span>
                                            <span id="summaryNextVaccination">—</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Billing Date</span>
                                            <span id="summaryBillingDate">{{ Date('Y-m-d') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    </div>
</div>
@endsection

@section('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('plugin/select2/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.css">

@stop

@section('third_party_scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.js"></script>

    <script src="{{ asset('plugin/select2/select2.min.js') }}"></script>
    <script>
        $('.select2').select2();
        $(document).ready(function() {
            $('#pet').select2({
                closeOnSelect: false,
                tags: false // Ensure tags is set to false
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const billingForm = document.querySelector('.billing-workspace form');
            const savePrintButton = billingForm ? billingForm.querySelector('button[type="submit"][name="action"][value="save_and_print"]') : null;

            if (billingForm && savePrintButton) {
                savePrintButton.addEventListener('click', function () {
                    billingForm.setAttribute('target', '_blank');
                    billingForm.dataset.printSubmit = 'true';
                });

                billingForm.addEventListener('submit', function () {
                    if (billingForm.dataset.printSubmit === 'true') {
                        setTimeout(function () {
                            billingForm.removeAttribute('target');
                            delete billingForm.dataset.printSubmit;
                        }, 500);
                    }
                });
            }

            const sectionLinks = document.querySelectorAll('.billing-section-nav .billing-nav-link');
            const sections = document.querySelectorAll('.billing-section');

            sectionLinks.forEach(function (link) {
                link.addEventListener('click', function (event) {
                    const targetId = this.getAttribute('href');
                    const target = targetId ? document.querySelector(targetId) : null;
                    if (target) {
                        event.preventDefault();
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        const id = entry.target.getAttribute('id');
                        if (!id) {
                            return;
                        }
                        const relatedLink = document.querySelector('.billing-section-nav .billing-nav-link[href="#' + id + '"]');
                        if (!relatedLink) {
                            return;
                        }
                        if (entry.isIntersecting) {
                            sectionLinks.forEach(function (link) { link.classList.remove('is-current'); });
                            relatedLink.classList.add('is-current');
                        }
                    });
                }, {
                    rootMargin: '-40% 0px -50% 0px',
                    threshold: [0.25, 0.6]
                });

                sections.forEach(function (section) {
                    observer.observe(section);
                });
            } else if (sectionLinks.length) {
                sectionLinks.forEach(function (link) { link.classList.remove('is-current'); });
                sectionLinks[0].classList.add('is-current');
            }

            const summaryNextTreatment = document.getElementById('summaryNextTreatment');
            const summaryNextVaccination = document.getElementById('summaryNextVaccination');
            const summaryBillingDate = document.getElementById('summaryBillingDate');

            function updateSummaryCard() {
                const nextTreatment = document.getElementById('next_treatment_date');
                const nextVaccination = document.querySelector('input[name="vacc_duration[]"]');
                const billingDate = document.getElementById('billing_date');

                if (summaryNextTreatment && nextTreatment) {
                    summaryNextTreatment.textContent = nextTreatment.value || '—';
                }
                if (summaryNextVaccination && nextVaccination) {
                    summaryNextVaccination.textContent = nextVaccination.value || '—';
                }
                if (summaryBillingDate && billingDate) {
                    summaryBillingDate.textContent = billingDate.value || '—';
                }
            }

            window.updateBillingSummaryCard = updateSummaryCard;

            ['next_treatment_date', 'billing_date'].forEach(function (id) {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('change', updateSummaryCard);
                    element.addEventListener('input', updateSummaryCard);
                }
            });

            document.addEventListener('input', function (event) {
                if (event.target && event.target.name === 'vacc_duration[]') {
                    updateSummaryCard();
                }
            });

            document.addEventListener('keydown', function (event) {
                if ((event.ctrlKey || event.metaKey) && event.key === 'Enter') {
                    event.preventDefault();
                    const saveButton = document.querySelector('button[type="submit"][name="action"][value="save"]');
                    if (saveButton) {
                        saveButton.click();
                    }
                }
            });

            updateSummaryCard();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>

// $(document).ready(function() {
//         $('#pet_category').change(function() {
//             var selectedText = $(this).find("option:selected").text();
//             $('#pet_category_text').val(selectedText);
//         });
//     });

        function getPetDetails(){
            var pet =  $('#pet').val();
            var medicalHistoryBtn = document.querySelector('.medical-history-btn');
            var billHistoryDiv = document.querySelector('.bill-history');

            if(pet!=''){
            $.ajax({
                url: "{{ route('ajax.getPetDetails') }}",
                method: "GET", // or "POST" for a POST request
                data: {
                    "pet": pet,
                },
                success: function(response) {
                  //alert(response.id);
                    document.getElementById('pet_id').value = response.pet_id;
                    document.getElementById('pet_name').value = response.name;
                    document.getElementById('age').value = response.age_at_register;
                    document.getElementById('weight').value = response.weight;
                    document.getElementById('colour').value = response.color;
                    document.getElementById('date_of_birth').value = response.date_of_birth;
                    //document.getElementById('gender').value = response.gender;
                    $('#gender').select2();
                    $('#gender').val(response.gender).trigger('change');
                    document.getElementById('remarks').value = response.remarks;
                   // document.getElementById('pet_category').value = response.pet_category;
                    $('#pet_category').select2();
                    $('#pet_category').val(response.pet_category).trigger('change');

                    //document.getElementById('breed').value = response.pet_breed;
                    $('#breed').select2();
                    $('#breed').val(response.pet_breed).trigger('change');

                    document.getElementById('owner_name').value = response.owner_name;
                    document.getElementById('owner_contact').value = response.owner_contact;
                    document.getElementById('owner_email').value = response.owner_email;
                    const ownerWhatsappEl = document.getElementById('owner_whatsapp');
                    if (ownerWhatsappEl) {
                        ownerWhatsappEl.value = response.owner_whatsapp ? response.owner_whatsapp : '+94 ';
                    }
                    document.getElementById('address').value = response.owner_address;

                    if (response.id) {
                        var templateUrl = medicalHistoryBtn.getAttribute('data-template');
                        var url = templateUrl.replace('PLACEHOLDER', response.id);
                        medicalHistoryBtn.href = url;
                        billHistoryDiv.style.display = 'block';
                    } else {
                        billHistoryDiv.style.display = 'none';
                    }

                    // Fetch vaccination options based on pet category
                fetchVaccinations(response.pet_category);

                if (window.updateBillingSummaryCard) {
                    window.updateBillingSummaryCard();
                }

                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
            }
        }

        function setSelectedValue(selectObj, valueToSet) {
            for (var i = 0; i < selectObj.options.length; i++) {
                if (selectObj.options[i].text== valueToSet) {
                    selectObj.options[i].selected = true;
                    return;
                }
            }
        }

        $('#pet').change(function() {
            getPetDetails();
        });

        document.addEventListener('DOMContentLoaded', function () {
            const savePetDetailsBtn = document.getElementById('savePetDetailsBtn');
            const petSelect = document.getElementById('pet');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (savePetDetailsBtn) {
                savePetDetailsBtn.addEventListener('click', function () {
                    if (!petSelect || !petSelect.value) {
                        toastr.warning('Select a pet before saving details.');
                        return;
                    }

                    const payload = {
                        pet: petSelect.value,
                        pet_id: document.getElementById('pet_id')?.value,
                        pet_name: document.getElementById('pet_name')?.value,
                        gender: document.getElementById('gender')?.value,
                        age: document.getElementById('age')?.value,
                        date_of_birth: document.getElementById('date_of_birth')?.value,
                        weight: document.getElementById('weight')?.value,
                        colour: document.getElementById('colour')?.value,
                        pet_category: document.getElementById('pet_category')?.value,
                        breed: document.getElementById('breed')?.value,
                        remarks: document.getElementById('remarks')?.value,
                        owner_name: document.getElementById('owner_name')?.value,
                        owner_contact: document.getElementById('owner_contact')?.value,
                        owner_whatsapp: document.getElementById('owner_whatsapp')?.value,
                        address: document.getElementById('address')?.value,
                    };

                    savePetDetailsBtn.disabled = true;

                    fetch("{{ route('billing.save-pet-details') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify(payload),
                    })
                        .then(async (response) => {
                            const data = await response.json().catch(() => ({}));
                            if (!response.ok) {
                                const message = data.message || 'Unable to save pet details.';
                                const validation = data.errors
                                    ? Object.values(data.errors).flat().join(' ')
                                    : '';
                                throw new Error(validation ? `${message} ${validation}` : message);
                            }

                            toastr.success(data.message || 'Client details saved.');
                        })
                        .catch((error) => {
                            toastr.error(error.message || 'Unable to save pet details.');
                        })
                        .finally(() => {
                            savePetDetailsBtn.disabled = false;
                        });
                });
            }
        });

    </script>

<script>

//////////////////////////start prescription//////////////////////////////////
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for the initial select element
    initializeSelect2('.select2');

    document.getElementById('addPrescription').addEventListener('click', function() {
        let original = document.querySelector('.prescription-details');
        let clone = original.cloneNode(true);
        clone.classList.remove('base-prescription-row');

        // Clear input values in the cloned node
        let clonedInputs = clone.querySelectorAll('input');
        clonedInputs.forEach(function(input) {
            input.value = '';
        });

        // Clear previous values and re-initialize Select2
        let clonedSelects = clone.querySelectorAll('select');
        clonedSelects.forEach(function(select) {
            $(select).val(null).trigger('change'); // Clear previous values
            $(select).next('.select2-container').remove(); // Remove the previous Select2 container
            initializeSelect2(select); // Re-initialize Select2
        });

        // Replace plus button with remove button
        let buttonContainer = clone.querySelector('.prescription-actions');
        if (buttonContainer) {
            buttonContainer.innerHTML = '';

            let removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger btn-sm btn-icon-split mt-0 mb-2 remove-prescription-row';
            removeButton.innerHTML = '<span class="icon text-white-50"><i class="fas fa-trash"></i></span>';
            buttonContainer.appendChild(removeButton);
        }

        document.getElementById('prescription').appendChild(clone);
    });

    document.addEventListener('click', function(event) {
        const removeBtn = event.target.closest('.remove-prescription-row');
        if (removeBtn) {
            const row = removeBtn.closest('.prescription-details');
            if (row?.classList.contains('base-prescription-row')) {
                row.querySelectorAll('input').forEach(input => input.value = '');
                $(row).find('select').val(null).trigger('change');
            } else {
                row?.remove();
            }
        }
    });
});

$(document).ready(function() {
    // Initialize Select2 for existing select element on page load
    initializeSelect2('.select2');
});


//////////////////////////end prescription//////////////////////////////////
////////////////////////Start Vaccination Script ////////////////////
document.addEventListener('DOMContentLoaded', function() {
    // Function to initialize datetimepicker (Flatpickr)
    function initializeDateTimePicker(element) {
        flatpickr(element, {
            dateFormat: 'Y-m-d'
        });
    }

    // Initialize Select2 for the initial select element
    initializeSelect2('.select2');
    initializeDateTimePicker('.datetimepicker');

    // Counter to keep track of the number of rows (to make radio button names unique)
    let rowCounter = 1;

    document.getElementById('addVaccination').addEventListener('click', function() {
        rowCounter++; // Increment row counter for each new row

        let original = document.querySelector('.vaccination-details');
        let clone = original.cloneNode(true);
        clone.classList.remove('base-vaccination-row');

        // Clear input values in the cloned node
        let clonedInputs = clone.querySelectorAll('input');
        clonedInputs.forEach(function(input) {
            input.value = '';
        });

        // Clear previous values and re-initialize Select2
        let clonedSelects = clone.querySelectorAll('select');
        clonedSelects.forEach(function(select) {
            $(select).val(null).trigger('change'); // Clear previous values
            $(select).next('.select2-container').remove(); // Remove the previous Select2 container
            initializeSelect2(select); // Re-initialize Select2
        });

        // Re-initialize datetimepicker for the cloned inputs
        let clonedDateTimePickers = clone.querySelectorAll('.datetimepicker');
        clonedDateTimePickers.forEach(function(dateTimePicker) {
            flatpickr(dateTimePicker, {
                dateFormat: 'Y-m-d'
            });
        });

        // Replace plus button with remove button
        let buttonContainer = clone.querySelector('.vaccination-actions');
        if (buttonContainer) {
            buttonContainer.innerHTML = '';

            let removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger btn-sm btn-icon-split mt-0 mb-2 remove-vaccination-row';
            removeButton.innerHTML = '<span class="icon text-white-50"><i class="fas fa-trash"></i></span>';
            buttonContainer.appendChild(removeButton);
        }

        document.getElementById('vaccination').appendChild(clone);
    });
});

$(document).ready(function() {
    // Initialize Select2 for existing select element on page load
    initializeSelect2('.select2');
    initializeDateTimePicker('.datetimepicker');
});



//////////////////////////end Vaccination//////////////////////////////////

////////////////////////Start Billing Script ////////////////////
document.addEventListener('DOMContentLoaded', function() {
    function updateTotal(row) {
        var qty = parseFloat(row.find('input[name="billing_qty[]"]').val()) || 0;
        var unitPrice = parseFloat(row.find('input[name="unit_price[]"]').val()) || 0;
        var discountPercentage = parseFloat(row.find('input[name="tax[]"]').val()) || 0;

        var discountAmount = (qty * unitPrice) * (discountPercentage / 100);
        var total = (qty * unitPrice) - discountAmount;

        row.find('input[name="last_price[]"]').val(total.toFixed(2));
    }

    function getVaccinationTotal() {
        var vaccinationTotal = 0;
        $('select[name="vaccine_name[]"]').each(function() {
            var price = parseFloat($(this).find('option:selected').data('price'));
            if (!isNaN(price)) {
                vaccinationTotal += price;
            }
        });

        return vaccinationTotal;
    }

    function updateGrandTotal() {
        var netTotal = 0;
        $('input[name="last_price[]"]').each(function() {
            netTotal += parseFloat($(this).val()) || 0;
        });

        netTotal += getVaccinationTotal();

        var discount = parseFloat($('#discount').val()) || 0;
        var grandTotal = netTotal - discount;

        $('#net_total').val(netTotal.toFixed(2));
        $('#grand_total').val(grandTotal.toFixed(2));
    }

    window.recalculateBillingTotals = updateGrandTotal;

    function attachServiceChangeHandler($select) {
        $select.off('change.service').on('change.service', function() {
            var selectedServiceId = $(this).val();
            var parentRow = $(this).closest('.service-row');

            if (selectedServiceId) {
                $.ajax({
                    url: '/get-service-price/' + selectedServiceId,
                    method: 'GET',
                    success: function(response) {
                        if (response.price) {
                            parentRow.find('input[name="unit_price[]"]').val(response.price);
                            parentRow.find('input[name="billing_qty[]"]').val(1);
                            parentRow.find('input[name="tax[]"]').val(0);
                            updateTotal(parentRow);
                            updateGrandTotal();
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching service price:', error);
                    }
                });
            } else {
                parentRow.find('input[name="unit_price[]"]').val('');
                parentRow.find('input[name="billing_qty[]"]').val('');
                parentRow.find('input[name="tax[]"]').val('');
                updateTotal(parentRow);
                updateGrandTotal();
            }
        });
    }

    function initializeServiceSelects(context) {
        var $context = context ? $(context) : $(document);
        var $serviceSelects = $context.find('select[name="service_name[]"]');

        $serviceSelects.each(function() {
            var $select = $(this);
            $select.next('.select2-container').remove();
            initializeSelect2($select);
            attachServiceChangeHandler($select);
        });
    }

    initializeServiceSelects(document);

    $(document).on('change', 'select[name="vaccine_name[]"]', function() {
        updateGrandTotal();
    });

    document.getElementById('addService').addEventListener('click', function() {
        let original = document.querySelector('.service-detail');
        let clone = original.cloneNode(true);
        clone.classList.remove('base-service-row');

        let clonedInputs = clone.querySelectorAll('input');
        clonedInputs.forEach(function(input) {
            input.value = '';
        });

        initializeServiceSelects(clone);

        let buttonContainer = clone.querySelector('.service-actions');
        if (buttonContainer) {
            buttonContainer.innerHTML = '';

            let removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger btn-sm btn-icon-split mt-0 mb-2 remove-service-row';
            removeButton.innerHTML = '<span class="icon text-white-50"><i class="fas fa-trash"></i></span>';
            buttonContainer.appendChild(removeButton);
        }

        document.getElementById('serviceDetails').appendChild(clone);
    });

    document.addEventListener('input', function(event) {
        if (event.target.matches('input[name="billing_qty[]"], input[name="tax[]"], input[name="unit_price[]"]')) {
            var row = event.target.closest('.service-row');
            updateTotal($(row));
            updateGrandTotal();
        }
    });

    $('#discount').on('input', updateGrandTotal);

    document.addEventListener('click', function(event) {
        const vaccBtn = event.target.closest('.remove-vaccination-row');
        if (vaccBtn) {
            const row = vaccBtn.closest('.vaccination-details');
            if (row?.querySelector('#addVaccination')) {
                row.querySelectorAll('input').forEach(input => input.value = '');
                $(row).find('select').val(null).trigger('change');
            } else {
                row?.remove();
            }
            updateGrandTotal();
        }

        const prescriptionBtn = event.target.closest('.remove-prescription-row');
        if (prescriptionBtn) {
            const row = prescriptionBtn.closest('.prescription-details');
            if (row?.classList.contains('base-prescription-row')) {
                row.querySelectorAll('input').forEach(input => input.value = '');
                $(row).find('select').val(null).trigger('change');
            } else {
                row?.remove();
            }
        }

        const serviceBtn = event.target.closest('.remove-service-row');
        if (serviceBtn) {
            const row = serviceBtn.closest('.service-detail');
            if (row?.querySelector('#addService')) {
                row.querySelectorAll('input').forEach(input => input.value = '');
                $(row).find('select').val(null).trigger('change');
            } else {
                row?.remove();
            }
            updateGrandTotal();
        }
    });

    updateGrandTotal();
});

$(document).ready(function() {
    // Initialize Select2 for existing select element on page load
    initializeSelect2('.select2');
});


///////////////////////end Services script //////////////////////////


function fetchVaccinations(petCategoryIds) {

    //alert(petCategoryIds);
    $.ajax({
        url: "{{ route('ajax.getVaccinationsByPetCategory') }}",
        method: "GET",
        data: {
            "pet_category": petCategoryIds,
        },
        success: function(vaccinations) {
           // alert(vaccinations);
            const vaccineSelects = $('select[name="vaccine_name[]"]');
            vaccineSelects.each(function() {
                const $select = $(this);
                $select.empty();
                $select.append('<option value="" selected="selected"></option>');
                $.each(vaccinations, function(key, value) {
                    const option = $('<option></option>')
                        .val(value.id)
                        .attr('data-price', value.price || 0)
                        .text(value.name);
                    $select.append(option);
                });
                $select.val(null).trigger('change');
            });

            if (window.recalculateBillingTotals) {
                window.recalculateBillingTotals();
            }
        },
        error: function(xhr, status, error) {
           // alert(error);
            console.log(error);
        }
    });
}


$(document).ready(function() {
    // Event listener for radio buttons
    $('input[name="next_treatment_weeks"]').on('change', function() {
        var selectedValue = $(this).val();
        var currentDate = new Date(); // Get current date

        // Check the selected value and add weeks accordingly
        if (selectedValue.endsWith('W')) {
            var weeksToAdd = parseInt(selectedValue); // Extract the number of weeks
            currentDate.setDate(currentDate.getDate() + (weeksToAdd * 7)); // Add weeks to the current date
        } else if (selectedValue.endsWith('Y')) {
            var yearsToAdd = parseInt(selectedValue); // Extract the number of years
            currentDate.setFullYear(currentDate.getFullYear() + yearsToAdd); // Add years to the current date
        }

        // Format the new date in YYYY-MM-DD
        var newDate = currentDate.toISOString().split('T')[0];

        // Set the new date in the datetimepicker input field
        $('#next_treatment_date').val(newDate).trigger('change');
    });

    // Event listener for each group of radio buttons related to next vaccination weeks
    // Use event delegation to handle dynamically added radio buttons
    $(document).on('change', 'select[name^="next_vacc_weeks[]"]', function() {
    var selectedValue = $(this).val();
    var currentDate = new Date(); // Get current date

    if (selectedValue.endsWith('W')) {
        var weeksToAdd = parseInt(selectedValue); // Extract the number of weeks (e.g., "1W" becomes 1)
        currentDate.setDate(currentDate.getDate() + (weeksToAdd * 7)); // Add weeks to the current date
    } else if(selectedValue.endsWith('Y')) {
        var yearsToAdd = parseInt(selectedValue); // Extract the number of weeks (e.g., "1W" becomes 1)
        currentDate.setFullYear(currentDate.getFullYear() + yearsToAdd);
    }

    // Format the new date in YYYY-MM-DD
    var newDate = currentDate.toISOString().split('T')[0];

    // Set the new date in the corresponding 'vacc_duration[]' input field
    $(this).closest('.vaccination-row').find('input[name="vacc_duration[]"]').val(newDate).trigger('input');
});





});
</script>
@stop
