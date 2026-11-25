<!DOCTYPE html>

<html lang="en" class="sa-app-root">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    <title>False Reports Analysis | Tekete SafeSpace</title>

    <x-favicon />

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
:root {
    --sky:#38b6ff;
    --lime:#c7da30;
    --ink:#545454;
    --line:#e7e7e7
}
* {
    box-sizing:border-box
}
html,body {
    font-family:Montserrat,sans-serif!important;
    color:var(--ink);
    margin:0
}
body {
    display:flex;
    min-height:100vh;
    overflow-x:hidden;
    background:#fff
}
.main-panel {
    flex:1;
    min-width:0;
    max-width:calc(100vw - 235px);
    height:100vh;
    display:flex;
    flex-direction:column;
    overflow:hidden;
    background:#fff
}
.topbar {
    height:92px;
    flex-shrink:0;
    display:flex;
    align-items:center;
    justify-content:flex-end;
    padding:15px 36px 0
}
.profile {
    display:flex;
    align-items:center;
    gap:16px
}
.profile .meta {
    text-align:right
}
.profile .meta>span {
    display:block
}
.profile .meta>span:first-child {
    color:var(--sky);
    font-size:22px;
    font-weight:700
}
.profile .meta .role {
    font-size:18px;
    color:#545454;
    margin-top:5px
}
.profile-avatar {
    width:74px;
    height:74px;
    border-radius:50%;
    overflow:hidden
}
.profile-avatar img,.profile-avatar svg {
    width:100%;
    height:100%;
    object-fit:cover
}
.dashboard-scroll {
    flex:1;
    min-height:0;
    overflow:auto;
    padding:12px 32px 45px
}
.page-heading {
    margin: 0 0 4px !important;
    font-size: 30px;
    font-weight: 800;
    line-height: 1.3;
    color: #545454;
    text-transform: uppercase;
    text-align: left !important;
    width: 100%;
}
.page-heading .school-name {
    display: block;
    color: var(--lime);
    text-align: left !important;
}
.subtitle {
    font-size: 18px;
    margin: 0 0 25px;
    text-align: left !important;
}
.stats-grid {
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:22px;
    margin-bottom:28px
}
.stat-card {
    border-left:2px solid var(--sky);
    border-bottom:2px solid var(--sky);
    border-radius:12px;
    display:flex;
    align-items:center;
    gap:14px;
    padding:13px 14px;
    min-height:105px
}
/* Prototype-style blue circular statistic icons */
.stat-icon {
    flex: none;
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: var(--sky);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}
.stat-icon svg {
    display: block;
    width: 53px;
    height: 53px;
    fill: none;
    stroke: currentColor;
    stroke-width: 2.4;
    stroke-linecap: round;
    stroke-linejoin: round;
}
.stat-label {
    font-size:15px;
    line-height:1.35;
    color:#111;
    flex:1
}
.stat-value {
    font-size:50px;
    font-weight:500;
    line-height:1;
    color:var(--sky)
}
.filters-panel {
    border-left:3px solid var(--lime);
    border-radius:12px;
    padding:13px 22px 18px;
    margin-bottom:15px
}
.filters-title {
    font-size:23px;
    color:var(--sky);
    margin:0 0 17px;
    display:flex;
    gap:10px;
    align-items:center
}
.filters-title svg {
    width:24px;
    height:24px
}
.filter-tabs {
    display:flex;
    gap:15px;
    flex-wrap:wrap
}
.filter-tab {
    padding:8px 14px;
    text-decoration:none;
    border:1px solid #888;
    border-radius:11px;
    color:#4d5665;
    font-size:14px;
    font-weight:700
}
.filter-tab.active {
    background:var(--sky);
    color:#fff;
    border-color:var(--sky)
}
.panel {
    border:2px solid #ededed;
    border-radius:13px;
    padding:10px 32px 20px;
    margin-bottom:25px;
    min-width:0
}
.panel h2 {
    font-size:22px;
    color:var(--sky);
    font-weight:500;
    margin:0 0 6px
}
.section-desc {
    font-size:16px;
    margin:0 0 15px
}
.pattern-group {
    margin-bottom:7px
}
.pattern-toggle {
    width:100%;
    display:flex;
    align-items:center;
    gap:10px;
    background:#fff;
    border:2px solid #ededed;
    border-radius:12px;
    padding:6px 12px;
    text-align:left;
    cursor:pointer;
    color:#111;
    font-family:inherit
}
.pattern-icon {
    width:30px;
    height:30px;
    background:var(--lime);
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:18px;
    flex-shrink:0
}
.pattern-key {
    font-size:14px;
    flex:1;
    overflow-wrap:anywhere
}
.pattern-count {
    background:var(--sky);
    color:#fff;
    border-radius:10px;
    font-size:11px;
    font-weight:700;
    padding:6px 14px;
    white-space:nowrap
}
.chevron {
    font-size:21px;
    color:#526070;
    transition:transform .2s
}
.pattern-group.open .chevron {
    transform:rotate(180deg)
}
.pattern-details {
    display:none
}
.pattern-group.open .pattern-details {
    display:block
}
.table-wrap {
    width:100%;
    overflow-x:auto
}
.reports-table {
    width:100%;
    min-width:900px;
    border-collapse:collapse;
    font-size:13px
}
.reports-table th {
    background:#eaf7ff;
    color:var(--sky);
    text-transform:uppercase;
    font-size:13px;
    text-align:left;
    padding:11px 8px;
    border-bottom:4px solid var(--lime);
    white-space:nowrap
}
.reports-table td {
    padding:10px 8px;
    color:#111;
    vertical-align:top
}
.reports-table tbody tr:hover {
    background:#f7fbfe
}
.desc-cell {
    max-width:190px;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap
}
.empty-state {
    text-align:center;
    padding:35px 10px;
    color:#53647f
}
.empty-state .empty-icon {
    color:var(--lime);
    font-size:35px
}
.empty-state h3 {
    font-weight:500;
    font-size:16px
}
.empty-state p {
    font-size:14px
}
.table-toolbar {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
    margin:18px 0 12px;
    font-size:14px
}
.table-toolbar select {
    font:inherit;
    color:var(--sky);
    border:2px solid var(--sky);
    border-radius:5px;
    padding:4px
}
.pagination-controls {
    display:flex;
    gap:8px;
    align-items:center;
    justify-content:flex-end;
    margin-top:14px
}
.pagination-controls button {
    font:inherit;
    background:#fff;
    border:1px solid #ddd;
    border-radius:5px;
    padding:6px 12px;
    cursor:pointer
}
.pagination-controls button:disabled {
    opacity:.4;
    cursor:default
}
@media(max-width:1250px) {
    .stats-grid {
        grid-template-columns:repeat(2,minmax(0,1fr))
    }
    .stat-value {
        font-size:42px
    }
}
@media(max-width:900px) {
    .main-panel {
        max-width:100%
    }
    .dashboard-scroll {
        padding:16px
    }
    .page-heading {
        font-size:23px
    }
    .topbar {
        height:75px;
        padding:10px 15px
    }
    .profile-avatar {
        width:50px;
        height:50px
    }
    .profile .meta>span:first-child {
        font-size:16px
    }
    .profile .meta .role {
        font-size:13px
    }
    .panel {
        padding:14px
    }
}
@media(max-width:550px) {
    .stats-grid {
        grid-template-columns:1fr
    }
    .stat-card {
        min-height:85px
    }
    .filter-tabs {
        gap:8px
    }
    .filter-tab {
        font-size:12px
    }
    .page-heading {
        font-size:20px
    }
}

