@extends('app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

    .mr-page * { font-family: 'DM Sans', sans-serif; box-sizing: border-box; }
    .mr-mono { font-family: 'DM Mono', monospace; }

    .mr-page {
        min-height: 100vh;
        background: #f7f6f3;
        background-image:
            radial-gradient(circle at 15% 0%, rgba(220,38,38,.07) 0%, transparent 55%),
            radial-gradient(circle at 90% 85%, rgba(220,38,38,.04) 0%, transparent 50%);
        padding: 2.5rem 1rem;
    }

    .mr-wrap { max-width: 960px; margin: 0 auto; }

    /* ── Breadcrumb ── */
    .mr-breadcrumb {
        display: flex; align-items: center; gap: .5rem;
        margin-bottom: 2rem; color: #9e9b95; font-size: .8125rem;
    }
    .mr-breadcrumb a { color: #9e9b95; text-decoration: none; transition: color .15s; }
    .mr-breadcrumb a:hover { color: #111; }
    .mr-breadcrumb svg { width: 14px; height: 14px; }

    /* ── Page header ── */
    .mr-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 1.75rem; gap: 1rem;
    }
    .mr-header-left { display: flex; align-items: center; gap: 1rem; }
    .mr-icon {
        width: 52px; height: 52px; border-radius: 14px;
        background: #dc2626;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; box-shadow: 0 4px 14px rgba(220,38,38,.3);
    }
    .mr-icon svg { width: 22px; height: 22px; color: #fff; }
    .mr-title { font-size: 1.5rem; font-weight: 600; color: #111; letter-spacing: -.02em; line-height: 1.2; }
    .mr-badge-id {
        display: inline-flex; align-items: center; margin-top: .35rem;
        background: #111; color: #fff; font-size: .7rem; font-weight: 500;
        letter-spacing: .06em; text-transform: uppercase; padding: .2rem .55rem;
        border-radius: 5px; font-family: 'DM Mono', monospace;
    }

    .mr-back-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .55rem 1.1rem; border-radius: 10px;
        font-size: .8125rem; font-weight: 600;
        text-decoration: none; color: #444;
        background: #fff; border: 1px solid #e0ddd8;
        transition: all .15s; white-space: nowrap; flex-shrink: 0;
    }
    .mr-back-btn:hover { background: #f5f4f1; border-color: #ccc; }
    .mr-back-btn svg { width: 14px; height: 14px; }

    /* ── Layout grid ── */
    .mr-grid {
        display: grid;
        grid-template-columns: 1fr 272px;
        gap: 1.25rem;
        align-items: start;
    }
    @media (max-width: 700px) {
        .mr-grid { grid-template-columns: 1fr; }
        .mr-header { flex-direction: column; }
    }

    /* ── Card ── */
    .mr-card {
        background: #fff;
        border: 1px solid #e8e6e1;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 16px rgba(0,0,0,.04);
    }

    /* ── Banner ── */
    .mr-banner {
        background: #dc2626;
        padding: 1.5rem 1.5rem 3.25rem;
        position: relative; overflow: hidden;
    }
    .mr-banner::before {
        content: '';
        position: absolute; top: -50px; right: -50px;
        width: 200px; height: 200px;
        border-radius: 50%; background: rgba(255,255,255,.06);
    }
    .mr-banner::after {
        content: '';
        position: absolute; bottom: -30px; left: 25%;
        width: 140px; height: 140px;
        border-radius: 50%; background: rgba(255,255,255,.04);
    }
    .mr-banner-inner {
        position: relative;
        display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem;
    }
    .mr-banner-icon {
        width: 52px; height: 52px; border-radius: 14px;
        background: rgba(255,255,255,.18); border: 1.5px solid rgba(255,255,255,.25);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .mr-banner-icon svg { width: 24px; height: 24px; color: #fff; }
    .mr-banner-title { font-size: 1.2rem; font-weight: 700; color: #fff; letter-spacing: -.02em; }
    .mr-banner-sub {
        display: flex; align-items: center; gap: .5rem; margin-top: .4rem;
    }
    .mr-banner-label { font-size: .8125rem; color: rgba(255,255,255,.6); }
    .mr-banner-rec {
        font-family: 'DM Mono', monospace; font-size: .7rem; font-weight: 500;
        background: rgba(255,255,255,.18); color: rgba(255,255,255,.9);
        padding: .15rem .5rem; border-radius: 5px;
        border: 1px solid rgba(255,255,255,.2); letter-spacing: .04em;
    }
    .mr-issue-badge {
        display: inline-flex; align-items: center; gap: .4rem;
        background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
        color: #fff; font-size: .75rem; font-weight: 600;
        padding: .3rem .85rem; border-radius: 99px; flex-shrink: 0;
    }
    .mr-issue-dot { width: 6px; height: 6px; border-radius: 50%; background: #fca5a5; }

    /* ── Floating info grid ── */
    .mr-info-grid {
        position: relative; z-index: 2;
        margin: -2rem 1rem 0;
        background: #fff;
        border: 1px solid #e8e6e1;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        display: grid; grid-template-columns: 1fr 1fr;
    }
    .mr-info-cell {
        padding: 1rem 1.25rem;
        border-right: 1px solid #f0ede8;
        border-bottom: 1px solid #f0ede8;
        transition: background .12s;
    }
    .mr-info-cell:hover { background: #fdf9f9; }
    .mr-info-cell:nth-child(2n) { border-right: none; }
    .mr-info-cell.full { grid-column: 1 / -1; border-right: none; }
    .mr-info-cell:last-child { border-bottom: none; }
    .mr-info-label {
        font-size: .7rem; font-weight: 600; letter-spacing: .07em;
        text-transform: uppercase; color: #b0ada7; margin-bottom: .4rem;
        display: flex; align-items: center; gap: .35rem;
    }
    .mr-info-label svg { width: 11px; height: 11px; }
    .mr-info-value { font-size: .9rem; font-weight: 600; color: #111; }
    .mr-info-sub { font-size: .75rem; color: #9e9b95; margin-top: .15rem; }

    .mr-plate {
        font-family: 'DM Mono', monospace; font-size: .875rem; font-weight: 500;
        background: #f5f4f1; border: 1px solid #e8e6e1;
        padding: .15rem .55rem; border-radius: 5px; letter-spacing: .04em; color: #111;
        display: inline-block;
    }
    .mr-issue-pill {
        display: inline-flex; align-items: center;
        background: #fffbeb; border: 1px solid #fde68a;
        color: #92400e; font-size: .8rem; font-weight: 600;
        padding: .25rem .75rem; border-radius: 8px;
    }
    .mr-cost-val {
        font-family: 'DM Mono', monospace;
        font-size: .9rem; font-weight: 400; color: #6b6860; letter-spacing: .01em;
    }

    /* ── Action bar ── */
    .mr-actions {
        display: flex; align-items: center; gap: .625rem;
        padding: 1rem 1.25rem 1.25rem; flex-wrap: wrap;
    }
    .mr-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem 1.1rem; border-radius: 10px;
        font-size: .8125rem; font-weight: 600; cursor: pointer;
        border: none; text-decoration: none; transition: all .15s;
        font-family: 'DM Sans', sans-serif; white-space: nowrap;
    }
    .mr-btn svg { width: 14px; height: 14px; flex-shrink: 0; }
    .mr-btn-pdf  { background: #fff5f5; color: #dc2626; border: 1px solid #fecaca; }
    .mr-btn-pdf:hover { background: #fee2e2; }
    .mr-btn-edit { background: #111; color: #fff; }
    .mr-btn-edit:hover { background: #333; }
    .mr-btn-del  { background: #fff5f5; color: #dc2626; border: 1px solid #fecaca; margin-left: auto; }
    .mr-btn-del:hover { background: #fee2e2; }

    /* ── Sidebar ── */
    .mr-side { display: flex; flex-direction: column; gap: 1rem; }

    .mr-side-card {
        background: #fff;
        border: 1px solid #e8e6e1;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
        transition: box-shadow .2s;
    }
    .mr-side-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.07); }

    .mr-side-header {
        padding: .75rem 1.25rem;
        border-bottom: 1px solid #f0ede8;
        font-size: .7rem; font-weight: 600; letter-spacing: .08em;
        text-transform: uppercase; color: #9e9b95;
        display: flex; align-items: center; gap: .5rem;
    }
    .mr-side-hicon {
        width: 20px; height: 20px; border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
    }
    .mr-side-hicon svg { width: 11px; height: 11px; }

    .mr-side-row {
        display: flex; align-items: flex-start; gap: .75rem;
        padding: .875rem 1.25rem;
        border-bottom: 1px solid #f7f6f3;
        transition: background .12s;
    }
    .mr-side-row:last-child { border-bottom: none; }
    .mr-side-row:hover { background: #fdf9f9; }
    .mr-side-icon {
        width: 30px; height: 30px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: .1rem;
    }
    .mr-side-icon svg { width: 13px; height: 13px; }
    .mr-side-lbl { font-size: .72rem; color: #b0ada7; font-weight: 500; margin-bottom: .2rem; }
    .mr-side-val { font-size: .8375rem; font-weight: 600; color: #111; line-height: 1.3; }
    .mr-side-sub { font-size: .72rem; color: #b0ada7; margin-top: .1rem; }

    /* quick actions */
    .mr-qa-wrap { padding: .75rem; display: flex; flex-direction: column; gap: .4rem; }
    .mr-qa-btn {
        display: flex; align-items: center; gap: .75rem;
        padding: .65rem 1rem; border-radius: 10px;
        font-size: .8125rem; font-weight: 500; text-decoration: none; cursor: pointer;
        border: 1px solid transparent; transition: all .15s; width: 100%;
        font-family: 'DM Sans', sans-serif; background: none;
    }
    .mr-qa-icon { width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .mr-qa-icon svg { width: 13px; height: 13px; }
    .mr-qa-pdf   { background: #fff5f5; border-color: #fecaca; color: #991b1b; }
    .mr-qa-pdf:hover { background: #fee2e2; }
    .mr-qa-edit  { background: #f5f4f1; border-color: #e0ddd8; color: #333; }
    .mr-qa-edit:hover { background: #eae8e3; }
    .mr-qa-list  { background: #fdf2f2; border-color: #fecaca; color: #991b1b; }
    .mr-qa-list:hover { background: #fee2e2; }
    .mr-qa-del   { background: #fff1f2; border-color: #fecdd3; color: #be123c; }
    .mr-qa-del:hover { background: #ffe4e6; }

    /* ── Delete modal ── */
    .mr-modal-bg {
        position: fixed; inset: 0; z-index: 50;
        display: none; align-items: center; justify-content: center;
        padding: 1rem;
        background: rgba(0,0,0,.45); backdrop-filter: blur(4px);
    }
    .mr-modal-bg.open { display: flex; }
    .mr-modal-box {
        background: #fff; border-radius: 20px;
        width: 100%; max-width: 360px; padding: 2rem;
        transform: scale(.95); opacity: 0;
        transition: all .2s;
        box-shadow: 0 20px 60px rgba(0,0,0,.2);
    }
    .mr-modal-box.open { transform: scale(1); opacity: 1; }
    .mr-modal-icon {
        width: 56px; height: 56px; border-radius: 16px;
        background: #fff1f2; border: 1px solid #fecdd3;
        display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;
    }
    .mr-modal-icon svg { width: 24px; height: 24px; color: #dc2626; }
    .mr-modal-title { font-size: 1.05rem; font-weight: 700; color: #111; text-align: center; margin-bottom: .5rem; }
    .mr-modal-sub   { font-size: .8375rem; color: #9e9b95; text-align: center; margin-bottom: 1.5rem; line-height: 1.5; }
    .mr-modal-actions { display: flex; gap: .625rem; }
    .mr-modal-cancel {
        flex: 1; padding: .65rem; border-radius: 10px; font-size: .875rem; font-weight: 600;
        background: #f5f4f1; color: #444; border: none; cursor: pointer; transition: background .15s;
        font-family: 'DM Sans', sans-serif;
    }
    .mr-modal-cancel:hover { background: #eae8e3; }
    .mr-modal-confirm {
        flex: 1; padding: .65rem; border-radius: 10px; font-size: .875rem; font-weight: 600;
        background: #dc2626; color: #fff; border: none; cursor: pointer; transition: background .15s;
        box-shadow: 0 4px 12px rgba(220,38,38,.25);
        font-family: 'DM Sans', sans-serif;
    }
    .mr-modal-confirm:hover { background: #b91c1c; }
</style>

<div class="mr-page">
<div class="mr-wrap">

    {{-- Breadcrumb --}}
    <nav class="mr-breadcrumb">
        <a href="{{ route('maintenance_records.index') }}">Maintenance</a>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span>Record #{{ str_pad($maintenance_record->id, 4, '0', STR_PAD_LEFT) }}</span>
    </nav>

    {{-- Page header --}}
    <div class="mr-header">
        <div class="mr-header-left">
            <div class="mr-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/>
                </svg>
            </div>
            <div>
                <div class="mr-title">Maintenance Record</div>
                <span class="mr-badge-id">#{{ str_pad($maintenance_record->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        <a href="{{ route('maintenance_records.index') }}" class="mr-back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back
        </a>
    </div>

    <div class="mr-grid">

        {{-- MAIN --}}
        <div>
            <div class="mr-card">

                {{-- Banner --}}
                <div class="mr-banner">
                    <div class="mr-banner-inner">
                        <div style="display:flex;align-items:center;gap:1rem">
                            <div class="mr-banner-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75"/>
                                </svg>
                            </div>
                            <div>
                                <div class="mr-banner-title">{{ $maintenance_record->vehicle->plate_number ?? 'N/A' }}</div>
                                <div class="mr-banner-sub">
                                    <span class="mr-banner-label">{{ $maintenance_record->vehicle->make ?? '' }} {{ $maintenance_record->vehicle->model ?? '' }}</span>
                                    <span style="color:rgba(255,255,255,.3);font-size:.7rem">·</span>
                                    <span class="mr-banner-rec">#{{ str_pad($maintenance_record->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mr-issue-badge">
                            <span class="mr-issue-dot"></span>
                            {{ $maintenance_record->issue }}
                        </div>
                    </div>
                </div>

                {{-- Floating info grid --}}
                <div class="mr-info-grid">

                    <div class="mr-info-cell">
                        <div class="mr-info-label">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                            Vehicle
                        </div>
                        <span class="mr-plate">{{ $maintenance_record->vehicle->plate_number ?? 'N/A' }}</span>
                        <div class="mr-info-sub">{{ $maintenance_record->vehicle->make ?? '' }} {{ $maintenance_record->vehicle->model ?? '' }}</div>
                    </div>

                    <div class="mr-info-cell">
                        <div class="mr-info-label">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                            Issue
                        </div>
                        <span class="mr-issue-pill">{{ $maintenance_record->issue }}</span>
                    </div>

                    <div class="mr-info-cell">
                        <div class="mr-info-label">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/></svg>
                            Service Date
                        </div>
                        <div class="mr-info-value">{{ $maintenance_record->service_date->format('M d, Y') }}</div>
                        <div class="mr-info-sub">{{ $maintenance_record->service_date->diffForHumans() }}</div>
                    </div>

                    <div class="mr-info-cell">
                        <div class="mr-info-label">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                            Technician
                        </div>
                        <div class="mr-info-value">{{ $maintenance_record->technician_name }}</div>
                    </div>

                    <div class="mr-info-cell full">
                        <div class="mr-info-label">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Cost
                        </div>
                        <span class="mr-cost-val">${{ number_format($maintenance_record->cost, 2) }}</span>
                    </div>

                </div>

                {{-- Actions --}}
                <div class="mr-actions">
                    <a href="{{ route('maintenance_records.pdf', $maintenance_record->id) }}" class="mr-btn mr-btn-pdf">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Export PDF
                    </a>
                    <a href="{{ route('maintenance_records.edit', $maintenance_record->id) }}" class="mr-btn mr-btn-edit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                        Edit Record
                    </a>
                    <button type="button" onclick="openDelModal()" class="mr-btn mr-btn-del">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                        Delete
                    </button>
                    <form id="del-form" action="{{ route('maintenance_records.destroy', $maintenance_record->id) }}" method="POST" style="display:none">
                        @csrf @method('DELETE')
                    </form>
                </div>

            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="mr-side">

            {{-- Record Info --}}
            <div class="mr-side-card">
                <div class="mr-side-header">
                    <div class="mr-side-hicon" style="background:#fff5f5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    Record Info
                </div>

                <div class="mr-side-row">
                    <div class="mr-side-icon" style="background:#eff6ff">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#3b82f6" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5"/></svg>
                    </div>
                    <div>
                        <div class="mr-side-lbl">Date Added</div>
                        <div class="mr-side-val">{{ $maintenance_record->created_at->format('M d, Y') }}</div>
                        <div class="mr-side-sub">{{ $maintenance_record->created_at->format('h:i A') }}</div>
                    </div>
                </div>

                <div class="mr-side-row">
                    <div class="mr-side-icon" style="background:#faf5ff">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#a855f7" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                    </div>
                    <div>
                        <div class="mr-side-lbl">Last Updated</div>
                        <div class="mr-side-val">{{ $maintenance_record->updated_at->format('M d, Y') }}</div>
                        <div class="mr-side-sub">{{ $maintenance_record->updated_at->format('h:i A') }}</div>
                    </div>
                </div>

                <div class="mr-side-row">
                    <div class="mr-side-icon" style="background:#f5f4f1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#6b6860" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                    </div>
                    <div>
                        <div class="mr-side-lbl">Record ID</div>
                        <div class="mr-side-val mr-mono" style="color:#9e9b95">#{{ str_pad($maintenance_record->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>
            </div>

            {{-- Vehicle Info --}}
            <div class="mr-side-card">
                <div class="mr-side-header">
                    <div class="mr-side-hicon" style="background:#fffbeb">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#d97706" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                    </div>
                    Vehicle
                </div>

                <div class="mr-side-row">
                    <div class="mr-side-icon" style="background:#fff5f5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                    </div>
                    <div>
                        <div class="mr-side-lbl">Plate Number</div>
                        <span class="mr-plate" style="font-size:.8rem">{{ $maintenance_record->vehicle->plate_number ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="mr-side-row">
                    <div class="mr-side-icon" style="background:#f5f4f1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#6b6860" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                    </div>
                    <div>
                        <div class="mr-side-lbl">Make & Model</div>
                        <div class="mr-side-val">{{ $maintenance_record->vehicle->make ?? 'N/A' }} {{ $maintenance_record->vehicle->model ?? '' }}</div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="mr-side-card">
                <div class="mr-side-header">
                    <div class="mr-side-hicon" style="background:#f5f4f1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#6b6860" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                    </div>
                    Quick Actions
                </div>
                <div class="mr-qa-wrap">
                    <a href="{{ route('maintenance_records.pdf', $maintenance_record->id) }}" class="mr-qa-btn mr-qa-pdf">
                        <div class="mr-qa-icon" style="background:#fee2e2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        Export PDF
                    </a>
                    <a href="{{ route('maintenance_records.edit', $maintenance_record->id) }}" class="mr-qa-btn mr-qa-edit">
                        <div class="mr-qa-icon" style="background:#eae8e3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#444" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                        </div>
                        Edit record
                    </a>
                    <a href="{{ route('maintenance_records.index') }}" class="mr-qa-btn mr-qa-list">
                        <div class="mr-qa-icon" style="background:#fee2e2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 000 4h6a2 2 0 000-4M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        All records
                    </a>
                    <button type="button" onclick="openDelModal()" class="mr-qa-btn mr-qa-del">
                        <div class="mr-qa-icon" style="background:#ffe4e6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                        </div>
                        Delete record
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>
</div>

{{-- Delete Modal --}}
<div id="del-modal" class="mr-modal-bg" onclick="if(event.target===this)closeDelModal()">
    <div id="del-box" class="mr-modal-box">
        <div class="mr-modal-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
        </div>
        <div class="mr-modal-title">Delete Record?</div>
        <p class="mr-modal-sub">Permanently delete record <strong style="color:#111">#{{ str_pad($maintenance_record->id, 4, '0', STR_PAD_LEFT) }}</strong>? This action cannot be undone.</p>
        <div class="mr-modal-actions">
            <button onclick="closeDelModal()" class="mr-modal-cancel">Cancel</button>
            <button onclick="document.getElementById('del-form').submit()" class="mr-modal-confirm">Yes, Delete</button>
        </div>
    </div>
</div>

<script>
function openDelModal() {
    const m = document.getElementById('del-modal'), b = document.getElementById('del-box');
    m.classList.add('open');
    setTimeout(() => b.classList.add('open'), 10);
}
function closeDelModal() {
    const m = document.getElementById('del-modal'), b = document.getElementById('del-box');
    b.classList.remove('open');
    setTimeout(() => m.classList.remove('open'), 200);
}
</script>

@endsection