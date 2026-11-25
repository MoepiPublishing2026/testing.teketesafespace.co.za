{{-- Shared School Admin Sidebar — Dashboard, Reports, False Reports, Settings --}}
<x-admin-flash-messages />
@php
    $currentRoute = request()->route()?->getName() ?? '';
    $isDashboard = $currentRoute === 'admin.dashboard';
    $isReports = in_array($currentRoute, ['admin.reports', 'admin.reports.index', 'admin.reports.show'], true);
    $isFalseReports = $currentRoute === 'admin.false-reports';
    $isSettings = $currentRoute === 'admin.settings';
    $showExportPdf = $isDashboard;
@endphp

@once
<style>
/* Loaded with sidebar in <body> so page-level head CSS cannot override link colors */
body.sa-app aside#sa-sidebar.school-admin-sidebar {
    position: relative !important;
    width: 260px !important;
    min-width: 250px !important;
    height: 100vh !important;
    background-color: #ffffff !important;
    border-right: 3px solid #d7d7d7 !important;
    display: flex !important;
    flex-direction: column !important;
    padding-top: 151px !important;
    flex-shrink: 0 !important;
}
body.sa-app aside#sa-sidebar .sidebar-logo {
    position: absolute !important;
    top: 46px !important;
    left: 28px !important;
    width: 204.2px !important;
    height: 87.3px !important;
    z-index: 1001 !important;
    X: 33.9px;
    Y: 52.1px;
}
body.sa-app aside#sa-sidebar .sidebar-logo img {
    width: 204.2px !important;
    height: 87.3px !important;
    X: 33.9px;
    Y: 52.1px;
    display: block !important;
}
body.sa-app aside#sa-sidebar .sidebar-list {
    list-style: none !important;
    padding: 0 0 0 28px !important;
    margin: 0 !important;
}
body.sa-app aside#sa-sidebar .sidebar-list li {
    list-style: none !important;
    margin: 0 !important;
    padding: 0 !important;
}
body.sa-app aside#sa-sidebar nav a.sidebar-link {
    display: block !important;
    width: 205.5px !important;
    min-height: 24.4px !important;
    font-size: 15px !important;
    font-weight: normal !important;
    color: #545454 !important;
    font-family: 'Montserrat' !important;
    padding: 5px 8px !important;
    margin-bottom: 10px !important;
    border-radius: 10px !important;
    line-height: 24.4px !important;
    text-decoration: none !important;
    transition: all 0.25s ease !important;
    box-sizing: border-box !important;
    background: transparent !important;
    X: 78.1px;
    Y: 210.5px;
    -webkit-text-fill-color: #545454 !important;
}

body.sa-app aside#sa-sidebar nav a.sidebar-link .side-logo{
    height: 16px;
    margin-bottom: -2px;
}

.side-logo{
    transition: filter .2s;
}

.sidebar-link:hover .side-logo,
.sidebar-link.active .side-logo {
    filter: invert(62%) sepia(87%) saturate(1900%) hue-rotate(176deg) brightness(101%);
}

body.sa-app aside#sa-sidebar nav a.sidebar-link:visited {
    color: #545454 !important;
    -webkit-text-fill-color: #545454 !important;
}
body.sa-app aside#sa-sidebar nav a.sidebar-link:hover,
body.sa-app aside#sa-sidebar nav a.sidebar-link.active {
    color: #38b6ff !important;
    -webkit-text-fill-color: #38b6ff !important;
    background: linear-gradient(to right, #ffffff, #ffffff) !important;
    border-bottom: 2px solid;
    border-color: #38b6ff;
    font-weight: bold !important;
}

@media (max-width: 900px) {
    body.sa-app aside#sa-sidebar.school-admin-sidebar {
        position: fixed !important;
        width: min(300px, 88vw) !important;
        min-width: min(300px, 88vw) !important;
        padding-top: max(0.75rem, env(safe-area-inset-top, 0px)) !important;
        border-right: 1px solid rgba(226, 232, 240, 0.95) !important;
    }

    body.sa-app aside#sa-sidebar .sidebar-logo {
        display: none !important;
        position: sticky !important;
        top: 0 !important;
        left: auto !important;
        width: 100% !important;
        padding: 12px 12px 0 !important;
        justify-content: flex-end !important;
    }

    body.sa-app aside#sa-sidebar.open .sidebar-logo {
        display: flex !important;
    }

    body.sa-app aside#sa-sidebar .sidebar-logo img {
        width: 95px !important;
    }

    body.sa-app aside#sa-sidebar nav a.sidebar-link {
        width: 92% !important;
        min-height: 0 !important;
        padding: 0.85rem 10px !important;
        margin-bottom: 0.35rem !important;
        border-radius: 10px !important;
    }
}
</style>
@endonce

<aside class="sidebar school-admin-sidebar" id="sa-sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Tekete SafeSpace">
    </div>
    <nav aria-label="School admin navigation">
        <ul class="sidebar-list">
            <li>
                <a href="{{ url('/admin/dashboard') }}"
                   class="sidebar-link{{ $isDashboard ? ' active' : '' }}"><img src="{{ asset('images/1.png') }}" alt="dashboard" class="side-logo">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/reports') }}"
                   class="sidebar-link{{ $isReports ? ' active' : '' }}"><img src="{{ asset('images/3.png') }}" alt="reports" class="side-logo">
                    Reports
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/false-reports') }}"
                   class="sidebar-link{{ $isFalseReports ? ' active' : '' }}"><img src="{{ asset('images/4.png') }}" alt="falsereports" class="side-logo">
                    False Reports
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/settings') }}"
                   class="sidebar-link{{ $isSettings ? ' active' : '' }}"><img src="{{ asset('images/5.png') }}" alt="myprofile" class="side-logo">
                    My Profile
                </a>
            </li>
            @if ($showExportPdf)
                <li>
                    <a href="#"
                       class="sidebar-link"
                       onclick="event.preventDefault(); if (typeof exportPDF === 'function') exportPDF();"><img src="{{ asset('images/6.png') }}" alt="exportpdf" class="side-logo">
                        Export PDF
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route('logout') }}"
                   class="sidebar-link"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><img src="{{ asset('images/7.png') }}" alt="signout" class="side-logo">
                    Sign Out
                </a>
            </li>
        </ul>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" hidden>@csrf</form>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>
