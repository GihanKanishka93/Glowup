@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Str;
    use App\Models\Bill;
    use App\Models\Patient;
    use App\Models\Doctor;

    $user = auth()->user();
    $isCashier = $user && $user->hasAnyRole(['Cashier', 'cashier']);
    $statusOptions = ['available' => 'Available', 'in_consult' => 'In consult', 'offline' => 'Offline'];
    $currentStatusKey = $user->status ?? 'available';
    $currentStatusLabel = $statusOptions[$currentStatusKey] ?? 'Available';

    $sidebarMetrics = Cache::remember('sidebar.metrics.' . ($user?->id ?? 'guest'), now()->addMinutes(5), function () {
        $now = Carbon::now();
        $queueBadgeEnabled = config('billing.queue_badge_enabled', true);
        $today = $now->copy()->startOfDay();

        $readyToPrint = 0;

        if ($queueBadgeEnabled) {
            $readyToPrint = Bill::query()
                ->whereNull('bills.deleted_at')
                ->whereDate('billing_date', '>=', $today)
                ->where(function ($query) {
                    $query->whereNull('print_status')
                        ->orWhere('print_status', '!=', 1);
                })
                ->count();
        }

        $newBills = 0; // badge intentionally hidden

        $unpaidBills = Bill::query()
            ->whereNull('bills.deleted_at')
            ->where(function ($query) {
                $query->whereNull('payment_status')
                    ->orWhere('payment_status', '!=', 1);
            })
            ->count();

        return [
            'readyToPrint' => $queueBadgeEnabled ? $readyToPrint : 0,
            'newBills' => $newBills,
            'unpaidBills' => $unpaidBills,
            'patientCount' => Patient::query()->whereNull('patients.deleted_at')->count(),
            'doctorCount' => Doctor::query()->whereNull('doctors.deleted_at')->count(),
        ];
    });

    $abilityAllows = function ($item) use ($user) {
        if (!$user) {
            return false;
        }

        if (isset($item['can'])) {
            foreach ((array) $item['can'] as $ability) {
                if (!$user->can($ability)) {
                    return false;
                }
            }
        }

        if (isset($item['roles'])) {
            if (!$user->hasAnyRole((array) $item['roles'])) {
                return false;
            }
        }

        return true;
    };

    $refineItems = function (array $items) use (&$refineItems, $abilityAllows) {
        $refined = [];

        foreach ($items as $item) {
            // Skip malformed entries without a label
            if (empty($item['label'])) {
                continue;
            }

            if (isset($item['children'])) {
                $children = $refineItems($item['children']);
                if (!empty($children) && $abilityAllows($item)) {
                    $item['children'] = $children;
                    $refined[] = $item;
                }
                continue;
            }

            if (!isset($item['can']) && !isset($item['roles'])) {
                $refined[] = $item;
                continue;
            }

            if ($abilityAllows($item)) {
                $refined[] = $item;
            }
        }

        return $refined;
    };

    $quickActions = [];

    $navSections = [
        [
            'label' => 'New Bill',
            'items' => [
                [
                    'label' => 'Create Bill',
                    'icon' => 'fas fa-plus-circle',
                    'route' => route('billing.create'),
                    'active' => request()->routeIs('billing.create'),
                    'badge' => 0,
                    'badge_context' => 'info',
                ],
            ],
        ],
        [
            'label' => 'Dashboard',
            'items' => [
                [
                    'label' => 'Dashboard Overview',
                    'icon' => 'fas fa-chart-pie',
                    'route' => route('dashboard'),
                    'active' => request()->routeIs('dashboard'),
                    'badge' => 0,
                    'badge_context' => 'info',
                ],
                [
                    'label' => 'Billing Workspace',
                    'icon' => 'fas fa-clipboard-check',
                    'route' => route('billing.create'),
                    'active' => request()->routeIs('billing.create'),
                    'badge' => 0,
                    'badge_context' => 'info',
                    'can' => 'bill-create',
                ],
                [
                    'label' => 'Billing Queue',
                    'icon' => 'fas fa-print',
                    'route' => route('billing.index'),
                    'active' => request()->routeIs('billing.index'),
                    'badge' => $sidebarMetrics['readyToPrint'] ?? 0,
                    'badge_context' => 'warning',
                    'can' => 'bill-list',
                ],
            ],
        ],
        [
            'label' => 'Client Management',
            'items' => [
                [
                    'label' => 'Client List',
                    'icon' => 'fas fa-user',
                    'route' => route('patient.index'),
                    'active' => request()->routeIs('patient.index'),
                    'badge' => $sidebarMetrics['patientCount'] ?? 0,
                    'badge_context' => 'neutral',
                ],
                [
                    'label' => 'Register Client',
                    'icon' => 'fas fa-user-plus',
                    'route' => route('patient.create'),
                    'active' => request()->routeIs('patient.create'),
                ],
            ],
        ],
        [
            'label' => 'Doctor Management',
            'items' => [
                [
                    'label' => 'Doctor List',
                    'icon' => 'fas fa-user-md',
                    'route' => route('doctor.index'),
                    'active' => request()->routeIs('doctor.index'),
                    'badge' => $sidebarMetrics['doctorCount'] ?? 0,
                    'badge_context' => 'neutral',
                ],
                [
                    'label' => 'Add Doctor',
                    'icon' => 'fas fa-user-plus',
                    'route' => route('doctor.create'),
                    'active' => request()->routeIs('doctor.create'),
                ],
            ],
        ],
        [
            'label' => 'Reports',
            'items' => [
                [
                    'label' => 'Monthly Report',
                    'icon' => 'fas fa-chart-line',
                    'route' => route('report.monthly-report'),
                    'active' => request()->routeIs('report.monthly-report'),
                ],
                [
                    'label' => 'Doctor Reports',
                    'icon' => 'fas fa-user-md',
                    'route' => route('report.doctor-report'),
                    'active' => request()->routeIs('report.doctor-report'),
                ],
            ],
        ],
        [
            'label' => 'Settings',
            'items' => [
                [
                    'label' => 'User Management',
                    'icon' => 'fas fa-users-cog',
                    'route' => route('users.index'),
                    'active' => request()->routeIs('users.*'),
                ],
                [
                    'label' => 'User Roles',
                    'icon' => 'fas fa-id-badge',
                    'route' => route('role.index'),
                    'active' => request()->routeIs('role.*'),
                ],
                [
                    'label' => 'Suspended Users',
                    'icon' => 'fas fa-user-slash',
                    'route' => route('users.suspendusers'),
                    'active' => request()->routeIs('users.suspendusers'),
                ],
                [
                    'label' => 'Services',
                    'icon' => 'fas fa-stethoscope',
                    'route' => route('services.index'),
                    'active' => request()->routeIs('services.*'),
                ],
                [
                    'label' => 'Drug Catalog',
                    'icon' => 'fas fa-pills',
                    'route' => route('drug.index'),
                    'active' => request()->routeIs('drug.*'),
                ],
            ],
        ],
    ];

    if ($isCashier) {
        $navSections = array_map(function ($section) {
            if ($section['label'] !== 'Reports') {
                return $section;
            }

            return [
                'label' => 'Reports',
                'items' => [
                    [
                        'label' => 'Billing Report (Today)',
                        'icon' => 'fas fa-file-invoice-dollar',
                        'route' => route('report.monthly-report'),
                        'active' => request()->routeIs('report.monthly-report'),
                    ],
                ],
            ];
        }, $navSections);
    }

    foreach ($navSections as $index => $section) {
        $items = $refineItems($section['items']);
        if (empty($items)) {
            unset($navSections[$index]);
            continue;
        }
        $navSections[$index]['items'] = $items;
    }
    $navSections = array_values($navSections);

    $commandPaletteItems = [];
@endphp

<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
    <li class="sidebar-modern">
        <div class="sidebar-top">
            <div class="sidebar-brand-wrapper">
                <a class="sidebar-brand" href="{{ route('home') }}" aria-label="Navigate to home">
                    <img src="{{ asset('img/Glowup_Logo-modified.png') }}" alt="Glowup Skin Clinic"
                        class="sidebar-brand-logo">
                </a>
                @if (!$isCashier)
                    <button class="sidebar-icon-button" type="button" data-command-open title="Search (⌘K)"><i
                            class="fas fa-magnifying-glass"></i></button>
                @endif
            </div>


        </div>

        <div class="sidebar-nav">
            @foreach ($navSections as $sectionIndex => $section)
                <div class="sidebar-section">
                    <p class="sidebar-section-label">{{ $section['label'] }}</p>
                    <ul class="sidebar-links">
                        @foreach ($section['items'] as $item)
                            @if (isset($item['children']))
                                @php
                                    $collapseId = $item['id'] ?? 'nav-' . Str::slug($item['label']) . '-' . $sectionIndex;
                                    $isOpen = !empty($item['active']);
                                    $hasBadge = !empty($item['badge']);
                                @endphp
                                <li class="sidebar-node">
                                    <button class="sidebar-link has-children {{ $isOpen ? '' : 'collapsed' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}"
                                        aria-expanded="{{ $isOpen ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                        <span class="sidebar-icon"><i class="{{ $item['icon'] ?? 'fas fa-circle' }}"></i></span>
                                        <span class="sidebar-label">{{ $item['label'] }}</span>
                                        @if ($hasBadge)
                                            <span
                                                class="sidebar-badge badge-{{ $item['badge_context'] ?? 'neutral' }}">{{ number_format($item['badge']) }}</span>
                                        @endif
                                        <span class="sidebar-caret"><i class="fas fa-chevron-right"></i></span>
                                    </button>
                                    <div id="{{ $collapseId }}" class="collapse sidebar-submenu {{ $isOpen ? 'show' : '' }}"
                                        data-bs-parent="#accordionSidebar">
                                        <ul>
                                            @foreach ($item['children'] as $child)
                                                @php
                                                    $commandPaletteItems[] = [
                                                        'label' => $child['label'],
                                                        'href' => $child['route'],
                                                        'icon' => $item['icon'] ?? 'fas fa-circle',
                                                        'group' => $section['label'],
                                                    ];
                                                @endphp
                                                <li>
                                                    <a href="{{ $child['route'] }}"
                                                        class="sidebar-sublink {{ !empty($child['active']) ? 'active' : '' }}"
                                                        data-nav-item data-label="{{ $child['label'] }}"
                                                        data-href="{{ $child['route'] }}"
                                                        data-icon="{{ $item['icon'] ?? 'fas fa-circle' }}">
                                                        <span>{{ $child['label'] }}</span>
                                                        @if (!empty($child['active']))
                                                            <span class="sidebar-pill">Now</span>
                                                        @endif
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @else
                                @php
                                    $commandPaletteItems[] = [
                                        'label' => $item['label'],
                                        'href' => $item['route'],
                                        'icon' => $item['icon'] ?? 'fas fa-circle',
                                        'group' => $section['label'],
                                    ];
                                @endphp
                                <li>
                                    <a href="{{ $item['route'] }}"
                                        class="sidebar-link {{ !empty($item['active']) ? 'active' : '' }}" data-nav-item
                                        data-label="{{ $item['label'] }}" data-href="{{ $item['route'] }}"
                                        data-icon="{{ $item['icon'] ?? 'fas fa-circle' }}">
                                        <span class="sidebar-icon"><i class="{{ $item['icon'] ?? 'fas fa-circle' }}"></i></span>
                                        <span class="sidebar-label">{{ $item['label'] }}</span>
                                        @if (!empty($item['badge']))
                                            <span
                                                class="sidebar-badge badge-{{ $item['badge_context'] ?? 'neutral' }}">{{ number_format($item['badge']) }}</span>
                                        @endif
                                        @if (!empty($item['active']))
                                            <span class="sidebar-pill">Now</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <div class="sidebar-footer">
            @php
                $userName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: $user->email;
            @endphp
            <div class="sidebar-account-card">
                <button class="sidebar-account-toggle dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" data-current-status="{{ $currentStatusKey }}">
                    <img class="avatar" src="{{ asset('img/undraw_profile.svg') }}" alt="{{ $userName }}">
                    <div class="sidebar-account-copy">
                        <span class="sidebar-account-name">{{ $userName }}</span>
                        <span class="sidebar-account-role">{{ $user->designation ?? 'Team Member' }}</span>
                        <span class="sidebar-account-status status-{{ $currentStatusKey }}"><i
                                class="fas fa-circle"></i><span
                                class="user-status-label">{{ $currentStatusLabel }}</span></span>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <ul class="dropdown-menu sidebar-account-menu">
                    <li class="dropdown-header text-muted text-uppercase small">Set Status</li>
                    @foreach ($statusOptions as $value => $label)
                        <li>
                            <button type="button"
                                class="dropdown-item d-flex align-items-center user-status-option {{ $value === $currentStatusKey ? 'active' : '' }}"
                                data-status="{{ $value }}" data-label="{{ $label }}">
                                <span class="status-indicator {{ $value }}"></span>{{ $label }}
                            </button>
                        </li>
                    @endforeach
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="{{ route('users.profile') }}"><i
                                class="fas fa-user"></i><span>Profile</span></a></li>
                    <li><a href="#" class="dropdown-item text-danger sidebar-logout-btn"><i
                                class="fas fa-arrow-right-from-bracket"></i><span>Logout</span></a></li>
                </ul>
            </div>

            <div class="sidebar-bottom-actions">
                <button class="sidebar-icon-button" type="button" data-settings-open title="Open settings"><i
                        class="fas fa-sliders-h"></i></button>
                <button class="sidebar-icon-button" id="sidebarToggle" type="button" aria-label="Collapse sidebar"><i
                        class="fas fa-chevron-left"></i></button>
            </div>
        </div>
    </li>
