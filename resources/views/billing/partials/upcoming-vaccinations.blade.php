<div class="card shadow-sm billing-card">
    <div class="card-header border-0 pb-0 d-flex align-items-center justify-content-between">
        <h6 class="mb-0 text-uppercase text-muted small">Upcoming Follow-ups</h6>
        <span class="badge bg-warning-subtle text-warning">Next 7 days</span>
    </div>
    <div class="list-group list-group-flush">
        @forelse ($upcomingVaccinations as $vaccination)
            @php
                $dueDate = $vaccination->next_vacc_date
                    ? \Illuminate\Support\Carbon::parse($vaccination->next_vacc_date)
                    : null;
                $pet = optional(optional($vaccination->treatment)->pet);
                $petName = $pet->name ?? 'Unknown Client';
            @endphp
            @if ($pet?->id)
                <a class="list-group-item list-group-item-action" href="{{ route('pet.show', $pet->id) }}">
                    <div class="fw-semibold">{{ $petName }}</div>
                    <div class="text-muted small">
                        {{ $vaccination->vaccine->name ?? 'Treatment plan' }}
                        @if ($dueDate)
                            · due {{ $dueDate->format('d M') }}
                        @endif
                    </div>
                </a>
            @else
                <div class="list-group-item">
                    <div class="fw-semibold">{{ $petName }}</div>
                    <div class="text-muted small">
                        {{ $vaccination->vaccine->name ?? 'Treatment plan' }}
                        @if ($dueDate)
                            · due {{ $dueDate->format('d M') }}
                        @endif
                    </div>
                </div>
            @endif
        @empty
            <div class="list-group-item text-muted small">No follow-ups scheduled over the next 7 days.</div>
        @endforelse
    </div>
</div>