/* Modal icons using existing image files */

.report-modal-main-icon img {
    width: 32px;
    height: 36px;
    object-fit: contain;
}

.report-info-icon img {
    width: 22px;
    height: 22px;
    object-fit: contain;
    display: block;
}

.report-modal-section-title .report-info-icon img {
    width: 23px;
    height: 23px;
}

</style>

    <x-school-admin-styles />
<style>
/* Force the entire heading to align left */
.sa-app .dashboard-scroll h1.page-heading {
    display: flex !important;
    flex-direction: column !important;
    align-items: flex-start !important;
    justify-content: flex-start !important;
    text-align: left !important;
    width: 100% !important;
    margin: 0 0 8px !important;
    padding: 0 !important;
}
/* First line */
.sa-app .dashboard-scroll .heading-title {
    display: block !important;
    width: 100% !important;
    text-align: left !important;
    color: #545454 !important;
    font-size: 30px;
    font-weight: 800;
}
/* School name */
.sa-app .dashboard-scroll .school-name {
    display: block !important;
    width: 100% !important;
    text-align: left !important;
    color: #c7da30 !important;
    font-size: 30px;
    font-weight: 800;
}
/* Subtitle */
.sa-app .dashboard-scroll .subtitle {
    text-align: left !important;
    margin: 8px 0 25px !important;
}



/* =========================================
   FALSE REPORT DETAILS MODAL - PROTOTYPE
========================================= */

.report-modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 99999;
    background: rgba(0, 0, 0, .28);
    align-items: center;
    justify-content: center;
    padding: 15px;
}

.report-modal.active {
    display: flex;
}

.report-modal-content {
    width: 100%;
    max-width: 590px;
    max-height: 94vh;
    overflow-y: auto;
    background: #fff;
    border-radius: 16px;
    padding: 17px 22px 24px;
    box-shadow: 0 8px 30px rgba(0,0,0,.15);
    position: relative;
    font-family: Montserrat, sans-serif;
    color: #111;
    animation: modalAppear .2s ease;
}

@keyframes modalAppear {
    from {
        opacity: 0;
        transform: translateY(12px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Header */

.report-modal-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 17px;
    padding-right: 30px;
}

.report-modal-main-icon {
    width: 45px;
    height: 50px;
    border-radius: 9px;
    background: var(--lime);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 29px;
    flex-shrink: 0;
}

.report-modal-heading h2 {
    font-size: 20px;
    font-weight: 700;
    margin: 0 0 2px;
    color: #111;
}

.report-modal-heading p {
    font-size: 14px;
    margin: 0;
    color: #222;
}

.report-modal-close {
    position: absolute;
    right: 17px;
    top: 10px;
    border: none;
    background: transparent;
    font-size: 29px;
    color: #000;
    cursor: pointer;
}

/* Status banner */

.report-status-banner {
    display: flex;
    align-items: center;
    gap: 9px;
    background: #050505;
    border-left: 9px solid red;
    border-radius: 8px;
    padding: 8px 10px;
    color: #fff;
    margin-bottom: 14px;
    min-height: 54px;
}

.report-status-alert {
    width: 37px;
    height: 37px;
    background: red;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 27px;
    font-weight: 800;
    flex-shrink: 0;
}

.report-status-text strong {
    display: block;
    font-size: 12px;
    margin-bottom: 3px;
}

.report-status-text span {
    display: block;
    font-size: 12px;
}

/* Flag warning */

.report-flag-warning {
    border-left: 4px solid red;
    padding: 2px 8px;
    margin-bottom: 20px;
}

.report-flag-warning strong {
    display: block;
    color: red;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 2px;
}

.report-flag-warning p {
    font-size: 11px;
    margin: 2px 0;
    line-height: 1.4;
}

/* Report information */

.report-info-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 17px 12px;
    margin: 20px 0 25px;
}

.report-info-item {
    display: flex;
    align-items: center;
    gap: 7px;
    min-width: 0;
}

.report-info-icon {
    width: 29px;
    height: 29px;
    border-radius: 8px;
    background: var(--sky);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
    flex-shrink: 0;
}

.report-info-text {
    min-width: 0;
}

.report-info-text strong {
    display: block;
    font-size: 14px;
    font-weight: 700;
}

.report-info-text span {
    display: block;
    font-size: 13px;
    overflow-wrap: anywhere;
}

/* Reason and clarification */

.report-reason-grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 14px;
    margin: 20px 0;
}

.report-reason-box {
    border-left: 4px solid red;
    padding: 8px;
    min-width: 0;
}

.report-reason-box strong {
    display: block;
    color: red;
    font-size: 12px;
    font-weight: 500;
    margin-bottom: 4px;
}

.report-reason-box span {
    display: block;
    font-size: 11px;
    line-height: 1.5;
    overflow-wrap: anywhere;
}

/* Description */

.report-description-label {
    font-size: 14px;
    display: block;
    margin-bottom: 6px;
}

.report-description-box {
    width: 100%;
    min-height: 68px;
    max-height: 150px;
    overflow-y: auto;
    border: 3px solid var(--lime);
    border-radius: 9px;
    padding: 10px;
    font-size: 13px;
    line-height: 1.5;
    margin-bottom: 15px;
    white-space: pre-wrap;
    overflow-wrap: anywhere;
}

/* Attachments and status */

.report-modal-section {
    margin: 12px 0;
}

.report-modal-section-title {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 14px;
    margin-bottom: 8px;
}

.report-modal-section-title .report-info-icon {
    width: 28px;
    height: 28px;
}

.report-attachments-empty {
    color: #888;
    font-style: italic;
    font-size: 13px;
    padding-left: 6px;
}

.report-status-select {
    width: 100%;
    border: 3px solid var(--lime);
    border-radius: 9px;
    padding: 6px;
    font-family: inherit;
    font-size: 13px;
    background: #fff;
    color: #222;
    outline: none;
}

/* Buttons */