</ul>

<button class="sidebar-expand-handle" type="button" data-sidebar-expand aria-label="Expand sidebar">
    <i class="fas fa-chevron-right"></i>
</button>

<div class="sidebar-settings-panel" id="sidebarSettingsFlyout" aria-hidden="true">
    <div class="settings-panel-header">
        <div>
            <h6>Workspace Preferences</h6>
            <p>Tailor the interface for your shift.</p>
        </div>
        <button type="button" class="sidebar-icon-button" data-settings-close aria-label="Close settings"><i
                class="fas fa-times"></i></button>
    </div>
    <div class="settings-panel-body">
        <div class="settings-item">
            <div>
                <h6>Dark Mode</h6>
                <p>Switch between light and dark themes.</p>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" data-settings-theme>Toggle</button>
        </div>
        <div class="settings-item">
            <div>
                <h6>Sound Alerts</h6>
                <p>Play a chime when new bills arrive.</p>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="sidebarSoundToggle">
                <label class="form-check-label" for="sidebarSoundToggle">Enabled</label>
            </div>
        </div>
        <div class="settings-item">
            <div>
                <h6>Compact Sidebar</h6>
                <p>Collapse the sidebar to icon-only mode.</p>
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm" data-settings-compact>Toggle</button>
        </div>
    </div>
