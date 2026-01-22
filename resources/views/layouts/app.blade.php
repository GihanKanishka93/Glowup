<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="/img/facv.ico" type="image/x-icon">
    <link rel="stylesheet" href="{{ request()->getBasePath() }}/plugin/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="{{ request()->getBasePath() }}/plugin/fontawesome-free/css/v4-shims.min.css" />
    @stack('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    {{-- <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('plugin/toastr/toastr.css') }}">
    <style>
        :root {
            --app-bg: #FDFBF7;
            --surface: #FFFFFF;
            --surface-alt: #F4EFE6;
            --text-primary: #1F1A12;
            --text-muted: #5A5244;
            --border: #E2D8C7;
            --border-strong: #C7B79E;
            --primary: #DAA100;
            --primary-hover: #C48A00;
            --primary-contrast: #FFFFFF;
            --accent: #FFCC4D;
            --accent-contrast: #0C0A07;
            --success: #3FAE6A;
            --success-hover: #34995C;
            --success-contrast: #FFFFFF;
            --warning: #E6A23C;
            --warning-hover: #C7872F;
            --warning-contrast: #0C0A07;
            --danger: #C0453F;
            --danger-hover: #A83C37;
            --danger-contrast: #FFFFFF;
            --info: #3C89D4;
            --info-hover: #2F72B4;
            --info-contrast: #0C0A07;
            --shadow-sm: 0 10px 24px rgba(34, 24, 6, 0.12);
            --field-bg: #FDFBF7;
            --field-border: #E2D8C7;
            --field-text: #1F1A12;
        }
        body.theme-dark {
            --app-bg: #0C0A07;
            --surface: #16120D;
            --surface-alt: #1E1911;
            --text-primary: #F7EBD4;
            --text-muted: #BFAF90;
            --border: #2B2418;
            --border-strong: #3A2F20;
            --primary: #DAA100;
            --primary-hover: #C48A00;
            --primary-contrast: #0C0A07;
            --accent: #FFCC4D;
            --accent-contrast: #0C0A07;
            --success: #3FAE6A;
            --success-hover: #34995C;
            --success-contrast: #06100A;
            --warning: #E6A23C;
            --warning-hover: #C7872F;
            --warning-contrast: #0C0A07;
            --danger: #C0453F;
            --danger-hover: #A83C37;
            --danger-contrast: #0C0A07;
            --info: #3C89D4;
            --info-hover: #2F72B4;
            --info-contrast: #0C0A07;
            --shadow-sm: 0 24px 42px rgba(0, 0, 0, 0.55);
            --field-bg: #1E1911;
            --field-border: #2B2418;
            --field-text: #F7EBD4;
        }
        body.theme-dark {
            background-color: var(--app-bg);
            background-image: radial-gradient(circle at 16% 18%, rgba(218, 161, 0, 0.14) 0%, transparent 48%),
                              radial-gradient(circle at 82% 12%, rgba(60, 137, 212, 0.12) 0%, transparent 42%),
                              radial-gradient(circle at 42% 78%, rgba(63, 174, 106, 0.12) 0%, transparent 50%),
                              linear-gradient(135deg, #0C0A07 0%, #16120D 52%, #1E1911 100%);
            background-attachment: fixed;
        }
        body {
            background-color: var(--app-bg);
            color: var(--text-primary);
            font-family: 'Inter', 'Segoe UI', Tahoma, sans-serif;
            transition: background-color .25s ease, color .25s ease;
        }
        h1, h2, h3, h4, h5, h6 {
            color: var(--text-primary);
        }
        a {
            color: var(--primary);
            text-decoration: none;
        }
        a:hover,
        a:focus {
            color: var(--primary-hover);
            text-decoration: underline;
        }
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: var(--primary-contrast);
        }
        .btn-primary:hover,
        .btn-primary:focus {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            color: var(--primary-contrast);
        }
        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }
        .btn-outline-primary:hover,
        .btn-outline-primary:focus {
            background-color: var(--primary);
            border-color: var(--primary);
            color: var(--primary-contrast);
        }
        .btn-success { background-color: var(--success); border-color: var(--success); color: var(--success-contrast); }
        .btn-success:hover,
        .btn-success:focus { background-color: var(--success-hover); border-color: var(--success-hover); color: var(--success-contrast); }
        .btn-warning { background-color: var(--warning); border-color: var(--warning); color: var(--warning-contrast); }
        .btn-warning:hover,
        .btn-warning:focus { background-color: var(--warning-hover); border-color: var(--warning-hover); color: var(--warning-contrast); }
        .btn-danger { background-color: var(--danger); border-color: var(--danger); color: var(--danger-contrast); }
        .btn-danger:hover,
        .btn-danger:focus { background-color: var(--danger-hover); border-color: var(--danger-hover); color: var(--danger-contrast); }
        .btn-info { background-color: var(--info); border-color: var(--info); color: var(--info-contrast); }
        .btn-info:hover,
        .btn-info:focus { background-color: var(--info-hover); border-color: var(--info-hover); color: var(--info-contrast); }
        .badge-primary { background-color: var(--primary); color: var(--primary-contrast); }
        .badge-success { background-color: var(--success); color: var(--success-contrast); }
        .badge-warning { background-color: var(--warning); color: var(--warning-contrast); }
        .badge-danger { background-color: var(--danger); color: var(--danger-contrast); }
        .badge-info { background-color: var(--info); color: var(--info-contrast); }
        .badge-neutral { background-color: rgba(148, 163, 184, 0.25); color: var(--text-primary); }
        .form-control,
        .form-select,
        .select2-container--default .select2-selection--single {
            border-color: var(--field-border);
            color: var(--field-text);
            background-color: var(--field-bg);
        }
        .select2-container--default .select2-selection--single {
            min-height: 46px;
            display: flex;
            align-items: center;
            border-radius: .6rem;
            padding: 0 .75rem;
            background-color: var(--field-bg) !important;
            border: 1px solid var(--field-border) !important;
            transition: border-color .2s ease, box-shadow .2s ease;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--field-text) !important;
            line-height: normal;
            padding-left: 0;
            padding-right: 1.75rem;
            display: flex;
            align-items: center;
            width: 100%;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: rgba(100, 116, 139, 0.85) !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            right: .75rem;
        }
        .select2-dropdown {
            background-color: #fffdfa !important;
            border: 1px solid rgba(250, 204, 21, 0.3) !important;
            color: var(--field-text) !important;
            border-radius: .75rem;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }
        .select2-results__option {
            color: var(--field-text);
        }
        .select2-results__option--highlighted[aria-selected] {
            background-color: rgba(250, 204, 21, 0.25) !important;
            color: #1f2937 !important;
        }
        .form-control::placeholder,
        .form-select::placeholder {
            color: rgba(100, 116, 139, 0.7);
        }
        .form-control:focus,
        .form-select:focus,
        .select2-container--default .select2-selection--single:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(29, 78, 216, 0.15);
        }
        body.theme-dark .form-control,
        body.theme-dark .form-select,
        body.theme-dark .select2-container--default .select2-selection--single {
            background-color: var(--field-bg) !important;
            color: var(--field-text) !important;
            border-color: var(--field-border) !important;
            box-shadow: inset 0 0 0 1px rgba(15, 23, 42, 0.12);
        }
        body.theme-dark .form-control::placeholder,
        body.theme-dark .form-select::placeholder {
            color: rgba(55, 65, 81, 0.75);
        }
        body.theme-dark .form-control:focus,
        body.theme-dark .form-select:focus,
        body.theme-dark .select2-container--default .select2-selection--single:focus {
            border-color: rgba(250, 204, 21, 0.9);
            box-shadow: 0 0 0 0.2rem rgba(250, 204, 21, 0.28);
        }
        body.theme-dark .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--field-text) !important;
        }
        body.theme-dark .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: rgba(55, 65, 81, 0.75) !important;
        }
        body.theme-dark .select2-dropdown {
            background-color: rgba(8, 13, 26, 0.95) !important;
            border-color: rgba(57, 72, 99, 0.55) !important;
            color: rgba(226, 232, 240, 0.9) !important;
            box-shadow: 0 18px 32px rgba(1, 5, 17, 0.55);
        }
        body.theme-dark .select2-results__option {
            color: rgba(226, 232, 240, 0.9);
        }
        body.theme-dark .select2-results__option--highlighted[aria-selected] {
            background-color: rgba(250, 204, 21, 0.25) !important;
            color: #1f2937 !important;
        }
        .patient-snapshot-grid {
            --bs-gutter-y: 0.95rem;
            row-gap: 0.95rem;
        }
        .patient-snapshot-grid > [class*="col-"] {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        .patient-snapshot-grid .form-label {
            margin-bottom: 0;
        }
        .table thead th {
            background-color: var(--surface);
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }
        .table tbody td,
        .table tbody th {
            color: var(--text-primary);
            border-top: 1px solid var(--border);
        }
        .table-striped tbody tr:nth-of-type(odd) > * {
            background-color: rgba(148, 163, 184, 0.12);
        }
        .table-hover tbody tr:hover > * {
            background-color: rgba(29, 78, 216, 0.08);
        }
        .card,
        .card .card-body,
        .card .card-header {
            background-color: var(--surface);
            color: var(--text-primary);
            border-color: var(--border);
        }
        .card {
            box-shadow: var(--shadow-sm);
        }
        .container-fluid {
            max-width: 100%;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            padding-bottom: 2rem;
        }
        .compact-topbar {
            min-height: 48px;
            padding: .6rem 1rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: .75rem;
            margin-bottom: 1.25rem;
            gap: 1rem;
            box-shadow: var(--shadow-sm);
            position: sticky !important;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }
        #content {
            position: relative;
            overflow: visible !important;
        }
        #wrapper #content-wrapper {
            overflow: visible !important;
        }
        .global-search {
            background: var(--surface-alt);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 0 .75rem;
            min-width: 320px;
            box-shadow: var(--shadow-sm);
        }
        .global-search .form-control {
            border: none;
            background: transparent;
            padding-left: .75rem;
            box-shadow: none;
            font-size: .9rem;
            color: var(--text-primary);
        }
        .global-search .form-control::placeholder {
            color: var(--text-muted);
            opacity: .85;
        }
        .global-search .form-control:focus {
            box-shadow: none;
        }
        .global-search .search-icon {
            color: var(--text-muted);
            font-size: .85rem;
        }
        .compact-topbar .btn {
            color: var(--text-muted);
        }
        .compact-topbar .btn:hover {
            color: var(--text-primary);
        }
        .theme-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: var(--surface-alt);
            color: var(--text-muted);
            transition: all .2s ease;
        }
        .theme-toggle:hover {
            color: var(--primary);
            border-color: var(--primary);
        }
        .sidebar-account {
            background: rgba(255, 255, 255, 0.12);
            border-radius: .75rem;
            padding: .65rem;
            margin: 0 1.1rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.25);
            position: relative;
            overflow: visible;
            z-index: 1;
        }
        body.theme-dark .sidebar-account {
            background: rgba(15, 23, 42, 0.75);
            border-color: rgba(148, 163, 184, 0.25);
        }
        .sidebar-account .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.45);
        }
        .sidebar-account .user-name {
            font-size: .95rem;
            font-weight: 600;
        }
        .sidebar-account .user-role {
            font-size: .75rem;
            opacity: .85;
        }
        .sidebar-account .status-pill {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            font-size: .7rem;
            padding: .2rem .55rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.18);
            color: #fff;
            text-transform: uppercase;
            letter-spacing: .02em;
        }
        .sidebar-account .status-pill.status-available { background: rgba(34, 197, 94, 0.28); }
        .sidebar-account .status-pill.status-in_consult { background: rgba(245, 158, 11, 0.32); }
        .sidebar-account .status-pill.status-offline { background: rgba(239, 68, 68, 0.32); }
        .sidebar-account .status-pill i {
            font-size: .65rem;
        }
        .sidebar-user-toggle {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            padding: .7rem .7rem .6rem;
            border-radius: .7rem;
            width: 100%;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .45rem;
            min-height: 95px;
            white-space: normal;
        }
        .sidebar-user-toggle.dropdown-toggle::after {
            display: none;
        }
        .sidebar-user-toggle .toggle-icon {
            font-size: .8rem;
        }
        body.theme-dark .sidebar-user-toggle {
            border-color: rgba(148, 163, 184, 0.4);
        }
        .sidebar-user-toggle .user-details {
            display: flex;
            flex-direction: column;
            gap: .2rem;
            min-width: 0;
            flex: 1 1 auto;
            align-items: center;
        }
        .sidebar-user-toggle .user-name,
        .sidebar-user-toggle .user-role {
            white-space: normal;
            word-break: break-word;
        }
        .sidebar-user-toggle .status-pill {
            margin-top: .25rem;
            display: inline-flex;
            align-self: center;
        }
        .sidebar-account .dropdown-menu {
            background-color: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-primary);
            width: 100%;
        }
        .sidebar-account .dropdown-item {
            color: var(--text-primary);
        }
        .sidebar-account .dropdown-item .status-indicator {
            width: .6rem;
            height: .6rem;
            border-radius: 50%;
            margin-right: .6rem;
        }
        .status-indicator.available { background: #22c55e; }
        .status-indicator.in_consult { background: #f59e0b; }
        .status-indicator.offline { background: #ef4444; }
        .sidebar-account .dropdown-item.active,
        .sidebar-account .dropdown-item:active {
            background-color: var(--primary);
            color: var(--primary-contrast);
        }
        .sidebar .nav-item .nav-link::after {
            display: none !important;
        }
        .sidebar .nav-item .nav-link .nav-caret {
            margin-left: auto;
            color: rgba(255, 255, 255, 0.6);
            transition: transform .2s ease;
            font-size: .75rem;
        }
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: .65rem;
            color: rgba(255,255,255,0.85);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.65rem 0.85rem;
            border-radius: 0.85rem;
            transition: background-color .2s ease, color .2s ease, transform .2s ease;
        }
        .sidebar .nav-link i {
            display: inline-flex;
            align-items: center;
            font-size: 1.1rem;
            color: inherit;
            opacity: .75;
            transition: opacity .2s ease, transform .2s ease;
        }
        .sidebar .nav-link:hover i,
        .sidebar .nav-link:not(.collapsed) i,
        .sidebar .nav-item.active .nav-link i {
            opacity: 1;
        }
        .sidebar .nav-item.active > .nav-link {
            background: linear-gradient(135deg, rgba(59,130,246,0.28), rgba(79,70,229,0.28));
            color: #fff;
            box-shadow: inset 2px 0 0 rgba(59,130,246,0.9);
        }
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(1px);
        }
        .sidebar .sidebar-heading {
            font-size: 0.75rem;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.6);
            margin: 0.75rem 1rem 0.35rem;
        }
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255,255,255,0.2);
            border-radius: 999px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar .nav-item .nav-link:not(.collapsed) .nav-caret i,
        .sidebar .nav-item .nav-link[aria-expanded="true"] .nav-caret i {
            transform: rotate(90deg);
        }
        .sidebar .nav-item .nav-link .nav-caret i {
            display: inline-block;
        }
        #sidebarToggle {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.25) !important;
            color: var(--primary);
            border-radius: 12px;
            transition: background-color .2s ease, color .2s ease, transform .2s ease;
        }
        #sidebarToggle:hover {
            background: rgba(59, 130, 246, 0.18);
            color: var(--primary);
            transform: translateY(-1px);
        }
        #sidebarToggle i {
            font-size: 1.1rem;
        }
        body.theme-dark .dropdown-menu {
            background-color: var(--surface);
            color: var(--text-primary);
        }
        body.theme-dark .dropdown-item {
            color: var(--text-primary);
        }
        #accordionSidebar.toggled .sidebar-account .user-details,
        #accordionSidebar.toggled .sidebar-account .sidebar-user-toggle .user-role,
        #accordionSidebar.toggled .sidebar-account .status-pill,
        #accordionSidebar.toggled .sidebar-account .sidebar-user-toggle .user-name,
        #accordionSidebar.toggled .sidebar-account .sidebar-user-toggle .toggle-icon,
        #accordionSidebar.toggled .sidebar-account .dropdown-menu {
            display: none !important;
        }
        #accordionSidebar.toggled .sidebar-account {
            padding: .65rem .5rem;
            display: flex;
            justify-content: center;
            overflow: visible;
        }
        #accordionSidebar.toggled .sidebar-account .sidebar-user-toggle {
            padding: .5rem;
            min-height: auto;
            width: auto;
        }
        #accordionSidebar.toggled .sidebar-account .avatar {
            width: 40px;
            height: 40px;
            border-width: 0;
        }
        .billing-card,
        .billing-workspace,
        .billing-card .card-header,
        .billing-card .card-body,
        .sticky-card {
            background-color: var(--surface);
            border-color: var(--border);
            color: var(--text-primary);
        }
        .glance-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f3f4f6 100%);
            border: 1px solid rgba(148, 163, 184, 0.25);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
        }
        .glance-grid {
            --bs-gutter-y: .65rem;
        }
        .glance-item {
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: .75rem;
            padding: .65rem .75rem;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.6);
        }
        .glance-label {
            font-size: .75rem;
            letter-spacing: .02em;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: .2rem;
            font-weight: 700;
        }
        .glance-value {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
        }
        .glance-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-size: 0.9rem;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.45);
        }
        .billing-card .card-header {
            border-bottom: 1px solid var(--border);
        }
        .billing-card .list-group-item {
            background-color: var(--surface);
            color: var(--text-primary);
            border-color: var(--border);
        }
        .billing-card .text-muted,
        .billing-workspace .text-muted {
            color: var(--text-muted) !important;
        }
        .billing-workspace .form-control,
        .billing-workspace .select2-container--default .select2-selection--single {
            border-radius: .6rem;
            border: 1px solid var(--border);
            background-color: var(--surface);
            color: var(--text-primary);
        }
        .billing-workspace .form-control::placeholder {
            color: var(--text-muted);
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-primary);
            line-height: 36px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: var(--text-muted) transparent transparent transparent;
        }
        .select2-dropdown {
            border: 1px solid var(--border);
            background-color: var(--surface);
            color: var(--text-primary);
        }
        .quick-actions .btn {
            border-radius: 999px;
            padding-inline: 1.1rem;
            border: 1px solid var(--border);
            background: var(--surface);
            box-shadow: var(--shadow-sm);
            color: var(--primary);
        }
        .quick-actions .btn:hover,
        .quick-actions .btn:focus {
            background: var(--primary);
            color: var(--primary-contrast);
            border-color: var(--primary);
        }
        .billing-flow {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }
        .billing-section-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 0.6rem 0.75rem;
            box-shadow: var(--shadow-sm);
            position: static;
        }
        .billing-nav-link {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.45rem 0.85rem;
            border-radius: 0.65rem;
            border: 1px solid transparent;
            background: var(--surface-alt);
            color: var(--text-muted);
            font-weight: 600;
            text-decoration: none;
            transition: background .2s ease, color .2s ease, transform .2s ease, border-color .2s ease;
        }
        .billing-nav-link:hover,
        .billing-nav-link:focus-visible {
            background: rgba(59, 130, 246, 0.16);
            color: var(--primary);
            border-color: rgba(59, 130, 246, 0.25);
            transform: translateY(-1px);
            outline: none;
        }
        .billing-nav-link.is-current {
            background: linear-gradient(135deg, var(--primary) 0%, #4338ca 100%);
            color: var(--primary-contrast);
            border-color: transparent;
            box-shadow: 0 10px 22px rgba(29, 78, 216, 0.18);
        }
        .billing-nav-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.15);
            color: #2563eb;
            font-size: 0.9rem;
        }
        .billing-nav-link.is-current .billing-nav-icon {
            background: rgba(255, 255, 255, 0.25);
            color: var(--primary-contrast);
        }
        .billing-sections {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }
        .billing-section {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 1rem;
            box-shadow: var(--shadow-sm);
            padding: 0.9rem 1rem;
        }
        .billing-section .panel-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }
        .billing-section .panel-body {
            background: var(--surface);
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 0.9rem;
            padding: 0.9rem;
        }
        body.theme-dark .billing-section {
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid rgba(79, 70, 229, 0.35);
            box-shadow: 0 20px 44px rgba(1, 5, 17, 0.55);
        }
        body.theme-dark .billing-section .panel-title {
            color: #e2e8f0;
            margin-bottom: 1.05rem;
            padding-bottom: 0.35rem;
            border-bottom: 1px solid rgba(79, 70, 229, 0.35);
            text-transform: none;
            letter-spacing: normal;
            display: block;
        }
        body.theme-dark .billing-section .panel-body {
            background: rgba(8, 13, 26, 0.75);
            border: 1px solid rgba(71, 85, 105, 0.5);
            border-radius: 0.9rem;
        }
        body.theme-dark .billing-section-nav {
            background: rgba(10, 16, 31, 0.92);
            border-color: rgba(71, 85, 105, 0.55);
        }
        body.theme-dark .billing-nav-link {
            background: rgba(24, 33, 51, 0.78);
            color: rgba(226, 232, 240, 0.9);
            border-color: rgba(79, 70, 229, 0.15);
        }
        body.theme-dark .billing-nav-link.is-current {
            background: rgba(79, 70, 229, 0.28);
            color: #e0e7ff;
            border-color: rgba(79, 70, 229, 0.45);
            box-shadow: 0 16px 32px rgba(5, 12, 32, 0.55);
        }
        .panel-divider {
            border-bottom: 1px dashed var(--border);
            margin: 1.5rem 0 1rem;
        }
        .panel-subtitle {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.75rem;
        }
        .summary-hints {
            background: var(--surface-alt);
            color: var(--text-muted);
        }
        .summary-hints span:last-child {
            color: var(--text-primary);
            font-weight: 600;
        }
        .billing-dashboard .billing-grid {
            gap: 1.5rem !important;
        }
        .list-page {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .list-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1rem 1.25rem;
            box-shadow: var(--shadow-sm);
        }
        .list-toolbar-heading {
            display: flex;
            flex-direction: column;
            gap: .35rem;
        }
        .page-title {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
        }
        .page-subtitle {
            margin: 0;
            color: var(--text-muted);
            font-size: .9rem;
        }
        .list-toolbar-actions {
            display: flex;
            align-items: center;
            gap: .75rem;
        }
        .list-toolbar-actions .btn {
            border-radius: .65rem;
            padding-inline: 1rem;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
        }
        .list-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 1rem;
            box-shadow: var(--shadow-sm);
        }
        .list-card .card-body {
            padding: 1.5rem;
        }
        .list-back-btn {
            background: transparent;
        }
        .list-back-btn:hover {
            background: rgba(29, 78, 216, 0.08);
            border-color: var(--primary);
            color: var(--primary);
        }
        .dt-buttons .dt-button,
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border-radius: .6rem;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text-primary);
            padding: .4rem .75rem;
        }
        .dataTables_wrapper .dataTables_filter input {
            margin-left: .5rem;
        }
        .dataTables_wrapper .dataTables_filter label {
            color: var(--text-muted);
            font-weight: 600;
        }
        .dataTables_wrapper .dataTables_length select {
            padding-right: 2rem;
        }
        .dt-buttons .dt-button {
            background: var(--surface);
            border-color: var(--border);
            color: var(--text-primary);
            font-weight: 600;
            box-shadow: var(--shadow-sm);
        }
        .dt-buttons .dt-button:hover,
        .dt-buttons .dt-button:focus {
            background: var(--primary);
            border-color: var(--primary);
            color: var(--primary-contrast);
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: .6rem;
            border: 1px solid transparent;
            padding: .35rem .8rem;
            margin: 0 .2rem;
            color: var(--text-primary) !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--primary) !important;
            color: var(--primary-contrast) !important;
            border-color: var(--primary) !important;
        }
        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted);
            padding-top: 1rem;
        }
        table.dataTable {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0;
        }
        table.dataTable thead th {
            background: var(--surface);
            color: var(--text-muted);
            border-bottom: 1px solid rgba(148, 163, 184, 0.4);
            font-size: .82rem;
            letter-spacing: .05em;
            text-transform: uppercase;
            font-weight: 700;
        }
        body.theme-dark table.dataTable thead th,
        body.theme-dark .table thead th {
            background: rgba(12, 19, 35, 0.85);
            color: rgba(226, 232, 240, 0.86);
            border-bottom-color: rgba(94, 129, 172, 0.4);
        }
        table.dataTable tbody td {
            border-color: var(--border);
            color: var(--text-primary);
            vertical-align: middle;
        }
        table.dataTable tbody tr,
        .table tbody tr {
            background-color: transparent;
        }
        table.dataTable tbody tr td,
        table.dataTable tbody tr th,
        .table tbody tr td,
        .table tbody tr th {
            border-top: 1px solid rgba(148, 163, 184, 0.22) !important;
            color: var(--text-primary);
        }
        table.dataTable tbody tr:nth-child(odd) > td,
        table.dataTable tbody tr:nth-child(odd) > th,
        table.dataTable.display tbody tr:nth-child(odd) > td,
        table.dataTable.display tbody tr:nth-child(odd) > th,
        .table-striped tbody tr:nth-of-type(odd) > td,
        .table-striped tbody tr:nth-of-type(odd) > th {
            background-color: var(--surface) !important;
            --bs-table-accent-bg: var(--surface);
        }
        table.dataTable tbody tr:nth-child(even) > td,
        table.dataTable tbody tr:nth-child(even) > th,
        table.dataTable.display tbody tr:nth-child(even) > td,
        table.dataTable.display tbody tr:nth-child(even) > th,
        .table-striped tbody tr:nth-of-type(even) > td,
        .table-striped tbody tr:nth-of-type(even) > th {
            background-color: rgba(148, 163, 184, 0.1) !important;
            --bs-table-accent-bg: rgba(148, 163, 184, 0.1);
        }
        body.theme-dark table.dataTable tbody tr:nth-child(odd) > td,
        body.theme-dark table.dataTable tbody tr:nth-child(odd) > th,
        body.theme-dark table.dataTable.display tbody tr:nth-child(odd) > td,
        body.theme-dark table.dataTable.display tbody tr:nth-child(odd) > th,
        body.theme-dark .table-striped tbody tr:nth-of-type(odd) > td,
        body.theme-dark .table-striped tbody tr:nth-of-type(odd) > th {
            background-color: rgba(16, 23, 42, 0.92) !important;
            --bs-table-accent-bg: rgba(16, 23, 42, 0.92);
        }
        body.theme-dark table.dataTable tbody tr:nth-child(even) > td,
        body.theme-dark table.dataTable tbody tr:nth-child(even) > th,
        body.theme-dark table.dataTable.display tbody tr:nth-child(even) > td,
        body.theme-dark table.dataTable.display tbody tr:nth-child(even) > th,
        body.theme-dark .table-striped tbody tr:nth-of-type(even) > td,
        body.theme-dark .table-striped tbody tr:nth-of-type(even) > th {
            background-color: rgba(13, 21, 38, 0.78) !important;
            --bs-table-accent-bg: rgba(13, 21, 38, 0.78);
        }
        body.theme-dark table.dataTable tbody tr td,
        body.theme-dark table.dataTable tbody tr th,
        body.theme-dark .table tbody tr td,
        body.theme-dark .table tbody tr th {
            color: rgba(226, 232, 240, 0.9);
            border-top-color: rgba(94, 129, 172, 0.35) !important;
        }
        table.dataTable tbody tr:hover > td,
        table.dataTable tbody tr:hover > th,
        .table tbody tr:hover > td,
        .table tbody tr:hover > th {
            background-color: rgba(37, 99, 235, 0.12) !important;
        }
        body.theme-dark table.dataTable tbody tr:hover > td,
        body.theme-dark table.dataTable tbody tr:hover > th,
        body.theme-dark .table tbody tr:hover > td,
        body.theme-dark .table tbody tr:hover > th {
            background-color: rgba(79, 70, 229, 0.18) !important;
        }
        table.dataTable tbody tr td .btn {
            border-radius: .65rem;
        }
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1rem;
        }
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }
        .stat-chip {
            background: var(--surface-alt);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1rem 1.25rem;
            display: flex;
            flex-direction: column;
            gap: .25rem;
            box-shadow: var(--shadow-sm);
            height: 100%;
        }
        .stat-chip .label {
            font-size: .75rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .stat-chip .value {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
        }
        .upcomming-date {
            font-size: .85rem;
            font-weight: 600;
            color: var(--text-muted);
        }
        @media (min-width: 1200px) {
            .billing-dashboard .billing-grid {
                flex-wrap: nowrap;
            }
        }
        @media (min-width: 1400px) {
            .billing-dashboard .insight-column {
                flex: 0 0 320px;
                max-width: 320px;
            }
            .billing-dashboard .workspace-column {
                flex: 1 1 auto;
                max-width: none;
            }
        }
        @media (min-width: 1600px) {
            .billing-dashboard .insight-column {
                flex-basis: 360px;
                max-width: 360px;
            }
        }
        .loading {
	z-index: 20;
	position: absolute;
	top: 0;
	left:-5px;
	width: 100%;
	height: 100%;
    background-color: rgba(0,0,0,0.4);
}
.loading-content {
	position: absolute;
	border: 16px solid #f3f3f3; /* Light grey */
	border-top: 16px solid #3498db; /* Blue */
	border-radius: 50%;
	width: 50px;
	height: 50px;
	top: 40%;
	left:35%;
	animation: spin 2s linear infinite;
	}
    .sidebar .nav-item .collapse .collapse-inner .collapse-item.active{
        color: #00166b !important;
        font-weight: 700;
        background-color: #fff !important;
    }

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
      </style>

    @yield('third_party_stylesheets')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

</head>

@php
    $authUser = auth()->user();
    $activeTheme = $authUser?->theme ?? 'light';
@endphp
<body id="page-top" class="theme-{{ $activeTheme }}">
    <section id="loading">
        <div id="loading-content"></div>
      </section>

    <div id="wrapper">
        @include('layouts.menu')
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('layouts.top_menu')
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>

            </div>
            @include('layouts.footer')
        </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('plugin/toastr/toastr.min.js') }}"></script>

    <script>
        window.initializeSelect2 = window.initializeSelect2 || function(element, options) {
            var defaultOptions = {
                tags: true,
                width: '100%',
                createTag: function(params) {
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true
                    };
                }
            };

            var config = $.extend(true, {}, defaultOptions, options || {});
            var $elements = typeof element === 'string' ? $(element) : $(element);

            $elements.each(function() {
                var $select = $(this);
                if ($select.data('select2')) {
                    $select.select2('destroy');
                }
                $select.select2(config);
            });
        };
    </script>

    @yield('third_party_scripts')
    <script>

