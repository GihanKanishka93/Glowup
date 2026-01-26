@if(count($lowStockItems) > 0)
    <style>
        .low-stock-card {
            border-left: 4px solid #ffc107 !important;
            transition: all 0.3s ease;
        }

        body.theme-dark .low-stock-card {
            background-color: var(--surface) !important;
            border-color: var(--border) !important;
        }

        body.theme-dark .low-stock-card .card-header,
        body.theme-dark .low-stock-card .card-footer {
            background-color: transparent !important;
            border-color: var(--border) !important;
        }

        body.theme-dark .low-stock-card .text-dark {
            color: var(--text) !important;
        }

        body.theme-dark .low-stock-card .list-group-item {
            background-color: transparent !important;
            border-color: var(--border) !important;
            color: var(--text) !important;
        }

        @keyframes subtle-pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }

            100% {
                opacity: 1;
            }
        }

        .critical-stock {
            animation: subtle-pulse 2s infinite;
        }
    </style>

    <div class="card shadow-sm low-stock-card mb-4">
        <div class="card-header border-0 py-3">
            <div class="d-flex align-items-center gap-2">
                <span class="p-2 bg-warning-subtle text-warning rounded-circle">
                    <i class="fas fa-boxes"></i>
                </span>
                <h6 class="mb-0 fw-bold text-dark">Low Stock Alerts</h6>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @foreach($lowStockItems as $item)
                    <div class="list-group-item border-0 py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold text-dark">{{ $item->name }}</span>
                            <span class="badge bg-danger rounded-pill critical-stock">
                                {{ (float) $item->stock_quantity }} {{ $item->unit }}
                            </span>
                        </div>
                        <div class="progress" style="height: 6px; background-color: rgba(0,0,0,0.1);">
                            @php
                                $percentage = $item->min_stock_level > 0 ? ($item->stock_quantity / $item->min_stock_level) * 100 : 0;
                                $percentage = min($percentage, 100);
                            @endphp
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percentage }}%"></div>
                        </div>
                        <small class="text-muted mt-1 d-block small">Min. Level: {{ (float) $item->min_stock_level }}
                            {{ $item->unit }}</small>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer border-0 pt-0 pb-3">
            <a href="{{ route('services.index') }}"
                class="btn btn-link btn-sm text-warning fw-semibold p-0 text-decoration-none">
                Manage Inventory <i class="fas fa-arrow-right ms-1 small"></i>
            </a>
        </div>
    </div>
@endif