</div>

<div class="command-palette" id="sidebarCommandPalette" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="command-backdrop" data-command-close></div>
    <div class="command-panel">
        <div class="command-header">
            <i class="fas fa-magnifying-glass"></i>
            <input type="text" id="commandPaletteInput" placeholder="Search menu, clients, bills…" autocomplete="off">
            <button type="button" class="sidebar-icon-button" data-command-close aria-label="Close command palette"><i
                    class="fas fa-times"></i></button>
        </div>
        <ul class="command-results" id="commandPaletteResults"></ul>
        <div class="command-hint">Press <kbd>Enter</kbd> to open · <kbd>Esc</kbd> to close</div>
    </div>
</div>

<form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<style>
    :root {
        --sidebar-bg: #f7f9fc;
        --sidebar-surface: #ffffff;
        --sidebar-border: rgba(148, 163, 184, 0.22);
        --sidebar-radius: 12px;
        --sidebar-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
        --sidebar-muted: #64748b;
        --sidebar-strong: #0f172a;
        --sidebar-icon-bg: rgba(148, 163, 184, 0.14);
        --sidebar-pill-bg: rgba(59, 130, 246, 0.12);
    }

    #accordionSidebar {
        position: sticky;
        top: 0;
        height: 100vh;
        align-self: flex-start;
        background: linear-gradient(180deg, var(--sidebar-bg) 0%, #eef2ff 20%, var(--sidebar-bg) 100%);
        padding: 1.1rem 0 1.2rem;
        border-right: 1px solid var(--sidebar-border);
        overflow: hidden;
        width: 15.75rem;
        flex: 0 0 15.75rem;
        max-width: 100%;
        box-sizing: border-box;
        box-shadow: inset -1px 0 0 rgba(255, 255, 255, 0.6);
    }

    #accordionSidebar .sidebar-modern {
        list-style: none;
        margin: 0;
        padding: 0 0.85rem 1.1rem;
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
        height: 100%;
    }

    .sidebar-top {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        flex: 0 0 auto;
    }

    .sidebar-nav {
        flex: 1 1 auto;
        overflow-y: auto;
        padding-right: 0.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
        scrollbar-gutter: stable both-edges;
    }

    .sidebar-nav::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.45);
        border-radius: 4px;
    }

    .sidebar-nav {
        scrollbar-width: thin;
        scrollbar-color: rgba(148, 163, 184, 0.45) transparent;
    }

    .sidebar-brand-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        padding-inline: 0.25rem;
    }

    .sidebar-brand {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        text-decoration: none;
    }

    .sidebar-brand-logo {
        width: 96px;
        height: auto;
        object-fit: contain;
        opacity: 0.98;
    }

    .sidebar-brand-wrapper [data-command-open] {
        display: none !important;
    }

    .sidebar-icon-button {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        border: 1px solid rgba(59, 130, 246, 0.2);
        background: rgba(59, 130, 246, 0.1);
        color: var(--primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform .2s ease, background .2s ease;
    }

    .sidebar-icon-button:hover {
        background: rgba(59, 130, 246, 0.18);
        transform: translateY(-1px);
    }

    .sidebar-search {
        display: none !important;
    }

    .sidebar-search input {
        background: transparent;
        border: 0;
        outline: none;
        color: inherit;
        width: 100%;
    }

    #accordionSidebar input[type="search"] {
        display: none !important;
    }

    .sidebar-search input::placeholder {
        color: rgba(100, 116, 139, 0.68);
    }

    .sidebar-quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 0.4rem 0.45rem;
    }

    .quick-action {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.4rem 0.55rem;
        border-radius: 0.8rem;
        background: var(--sidebar-surface);
        color: var(--primary);
        text-decoration: none;
        border: 1px solid rgba(59, 130, 246, 0.16);
        transition: transform .16s ease, box-shadow .16s ease;
        font-weight: 600;
        font-size: 0.85rem;
        box-shadow: 0 10px 22px rgba(59, 130, 246, 0.08);
    }

    .quick-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 14px 26px rgba(59, 130, 246, 0.14);
    }

    .quick-action kbd {
        background: rgba(59, 130, 246, 0.12);
        border-radius: 0.35rem;
        padding: 0.05rem 0.35rem;
        font-size: 0.6rem;
        letter-spacing: .06em;
    }

    .sidebar-section {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .sidebar-section-label {
        text-transform: uppercase;
        font-size: 0.62rem;
        letter-spacing: .08em;
        color: rgba(15, 23, 42, 0.68);
        margin: 0;
        font-weight: 600;
    }

    .sidebar-links {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 0.12rem;
    }

    .sidebar-link,
    .sidebar-sublink {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.35rem 0.55rem;
        border-radius: 0.7rem;
        color: var(--text-primary);
        text-decoration: none;
        transition: background .16s ease, color .16s ease, border-color .16s ease;
        border: 1px solid transparent;
        font-size: 0.85rem;
    }

    .sidebar-link:hover,
    .sidebar-sublink:hover {
        background: rgba(59, 130, 246, 0.1);
        color: var(--primary);
        border-color: rgba(59, 130, 246, 0.16);
    }

    .sidebar-link.active,
    .sidebar-sublink.active {
        background: linear-gradient(135deg, var(--primary), var(--primary-hover));
        border-color: transparent;
        color: var(--primary-contrast);
    }

    .sidebar-link .sidebar-icon {
        width: 24px;
        height: 24px;
        border-radius: 0.55rem;
        background: var(--sidebar-icon-bg);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--text-primary);
        font-size: 0.85rem;
        flex: 0 0 24px;
    }

    .sidebar-link:hover .sidebar-icon {
        background: rgba(59, 130, 246, 0.18);
        color: var(--primary);
    }

    .sidebar-link.active .sidebar-icon {
        background: rgba(255, 255, 255, 0.28);
        color: var(--primary-contrast);
    }

    .sidebar-node .sidebar-link {
        justify-content: space-between;
    }

    .sidebar-node .sidebar-label {
        flex: 1 1 auto;
        text-align: left;
    }

    .sidebar-caret {
        color: rgba(226, 232, 240, 0.45);
        transition: transform .2s ease;
    }

    .sidebar-node .sidebar-link.collapsed .sidebar-caret {
        transform: rotate(0deg);
    }

    .sidebar-node .sidebar-link:not(.collapsed) .sidebar-caret {
        transform: rotate(90deg);
    }

    .sidebar-badge {
        padding: 0.15rem 0.45rem;
        border-radius: 999px;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: .05em;
        background: var(--sidebar-pill-bg);
        color: var(--primary);
        min-width: 2.2rem;
        text-align: center;
    }

    .badge-warning {
        background: rgba(249, 115, 22, 0.14);
        color: var(--warning);
    }

    .badge-info {
        background: rgba(56, 189, 248, 0.16);
        color: var(--info);
    }

    .badge-neutral {
        background: rgba(148, 163, 184, 0.2);
        color: var(--text-primary);
    }

    .sidebar-pill {
        padding: 0.12rem 0.45rem;
        border-radius: 999px;
        background: rgba(34, 197, 94, 0.16);
        color: var(--success);
        font-size: 0.6rem;
        letter-spacing: .08em;
        border: 1px solid rgba(34, 197, 94, 0.26);
    }

    .sidebar-submenu {
        margin-top: 0.35rem;
    }

    .sidebar-submenu ul {
        list-style: none;
        margin: 0;
        padding: 0 0 0 2.2rem;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .sidebar-footer {
        display: flex;
        flex-direction: column;
        gap: 0.7rem;
        margin-top: auto;
        padding-top: 0.4rem;
        width: 100%;
        min-width: 0;
    }

    .sidebar-account-card {
        background: var(--sidebar-surface);
        border: 1px solid var(--sidebar-border);
        border-radius: 0.85rem;
        padding: 0.45rem 0.55rem;
        width: 100%;
        box-sizing: border-box;
        min-width: 0;
        box-shadow: var(--sidebar-shadow);
    }

    .sidebar-account-toggle {
        width: 100%;
        border: none;
        background: transparent;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.65rem;
        padding: 0.1rem 0.05rem;
    }

    .sidebar-account-toggle i {
        color: inherit;
    }

    .sidebar-account-toggle:focus {
        outline: none;
    }

    .sidebar-account-copy {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
        flex: 1 1 auto;
        text-align: left;
    }

    .sidebar-account-name {
        font-weight: 700;
        font-size: 0.85rem;
        line-height: 1.2;
    }

    .sidebar-account-role {
        font-size: 0.72rem;
        color: var(--primary);
        font-weight: 600;
        opacity: 0.9;
    }

    .sidebar-account-status {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-top: 0.1rem;
    }

    .sidebar-account-status i {
        font-size: 0.55rem;
    }

    .sidebar-account-status.status-available {
        color: #34d399;
    }

    .sidebar-account-status.status-in_consult {
        color: #fbbf24;
    }

    .sidebar-account-status.status-offline {
        color: #f87171;
    }

    .sidebar-account-card .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        border: 1.5px solid rgba(255, 255, 255, 0.35);
    }

    .sidebar-bottom-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        width: 100%;
    }

    .sidebar-expand-handle {
        position: fixed;
        left: 0.35rem;
        bottom: 1rem;
        z-index: 1200;
        width: 38px;
        height: 38px;
        border-radius: 12px;
        border: 1px solid var(--sidebar-border);
        background: #fff;
        color: var(--text-primary);
        display: none;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.12);
    }

    #accordionSidebar.toggled+.sidebar-expand-handle {
        display: inline-flex;
    }

    .sidebar-expand-handle:hover {
        background: rgba(59, 130, 246, 0.08);
        color: var(--primary);
    }

    .sidebar-settings-panel {
        position: fixed;
        top: 0;
        bottom: 0;
        right: 0;
        left: auto;
        width: min(360px, calc(100% - 4rem));
        background: var(--surface, #ffffff);
        box-shadow: -6px 0 24px rgba(15, 23, 42, 0.18);
        border-radius: 0;
        border-left: 1px solid rgba(148, 163, 184, 0.25);
        transform: translateX(105%);
        transition: transform .28s ease;
        z-index: 1050;
        display: flex;
        flex-direction: column;
        padding: 1.6rem;
    }

    .sidebar-settings-panel.is-open {
        transform: translateX(0);
    }

    .settings-panel-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .settings-panel-header h6 {
        margin: 0;
        font-weight: 700;
    }

    .settings-panel-header p {
        margin: 0;
        font-size: 0.85rem;
        color: var(--text-muted, #64748b);
    }

    .settings-panel-body {
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
    }

    .settings-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.2rem;
    }

    .settings-item h6 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 600;
    }

    .settings-item p {
        margin: 0;
        font-size: 0.8rem;
        color: var(--text-muted, #64748b);
    }

    .command-palette {
        position: fixed;
        inset: 0;
        display: none;
        align-items: flex-start;
        justify-content: center;
        padding-top: 12vh;
        z-index: 1060;
    }

    .command-palette.is-open {
        display: flex;
    }

    .command-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(2px);
    }

    .command-panel {
        position: relative;
        width: clamp(320px, 56vw, 600px);
        background: var(--surface, #ffffff);
        border-radius: 1rem;
        border: 1px solid rgba(148, 163, 184, 0.2);
        box-shadow: 0 20px 48px rgba(15, 23, 42, 0.35);
        overflow: hidden;
        z-index: 1;
        display: flex;
        flex-direction: column;
    }

    .command-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.9rem 1.2rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.18);
        color: var(--text-muted, #64748b);
    }

    .command-header input {
        flex: 1 1 auto;
        border: none;
        outline: none;
        background: transparent;
        font-size: 0.95rem;
        color: var(--text-primary, #1f2937);
    }

    .command-results {
        list-style: none;
        margin: 0;
        padding: 0.4rem 0;
        max-height: 320px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .command-results li {
        padding: 0.5rem 1.2rem;
    }

    .command-result-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
        color: var(--text-primary);
        border-radius: 0.75rem;
        padding: 0.55rem 0.75rem;
        transition: background .15s ease;
    }

    .command-result-item:hover,
    .command-result-item.is-active {
        background: rgba(59, 130, 246, 0.12);
        color: var(--primary);
    }

    .command-result-item .result-icon {
        width: 32px;
        height: 32px;
        border-radius: 0.65rem;
        background: rgba(59, 130, 246, 0.12);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
    }

    .command-result-item .result-meta {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
    }

    .command-result-item .result-group {
        font-size: 0.7rem;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: .08em;
    }

    .command-hint {
        padding: 0.75rem 1.2rem;
        font-size: 0.75rem;
        color: var(--text-muted);
        border-top: 1px solid rgba(148, 163, 184, 0.18);
    }

    @media (max-width: 1024px) {
        #accordionSidebar .sidebar-modern {
            padding-inline: 1rem;
        }

        .sidebar-quick-actions {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }

        .sidebar-settings-panel {
            inset: 0;
            width: 100%;
            transform: translateX(100%);
        }
    }

    body.theme-dark #accordionSidebar {
        background: linear-gradient(195deg, #0B0E14 0%, #151921 55%, #1C222D 100%);
    }

    body.theme-dark .quick-action {
        background: rgba(24, 33, 51, 0.85);
        border-color: rgba(79, 70, 229, 0.25);
        color: rgba(226, 232, 240, 0.94);
    }

    body.theme-dark .quick-action:hover {
        box-shadow: 0 14px 28px rgba(5, 12, 32, 0.45);
    }

    body.theme-dark .sidebar-link,
    body.theme-dark .sidebar-sublink {
        color: rgba(226, 232, 240, 0.9);
        border-color: transparent;
    }

    body.theme-dark .sidebar-link:hover,
    body.theme-dark .sidebar-sublink:hover {
        background: rgba(79, 70, 229, 0.22);
    }

    body.theme-dark .sidebar-link .sidebar-icon {
        background: rgba(12, 19, 35, 0.78);
    }

    body.theme-dark .sidebar-section-label {
        color: rgba(148, 163, 184, 0.82);
    }

    body.theme-dark .sidebar-account-card {
        background: rgba(30, 41, 59, 0.45);
        backdrop-filter: blur(8px);
        border-color: rgba(148, 163, 184, 0.15);
    }

    body.theme-dark .sidebar-settings-panel {
        background: rgba(8, 13, 26, 0.97);
        border-left-color: rgba(24, 38, 63, 0.6);
        color: rgba(226, 232, 240, 0.92);
    }

    body.theme-dark .settings-panel-header p,
    body.theme-dark .settings-item p {
        color: rgba(148, 163, 184, 0.78);
    }

    body.theme-dark .sidebar-search {
        background: rgba(12, 19, 35, 0.92);
        border-color: rgba(57, 72, 99, 0.55);
    }

    body.theme-dark .sidebar-settings-panel button.btn {
        color: rgba(226, 232, 240, 0.92);
        border-color: rgba(79, 70, 229, 0.25);
    }

    body.theme-dark .sidebar-settings-panel .btn-outline-secondary:hover,
    body.theme-dark .sidebar-settings-panel .btn-outline-primary:hover {
        background: rgba(79, 70, 229, 0.25);
        border-color: rgba(79, 70, 229, 0.45);
        color: #f8fafc;
    }

    .sidebar-link:focus-visible,
    .sidebar-sublink:focus-visible,
    .sidebar-icon-button:focus-visible,
    .sidebar-account-toggle:focus-visible,
    .quick-action:focus-visible {
        outline: 2px solid rgba(59, 130, 246, 0.5);
        outline-offset: 2px;
    }

    #accordionSidebar.toggled {
        width: 5rem;
        flex: 0 0 5rem;
    }

    #accordionSidebar.toggled .sidebar-label,
    #accordionSidebar.toggled .sidebar-section-label,
    #accordionSidebar.toggled .quick-action span,
    #accordionSidebar.toggled .quick-action kbd,
    #accordionSidebar.toggled .sidebar-account-copy,
    #accordionSidebar.toggled .sidebar-badge,
    #accordionSidebar.toggled .sidebar-pill {
        display: none !important;
    }

    #accordionSidebar.toggled .sidebar-top {
        align-items: center;
        gap: 0.4rem;
    }

    #accordionSidebar.toggled .sidebar-quick-actions {
        display: none !important;
    }

    #accordionSidebar.toggled .sidebar-account-card {
        display: none !important;
    }

    #accordionSidebar.toggled .sidebar-nav {
        overflow: visible;
        align-items: center;
        padding-right: 0;
    }

    #accordionSidebar.toggled .sidebar-modern {
        padding-inline: 0.6rem;
        align-items: center;
    }

    #accordionSidebar.toggled .sidebar-link,
    #accordionSidebar.toggled .sidebar-sublink {
        justify-content: center;
        width: 48px;
        padding: 0.4rem;
    }

    #accordionSidebar.toggled .sidebar-icon {
        margin: 0;
    }

    #accordionSidebar.toggled .sidebar-submenu ul {
        padding-left: 0;
        align-items: center;
    }

    #accordionSidebar.toggled .sidebar-submenu {
        margin-left: 0;
    }

    #accordionSidebar.toggled .sidebar-section {
        align-items: center;
    }

    #accordionSidebar.toggled .sidebar-bottom-actions {
        flex-direction: column;
        display: none !important;
    }

    @media (max-width: 767.98px) {
        #wrapper {
            display: block;
        }

        #accordionSidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            transform: translateX(-105%);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.2);
            z-index: 1045;
            width: min(82vw, 17.5rem) !important;
            flex: 0 0 auto !important;
        }

        body.sidebar-open #accordionSidebar {
            transform: translateX(0);
        }

        .sidebar.toggled {
            transform: translateX(-105%);
            width: min(82vw, 17.5rem) !important;
        }

        body.sidebar-open {
            overflow: hidden;
        }

        .mobile-sidebar-backdrop {
            display: none;
        }

        body.sidebar-open .mobile-sidebar-backdrop {
            display: block;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            z-index: 1040;
        }

        .compact-topbar {
            z-index: 1042;
        }

        .sidebar-expand-handle {
            display: none !important;
        }
    }