.report-modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 30px;
    margin-top: 20px;
}

.report-modal-actions button {
    min-width: 115px;
    padding: 12px 20px;
    border: none;
    border-radius: 10px;
    background: var(--sky);
    color: #fff;
    font-family: inherit;
    font-size: 14px;
    cursor: pointer;
}

.report-modal-actions button:hover {
    background: #209fe8;
}

.report-modal-actions .block-reporter-btn {
    min-width: 165px;
}

@media(max-width: 600px) {
    .report-modal-content {
        padding: 15px;
        max-height: 95vh;
    }

    .report-info-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px 8px;
    }

    .report-reason-grid {
        grid-template-columns: 1fr;
    }

    .report-modal-actions {
        gap: 10px;
    }

    .report-modal-actions button {
        min-width: 0;
        flex: 1;
    }
}

/* Make report rows clickable */

.reports-table tbody tr.report-clickable {
    cursor: pointer;
    transition: background 0.2s ease;
}

.reports-table tbody tr.report-clickable:hover {
    background: #eaf7ff;
}

/* Numbered image icons */

.report-modal-main-icon img {
    width: 35px;
    height: 38px;
    object-fit: contain;
}

.report-info-icon img {
    width: 23px;
    height: 23px;
    object-fit: contain;
    display: block;
}
</style>

</head>

<body class="sa-app">

<x-school-admin-sidebar />

    <div class="main-panel">

        <button class="menu-icon" id="sidebarToggle" aria-label="Open navigation menu" aria-expanded="false" aria-controls="sa-sidebar" type="button">&#9776;</button>

        <div class="topbar">

        <div class="profile">

            <div class="meta">

                <span>{{ auth()->user()->name ?? 'Administrator' }}</span>

                <span class="role">Administrator</span>

            </div>

            <div class="profile-avatar">

                @php $currentUser = auth()->user()->fresh(); @endphp

                @if($currentUser && $currentUser->profile_picture)

                    <img src="{{ $currentUser->profile_picture_url }}" alt="Profile Picture" class="profile-pic">

                @else

                    <svg viewBox="0 0 52 52" role="img" aria-label="Default administrator profile picture">

                        <circle cx="26" cy="26" r="26" fill="#e3e7ec"/>

                        <ellipse cx="26" cy="20" rx="10" ry="12" fill="#647184"/>

                        <path d="M8 47c2-11 9-17 18-17s16 6 18 17c-5 3-11 5-18 5S13 50 8 47Z" fill="#647184"/>

                    </svg>

                @endif

            </div>

        </div>

    </div>

        <div class="dashboard-scroll">

            <h1 class="page-heading">

    <span class="heading-title">FALSE REPORTS ANALYSIS -</span>

    <span class="school-name">{{ $school->school_name }}</span>

</h1>

<p class="subtitle">

    Identify patterns and suspicious activity in false reports

