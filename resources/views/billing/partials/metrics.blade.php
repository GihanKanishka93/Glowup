<div class="card shadow-sm billing-card h-100 glance-card">
    <div class="card-header border-0 pb-2 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <span class="glance-icon bg-primary-subtle text-primary"><i class="fas fa-bolt"></i></span>
            <h6 class="mb-0 text-uppercase text-muted small">Today At A Glance</h6>
        </div>
        <span class="badge bg-light text-dark small fw-semibold">{{ now()->format('d M') }}</span>
    </div>
    <div class="card-body pt-2">
        <div class="row g-3 glance-grid">
            <div class="col-6 glance-item">
                <div class="glance-label">Consultations</div>
                <div class="glance-value">{{ number_format($metrics['visits_today'] ?? 0) }}</div>
            </div>
            <div class="col-6 glance-item">
                <div class="glance-label">Follow-ups Due</div>
                <div class="glance-value">{{ number_format($metrics['followups_today'] ?? 0) }}</div>
            </div>
            <div class="col-6 glance-item">
                <div class="glance-label">Bills Raised</div>
                <div class="glance-value">{{ number_format($metrics['bills_today'] ?? 0) }}</div>
            </div>
            <div class="col-6 glance-item">
                <div class="glance-label">Revenue Today</div>
                <div class="glance-value text-success">Rs {{ number_format($metrics['revenue_today'] ?? 0, 2) }}</div>
            </div>
        </div>
    </div>
</div>
