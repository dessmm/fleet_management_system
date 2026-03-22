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
            radial-gradient(circle at 15% 0%, rgba(220,38,38,.06) 0%, transparent 55%),
            radial-gradient(circle at 90% 85%, rgba(220,38,38,.04) 0%, transparent 50%);
        padding: 2.5rem 2rem;
    }

    .mr-wrap { max-width: 1400px; margin: 0 auto; }

    /* ── Breadcrumb ── */
    .mr-breadcrumb {
        display: flex; align-items: center; gap: .5rem;
        margin-bottom: 2rem; color: #9e9b95; font-size: .8125rem;
    }
    .mr-breadcrumb a { color: #9e9b95; text-decoration: none; transition: color .15s; }
    .mr-breadcrumb a:hover { color: #111; }
    .mr-breadcrumb svg { width: 14px; height: 14px; }

    /* ── Header ── */
    .mr-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.75rem; gap: 1rem; flex-wrap: wrap;
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
    .mr-subtitle { font-size: .8125rem; color: #9e9b95; margin-top: .2rem; }

    .mr-add-btn {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .6rem 1.25rem; border-radius: 11px;
        font-size: .8125rem; font-weight: 600; text-decoration: none;
        background: #dc2626; color: #fff;
        box-shadow: 0 4px 14px rgba(220,38,38,.3);
        transition: all .15s; white-space: nowrap;
    }
    .mr-add-btn:hover { background: #b91c1c; box-shadow: 0 6px 18px rgba(220,38,38,.35); transform: translateY(-1px); }
    .mr-add-btn svg { width: 15px; height: 15px; }

    /* ── Stat cards ── */
    .mr-stats {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 1rem; margin-bottom: 1.5rem;
    }
    @media (max-width: 640px) { .mr-stats { grid-template-columns: repeat(2, 1fr); } }

    .mr-stat {
        background: #fff; border: 1px solid #e8e6e1;
        border-radius: 16px; padding: 1.1rem 1.25rem;
        display: flex; align-items: center; gap: .875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
        transition: box-shadow .2s, transform .2s;
    }
    .mr-stat:hover { box-shadow: 0 6px 20px rgba(0,0,0,.08); transform: translateY(-2px); }
    .mr-stat-icon {
        width: 40px; height: 40px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .mr-stat-icon svg { width: 18px; height: 18px; }
    .mr-stat-num { font-size: 1.6rem; font-weight: 700; color: #111; letter-spacing: -.03em; line-height: 1; }
    .mr-stat-lbl { font-size: .75rem; color: #9e9b95; font-weight: 500; margin-top: .2rem; }

    /* ── Main card ── */
    .mr-card {
        background: #fff;
        border: 1px solid #e8e6e1;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 16px rgba(0,0,0,.04);
    }
    .mr-card-header {
        padding: .875rem 1.5rem;
        border-bottom: 1px solid #f0ede8;
        display: flex; align-items: center; gap: .75rem; flex-wrap: wrap;
    }
    .mr-card-title { font-size: .8125rem; font-weight: 600; color: #333; }
    .mr-count {
        display: inline-flex; align-items: center;
        background: #fff5f5; border: 1px solid #fecaca;
        color: #dc2626; font-size: .7rem; font-weight: 700;
        padding: .15rem .55rem; border-radius: 99px;
        font-family: 'DM Mono', monospace;
    }

    /* filter tabs */
    .mr-filters { display: flex; align-items: center; gap: .4rem; }
    .mr-filter-btn {
        padding: .35rem .8rem; border-radius: 8px;
        font-size: .75rem; font-weight: 600; cursor: pointer;
        border: 1px solid #e8e6e1; background: #fff; color: #6b6860;
        transition: all .15s; font-family: 'DM Sans', sans-serif;
    }
    .mr-filter-btn:hover { background: #f5f4f1; }
    .mr-filter-btn.active { background: #111; color: #fff; border-color: #111; }
    .mr-filter-btn.active-amber { background: #fffbeb; color: #92400e; border-color: #fde68a; }
    .mr-filter-btn.active-green { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }

    /* search */
    .mr-search-wrap { margin-left: auto; position: relative; }
    .mr-search-wrap svg { position: absolute; left: .75rem; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: #b0ada7; pointer-events: none; }
    .mr-search {
        padding: .5rem .875rem .5rem 2.25rem;
        font-size: .8125rem; background: #fafaf8;
        border: 1px solid #e8e6e1; border-radius: 9px;
        color: #333; width: 200px; font-family: 'DM Sans', sans-serif;
        transition: all .15s;
    }
    .mr-search::placeholder { color: #c0bdb8; }
    .mr-search:focus { outline: none; background: #fff; border-color: #fca5a5; box-shadow: 0 0 0 3px rgba(252,165,165,.2); width: 240px; }

    /* ── Table ── */
    .mr-table { width: 100%; border-collapse: collapse; }
    .mr-table thead tr { background: #fafaf8; border-bottom: 1px solid #f0ede8; }
    .mr-table th {
        padding: .75rem 1.25rem; text-align: left;
        font-size: .7rem; font-weight: 600; letter-spacing: .07em;
        text-transform: uppercase; color: #b0ada7; white-space: nowrap;
    }
    .mr-table th:last-child { text-align: right; }
    .mr-table tbody tr { border-bottom: 1px solid #f7f6f3; transition: background .12s; }
    .mr-table tbody tr:last-child { border-bottom: none; }
    .mr-table tbody tr:hover { background: #fdf9f9; }
    .mr-table td { padding: .875rem 1.25rem; vertical-align: middle; }

    /* ── Record ID badge ── */
    .mr-rec-id {
        font-family: 'DM Mono', monospace; font-size: .72rem; font-weight: 500;
        background: #fff5f5; border: 1px solid #fecaca;
        color: #9a3412; padding: .2rem .55rem; border-radius: 5px;
        letter-spacing: .04em; display: inline-block;
    }

    /* ── Vehicle cell ── */
    .mr-veh-icon {
        width: 32px; height: 32px; border-radius: 9px;
        background: #eff6ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .mr-veh-icon svg { width: 14px; height: 14px; color: #3b82f6; }
    .mr-plate {
        font-family: 'DM Mono', monospace; font-size: .8rem; font-weight: 500;
        background: #f5f4f1; border: 1px solid #e8e6e1;
        color: #111; padding: .15rem .5rem; border-radius: 5px; letter-spacing: .04em;
        display: inline-block;
    }
    .mr-veh-sub { font-size: .72rem; color: #b0ada7; margin-top: .2rem; }

    /* ── Issue pill ── */
    .mr-issue {
        display: inline-flex; align-items: center;
        background: #fffbeb; border: 1px solid #fde68a;
        color: #92400e; font-size: .75rem; font-weight: 600;
        padding: .2rem .65rem; border-radius: 7px;
    }

    /* ── Date ── */
    .mr-date-primary { font-size: .8375rem; font-weight: 500; color: #333; }
    .mr-date-sub { font-size: .72rem; color: #b0ada7; margin-top: .15rem; }

    /* ── Technician ── */
    .mr-tech-avatar {
        width: 28px; height: 28px; border-radius: 50%;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: .65rem; font-weight: 700; flex-shrink: 0;
    }
    .mr-tech-name { font-size: .8375rem; color: #444; }

    /* ── Cost ── */
    .mr-cost { font-family: 'DM Mono', monospace; font-size: .875rem; font-weight: 500; color: #6b6860; }

    /* ── Status pills ── */
    .mr-status {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .72rem; font-weight: 600;
        padding: .25rem .7rem; border-radius: 99px;
        border: 1px solid transparent;
    }
    .mr-status-dot { width: 5px; height: 5px; border-radius: 50%; }
    .mr-status-done { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
    .mr-status-done .mr-status-dot { background: #22c55e; }
    .mr-status-active { background: #fffbeb; border-color: #fde68a; color: #92400e; }
    .mr-status-active .mr-status-dot { background: #f59e0b; animation: pulse-dot 2s ease-in-out infinite; }
    @keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:.4} }
    .mr-status-date { font-size: .68rem; color: #b0ada7; margin-top: .2rem; }

    /* ── Action buttons ── */
    .mr-actions { display: flex; align-items: center; justify-content: flex-end; gap: .4rem; }
    .mr-btn {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .4rem .8rem; border-radius: 8px;
        font-size: .75rem; font-weight: 600; text-decoration: none; cursor: pointer;
        border: 1px solid transparent; transition: all .15s;
        font-family: 'DM Sans', sans-serif; white-space: nowrap;
    }
    .mr-btn svg { width: 12px; height: 12px; flex-shrink: 0; }
    .mr-btn-done { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
    .mr-btn-done:hover { background: #dcfce7; }
    .mr-btn-view { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
    .mr-btn-view:hover { background: #dbeafe; }
    .mr-btn-edit { background: #fffbeb; border-color: #fde68a; color: #92400e; }
    .mr-btn-edit:hover { background: #fef3c7; }
    .mr-btn-del  { background: #fff5f5; border-color: #fecaca; color: #dc2626; }
    .mr-btn-del:hover { background: #fee2e2; }

    /* ── Footer ── */
    .mr-footer {
        padding: .75rem 1.5rem; border-top: 1px solid #f0ede8;
        background: #fafaf8; display: flex; align-items: center; justify-content: space-between;
    }
    .mr-footer-text { font-size: .72rem; color: #b0ada7; }

    /* ── Empty state ── */
    .mr-empty {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; padding: 5rem 2rem; text-align: center;
    }
    .mr-empty-icon {
        width: 72px; height: 72px; border-radius: 20px;
        background: #fff5f5; border: 1px solid #fecaca;
        display: flex; align-items: center; justify-content: center; margin-bottom: 1.25rem;
    }
    .mr-empty-icon svg { width: 30px; height: 30px; color: #f87171; }
    .mr-empty-title { font-size: 1rem; font-weight: 600; color: #333; margin-bottom: .4rem; }
    .mr-empty-sub { font-size: .8375rem; color: #9e9b95; max-width: 280px; line-height: 1.5; margin-bottom: 1.5rem; }

    /* ── Delete modal ── */
    .mr-modal-bg {
        position: fixed; inset: 0; z-index: 50;
        display: none; align-items: center; justify-content: center;
        padding: 1rem; background: rgba(0,0,0,.45); backdrop-filter: blur(4px);
    }
    .mr-modal-bg.open { display: flex; }
    .mr-modal-box {
        background: #fff; border-radius: 20px;
        width: 100%; max-width: 360px; padding: 2rem;
        transform: scale(.95); opacity: 0; transition: all .2s;
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
        box-shadow: 0 4px 12px rgba(220,38,38,.25); font-family: 'DM Sans', sans-serif;
    }
    .mr-modal-confirm:hover { background: #b91c1c; }
</style>

@php
    $total     = count($maintenance_records);
    $active    = $maintenance_records->whereNull('completed_at')->count();
    $completed = $maintenance_records->whereNotNull('completed_at')->count();
    $totalCost = $maintenance_records->sum('cost');
@endphp

<div class="mr-page">
<div class="mr-wrap">

    {{-- Breadcrumb --}}
    <nav class="mr-breadcrumb">
        <a href="/">Home</a>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span>Maintenance</span>
    </nav>

    {{-- Header --}}
    <div class="mr-header">
        <div class="mr-header-left">
            <div class="mr-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75"/>
                </svg>
            </div>
            <div>
                <div class="mr-title">Maintenance Records</div>
                <div class="mr-subtitle">Track repairs, service schedules, and maintenance costs</div>
            </div>
        </div>
        <a href="{{ route('maintenance_records.create') }}" class="mr-add-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Add Record
        </a>
    </div>

    {{-- Stats --}}
    <div class="mr-stats">
        <div class="mr-stat">
            <div class="mr-stat-icon" style="background:#fff5f5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <div class="mr-stat-num">{{ $total }}</div>
                <div class="mr-stat-lbl">Total Records</div>
            </div>
        </div>
        <div class="mr-stat">
            <div class="mr-stat-icon" style="background:#fffbeb">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#d97706" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63"/></svg>
            </div>
            <div>
                <div class="mr-stat-num">{{ $active }}</div>
                <div class="mr-stat-lbl">In Progress</div>
            </div>
        </div>
        <div class="mr-stat">
            <div class="mr-stat-icon" style="background:#f0fdf4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="mr-stat-num">{{ $completed }}</div>
                <div class="mr-stat-lbl">Completed</div>
            </div>
        </div>
        <div class="mr-stat">
            <div class="mr-stat-icon" style="background:#eff6ff">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#3b82f6" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="mr-stat-num" style="font-size:1.2rem">${{ number_format($totalCost, 0) }}</div>
                <div class="mr-stat-lbl">Total Cost</div>
            </div>
        </div>
    </div>

    {{-- Table card --}}
    <div class="mr-card">
        <div class="mr-card-header">
            <span class="mr-card-title">Service History</span>
            <span class="mr-count">{{ $total }}</span>

            {{-- Filter tabs --}}
            <div class="mr-filters">
                <button class="mr-filter-btn active" data-filter="all" onclick="mrFilter('all', this)">All</button>
                <button class="mr-filter-btn" data-filter="active" onclick="mrFilter('active', this)">🔧 In Progress</button>
                <button class="mr-filter-btn" data-filter="completed" onclick="mrFilter('completed', this)">✓ Completed</button>
            </div>

            <div class="mr-search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                <input id="mr-search" type="text" placeholder="Search records…" class="mr-search">
            </div>
        </div>

        @if($total > 0)
        <div style="overflow-x:auto">
            <table class="mr-table" id="mr-table">
                <thead>
                    <tr>
                        <th>Record</th>
                        <th>Vehicle</th>
                        <th>Issue</th>
                        <th>Service Date</th>
                        <th>Technician</th>
                        <th>Cost</th>
                        <th>Status</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($maintenance_records as $record)
                    @php
                        $initials = collect(explode(' ', $record->technician_name))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode('');
                    @endphp
                    <tr data-status="{{ $record->completed_at ? 'completed' : 'active' }}"
                        data-search="{{ strtolower(($record->vehicle->plate_number ?? '').' '.($record->issue ?? '').' '.($record->technician_name ?? '')) }}">

                        {{-- Record ID --}}
                        <td><span class="mr-rec-id">#{{ str_pad($record->id, 4, '0', STR_PAD_LEFT) }}</span></td>

                        {{-- Vehicle --}}
                        <td>
                            <div style="display:flex;align-items:center;gap:.625rem">
                                <div class="mr-veh-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                                </div>
                                <div>
                                    <span class="mr-plate">{{ $record->vehicle->plate_number ?? 'N/A' }}</span>
                                    <div class="mr-veh-sub">{{ $record->vehicle->make ?? '' }} {{ $record->vehicle->model ?? '' }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Issue --}}
                        <td><span class="mr-issue">{{ $record->issue }}</span></td>

                        {{-- Service Date --}}
                        <td>
                            <div class="mr-date-primary">{{ $record->service_date->format('M d, Y') }}</div>
                            <div class="mr-date-sub">{{ $record->service_date->diffForHumans() }}</div>
                        </td>

                        {{-- Technician --}}
                        <td>
                            <div style="display:flex;align-items:center;gap:.5rem">
                                <div class="mr-tech-avatar">{{ $initials }}</div>
                                <span class="mr-tech-name">{{ $record->technician_name }}</span>
                            </div>
                        </td>

                        {{-- Cost --}}
                        <td><span class="mr-cost">${{ number_format($record->cost, 2) }}</span></td>

                        {{-- Status --}}
                        <td>
                            @if($record->completed_at)
                                <span class="mr-status mr-status-done"><span class="mr-status-dot"></span>Completed</span>
                                <div class="mr-status-date">{{ $record->completed_at->format('M d, Y') }}</div>
                            @else
                                <span class="mr-status mr-status-active"><span class="mr-status-dot"></span>In Progress</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="mr-actions">
                                @if(!$record->completed_at)
                                <form action="{{ route('maintenance_records.complete', $record->id) }}" method="POST" style="display:contents">
                                    @csrf @method('PATCH')
                                    <button type="submit" onclick="return confirm('Mark as completed?')" class="mr-btn mr-btn-done">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        Done
                                    </button>
                                </form>
                                @endif
                                <a href="{{ route('maintenance_records.show', $record->id) }}" class="mr-btn mr-btn-view">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    View
                                </a>
                                <a href="{{ route('maintenance_records.edit', $record->id) }}" class="mr-btn mr-btn-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                    Edit
                                </a>
                                <button type="button" class="mr-btn mr-btn-del"
                                    data-id="{{ $record->id }}"
                                    data-name="#{{ str_pad($record->id, 4, '0', STR_PAD_LEFT) }}"
                                    onclick="openMrModal(this.dataset.id, this.dataset.name)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    Delete
                                </button>
                                <form id="mr-del-form-{{ $record->id }}" action="{{ route('maintenance_records.destroy', $record->id) }}" method="POST" style="display:none">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mr-footer">
            <span class="mr-footer-text" id="mr-row-count">Showing {{ $total }} record(s)</span>
            <span class="mr-footer-text">Fleet Management System</span>
        </div>

        @else
        <div class="mr-empty">
            <div class="mr-empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75"/></svg>
            </div>
            <div class="mr-empty-title">No maintenance records yet</div>
            <p class="mr-empty-sub">Start tracking maintenance activity by adding your first record.</p>
            <a href="{{ route('maintenance_records.create') }}" class="mr-add-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Add First Record
            </a>
        </div>
        @endif
    </div>

</div>
</div>

{{-- Delete Modal --}}
<div id="mr-modal" class="mr-modal-bg" onclick="if(event.target===this)closeMrModal()">
    <div id="mr-modal-box" class="mr-modal-box">
        <div class="mr-modal-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
        </div>
        <div class="mr-modal-title">Delete Record?</div>
        <p class="mr-modal-sub">Permanently delete record <strong id="mr-modal-name" style="color:#111"></strong>? This cannot be undone.</p>
        <div class="mr-modal-actions">
            <button onclick="closeMrModal()" class="mr-modal-cancel">Cancel</button>
            <button id="mr-modal-confirm" class="mr-modal-confirm">Yes, Delete</button>
        </div>
    </div>
</div>

<script>
// Filter + Search
const mrSearch = document.getElementById('mr-search');
const mrRows   = document.querySelectorAll('#mr-table tbody tr');
const mrCount  = document.getElementById('mr-row-count');
let mrCurrentFilter = 'all';

function mrFilter(filter, btn) {
    mrCurrentFilter = filter;
    document.querySelectorAll('.mr-filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    mrApplyFilters();
}

mrSearch && mrSearch.addEventListener('input', mrApplyFilters);

function mrApplyFilters() {
    const q = (mrSearch?.value || '').toLowerCase().trim();
    let visible = 0;
    mrRows.forEach(r => {
        const matchFilter = mrCurrentFilter === 'all' || r.dataset.status === mrCurrentFilter;
        const matchSearch = !q || (r.dataset.search || '').includes(q);
        const show = matchFilter && matchSearch;
        r.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    if (mrCount) mrCount.textContent = `Showing ${visible} record(s)`;
}

// Delete modal
let mrPendingId = null;
function openMrModal(id, name) {
    mrPendingId = id;
    document.getElementById('mr-modal-name').textContent = name;
    const m = document.getElementById('mr-modal'), b = document.getElementById('mr-modal-box');
    m.classList.add('open');
    setTimeout(() => b.classList.add('open'), 10);
}
function closeMrModal() {
    const m = document.getElementById('mr-modal'), b = document.getElementById('mr-modal-box');
    b.classList.remove('open');
    setTimeout(() => { m.classList.remove('open'); mrPendingId = null; }, 200);
}
document.getElementById('mr-modal-confirm').addEventListener('click', () => {
    if (mrPendingId) document.getElementById('mr-del-form-' + mrPendingId).submit();
});
</script>

@endsection