</p>

            @php

                $summaryCards = [

                    ['label' => 'Total False Reports', 'value' => $totalFalseReports, 'icon' => 'warning'],

                    ['label' => 'Emails with 2+ False', 'value' => $totalSuspiciousEmails, 'icon' => 'email'],

                    ['label' => 'Names with 2+ False', 'value' => $totalSuspiciousNames, 'icon' => 'name'],

                    ['label' => 'Phones with 2+ False', 'value' => $totalSuspiciousPhones ?? 0, 'icon' => 'phone'],

                ];

                $patternSections = [

                    ['key'=>'email','title'=>'Suspicious Email Patterns','desc'=>'Emails with multiple false reports','data'=>$suspiciousEmails,'empty'=>'No Suspicious Email Patterns Found','emptyDesc'=>'All false reports have unique email addresses','icon'=>'✉'],

                    ['key'=>'name','title'=>'Suspicious Name Patterns','desc'=>'Names with multiple false reports','data'=>$suspiciousNames,'empty'=>'No Suspicious Name Patterns Found','emptyDesc'=>'All false reports have unique names','icon'=>'♙'],

                    ['key'=>'phone','title'=>'Suspicious Phone Patterns','desc'=>'Phone numbers with multiple false reports','data'=>$suspiciousPhones ?? [],'empty'=>'No Suspicious Phone Patterns Found','emptyDesc'=>'All false reports have unique phone numbers','icon'=>'☎'],

                ];

            @endphp

            <div class="stats-grid">

                @foreach($summaryCards as $card)

                    <div class="stat-card">

                        <span class="stat-icon" aria-hidden="true">

                            @if($card['icon'] === 'warning')
                                {{-- Prototype: bold white warning triangle --}}
                                <svg viewBox="0 0 64 64" aria-hidden="true">
                                    <path d="M32 8 58 54H6L32 8Z" stroke-width="4.8" stroke-linejoin="round" />
                                    <path d="M32 25v13" stroke-width="5" />
                                    <circle cx="32" cy="46" r="2.8" fill="white" stroke="none" />
                                </svg>
                            @elseif($card['icon'] === 'email')
                                {{-- Prototype: envelope and overlapping alert circle --}}
                                <svg viewBox="0 0 64 64" aria-hidden="true">
                                    <rect x="5" y="12" width="43" height="34" rx="3.5" stroke-width="3.8" />
                                    <path d="M7 16 26.5 31 46 16" stroke-width="3.8" />
                                    <circle cx="47" cy="44" r="14" fill="#38b6ff" stroke="white" stroke-width="3.8" />
                                    <path d="M47 37v9" stroke-width="3.6" />
                                    <circle cx="47" cy="51" r="2" fill="white" stroke="none" />
                                </svg>
                            @elseif($card['icon'] === 'name')
                                {{-- Prototype: person silhouette with small spark and alert triangle --}}
                                <svg viewBox="0 0 64 64" aria-hidden="true">
                                    <circle cx="24" cy="22" r="7" fill="white" stroke="none" />
                                    <path d="M12 48c0-11 5-17 12-17 6 0 10 4 11 10" stroke-width="4" />
                                    <path d="m10 12-4-5M39 9l4-6M44 19l6-2" stroke-width="3.6" />
                                    <path d="M45 33 60 58H30l15-25Z" fill="#38b6ff" stroke="white" stroke-width="3" />
                                    <path d="M45 42v7" stroke-width="2.8" />
                                    <circle cx="45" cy="53" r="1.6" fill="white" stroke="none" />
                                </svg>
                            @else
                                {{-- Prototype: phone screen with prominent warning triangle --}}
                                <svg viewBox="0 0 64 64" aria-hidden="true">
                                    <rect x="14" y="3" width="36" height="58" rx="4" stroke-width="4" />
                                    <path d="M25 9h14" stroke-width="2.5" />
                                    <circle cx="32" cy="55" r="2" fill="white" stroke="none" />
                                    <circle cx="32" cy="32" r="17" fill="#38b6ff" stroke="white" stroke-width="2.8" />
                                    <path d="M32 19 44 42H20l12-23Z" fill="white" stroke="white" stroke-width="2" />
                                    <path d="M32 27v8" stroke="#38b6ff" stroke-width="3" />
                                    <circle cx="32" cy="39" r="1.5" fill="#38b6ff" stroke="none" />
                                </svg>
                            @endif

                        </span>

                        <span class="stat-label">{{ $card['label'] }}</span>

                        <span class="stat-value">{{ $card['value'] }}</span>

                    </div>

                @endforeach

            </div>

            <section class="filters-panel" aria-label="Report filters">

                <h2 class="filters-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 4h18l-7 8v7l-4 2v-9L3 4Z"/></svg>Filters</h2>

                <nav class="filter-tabs">

                    @foreach(['all'=>'All Reports','email'=>'By Email','name'=>'By Name','phone'=>'By Phone'] as $filter => $label)

                        <a href="{{ url('/admin/false-reports') . '?action=' . $filter }}" class="filter-tab {{ $actionFilter === $filter ? 'active' : '' }}" @if($actionFilter === $filter) aria-current="page" @endif>{{ $label }}</a>

                    @endforeach

                </nav>

            </section>

            @foreach($patternSections as $section)

                @if($actionFilter === 'all' || $actionFilter === $section['key'])

                    <section class="panel">

                        <h2>{{ $section['title'] }}</h2>

                        <p class="section-desc">{{ $section['desc'] }}</p>

                        @forelse($section['data'] as $pattern => $reports)

                            <div class="pattern-group" data-accordion>

                                <button type="button" class="pattern-toggle" aria-expanded="false">

                                    <span class="pattern-icon" aria-hidden="true">{{ $section['icon'] }}</span>

                                    <span class="pattern-key">{{ $section['key'] === 'name' ? ucwords($pattern) : $pattern }}</span>

                                    <span class="pattern-count">{{ count($reports) }} {{ count($reports) === 1 ? 'Report' : 'Reports' }}</span>

                                    <span class="chevron" aria-hidden="true">⌄</span>

                                </button>

                                <div class="pattern-details">

                                    <div class="table-wrap">

                                        <table class="reports-table">

                                            <thead><tr><th>Case Number</th><th>Name</th><th>Email</th><th>Phone</th><th>Report Type</th><th>Description</th><th>Date</th><th>Status Reason</th></tr></thead>

                                            <tbody>

                                                @foreach($reports as $report)

                                                   <tr class="report-clickable" tabindex="0" role="button"
    aria-label="View report {{ $report->case_number }}">

                                                        <td>{{ $report->case_number }}</td>

                                                        <td>{{ $report->full_name ?: 'N/A' }}</td>

                                                        <td>{{ $report->reporter_email ?: 'N/A' }}</td>

                                                        <td>{{ $report->phone_number ?: 'N/A' }}</td>

                                                        <td>{{ $report->abuseType->type_name ?? 'N/A' }}</td>

                                                        <td class="desc-cell" title="{{ $report->description ?? '' }}">{{ $report->description ?: 'N/A' }}</td>

                                                        <td>{{ $report->created_at?->format('Y-m-d') ?? 'N/A' }}</td>

                                                        <td>{{ $report->latest_status_reason ?: 'N/A' }}</td>

                                                    </tr>

                                                @endforeach

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="empty-state"><div class="empty-icon" aria-hidden="true">☑</div><h3>{{ $section['empty'] }}</h3><p>{{ $section['emptyDesc'] }}</p></div>

                        @endforelse

                    </section>

                @endif

            @endforeach

            @if($actionFilter === 'all')

                <section class="panel">

                    <h2>All False Reports</h2>

                    <p class="section-desc">Complete list of all false reports for this school</p>

                    @if($falseReports->count() > 0)

                        <div class="table-toolbar"><label>Show <select id="pageSize"><option>10</option><option>25</option><option>50</option><option>100</option></select> entries</label><span id="tableSummary"></span></div>

                        <div class="table-wrap">

                            <table class="reports-table" id="allFalseTable">

                                <thead><tr><th>Case Number</th><th>Name</th><th>Email</th><th>Phone</th><th>Report Type</th><th>Description</th><th>Date</th><th>Status Reason</th></tr></thead>

                                <tbody>

                                    @foreach($falseReports as $report)

                                        <tr class="report-clickable" tabindex="0" role="button"
    aria-label="View report {{ $report->case_number }}">
