@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row g-4">
            <div class="col-12 col-xl-4">
                @include('billing.partials.stock-alerts')
            </div>
            <div class="col-12 col-xl-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center py-5">
                        <div class="text-center">
                            <i class="fas fa-chart-line fa-4x text-light mb-4" style="opacity: 0.2"></i>
                            <h4 class="text-dark fw-bold">Clinic Intelligence Center</h4>
                            <p class="text-muted">High-level medical and financial insights will be displayed here as the
                                clinic operations scale.</p>
                            <div class="d-flex gap-2 justify-content-center mt-4">
                                <a href="{{ route('billing.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>New Billing
                                </a>
                                <a href="{{ route('patient.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-users me-2"></i>Patient Directory
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection