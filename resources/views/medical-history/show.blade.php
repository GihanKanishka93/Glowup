
@extends('layouts.popup')
<style>

.basic-information {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

p {
    color: #0644ff;
}
p strong{
    color: #000;
}
.basic-information p {
    margin: 0;
    padding: 0 15px;
    font-weight: bold;
}

.treatment_info {
    margin-top: 20px;
}

.treatment {
    display: flex;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 10px;
    background-color: #f8f9fa;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.treatment-date {
    margin-right: 20px;
    display: flex;
    align-items: center;
}

.date-circle {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background-color: #007bff;
    color: #fff;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    font-weight: bold;
}

.date-circle .day {
    font-size: 18px;
}

.date-circle .month {
    font-size: 12px;
}

.date-circle .year {
    font-size: 12px;
}

.treatment-details {
    flex-grow: 1;
}

.treatment-details p {
    margin: 0;
}

.prescription-box, .vaccination-box {
    margin-top: 10px;
    background-color: #e9ecef;
    padding: 10px;
    border-radius: 5px;
}

.prescription-box h4, .vaccination-box h4 {
    margin-top: 0;
}

.table-bordered {
    width: 100%;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
}
p.trement-basic span {
    padding-right: 40px;
}

/* Dark mode treatment */
body.theme-dark .medical-history {
    color: var(--text);
}

body.theme-dark .medical-history .basic-information {
    background-color: var(--surface);
    border-color: var(--border);
    box-shadow: var(--shadow-sm);
}

body.theme-dark .medical-history p {
    color: var(--text);
}

body.theme-dark .medical-history .basic-information p {
    color: var(--text);
}

body.theme-dark .medical-history .basic-information p strong {
    color: var(--text);
}

body.theme-dark .medical-history .treatment {
    border-color: var(--border);
    background-color: var(--surface);
    box-shadow: var(--shadow-sm);
}

body.theme-dark .medical-history .date-circle {
    background-color: var(--primary);
    color: var(--text-primary);
}

body.theme-dark .medical-history .prescription-box,
body.theme-dark .medical-history .vaccination-box {
    background-color: var(--panel);
}

body.theme-dark .medical-history .table-bordered {
    background-color: var(--surface);
    border-color: var(--border);
    color: var(--text);
}

body.theme-dark .medical-history .table-bordered thead th,
body.theme-dark .medical-history .table-bordered tfoot th,
body.theme-dark .medical-history .table-bordered tfoot td {
    background-color: var(--panel);
    color: var(--text);
    border-color: var(--border);
}

body.theme-dark .medical-history .table-bordered tbody td,
body.theme-dark .medical-history .table-bordered tbody th {
    color: var(--text);
    border-color: var(--border);
}

body.theme-dark .medical-history hr {
    border-color: var(--border);
}
</style>
@section('content')
<div class="container medical-history">
    <div class="pagetitle">
    <h2>Medical History for {{ $pet->name }}</h2>
   </div>
    <hr/>
    <div class="basic-information">
        <p><strong>Client ID:</strong> {{ $pet->pet_id }}</p>
        <p><strong>Client Name:</strong> {{ $pet->name }}</p>
        <p><strong>Skin Type:</strong> {{ $pet->petcategory->name }}</p>
        <p><strong>Skin Concern:</strong> {{ $pet->petbreed->name }}</p>
    </div>

    <div class="treatment_info">
        <h3>Treatments</h3>
        <hr/>
        @foreach ($treatments as $treatment)
        <div class="treatment">
            <div class="treatment-date">
                <div class="date-circle">
                    <span class="day">{{ \Carbon\Carbon::parse($treatment->treatment_date)->format('d') }}</span>
                    <span class="month">{{ \Carbon\Carbon::parse($treatment->treatment_date)->format('M') }}</span>
                    <span class="year">{{ \Carbon\Carbon::parse($treatment->treatment_date)->format('Y') }}</span>
                </div>
            </div>
            <div class="treatment-details">
                <p class="trement-basic"><strong>Doctor Name:</strong> <span>{{ $treatment->doctor->name }} </span> <strong> Bill ID:</strong>  <span>{{ $treatment->bill->billing_id }}</span> <strong> Bill Date:</strong>  <span>{{ $treatment->bill->billing_date }}</span> <strong> Billing Amount:</strong>  <span>{{ $treatment->bill->total }}</span></p>
                <p><strong>History/Complaint:</strong> {{ $treatment->history_complaint }}</p>
                <p><strong>Clinical Observation:</strong> {{ $treatment->clinical_observation }}</p>
                <p><strong>Remarks:</strong> {{ $treatment->remarks }}</p>
            <hr/>
                <h4>Prescriptions</h4>
                <div class="prescription-box">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Drug Name</th>
                                <th>Dosage</th>
                                <th>Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($treatment->prescriptions as $index => $prescription)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $prescription->drug_name }}</td>
                                <td>{{ $prescription->dosage }}</td>
                                <td>{{ $prescription->duration }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h4>Vaccinations</h4>
                <div class="vaccination-box">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Vaccine Name</th>
                                <th>Next Vaccination Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($treatment->vaccinations as $vaccination)
                            <tr>
                                <td>{{ optional($vaccination->vaccine)->name ?? 'Not available' }}</td>
                                <td>
                                     @if(!empty($vaccination->next_vacc_date))
                                    {{ $vaccination->next_vacc_date }}
                                @endif

                                @if(!empty($vaccination->next_vacc_weeks))
                                    @if(!empty($vaccination->next_vacc_date))
                                        /
                                    @endif
                                    {{ $vaccination->next_vacc_weeks }}
                                @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @php
                     $billItems = App\Models\BillItem::where('bill_id', $treatment->bill->billing_id )->get();

                @endphp
                <br/>
                <h4>Bill Information</h4>
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
                                <td>{{ $treatment->bill->net_amount }}</td>
                            </tr>
                            <tr>
                                <th colspan="4">Discount:</th>
                                <td>{{ $treatment->bill->discount }}</td>
                            </tr>
                            <tr>
                                <th colspan="4">Grand Total:</th>
                                <td>{{ $treatment->bill->total }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <hr>
        </div>
        @endforeach
        <div class="pagination">
            {{ $treatments->links() }}
        </div>
    </div>

</div>
@endsection