function showLoading() {
  document.querySelector('#loading').classList.add('loading');
  document.querySelector('#loading-content').classList.add('loading-content');
}

function hideLoading() {
  document.querySelector('#loading').classList.remove('loading');
  document.querySelector('#loading-content').classList.remove('loading-content');
}


        $(document).ready(function () {
            // Remove validation error when any input field gains focus
            $(".form-control").focus(function () {
                $(this).removeClass('is-invalid'); // Remove the 'is-invalid' class
                $(this).next('.invalid-feedback').html(''); // Clear the error message
            });
        });
    </script>
    @if (session()->has('info'))
        <script>
            $(document).ready(function() {
                toastr.info('{{ session()->get('info') }}')
            });
        </script>
    @endif
    @if (session()->has('danger'))
        <script>
            $(document).ready(function() {
                toastr.error('{{ session()->get('danger') }}')
            });
        </script>
    @endif
    @if (session()->has('message'))
        <script>
            $(document).ready(function() {
                toastr.success('{{ session()->get('message') }}')
            });
        </script>
    @endif
    @if (session()->has('success'))
        <script>
            $(document).ready(function() {
                toastr.success('{{ session()->get('success') }}')
            });
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.medical-history-btn');
            buttons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const url = this.getAttribute('href');
                    window.open(url, 'MedicalHistory', 'width=800,height=600,scrollbars=yes,resizable=yes');
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : null;
            const themeToggle = document.querySelector('.theme-toggle');
            const statusButtons = document.querySelectorAll('.user-status-option');
            const statusContainer = document.querySelector('.sidebar-account-status');
            const statusLabel = statusContainer ? statusContainer.querySelector('.user-status-label') : null;
            const sidebarToggleButton = document.getElementById('sidebarToggle');
            const sidebarToggleTop = document.getElementById('sidebarToggleTop');

            if (themeToggle) {
                themeToggle.addEventListener('click', function () {
                    const currentTheme = this.dataset.theme === 'dark' ? 'dark' : 'light';
                    const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';

                    const request = csrfToken ? fetch('{{ route('ui.theme') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ theme: nextTheme })
                    }) : Promise.reject();

                    request.then(response => response.ok ? response.json() : Promise.reject())
                      .then(data => {
                          document.body.classList.remove('theme-light', 'theme-dark');
                          document.body.classList.add('theme-' + data.theme);
                          themeToggle.dataset.theme = data.theme;
                          const icon = themeToggle.querySelector('i');
                          if (icon) {
                              icon.classList.remove('fa-sun', 'fa-moon');
                              icon.classList.add(data.theme === 'dark' ? 'fa-moon' : 'fa-sun');
                          }
                      })
                      .catch(() => console.warn('Unable to update theme preference.'));
                });
            }

            statusButtons.forEach(function (button) {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const status = this.dataset.status;
                    const label = this.dataset.label || status;

                    if (!csrfToken) {
                        console.warn('Unable to update status: CSRF token missing.');
                        return;
                    }

                    fetch('{{ route('ui.status') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ status })
                    }).then(response => response.ok ? response.json() : Promise.reject())
                      .then(data => {
                          statusButtons.forEach(btn => btn.classList.remove('active'));
                          this.classList.add('active');
                          if (statusLabel) {
                              statusLabel.textContent = label;
                          }
                          if (statusContainer) {
                              statusContainer.classList.remove('status-available', 'status-in_consult', 'status-offline');
                              statusContainer.classList.add('status-' + data.status);
                          }
                      })
                      .catch(() => console.warn('Unable to update status.'));
                });
            });

            const logoutButtons = document.querySelectorAll('.sidebar-logout-btn');
            logoutButtons.forEach(function (button) {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const form = document.getElementById('sidebar-logout-form');
                    if (form) {
                        form.submit();
                    }
                });
            });

            document.querySelectorAll('.dropdown-toggle').forEach(function (toggle) {
                new bootstrap.Dropdown(toggle, { autoClose: 'outside' });
            });

            const updateSidebarToggleIcon = () => {
                if (!sidebarToggleButton) {
                    return;
                }
                const icon = sidebarToggleButton.querySelector('i');
                if (!icon) {
                    return;
                }
                const collapsed = document.body.classList.contains('sidebar-toggled');
                icon.classList.remove('fa-chevron-left', 'fa-chevron-right');
                icon.classList.add(collapsed ? 'fa-chevron-right' : 'fa-chevron-left');
            };

            updateSidebarToggleIcon();

            const scheduleToggleRefresh = () => setTimeout(updateSidebarToggleIcon, 220);

            if (sidebarToggleButton) {
                sidebarToggleButton.addEventListener('click', scheduleToggleRefresh);
            }
            if (sidebarToggleTop) {
                sidebarToggleTop.addEventListener('click', scheduleToggleRefresh);
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