<td><strong>{{ $report->case_number }}</strong></td><td>{{ $report->full_name ?: 'N/A' }}</td><td>{{ $report->reporter_email ?: 'N/A' }}</td><td>{{ $report->phone_number ?: 'N/A' }}</td><td>{{ $report->abuseType->type_name ?? 'N/A' }}</td><td class="desc-cell" title="{{ $report->description ?? '' }}">{{ $report->description ?: 'N/A' }}</td><td>{{ $report->created_at?->format('Y-m-d') ?? 'N/A' }}</td><td>{{ $report->latest_status_reason ?: 'N/A' }}</td></tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                        <div class="pagination-controls"><button id="prevPage" type="button">Previous</button><span id="pageNumber"></span><button id="nextPage" type="button">Next</button></div>

                    @else

                        <div class="empty-state"><h3>No False Reports</h3><p>There are no false reports for this school at this time.</p></div>

                    @endif

                </section>

            @endif

        </div>

    </div>


<!-- =====================================
     REPORT DETAILS MODAL
===================================== -->

<div class="report-modal" id="reportModal" aria-hidden="true">

    <div class="report-modal-content"
         role="dialog"
         aria-modal="true"
         aria-labelledby="reportModalTitle">

        <!-- HEADER -->
        <div class="report-modal-header">

            <div class="report-modal-main-icon">
    <img src="{{ asset('images/39.png') }}" alt="Clipboard">
</div>

            <div class="report-modal-heading">
                <h2 id="reportModalTitle">Report Details</h2>
                <p>Case-<span id="modalCaseNumber">N/A</span></p>
            </div>

            <button type="button"
                    class="report-modal-close"
                    id="closeReportModal">
                &times;
            </button>

        </div>

        <!-- STATUS BANNER -->
        <div class="report-status-banner">

            <div class="report-status-alert">!</div>

            <div class="report-status-text">
                <strong id="modalBannerTitle">FALSE REPORT FLAGGED</strong>
                <span id="modalBannerText">Report status information</span>
            </div>

        </div>

        <!-- FLAG WARNING -->
        <div class="report-flag-warning">

            <strong>ATTENTION: THIS REPORT IS FLAGGED</strong>

            <p>Flag Reason: <span id="modalFlagReason">N/A</span></p>

            <p id="modalFlagMessage">
                The report has been flagged for review.
            </p>

        </div>

        <!-- REPORT INFORMATION -->