</style>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const commandPalette = document.getElementById('sidebarCommandPalette');
            const commandInput = document.getElementById('commandPaletteInput');
            const commandResults = document.getElementById('commandPaletteResults');
            const commandOpeners = document.querySelectorAll('[data-command-open]');
            const commandClosers = document.querySelectorAll('[data-command-close]');

            const settingsPanel = document.getElementById('sidebarSettingsFlyout');
            const settingsOpeners = document.querySelectorAll('[data-settings-open]');
            const settingsCloser = document.querySelector('[data-settings-close]');
            const settingsThemeBtn = document.querySelector('[data-settings-theme]');
            const settingsCompactBtn = document.querySelector('[data-settings-compact]');
            const soundToggle = document.getElementById('sidebarSoundToggle');

            const sidebarToggleBtn = document.getElementById('sidebarToggle');
            const themeToggleButton = document.querySelector('.theme-toggle');
            const sidebarExpandHandle = document.querySelector('[data-sidebar-expand]');

            const paletteItems = @json($commandPaletteItems);

            const openPalette = () => {
                if (!commandPalette) {
                    return;
                }
                commandPalette.classList.add('is-open');
                commandPalette.setAttribute('aria-hidden', 'false');
                commandInput.value = '';
                renderPaletteResults('');
                setTimeout(() => commandInput.focus(), 60);
            };

            const closePalette = () => {
                if (!commandPalette) {
                    return;
                }
                commandPalette.classList.remove('is-open');
                commandPalette.setAttribute('aria-hidden', 'true');
            };

            const renderPaletteResults = (term) => {
                if (!commandResults) {
                    return;
                }
                const keyword = term.trim().toLowerCase();
                const matches = paletteItems.filter(item => {
                    if (!keyword) {
                        return true;
                    }
                    return item.label.toLowerCase().includes(keyword) || (item.group && item.group.toLowerCase().includes(keyword));
                }).slice(0, 12);

                commandResults.innerHTML = '';

                if (matches.length === 0) {
                    const empty = document.createElement('li');
                    empty.textContent = 'No matches found.';
                    commandResults.appendChild(empty);
                    return;
                }

                matches.forEach((item, index) => {
                    const li = document.createElement('li');
                    const link = document.createElement('a');
                    link.href = item.href;
                    link.className = 'command-result-item';
                    if (index === 0) {
                        link.classList.add('is-active');
                    }
                    link.dataset.index = index.toString();

                    const iconWrap = document.createElement('span');
                    iconWrap.className = 'result-icon';
                    const icon = document.createElement('i');
                    icon.className = item.icon || 'fas fa-circle';
                    iconWrap.appendChild(icon);

                    const meta = document.createElement('span');
                    meta.className = 'result-meta';
                    meta.innerHTML = '<strong>' + item.label + '</strong>' + (item.group ? '<span class="result-group">' + item.group + '</span>' : '');

                    link.appendChild(iconWrap);
                    link.appendChild(meta);
                    link.addEventListener('click', closePalette);

                    li.appendChild(link);
                    commandResults.appendChild(li);
                });
            };

            const activateFirstResult = () => {
                const first = commandResults?.querySelector('.command-result-item');
                if (first) {
                    window.location.href = first.getAttribute('href');
                }
            };

            commandOpeners.forEach(btn => {
                btn.addEventListener('click', (event) => {
                    event.preventDefault();
                    openPalette();
                });
            });

            commandClosers.forEach(btn => {
                btn.addEventListener('click', closePalette);
            });

            commandInput?.addEventListener('input', (event) => {
                renderPaletteResults(event.target.value);
            });

            commandInput?.addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    activateFirstResult();
                }
                if (event.key === 'Escape') {
                    closePalette();
                }
            });

            document.addEventListener('keydown', (event) => {
                if ((event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k') {
                    event.preventDefault();
                    if (commandPalette?.classList.contains('is-open')) {
                        closePalette();
                    } else {
                        openPalette();
                    }
                }
                if (event.key === 'Escape') {
                    closePalette();
                    if (settingsPanel?.classList.contains('is-open')) {
                        settingsPanel.classList.remove('is-open');
                    }
                }
            });

            const openSettings = () => settingsPanel?.classList.add('is-open');
            const closeSettings = () => settingsPanel?.classList.remove('is-open');

            settingsOpeners.forEach(btn => btn.addEventListener('click', openSettings));
            settingsCloser?.addEventListener('click', closeSettings);

            settingsThemeBtn?.addEventListener('click', () => {
                themeToggleButton?.click();
            });

            settingsCompactBtn?.addEventListener('click', () => {
                sidebarToggleBtn?.click();
            });
            sidebarExpandHandle?.addEventListener('click', () => {
                sidebarToggleBtn?.click();
            });

            const SOUND_PREF_KEY = 'cv.sidebar.sound';
            const storedSoundPref = localStorage.getItem(SOUND_PREF_KEY);
            if (soundToggle) {
                soundToggle.checked = storedSoundPref !== 'off';
                soundToggle.addEventListener('change', () => {
                    localStorage.setItem(SOUND_PREF_KEY, soundToggle.checked ? 'on' : 'off');
                });
            }

            const playChime = () => {
                if (!soundToggle?.checked) {
                    return;
                }
                try {
                    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                    const oscillator = audioContext.createOscillator();
                    const gainNode = audioContext.createGain();
                    oscillator.type = 'sine';
                    oscillator.frequency.setValueAtTime(880, audioContext.currentTime);
                    gainNode.gain.setValueAtTime(0.0001, audioContext.currentTime);
                    gainNode.gain.linearRampToValueAtTime(0.08, audioContext.currentTime + 0.01);
                    gainNode.gain.exponentialRampToValueAtTime(0.0001, audioContext.currentTime + 0.35);
                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);
                    oscillator.start();
                    oscillator.stop(audioContext.currentTime + 0.4);
                } catch (err) {
                    console.warn('Unable to play notification sound.', err);
                }
            };

            document.querySelectorAll('.quick-action').forEach(action => {
                action.addEventListener('click', playChime);
            });
        });
    </script>
@endpush
