@php $currentTheme = auth()->user()?->theme ?? 'light'; @endphp
<nav class="navbar navbar-expand navbar-light compact-topbar sticky-top px-3 align-items-center gap-3">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-2" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </button>

    <form class="global-search d-none d-md-flex align-items-center flex-grow-0"
        style="flex-basis: 40%; min-width: 320px; max-width: 520px;" role="search" method="GET"
        action="{{ route('billing.index') }}">
        <span class="search-icon">
            <i class="fas fa-search"></i>
        </span>
        <input type="search" name="search" id="global-search-input" class="form-control"
            placeholder="Search patient, mobile, bill ID" value="{{ request('search') }}" aria-label="Global search">
    </form>

    <div
        class="d-flex align-items-center justify-content-center flex-grow-0 flex-md-grow-0 text-muted small text-center px-3 mx-auto">
        <span class="d-none d-md-inline">{{ now()->format('l, d M Y · h:i A') }}</span>
        <span class="d-md-none">{{ now()->format('d M · h:i A') }}</span>
    </div>

    <div class="ms-auto d-flex align-items-center gap-2">
        <button type="button" class="btn btn-outline-primary btn-sm d-md-none" data-bs-toggle="modal"
            data-bs-target="#globalSearchModal">
            <i class="fas fa-search"></i>
        </button>
        <button type="button" class="btn theme-toggle" data-theme="{{ $currentTheme }}" aria-label="Toggle theme">
            <i class="fas {{ $currentTheme === 'dark' ? 'fa-moon' : 'fa-sun' }}"></i>
        </button>
    </div>
</nav>

<!-- Mobile search modal -->
<div class="modal fade" id="globalSearchModal" tabindex="-1" aria-labelledby="globalSearchLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="globalSearchLabel">Search Records</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="GET" action="{{ route('billing.index') }}">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="search" name="search" class="form-control"
                            placeholder="Search patient, mobile, bill ID" value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Go</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <small class="text-muted">Tip: Press <kbd>Ctrl</kbd>/<kbd>⌘</kbd> + <kbd>K</kbd> to focus
                    search.</small>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('keydown', function (event) {
            if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
                event.preventDefault();
                const searchInput = document.getElementById('global-search-input');
                if (searchInput) {
                    searchInput.focus();
                } else {
                    const modal = new bootstrap.Modal(document.getElementById('globalSearchModal'));
                    modal.show();
                }
            }
        });
    </script>
@endpush