<!-- REPORT INFORMATION -->

<div class="report-info-grid">

    <!-- EMAIL -->
    <div class="report-info-item">
        <div class="report-info-icon">
            <img src="{{ asset('images/22.png') }}" alt="Email">
        </div>
        <div class="report-info-text">
            <strong>Email:</strong>
            <span id="modalEmail">N/A</span>
        </div>
    </div>

    <!-- TYPE -->
    <div class="report-info-item">
        <div class="report-info-icon">
            <img src="{{ asset('images/23.png') }}" alt="Type">
        </div>
        <div class="report-info-text">
            <strong>Type:</strong>
            <span id="modalType">N/A</span>
        </div>
    </div>

    <!-- SUBTYPE -->
    <div class="report-info-item">
        <div class="report-info-icon">
            <img src="{{ asset('images/26.png') }}" alt="Subtype">
        </div>
        <div class="report-info-text">
            <strong>Subtype:</strong>
            <span id="modalSubtype">N/A</span>
        </div>
    </div>

    <!-- PHONE -->
    <div class="report-info-item">
        <div class="report-info-icon">
            <img src="{{ asset('images/25.png') }}" alt="Phone">
        </div>
        <div class="report-info-text">
            <strong>Phone:</strong>
            <span id="modalPhone">N/A</span>
        </div>
    </div>

    <!-- REPORT ID -->
    <div class="report-info-item">
        <div class="report-info-icon">
            <img src="{{ asset('images/29.png') }}" alt="Report ID">
        </div>
        <div class="report-info-text">
            <strong>Report ID:</strong>
            <span id="modalReportId">N/A</span>
        </div>
    </div>

    <!-- GRADE -->
    <div class="report-info-item">
        <div class="report-info-icon">
            <img src="{{ asset('images/27.png') }}" alt="Grade">
        </div>
        <div class="report-info-text">
            <strong>Grade:</strong>
            <span id="modalGrade">N/A</span>
        </div>
    </div>

    <!-- SCHOOL -->
    <div class="report-info-item">
        <div class="report-info-icon">
            <img src="{{ asset('images/28.png') }}" alt="School">
        </div>
        <div class="report-info-text">
            <strong>School:</strong>
            <span id="modalSchool">N/A</span>
        </div>
    </div>

    <!-- CURRENT STATUS -->
    <div class="report-info-item">
        <div class="report-info-icon">
            <img src="{{ asset('images/30.png') }}" alt="Current Status">
        </div>
        <div class="report-info-text">
            <strong>Current Status:</strong>
            <span id="modalCurrentStatus">N/A</span>
        </div>
    </div>

</div>

        <!-- REASON AND CLARIFICATION -->
        <div class="report-reason-grid">

            <div class="report-reason-box">
                <strong>REASON FOR FLAGGING</strong>
                <span id="modalReason">N/A</span>
            </div>

            <div class="report-reason-box">
                <strong>REPORTER'S CLARIFICATION</strong>
                <span id="modalClarification">
                    The reporter has not responded yet.
                </span>
            </div>

        </div>

        <!-- DESCRIPTION -->
        <label class="report-description-label">Description</label>

        <div class="report-description-box" id="modalDescription">
            N/A
        </div>

        <!-- ATTACHMENTS -->
        <div class="report-modal-section">

           <div class="report-modal-section-title">
    <span class="report-info-icon">
        <img src="{{ asset('images/23.png') }}" alt="Attachments">
    </span>
    Attachments
</div>

            <div class="report-attachments-empty">
                No attachments uploaded
            </div>

        </div>

        <!-- UPDATE STATUS -->
        <div class="report-modal-section">

            <div class="report-modal-section-title">
    <span class="report-info-icon">
        <img src="{{ asset('images/32.png') }}" alt="Update Status">
    </span>
    Update Status
</div>

            <select class="report-status-select" id="modalStatusSelect">
                <option value="Awaiting Resolution">Awaiting Resolution</option>
                <option value="Under Review">Under Review</option>
                <option value="Forwarded">Forwarded</option>
                <option value="Closed">Closed</option>
                <option value="False Report">False Report</option>
            </select>

        </div>

        <!-- ACTION BUTTONS -->
        <div class="report-modal-actions">

            <button type="button"
                    class="block-reporter-btn"
                    id="blockReporterBtn">
                Block Reporter
            </button>

            <button type="button"
                    id="cancelReportModal">
                Cancel
            </button>

        </div>

    </div>
