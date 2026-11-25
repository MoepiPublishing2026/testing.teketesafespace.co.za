<div>
@include('components.school-admin-styles')

@php
    $formatStatusLabel = static function (?string $status): string {
        if (! $status) {
            return 'N/A';
        }

        return str_replace(' ', '-', ucwords(str_replace('-', ' ', $status)));
    };
@endphp

<style>
.school-reports-shell {
    --reports-lime: #c7da30;
    --reports-lime-soft: #d7e47a;
    --reports-blue: #38b6ff;
    --reports-text: #4a4a4a;
    --reports-muted: #6b7280;
    --reports-border: #e5e5e5;
    display: flex;
    min-height: 100vh;
    margin: 0;
    padding: 0;
    background: #ffffff;
    color: var(--reports-text);
    font-family: 'Montserrat', sans-serif;
}

.school-reports-shell > #sa-sidebar.school-admin-sidebar {
    position: relative !important;
    width: 220px !important;
    min-width: 220px !important;
    height: 100vh;
    padding-top: 140px !important;
    border-right: 1px solid #e5e5e5 !important;
    background: #ffffff !important;
}

.school-reports-shell > #sa-sidebar .sidebar-logo {
    position: absolute !important;
    top: 36px !important;
    left: 28px !important;
    width: 120px !important;
}

.school-reports-shell > #sa-sidebar .sidebar-logo img {
    width: 120px !important;
    height: auto !important;
}

.school-reports-shell > #sa-sidebar .sidebar-list {
    padding: 0 0 0 18px !important;
}

.school-reports-shell > #sa-sidebar nav a.sidebar-link {
    width: calc(100% - 18px) !important;
    margin-bottom: 10px !important;
    padding: 10px 16px !important;
    border-radius: 8px !important;
    color: #545454 !important;
    -webkit-text-fill-color: #545454 !important;
    font-size: 15px !important;
    font-weight: 500 !important;
    line-height: 1.3 !important;
    background: transparent !important;
}

.school-reports-shell > #sa-sidebar nav a.sidebar-link:hover,
.school-reports-shell > #sa-sidebar nav a.sidebar-link.active {
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
    background: var(--reports-blue) !important;
}

.school-reports-shell .main-panel {
    flex: 1;
    min-width: 0;
    height: 100vh;
    overflow: hidden;
    background: #ffffff;
}

.school-reports-shell .reports-main {
    box-sizing: border-box;
    height: 100%;
    overflow: auto;
    padding: 28px 36px 28px 28px;
    background: #ffffff;
}

.school-reports-shell .mobile-menu {
    display: none;
}

.school-reports-shell .reports-user {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    margin-bottom: 8px;
}

.school-reports-shell .reports-user-copy {
    text-align: right;
    line-height: 1.15;
}

.school-reports-shell .reports-user-name {
    margin: 0;
    color: var(--reports-blue);
    font-size: 16px;
    font-weight: 700;
}

.school-reports-shell .reports-user-role {
    margin: 2px 0 0;
    color: #777777;
    font-size: 13px;
    font-weight: 400;
}

.school-reports-shell .reports-avatar {
    width: 48px;
    height: 48px;
    flex: 0 0 48px;
    border-radius: 50%;
    object-fit: cover;
}

.school-reports-shell .reports-heading {
     position: relative;
    left: 0; /* Changed from -20px to 0 */
    margin: 0 0 14px;
    padding: 0;
    color: #3f3f3f;
    font-family: 'Montserrat', sans-serif;
    font-size: 22px; /* You can increase this to 24px or 26px to match your other screenshot */
    width: auto; /* Changed from 221.6px to auto */
    height: auto; /* Changed from 17.9px to auto */
    font-weight: 700;
    line-height: 1.2;
    letter-spacing: 0.02em;
    text-transform: uppercase;
    text-align: left;
    white-space: nowrap;
}

.school-reports-shell .filter-panel {
    margin: 0 0 13px;
    padding: 20px 24px 20px;
    
    border-radius: 10px !important;
    
    box-shadow: none !important;
    border-left: 3px solid #c7da30;
border-radius: 16px 0 0 16px;
}

.school-reports-shell .search-wrap {
    margin-bottom: 18px;
}


.school-reports-shell .search-wrap input {
    box-sizing: border-box;
    width: 100%;
    height: 23px;
    padding: 0 14px;
    border: 3px solid #4b5563;   /* ← change var(--reports-lime) to #9ca3af */
    border-radius: 999px;
    outline: none;
    background: #ffffff;
    color: #333333;
    font-family: inherit;
    font-size: 9px;
}

.school-reports-shell .search-wrap input::placeholder {
    color: #9ca3af;
}

.school-reports-shell .search-wrap input:focus,
.school-reports-shell .filter-input:focus {
    border-color: #6b7280;                            /* ← was #9eb718 */
    box-shadow: 0 0 0 3px rgba(107, 114, 128, 0.18);  /* ← was lime rgba */
}

.school-reports-shell .filter-grid {
    display: grid;
    grid-template-columns: 0.85fr 1.2fr 1fr 1.1fr 1.1fr 1fr 1fr 1fr ;
    gap: 10px;
    align-items: end;
}

.school-reports-shell .filter-grid > div {
    min-width: 0;
}
.school-reports-shell .refresh-row {
    display: flex;
    justify-content: flex-start;
    margin-top: 15px;
}
.school-reports-shell .filter-label {
    display: block;
    height: 11px;
    margin: 0 0 3px;
    overflow: hidden;
    color: #6b7280;
    font-size: 7px;
    font-weight: 400 ! important;
    letter-spacing: 0;
    line-height: 11px;
    text-transform: uppercase;
    white-space: nowrap;
}

.school-reports-shell .filter-input {
    box-sizing: border-box;
    width: 100%;
    height: 23px;
    padding: 0 5px;
    border: 3px solid #4b5563;   /* ← change var(--reports-lime) to #9ca3af */
    border-radius: 6px;
    outline: none;
    background: #ffffff;
    color: #4b5563;
    font-family: inherit;
    font-size: 8px;
}

.school-reports-shell .filter-input.is-disabled {
    cursor: not-allowed;
    background: #f3f4f6;
    opacity: 0.45;
}

.school-reports-shell .filter-date {
    position: relative;
}

.school-reports-shell .filter-date input {
    padding-right: 12px;
    color-scheme: light;
}

.school-reports-shell .filter-date input::-webkit-calendar-picker-indicator {
    cursor: pointer;
    opacity: 0.55;
}

.school-reports-shell #refreshBtn {
    display: inline-flex;          /* Aligns image and text horizontally */
    align-items: center;           /* Centers them vertically */
    justify-content: center;
    gap: 8px;                      /* Space between the image and the text */
    
    width: 160px;
    height: 28px;                  /* Slightly taller to fit the icon comfortably */
    padding: 0 10px;
    
    border: 0;
    border-radius: 6px;
    
    color: #ffffff !important;
    background: #38b6ff !important;
    cursor: pointer;
    font-family: 'Montserrat', sans-serif;
    font-size: 11px;
    font-weight: 400 !important;
    line-height: 1;
    transition: background-color 0.2s ease;
}

.school-reports-shell #refreshBtn:hover {
    background: #1aa0e8 !important;
}

.school-reports-shell .reports-table-wrap {
    width: 100%;
    overflow-x: auto;
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e5e7eb; /* Light gray outer border */
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); /* Soft shadow */
    -webkit-overflow-scrolling: touch;
}
.school-reports-shell #refreshBtn .btn-icon {
    width: 20px;                   /* Adjust this to make the icon bigger/smaller */
    height: 20px;
    object-fit: contain;           /* Prevents the image from stretching weirdly */
    flex-shrink: 0;                /* Prevents the text from squishing the image */
}
.school-reports-shell .reports-table {
    display: table;
    width: 100%;
    min-width: 780px;
    border-collapse: collapse;
    table-layout: fixed;
    background: #ffffff;
    color: #374151; /* Dark gray text */
    font-size: 13px; /* Slightly larger, readable text */
}

.school-reports-shell .reports-table thead tr {
    background: #f0f8ff !important; /* Light blue background */
    border-bottom: 3px solid #c7da30; /* Lime green bottom border */
}

.school-reports-shell .reports-table th {
    height: 48px;
    padding: 0 16px;
    color: #38b6ff !important; /* Blue text */
    font-size: 12px;
    font-weight: 700;
    text-align: left; /* Left-aligned as seen in image */
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border: none; /* Removes old borders */
}

.school-reports-shell .reports-table th:last-child,
.school-reports-shell .reports-table td:last-child {
    border-right: 0;
}

.school-reports-shell .reports-table td {
    height: 56px;
    padding: 0 16px;
    text-align: left; /* Left-aligned as seen in image */
    vertical-align: middle;
    border-bottom: 1px solid #f3f4f6; /* Very faint line between rows */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-weight: 500;
}

.school-reports-shell .reports-table tbody tr {
    transition: background-color 0.2s ease;
    cursor: pointer;
}

.school-reports-shell .reports-table tbody tr:nth-child(odd) {
    background: #ffffff;
}

.school-reports-shell .reports-table tbody tr:nth-child(even) {
    background: #ffffff;
}

.school-reports-shell .reports-table tbody tr:hover {
    background-color: #f9fafb; /* Light gray hover */
}

.school-reports-shell .case-number {
    font-weight: 700;
    color: #111827;
}

.school-reports-shell .status-pill {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 9999px;
    background: #fef9c3; /* Light yellow */
    color: #854d0e; /* Darker yellow/brown text */
    font-size: 12px;
    font-weight: 500;
    text-align: center;
    white-space: nowrap;
}


.school-reports-shell .action-select {
    width: 110px;
    height: 32px;
    padding: 0 8px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    background: #f9fafb;
    color: #4b5563;
    font-family: inherit;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    outline: none;
    appearance: auto; /* Keeps native dropdown arrow */
}

.school-reports-shell .reports-pagination {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 22px;
}

.school-reports-shell .pagination-btn {
    display: inline-flex;
    width: 40px;
    height: 40px;
    min-width: 40px;
    align-items: center;
    justify-content: center;
    border: 2px solid var(--reports-lime);
    border-radius: 999px;
    background: #ffffff;
    color: #222222;
    cursor: pointer;
    font-family: inherit;
    font-size: 15px;
    font-weight: 500;
    line-height: 1;
    transition: background-color 0.2s ease, color 0.2s ease;
}

.school-reports-shell .pagination-btn:hover {
    background: #f5f9d7;
    color: #111111;
}

.school-reports-shell .pagination-btn.active {
    border-color: var(--reports-lime);
    background: var(--reports-lime);
    color: #111111;
    font-weight: 700;
}

.school-reports-shell .pagination-btn.is-disabled {
    cursor: not-allowed;
    opacity: 0.4;
}

.school-reports-shell .font-montserrat-bold,
.school-reports-shell .font-montserrat-regular,
.school-reports-shell .font-montserrat {
    font-family: 'Montserrat', sans-serif;
}

