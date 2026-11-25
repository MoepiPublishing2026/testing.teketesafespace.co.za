<!DOCTYPE html>
<html lang="en" class="pa-app-root">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reports | Tekete SafeSpace – {{ $province->province_name ?? 'Provincial Admin' }}</title>
    <x-favicon />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <style>
:root {
    --theme-gradient: linear-gradient(to right, #38b6ff, #38b6ff);
    --black: #000000;
    --gray-light: #dadada;
    --gray-dark: #2a2e32;
    --offwhite: #fffbf7;
    --lime: #c7da30;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
html, body { font-family: 'Montserrat', sans-serif !important; color: #545454 !important; background-color: white !important; }
body {
    display: flex;
    min-height: 100vh;
    width: 100%;
    min-width: 0;
    overflow-x: hidden;
    overflow-y: hidden;
}

.sidebar-link, button, select, input, label { font-size: 15px !important; font-weight: 400 !important; color: #545454 !important; font-family: 'Montserrat', sans-serif !important; }
button { background-color: white !important; color: #38b6ff !important; border: 3px solid #c7da30 !important; font-weight: 700 !important; font-family: 'Montserrat', sans-serif !important; padding: 0.75rem 1rem !important; border-radius: 0.5rem !important; cursor: pointer !important; transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease; }
button:hover, button:focus { background-color: #c7da30 !important; color: white !important; border-color: #38b6ff !important; outline: none; }
.main-panel { flex: 1 1 0; display: flex; flex-direction: column; height: 100vh; min-width: 0; }

main { flex: 1; padding: 2.5rem; background: #fff; overflow-y: auto; min-width: 0; }

.topbar {
    width: 100%;
    background: #fff;
    border: 0;
    display: flex;
    align-items: flex-start;
    justify-content: flex-end;
    padding: 24px 39px 0;
    position: relative;
    z-index: 10;
    box-shadow: none;
    height: 78px;
    flex: 0 0 78px;
    min-height: 0;
}
.profile { display: flex; align-items: flex-start; gap: 12px; }
.profile-avatar {
    width: 52px; height: 52px; flex: 0 0 52px; border-radius: 50%;
    background: transparent; overflow: hidden;
    display: flex; align-items: center; justify-content: center;
    box-shadow: none;
}
.profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
.profile .meta { text-align: right; }
.profile .meta > span:first-child { color: #38b6ff; font-size: 18px; font-weight: 700; }
.profile .meta span { display: block; line-height: 1.3; font-weight: 700; color: #232323; }
.profile .meta .role { font-weight: 400; color: #4a4a4a; font-size: 13px; }
h1 {
    margin: 0 0 1.5rem;
    font-weight: 900 !important;
    font-size: 32px !important;
    font-family: 'Montserrat', sans-serif !important;
    letter-spacing: 0.03em;
    text-transform: uppercase !important;
    color: #545454 !important;
    text-align: center;
}
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
    color: var(--black);
    font-family: 'Montserrat', sans-serif;
    table-layout: fixed;
}

.table-wrap {
    width: 100%;
    max-width: 100%;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    touch-action: pan-x;
    border: 3px solid #c7da30;
    border-radius: 0.375rem;
    background: var(--gray-light);
}
.table-wrap table { width: max-content; min-width: 100%; border: 0; background: transparent; }
thead { background: #bbc93dff; color: black; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.75rem; }
th, td { padding: 0.9rem 1rem; border-bottom: 1px solid var(--lime); text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
tbody tr:hover { background: rgba(199,218,48,0.15); cursor: pointer; transition: background-color 0.3s ease; }
tbody tr:last-child td { border-bottom: none; }

/* ── Status Badge Styling ── */
.status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.4rem 0.8rem;
    border-radius: 16px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: capitalize;
    white-space: nowrap;
}

.status-awaiting-resolution {
    background-color: #fef3c7;
    color: #92400e;
    border: 1px solid #fcd34d;
}

.status-under-review {
    background-color: #dbeafe;
    color: #1e40af;
    border: 1px solid #93c5fd;
}

.status-forwarded {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

.status-closed {
    background-color: #dcfce7;
    color: #166534;
    border: 1px solid #86efac;
}

.status-unresolved {
    background-color: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
}
.status-false-report {
    background-color: #f3e8ff;
    color: #6b21a8;
    border: 1px solid #e9d5ff;
}

.pagination { display: flex; justify-content: center; margin-top: 1rem; }
.page-item.active .page-link { background: #cddc39; border-color: #cddc39; color: black; }
.page-link {
    border: 1px solid #cddc39; color: black; border-radius: 50%;
    width: 35px; height: 35px; text-align: center; line-height: 32px;
    margin: 0 4px; transition: all 0.3s ease; display: inline-block;
    text-decoration: none;
}
.page-link:hover { background: #cddc39; color: white; }

/* ── Modal Styling ── */
.modal-backdrop {
    position: fixed; inset: 0;
    background: rgba(0, 12, 12, 0.4);
    display: none; align-items: center; justify-content: center;
    z-index: 1100; backdrop-filter: blur(2px);
}

.modal-card {
    background: #fff; border: 3px solid #d7e47a; border-radius: 16px;
    width: 950px; max-width: 95vw; max-height: 90vh;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    display: flex; flex-direction: column;
    font-family: 'Montserrat', sans-serif; color: #333;
    position: relative; overflow: visible;
}

/* Top Right Close X */
.modal-close-x {
    position: absolute; top: 20px; right: 25px;
    background: transparent !important; border: none !important;
    font-size: 28px !important; font-weight: 400 !important; color: #333 !important;
    cursor: pointer; padding: 0 !important; transition: color 0.2s !important;
    line-height: 1; z-index: 10;
}
.modal-close-x:hover { color: #38b6ff !important; }

.modal-content { 
    padding: 2rem; 
    overflow-y: auto; flex: 1;
}

/* Header Section */
.modal-header-custom {
    display: flex; align-items: center; gap: 15px; margin-bottom: 2rem;
}
.modal-header-icon {
    width: 50px; height: 50px; background: #c7da30; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 24px;
}
.modal-header-text h3 {
    margin: 0; font-size: 24px; font-weight: 800; color: #000;
    text-transform: none; border: none; padding: 0; letter-spacing: 0;
}
.modal-header-text p {
    margin: 0; font-size: 16px; color: #666; display: block;
}

/* 3-Column Grid */
.modal-grid {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 24px; margin-bottom: 2rem;
}

.grid-item {
    display: flex; align-items: flex-start; gap: 12px;
}
.grid-icon {
    width: 36px; height: 36px; background: #38b6ff; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 16px; flex-shrink: 0;
}
.grid-text { display: flex; flex-direction: column; }
.grid-label {
    font-weight: 700; color: #000; font-size: 15px; margin-bottom: 2px;
}
.grid-value {
    color: #333; font-size: 15px; word-break: break-word;
}
.text-italic { font-style: italic; }
.text-brown { color: #a37b4e; }

/* Description Box */
.modal-desc-section { margin-bottom: 2rem; }
.modal-desc-title {
    font-size: 16px; font-weight: 400; color: #000; margin-bottom: 8px; display: block;
}
.modal-desc-box {
    border: 4px solid #c7da30; border-radius: 8px;
    min-height: 120px; padding: 15px;
    font-size: 15px; color: #333;
    white-space: pre-wrap; line-height: 1.5;
    background: #fff;
}

/* Attachments */
.modal-attach-section { margin-bottom: 1rem; }
.modal-attach-title {
    display: flex; align-items: center; gap: 10px;
    font-size: 16px; font-weight: 400; color: #000; margin-bottom: 15px;
}
.modal-attach-title i {
    width: 32px; height: 32px; background: #38b6ff; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 14px;
}
.attachments-container {
    display: flex; flex-wrap: wrap; gap: 12px; padding-left: 2px;
}
.attachments-container img, 
.attachments-container video {
    border: 2px solid #c7da30; border-radius: 8px;
    width: 90px !important; height: 90px !important;
    object-fit: cover; cursor: pointer; transition: opacity 0.2s;
}
.attachments-container img:hover { opacity: 0.8; }
.attachments-container a {
    display: inline-block; padding: 8px 12px; background: #f0f9d4;
    border: 1px solid #c7da30; border-radius: 6px; color: #4a5e00;
    text-decoration: none; font-weight: 600; font-size: 13px;
}
.attachments-container a:hover { background: #c7da30; color: #fff; }
.text-empty { color: #9ca3af; font-style: italic; font-size: 15px; }
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-thumb { background: var(--lime); border-radius: 10px; }
::-webkit-scrollbar-track { background: #f2f2f2; }

@media (max-width: 900px) {
    .main-panel { margin-left: 0 !important; height: 100vh; }
    main { padding: 1.25rem; }
    .filter-grid { grid-template-columns: 1fr 1fr !important; }
    th, td { padding: 0.65rem 0.75rem; }
    h1 { font-size: 22px !important; }
}
@media (max-width: 540px) {
    .filter-grid { grid-template-columns: 1fr !important; }
    main { padding: 1rem; }
}
@media (max-width: 600px) {
    .menu-icon { top: 10px; left: 10px; width: 40px; height: 40px; font-size: 20px; }
    .main-panel.shifted { margin-left: 0; }
}

/* ── Filter Panel ──────────────────────────────────────────────── */
.filter-panel {
    background: #f9fafb;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 24px;
}
.filter-label {
    font-family: 'Montserrat', sans-serif;
    font-size: 13px !important;
    font-weight: 700 !important;
    color: #545454 !important;
    text-transform: none;
    letter-spacing: 0;
    margin-bottom: 5px;
    display: block;
}
.filter-input {
    width: 100%;
    border: 2px solid #e5e7eb !important;
    border-radius: 8px;
    padding: 7px 10px !important;
    font-size: 15px !important;
    font-family: 'Montserrat', sans-serif !important;
    color: #545454 !important;
    background: white !important;
    transition: border-color 0.2s;
    outline: none;
    box-sizing: border-box;
    font-weight: 400 !important;
    margin: 0 !important;
    display: block;
}
.filter-input:focus { border-color: #c7da30 !important; box-shadow: 0 0 0 3px rgba(199,218,48,0.15); }
.search-wrap { position: relative; margin-bottom: 18px; }
.search-wrap input {
    width: 100%;
    border: 2px solid #c7da30 !important;
    border-radius: 30px;
    padding: 10px 20px 10px 44px !important;
    font-size: 15px !important;
    font-family: 'Montserrat', sans-serif !important;
    color: #545454 !important;
    background: white !important;
    outline: none;
    transition: box-shadow 0.2s;
    box-sizing: border-box;
    font-weight: 400 !important;
    margin: 0 !important;
}
.search-wrap input:focus { box-shadow: 0 0 0 3px rgba(199,218,48,0.2); }
.search-icon {
    position: absolute; left: 16px; top: 50%;
    transform: translateY(-50%); color: #aaa;
    pointer-events: none; font-size: 15px;
}
.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 12px;
    align-items: end;
}
.filter-btn {
    width: 100%; border-radius: 8px !important;
    padding: 8px 14px !important; font-size: 12px !important;
    font-family: 'Montserrat', sans-serif !important;
    font-weight: 700 !important; cursor: pointer;
    transition: all 0.2s; height: 36px;
    margin: 0 !important; display: block;
}
.filter-btn-apply { background: #38b6ff !important; color: white !important; border: none !important; }
.filter-btn-clear { background: white !important; border: 2px solid #e5e7eb !important; color: #6b7280 !important; }
.filter-btn-apply:hover { background: #1a9fe0 !important; color: white !important; border: none !important; }
.filter-btn-clear:hover { border-color: #c7da30 !important; color: #000 !important; background: #f7fcd4 !important; }
#refreshBtn {
    width: 100%;
    background: #38b6ff !important;
    color: white !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 8px 14px !important;
    font-size: 12px !important;
    font-family: 'Montserrat', sans-serif !important;
    font-weight: 700 !important;
    cursor: pointer;
    height: 36px;
    transition: background-color 0.2s;
    margin: 0 !important;
    display: block !important;
}
#refreshBtn:hover { background: #1a9fe0 !important; color: white !important; }

.active-filter-badge {
    display: inline-flex; align-items: center;
    background: #f0f9d4; border: 1px solid #c7da30;
    border-radius: 20px; padding: 2px 10px;
    font-size: 11px; font-family: 'Montserrat', sans-serif;
    font-weight: 600; color: #4a5e00;
    margin-right: 6px; margin-bottom: 6px;
}

/* ── Choices.js overrides ──────────────────────────────────────── */
.choices {
    margin: 0 !important;
}
.choices__inner {
    border: 2px solid #e5e7eb !important;
    border-radius: 8px !important;
    background: white !important;
    font-family: 'Montserrat', sans-serif !important;
    font-size: 13px !important;
    min-height: unset !important;
    padding: 4px 8px !important;
    color: #111 !important;
}
.choices__inner:focus-within {
    border-color: #c7da30 !important;
    box-shadow: 0 0 0 3px rgba(199,218,48,0.15) !important;
}
.choices_list--single .choices_item {
    font-size: 13px !important;
    font-family: 'Montserrat', sans-serif !important;
    color: #111 !important;
    padding: 2px 0 !important;
}
.choices__list--dropdown {
    border: 2px solid #c7da30 !important;
    border-radius: 8px !important;
    font-family: 'Montserrat', sans-serif !important;
    font-size: 13px !important;
    z-index: 9999 !important;
}
.choices_list--dropdown .choices_item {
    font-size: 13px !important;
    font-family: 'Montserrat', sans-serif !important;
    color: #111 !important;
    padding: 8px 12px !important;
}
.choices__list--dropdown .choices__item--selectable.is-highlighted {
    background: #f7fcd4 !important;
    color: #000 !important;
}
.choices__input {
    font-family: 'Montserrat', sans-serif !important;
    font-size: 13px !important;
    color: #111 !important;
    background: white !important;
}
.choices[data-type*="select-one"] .choices__button {
    display: none;
}
.choices__placeholder {
    color: #9ca3af !important;
    opacity: 1 !important;
}

/* Provincial Reports — match the School/National Admin reports visual system */
body.pa-app {
    --reports-lime: #c7da30;
    --reports-blue: #38b6ff;
    background: #fff !important;
}

body.pa-app .main-panel {
    height: 100vh;
    overflow: hidden;
    background: #fff;
}

body.pa-app .topbar {
    position: relative;
    height: 78px;
    flex: 0 0 78px;
    align-items: flex-start;
    padding: 24px 39px 0;
    border: 0;
    background: #fff;
    box-shadow: none;
}

body.pa-app .profile {
    align-items: flex-start;
    gap: 12px;
}

body.pa-app .profile .meta {
    padding-top: 4px;
    line-height: 1.08;
}

body.pa-app .profile .meta > span:first-child {
    color: var(--reports-blue) !important;
    font-size: 18px !important;
    font-weight: 700 !important;
}

body.pa-app .profile .meta .role {
    margin-top: 2px;
    color: #4a4a4a !important;
    font-size: 13px !important;
    font-weight: 400 !important;
}

body.pa-app .profile-avatar {
    width: 52px;
    height: 52px;
    flex: 0 0 52px;
    background: transparent;
    box-shadow: none;
}

body.pa-app .profile-avatar svg {
    display: block;
    width: 100%;
    height: 100%;
}

body.pa-app main#main-content {
    min-width: 0;
    padding: 3px 39px 18px 24px;
    background: #fff;
}

body.pa-app main#main-content > h1 {
    margin: 0 0 1.5rem !important;
    color: #545454 !important;
    font-size: 32px !important;
    font-weight: 900 !important;
    letter-spacing: 0.03em !important;
    text-transform: uppercase !important;
    line-height: 1.25 !important;
    text-align: center !important;
}

body.pa-app .filter-panel {
    margin: 0 0 1.25rem;
    padding: 1rem 1.15rem;
    border: 2px solid var(--reports-lime) !important;
    border-radius: 10px;
    background: #f5f5f5;
    box-shadow: none;
}

body.pa-app .search-wrap {
    margin-bottom: 0.85rem;
}

body.pa-app .search-icon {
    display: none;
}

body.pa-app .search-wrap input {
    width: 100%;
    height: 40px;
    margin: 0 !important;
    padding: 0 16px !important;
    border: 2px solid var(--reports-lime) !important;
    border-radius: 999px;
    background: #fff !important;
    color: #545454 !important;
    font-size: 15px !important;
    font-weight: 400 !important;
}

body.pa-app .filter-grid {
    display: grid;
    grid-template-columns: repeat(8, minmax(0, 1fr));
    gap: 0.75rem;
    align-items: end;
}

body.pa-app .filter-grid > div {
    min-width: 0;
}

body.pa-app .filter-label {
    display: block;
    height: auto;
    margin: 0 0 0.35rem;
    overflow: hidden;
    color: #545454 !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    letter-spacing: 0;
    line-height: 1.3;
    white-space: nowrap;
}

body.pa-app .filter-input,
body.pa-app #refreshBtn {
    box-sizing: border-box;
    width: 100%;
    height: 40px;
    margin: 0 !important;
    padding: 0 0.65rem !important;
    border-radius: 6px !important;
    font-family: 'Montserrat', sans-serif !important;
    font-size: 15px !important;
}

body.pa-app .filter-input {
    border: 2px solid var(--reports-lime) !important;
    background: #fff !important;
    color: #545454 !important;
    font-weight: 400 !important;
}

body.pa-app #refreshBtn {
    border: 0 !important;
    background: var(--reports-blue) !important;
    color: #fff !important;
    font-weight: 700 !important;
}

body.pa-app .active-filter-badge {
    padding: 0.25rem 0.55rem;
    font-size: 11px;
}

body.pa-app .choices__inner {
    min-height: 40px !important;
    padding: 0 0.65rem !important;
    border: 2px solid var(--reports-lime) !important;
    border-radius: 6px !important;
    font-size: 15px !important;
}

body.pa-app .choices__list--single .choices__item {
    font-size: 15px !important;
    padding: 0.35rem 0 !important;
}

body.pa-app .choices__list--dropdown,
body.pa-app .choices__list--dropdown .choices__item {
    font-size: 13px !important;
}

body.pa-app .table-wrap {
    width: 100%;
    max-width: 100%;
    overflow-x: auto;
    overflow-y: hidden;
    border: 0;
    border-radius: 0;
    background: #e5e5e5;
    -webkit-overflow-scrolling: touch;
}

body.pa-app .table-wrap table {
    display: table;
    width: max-content !important;
    min-width: 100%;
    border-collapse: collapse;
    table-layout: auto !important;
    background: #e5e5e5;
    color: #545454;
    font-size: 13px !important;
}

/* Table Header */
body.pa-app .table-wrap thead {
    background: #c4df20;
    color: #fff;
    font-size: 11px !important;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}

body.pa-app .table-wrap th {
    height: 40px;
    padding: 0 12px;
    border-right: 1px solid rgba(255,255,255,.9);
    border-bottom: 0;
    color: #fff;
    font-size: 11px !important;
    font-weight: 700 !important;
    text-align: center;

    /* Do not cut header text */
    white-space: nowrap;
    overflow: visible;
    text-overflow: clip;
}

/* Table Cells */
body.pa-app .table-wrap td {
    height: 40px;
    padding: 0 12px;
    border-right: 1px solid rgba(255,255,255,.9);
    border-bottom: 1px solid #fff;
    color: #545454;
    font-size: 13px !important;
    font-weight: 400 !important;
    text-align: center;

    /* Show complete information */
    white-space: nowrap;
    overflow: visible;
    text-overflow: clip;
}

/* Give each column enough space */
body.pa-app .table-wrap th:nth-child(1),
body.pa-app .table-wrap td:nth-child(1) {
    min-width: 130px;
}

body.pa-app .table-wrap th:nth-child(2),
body.pa-app .table-wrap td:nth-child(2) {
    min-width: 150px;
}

body.pa-app .table-wrap th:nth-child(3),
body.pa-app .table-wrap td:nth-child(3) {
    min-width: 110px;
}

body.pa-app .table-wrap th:nth-child(4),
body.pa-app .table-wrap td:nth-child(4) {
    min-width: 130px;
}

body.pa-app .table-wrap th:nth-child(5),
body.pa-app .table-wrap td:nth-child(5) {
    min-width: 180px;
}

body.pa-app .table-wrap th:nth-child(6),
body.pa-app .table-wrap td:nth-child(6) {
    min-width: 100px;
}

body.pa-app .table-wrap th:nth-child(7),
body.pa-app .table-wrap td:nth-child(7) {
    min-width: 150px;
}

body.pa-app .table-wrap th:nth-child(8),
body.pa-app .table-wrap td:nth-child(8) {
    min-width: 180px;
}

body.pa-app .table-wrap th:nth-child(9),
body.pa-app .table-wrap td:nth-child(9) {
    min-width: 110px;
}

body.pa-app .table-wrap th:nth-child(10),
body.pa-app .table-wrap td:nth-child(10) {
    min-width: 130px;
}

body.pa-app .table-wrap td:first-child {
    font-weight: 700;
}

body.pa-app .table-wrap tbody tr {
    background: #e5e5e5;
}

body.pa-app .table-wrap tbody tr:hover {
    background: #f4f8d4;
}

body.pa-app .status-badge {
    padding: 4px 8px;
    border: 0;
    border-radius: 999px;
    background: #fff3a6;
    color: #9b8749;
    font-size: 11px !important;
    font-weight: 700 !important;
    line-height: 1.2;
    text-transform: none;
}

body.pa-app .pagination {
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: center;
    gap: 5px;
    margin-top: 13px;
}

body.pa-app .page-link {
    display: inline-flex;
    width: 36px;
    height: 36px;
    margin: 0;
    align-items: center;
    justify-content: center;
    border: 2px solid var(--reports-lime);
    border-radius: 50%;
    background: #fff;
    color: #545454;
    font-size: 15px !important;
    font-weight: 400 !important;
    line-height: 1;
}

body.pa-app .page-link:hover,
body.pa-app .page-link[aria-current="page"] {
    border-color: var(--reports-lime);
    background: var(--reports-lime);
    color: #111;
}

@media (min-width: 1400px) {
    body.pa-app .filter-grid {
        grid-template-columns: repeat(9, minmax(0, 1fr));
    }
}

@media (max-width: 900px) {
    body.pa-app .topbar {
        height: 60px;
        flex-basis: 60px;
        padding: 10px 16px 0 60px;
    }

    body.pa-app main#main-content {
        padding: 12px 16px 24px;
    }

    body.pa-app .filter-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    }

    body.pa-app .table-wrap table {
        min-width: 900px;
    }
}

@media (max-width: 540px) {
    body.pa-app .filter-grid {
        grid-template-columns: 1fr !important;
    }
}
    </style>
    <x-provincial-admin-styles />
</head>
<body class="pa-app">

{{-- Report Details Modal --}}
{{-- Report Details Modal --}}
<div class="modal-backdrop" id="reportModal" aria-hidden="true">
    <div class="modal-card" role="dialog" aria-modal="true" style="background: #fff; border: 3px solid #d7e47a; border-radius: 16px; width: 950px; max-width: 95vw; max-height: 95vh; display: flex; flex-direction: column; font-family: 'Montserrat', sans-serif; position: relative; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        
        <!-- Close X Button -->
        <button type="button" onclick="closeReportModal()" style="position: absolute; top: 20px; right: 25px; background: transparent; border: none; font-size: 28px; font-weight: 400; color: #000; cursor: pointer; padding: 0; line-height: 1; z-index: 10;">&times;</button>

        <div style="padding: 2.5rem 3rem; overflow-y: auto; flex: 1;">
            
            <!-- Header -->
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px;">
                <div style="width: 56px; height: 56px; background-color: #c7da30; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <!-- YOUR CUSTOM IMAGE HERE -->
                    <img src="{{ asset('images/21.png') }}" alt="Report Icon" style="width: 32px; height: 32px; object-fit: contain;">
                </div>
                <div>
                    <h2 style="margin: 0; font-size: 26px; font-weight: 700; color: #000000; line-height: 1.2;">Report Details</h2>
                    <p id="modalCaseNumber" style="margin: 0; font-size: 18px; font-weight: 400; color: #4b5563;"></p>
                </div>
            </div>

            <!-- 3-Column Grid -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px 30px; margin-bottom: 2.5rem;">
                
                <!-- Row 1 -->
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 42px; height: 42px; background: #38b6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <img src="{{ asset('images/34.png') }}" alt="User" style="width: 20px; height: 20px; object-fit: contain;">
                    </div>
                    <div style="display: flex; flex-direction: column; padding-top: 2px;">
                        <span style="font-weight: 800; color: #000; font-size: 16px; margin-bottom: 2px;">Full Name</span>
                        <span id="modalFullName" style="color: #333; font-size: 15px; word-break: break-word;"></span>
                    </div>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 42px; height: 42px; background: #38b6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <img src="{{ asset('images/23.png') }}" alt="Type" style="width: 20px; height: 20px; object-fit: contain;">
                    </div>
                    <div style="display: flex; flex-direction: column; padding-top: 2px;">
                        <span style="font-weight: 800; color: #000; font-size: 16px; margin-bottom: 2px;">Type:</span>
                        <span id="modalType" style="color: #333; font-size: 15px; word-break: break-word;"></span>
                    </div>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 42px; height: 42px; background: #38b6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <img src="{{ asset('images/26.png') }}" alt="Subtype" style="width: 20px; height: 20px; object-fit: contain;">
                    </div>
                    <div style="display: flex; flex-direction: column; padding-top: 2px;">
                        <span style="font-weight: 800; color: #000; font-size: 16px; margin-bottom: 2px;">Subtype:</span>
                        <span id="modalSubtype" style="color: #333; font-size: 15px; word-break: break-word;"></span>
                    </div>
                </div>

                <!-- Row 2 -->
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 42px; height: 42px; background: #38b6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <img src="{{ asset('images/22.png') }}" alt="Email" style="width: 20px; height: 20px; object-fit: contain;">
                    </div>
                    <div style="display: flex; flex-direction: column; padding-top: 2px;">
                        <span style="font-weight: 800; color: #000; font-size: 16px; margin-bottom: 2px;">Email:</span>
                        <span id="modalEmail" style="color: #333; font-size: 15px; word-break: break-word;"></span>
                    </div>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 42px; height: 42px; background: #38b6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <img src="{{ asset('images/16.png') }}" alt="ID" style="width: 20px; height: 20px; object-fit: contain;">
                    </div>
                    <div style="display: flex; flex-direction: column; padding-top: 2px;">
                        <span style="font-weight: 800; color: #000; font-size: 16px; margin-bottom: 2px;">Report ID:</span>
                        <span id="modalReportId" style="color: #333; font-size: 15px; word-break: break-word;"></span>
                    </div>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 42px; height: 42px; background: #38b6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <img src="{{ asset('images/calendar.png') }}" alt="Calendar" style="width: 20px; height: 20px; object-fit: contain;">
                    </div>
                    <div style="display: flex; flex-direction: column; padding-top: 2px;">
                        <span style="font-weight: 800; color: #000; font-size: 16px; margin-bottom: 2px;">Latest Reason:</span>
                        <span id="modalReason" style="color: #a37b4e; font-style: italic; font-size: 15px; word-break: break-word;"></span>
                    </div>
                </div>

                <!-- Row 3 -->
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 42px; height: 42px; background: #38b6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <img src="{{ asset('images/phone.png') }}" alt="Phone" style="width: 20px; height: 20px; object-fit: contain;">
                    </div>
                    <div style="display: flex; flex-direction: column; padding-top: 2px;">
                        <span style="font-weight: 800; color: #000; font-size: 16px; margin-bottom: 2px;">Phone:</span>
                        <span id="modalPhone" style="color: #333; font-size: 15px; word-break: break-word;"></span>
                    </div>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 42px; height: 42px; background: #38b6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <img src="{{ asset('images/status.png') }}" alt="Status" style="width: 20px; height: 20px; object-fit: contain;">
                    </div>
                    <div style="display: flex; flex-direction: column; padding-top: 2px;">
                        <span style="font-weight: 800; color: #000; font-size: 16px; margin-bottom: 2px;">Current Status:</span>
                        <span id="modalStatus" style="color: #333; font-size: 15px; word-break: break-word;"></span>
                    </div>
                </div>
                <div></div> <!-- Empty slot for layout -->

                <!-- Row 4 -->
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 42px; height: 42px; background: #38b6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <img src="{{ asset('images/school.png') }}" alt="School" style="width: 20px; height: 20px; object-fit: contain;">
                    </div>
                    <div style="display: flex; flex-direction: column; padding-top: 2px;">
                        <span style="font-weight: 800; color: #000; font-size: 16px; margin-bottom: 2px;">School:</span>
                        <span id="modalSchool" style="color: #333; font-size: 15px; word-break: break-word;"></span>
                    </div>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 42px; height: 42px; background: #38b6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <img src="{{ asset('images/grade.png') }}" alt="Grade" style="width: 20px; height: 20px; object-fit: contain;">
                    </div>
                    <div style="display: flex; flex-direction: column; padding-top: 2px;">
                        <span style="font-weight: 800; color: #000; font-size: 16px; margin-bottom: 2px;">Grade:</span>
                        <span id="modalGrade" style="color: #333; font-size: 15px; word-break: break-word;"></span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div style="margin-bottom: 2.5rem;">
                <span style="font-size: 18px; font-weight: 400; color: #000; margin-bottom: 12px; display: block;">Description</span>
                <div id="modalDescription" style="border: 4px solid #c7da30; border-radius: 8px; min-height: 140px; padding: 18px; font-size: 16px; color: #333; white-space: pre-wrap; line-height: 1.6; background: #fff;"></div>
            </div>

            <!-- Attachments -->
            <div>
                <div style="display: flex; align-items: center; gap: 10px; font-size: 18px; font-weight: 400; color: #000; margin-bottom: 12px;">
                    <div style="width: 36px; height: 36px; background: #38b6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('images/attachment.png') }}" alt="Attachment" style="width: 18px; height: 18px; object-fit: contain;">
                    </div>
                    Attachments
                </div>
                <div id="modalAttachments" style="display: flex; flex-wrap: wrap; gap: 12px; padding-left: 2px;"></div>
            </div>

        </div>
    </div>
</div>




<x-provincial-admin-sidebar />

<div class="main-panel">
    <button class="menu-icon" id="sidebarToggle" aria-label="Open navigation menu" aria-expanded="false" aria-controls="pa-sidebar" type="button">&#9776;</button>
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
    <main id="main-content">
        <h1>All Reports</h1>

        {{-- ════════════════════════════════════════════════════════════ --}}
        {{--  SEARCH BAR + FILTER PANEL                                  --}}
        {{-- ════════════════════════════════════════════════════════════ --}}
        <form id="filterForm" method="GET" action="{{ url('/provincial-admin/reports') }}">
        <div class="filter-panel">

            {{-- Search Bar --}}
            <div class="search-wrap">
                <span class="search-icon"><i class="fas fa-search"></i></span>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by  email, case number, description"
                    autocomplete="off"
                />
            </div>


            {{-- Filter Grid --}}
            <div class="filter-grid">
                <div>
                    <label class="filter-label">Anonymous</label>
                    <select name="is_anonymous" class="filter-input" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option value="1" {{ request('is_anonymous') === '1' ? 'selected' : '' }}>Anonymous</option>
                        <option value="0" {{ request('is_anonymous') === '0' ? 'selected' : '' }}>Identified</option>
                    </select>
                </div>

            

                <div>
                    <label class="filter-label">Name / Surname</label>
                    <input type="text" name="full_name" class="filter-input"
                           value="{{ request('full_name') }}"
                           placeholder="e.g Joe Smith" />
                </div>

                <div>
                    <label class="filter-label">Grades</label>
                    <select name="grade" class="filter-input" onchange="this.form.submit()">
                        <option value="">All Grades</option>
                        @foreach($gradeOptions as $grade)
                            <option value="{{ $grade }}" {{ request('grade') == $grade ? 'selected' : '' }}>
                                {{ $grade }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="filter-label">Date From</label>
                    <input type="date" name="date_from" class="filter-input"
                           value="{{ request('date_from') }}" onchange="this.form.submit()" />
                </div>

                <div>
                    <label class="filter-label">Date To</label>
                    <input type="date" name="date_to" class="filter-input"
                           value="{{ request('date_to') }}" onchange="this.form.submit()" />
                </div>

                <div>
                    <label class="filter-label">Report Type</label>
                    <select name="type_id" class="filter-input" onchange="document.getElementById('subtypeSelect').value=''; if(typeof filterSubtypes==='function') filterSubtypes(); this.form.submit();">
                        <option value="">All Types</option>
                        @foreach($typeOptions as $type)
                            <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="filter-label">Subtypes</label>
                    <select name="subtype_id" id="subtypeSelect" class="filter-input" onchange="this.form.submit()">
                            <option value="">All Subtypes</option>
                            @foreach($subtypeOptions->sortBy('sub_type_name') as $sub)
                                <option value="{{ $sub->id }}"
                                        data-type="{{ $sub->abuse_type_id }}"
                                        {{ request('subtype_id') == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->sub_type_name }}
                                </option>
                            @endforeach
                    </select>
                </div>

                <div>
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-input" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="awaiting-resolution" {{ request('status') == 'awaiting-resolution' ? 'selected' : '' }}>Awaiting Resolution</option>
                        <option value="under-review"        {{ request('status') == 'under-review'        ? 'selected' : '' }}>Under Review</option>
                        <option value="forwarded"           {{ request('status') == 'forwarded'           ? 'selected' : '' }}>Forwarded</option>
                        <option value="closed"              {{ request('status') == 'closed'              ? 'selected' : '' }}>Closed</option>
                        <option value="unresolved"          {{ request('status') == 'unresolved'          ? 'selected' : '' }}>Unresolved</option>
                        <option value="false-report"        {{ request('status') == 'false-report'        ? 'selected' : '' }}>False Report</option>
                    </select>
                </div>

                <div>
                    <label class="filter-label">School</label>
                    <div style="position:relative;">
                        <input
                            type="text"
                            name="school_name"
                            id="schoolSearch"
                            class="filter-input"
                            autocomplete="off"
                            placeholder="Type to search school…"
                            value="{{ $schoolName }}"
                        />
                        <input type="hidden" name="school_id" id="schoolId" value="{{ request('school_id') }}" />
                        <div id="schoolDropdown"
                             style="display:none; position:absolute; left:0; right:0; top:100%; background:#fff; border:1px solid #d1d5db; max-height:200px; overflow-y:auto; z-index:9999; font-size:13px;"></div>
                    </div>
                </div>
                
                <div style="display:flex; align-items:flex-end;">
                    <button type="button" id="refreshBtn">Refresh Table</button>
                </div>

            </div>{{-- end .filter-grid --}}

            {{-- Active filter badges --}}
            @php
               $activeFilters = array_filter([
                    'Search'    => request('search'),
                    'School'    => request('school_id')
                                    ? ($schoolOptions->firstWhere('school_id', request('school_id'))?->school_name ?? request('school_id'))
                                    : (request('school_name') ?: null),
                    'Name'      => request('full_name'),
                    'Grade'     => request('grade'),
                    'From'      => request('date_from'),
                    'To'        => request('date_to'),
                    'Type'      => request('type_id')    ? ($typeOptions->firstWhere('id', request('type_id'))?->type_name          ?? request('type_id'))    : null,
                    'Subtype'   => request('subtype_id') ? ($subtypeOptions->firstWhere('id', request('subtype_id'))?->sub_type_name ?? request('subtype_id')) : null,
                    'Status'    => request('status'),
                    'Anonymous' => request('is_anonymous') !== null && request('is_anonymous') !== ''
                                    ? (request('is_anonymous') === '1' ? 'Yes' : 'No')
                                    : null,
                ]);
            @endphp
            @if(count($activeFilters))
                <div style="margin-top:12px; display:flex; flex-wrap:wrap; align-items:center;">
                    @foreach($activeFilters as $label => $val)
                        <span class="active-filter-badge">
                            <i class="fas fa-filter" style="font-size:9px; margin-right:4px;"></i>
                            {{ $label }}: {{ $val }}
                        </span>
                    @endforeach
                    <span style="font-size:11px; color:#9ca3af; margin-left:4px;">
                        — {{ $reports->total() }} result(s)
                    </span>
                </div>
            @endif

        </div>{{-- end .filter-panel --}}
        </form>
        {{-- ══════════════════════════ END FILTER PANEL ════════════════ --}}

        <div class="table-wrap">
        <table aria-label="List of filtered reports">
            <thead>
                <tr>
                    <th>Case Number</th>
                    <th>Full Name</th>
                    <th>Province</th>
                    <th>District</th>
                    <th>School</th>
                    <th>Grade</th>
                    <th>Report Type</th>
                    <th>Status</th>
                    <th>Anonymous</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                    <tr onclick="openReportModal({{ $report->id }})" style="cursor:pointer;">
                        <td>{{ $report->case_number ?? 'N/A' }}</td>
                        <td>{{ $report->full_name ?? 'Anonymous' }}</td>
                        <td>{{ $report->province->province_name ?? 'N/A' }}</td>
                        <td>{{ $report->district->district_name ?? 'N/A' }}</td>
                        <td>{{ $report->school->school_name ?? 'N/A' }}</td>
                        <td>{{ $report->grade ?? 'N/A' }}</td>
                      <td>{{ $report->abuseType->type_name ?? 'N/A' }}</td>
                        <td style="text-align: center;">
                            <span class="status-badge status-{{ str_replace('_', '-', $report->status) }}">
                                {{ str_replace(' ', '-', ucwords(str_replace(['-', '_'], ' ', $report->status))) }}
                            </span>
                        </td>
                        <td>{{ $report->is_anonymous ? 'YES' : 'NO' }}</td>
                        <td>{{ $report->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align:center; padding:1rem;">
                            No reports found for this filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        {{-- Pagination — preserve all active filters across pages --}}
        <div class="pagination">
            @if ($reports->onFirstPage())
                <span class="page-link" aria-disabled="true">←</span>
            @else
                <a href="{{ $reports->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}" class="page-link" rel="prev">←</a>
            @endif

            @foreach ($reports->getUrlRange(1, $reports->lastPage()) as $page => $url)
                @if ($page == $reports->currentPage())
                    <span class="page-link" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $url }}&{{ http_build_query(request()->except('page')) }}" class="page-link">{{ $page }}</a>
                @endif
            @endforeach

            @if ($reports->hasMorePages())
                <a href="{{ $reports->nextPageUrl() }}&{{ http_build_query(request()->except('page')) }}" class="page-link" rel="next">→</a>
            @else
                <span class="page-link" aria-disabled="true">→</span>
            @endif
        </div>

    </main>
</div>{{-- end .main-panel --}}

<script src="{{ asset('js/mobile-select-modal.js') }}"></script>
<script src="https://kit.fontawesome.com/2c36e9b7b9.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/dist/choices.min.js"></script>
<script>
// ── PDF Export ───────────────────────────────────────────────────
function exportPDF() {
        const element = document.getElementById('main-content');
        if (!element) {
            alert("Main content not found! Add id='main-content' to your <main> tag.");
            return;
        }

        html2pdf().from(element).set({
            margin: 10,
            filename: 'provincial-admin-reports.pdf',
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a3', orientation: 'landscape' }
        }).save();
    }

// ── Report detail modal ──────────────────────────────────────────
function openReportModal(reportId) {
    fetch(`/provincial-admin/reports/${reportId}`, {
        headers: { 'Accept': 'application/json' }
    })
    .then(r => { if (!r.ok) throw new Error('Network error'); return r.json(); })
    .then(report => {
        // Privacy check
        const isAnon = report.is_anonymous || report.full_name === 'Anonymous';
        
        // Header
        document.getElementById('modalCaseNumber').textContent = 'Case-' + (report.case_number || 'N/A');
        
        // Grid Data
        document.getElementById('modalFullName').textContent = isAnon ? 'Anonymous' : (report.full_name || 'N/A');
        document.getElementById('modalEmail').textContent    = isAnon ? 'Hidden (Anonymous)' : (report.reporter_email || 'N/A');
        document.getElementById('modalPhone').textContent    = isAnon ? 'Hidden (Anonymous)' : (report.phone_number || 'N/A');
        
        document.getElementById('modalType').textContent     = report.abuseType || 'N/A';
        document.getElementById('modalSubtype').textContent  = report.subtype || 'N/A';
        document.getElementById('modalReportId').textContent = 'Case-' + (report.case_number || 'N/A');
        document.getElementById('modalSchool').textContent   = report.school || 'N/A';
        document.getElementById('modalGrade').textContent    = report.grade || 'N/A';
        
        // Format status to Title Case (e.g., "Awaiting Resolution")
        const statusText = report.status ? report.status.replace(/-/g, ' ') : 'N/A';
        document.getElementById('modalStatus').textContent = statusText.replace(/\w\S*/g, (txt) => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase());
        
        // Latest Reason
        document.getElementById('modalReason').textContent = report.latest_status_reason 
            ? report.latest_status_reason 
            : 'No Status history recorded';

        // Description
        document.getElementById('modalDescription').textContent = report.description || '';

        // Attachments
        const attachmentSpan = document.getElementById('modalAttachments');
        attachmentSpan.replaceChildren();

        if (report.attachments && report.attachments.length > 0) {
            report.attachments.forEach((filePath, i) => {
                const ext       = filePath.split('.').pop().toLowerCase();
                const publicUrl = (report.attachment_urls || [])[i];   // authenticated handler URL
                if (!publicUrl) return;
                let elem;

                if (['jpg','jpeg','png','gif','bmp','webp','svg'].includes(ext)) {
                    elem = document.createElement('img');
                    elem.src = publicUrl;
                    elem.alt = 'Attachment';
                    elem.onclick = () => openLightbox(publicUrl);
                } else if (['mp4','mov','avi','wmv'].includes(ext)) {
                    elem = document.createElement('video');
                    elem.controls = true;
                    const src = document.createElement('source');
                    src.src  = publicUrl;
                    src.type = 'video/' + (ext === 'mov' ? 'mp4' : ext);
                    elem.appendChild(src);
                } else {
                    const icon = ext === 'pdf' ? '📄' : '📎';
                    elem = document.createElement('a');
                    elem.href = publicUrl;
                    elem.target = '_blank';
                    elem.rel = 'noopener noreferrer';
                    elem.download = filePath.split('/').pop();
                    elem.textContent = icon + ' ' + elem.download;
                }
                attachmentSpan.appendChild(elem);
            });
        } else {
            const empty = document.createElement('span');
            empty.className = 'text-empty';
            empty.textContent = 'No attachments uploaded';
            attachmentSpan.appendChild(empty);
        }

        const modal = document.getElementById('reportModal');
        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
    })
    .catch(() => alert('Failed to load report details.'));
}
function openLightbox(src) {
    const overlay = document.createElement('div');
    Object.assign(overlay.style, {
        position: 'fixed', inset: '0',
        background: 'rgba(0,0,0,.88)',
        display: 'flex', alignItems: 'center', justifyContent: 'center',
        zIndex: '99999', cursor: 'zoom-out'
    });

    const img = document.createElement('img');
    img.src = src;
    Object.assign(img.style, {
        maxWidth: '90vw', maxHeight: '90vh',
        borderRadius: '10px',
        boxShadow: '0 8px 40px rgba(0,0,0,.6)'
    });

    // Close on overlay click or Escape
    overlay.onclick = () => overlay.remove();
    overlay.addEventListener('keydown', e => {
        if (e.key === 'Escape') overlay.remove();
    });

    overlay.appendChild(img);
    document.body.appendChild(overlay);
    overlay.focus();
}

function closeReportModal() {
    const modal = document.getElementById('reportModal');
    modal.style.display = 'none';
    modal.setAttribute('aria-hidden', 'true');
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeReportModal(); });

// ── DOMContentLoaded ─────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('filterForm');
    let filterDebounce = null;

    if (filterForm) {
        filterForm.querySelectorAll('input[name="search"], input[name="full_name"]').forEach(function (input) {
            input.addEventListener('input', function () {
                clearTimeout(filterDebounce);
                filterDebounce = setTimeout(function () { filterForm.submit(); }, 500);
            });
        });

        const refreshBtn = document.getElementById('refreshBtn');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', function () {
                // Hard redirect with no params — cleanest way to guarantee all filters clear
                window.location.href = '{{ url('/provincial-admin/reports') }}';
            });
        }
    }


    const anonSelect = document.querySelector('select[name="is_anonymous"]');
    const nameInput  = document.querySelector('input[name="full_name"]');

    function syncAnonNameState() {
        if (!anonSelect || !nameInput) return;
        const isAnon = anonSelect.value === '1';
        nameInput.disabled  = isAnon;
        nameInput.title     = isAnon ? 'Not available for anonymous reports' : '';
        nameInput.style.opacity    = isAnon ? '0.4' : '1';
        nameInput.style.cursor     = isAnon ? 'not-allowed' : '';
        nameInput.style.background = isAnon ? '#f3f4f6' : 'white';
        if (isAnon) nameInput.value = '';
    }

    if (anonSelect) anonSelect.addEventListener('change', syncAnonNameState);
    syncAnonNameState();

    // ── Subtype filtered by report type ──────────────────────────
    const typeSelect    = document.querySelector('select[name="type_id"]');
    const subtypeSelect = document.getElementById('subtypeSelect');

    (function initSchoolAutocomplete() {
        const API_ENDPOINT = '/api/schools';
        const LS_KEY = 'schools_cache_v3';
        const CACHE_TTL = 24 * 60 * 60 * 1000;

        const input = document.getElementById('schoolSearch');
        const dropdown = document.getElementById('schoolDropdown');
        const hiddenId = document.getElementById('schoolId');
        if (!input || !dropdown || !hiddenId) return;

        let schools = [];
        let items = [];
        let focused = -1;
        let timer = null;

        function loadCache() {
            try {
                const raw = localStorage.getItem(LS_KEY);
                if (!raw) return false;
                const parsed = JSON.parse(raw);
                if (!parsed.data || !parsed.timestamp) return false;
                if (Date.now() - parsed.timestamp > CACHE_TTL) return false;
                if (parsed.data.length > 0 && parsed.data[0].name) {
                    schools = parsed.data;
                    return true;
                }
                return false;
            } catch (e) {
                return false;
            }
        }

        function saveCache(data) {
            try {
                localStorage.setItem(LS_KEY, JSON.stringify({ data, timestamp: Date.now() }));
            } catch (e) {}
        }

        async function loadFromDatabase() {
            try {
                const res = await fetch(API_ENDPOINT, { cache: 'no-store' });
                if (!res.ok) throw new Error('HTTP ' + res.status);
                const json = await res.json();
                if (Array.isArray(json)) {
                    schools = json;
                    saveCache(schools);
                }
            } catch (e) {}
        }

        (async function init() {
            if (!loadCache()) {
                await loadFromDatabase();
            }
            fetch(API_ENDPOINT).then(r => r.json()).then(d => {
                if (Array.isArray(d)) {
                    schools = d;
                    saveCache(schools);
                }
            }).catch(() => {});
        })();

        function searchPrefix(q, limit = 20) {
            if (!q) return [];
            const low = q.toLowerCase();
            const out = [];
            for (let i = 0; i < schools.length && out.length < limit; i++) {
                const s = schools[i];
                if (!s || !s.name) continue;
                if (s.name.toLowerCase().startsWith(low)) {
                    out.push(s);
                }
            }
            return out;
        }

        function clearSuggestions() {
            dropdown.innerHTML = '';
            dropdown.style.display = 'none';
            items = [];
            focused = -1;
        }

        function selectItem(index) {
            const it = items[index];
            if (!it) return;
            input.value = it.name;
            hiddenId.value = it.id ?? '';
            clearSuggestions();
            filterForm.submit();
        }

        function render(arr) {
            dropdown.innerHTML = '';
            items = arr || [];
            focused = -1;
            if (!items.length) {
                dropdown.style.display = 'none';
                return;
            }
            for (let i = 0; i < items.length; i++) {
                const it = items[i];
                const el = document.createElement('div');
                el.textContent = it.name + (it.province ? (' (' + it.province + ')') : '');
                el.dataset.index = i;
                el.style.padding = '8px';
                el.style.cursor = 'pointer';
                el.addEventListener('pointerdown', function(e) {
                    e.preventDefault();
                    selectItem(parseInt(this.dataset.index, 10));
                });
                el.addEventListener('mouseenter', function() {
                    focused = parseInt(this.dataset.index, 10);
                    updateFocus();
                });
                dropdown.appendChild(el);
            }
            dropdown.style.display = 'block';
        }

        function updateFocus() {
            const children = dropdown.children;
            for (let i = 0; i < children.length; i++) {
                children[i].style.background = '';
                children[i].style.color = '';
                if (i === focused) {
                    children[i].style.background = '#c6d933';
                    children[i].style.color = '#000';
                }
            }
            if (focused >= 0 && children[focused]) {
                children[focused].scrollIntoView({ block: 'nearest' });
            }
        }

        input.addEventListener('input', function() {
            hiddenId.value = '';
            clearTimeout(timer);
            const q = this.value.trim();
            if (q.length < 1) {
                clearSuggestions();
                return;
            }
            timer = setTimeout(() => {
                render(searchPrefix(q, 20));
            }, 120);
        });

        input.addEventListener('keydown', function(e) {
            if (dropdown.style.display === 'none') return;
            const count = dropdown.children.length;
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                focused = Math.min(count - 1, Math.max(0, focused + 1));
                updateFocus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                focused = Math.max(0, focused - 1);
                updateFocus();
            } else if (e.key === 'Enter') {
                if (focused >= 0) {
                    e.preventDefault();
                    selectItem(focused);
                } else {
                    clearSuggestions();
                }
            } else if (e.key === 'Escape') {
                clearSuggestions();
            }
        });

        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                clearSuggestions();
            }
        });
    })();

function filterSubtypes() {
                const selectedType = typeSelect.value;

                const options = Array.from(subtypeSelect.options).filter(opt => opt.value !== '');
                const placeholder = subtypeSelect.options[0]; // "All Subtypes"

                // Separate "Other" and non-Other options
                const seenOtherTypes = new Set();
                const regular = [];
                const others  = [];

                options.forEach(function(opt) {
                    const isOther = opt.text.trim().toLowerCase() === 'other';
                    const optType = opt.getAttribute('data-type');

                    if (!selectedType) {
                        // No type selected: show all non-Others, show only one Other total
                        if (isOther) {
                            if (!seenOtherTypes.has('global')) {
                                seenOtherTypes.add('global');
                                others.push(opt);
                            }
                        } else {
                            regular.push(opt);
                        }
                    } else {
                        // Type selected: show only matching subtypes
                        if (String(optType) === String(selectedType)) {
                            if (isOther) {
                                others.push(opt);
                            } else {
                                regular.push(opt);
                            }
                        }
                    }
                });

                // Rebuild the select: placeholder → regular options → Others at bottom
                subtypeSelect.innerHTML = '';
                subtypeSelect.appendChild(placeholder);

                regular.forEach(opt => {
                    opt.style.display = '';
                    subtypeSelect.appendChild(opt);
                });

                others.forEach(opt => {
                    opt.style.display = '';
                    subtypeSelect.appendChild(opt);
                });
}

    filterSubtypes();
});

</script>

<x-provincial-admin-sidebar-script />

</body>
</html>
