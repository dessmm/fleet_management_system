<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ══════════════════════════════════════════════════════════
           GLOBAL DARK MODE OVERRIDES
           ══════════════════════════════════════════════════════════ */

        /* ── Base ────────────────────────────────────────────────── */
        html.dark body                          { background: #0f172a; color: #e2e8f0; }
        html.dark *                             { border-color: #334155; }

        /* ── Backgrounds ─────────────────────────────────────────── */
        html.dark .bg-white                     { background: #1e293b !important; }
        html.dark .bg-gray-50                   { background: #0f172a !important; }
        html.dark .bg-gray-100                  { background: #1e293b !important; }
        html.dark .bg-gray-200                  { background: #334155 !important; }
        html.dark .bg-slate-50                  { background: #0f172a !important; }
        html.dark .bg-slate-100                 { background: #1e293b !important; }

        /* ── Gradient backgrounds ────────────────────────────────── */
        html.dark .bg-gradient-to-br.from-slate-50  { --tw-gradient-from: #0f172a; }
        html.dark .bg-gradient-to-br.via-blue-50    { --tw-gradient-via: #0f172a; }
        html.dark .bg-gradient-to-br.via-indigo-50  { --tw-gradient-via: #0f172a; }
        html.dark .bg-gradient-to-br.via-purple-50  { --tw-gradient-via: #0f172a; }
        html.dark .bg-gradient-to-br.via-red-50     { --tw-gradient-via: #0f172a; }
        html.dark .bg-gradient-to-br.via-orange-50  { --tw-gradient-via: #0f172a; }
        html.dark .bg-gradient-to-br.via-amber-50   { --tw-gradient-via: #0f172a; }
        html.dark .bg-gradient-to-br.to-slate-100   { --tw-gradient-to: #1e293b; }
        html.dark .min-h-screen                 { background: #0f172a; }

        /* ── Text ────────────────────────────────────────────────── */
        html.dark .text-gray-900               { color: #f1f5f9 !important; }
        html.dark .text-gray-800               { color: #e2e8f0 !important; }
        html.dark .text-gray-700               { color: #cbd5e1 !important; }
        html.dark .text-gray-600               { color: #94a3b8 !important; }
        html.dark .text-gray-500               { color: #64748b !important; }
        html.dark .text-gray-400               { color: #475569 !important; }

        /* ── Borders ─────────────────────────────────────────────── */
        html.dark .border-gray-100             { border-color: #334155 !important; }
        html.dark .border-gray-200             { border-color: #334155 !important; }
        html.dark .border-gray-300             { border-color: #475569 !important; }
        html.dark .divide-gray-50 > *          { border-color: #334155 !important; }
        html.dark .divide-gray-100 > *         { border-color: #334155 !important; }
        html.dark .divide-y > *                { border-color: #334155 !important; }

        /* ── Cards & Panels ──────────────────────────────────────── */
        html.dark .rounded-2xl.bg-white        { background: #1e293b !important; }
        html.dark .rounded-xl.bg-white         { background: #1e293b !important; }
        html.dark .shadow-sm                   { box-shadow: 0 1px 3px rgba(0,0,0,.4) !important; }

        /* ── Inputs & Selects ────────────────────────────────────── */
        html.dark input,
        html.dark select,
        html.dark textarea                      { background: #0f172a !important; color: #e2e8f0 !important; border-color: #334155 !important; }
        html.dark input::placeholder,
        html.dark textarea::placeholder         { color: #475569 !important; }
        html.dark input:focus,
        html.dark select:focus,
        html.dark textarea:focus                { background: #1e293b !important; }

        /* ── Tables ──────────────────────────────────────────────── */
        html.dark table                         { background: #1e293b; }
        html.dark thead tr                      { background: #0f172a !important; }
        html.dark tbody tr:hover                { background: #334155 !important; }
        html.dark .bg-gray-50.border-b          { background: #0f172a !important; }
        html.dark th                            { color: #94a3b8 !important; }
        html.dark td                            { color: #cbd5e1; }

        /* ── Buttons ─────────────────────────────────────────────── */
        html.dark .hover\:bg-gray-50:hover      { background: #334155 !important; }
        html.dark .hover\:bg-gray-100:hover     { background: #334155 !important; }

        /* ── Stat / Side cards ───────────────────────────────────── */
        html.dark .stat-card                    { background: #1e293b !important; border-color: #334155 !important; }
        html.dark .side-card                    { background: #1e293b !important; border-color: #334155 !important; }

        /* ── Info cells ──────────────────────────────────────────── */
        html.dark .info-cell                    { background: #1e293b; }
        html.dark .info-cell:hover              { background: #334155 !important; }

        /* ── Table row hovers ────────────────────────────────────── */
        html.dark .vehicle-row:hover            { background: #334155 !important; }
        html.dark .driver-row:hover             { background: #334155 !important; }
        html.dark .trip-row:hover               { background: #334155 !important; }
        html.dark .maintenance-row:hover        { background: #334155 !important; }
        html.dark .fuel-row:hover               { background: #334155 !important; }
        html.dark .traffic-row:hover            { background: #334155 !important; }

        /* ── Colored badge backgrounds ───────────────────────────── */
        html.dark .bg-blue-100                  { background: #1e3a5f !important; }
        html.dark .bg-indigo-100                { background: #1e1b4b !important; }
        html.dark .bg-violet-100                { background: #2e1065 !important; }
        html.dark .bg-purple-100                { background: #2e1065 !important; }
        html.dark .bg-emerald-100               { background: #064e3b !important; }
        html.dark .bg-red-100                   { background: #450a0a !important; }
        html.dark .bg-amber-100                 { background: #431407 !important; }
        html.dark .bg-orange-100                { background: #431407 !important; }
        html.dark .bg-yellow-100                { background: #422006 !important; }

        /* ── Colored badge text ──────────────────────────────────── */
        html.dark .text-blue-700                { color: #93c5fd !important; }
        html.dark .text-indigo-700              { color: #a5b4fc !important; }
        html.dark .text-violet-700              { color: #c4b5fd !important; }
        html.dark .text-purple-700              { color: #c4b5fd !important; }
        html.dark .text-emerald-700             { color: #6ee7b7 !important; }
        html.dark .text-red-700                 { color: #fca5a5 !important; }
        html.dark .text-amber-700               { color: #fcd34d !important; }
        html.dark .text-orange-700              { color: #fdba74 !important; }

        /* ── Light tinted section backgrounds ───────────────────── */
        html.dark .bg-blue-50                   { background: #172554 !important; }
        html.dark .bg-indigo-50                 { background: #1e1b4b !important; }
        html.dark .bg-violet-50                 { background: #2e1065 !important; }
        html.dark .bg-purple-50                 { background: #2e1065 !important; }
        html.dark .bg-emerald-50                { background: #022c22 !important; }
        html.dark .bg-red-50                    { background: #450a0a !important; }
        html.dark .bg-amber-50                  { background: #431407 !important; }
        html.dark .bg-orange-50                 { background: #431407 !important; }

        /* ── Gradient hero banners ───────────────────────────────── */
        html.dark .bg-gradient-to-r.from-blue-600   { opacity: 0.9; }
        html.dark .bg-gradient-to-r.from-indigo-600 { opacity: 0.9; }
        html.dark .bg-gradient-to-r.from-purple-600 { opacity: 0.9; }
        html.dark .bg-gradient-to-r.from-red-600    { opacity: 0.9; }
        html.dark .bg-gradient-to-r.from-orange-600 { opacity: 0.9; }
        html.dark .bg-gradient-to-r.from-amber-500  { opacity: 0.9; }

        /* ── Modals ──────────────────────────────────────────────── */
        html.dark #delete-modal .bg-white,
        html.dark #del-modal .bg-white,
        html.dark #route-modal .bg-white,
        html.dark #jsonModal .bg-white          { background: #1e293b !important; }
        html.dark #delete-modal .text-gray-900,
        html.dark #del-modal .text-gray-900,
        html.dark #route-modal .text-gray-900   { color: #f1f5f9 !important; }
        html.dark #delete-modal .text-gray-500,
        html.dark #del-modal .text-gray-500,
        html.dark #route-modal .text-gray-500   { color: #94a3b8 !important; }

        /* ── Search inputs ───────────────────────────────────────── */
        html.dark #search-input                 { background: #0f172a !important; color: #e2e8f0 !important; border-color: #334155 !important; }
        html.dark #search-input:focus           { background: #1e293b !important; box-shadow: 0 0 0 3px rgba(99,102,241,.2) !important; }

        /* ── Notification panel ──────────────────────────────────── */
        html.dark #notif-panel                  { background: #1e293b !important; border-color: #334155 !important; }
        html.dark .notif-item:hover             { background: #334155 !important; }

        /* ── Navbar ──────────────────────────────────────────────── */
        html.dark nav                           { background: #1e293b !important; border-color: #334155 !important; }
        html.dark .nav-link.active              { background: #1e3a5f !important; color: #93c5fd !important; }
        html.dark .nav-link:hover               { background: #334155 !important; }
        html.dark #mobile-menu                  { background: #1e293b !important; border-color: #334155 !important; }
        html.dark #mobile-menu a                { color: #cbd5e1; }
        html.dark #mobile-menu a:hover          { background: #334155 !important; color: #f1f5f9 !important; }

        /* ── Footer ──────────────────────────────────────────────── */
        html.dark footer                        { background: #020617 !important; border-color: #1e293b !important; }

        /* ── Toast ───────────────────────────────────────────────── */
        html.dark .toast                        { background: #1e293b !important; border-color: #334155 !important; }
        html.dark .toast-title                  { color: #f1f5f9 !important; }
        html.dark .toast-msg                    { color: #94a3b8 !important; }
        html.dark .toast-close                  { color: #64748b !important; }
        html.dark .toast-close:hover            { color: #cbd5e1 !important; }

        /* ── Leaflet map ─────────────────────────────────────────── */
        html.dark .leaflet-container            { background: #1e293b; }
        html.dark .leaflet-popup-content-wrapper { background: #1e293b !important; color: #e2e8f0 !important; border: 1px solid #334155; }
        html.dark .leaflet-popup-tip            { background: #1e293b !important; }

        /* ── Custom scrollbar ────────────────────────────────────── */
        html.dark ::-webkit-scrollbar           { width: 6px; height: 6px; }
        html.dark ::-webkit-scrollbar-track     { background: #0f172a; }
        html.dark ::-webkit-scrollbar-thumb     { background: #334155; border-radius: 3px; }
        html.dark ::-webkit-scrollbar-thumb:hover { background: #475569; }

        /* ══════════════════════════════════════════════════════════
           TOAST NOTIFICATIONS
           ══════════════════════════════════════════════════════════ */
        #toast-container { position: fixed; top: 1.25rem; right: 1.25rem; z-index: 9999; display: flex; flex-direction: column; gap: .625rem; pointer-events: none; }
        .toast { display: flex; align-items: flex-start; gap: .75rem; padding: .875rem 1rem; background: #fff; border-radius: .875rem; box-shadow: 0 8px 32px rgba(0,0,0,.12), 0 2px 8px rgba(0,0,0,.08); border: 1px solid #e5e7eb; min-width: 280px; max-width: 380px; pointer-events: all; transform: translateX(120%); opacity: 0; transition: transform .35s cubic-bezier(.34,1.56,.64,1), opacity .35s ease; }
        .toast.show { transform: translateX(0); opacity: 1; }
        .toast.hide { transform: translateX(120%); opacity: 0; }
        .toast-icon { width: 2rem; height: 2rem; border-radius: .5rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .toast-title { font-size: .8125rem; font-weight: 700; color: #111827; line-height: 1.2; }
        .toast-msg { font-size: .75rem; color: #6b7280; margin-top: .125rem; line-height: 1.4; }
        .toast-close { margin-left: auto; flex-shrink: 0; background: none; border: none; color: #9ca3af; cursor: pointer; font-size: 1rem; line-height: 1; padding: .125rem; transition: color .15s; }
        .toast-close:hover { color: #374151; }
        .toast-progress { position: absolute; bottom: 0; left: 0; height: 3px; border-radius: 0 0 .875rem .875rem; animation: toast-progress linear forwards; }
        .toast { position: relative; overflow: hidden; }
        @keyframes toast-progress { from { width: 100%; } to { width: 0%; } }

        /* ══════════════════════════════════════════════════════════
           BELL DROPDOWN
           ══════════════════════════════════════════════════════════ */
        #notif-panel { transform-origin: top right; transition: transform .2s cubic-bezier(.34,1.56,.64,1), opacity .2s ease; }
        #notif-panel.hidden { transform: scale(.95); opacity: 0; pointer-events: none; }
        #notif-panel:not(.hidden) { transform: scale(1); opacity: 1; }
        .notif-item { transition: background .15s; }
        .notif-item:hover { background: #f9fafb; }

        /* ══════════════════════════════════════════════════════════
           NAVBAR ACTIVE LINK
           ══════════════════════════════════════════════════════════ */
        .nav-link.active { background: #eff6ff; color: #2563eb; }

        /* ══════════════════════════════════════════════════════════
           MOBILE MENU ANIMATION
           ══════════════════════════════════════════════════════════ */
        #mobile-menu { transition: max-height .3s ease, opacity .3s ease; max-height: 0; opacity: 0; overflow: hidden; }
        #mobile-menu.open { max-height: 500px; opacity: 1; }

        /* ── Remove colored shadows in dark mode ─────────────────── */
html.dark .shadow-blue-200    { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
html.dark .shadow-indigo-200  { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
html.dark .shadow-violet-200  { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
html.dark .shadow-purple-200  { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
html.dark .shadow-red-200     { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
html.dark .shadow-orange-200  { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
html.dark .shadow-amber-200   { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
html.dark .shadow-emerald-200 { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }
html.dark .shadow-green-200   { --tw-shadow-color: transparent !important; box-shadow: 0 4px 12px rgba(0,0,0,.4) !important; }

/* ══════════════════════════════════════════════════════════════════════
   COMPREHENSIVE SECTION DARK MODE OVERRIDES
   Palette extracted from scanned files:
     Base page       #0f172a   Elevated surface  #1e293b
     Hover surface   #253347   Border            #334155
     Primary blue    #2563eb   Blue deep         #1d4ed8
     Blue text light #93c5fd   Blue active bg    #1e3a5f
     Indigo/drivers  #6366f1   Purple/trips      #7c3aed
     Orange/fuel     #ea580c   Red/maintenance   #dc2626
     Green active    #4ade80   Green border      rgba(34,197,94,.3)
     Yellow pending  #facc15   Red badge         #f87171
     Text primary    #e2e8f0   Text muted        #94a3b8
     Text subtle     #475569
   ══════════════════════════════════════════════════════════════════════ */

/* === GLOBAL PAGE BACKGROUNDS === */
html.dark .vh-page,
html.dark .dr-page,
html.dark .tr-page,
html.dark .mr-page,
html.dark .fr-page  { background: #0f172a !important; background-image: none !important; }

/* === BREADCRUMBS === */
html.dark .vh-breadcrumb,
html.dark .dr-breadcrumb,
html.dark .tr-breadcrumb,
html.dark .mr-breadcrumb,
html.dark .fr-breadcrumb { color: #475569; }
html.dark .vh-breadcrumb a,
html.dark .dr-breadcrumb a,
html.dark .tr-breadcrumb a,
html.dark .mr-breadcrumb a,
html.dark .fr-breadcrumb a { color: #475569; }
html.dark .vh-breadcrumb a:hover,
html.dark .dr-breadcrumb a:hover,
html.dark .tr-breadcrumb a:hover,
html.dark .mr-breadcrumb a:hover,
html.dark .fr-breadcrumb a:hover { color: #e2e8f0; }

/* === PAGE TITLES & SUBTITLES === */
html.dark .vh-title, html.dark .dr-title,
html.dark .tr-title, html.dark .mr-title, html.dark .fr-title { color: #f1f5f9; }
html.dark .vh-subtitle, html.dark .dr-subtitle,
html.dark .tr-subtitle, html.dark .mr-subtitle, html.dark .fr-subtitle { color: #64748b; }

/* === STAT CARDS === */
html.dark .vh-stat, html.dark .dr-stat,
html.dark .tr-stat, html.dark .mr-stat, html.dark .fr-stat {
    background: #1e293b !important; border-color: #334155 !important;
    box-shadow: 0 1px 3px rgba(0,0,0,.3) !important;
}
html.dark .vh-stat:hover, html.dark .dr-stat:hover,
html.dark .tr-stat:hover, html.dark .mr-stat:hover, html.dark .fr-stat:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,.4) !important;
}
html.dark .vh-stat-num, html.dark .dr-stat-num,
html.dark .tr-stat-num, html.dark .mr-stat-num, html.dark .fr-stat-num { color: #f1f5f9; }
html.dark .vh-stat-lbl, html.dark .dr-stat-lbl,
html.dark .tr-stat-lbl, html.dark .mr-stat-lbl, html.dark .fr-stat-lbl { color: #64748b; }
/* Stat icon tinted backgrounds in dark */
html.dark .vh-stat .vh-stat-icon,
html.dark .dr-stat .dr-stat-icon,
html.dark .tr-stat .tr-stat-icon,
html.dark .mr-stat .mr-stat-icon,
html.dark .fr-stat .fr-stat-icon { background: #253347 !important; }

/* === MAIN TABLE CARDS === */
html.dark .vh-card, html.dark .dr-card,
html.dark .tr-card, html.dark .mr-card, html.dark .fr-card {
    background: #1e293b !important; border-color: #334155 !important;
    box-shadow: 0 2px 12px rgba(0,0,0,.4) !important;
}
html.dark .vh-card-header, html.dark .dr-card-header,
html.dark .tr-card-header, html.dark .mr-card-header, html.dark .fr-card-header {
    border-bottom-color: #334155 !important; background: #1e293b;
}
html.dark .vh-card-title, html.dark .dr-card-title,
html.dark .tr-card-title, html.dark .mr-card-title, html.dark .fr-card-title { color: #cbd5e1; }

/* Count badges in card headers */
html.dark .vh-count  { background: #1e3a5f !important; border-color: rgba(37,99,235,.4) !important; color: #93c5fd !important; }
html.dark .dr-count  { background: #1e1b4b !important; border-color: rgba(99,102,241,.4) !important; color: #a5b4fc !important; }
html.dark .tr-count  { background: #2e1065 !important; border-color: rgba(124,58,237,.4) !important; color: #c4b5fd !important; }
html.dark .mr-count  { background: #450a0a !important; border-color: rgba(220,38,38,.4) !important; color: #fca5a5 !important; }
html.dark .fr-count  { background: #431407 !important; border-color: rgba(234,88,12,.4) !important; color: #fdba74 !important; }

/* === SEARCH INPUTS === */
html.dark .vh-search, html.dark .dr-search,
html.dark .tr-search, html.dark .mr-search, html.dark .fr-search {
    background: #0f172a !important; border-color: #334155 !important;
    color: #e2e8f0 !important;
}
html.dark .vh-search::placeholder, html.dark .dr-search::placeholder,
html.dark .tr-search::placeholder, html.dark .mr-search::placeholder,
html.dark .fr-search::placeholder { color: #475569 !important; }
html.dark .vh-search:focus, html.dark .dr-search:focus,
html.dark .tr-search:focus, html.dark .mr-search:focus, html.dark .fr-search:focus {
    background: #1e293b !important; border-color: #2563eb !important;
    box-shadow: 0 0 0 3px rgba(37,99,235,.2) !important;
}

/* === TABLE HEADERS === */
html.dark .vh-table thead tr,
html.dark .dr-table thead tr,
html.dark .tr-table thead tr,
html.dark .mr-table thead tr,
html.dark .fr-table thead tr { background: #0f172a !important; border-bottom-color: #334155 !important; }
html.dark .vh-table th,
html.dark .dr-table th,
html.dark .tr-table th,
html.dark .mr-table th,
html.dark .fr-table th { color: #64748b !important; }
/* Tailwind thead rows */
html.dark tr.bg-gray-50 { background: #0f172a !important; }

/* === TABLE BODY ROWS === */
html.dark .vh-table tbody tr,
html.dark .dr-table tbody tr,
html.dark .tr-table tbody tr,
html.dark .mr-table tbody tr,
html.dark .fr-table tbody tr { border-bottom-color: #253347 !important; }

/* HOVER ROWS — explicit text color to prevent invisibility */
html.dark .vh-table tbody tr:hover,
html.dark .vehicle-row:hover {
    background: rgba(37,99,235,.12) !important;
    border-left: 3px solid #2563eb;
}
html.dark .vh-table tbody tr:hover td,
html.dark .vehicle-row:hover td,
html.dark .vh-table tbody tr:hover p,
html.dark .vehicle-row:hover p { color: #e2e8f0 !important; }

html.dark .dr-table tbody tr:hover,
html.dark .driver-row:hover { background: rgba(99,102,241,.12) !important; }
html.dark .dr-table tbody tr:hover td,
html.dark .driver-row:hover td,
html.dark .dr-table tbody tr:hover span,
html.dark .driver-row:hover span { color: #e2e8f0 !important; }

html.dark .tr-table tbody tr:hover { background: rgba(124,58,237,.12) !important; }
html.dark .tr-table tbody tr:hover td { color: #e2e8f0 !important; }

html.dark .mr-table tbody tr:hover,
html.dark .maintenance-row:hover { background: rgba(220,38,38,.08) !important; }
html.dark .mr-table tbody tr:hover td { color: #e2e8f0 !important; }

html.dark .fr-table tbody tr:hover,
html.dark .fuel-row:hover { background: rgba(234,88,12,.08) !important; }
html.dark .fr-table tbody tr:hover td { color: #e2e8f0 !important; }

/* === TABLE CELL TEXT === */
html.dark .vh-table td, html.dark .dr-table td,
html.dark .tr-table td, html.dark .mr-table td, html.dark .fr-table td { color: #e2e8f0; }

/* === TABLE FOOTERS === */
html.dark .vh-footer, html.dark .dr-footer,
html.dark .tr-footer, html.dark .mr-footer, html.dark .fr-footer {
    background: #0f172a !important; border-top-color: #334155 !important;
}
html.dark .vh-footer-text, html.dark .dr-footer-text,
html.dark .tr-footer-text, html.dark .mr-footer-text, html.dark .fr-footer-text { color: #475569; }

/* === STATUS BADGES — all sections === */
/* Active / Completed / Online */
html.dark .bg-emerald-50  { background: rgba(34,197,94,.13) !important; }
html.dark .text-emerald-700 { color: #4ade80 !important; }
html.dark .border-emerald-200 { border-color: rgba(34,197,94,.3) !important; }
html.dark .tr-status-completed {
    background: rgba(34,197,94,.13) !important; border-color: rgba(34,197,94,.3) !important; color: #4ade80 !important;
}
html.dark .mr-status-done {
    background: rgba(34,197,94,.13) !important; border-color: rgba(34,197,94,.3) !important; color: #4ade80 !important;
}
/* Inactive / Cancelled */
html.dark .bg-red-50   { background: rgba(239,68,68,.13) !important; }
html.dark .text-red-600, html.dark .text-red-700 { color: #f87171 !important; }
html.dark .border-red-200 { border-color: rgba(239,68,68,.3) !important; }
/* Pending / In Progress (yellow) */
html.dark .bg-amber-50 { background: rgba(234,179,8,.13) !important; }
html.dark .text-amber-700 { color: #facc15 !important; }
html.dark .border-amber-200 { border-color: rgba(234,179,8,.3) !important; }
html.dark .tr-status-pending {
    background: rgba(234,179,8,.13) !important; border-color: rgba(234,179,8,.3) !important; color: #facc15 !important;
}
/* In Progress (blue) */
html.dark .tr-status-progress {
    background: rgba(37,99,235,.15) !important; border-color: rgba(37,99,235,.35) !important; color: #93c5fd !important;
}
/* Maintenance In Progress (orange) */
html.dark .mr-status-active {
    background: rgba(249,115,22,.13) !important; border-color: rgba(249,115,22,.3) !important; color: #fb923c !important;
}
/* Purple violet badges */
html.dark .bg-violet-50  { background: rgba(139,92,246,.13) !important; }
html.dark .text-violet-700 { color: #a78bfa !important; }
html.dark .border-violet-100 { border-color: rgba(139,92,246,.25) !important; }

/* === VEHICLES — section-specific === */
/* License plate dark chip (already dark bg, lighten text) */
html.dark .vh-table td span.bg-gray-900,
html.dark .dr-table td span.bg-gray-900,
html.dark .tr-plate { background: #334155 !important; color: #f1f5f9 !important; }
/* Capacity values */
html.dark .vh-table td .text-gray-700 { color: #93c5fd !important; }
/* Type badge (violet) already covered above */

/* === DRIVERS — section-specific === */
/* Driver name in table */
html.dark .dr-table td p.text-gray-900 { color: #e2e8f0 !important; }
html.dark .dr-table td p.text-gray-400 { color: #475569 !important; }
html.dark .dr-table td span.text-gray-700 { color: #cbd5e1 !important; }
/* License expiry badges: expired = red, expiring soon = yellow */
html.dark .bg-red-50.border-red-200   { background: rgba(239,68,68,.13) !important; color: #f87171 !important; }
html.dark .bg-amber-50.border-amber-200 { background: rgba(234,179,8,.13) !important; color: #facc15 !important; }
html.dark .bg-gray-50  { background: #1e293b !important; }
html.dark .text-gray-600 { color: #94a3b8 !important; }
html.dark .border-gray-200 { border-color: #334155 !important; }

/* === TRIPS — section-specific === */
html.dark .tr-trip-id   { color: #e2e8f0; }
html.dark .tr-trip-dist { color: #475569; }
html.dark .tr-route-from { color: #e2e8f0; }
html.dark .tr-route-to  { color: #3b82f6; }  /* arrow → brand blue */
html.dark .tr-driver-name { color: #cbd5e1; }
html.dark .tr-driver-sub  { color: #475569; }
html.dark .tr-sched-date  { color: #cbd5e1; }
html.dark .tr-sched-time  { color: #475569; }
/* Trip status row borders */
html.dark .tr-table tbody tr[data-search*="in_progress"],
html.dark .tr-table tbody tr .tr-status-progress { border-left: 3px solid #2563eb; }
html.dark .tr-table tbody tr .tr-status-completed { border-left: 3px solid #22c55e; }
html.dark .tr-table tbody tr .tr-status-pending   { border-left: 3px solid #facc15; }

/* === MAINTENANCE — section-specific === */
html.dark .mr-rec-id   { background: rgba(220,38,38,.13) !important; border-color: rgba(220,38,38,.3) !important; color: #fca5a5 !important; }
html.dark .mr-veh-icon { background: #253347 !important; }
html.dark .mr-plate    { background: #253347 !important; border-color: #334155 !important; color: #e2e8f0 !important; }
html.dark .mr-veh-sub  { color: #475569; }
html.dark .mr-issue    { background: rgba(234,179,8,.13) !important; border-color: rgba(234,179,8,.3) !important; color: #facc15 !important; }
html.dark .mr-date-primary { color: #e2e8f0; }
html.dark .mr-date-sub    { color: #475569; }
html.dark .mr-tech-name   { color: #a5b4fc; }  /* light purple */
html.dark .mr-cost         { color: #4ade80; font-weight: 600; }  /* green for cost */
html.dark .mr-status-date  { color: #475569; }
/* In Progress maintenance row orange left border */
html.dark .mr-table tbody tr[data-status="active"] { border-left: 3px solid #f97316; }
html.dark .mr-table tbody tr[data-status="completed"] { border-left: 3px solid #22c55e; }

/* === FUEL — section-specific === */
html.dark .fr-plate      { background: #253347 !important; border-color: #334155 !important; color: #e2e8f0 !important; }
html.dark .fr-vehicle-sub { color: #475569; }
html.dark .fr-fuel-pill  { background: rgba(234,179,8,.13) !important; border-color: rgba(234,179,8,.3) !important; color: #facc15 !important; }
html.dark .fr-qty         { color: #7dd3fc; }  /* light blue for quantity */
html.dark .fr-qty span    { color: #475569; }
html.dark .fr-price       { color: #94a3b8; }
html.dark .fr-cost        { color: #4ade80; font-weight: 600; }  /* green for cost */
html.dark .fr-date-primary { color: #e2e8f0; }
html.dark .fr-date-sub    { color: #475569; }
html.dark .fr-station      { color: #94a3b8; }
html.dark .fr-station-empty { color: #334155; }
html.dark .fr-rec-id-text  { color: #e2e8f0; }
html.dark .fr-rec-sub      { color: #475569; }

/* === ACTION BUTTONS — all sections === */
/* View buttons */
html.dark .vh-btn-view, html.dark .dr-btn-view,
html.dark .tr-btn-view, html.dark .mr-btn-view, html.dark .fr-btn-view,
html.dark .action-btn.text-blue-700 {
    background: #1e3a5f !important; border-color: rgba(37,99,235,.4) !important; color: #93c5fd !important;
}
html.dark .vh-btn-view:hover, html.dark .dr-btn-view:hover,
html.dark .tr-btn-view:hover, html.dark .mr-btn-view:hover, html.dark .fr-btn-view:hover,
html.dark .action-btn.text-blue-700:hover {
    background: #1e3a5f !important; color: #bfdbfe !important; box-shadow: 0 0 8px rgba(37,99,235,.3) !important;
}
/* Edit buttons */
html.dark .vh-btn-edit, html.dark .dr-btn-edit,
html.dark .tr-btn-edit, html.dark .mr-btn-edit, html.dark .fr-btn-edit,
html.dark .action-btn.text-amber-700 {
    background: #431407 !important; border-color: rgba(234,179,8,.35) !important; color: #fcd34d !important;
}
html.dark .vh-btn-edit:hover, html.dark .dr-btn-edit:hover,
html.dark .tr-btn-edit:hover, html.dark .mr-btn-edit:hover, html.dark .fr-btn-edit:hover,
html.dark .action-btn.text-amber-700:hover {
    background: #5a1d09 !important; color: #fde68a !important;
}
/* Delete buttons */
html.dark .vh-btn-del, html.dark .dr-btn-del,
html.dark .tr-btn-del, html.dark .mr-btn-del, html.dark .fr-btn-del,
html.dark .action-btn.text-red-600,
html.dark .delete-btn.action-btn {
    background: #450a0a !important; border-color: rgba(239,68,68,.35) !important; color: #f87171 !important;
}
html.dark .vh-btn-del:hover, html.dark .dr-btn-del:hover,
html.dark .tr-btn-del:hover, html.dark .mr-btn-del:hover, html.dark .fr-btn-del:hover,
html.dark .action-btn.text-red-600:hover,
html.dark .delete-btn.action-btn:hover {
    background: #5c0a0a !important; color: #fca5a5 !important;
}
/* Mark done button (maintenance) */
html.dark .mr-btn-done {
    background: rgba(34,197,94,.13) !important; border-color: rgba(34,197,94,.3) !important; color: #4ade80 !important;
}
html.dark .mr-btn-done:hover { background: rgba(34,197,94,.22) !important; }

/* Add buttons (primary) */
html.dark .vh-add-btn, html.dark .dr-add-btn,
html.dark .tr-add-btn, html.dark .mr-add-btn, html.dark .fr-add-btn {
    box-shadow: 0 4px 14px rgba(0,0,0,.4) !important;
}

/* === MAINTENANCE FILTER TABS === */
html.dark .mr-filter-btn {
    background: #1e293b !important; border-color: #334155 !important; color: #94a3b8 !important;
}
html.dark .mr-filter-btn:hover { background: #253347 !important; color: #e2e8f0 !important; }
html.dark .mr-filter-btn.active { background: #e2e8f0 !important; color: #0f172a !important; border-color: #e2e8f0 !important; }
html.dark .mr-filter-btn.active-amber { background: rgba(234,179,8,.15) !important; color: #facc15 !important; border-color: rgba(234,179,8,.35) !important; }
html.dark .mr-filter-btn.active-green { background: rgba(34,197,94,.13) !important; color: #4ade80 !important; border-color: rgba(34,197,94,.3) !important; }

/* === MODALS === */
html.dark .vh-card ~ #delete-modal .bg-white,
html.dark #modal-box,
html.dark .tr-modal-box,
html.dark .mr-modal-box,
html.dark .fr-modal-box {
    background: #1e293b !important; border: 1px solid rgba(255,255,255,.08);
}
html.dark #modal-box h3,
html.dark .tr-modal-title,
html.dark .mr-modal-title,
html.dark .fr-modal-title { color: #f1f5f9 !important; }
html.dark #modal-box p,
html.dark .tr-modal-sub,
html.dark .mr-modal-sub,
html.dark .fr-modal-sub  { color: #94a3b8 !important; }
html.dark .tr-modal-cancel,
html.dark .mr-modal-cancel,
html.dark .fr-modal-cancel {
    background: #334155 !important; color: #e2e8f0 !important;
}
html.dark .tr-modal-cancel:hover,
html.dark .mr-modal-cancel:hover,
html.dark .fr-modal-cancel:hover { background: #475569 !important; }
/* Cancel button in Tailwind modal */
html.dark button.text-gray-700.bg-gray-100 {
    background: #334155 !important; color: #e2e8f0 !important;
}
html.dark button.text-gray-700.bg-gray-100:hover { background: #475569 !important; color: #f1f5f9 !important; }
html.dark #modal-vehicle-name,
html.dark #modal-driver-name,
html.dark #tr-modal-name,
html.dark #mr-modal-name,
html.dark #fr-modal-label { color: #f1f5f9 !important; }

/* === EMPTY STATES === */
html.dark .vh-empty-title, html.dark .dr-empty-title,
html.dark .tr-empty-title, html.dark .mr-empty-title, html.dark .fr-empty-title { color: #e2e8f0; }
html.dark .vh-empty-sub,   html.dark .dr-empty-sub,
html.dark .tr-empty-sub,   html.dark .mr-empty-sub,   html.dark .fr-empty-sub   { color: #64748b; }
html.dark .vh-empty-icon   { background: #1e3a5f !important; border-color: rgba(37,99,235,.3) !important; }
html.dark .dr-empty-icon   { background: #1e1b4b !important; border-color: rgba(99,102,241,.3) !important; }
html.dark .tr-empty-icon   { background: #2e1065 !important; border-color: rgba(124,58,237,.3) !important; }
html.dark .mr-empty-icon   { background: #450a0a !important; border-color: rgba(220,38,38,.3) !important; }
html.dark .fr-empty-icon   { background: #431407 !important; border-color: rgba(234,88,12,.3) !important; }

/* === GENERAL FORM INPUTS (create/edit pages) === */
html.dark input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]),
html.dark select,
html.dark textarea {
    background: #0f172a !important; border-color: #334155 !important;
    color: #e2e8f0 !important;
}
html.dark input::placeholder, html.dark textarea::placeholder { color: #475569 !important; }
html.dark input:focus, html.dark select:focus, html.dark textarea:focus {
    border-color: #2563eb !important; box-shadow: 0 0 0 3px rgba(37,99,235,.2) !important;
}
html.dark label { color: #cbd5e1 !important; }
html.dark .text-red-500 { color: #f87171 !important; }

/* ══════════════════════════════════════════════════════════════════════
   TRAFFIC MODULE DARK MODE — dashboard, hotspots, analytics
   Accent:  Amber #d97706 / #f59e0b
   ══════════════════════════════════════════════════════════════════════ */

/* === TRAFFIC PAGE BACKGROUND === */
html.dark .tf-page {
    background: #0f172a !important;
    background-image: none !important;
}
html.dark .min-h-screen.bg-gradient-to-br.from-slate-50 {
    background: #0f172a !important;
}

/* === TRAFFIC BREADCRUMB === */
html.dark .tf-breadcrumb { color: #475569; }
html.dark .tf-breadcrumb a { color: #475569; }
html.dark .tf-breadcrumb a:hover { color: #e2e8f0; }

/* === PAGE TITLE & SUBTITLE === */
html.dark .tf-page h1,
html.dark .tf-page .text-gray-900,
html.dark h1.text-gray-900 { color: #f1f5f9 !important; }
html.dark .tf-page .text-gray-500,
html.dark .tf-page .text-gray-600 { color: #64748b !important; }
html.dark .tf-page .text-gray-400 { color: #475569 !important; }
html.dark .tf-page .text-gray-700 { color: #94a3b8 !important; }

/* === STAT CARDS (dashboard) === */
html.dark .stat-card {
    background: #1e293b !important;
    border-color: #334155 !important;
    box-shadow: 0 1px 3px rgba(0,0,0,.3) !important;
}
html.dark .stat-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,.4) !important;
}
html.dark .stat-card p.text-gray-900 { color: #f1f5f9 !important; }
html.dark .stat-card p.text-gray-500 { color: #64748b !important; }
/* Stat card icon backgrounds */
html.dark .stat-card .bg-amber-100  { background: rgba(217,119,6,.2) !important; }
html.dark .stat-card .bg-red-100    { background: rgba(239,68,68,.15) !important; }
html.dark .stat-card .bg-violet-100 { background: rgba(139,92,246,.15) !important; }
html.dark .stat-card .bg-emerald-100 { background: rgba(34,197,94,.15) !important; }
/* Stat card icon colors */
html.dark .stat-card .text-amber-600  { color: #fbbf24 !important; }
html.dark .stat-card .text-red-500    { color: #f87171 !important; }
html.dark .stat-card .text-violet-600 { color: #a78bfa !important; }
html.dark .stat-card .text-emerald-600 { color: #4ade80 !important; }

/* === FILTER BAR === */
html.dark span.text-gray-500.uppercase { color: #475569 !important; }
/* Active filter (All button - bg-gray-900 text-white) already readable in dark */
html.dark .filter-btn {
    background: #1e293b !important;
    border-color: #334155 !important;
    color: #94a3b8 !important;
}
/* Keep the active 'All' button distinct in dark */
html.dark .filter-btn.bg-gray-900 {
    background: #e2e8f0 !important;
    color: #0f172a !important;
    border-color: #e2e8f0 !important;
}
/* Congestion filter buttons */
html.dark .filter-btn.text-red-700 { color: #f87171 !important; border-color: rgba(239,68,68,.35) !important; }
html.dark .filter-btn.text-orange-700 { color: #fb923c !important; border-color: rgba(249,115,22,.35) !important; }
html.dark .filter-btn.text-yellow-700 { color: #facc15 !important; border-color: rgba(234,179,8,.35) !important; }
html.dark .filter-btn.text-emerald-700 { color: #4ade80 !important; border-color: rgba(34,197,94,.35) !important; }
html.dark .filter-btn:hover { background: #253347 !important; color: #e2e8f0 !important; }
/* Live indicator text */
html.dark .text-gray-400 { color: #475569 !important; }

/* === MAIN TABLE CARD (Active Vehicle Traffic) === */
html.dark .bg-white.rounded-2xl.shadow-sm {
    background: #1e293b !important;
    border-color: #334155 !important;
}
html.dark .border-gray-100 { border-color: #334155 !important; }
html.dark .border-b.border-gray-100 { border-bottom-color: #334155 !important; }

/* Card header */
html.dark .text-gray-700 { color: #94a3b8 !important; }
html.dark .text-sm.font-semibold.text-gray-700 { color: #cbd5e1 !important; }

/* Table badge (amber pill in header) */
html.dark .bg-amber-100.text-amber-700 {
    background: rgba(217,119,6,.2) !important;
    color: #fbbf24 !important;
}

/* Search input inside traffic card */
html.dark #search-input {
    background: #0f172a !important;
    border-color: #334155 !important;
    color: #e2e8f0 !important;
}
html.dark #search-input::placeholder { color: #475569 !important; }
html.dark #search-input:focus {
    background: #1e293b !important;
    border-color: #d97706 !important;
    box-shadow: 0 0 0 3px rgba(217,119,6,.2) !important;
}

/* === TRAFFIC TABLE === */
html.dark #traffic-table thead tr,
html.dark tr.bg-gray-50.border-b { background: #0f172a !important; border-bottom-color: #334155 !important; }
html.dark #traffic-table th,
html.dark th.text-gray-500 { color: #64748b !important; }
html.dark #traffic-table tbody tr,
html.dark .divide-y.divide-gray-50 > * { border-color: #253347 !important; }
html.dark #traffic-table td { color: #e2e8f0 !important; }

/* Traffic row hover — amber tint fix */
html.dark .traffic-row:hover,
html.dark tr.traffic-row:hover {
    background-color: rgba(217,119,6,.1) !important;
    border-left: 3px solid #d97706;
}
html.dark .traffic-row:hover td,
html.dark tr.traffic-row:hover td { color: #e2e8f0 !important; }

/* Trip ID badge in traffic table */
html.dark .bg-amber-100.text-amber-700.rounded-lg {
    background: rgba(217,119,6,.2) !important;
    color: #fbbf24 !important;
}

/* Route text */
html.dark p.text-sm.font-medium.text-gray-900 { color: #e2e8f0 !important; }

/* Speed text */
html.dark span.text-sm.font-semibold.text-gray-900 { color: #7dd3fc !important; }
html.dark span.text-xs.text-gray-400.ml-0\.5 { color: #475569 !important; }

/* Coordinates link */
html.dark a.text-amber-600 { color: #fbbf24 !important; }
html.dark a.text-amber-600:hover { color: #fde68a !important; }

/* Last update text */
html.dark td.text-xs.text-gray-500 { color: #475569 !important; }

/* === CONGESTION LEVEL BADGES === */
/* Severe */
html.dark .bg-red-50.text-red-700.border-red-200 {
    background: rgba(239,68,68,.13) !important;
    color: #f87171 !important;
    border-color: rgba(239,68,68,.3) !important;
}
html.dark .bg-red-100.text-red-800 {
    background: rgba(239,68,68,.15) !important;
    color: #fca5a5 !important;
}
/* High */
html.dark .bg-orange-50.text-orange-700.border-orange-200 {
    background: rgba(249,115,22,.13) !important;
    color: #fb923c !important;
    border-color: rgba(249,115,22,.3) !important;
}
html.dark .bg-orange-100.text-orange-800 {
    background: rgba(249,115,22,.15) !important;
    color: #fdba74 !important;
}
/* Moderate */
html.dark .bg-yellow-50.text-yellow-700.border-yellow-200 {
    background: rgba(234,179,8,.13) !important;
    color: #facc15 !important;
    border-color: rgba(234,179,8,.3) !important;
}
html.dark .bg-yellow-100.text-yellow-800 {
    background: rgba(234,179,8,.15) !important;
    color: #fde047 !important;
}
/* Low */
html.dark .bg-emerald-50.text-emerald-700.border-emerald-200,
html.dark .bg-green-100.text-green-800 {
    background: rgba(34,197,94,.13) !important;
    color: #4ade80 !important;
    border-color: rgba(34,197,94,.3) !important;
}

/* === ACTION BUTTONS (traffic module) === */
/* View Trip / View (amber) */
html.dark .action-btn.text-amber-700,
html.dark a.text-amber-700.bg-amber-50,
html.dark button.text-amber-700.bg-amber-50 {
    background: rgba(217,119,6,.15) !important;
    border-color: rgba(217,119,6,.35) !important;
    color: #fbbf24 !important;
}
html.dark .action-btn.text-amber-700:hover,
html.dark a.text-amber-700.bg-amber-50:hover,
html.dark button.text-amber-700.bg-amber-50:hover {
    background: rgba(217,119,6,.25) !important;
    color: #fde68a !important;
}
/* Refresh / Analytics (gray outline buttons) */
html.dark .action-btn.text-gray-600,
html.dark button.text-gray-600.bg-white,
html.dark a.text-gray-600.bg-white {
    background: #1e293b !important;
    border-color: #334155 !important;
    color: #94a3b8 !important;
}
html.dark .action-btn.text-gray-600:hover,
html.dark button.text-gray-600.bg-white:hover,
html.dark a.text-gray-600.bg-white:hover {
    background: #253347 !important;
    color: #e2e8f0 !important;
}
/* View Details (blue button in hotspots table) */
html.dark button.text-blue-600.bg-blue-50,
html.dark .text-blue-600.bg-blue-50 {
    background: #1e3a5f !important;
    border-color: rgba(37,99,235,.4) !important;
    color: #93c5fd !important;
}
html.dark button.text-blue-600.bg-blue-50:hover { background: #1e3a5f !important; color: #bfdbfe !important; }

/* === TABLE FOOTER (traffic) === */
html.dark .bg-gray-50.border-t.border-gray-100 {
    background: #0f172a !important;
    border-top-color: #334155 !important;
}
html.dark #row-count,
html.dark p.text-xs.text-gray-400 { color: #475569 !important; }

/* === RECENT TRIP ANALYSES section === */
/* Analysis card rows */
html.dark .divide-y.divide-gray-50 > div:hover,
html.dark .hover\:bg-amber-50:hover {
    background: rgba(217,119,6,.08) !important;
}
html.dark .divide-y.divide-gray-50 > div:hover p,
html.dark .divide-y.divide-gray-50 > div:hover span { color: #e2e8f0 !important; }
/* Trip analysis info mini cards */
html.dark .bg-gray-50.rounded-lg {
    background: #253347 !important;
}
html.dark .bg-gray-50.rounded-lg p.text-gray-400 { color: #475569 !important; }
html.dark .bg-gray-50.rounded-lg p.text-gray-900 { color: #e2e8f0 !important; }
html.dark .bg-gray-50.rounded-lg span.text-gray-400 { color: #475569 !important; }

/* === HOTSPOTS PAGE === */
/* Hotspot table rows */
html.dark .hotspot-row {
    border-bottom-color: #253347 !important;
}
html.dark .hotspot-row:hover,
html.dark tr.hotspot-row:hover {
    background: rgba(217,119,6,.08) !important;
}
html.dark .hotspot-row td { color: #e2e8f0 !important; }
html.dark .hotspot-row td .text-gray-700 { color: #94a3b8 !important; }
html.dark .hotspot-row td .text-gray-400 { color: #475569 !important; }

/* Incident count badge */
html.dark .bg-red-100.text-red-800.rounded-full {
    background: rgba(239,68,68,.2) !important;
    color: #fca5a5 !important;
}

/* Map container header */
html.dark #map-container {
    background: #1e293b !important;
    border-color: #334155 !important;
}
html.dark #map-container .bg-gray-50 { background: #0f172a !important; }
html.dark #map-container .border-gray-100 { border-color: #334155 !important; }
html.dark #map-container .text-amber-600 { color: #fbbf24 !important; }
html.dark #map-container .text-gray-700 { color: #cbd5e1 !important; }
html.dark #map-container .text-gray-500 { color: #64748b !important; }
/* Map legend pill in header */
html.dark .bg-amber-100.text-amber-700.rounded-full {
    background: rgba(217,119,6,.2) !important;
    color: #fbbf24 !important;
}
/* Legend dots label texts */
html.dark #map-container .text-xs.text-gray-500 { color: #64748b !important; }

/* Hotspot table card header */
html.dark .bg-white.rounded-2xl h2.text-gray-900 { color: #f1f5f9 !important; }
html.dark .bg-white.rounded-2xl p.text-gray-600 { color: #64748b !important; }

/* Back to Dashboard button */
html.dark a.text-gray-600.bg-white.border.border-gray-200 {
    background: #1e293b !important;
    border-color: #334155 !important;
    color: #94a3b8 !important;
}
html.dark a.text-gray-600.bg-white.border.border-gray-200:hover {
    background: #253347 !important;
    color: #e2e8f0 !important;
}

/* === SR ROUTE SUGGESTION MODAL === */
html.dark .sr-modal-box {
    background: #1e293b !important;
    border: 1px solid rgba(255,255,255,.08);
}
html.dark .sr-body { background: #1e293b; }
html.dark .sr-section-label { color: #64748b !important; }
html.dark .sr-route-box {
    background: rgba(217,119,6,.1) !important;
    border-color: rgba(217,119,6,.3) !important;
}
html.dark .sr-route-text { color: #f1f5f9 !important; }
html.dark .sr-reason-box {
    background: #253347 !important;
    border-color: #334155 !important;
}
html.dark .sr-reason-text { color: #94a3b8 !important; }
html.dark .sr-stat-val { color: #f1f5f9 !important; }
html.dark .sr-stat-lbl { color: #64748b !important; }
/* Stat boxes in modal */
html.dark .sr-stat-box[style*="#f0fdf4"] {
    background: rgba(34,197,94,.1) !important;
    border-color: rgba(34,197,94,.25) !important;
}
html.dark .sr-stat-box[style*="#eff6ff"] {
    background: rgba(37,99,235,.1) !important;
    border-color: rgba(37,99,235,.25) !important;
}
html.dark .sr-stat-box[style*="#fff5f5"] {
    background: rgba(239,68,68,.1) !important;
    border-color: rgba(239,68,68,.25) !important;
}
html.dark .sr-hotspot-item {
    background: rgba(239,68,68,.1) !important;
    border-color: rgba(239,68,68,.3) !important;
    color: #fca5a5 !important;
}
html.dark .sr-hotspot-item svg { color: #f87171 !important; }
html.dark .sr-ai-badge {
    background: rgba(34,197,94,.1) !important;
    border-color: rgba(34,197,94,.3) !important;
    color: #4ade80 !important;
}
html.dark .sr-map-legend {
    background: rgba(30,41,59,.9) !important;
    border-color: #334155 !important;
    color: #e2e8f0 !important;
}
html.dark .sr-btn-secondary {
    background: #334155 !important;
    color: #e2e8f0 !important;
}
html.dark .sr-btn-secondary:hover { background: #475569 !important; }
html.dark .sr-thinking-label { color: #64748b !important; }

/* === JSON HOTSPOT DETAIL MODAL === */
html.dark #jsonModal > div {
    background: #1e293b !important;
}
html.dark #jsonModal .sticky.bg-gray-50 {
    background: #0f172a !important;
    border-bottom-color: #334155 !important;
}
html.dark #jsonModal h3.text-gray-900 { color: #f1f5f9 !important; }
html.dark #jsonModal #hotspotLocation { color: #64748b !important; }
html.dark #jsonModal button.text-gray-400 { color: #475569 !important; }
html.dark #jsonModal button.text-gray-400:hover { color: #e2e8f0 !important; }
/* Incident / speed mini cards */
html.dark #jsonModal .bg-amber-50 {
    background: rgba(217,119,6,.13) !important;
    border-color: rgba(217,119,6,.25) !important;
}
html.dark #jsonModal #incidentCount { color: #fbbf24 !important; }
html.dark #jsonModal .bg-orange-50 {
    background: rgba(249,115,22,.13) !important;
    border-color: rgba(249,115,22,.25) !important;
}
html.dark #jsonModal #avgSpeed { color: #fb923c !important; }
html.dark #jsonModal .text-gray-500 { color: #64748b !important; }
html.dark #jsonModal h4.text-gray-900 { color: #e2e8f0 !important; }
/* Records list rows */
html.dark #recordsList > div {
    background: #253347 !important;
    border-color: #334155 !important;
}
html.dark #recordsList p.text-gray-900 { color: #e2e8f0 !important; }
html.dark #recordsList p.text-gray-500 { color: #64748b !important; }
html.dark #recordsList span.text-gray-400 { color: #475569 !important; }
/* JSON pre block */
html.dark #jsonText {
    background: #0f172a !important;
    border-color: #334155 !important;
    color: #94a3b8 !important;
}
/* Copy/Close buttons */
html.dark #jsonModal .bg-gray-100.text-gray-700 {
    background: #334155 !important;
    color: #e2e8f0 !important;
}
html.dark #jsonModal .bg-gray-100.text-gray-700:hover { background: #475569 !important; }
/* Loading spinner color */
html.dark #loadingMsg p.text-gray-600 { color: #64748b !important; }

    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
{{-- ── FLEETBOT CHATBOT ─────────────────────────────────────── --}}
<style>
    #fleetbot-bubble { position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 99999; }
    #fleetbot-btn {
        width: 58px; height: 58px; border-radius: 50%;
        background: linear-gradient(135deg, #7c3aed, #4f46e5);
        border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 20px rgba(124,58,237,.45); transition: all .25s ease; position: relative;
    }
    #fleetbot-btn:hover { transform: scale(1.1); box-shadow: 0 8px 28px rgba(124,58,237,.55); }
    #fleetbot-btn .fb-notif-dot {
        position: absolute; top: 0; right: 0;
        width: 14px; height: 14px; background: #ef4444;
        border-radius: 50%; border: 2px solid #fff;
        animation: pulse-dot 2s ease-in-out infinite;
    }
    #fleetbot-panel {
        position: absolute; bottom: 70px; right: 0;
        width: 370px; background: #fff; border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,.15), 0 4px 16px rgba(0,0,0,.08);
        border: 1px solid #e5e7eb; overflow: hidden;
        transform: scale(.93) translateY(12px); opacity: 0;
        transition: all .28s cubic-bezier(.34,1.56,.64,1);
        pointer-events: none;
    }
    #fleetbot-panel.open { transform: scale(1) translateY(0); opacity: 1; pointer-events: all; }

    /* Header */
    .fb-header {
        background: linear-gradient(135deg, #7c3aed, #4f46e5);
        padding: 1rem 1.25rem; display: flex; align-items: center; gap: .75rem;
    }
    .fb-avatar-lg {
        width: 38px; height: 38px; border-radius: 50%;
        background: rgba(255,255,255,.2); display: flex; align-items: center;
        justify-content: center; font-size: 1.15rem; border: 1.5px solid rgba(255,255,255,.35);
        flex-shrink: 0;
    }
    .fb-header-info .fb-title { font-size: .9rem; font-weight: 700; color: #fff; }
    .fb-header-info .fb-sub   { font-size: .7rem; color: rgba(255,255,255,.7); display: flex; align-items: center; gap: .3rem; margin-top: .1rem; }
    .fb-online-dot { width: 6px; height: 6px; border-radius: 50%; background: #4ade80; animation: pulse-dot 2s ease-in-out infinite; }
    .fb-close-btn {
        margin-left: auto; background: rgba(255,255,255,.15); border: none;
        color: #fff; width: 30px; height: 30px; border-radius: 8px;
        cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center;
        transition: background .15s; flex-shrink: 0;
    }
    .fb-close-btn:hover { background: rgba(255,255,255,.28); }

    /* Messages */
    #fb-messages {
        height: 340px; overflow-y: auto; padding: 1rem;
        display: flex; flex-direction: column; gap: .6rem;
        background: #f0f4ff; scroll-behavior: smooth;
    }
    #fb-messages::-webkit-scrollbar { width: 4px; }
    #fb-messages::-webkit-scrollbar-thumb { background: #c7d2fe; border-radius: 99px; }

    .fb-msg { display: flex; gap: .5rem; align-items: flex-end; max-width: 100%; }
    .fb-msg.user { flex-direction: row-reverse; }
    .fb-msg-avatar { width: 26px; height: 26px; border-radius: 50%; background: #dbeafe; display: flex; align-items: center; justify-content: center; font-size: .75rem; flex-shrink: 0; margin-bottom: 2px; }
    .fb-bubble {
        max-width: 82%; padding: .65rem .9rem; border-radius: 16px;
        font-size: .8rem; line-height: 1.55; word-break: break-word;
    }
    .fb-msg.bot  .fb-bubble { background: #fff; border: 1px solid #e2e8f0; color: #1e293b; border-bottom-left-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
    .fb-msg.user .fb-bubble { background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; border-bottom-right-radius: 4px; box-shadow: 0 2px 8px rgba(37,99,235,.3); }
    .fb-action-pill { display: inline-flex; align-items: center; gap: .4rem; font-size: .72rem; padding: .35rem .7rem; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 99px; color: #166534; margin-top: .4rem; font-weight: 600; }
    .fb-time { font-size: .62rem; color: #94a3b8; margin-top: .2rem; text-align: right; }
    .fb-msg.bot .fb-time { text-align: left; }

    /* Typing */
    .fb-typing-bubble { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; border-bottom-left-radius: 4px; padding: .65rem .9rem; display: flex; gap: 5px; align-items: center; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
    .fb-typing-bubble span { width: 7px; height: 7px; border-radius: 50%; background: #94a3b8; animation: bounce-dot .8s ease-in-out infinite; display: block; }
    .fb-typing-bubble span:nth-child(2) { animation-delay: .15s; }
    .fb-typing-bubble span:nth-child(3) { animation-delay: .3s; }

    /* Suggestions */
    .fb-suggestions { display: flex; flex-wrap: wrap; gap: .35rem; padding: .75rem 1rem .25rem; background: #f0f4ff; border-top: 1px solid #e2e8f0; }
    .fb-chip {
        font-size: .7rem; padding: .3rem .7rem; border-radius: 99px;
        background: #fff; border: 1px solid #bfdbfe; color: #1d4ed8;
        cursor: pointer; transition: all .15s; font-weight: 500; white-space: nowrap;
    }
    .fb-chip:hover { background: #dbeafe; border-color: #93c5fd; }

    /* Input */
    .fb-footer { padding: .75rem 1rem; border-top: 1px solid #e5e7eb; background: #fff; }
    .fb-input-row { display: flex; gap: .5rem; align-items: center; }
    #fb-input {
        flex: 1; padding: .55rem .875rem; border: 1.5px solid #e2e8f0;
        border-radius: 12px; font-size: .8rem; outline: none;
        background: #f8faff; transition: all .15s; color: #1e293b; resize: none;
    }
    #fb-input:focus { border-color: #2563eb; background: #fff; box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
    #fb-input::placeholder { color: #94a3b8; }
    #fb-send {
        width: 38px; height: 38px; border-radius: 10px;
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        border: none; cursor: pointer; color: #fff;
        display: flex; align-items: center; justify-content: center;
        transition: all .15s; flex-shrink: 0; box-shadow: 0 2px 8px rgba(124,58,237,.3);
    }
    #fb-send:hover:not(:disabled) { transform: scale(1.05); box-shadow: 0 4px 12px rgba(124,58,237,.4); }
    #fb-send:disabled { background: #93c5fd; cursor: not-allowed; box-shadow: none; }

    /* ══════════════════════════════════════════════════════════
       FLEETBOT — DARK MODE OVERRIDES
       All values sourced from app.blade.php + home.blade.php palette.
       Palette reference:
         Base surface    #0f172a  (dark page/body)
         Elevated        #1e293b  (cards, panel)
         Hover surface   #253347  (subtle hover lift)
         Hover strong    #334155  (rows, borders)
         Border default  #334155
         Border muted    #2d3f55
         Primary blue    #2563eb  (buttons, logo, user bubble)
         Blue deep       #1d4ed8  (user bubble gradient end)
         Blue dark bg    #1e3a5f  (active nav, chip hover)
         Blue text light #93c5fd  (dark badge text)
         Bot/purple      #7c3aed  (FleetBot brand, send btn)
         Purple end      #4f46e5  (FleetBot header gradient end)
         Green accent    #4ade80  (online dot)
         Green dark text #16a34a  (action pill text)
         Text primary    #e2e8f0
         Text muted      #94a3b8
         Text subtle     #475569
       ══════════════════════════════════════════════════════════ */

    /* ── Message entrance animation ──────────────────────────── */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Floating bubble button ───────────────────────────────── */
    html.dark #fleetbot-btn {
        background: linear-gradient(135deg, #7c3aed, #4f46e5);
        box-shadow: 0 4px 20px rgba(124,58,237,.5);
    }
    html.dark #fleetbot-btn:hover {
        box-shadow: 0 8px 32px rgba(124,58,237,.7), 0 0 0 4px rgba(124,58,237,.2);
        transform: scale(1.1);
    }

    /* ── Panel & surface hierarchy ────────────────────────────── */
    html.dark #fleetbot-panel {
        background: #1e293b;
        border-color: #334155;
        box-shadow: 0 24px 64px rgba(0,0,0,.55), 0 4px 20px rgba(0,0,0,.35);
    }

    /* ── Header — darker purple gradient + bottom border ─────── */
    html.dark .fb-header {
        background: linear-gradient(135deg, #5b21b6, #3730a3);
        border-bottom: 1px solid rgba(124,58,237,.35);
    }
    html.dark .fb-close-btn:hover {
        background: rgba(255,255,255,.22);
    }

    /* ── Online dot — glowing green ──────────────────────────── */
    html.dark .fb-online-dot {
        background: #4ade80;
        box-shadow: 0 0 6px 2px rgba(74,222,128,.6);
    }

    /* ── Message area ─────────────────────────────────────────── */
    html.dark #fb-messages {
        background: #0f172a;
    }

    /* ── New message slide-up ─────────────────────────────────── */
    html.dark .fb-msg {
        animation: fadeSlideUp .25s ease both;
    }

    /* ── Bot bubble — elevated surface, brand-blue border tint ── */
    html.dark .fb-msg.bot .fb-bubble {
        background: #1e293b;
        border-color: rgba(37,99,235,.28);
        color: #e2e8f0;
        box-shadow: 0 2px 10px rgba(0,0,0,.3);
    }

    /* ── User bubble — primary blue gradient + matching glow ──── */
    html.dark .fb-msg.user .fb-bubble {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        box-shadow: 0 3px 14px rgba(37,99,235,.45);
    }

    /* ── Avatar ───────────────────────────────────────────────── */
    html.dark .fb-msg-avatar {
        background: #253347;
    }

    /* ── Timestamp ────────────────────────────────────────────── */
    html.dark .fb-time {
        color: #475569;
    }

    /* ── Action result pill — green accent at low opacity ─────── */
    html.dark .fb-action-pill {
        background: rgba(74,222,128,.12);
        border-color: rgba(74,222,128,.3);
        color: #4ade80;
    }

    /* ── Typing indicator — brand blue dots ───────────────────── */
    html.dark .fb-typing-bubble {
        background: #1e293b;
        border-color: rgba(37,99,235,.28);
        box-shadow: 0 2px 10px rgba(0,0,0,.3);
    }
    html.dark .fb-typing-bubble span {
        background: #2563eb;
    }

    /* ── Quick suggestion chips ───────────────────────────────── */
    html.dark .fb-suggestions {
        background: #0f172a;
        border-top-color: #334155;
    }
    html.dark .fb-chip {
        background: #1e293b;
        border-color: rgba(37,99,235,.4);
        color: #93c5fd;
    }
    html.dark .fb-chip:hover {
        background: #1e3a5f;
        border-color: rgba(37,99,235,.7);
        box-shadow: 0 0 8px rgba(37,99,235,.25);
        color: #bfdbfe;
    }

    /* ── Footer & input ───────────────────────────────────────── */
    html.dark .fb-footer {
        background: #1e293b;
        border-top-color: #334155;
    }
    html.dark #fb-input {
        background: #0f172a;
        border-color: #334155;
        color: #e2e8f0;
    }
    html.dark #fb-input::placeholder {
        color: #475569;
    }
    html.dark #fb-input:focus {
        background: #1e293b;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,.22);
    }

    /* ── Send button disabled state in dark ───────────────────── */
    html.dark #fb-send:disabled {
        background: #1e3a5f;
        box-shadow: none;
    }

    /* ── Scrollbar — brand blue thumb ────────────────────────── */
    html.dark #fb-messages::-webkit-scrollbar        { width: 4px; }
    html.dark #fb-messages::-webkit-scrollbar-track  { background: transparent; }
    html.dark #fb-messages::-webkit-scrollbar-thumb  { background: rgba(37,99,235,.45); border-radius: 99px; }
    html.dark #fb-messages::-webkit-scrollbar-thumb:hover { background: rgba(37,99,235,.7); }
</style>

{{-- Bubble --}}
<div id="fleetbot-bubble">
    <button id="fleetbot-btn" onclick="toggleFleetbot()" title="FleetBot AI Assistant">
        <svg id="fb-icon-chat" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
        <svg id="fb-icon-x" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <span class="fb-notif-dot"></span>
    </button>

    {{-- Panel --}}
    <div id="fleetbot-panel">

        {{-- Header --}}
        <div class="fb-header">
            <div class="fb-avatar-lg">✨</div>
            <div class="fb-header-info">
                <div class="fb-title">FleetBot</div>
                <div class="fb-sub">
                    <span class="fb-online-dot"></span>
                    Gemini AI · Online
                </div>
            </div>
            <button id="fb-clear-btn" onclick="fbClearChat()" title="Clear conversation"
                style="background:rgba(255,255,255,.15);border:none;color:#fff;width:30px;height:30px;
                       border-radius:8px;cursor:pointer;font-size:.78rem;display:flex;align-items:center;
                       justify-content:center;transition:background .15s;flex-shrink:0;"
                onmouseover="this.style.background='rgba(255,255,255,.28)'"
                onmouseout="this.style.background='rgba(255,255,255,.15)'">🗑️</button>
            <button class="fb-close-btn" onclick="toggleFleetbot()">✕</button>
        </div>

        {{-- Messages --}}
        <div id="fb-messages">
            <div class="fb-msg bot">
                <div class="fb-msg-avatar">✨</div>
                <div>
                    <div class="fb-bubble">
                        👋 Hi! I'm <strong>FleetBot</strong>, your Gemini-powered fleet assistant.<br><br>
                        I can <strong>answer questions</strong> about your fleet and <strong>perform actions</strong> like creating records or updating statuses. How can I help you today?
                    </div>
                    <div class="fb-time">Just now</div>
                </div>
            </div>
        </div>

        {{-- Quick suggestions --}}
        <div class="fb-suggestions" id="fb-chips">
            <button class="fb-chip" onclick="useChip(this)">Fleet summary</button>
            <button class="fb-chip" onclick="useChip(this)">Active vehicles?</button>
            <button class="fb-chip" onclick="useChip(this)">Expiring licenses?</button>
            <button class="fb-chip" onclick="useChip(this)">Total fuel cost?</button>
            <button class="fb-chip" onclick="useChip(this)">Trips in progress?</button>
            <button class="fb-chip" onclick="useChip(this)">Any risks?</button>
        </div>

        {{-- Input --}}
        <div class="fb-footer">
            <div class="fb-input-row">
                <input id="fb-input" type="text"
                       placeholder="Ask about your fleet…"
                       maxlength="500"
                       onkeydown="if(event.key==='Enter' && !event.shiftKey){ event.preventDefault(); sendFbMessage(); }">
                <button id="fb-send" onclick="sendFbMessage()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// ══════════════════════════════════════════════════════════════
// FLEETBOT — STATE & PERSISTENCE
// Uses sessionStorage so state survives page navigation within
// the same browser tab but clears when the tab is closed.
// ══════════════════════════════════════════════════════════════
let fbOpen    = false;
let fbHistory = [];

// ── Save full state to sessionStorage ────────────────────────
function fbSaveState() {
    // Trim history to last 20 entries
    if (fbHistory.length > 20) fbHistory = fbHistory.slice(-20);

    // Trim DOM messages if more than 50 bubbles
    const msgs    = document.getElementById('fb-messages');
    const allMsgs = msgs.querySelectorAll('.fb-msg');
    if (allMsgs.length > 50) {
        for (let i = 0; i < allMsgs.length - 50; i++) allMsgs[i].remove();
    }

    try {
        sessionStorage.setItem('fbHistory',  JSON.stringify(fbHistory));
        sessionStorage.setItem('fbOpen',     JSON.stringify(fbOpen));
        sessionStorage.setItem('fbMessages', msgs.innerHTML);
        sessionStorage.setItem('fbChipsHidden',
            document.getElementById('fb-chips').style.display === 'none' ? '1' : '0');
    } catch (e) {
        // sessionStorage full — keep only the last 10 history entries and retry
        try {
            sessionStorage.clear();
            sessionStorage.setItem('fbHistory', JSON.stringify(fbHistory.slice(-10)));
        } catch (_) { /* storage completely unavailable — degrade silently */ }
    }
}

// ── Restore state from sessionStorage on page load ────────────
function fbRestoreState() {
    let savedMessages, savedHistory, savedOpen, chipsHidden;
    try {
        savedMessages  = sessionStorage.getItem('fbMessages');
        savedHistory   = sessionStorage.getItem('fbHistory');
        savedOpen      = sessionStorage.getItem('fbOpen');
        chipsHidden    = sessionStorage.getItem('fbChipsHidden');
    } catch (e) { return; } // sessionStorage unavailable — start fresh

    if (savedHistory) {
        try { fbHistory = JSON.parse(savedHistory); } catch (_) { fbHistory = []; }
    }

    if (savedMessages) {
        const msgs = document.getElementById('fb-messages');
        msgs.innerHTML = savedMessages;

        // Append a subtle "conversation restored" divider
        const divider = document.createElement('div');
        divider.style.cssText = 'text-align:center;font-size:.63rem;color:#94a3b8;padding:.15rem 0;margin:.15rem 0;letter-spacing:.03em;';
        divider.textContent = '— conversation restored —';
        msgs.appendChild(divider);
        msgs.scrollTop = msgs.scrollHeight;

        // Hide chips if they were hidden before
        if (chipsHidden === '1') document.getElementById('fb-chips').style.display = 'none';
    }

    if (savedOpen === 'true') {
        fbOpen = true;
        document.getElementById('fleetbot-panel').classList.add('open');
        document.getElementById('fb-icon-chat').classList.add('hidden');
        document.getElementById('fb-icon-x').classList.remove('hidden');
        const dot = document.querySelector('#fleetbot-btn .fb-notif-dot');
        if (dot) dot.style.display = 'none';
    }
}

// Restore state as soon as the DOM is ready
document.addEventListener('DOMContentLoaded', fbRestoreState);

// ── Clear chat and reset all persisted state ──────────────────
function fbClearChat() {
    if (!confirm('Clear the conversation? This cannot be undone.')) return;

    fbHistory = [];
    try {
        sessionStorage.removeItem('fbHistory');
        sessionStorage.removeItem('fbOpen');
        sessionStorage.removeItem('fbMessages');
        sessionStorage.removeItem('fbChipsHidden');
    } catch (_) {}

    document.getElementById('fb-messages').innerHTML = `
        <div class="fb-msg bot">
            <div class="fb-msg-avatar">✨</div>
            <div>
                <div class="fb-bubble">
                    👋 Hi! I'm <strong>FleetBot</strong>, your Gemini-powered fleet assistant.<br><br>
                    I can <strong>answer questions</strong> about your fleet and <strong>perform actions</strong>
                    like creating records or updating statuses. How can I help you today?
                </div>
                <div class="fb-time">Just now</div>
            </div>
        </div>`;

    document.getElementById('fb-chips').style.display = 'flex';
}

// ── Toggle panel ──────────────────────────────────────────────
function toggleFleetbot() {
    fbOpen = !fbOpen;
    document.getElementById('fleetbot-panel').classList.toggle('open', fbOpen);
    document.getElementById('fb-icon-chat').classList.toggle('hidden', fbOpen);
    document.getElementById('fb-icon-x').classList.toggle('hidden', !fbOpen);
    const dot = document.querySelector('#fleetbot-btn .fb-notif-dot');
    if (dot && fbOpen) dot.style.display = 'none';
    if (fbOpen) setTimeout(() => document.getElementById('fb-input').focus(), 300);
    fbSaveState(); // persist open/closed state
}

// ── Use quick chip ────────────────────────────────────────────
function useChip(btn) {
    document.getElementById('fb-input').value = btn.textContent;
    document.getElementById('fb-chips').style.display = 'none';
    fbSaveState(); // persist chips-hidden state
    sendFbMessage();
}

// ── Append message to UI ──────────────────────────────────────
function fbAppend(role, html, actionResult = null) {
    const msgs = document.getElementById('fb-messages');
    const now  = new Date().toLocaleTimeString([], { hour:'2-digit', minute:'2-digit' });
    const div  = document.createElement('div');
    div.className = `fb-msg ${role}`;

    if (role === 'bot') {
        div.innerHTML = `
            <div class="fb-msg-avatar">✨</div>
            <div>
                <div class="fb-bubble">${html}</div>
                ${actionResult ? `<div class="fb-action-pill">⚡ ${actionResult}</div>` : ''}
                <div class="fb-time">${now}</div>
            </div>`;
    } else {
        div.innerHTML = `
            <div>
                <div class="fb-bubble">${html}</div>
                <div class="fb-time">${now}</div>
            </div>`;
    }

    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
    fbSaveState(); // persist after every new bubble
}

// ── Show / remove typing indicator ───────────────────────────
function fbShowTyping() {
    const msgs = document.getElementById('fb-messages');
    const div  = document.createElement('div');
    div.className = 'fb-msg bot';
    div.id = 'fb-typing-indicator';
    div.innerHTML = `
        <div class="fb-msg-avatar">✨</div>
        <div class="fb-typing-bubble"><span></span><span></span><span></span></div>`;
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
    // NOTE: typing indicator is NOT saved — it is always fresh on reload
}

function fbRemoveTyping() {
    document.getElementById('fb-typing-indicator')?.remove();
}

// ── Format AI reply (markdown → HTML) ────────────────────────
function fbFormat(text) {
    return text
        .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
        .replace(/\*(.*?)\*/g, '<em>$1</em>')
        .replace(/`(.*?)`/g, '<code style="background:#f1f5f9;padding:1px 5px;border-radius:4px;font-size:.75rem;">$1</code>')
        .replace(/^• (.+)$/gm, '<span style="display:block;padding-left:.75rem;position:relative;"><span style="position:absolute;left:0;">•</span>$1</span>')
        .replace(/^- (.+)$/gm, '<span style="display:block;padding-left:.75rem;position:relative;"><span style="position:absolute;left:0;">•</span>$1</span>')
        .replace(/\n\n/g, '<br><br>')
        .replace(/\n/g, '<br>');
}

// ── Send message ──────────────────────────────────────────────
async function sendFbMessage() {
    const input  = document.getElementById('fb-input');
    const send   = document.getElementById('fb-send');
    const msg    = input.value.trim();
    if (!msg || send.disabled) return;

    input.value   = '';   // always clear input on send
    send.disabled = true;

    // Append user message and persist
    fbAppend('user', msg.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'));

    // Add to history
    fbHistory.push({ role: 'user', content: msg });

    fbShowTyping();

    try {
        const res = await fetch('{{ route("chat") }}', {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept':       'application/json',
            },
            body: JSON.stringify({
                message: msg,
                history: fbHistory.slice(-10),
            }),
        });

        const data = await res.json();
        fbRemoveTyping();

        if (data.error) {
            fbAppend('bot', `❌ ${data.error}`);
        } else {
            fbAppend('bot', fbFormat(data.reply), data.action_result);
            fbHistory.push({ role: 'assistant', content: data.reply });
            if (fbHistory.length > 20) fbHistory = fbHistory.slice(-20);
            fbSaveState(); // save updated history after assistant reply
        }

    } catch (err) {
        fbRemoveTyping();
        fbAppend('bot', '❌ Connection error. Please check your connection and try again.');
    } finally {
        send.disabled = false;
        input.focus();
    }
}
</script>
<body class="bg-gray-50 transition-colors duration-300">

    {{-- ── NAVBAR ──────────────────────────────────────────────── --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap');
            nav * { font-family: 'DM Sans', sans-serif; }
            .nav-link { padding: .5rem .875rem; border-radius: 10px; font-size: .85rem; font-weight: 500; color: #6b7280; transition: all .2s ease; }
            .nav-link:hover { background: #f3f4f6; color: #374151; }
            .nav-link.active { background: #eff6ff; color: #2563eb; font-weight: 600; }
        </style>
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="/" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md">🚛</div>
                    <span class="text-lg font-bold text-gray-900 hidden sm:inline" style="letter-spacing: -.5px;">Fleet Manager</span>
                </a>

                {{-- Desktop Nav links --}}
                <ul class="hidden md:flex items-center gap-2">
                    @php
                        $navLinks = [
                            ['route' => 'vehicles.index',            'label' => 'Vehicles',    'icon' => '🚗'],
                            ['route' => 'drivers.index',             'label' => 'Drivers',     'icon' => '👨‍💼'],
                            ['route' => 'trips.index',               'label' => 'Trips',       'icon' => '📍'],
                            ['route' => 'maintenance_records.index', 'label' => 'Maintenance', 'icon' => '🔧'],
                            ['route' => 'fuel_records.index',        'label' => 'Fuel',        'icon' => '⛽'],
                            ['route' => 'traffic.dashboard',         'label' => 'Traffic',     'icon' => '📊'],
                            ['route' => 'fleetmind.index',           'label' => 'FleetMind',   'icon' => '🤖'],
                        ];
                    @endphp
                    @foreach($navLinks as $link)
                        <li>
                            <a href="{{ route($link['route']) }}"
                               class="nav-link {{ request()->routeIs(explode('.', $link['route'])[0].'.*') ? 'active' : '' }}">
                                {{ $link['icon'] }} <span class="hidden lg:inline">{{ $link['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{-- Right side: Dark Mode + Bell + Home + Hamburger --}}
                <div class="flex items-center gap-3">

                    {{-- Dark Mode Toggle --}}
                    <button id="dark-toggle" onclick="toggleDarkMode()"
                            class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors duration-200"
                            title="Toggle dark mode">
                        <svg id="icon-sun" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                        </svg>
                        <svg id="icon-moon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    {{-- Bell Button --}}
                    <div class="relative">
                        <button id="bell-btn" onclick="toggleNotifPanel()"
                                class="relative w-10 h-10 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @php
                                $alerts = [];
                                try {
                                    $expiringDrivers = \App\Models\Driver::whereNotNull('license_expiry_date')
                                        ->where('license_expiry_date', '<=', now()->addDays(30))->get();
                                    foreach ($expiringDrivers as $driver) {
                                        $expired = $driver->license_expiry_date->isPast();
                                        $alerts[] = ['type' => $expired ? 'error' : 'warning', 'title' => $expired ? 'License Expired' : 'License Expiring Soon', 'message' => $driver->name . ' — ' . $driver->license_expiry_date->format('M d, Y'), 'link' => route('drivers.show', $driver->id)];
                                    }
                                } catch (\Exception $e) {}
                                try {
                                    $overdueVehicles = \App\Models\MaintenanceRecord::with('vehicle')->where('service_date', '<=', now()->subDays(90))->orderByDesc('service_date')->get()->unique('vehicle_id')->take(5);
                                    foreach ($overdueVehicles as $record) {
                                        $alerts[] = ['type' => 'warning', 'title' => 'Maintenance Overdue', 'message' => ($record->vehicle->plate_number ?? 'Vehicle') . ' — last serviced ' . $record->service_date->diffForHumans(), 'link' => route('maintenance_records.index')];
                                    }
                                } catch (\Exception $e) {}
                                try {
                                    $activeTrips = \App\Models\Trip::where('status', 'in_progress')->count();
                                    if ($activeTrips > 0) {
                                        $alerts[] = ['type' => 'info', 'title' => 'Active Trips', 'message' => $activeTrips . ' trip' . ($activeTrips > 1 ? 's' : '') . ' currently in progress', 'link' => route('trips.index')];
                                    }
                                } catch (\Exception $e) {}
                                $alertCount = count($alerts);
                            @endphp
                            @if($alertCount > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center leading-none">
                                    {{ $alertCount > 9 ? '9+' : $alertCount }}
                                </span>
                            @endif
                        </button>

                        {{-- Notification Panel --}}
                        <div id="notif-panel" class="hidden absolute right-0 mt-3 w-96 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden" style="top: 100%;">
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-gray-900">Notifications</span>
                                    @if($alertCount > 0)
                                        <span class="px-2 py-0.5 text-xs font-semibold bg-red-100 text-red-700 rounded-full">{{ $alertCount }}</span>
                                    @endif
                                </div>
                                @if($alertCount > 0)
                                    <button onclick="clearAllNotifs()" class="text-xs text-gray-400 hover:text-gray-600 font-medium transition-colors">Clear all</button>
                                @endif
                            </div>
                            <div id="notif-list" class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                                @if($alertCount > 0)
                                    @foreach($alerts as $i => $alert)
                                        <div class="notif-item px-6 py-4 cursor-pointer hover:bg-gray-50 transition-colors" id="notif-{{ $i }}" data-href="{{ $alert['link'] }}">
                                            <div class="flex items-start gap-3">
                                                <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 {{ $alert['type'] === 'error' ? 'bg-red-100' : ($alert['type'] === 'warning' ? 'bg-amber-100' : 'bg-blue-100') }}">
                                                    @if($alert['type'] === 'error')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/></svg>
                                                    @elseif($alert['type'] === 'warning')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/></svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs font-bold text-gray-900">{{ $alert['title'] }}</p>
                                                    <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $alert['message'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="px-6 py-12 text-center">
                                        <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                        </div>
                                        <p class="text-sm font-bold text-gray-500">All clear!</p>
                                        <p class="text-xs text-gray-400 mt-1">No alerts at this time</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Home button (hidden on mobile) --}}
                    <a href="/" class="hidden sm:inline-flex px-5 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg text-sm font-semibold hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        🏠 Home
                    </a>

                    {{-- Hamburger (mobile only) --}}
                    <button id="hamburger" onclick="toggleMobileMenu()"
                            class="md:hidden w-10 h-10 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors duration-200">
                        <svg id="hamburger-icon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- ── MOBILE MENU ──────────────────────────────────────── --}}
        <div id="mobile-menu" class="md:hidden border-t border-gray-100 bg-white">
            <div class="container mx-auto px-4 py-4 space-y-2">
                @foreach($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors {{ request()->routeIs(explode('.', $link['route'])[0].'.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <span class="text-lg">{{ $link['icon'] }}</span>
                        {{ $link['label'] }}
                    </a>
                @endforeach
                <div class="border-t border-gray-100 pt-3 mt-3">
                    <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700">
                        🏠 Home
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- ── TOAST CONTAINER ─────────────────────────────────────── --}}
    <div id="toast-container"></div>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-400 mt-20 border-t border-gray-800">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-white font-semibold mb-4">Fleet Manager</h3>
                    <p class="text-sm">Complete fleet management solution for modern logistics.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Navigation</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('vehicles.index') }}" class="hover:text-white transition-colors duration-200">Vehicles</a></li>
                        <li><a href="{{ route('drivers.index') }}" class="hover:text-white transition-colors duration-200">Drivers</a></li>
                        <li><a href="{{ route('trips.index') }}" class="hover:text-white transition-colors duration-200">Trips</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Operations</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('maintenance_records.index') }}" class="hover:text-white transition-colors duration-200">Maintenance</a></li>
                        <li><a href="{{ route('fuel_records.index') }}" class="hover:text-white transition-colors duration-200">Fuel Records</a></li>
                        <li><a href="{{ route('traffic.dashboard') }}" class="hover:text-white transition-colors duration-200">Traffic Control</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact</h4>
                    <p class="text-sm mb-2">Email: support@fleetmanager.com</p>
                    <p class="text-sm">Phone: (555) 123-4567</p>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; 2026 Fleet Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- ── GLOBAL SCRIPTS ───────────────────────────────────────── --}}
    <script>
        /* Flash message data injected by PHP — no Blade directives in JS context */
        var __flash = {
            success: <?php echo json_encode(session('success')); ?>,
            error:   <?php echo json_encode(session('error')); ?>,
            warning: <?php echo json_encode(session('warning')); ?>,
            info:    <?php echo json_encode(session('info')); ?>
        };
    </script>
    <script>
        // ── Dark Mode ─────────────────────────────────────────────
        const html     = document.documentElement;
        const iconSun  = document.getElementById('icon-sun');
        const iconMoon = document.getElementById('icon-moon');

        function applyDark(dark) {
            if (dark) {
                html.classList.add('dark');
                iconSun.classList.remove('hidden');
                iconMoon.classList.add('hidden');
            } else {
                html.classList.remove('dark');
                iconSun.classList.add('hidden');
                iconMoon.classList.remove('hidden');
            }
        }

        function toggleDarkMode() {
            const isDark = html.classList.contains('dark');
            localStorage.setItem('darkMode', !isDark);
            applyDark(!isDark);
        }

        applyDark(localStorage.getItem('darkMode') === 'true');

        // ── Mobile Menu ───────────────────────────────────────────
        let mobileOpen = false;

        function toggleMobileMenu() {
            mobileOpen = !mobileOpen;
            const menu          = document.getElementById('mobile-menu');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            const closeIcon     = document.getElementById('close-icon');
            if (mobileOpen) {
                menu.classList.add('open');
                hamburgerIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            } else {
                menu.classList.remove('open');
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        }

        document.addEventListener('click', function(e) {
            const nav = document.getElementById('mobile-menu');
            const btn = document.getElementById('hamburger');
            if (mobileOpen && !nav.contains(e.target) && !btn.contains(e.target)) {
                toggleMobileMenu();
            }
        });

        // ── Toast System ──────────────────────────────────────────
        const toastColors = {
            success: { bg: '#f0fdf4', border: '#bbf7d0', icon: '#16a34a', progress: '#16a34a', title: 'Success' },
            error:   { bg: '#fef2f2', border: '#fecaca', icon: '#dc2626', progress: '#dc2626', title: 'Error'   },
            warning: { bg: '#fffbeb', border: '#fde68a', icon: '#d97706', progress: '#d97706', title: 'Warning' },
            info:    { bg: '#eff6ff', border: '#bfdbfe', icon: '#2563eb', progress: '#2563eb', title: 'Info'    },
        };

        function showToast(type, message, duration = 4500) {
            const c  = toastColors[type] || toastColors.info;
            const id = 'toast-' + Date.now();
            const icons = {
                success: `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`,
                error:   `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>`,
                warning: `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/></svg>`,
                info:    `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            };
            const el = document.createElement('div');
            el.className = 'toast';
            el.id = id;
            el.style.background  = c.bg;
            el.style.borderColor = c.border;
            el.innerHTML = `
                <div class="toast-icon" style="background:${c.icon}20; color:${c.icon}">${icons[type]}</div>
                <div class="flex-1 min-w-0">
                    <p class="toast-title">${c.title}</p>
                    <p class="toast-msg">${message}</p>
                </div>
                <button class="toast-close" onclick="dismissToast('${id}')">&times;</button>
                <div class="toast-progress" style="background:${c.progress}; animation-duration:${duration}ms;"></div>
            `;
            document.getElementById('toast-container').appendChild(el);
            requestAnimationFrame(() => { requestAnimationFrame(() => el.classList.add('show')); });
            setTimeout(() => dismissToast(id), duration);
        }

        function dismissToast(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.remove('show');
            el.classList.add('hide');
            setTimeout(() => el.remove(), 350);
        }

        if (__flash.success) showToast('success', __flash.success);
        if (__flash.error)   showToast('error',   __flash.error);
        if (__flash.warning) showToast('warning', __flash.warning);
        if (__flash.info)    showToast('info',    __flash.info);

        // ── Bell / Notification Panel ──────────────────────────────
        let notifOpen = false;

        function toggleNotifPanel() {
            const panel = document.getElementById('notif-panel');
            notifOpen = !notifOpen;
            notifOpen ? panel.classList.remove('hidden') : panel.classList.add('hidden');
        }

        function clearAllNotifs() {
            document.getElementById('notif-list').innerHTML = `
                <div class="px-4 py-10 text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-500">All clear!</p>
                    <p class="text-xs text-gray-400 mt-1">No alerts right now</p>
                </div>`;
            const badge = document.querySelector('#bell-btn span');
            if (badge) badge.remove();
        }

        document.addEventListener('click', function(e) {
            const bell  = document.getElementById('bell-btn');
            const panel = document.getElementById('notif-panel');
            if (notifOpen && !bell.contains(e.target) && !panel.contains(e.target)) {
                panel.classList.add('hidden');
                notifOpen = false;
            }
        });

        // Delegated handler for notification item clicks (data-href)
        document.getElementById('notif-list').addEventListener('click', function(e) {
            const item = e.target.closest('[data-href]');
            if (item) window.location = item.dataset.href;
        });

        // ── Active nav highlight ───────────────────────────────────
        document.querySelectorAll('.nav-link').forEach(link => {
            if (link.href === window.location.href || window.location.pathname.startsWith(new URL(link.href).pathname)) {
                link.classList.add('active');
            }
        });
    </script>
</body>
</html>