</div>



    <script>

    document.querySelectorAll('[data-accordion]').forEach((group) => {

        const button = group.querySelector('.pattern-toggle');

        button.addEventListener('click', () => {

            const open = group.classList.toggle('open');

            button.setAttribute('aria-expanded', String(open));

        });

    });

    const table = document.getElementById('allFalseTable');

    if (table) {

        const rows = Array.from(table.querySelectorAll('tbody tr'));

        const size = document.getElementById('pageSize');

        const summary = document.getElementById('tableSummary');

        const pageNumber = document.getElementById('pageNumber');

        const prev = document.getElementById('prevPage');

        const next = document.getElementById('nextPage');

        let page = 1;

        function renderPage() {

            const perPage = Number(size.value);

            const pages = Math.max(1, Math.ceil(rows.length / perPage));

            page = Math.min(Math.max(page, 1), pages);

            const start = (page - 1) * perPage;

            rows.forEach((row, i) => { row.hidden = i < start || i >= start + perPage; });

            summary.textContent = `Showing ${rows.length ? start + 1 : 0} - ${Math.min(start + perPage, rows.length)} of ${rows.length} Reports`;

            pageNumber.textContent = `${page} / ${pages}`;

            prev.disabled = page === 1;

            next.disabled = page === pages;

        }

        size.addEventListener('change', () => { page = 1; renderPage(); });

        prev.addEventListener('click', () => { page--; renderPage(); });

        next.addEventListener('click', () => { page++; renderPage(); });

        renderPage();

    }
    


// ======================================
// REPORT DETAILS MODAL
// ======================================

const reportModal = document.getElementById('reportModal');

function setModalText(id, value) {
    const element = document.getElementById(id);

    if (element) {
        element.textContent = value || 'N/A';
    }
}

function openReportModal(row) {

    const data = row.dataset;

    setModalText('modalCaseNumber', data.case);
    setModalText('modalReportId', data.case);
    setModalText('modalEmail', data.email);
    setModalText('modalPhone', data.phone);
    setModalText('modalType', data.type);
    setModalText('modalSubtype', data.subtype);
    setModalText('modalGrade', data.grade);
    setModalText('modalSchool', data.school);
    setModalText('modalCurrentStatus', data.status);
    setModalText('modalReason', data.reason);
    setModalText('modalFlagReason', data.reason);
    setModalText('modalClarification', data.clarification);
    setModalText('modalDescription', data.description);

    setModalText(
        'modalBannerText',
        'Report date: ' + (data.date || 'N/A')
    );

    setModalText(
        'modalBannerTitle',
        'FALSE REPORT FLAGGED'
    );

    setModalText(
        'modalFlagMessage',
        'This report has been identified for review.'
    );

    // Match the dropdown to the selected report
    const statusSelect = document.getElementById('modalStatusSelect');

    if (statusSelect) {
        const matchingOption = Array.from(statusSelect.options)
            .find(option => option.value === data.status);

        statusSelect.value = matchingOption
            ? data.status
            : 'Awaiting Resolution';
    }

    reportModal.classList.add('active');
    reportModal.setAttribute('aria-hidden', 'false');

    document.body.style.overflow = 'hidden';

    document.getElementById('closeReportModal').focus();
}

// Open modal when clicking any report row
document.addEventListener('click', function(event) {

    const row = event.target.closest('tr.report-clickable');

    if (row) {
        openReportModal(row);
    }
});

// Close modal
function closeReportDetails() {

    reportModal.classList.remove('active');
    reportModal.setAttribute('aria-hidden', 'true');

    document.body.style.overflow = '';
}

document.getElementById('closeReportModal')
    .addEventListener('click', closeReportDetails);

document.getElementById('cancelReportModal')
    .addEventListener('click', closeReportDetails);

// Close when clicking outside
reportModal.addEventListener('click', function(event) {

    if (event.target === reportModal) {
        closeReportDetails();
    }
});

// Close using Escape
document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape' &&
        reportModal.classList.contains('active')) {

        closeReportDetails();
    }

    // Keyboard accessibility for report rows
    if ((event.key === 'Enter' || event.key === ' ') &&
        event.target.matches('tr.report-clickable')) {

        event.preventDefault();
        openReportModal(event.target);
    }
});

// Block button: backend integration still required
document.getElementById('blockReporterBtn')
    .addEventListener('click', function() {

        alert('The Block Reporter action must be connected to your Laravel blocking functionality.');
    });


    </script>

    <x-school-admin-sidebar-script />

</body>

</html>
