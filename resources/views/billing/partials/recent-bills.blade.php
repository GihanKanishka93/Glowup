<div class="card shadow-sm billing-card">
    <div class="card-header border-0 pb-0">
        <h6 class="mb-0 text-uppercase text-muted small">Recently Printed Bills</h6>
    </div>
    <div class="list-group list-group-flush">
        @forelse ($recentBills as $bill)
            @php
                $billDate = $bill->billing_date ? \Illuminate\Support\Carbon::parse($bill->billing_date) : null;
            @endphp
            <a href="{{ route('billing.show', $bill->id) }}"
                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-semibold">{{ $bill->treatment->patient->name ?? 'Unknown Client' }}</div>
                    <div class="text-muted small">Bill #{{ $bill->billing_id }} @if($billDate) ·
                    {{ $billDate->format('d M') }} @endif</div>
                </div>
                <span class="fw-semibold">Rs {{ number_format($bill->total ?? 0, 2) }}</span>
            </a>
        @empty
            <div class="list-group-item text-muted small">No recent bills yet.</div>
        @endforelse
    </div>
</div>