@media (min-width: 901px) and (max-width: 1200px) {
    .school-reports-shell > #sa-sidebar.school-admin-sidebar {
        width: 185px !important;
        min-width: 185px !important;
        padding-top: 151px !important;
    }

    .school-reports-shell > #sa-sidebar .sidebar-logo {
        top: 46px !important;
        left: 28px !important;
        width: 140px !important;
    }

    .school-reports-shell > #sa-sidebar .sidebar-logo img {
        width: 140px !important;
    }

    .school-reports-shell > #sa-sidebar .sidebar-list {
        padding-left: 28px !important;
    }

    .school-reports-shell > #sa-sidebar nav a.sidebar-link {
        width: 118px !important;
        min-height: 31px !important;
        margin-bottom: 8px !important;
        padding: 5px 8px !important;
        border-radius: 4px !important;
        font-size: 15px !important;
        font-weight: 400 !important;
        line-height: 21px !important;
    }

    .school-reports-shell .reports-main {
        padding: 24px 39px 18px 24px;
    }

    .school-reports-shell .reports-user {
        min-height: 54px;
        align-items: flex-start;
        margin-bottom: 0;
    }

    .school-reports-shell .reports-avatar {
        width: 52px;
        height: 52px;
        flex-basis: 52px;
    }

    .school-reports-shell .reports-user-name {
        font-size: 16px;
    }

    .school-reports-shell .reports-user-role {
        font-size: 15px;
    }

    .school-reports-shell .reports-heading {
position: relative;
left: -20px;
margin: 3px 0 4px;
font-size: 17px;
line-height: 1.25;
}

    .school-reports-shell .filter-panel {
        margin-bottom: 13px;
        padding: 11px 14px 7px;
        border-radius: 10px !important;
    }

    .school-reports-shell .search-wrap {
        margin-bottom: 4px;
    }

    .school-reports-shell .search-wrap input {
        height: 23px;
        padding: 0 14px;
        font-size: 9px;
    }

    .school-reports-shell .filter-grid {
        grid-template-columns: 80px 87px 62px 101px 99px 62px 67px 67px 69px;
        gap: 5px;
    }

    .school-reports-shell .filter-label {
        height: 11px;
        margin: 0 0 3px;
        overflow: hidden;
        font-size: 7px;
        letter-spacing: 0;
        line-height: 11px;
    }

    .school-reports-shell .filter-input,
    .school-reports-shell #refreshBtn {
        height: 23px;
        padding-right: 5px;
        padding-left: 5px;
        border-radius: 6px;
        font-size: 8px;
    }

    .school-reports-shell .reports-table-wrap {
        overflow-x: hidden;
    }

    .school-reports-shell .reports-table {
        width: 100%;
        min-width: 0;
        font-size: 8px;
    }

    .school-reports-shell .reports-table th {
        height: 36px;
        padding: 0 6px;
        font-size: 8px;
    }

    .school-reports-shell .reports-table td {
        height: 32px;
        padding: 0 8px;
    }

    .school-reports-shell .status-pill {
        padding: 4px 8px;
        font-size: 8px;
    }

    .school-reports-shell .action-select {
        height: 22px;
        padding: 0 5px;
        font-size: 8px;
    }

    .school-reports-shell .reports-pagination {
        flex-wrap: nowrap;
        gap: 5px;
        margin-top: 13px;
    }

    .school-reports-shell .pagination-btn {
        width: 36px;
        height: 36px;
        min-width: 36px;
        font-size: 14px;
    }
}

@media (max-width: 900px) {
    .school-reports-shell > #sa-sidebar.school-admin-sidebar {
        position: fixed !important;
        width: min(300px, 88vw) !important;
        min-width: min(300px, 88vw) !important;
        padding-top: max(0.75rem, env(safe-area-inset-top, 0px)) !important;
    }

    .school-reports-shell .reports-main {
        padding: 64px 16px 24px;
    }

    .school-reports-shell .mobile-menu {
        position: fixed;
        top: 12px;
        left: 12px;
        z-index: 1002;
        display: flex;
        width: 44px;
        height: 44px;
        align-items: center;
        justify-content: center;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        background: #ffffff;
        color: var(--reports-blue);
        cursor: pointer;
        font-size: 22px;
    }

    .school-reports-shell .reports-heading {
        font-size: 22px;
    }

    .school-reports-shell .filter-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .school-reports-shell .reports-pagination {
        justify-content: flex-start;
        overflow-x: auto;
        flex-wrap: nowrap;
    }
}

@media (max-width: 540px) {
    .school-reports-shell .filter-grid {
        grid-template-columns: 1fr;
    }

    .school-reports-shell .reports-user-name {
        max-width: 160px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
}

@media (prefers-reduced-motion: reduce) {
    .school-reports-shell *,
    .school-reports-shell *::before,
    .school-reports-shell *::after {
        transition: none !important;
    }
}

.school-reports-shell .reports-table thead tr {
    background: #f0f8ff; /* Light blue background */
    color: #38b6ff;      /* Blue text */
    border-bottom: 3px solid #c7da30; /* Lime green bottom border */
}

.school-reports-shell .reports-table th {
    /* ... keep existing padding ... */
    font-weight: 700;
    text-transform: uppercase;
}
.school-reports-shell.modal-open > #sa-sidebar .sidebar-logo {
    display: none !important;
    opacity: 0 !important;
    visibility: hidden !important;
}




</style>

