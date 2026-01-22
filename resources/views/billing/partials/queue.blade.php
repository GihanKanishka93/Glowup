<div class="card shadow-sm billing-card">
    <div class="card-header border-0 pb-0">
        <h6 class="mb-0 text-uppercase text-muted small">Today's Queue</h6>
    </div>
    <div class="list-group list-group-flush">
        @forelse ($visitQueue as $visit)
            @php
                $visitDate = $visit->treatment_date ? \Illuminate\Support\Carbon::parse($visit->treatment_date) : null;
            @endphp
            <div class="list-group-item d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-semibold">{{ $visit->pet->name ?? 'Unknown Client' }}</div>
                    <div class="text-muted small">
                        with {{ $visit->doctor->name ?? '—' }}
                        @if($visitDate)
                            · {{ $visitDate->format('d M') }}
                        @endif
                    </div>
                </div>
                <span class="badge bg-primary-subtle text-primary">In consult</span>
            </div>
        @empty
            <div class="list-group-item text-muted small">No consultations logged for today yet.</div>
        @endforelse
    </div>
</div>
