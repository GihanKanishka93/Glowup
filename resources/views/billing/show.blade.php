@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@section('content')
<style>
    body {
        background-color: #ffffff;
    }
    body.theme-dark {
        background-color: #f5f7fb !important;
        color: #0f172a !important;
    }
    .card {
        border: 1px solid #818185;
        color: #0f172a;
    }
    .card-header {
        background: linear-gradient(135deg, #4338ca, #6366f1);
        color: #ffffff;
    }
    .card-body {
        background-color: #ffffff;
    }
    .bill-label-data {
        font-weight: bold;
        color: #007bff;
    }
    .form-group.row {
        margin-bottom: 1rem;
    }
    legend {
        background-color: #ffffff;
        color: #0f5132;
        padding: 0.5rem;
        border-radius: 0.25rem;
    }
    .custom-buttons-container .btn {
        margin-left: 1rem;
    }
    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
    .btn-primary {
        background-color: #4442c5;
        border-color: #4442c5;
    }
    .icon {
        margin-right: 0.5rem;
    }
    hr {
        border-top: 2px solid #4442c5;
    }

    /* **********************************/
    .basic-information {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .owner-information, .trematment-info, .prescription, .vaccinationa-info {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
    }

    .info-row p {
        margin: 0;
        padding: 0 15px;
        font-weight: bold;
        color: #0f172a;
    }
    .info-row p strong { color: #0b1324; }

    .custom-buttons-container {
        padding: 15px 30px 0px 30px !important;
    }
    @media only screen and (max-width: 767px) {
    .info-row {
        display: flex;
        flex-direction: column;
        flex-wrap: nowrap;
        justify-content: flex-start;

    }
    .info-row div{
        padding: 5px 0px !important;
    }

}
.bg-gray-200 {
    background-color: #eef2ff !important;
    color: #312e81 !important;
    font-weight: 700 !important;
    font-size: 1rem !important;
    padding: 10px 30px !important;
}
.form-group.row {
    margin-bottom: 0rem !important;
}
/* Ensure dark theme still renders dark text on light cards */
body.theme-dark .card,
body.theme-dark .card-body,
body.theme-dark .basic-information,
body.theme-dark .owner-information,
body.theme-dark .trematment-info,
body.theme-dark .prescription,
body.theme-dark .vaccinationa-info,
body.theme-dark .info-row p,
body.theme-dark .info-row p strong,
body.theme-dark legend {
    color: #0f172a !important;
    background-color: #ffffff !important;
}
body.theme-dark .bg-gray-200 {
    background-color: #eef2ff !important;
    color: #312e81 !important;
}

</style>
    <div class="row align-items-center">
        <div class="col">
            <h1 class="h3 mb-2 text-gray-800">Billing Information  ( ID - {{ $bill->billing_id }} )</h1>
        </div>
        <div class="col-auto">
            <form action="{{ route('billing.email', $bill->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-md btn-outline-primary btn-icon-split ml-2">
                    <span class="icon text-primary-50">
                        <i class="fa fa-envelope"></i>
                    </span>
                    <span class="text">Email Bill</span>
                </button>
            </form>
            <a href="{{ route('medical-history.show', ['id' => $treatment->pet_id]) }}" target="_blank" class="btn btn-md btn-primary btn-icon-split ml-2 medical-history-btn">
                <span class="icon text-white-50">
                    <i class="fa fa-file"></i>
                </span>
                <span class="text">Medical History</span>
        </a>
    </div>
</div>



    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold ">Client : {{ $treatment->pet->name }} </h6>
                    <div class="dropdown no-arrow show">
                       Billing Date :  {{ $bill->billing_date }}
                    </div>
                </div>


                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="card-body">

                        <div class="basic-information">
                            <div class="info-row">
                                <div class="col-sm-12 col-xl-6 col-lg-6">
                                    <p><strong>Client Name:</strong> {{ $treatment->pet->name }}</p>
                                </div>
                                <div class="col-sm-12 col-xl-6 col-lg-6">
                                     <p><strong>Doctor Name:</strong> {{ $treatment->doctor->name }}</p>
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="col-xl-6 col-lg-6">
                                    <p><strong>Client ID:</strong> {{ $treatment->pet->pet_id }}</p>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <p><strong>Date of Birth:</strong> {{ $treatment->pet->date_of_birth }}</p>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="col-xl-6 col-lg-6">
                                  <p><strong>Age:</strong> {{ $treatment->pet->age_at_register }}</p>
                                </div>

                                <div class="col-xl-6 col-lg-6">
                                 <p><strong>Skin Type:</strong> {{ $treatment->pet->petcategory->name ?? '-' }}</p>
                                </div>

                            </div>
                            <div class="info-row">
                                <div class="col-xl-6 col-lg-6">
                                <p><strong>Breed:</strong>@if(isset($treatment->pet->petbreed->name)) {{ $treatment->pet->petbreed->name }} @endif</p>
                            </div>
                                <div class="col-xl-6 col-lg-6">
                                <p><strong>Gender:</strong> {{ $treatment->pet->gender == 1 ? 'Male' : 'Female' }}</p>
                            </div>
                            </div>
                            <div class="info-row">
                                <div class="col-xl-6 col-lg-6">
                                <p><strong>Weight:</strong> {{ $treatment->pet->weight }}</p>
                            </div>
                                <div class="col-xl-6 col-lg-6">
                                <p><strong>Color:</strong> {{ $treatment->pet->color }}</p>
                            </div>
                            </div>
                            <div class="info-row">
                                <div class="col-xl-6 col-lg-6">
                                <p><strong>Remarks:</strong> {{ $treatment->pet->remarks }}</p>
                            </div>
                            </div>
                        </div>


                        <legend class="bg-gray-200 p-1 pl-lg-4">Owner Information</legend>
                        <br>
                        <div class="owner-information">
                            <div class="info-row">
                                <div class="col-sm-12 col-xl-6 col-lg-6">
                                    <p><strong>Name:</strong> {{ $treatment->pet->owner_name }}</p>
                                </div>
                                <div class="col-sm-12 col-xl-6 col-lg-6">
                                    <p><strong>Contact Number:</strong> {{ $treatment->pet->owner_contact }}</p>
                                </div>
                                <div class="col-sm-12 col-xl-6 col-lg-6">
                                    <p><strong>WhatsApp:</strong> {{ $treatment->pet->owner_whatsapp ?? '—' }}</p>
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="col-sm-12 col-xl-6 col-lg-6">
                                    <p><strong>Address:</strong> {{ $treatment->pet->owner_address }}</p>
                                </div>
                            </div>
                        </div>


                        <legend class="bg-gray-200 p-1 pl-lg-4">Treatment Information</legend>
                        <br>

                        <div class="trematment-info">
                            <div class="info-row">
                                <div class="col-sm-12 col-xl-6 col-lg-6">
                                    <p><strong>History/Complaint:</strong> {{ $treatment->history_complaint }}</p>
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="col-sm-12 col-xl-6 col-lg-6">
                                    <p><strong>Clinical Observation:</strong> {{ $treatment->clinical_observation }}</p>
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="col-sm-12 col-xl-6 col-lg-6">
                                    <p><strong>Treatment Remarks:</strong> {{ $treatment->remarks }}</p>
                                </div>
                            </div>
                        </div>

                        <legend class="bg-gray-200 p-1 pl-lg-4">Prescription</legend>
                        <br/>
                        <div class="prescription">
                        <div id="prescription" class="form-group row ">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Drug Name</th>
                                        <th>Dose</th>
                                        <th>Dosage</th>
                                        <th>Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prescriptions as $prescription)
                                    <tr id="prescription-{{ $prescription->id }}">
                                        <td>{{ $prescription->drug_name }}</td>
                                        <td>{{ $prescription->dosage }}</td>
                                        <td>{{ $prescription->dose }}</td>
                                        <td>{{ $prescription->duration }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                        <br>


                        <legend class="bg-gray-200 p-1 pl-lg-4">Vaccination</legend>
                        <br/>
                        <div class="vaccinationa-info">
                            <div id="vaccination" class="mt-4">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Vaccine Name</th>
                                            <th>Duration</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vaccinationInfo as $vaccination)
                                        <tr id="vaccination-{{ $vaccination->id }}">
                                            <td>{{ optional($vaccination->vaccine)->name ?? 'Not available' }}</td>
                                            <td>
                                                @if(!empty($vaccination->next_vacc_date))
                                                {{ $vaccination->next_vacc_date }}
                                            @endif

                                            @if(!empty($vaccination->next_vacc_weeks))
                                                @if(!empty($vaccination->next_vacc_date))
                                                &nbsp; / &nbsp;
                                                @endif
                                                {{ $vaccination->next_vacc_weeks }}
                                            @endif

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>

                            <div class="basic-information">
                                <div class="info-row">
                                    <div class="col-sm-12 col-xl-6 col-lg-6">
                                        <p><strong>Next Treatment Date:</strong>
                                            @if(!empty($treatment->next_clinic_date))
                                                {{ $treatment->next_clinic_date }}
                                            @endif

                                            @if(!empty($treatment->next_clinic_weeks))
                                                @if(!empty($treatment->next_clinic_weeks))
                                                    &nbsp;&nbsp; / &nbsp;&nbsp;
                                                @endif
                                                {{ $treatment->next_clinic_weeks }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-sm-12 col-xl-6 col-lg-6">
                                         <p><strong>Billing Date:</strong> {{ $bill->billing_date }}</p>
                                    </div>
                                </div>

                        </div>

                        <legend class="bg-gray-200 p-1 pl-lg-4">Billing Information</legend>
                        <br>
                        <div class="basic-information">
                            <div id="billing-items" class="mt-4">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Service Name</th>
                                            <th>Qty</th>
                                            <th>Unit Price</th>
                                            <th>Discount</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0; @endphp
                                        @foreach ($billItems as $item)
                                        <tr id="bill-item-{{ $item->id }}">
                                            <td>{{ $item->item_name }}</td>
                                            <td>{{ $item->item_qty }}</td>
                                            <td>{{ $item->unit_price }}</td>
                                            <td>{{ $item->tax }}</td>
                                            <td>{{ $item->total_price }}</td>
                                            @php $total += intval($item->total_price); @endphp
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">Net Total:</th>
                                            <td>{{ $bill->net_amount }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Discount:</th>
                                            <td>{{ $bill->discount }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Grand Total:</th>
                                            <td>{{ $bill->total }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>

                    </div>


                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8 d-flex justify-content-sm-end custom-buttons-container">
                            @can('bill-edit')
                            <a href="{{ route('billing.edit', $bill->id) }}" target="_self"  class="btn btn-md btn-info btn-icon-split ml-2">
                                <span class="icon text-white-50">
                                    <i class="fa fa-file"></i>
                                </span>
                                <span class="text">Edit </span>
                            </a>
                            @endcan

                            <a href="{{ route('billing.index') }}" class="btn btn-info">
                                <span class="text">Cancel</span>
                            </a>
                            @can('bill-print')
                            <a href="{{ route('billing.print', ['id' => $bill->id]) }}" target="_blank"  class="btn btn-md btn-primary btn-icon-split ml-2">
                                <span class="icon text-white-50">
                                    <i class="fa fa-print"></i>
                                </span>
                                <span class="text">Bill </span>
                            </a>
                            @endcan
                            @can('prescription-print')
                            <a href="{{ route('billing.print-prescription', ['id' => $bill->id]) }}" target="_blank"  class="btn btn-md btn-primary btn-icon-split ml-2">
                                <span class="icon text-white-50">
                                    <i class="fa fa-file"></i>
                                </span>
                                <span class="text">Prescription Print</span>
                            </a>
                            @endcan
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

@section('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('plugin/select2/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.css">
    <style>
        #moodEmoji {
            font-size: 3em;
            /* Adjust the font size as needed */
        }
    </style>
@stop

@section('third_party_scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.js"></script>

    <script src="{{ asset('plugin/select2/select2.min.js') }}"></script>

</script>
@stop