<div class="school-reports-shell {{ $selectedReport ? 'modal-open' : '' }}">
    @include('components.school-admin-sidebar')

    <div class="main-panel">
        <button id="sidebarToggle" class="mobile-menu" type="button" aria-label="Open navigation menu" aria-expanded="false">
            <i class="ti ti-menu-2" aria-hidden="true"></i>
        </button>

        <main id="main-content" class="reports-main">
            <div class="reports-user">
                <div class="reports-user-copy">
                    <p class="reports-user-name">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="reports-user-role">Administrator</p>
                </div>
                @php
                    $currentUser = auth()->user();
                    $currentUser = $currentUser ? $currentUser->fresh() : null;
                @endphp
                @if($currentUser && $currentUser->profile_picture)
                    <img src="{{ $currentUser->profile_picture_url }}" alt="{{ $currentUser->name }} profile picture" class="reports-avatar">
                @else
                    <svg class="reports-avatar" viewBox="0 0 52 52" role="img" aria-label="Default administrator profile picture">
                        <circle cx="26" cy="26" r="26" fill="#e3e7ec"/>
                        <ellipse cx="26" cy="20" rx="10" ry="12" fill="#647184"/>
                        <path d="M8 47c2-11 9-17 18-17s16 6 18 17c-5 3-11 5-18 5S13 50 8 47Z" fill="#647184"/>
                    </svg>
                @endif
            </div>

            <h1 class="reports-heading">
                @if ($filter === 'all') All Reports @else {{ $formatStatusLabel($filter) }} Reports @endif
            </h1>

            <section class="filter-panel" aria-label="Report filters">
                <div class="search-wrap">
                    <label class="sr-only" for="report-search">Search reports</label>
                    <input
                        id="report-search"
                        type="text"
                        wire:model.live.debounce.350ms="search"
                        placeholder="Search by email, case number, description"
                    />
                </div>

                <div class="filter-grid">
                    <div>
                        <label class="filter-label" for="filter-anonymous">Anonymous</label>
                        <select id="filter-anonymous" class="filter-input" wire:model.live="filterAnonymous">
                            <option value="">All</option>
                            <option value="1">Anonymous</option>
                            <option value="0">Identified</option>
                        </select>
                    </div>

                    <div>
                        <label class="filter-label" for="filter-name">Name / Surname</label>
                        <input
                            id="filter-name"
                            type="text"
                            class="filter-input {{ $filterAnonymous === '1' ? 'is-disabled' : '' }}"
                            wire:model.live.debounce.350ms="filterName"
                            placeholder="e.g Joe Smith"
                            @if($filterAnonymous === '1') disabled @endif
                            title="{{ $filterAnonymous === '1' ? 'Not available for anonymous reports' : '' }}"
                        />
                    </div>

                    <div>
                        <label class="filter-label" for="filter-grade">Grades</label>
                        <select id="filter-grade" class="filter-input" wire:model.live="filterGrade">
                            <option value="">All Grades</option>
                            @foreach($gradeOptions as $grade)
                                <option value="{{ $grade }}">{{ $grade }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-date">
                        <label class="filter-label" for="filter-date-from">Date From</label>
                        <input id="filter-date-from" type="date" class="filter-input" wire:model.live="filterDateFrom" />
                    </div>

                    <div class="filter-date">
                        <label class="filter-label" for="filter-date-to">Date To</label>
                        <input id="filter-date-to" type="date" class="filter-input" wire:model.live="filterDateTo" />
                    </div>

                    <div>
                        <label class="filter-label" for="filter-type">Report Type</label>
                        <select id="filter-type" class="filter-input" wire:model.live="filterType">
                            <option value="">All Types</option>
                            @foreach($typeOptions as $type)
                                <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="filter-label" for="filter-subtype">Subtypes</label>
                        <select id="filter-subtype" class="filter-input" wire:model.live="filterSubtype">
                            <option value="">All Subtypes</option>
                            @foreach($subtypeOptions as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->sub_type_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="filter-label" for="filter-status">Status</label>
                        <select id="filter-status" class="filter-input" wire:model.live="filterStatus">
                            <option value="">All Statuses</option>
                            <option value="awaiting-resolution">Awaiting Resolution</option>
                            <option value="under-review">Under Review</option>
                            <option value="forwarded">Forwarded</option>
                            <option value="closed">Closed</option>
                            <option value="unresolved">Unresolved</option>
                            <option value="false-report">False Report</option>
                        </select>
                    </div>

                    
                </div>

                <div class="refresh-row">
    <button type="button" id="refreshBtn" wire:click="clearFilters">
        <img src="{{ asset('images/14.png') }}" alt="Refresh" class="btn-icon">
        
        Refresh Table
    </button>
</div>
{{-- Active Dashboard Filters --}}
@if(
    $filterAge !== '' ||
    $filterAnonymous !== '' ||
    $filterGrade !== '' ||
    trim($filterName) !== ''
)
    <div style="
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        margin: 12px 0 16px;
    ">

        @if($filterAge !== '')
            <span style="
                background: #f0f9d4;
                color: #4a5e00;
                border: 1px solid #c7da30;
                padding: 7px 14px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
            ">
                Age: {{ $filterAge }}
            </span>
        @endif
{{-- Name / Surname Filter Badge --}}
@if(trim($filterName) !== '')
    <span style="
        background: #f0f9d4;
        color: #4a5e00;
        border: 1px solid #c7da30;
        padding: 7px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    ">
        Name: {{ trim($filterName) }}
    </span>
@endif
        @if($filterGrade !== '')
    <span style="
        background: #f0f9d4;
        color: #4a5e00;
        border: 1px solid #c7da30;
        padding: 7px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    ">
        Grade: {{ $filterGrade }}
    </span>
@endif

        @if($filterAnonymous !== '')
            <span style="
                background: #f0f9d4;
                color: #4a5e00;
                border: 1px solid #c7da30;
                padding: 7px 14px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
            ">
                Anonymous: {{ (string) $filterAnonymous === '1' ? 'Yes' : 'No' }}
            </span>
        @endif

        <span style="font-size: 12px; color: #6b7280;">
            {{ $reports->total() }} result(s)
        </span>

    </div>
@endif
            </section>
            <div class="pagination-toolbar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; font-size: 15px; color: #4b5563;">
    
    {{-- Left side: Show [X] entries --}}
    <div class="show-entries" style="display: flex; align-items: center; gap: 8px;">
        <span>Show</span>
        <select wire:model.live="perPage" class="per-page-select" style="
            height: 28px; 
            padding: 0 8px; 
            border: 3px solid #38b6ff; 
            border-radius: 4px; 
            outline: none; 
            color: #333; 
            font-family: inherit;
            font-size: 14px !important;
            font-weight: 550 !important;
            cursor: pointer;
        ">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <span>entries</span>
    </div>

    {{-- Right side: Showing X - Y of Z Reports --}}
    <div class="showing-entries">
        Showing {{ $reports->firstItem() ?? 0 }} - {{ $reports->lastItem() ?? 0 }} of 
        <strong>{{ $reports->total() }}</strong> Reports
    </div>

</div>

            <div class="reports-table-wrap">

                <table class="reports-table">
                    <thead>
                        <tr>
                            <th style="width: 12.18%;">Case Number</th>
                            <th style="width: 17.44%;">Full Name</th>
                            <th style="width: 12.56%;">Report Type</th>
                            <th style="width: 13.46%;">Grade</th>
                            <th style="width: 14.87%;">Status</th>
                            <th style="width: 9.36%;">Anonymous</th>
                            <th style="width: 8.72%;">Created At</th>
                            <th style="width: 11.41%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                          @php
                                $displayName = $report->is_anonymous 
                                    ? 'Anonymous' 
                                    :  $report->full_name;
                            @endphp
                            <tr wire:click="showReport({{ (int) $report->id }})">
                                <td class="case-number">{{ $report->case_number }}</td>
                                <td title="{{ $displayName }}">{{ $displayName }}</td>
                                <td>{{ $report->abuseType->type_name ?? 'N/A' }}</td>
                                <td>{{ $report->grade ?? 'N/A' }}</td>
                                <td>
                                    <span class="status-pill">{{ $formatStatusLabel($report->status) }}</span>
                                </td>
                                <td>{{ $report->is_anonymous ? 'YES' : 'NO' }}</td>
                                <td>{{ $report->created_at?->format('Y-m-d') ?? 'N/A' }}</td>
                                <td>
                                    <label class="sr-only" for="status-{{ $report->id }}">Update status for {{ $report->case_number }}</label>
                                    <select
                                        id="status-{{ $report->id }}"
                                        wire:change.stop="promptForStatusUpdate({{ $report->id }}, $event.target.value)"
                                        onclick="event.stopPropagation()"
                                        class="action-select"
                                    >
                                        <option value="">--Update--</option>
                                        <option value="awaiting-resolution">Awaiting Resolution</option>
                                        <option value="under-review">Under Review</option>
                                        <option value="forwarded">Forwarded</option>
                                        <option value="closed">Closed</option>
                                        <option value="unresolved">Unresolved</option>
                                        <option value="false-report">False Report</option>
                                    </select>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="height: 96px; color: #9ca3af;">
                                    No reports match your current filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

    <table class="reports-table">
        <thead>
            <tr>
                <th style="width: 15%;">Case Number</th>
                <th style="width: 20%;">Email</th>
                <th style="width: 15%;">Report Type</th>
                <th style="width: 12%;">Subtype</th>
                <th style="width: 10%;">Grade</th>
                <th style="width: 12%;">Date</th>
                <th style="width: 18%;">Status</th>
                <th style="width: 13%;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reports as $report)
                @php
                    // Use email if it exists, otherwise show Anonymous
                    $displayEmail = $report->is_anonymous ? 'Anonymous' : ($report->reporter_email ?? $report->email ?? 'N/A');
                @endphp
                <tr wire:click="showReport({{ $report->id }})">
                    <td class="case-number">{{ $report->case_number }}</td>
                    <td title="{{ $displayEmail }}">{{ $displayEmail }}</td>
                    <td>{{ $report->abuseType->type_name ?? 'N/A' }}</td>
                    <td>{{ $report->subtype->sub_type_name ?? 'N/A' }}</td>
                    <td>{{ $report->grade ?? 'N/A' }}</td>
                    <td>{{ $report->created_at?->format('Y-m-d') ?? 'N/A' }}</td>
                    <td>
                        <span class="status-pill">{{ $formatStatusLabel($report->status) }}</span>
                    </td>
                    <td>
                        <select
                            id="status-{{ $report->id }}"
                            wire:change.stop="promptForStatusUpdate({{ $report->id }}, $event.target.value)"
                            onclick="event.stopPropagation()"
                            class="action-select"
                        >
                            <option value="">--Update--</option>
                            <option value="awaiting-resolution">Awaiting Resolution</option>
                            <option value="under-review">Under Review</option>
                            <option value="forwarded">Forwarded</option>
                            <option value="closed">Closed</option>
                            <option value="unresolved">Unresolved</option>
                            <option value="false-report">False Report</option>
                        </select>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="height: 96px; color: #9ca3af; text-align: center;">
                        No reports match your current filters.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


            

                        @if($selectedReport)
                <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[9999] p-4">
                    <!-- Modal Container -->
                    <div style="background-color: #ffffff; border-radius: 12px; padding: 32px; width: 100%; max-width: 950px; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 25px rgba(0,0,0,0.2); font-family: 'Montserrat', sans-serif;">
                        
                        <!-- Header -->
                        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px;">
                            <div style="width: 56px; height: 56px; background-color: #c7da30; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <img src="{{ asset('images/21.png') }}" alt="Report Icon" style="width: 32px; height: 32px; object-fit: contain;">
                            </div>
                            <div>
                                <h2 style="margin: 0; font-size: 26px; font-weight: 700; color: #000000; line-height: 1.2;">Report Details</h2>
                                <p style="margin: 0; font-size: 18px; font-weight: 400; color: #4b5563;">{{ $selectedReport->case_number }}</p>
                            </div>
                        </div>

                        <!-- Alerts -->
                        @if($selectedReport->blocked_at)
                            <div class="mb-6 bg-black border-l-4 border-red-600 p-4 rounded shadow-md">
                                <div class="flex items-center">
                                    <i class="fas fa-user-slash text-red-600 mr-3 text-xl"></i>
                                    <div>
                                        <h3 class="text-white font-bold uppercase text-xs tracking-widest">Reporter Permanently Blocked</h3>
                                        <p class="text-gray-300 text-xs">
                                            Action taken by Admin: <span class="text-[#c7da30] font-bold">{{ $selectedReport->blocked_by_name }}</span>
                                            on {{ \Carbon\Carbon::parse($selectedReport->blocked_at)->format('Y M d') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($selectedReport->status === 'false-report')
                            <div class="mb-6 bg-red-50 border-l-4 border-red-600 p-4 rounded shadow-sm">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-triangle text-red-600 mr-3 text-xl"></i>
                                    <div>
                                        <h3 class="text-red-800 font-bold uppercase text-sm">Attention: This Report is Flagged</h3>
                                        <p class="text-red-700 text-xs font-semibold">Flag Reason: "{{ $selectedReport->latest_status_reason }}"</p>
                                        <p class="text-red-700 text-xs">The reporter has been notified and asked to provide a clarification statement.</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- 9-Grid Data Section -->
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px 16px; margin-bottom: 32px;">

                            <!-- 1. Email -->
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 42px; height: 42px; background-color: #38b6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <img src="{{ asset('images/22.png') }}" alt="Email" style="width: 24px; height: 24px; object-fit: contain;">
                                </div>
                                <div style="display: flex; flex-direction: column; line-height: 1.3;">
                                    <span style="font-weight: 700; font-size: 16px; color: #000;">Email:</span>
                                    <span style="font-weight: 400; font-size: 16px; color: #000;">{{ $selectedReport->is_anonymous ? 'Anonymous' : ($selectedReport->reporter_email ?? 'N/A') }}</span>
                                </div>
                            </div>

                            <!-- 2. Type -->
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 42px; height: 42px; background-color: #38b6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <img src="{{ asset('images/23.png') }}" alt="Type" style="width: 24px; height: 24px; object-fit: contain;">
                                </div>
                                <div style="display: flex; flex-direction: column; line-height: 1.3;">
                                    <span style="font-weight: 700; font-size: 16px; color: #000;">Type:</span>
                                    <span style="font-weight: 400; font-size: 16px; color: #000;">{{ $selectedReport->abuseType->type_name ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- 3. Latest Reason -->
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 42px; height: 42px; background-color: #38b6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <img src="{{ asset('images/24.png') }}" alt="Reason" style="width: 24px; height: 24px; object-fit: contain;">
                                </div>
                                <div style="display: flex; flex-direction: column; line-height: 1.3;">
                                    <span style="font-weight: 700; font-size: 16px; color: #000;">Latest Reason:</span>
                                    <span style="font-weight: 400; font-size: 16px; color: #d97706; font-style: italic; white-space: nowrap;">{{ $selectedReport->latest_status_reason ?? 'No Status history recorded' }}</span>
                                </div>
                            </div>

                            <!-- 4. Phone -->
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 42px; height: 42px; background-color: #38b6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <img src="{{ asset('images/25.png') }}" alt="Phone" style="width: 24px; height: 24px; object-fit: contain;">
                                </div>
                                <div style="display: flex; flex-direction: column; line-height: 1.3;">
                                    <span style="font-weight: 700; font-size: 16px; color: #000;">Phone:</span>
                                    <span style="font-weight: 400; font-size: 16px; color: #000;">{{ $selectedReport->phone_number ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- 5. Subtype -->
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 42px; height: 42px; background-color: #38b6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <img src="{{ asset('images/26.png') }}" alt="Subtype" style="width: 24px; height: 24px; object-fit: contain;">
                                </div>
                                <div style="display: flex; flex-direction: column; line-height: 1.3;">
                                    <span style="font-weight: 700; font-size: 16px; color: #000;">Subtype:</span>
                                    <span style="font-weight: 400; font-size: 16px; color: #000;">{{ $selectedReport->subtype->sub_type_name ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- 6. Grade -->
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 42px; height: 42px; background-color: #38b6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <img src="{{ asset('images/27.png') }}" alt="Grade" style="width: 24px; height: 24px; object-fit: contain;">
                                </div>
                                <div style="display: flex; flex-direction: column; line-height: 1.3;">
                                    <span style="font-weight: 700; font-size: 16px; color: #000;">Grade:</span>
                                    <span style="font-weight: 400; font-size: 16px; color: #000;">{{ $selectedReport->grade ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- 7. School -->
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 42px; height: 42px; background-color: #38b6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <img src="{{ asset('images/28.png') }}" alt="School" style="width: 24px; height: 24px; object-fit: contain;">
                                </div>
                                <div style="display: flex; flex-direction: column; line-height: 1.3;">
                                    <span style="font-weight: 700; font-size: 16px; color: #000;">School:</span>
                                    <span style="font-weight: 400; font-size: 16px; color: #000;">{{ $selectedReport->schoolName ?? $selectedReport->school_name ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- 8. Report ID -->
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 42px; height: 42px; background-color: #38b6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <img src="{{ asset('images/16.png') }}" alt="ID" style="width: 24px; height: 24px; object-fit: contain;">
                                </div>
                                <div style="display: flex; flex-direction: column; line-height: 1.3;">
                                    <span style="font-weight: 700; font-size: 16px; color: #000;">Report ID:</span>
                                    <span style="font-weight: 400; font-size: 16px; color: #000;">{{ $selectedReport->case_number }}</span>
                                </div>
                            </div>

                            <!-- 9. Current Status -->
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 42px; height: 42px; background-color: #38b6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <img src="{{ asset('images/30.png') }}" alt="Status" style="width: 24px; height: 24px; object-fit: contain;">
                                </div>
                                <div style="display: flex; flex-direction: column; line-height: 1.3;">
                                    <span style="font-weight: 700; font-size: 16px; color: #000;">Current Status:</span>
                                    <span style="font-weight: 400; font-size: 16px; color: #000;">{{ $formatStatusLabel($selectedReport->status) }}</span>
                                </div>
                            </div>

                        </div>

                        <!-- Description -->
                        <div style="margin-bottom: 24px; width: 100%;">
                            <p style="font-size: 16px; font-weight: 500; color: #111827; margin-bottom: 8px;">Description</p>
                            <div style="border: 3px solid #c7da30; border-radius: 8px; padding: 16px; min-height: 120px; width: 100%; box-sizing: border-box; font-size: 15px; color: #374151; line-height: 1.6; white-space: pre-wrap;">
                                {{ $selectedReport->description }}
                            </div>
                        </div>

                        <!-- Attachments -->
                        @php
                            $attachments = $selectedReport->image_path ? json_decode($selectedReport->image_path, true) : [];
                        @endphp

                        <div style="margin-bottom: 24px;">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                <div style="width: 36px; height: 36px; background-color: #38b6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <img src="{{ asset('images/31.png') }}" alt="Attachments" style="width: 20px; height: 20px; object-fit: contain;">
                                </div>
                                <p style="margin: 0; font-size: 18px; font-weight: 400; color: #111827;">Attachments</p>
                            </div>
                            
                            @if (!empty($attachments))
                                <div class="flex flex-wrap gap-4">
                                    @foreach ($attachments as $filePath)
                                        @php
                                            $ext       = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                            $publicUrl = \App\Support\AttachmentAccess::adminUrl($selectedReport->id, $filePath);
                                            $isImage   = in_array($ext, ['jpg','jpeg','png','gif','bmp','webp','svg']);
                                            $isVideo   = in_array($ext, ['mp4','mov','avi','wmv']);
                                        @endphp
                                        @if ($isImage)

                                            <img src="{{ $publicUrl }}" alt="Attachment"
                                                 class="w-32 h-auto mt-2 border rounded shadow cursor-pointer"
                                                 wire:click="showImage({{ $loop->index }})">


                                        @elseif ($isVideo)
                                            <video controls class="w-48 h-auto mt-2 border rounded shadow">
                                                <source src="{{ $publicUrl }}" type="video/{{ $ext }}">
                                            </video>
                                        @else
                                            <a href="{{ $publicUrl }}" target="_blank" class="text-blue-600 underline inline-block mt-2">
                                                View {{ basename($filePath) }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <p style="color: #9ca3af; font-style: italic; font-size: 15px; margin-top: 8px;">No attachments uploaded</p>
                            @endif
                        </div>

                                                                    <!-- Update Status -->
                        <div style="margin-bottom: 24px;">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                <div style="width: 36px; height: 36px; background-color: #38b6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <img src="{{ asset('images/14.png') }}" alt="Update Status" style="width: 20px; height: 20px; object-fit: contain;">
                                </div>
                                <p style="margin: 0; font-size: 18px; font-weight: 400; color: #111827;">Update Status</p>
                            </div>
                            
                            <select wire:change.stop="promptForStatusUpdate({{ $selectedReport->id }}, $event.target.value)" style="width: 100%; border: 3px solid #c7da30; border-radius: 8px; padding: 10px 14px; font-size: 15px; color: #374151; outline: none; font-family: inherit; background-color: #ffffff; cursor: pointer; appearance: auto; margin-bottom: 6px;">
                                <option value="awaiting-resolution" {{ $selectedReport->status == 'awaiting-resolution' ? 'selected' : '' }}>Awaiting Resolution</option>
                                <option value="under-review"        {{ $selectedReport->status == 'under-review'        ? 'selected' : '' }}>Under Review</option>
                                <option value="forwarded"           {{ $selectedReport->status == 'forwarded'           ? 'selected' : '' }}>Forwarded</option>
                                <option value="closed"              {{ $selectedReport->status == 'closed'              ? 'selected' : '' }}>Closed</option>
                                <option value="unresolved"          {{ $selectedReport->status == 'unresolved'          ? 'selected' : '' }}>Unresolved</option>
                                <option value="false-report"        {{ $selectedReport->status == 'false-report'        ? 'selected' : '' }}>False Report</option>
                            </select>

                            <!-- Red Text Right Below the Dropdown -->
                            @if($selectedReport->reporter_email)
                                <p style="margin: 0; font-size: 11px; font-weight: 400 !important; color: #dc2626; text-transform: uppercase; font-family: 'Montserrat', sans-serif; text-align: left;">
                                    {{ $falseReportsCount }} TOTAL FALSE REPORTS
                                </p>
                            @endif
                        </div>

                        <!-- Footer Actions (Buttons only) -->
                        <div style="display: flex; justify-content: flex-end; align-items: center; gap: 16px; margin-top: 24px;">
                            
                            @if($selectedReport->reporter_email)

                                

                                <button wire:click="permanentBlock(@js($selectedReport->reporter_email))"
                                        wire:confirm="Are you sure? This will permanently prevent this email ({{ $selectedReport->reporter_email }}) from making future reports."
                                        style="background-color: #38b6ff; color: #ffffff; padding: 12px 28px; border-radius: 8px; font-weight: 400 !important; font-size: 15px; border: none; cursor: pointer; font-family: 'Montserrat', sans-serif;">
                                    Block Reporter
                                </button>

                            @endif

                            <button wire:click="closeReport"
                                    style="background-color: #38b6ff; color: #ffffff; padding: 12px 32px; border-radius: 8px; font-weight: 400 !important; font-size: 15px; border: none; cursor: pointer; font-family: 'Montserrat', sans-serif;">
                                Close
                            </button>
                            
                    </div>
                </div>
            @endif
            @if($modalImage)
                <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-70 z-50">
                    <img src="{{ $modalImage }}" class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-lg">
                    <button wire:click="closeImage"
                            class="absolute bottom-8 bg-gradient-to-r from-[#c7da30] to-[#d7e47a] px-5 py-2 rounded-full font-montserrat text-black">
                        Close
                    </button>
                </div>
            @endif

                        @if($showReasonModal)
                <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[9999] p-4">
                    <div style="background-color: #ffffff; border-radius: 12px; padding: 32px; width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 25px rgba(0,0,0,0.2); font-family: 'Montserrat', sans-serif;">
                        
                        <!-- Header -->
                        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
                            <div style="width: 56px; height: 56px; background-color: #c7da30; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <!-- Replace '41.png' with your actual flag icon file -->
                                <img src="{{ asset('images/41.png') }}" alt="Flag Icon" style="width: 900px ! important; height: 900px ! important; object-fit: contain;">
                            </div>
                            <div>
                                @if($newStatus === 'false-report')
                                    <h2 style="margin: 0; font-size: 24px; font-weight: 700; color: #000000 ! important; line-height: 1.2;">FLAGGING REPORT</h2>
                                @else
                                    <h2 style="margin: 0; font-size: 24px; font-weight: 700; color: #000000 ! important; line-height: 1.2;">UPDATE STATUS</h2>
                                @endif
                            </div>
                        </div>

                        @if($newStatus === 'false-report')
                            <!-- Status Change Text -->
                            <p style="margin: 0 0 16px 0; font-size: 15px; color: #374151; text-align: center;">
                                You are changing <strong>{{ $reportToUpdate->case_number }}</strong> status from
                            </p>

                                                        <!-- Status Pills -->
                            <div style="display: flex; justify-content: center; align-items: center; gap: 16px; margin-bottom: 24px;">
                                
                                <!-- Old Status (Yellow Pill) -->
                                <span style="background-color: #fef9c3; color: #854d0e; padding: 6px 16px; border-radius: 20px; font-size: 14px; font-weight: 700;">
                                    {{ $formatStatusLabel($reportToUpdate->status) }}
                                </span>

                                <!-- The Arrow (Thick and Black) -->
                                <img src="{{ asset('images/43.png') }}" alt="Flag Icon" style="width: 32px; height: 32px; object-fit: contain;">

                                <!-- New Status (Red Text) -->
                                <span style="color: #dc2626; font-size: 15px; font-weight: 500 ! important;">
                                    {{ $formatStatusLabel($newStatus) }}
                                </span>
                                
                            </div>

                            <!-- Warning Banner -->
                            <div style="background-color: #000000; border-left: 6px solid #dc2626; padding: 16px; border-radius: 8px; display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
                                <div style="width: 32px; height: 32px; background-color: #dc2626; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <img src="{{ asset('images/33.png') }}" alt="Flag Icon" style="width: 32px; height: 32px; object-fit: contain;">
                                </div>
                                <p style="margin: 0; font-size: 13px; color: #ffffff; font-weight: 350 ! important; line-height: 1.4;">
                                    <strong>NOTE:</strong> This action will mark the report as fraudulent.
                                </p>
                            </div>

                            <!-- Admin & Date Info -->
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                                <!-- Flagged By -->
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 42px; height: 42px; background-color: #c7da30; border: 1px solid #c7da30; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <img src="{{ asset('images/34.png') }}" alt="Flag Icon" style="width: 32px; height: 32px; object-fit: contain;">
                                    </div>
                                    <div style="display: flex; flex-direction: column; line-height: 1.2;">
                                        <span style="font-size: 13px; color: #6b7280;">Flagged by</span>
                                        <span style="font-size: 14px; font-weight: 700; color: #000000;">{{ $adminName }}</span>
                                    </div>
                                </div>
                                
                                <!-- Date/Time -->
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 42px; height: 42px; background-color: #c7da30; border: 1px solid #c7da30; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <img src="{{ asset('images/24.png') }}" alt="Flag Icon" style="width: 32px; height: 32px; object-fit: contain;">
                                    </div>
                                    <div style="display: flex; flex-direction: column; line-height: 1.2;">
                                        <span style="font-size: 13px; color: #6b7280;">Date / Time</span>
                                        <span style="font-size: 13px; font-weight: 700; color: #000000; text-transform: uppercase;">{{ $timestamp }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="mb-6 text-sm text-black text-center">
                                You are changing <strong>{{ $reportToUpdate->case_number }}</strong> status from
                                <span class="font-semibold">{{ $formatStatusLabel($reportToUpdate->status) }}</span>
                                to <span class="font-semibold text-blue-700">{{ $formatStatusLabel($newStatus) }}</span>.
                            </p>
                        @endif

                        <!-- Reason Form -->
                        <form wire:submit.prevent="finalizeStatusUpdate">
                            <div style="margin-bottom: 24px;">
                                <label style="display: block; font-size: 15px; font-weight: 700; color: #000000; margin-bottom: 8px;">
                                    {{ $newStatus === 'false-report' ? 'Reason for flagging' : 'Reason for update' }}
                                </label>
                                <textarea wire:model.defer="statusChangeReason"
                                          rows="4"
                                          placeholder="{{ $newStatus === 'false-report' ? 'Provide evidence or reason why this report is false' : 'Enter reason...' }}"
                                          style="width: 100%; border: 3px solid #c7da30; border-radius: 8px; padding: 16px; font-size: 14px; color: #000000; outline: none; font-family: inherit; resize: none; box-sizing: border-box;"></textarea>
                                @error('statusChangeReason')
                                    <p style="margin: 8px 0 0 0; font-size: 13px; color: #dc2626; font-weight: bold;">{{ $message }}</p>
                                @enderror
                            </div>

                                                        
                                                        <!-- Actions -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 24px;">
                                <button type="submit"
                                        style="background-color: #38b6ff; color: #ffffff; padding: 14px 40px; border-radius: 8px; font-weight: 400 ! important; font-size: 16px; border: none; cursor: pointer; font-family: 'Montserrat', sans-serif; transition: background-color 0.2s;">
                                    {{ $newStatus === 'false-report' ? 'Confirm Flag' : 'Confirm & Update' }}
                                </button>
                                
                                <button type="button" wire:click="cancelUpdate"
                                        style="background-color: #38b6ff; color: #ffffff; padding: 14px 40px; border-radius: 8px; font-weight: 400 ! important; font-size: 16px; border: none; cursor: pointer; font-family: 'Montserrat', sans-serif; transition: background-color 0.2s;">
                                    Cancel
                                </button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            @endif
        </main>
    </div>
</div>

@include('components.school-admin-sidebar-script')
<script src="https://kit.fontawesome.com/2c36e9b7b9.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function exportPDF() {
        const element = document.getElementById('main-content');
        if (!element) return console.error("Main content not found!");
        html2pdf().from(element).set({
            margin: 10,
            filename: 'admin-reports.pdf',
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a3', orientation: 'landscape' }
        }).save();
    }
</script>
</div>
