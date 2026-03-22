@extends('app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

    .tr-page * { font-family: 'DM Sans', sans-serif; box-sizing: border-box; }
    .tr-mono { font-family: 'DM Mono', monospace; }

    .tr-page {
        min-height: 100vh;
        background: #f7f6f3;
        background-image:
            radial-gradient(circle at 15% 0%, rgba(124,58,237,.06) 0%, transparent 55%),
            radial-gradient(circle at 90% 85%, rgba(124,58,237,.04) 0%, transparent 50%);
        padding: 2.5rem 2rem;
    }

    .tr-wrap { max-width: 1400px; margin: 0 auto; }

    /* ── Breadcrumb ── */
    .tr-breadcrumb {
        display: flex; align-items: center; gap: .5rem;
        margin-bottom: 2rem; color: #9e9b95; font-size: .8125rem;
    }
    .tr-breadcrumb a { color: #9e9b95; text-decoration: none; transition: color .15s; }
    .tr-breadcrumb a:hover { color: #111; }
    .tr-breadcrumb svg { width: 14px; height: 14px; }

    /* ── Header ── */
    .tr-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.75rem; gap: 1rem; flex-wrap: wrap;
    }
    .tr-header-left { display: flex; align-items: center; gap: 1rem; }
    .tr-icon {
        width: 52px; height: 52px; border-radius: 14px;
        background: #7c3aed;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; box-shadow: 0 4px 14px rgba(124,58,237,.3);
    }
    .tr-icon svg { width: 22px; height: 22px; color: #fff; }
    .tr-title { font-size: 1.5rem; font-weight: 600; color: #111; letter-spacing: -.02em; line-height: 1.2; }
    .tr-subtitle { font-size: .8125rem; color: #9e9b95; margin-top: .2rem; }

    .tr-add-btn {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .6rem 1.25rem; border-radius: 11px;
        font-size: .8125rem; font-weight: 600; text-decoration: none;
        background: #7c3aed; color: #fff;
        box-shadow: 0 4px 14px rgba(124,58,237,.3);
        transition: all .15s; white-space: nowrap;
    }
    .tr-add-btn:hover { background: #6d28d9; box-shadow: 0 6px 18px rgba(124,58,237,.35); transform: translateY(-1px); }
    .tr-add-btn svg { width: 15px; height: 15px; }

    /* ── Stat cards ── */
    .tr-stats {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 1rem; margin-bottom: 1.5rem;
    }
    @media (max-width: 640px) { .tr-stats { grid-template-columns: repeat(2, 1fr); } }

    .tr-stat {
        background: #fff; border: 1px solid #e8e6e1;
        border-radius: 16px; padding: 1.1rem 1.25rem;
        display: flex; align-items: center; gap: .875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
        transition: box-shadow .2s, transform .2s;
    }
    .tr-stat:hover { box-shadow: 0 6px 20px rgba(0,0,0,.08); transform: translateY(-2px); }
    .tr-stat-icon {
        width: 40px; height: 40px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .tr-stat-icon svg { width: 18px; height: 18px; }
    .tr-stat-num { font-size: 1.6rem; font-weight: 700; color: #111; letter-spacing: -.03em; line-height: 1; }
    .tr-stat-lbl { font-size: .75rem; color: #9e9b95; font-weight: 500; margin-top: .2rem; }

    /* ── Main card ── */
    .tr-card {
        background: #fff;
        border: 1px solid #e8e6e1;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 16px rgba(0,0,0,.04);
    }
    .tr-card-header {
        padding: .875rem 1.5rem;
        border-bottom: 1px solid #f0ede8;
        display: flex; align-items: center; gap: .75rem; flex-wrap: wrap;
    }
    .tr-card-title { font-size: .8125rem; font-weight: 600; color: #333; }
    .tr-count {
        display: inline-flex; align-items: center;
        background: #f3f0ff; border: 1px solid #ddd6fe;
        color: #5b21b6; font-size: .7rem; font-weight: 700;
        padding: .15rem .55rem; border-radius: 99px;
        font-family: 'DM Mono', monospace;
    }

    /* search */
    .tr-search-wrap { margin-left: auto; position: relative; }
    .tr-search-wrap svg { position: absolute; left: .75rem; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: #b0ada7; pointer-events: none; }
    .tr-search {
        padding: .5rem .875rem .5rem 2.25rem;
        font-size: .8125rem; background: #fafaf8;
        border: 1px solid #e8e6e1; border-radius: 9px;
        color: #333; width: 220px; font-family: 'DM Sans', sans-serif;
        transition: all .15s;
    }
    .tr-search::placeholder { color: #c0bdb8; }
    .tr-search:focus { outline: none; background: #fff; border-color: #c4b5fd; box-shadow: 0 0 0 3px rgba(196,181,253,.2); width: 260px; }

    /* ── Table ── */
    .tr-table { width: 100%; border-collapse: collapse; }
    .tr-table thead tr { background: #fafaf8; border-bottom: 1px solid #f0ede8; }
    .tr-table th {
        padding: .75rem 1.25rem; text-align: left;
        font-size: .7rem; font-weight: 600; letter-spacing: .07em;
        text-transform: uppercase; color: #b0ada7; white-space: nowrap;
    }
    .tr-table th:last-child { text-align: right; }
    .tr-table tbody tr { border-bottom: 1px solid #f7f6f3; transition: background .12s; }
    .tr-table tbody tr:last-child { border-bottom: none; }
    .tr-table tbody tr:hover { background: #fbf8ff; }
    .tr-table td { padding: .875rem 1.25rem; vertical-align: middle; }

    /* ── Trip avatar ── */
    .tr-avatar {
        width: 38px; height: 38px; border-radius: 11px;
        background: linear-gradient(135deg, #7c3aed, #8b5cf6);
        display: flex; align-items: center; justify-content: center;
        font-size: .75rem; font-weight: 700; color: #fff; flex-shrink: 0;
        font-family: 'DM Mono', monospace;
    }
    .tr-trip-id { font-size: .875rem; font-weight: 600; color: #111; }
    .tr-trip-dist { font-size: .72rem; color: #b0ada7; font-family: 'DM Mono', monospace; margin-top: .1rem; }

    /* ── Route ── */
    .tr-route-from { font-size: .875rem; font-weight: 500; color: #111; }
    .tr-route-to   { font-size: .72rem; color: #9e9b95; margin-top: .1rem; }

    /* ── Driver / vehicle ── */
    .tr-driver-name { font-size: .8375rem; font-weight: 500; color: #333; }
    .tr-driver-sub  { font-size: .72rem; color: #b0ada7; margin-top: .1rem; }
    .tr-plate {
        font-family: 'DM Mono', monospace; font-size: .8rem; font-weight: 500;
        background: #111; color: #fff;
        padding: .25rem .6rem; border-radius: 6px; letter-spacing: .06em;
        display: inline-block;
    }

    /* ── Schedule ── */
    .tr-sched-date { font-size: .8375rem; font-weight: 500; color: #333; }
    .tr-sched-time { font-size: .72rem; color: #b0ada7; font-family: 'DM Mono', monospace; margin-top: .1rem; }

    /* ── Status pills ── */
    .tr-status {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .72rem; font-weight: 600;
        padding: .25rem .7rem; border-radius: 99px;
        border: 1px solid transparent;
    }
    .tr-status-dot { width: 5px; height: 5px; border-radius: 50%; }
    .tr-status-completed  { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
    .tr-status-completed .tr-status-dot  { background: #22c55e; }
    .tr-status-progress   { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
    .tr-status-progress .tr-status-dot   { background: #3b82f6; animation: pulse-dot 2s ease-in-out infinite; }
    .tr-status-pending    { background: #fffbeb; border-color: #fde68a; color: #92400e; }
    .tr-status-pending .tr-status-dot    { background: #f59e0b; }
    @keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:.4} }

    /* ── Action buttons ── */
    .tr-actions { display: flex; align-items: center; justify-content: flex-end; gap: .4rem; }
    .tr-btn {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .4rem .8rem; border-radius: 8px;
        font-size: .75rem; font-weight: 600; text-decoration: none; cursor: pointer;
        border: 1px solid transparent; transition: all .15s;
        font-family: 'DM Sans', sans-serif; white-space: nowrap;
    }
    .tr-btn svg { width: 12px; height: 12px; flex-shrink: 0; }
    .tr-btn-view { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
    .tr-btn-view:hover { background: #dbeafe; }
    .tr-btn-edit { background: #fffbeb; border-color: #fde68a; color: #92400e; }
    .tr-btn-edit:hover { background: #fef3c7; }
    .tr-btn-del  { background: #fff5f5; border-color: #fecaca; color: #dc2626; }
    .tr-btn-del:hover { background: #fee2e2; }

    /* ── Footer ── */
    .tr-footer {
        padding: .75rem 1.5rem; border-top: 1px solid #f0ede8;
        background: #fafaf8; display: flex; align-items: center; justify-content: space-between;
    }
    .tr-footer-text { font-size: .72rem; color: #b0ada7; }

    /* ── Empty state ── */
    .tr-empty {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; padding: 5rem 2rem; text-align: center;
    }
    .tr-empty-icon {
        width: 72px; height: 72px; border-radius: 20px;
        background: #f3f0ff; border: 1px solid #ddd6fe;
        display: flex; align-items: center; justify-content: center; margin-bottom: 1.25rem;
    }
    .tr-empty-icon svg { width: 30px; height: 30px; color: #a78bfa; }
    .tr-empty-title { font-size: 1rem; font-weight: 600; color: #333; margin-bottom: .4rem; }
    .tr-empty-sub { font-size: .8375rem; color: #9e9b95; max-width: 280px; line-height: 1.5; margin-bottom: 1.5rem; }

    /* ── Delete modal ── */
    .tr-modal-bg {
        position: fixed; inset: 0; z-index: 50;
        display: none; align-items: center; justify-content: center;
        padding: 1rem; background: rgba(0,0,0,.45); backdrop-filter: blur(4px);
    }
    .tr-modal-bg.open { display: flex; }
    .tr-modal-box {
        background: #fff; border-radius: 20px;
        width: 100%; max-width: 360px; padding: 2rem;
        transform: scale(.95); opacity: 0; transition: all .2s;
        box-shadow: 0 20px 60px rgba(0,0,0,.2);
    }
    .tr-modal-box.open { transform: scale(1); opacity: 1; }
    .tr-modal-icon {
        width: 56px; height: 56px; border-radius: 16px;
        background: #fff1f2; border: 1px solid #fecdd3;
        display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;
    }
    .tr-modal-icon svg { width: 24px; height: 24px; color: #dc2626; }
    .tr-modal-title { font-size: 1.05rem; font-weight: 700; color: #111; text-align: center; margin-bottom: .5rem; }
    .tr-modal-sub   { font-size: .8375rem; color: #9e9b95; text-align: center; margin-bottom: 1.5rem; line-height: 1.5; }
    .tr-modal-actions { display: flex; gap: .625rem; }
    .tr-modal-cancel {
        flex: 1; padding: .65rem; border-radius: 10px; font-size: .875rem; font-weight: 600;
        background: #f5f4f1; color: #444; border: none; cursor: pointer; transition: background .15s;
        font-family: 'DM Sans', sans-serif;
    }
    .tr-modal-cancel:hover { background: #eae8e3; }
    .tr-modal-confirm {
        flex: 1; padding: .65rem; border-radius: 10px; font-size: .875rem; font-weight: 600;
        background: #dc2626; color: #fff; border: none; cursor: pointer; transition: background .15s;
        box-shadow: 0 4px 12px rgba(220,38,38,.25); font-family: 'DM Sans', sans-serif;
    }
    .tr-modal-confirm:hover { background: #b91c1c; }
</style>

@php
    $total      = count($trips);
    $completed  = $trips->where('status','completed')->count();
    $inProgress = $trips->where('status','in_progress')->count();
    $pending    = $trips->where('status','pending')->count();
@endphp

<div class="tr-page">
<div class="tr-wrap">

    {{-- Breadcrumb --}}
    <nav class="tr-breadcrumb">
        <a href="/">Home</a>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span>Trips</span>
    </nav>

    {{-- Header --}}
    <div class="tr-header">
        <div class="tr-header-left">
            <div class="tr-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-3m-6 3V2m6 15l6-3m-6 3V5m6 9V3m0 0l-6 3m6-3l-6 3"/>
                </svg>
            </div>
            <div>
                <div class="tr-title">Trip Management</div>
                <div class="tr-subtitle">Manage schedules, routes, and trip progress</div>
            </div>
        </div>
        <a href="{{ route('trips.create') }}" class="tr-add-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Add New Trip
        </a>
    </div>

    {{-- Stats --}}
    <div class="tr-stats">
        <div class="tr-stat">
            <div class="tr-stat-icon" style="background:#f3f0ff">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#7c3aed" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-3m-6 3V2m6 15l6-3m-6 3V5m6 9V3m0 0l-6 3m6-3l-6 3"/></svg>
            </div>
            <div>
                <div class="tr-stat-num">{{ $total }}</div>
                <div class="tr-stat-lbl">Total Trips</div>
            </div>
        </div>
        <div class="tr-stat">
            <div class="tr-stat-icon" style="background:#f0fdf4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="tr-stat-num">{{ $completed }}</div>
                <div class="tr-stat-lbl">Completed</div>
            </div>
        </div>
        <div class="tr-stat">
            <div class="tr-stat-icon" style="background:#eff6ff">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#3b82f6" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="tr-stat-num">{{ $inProgress }}</div>
                <div class="tr-stat-lbl">In Progress</div>
            </div>
        </div>
        <div class="tr-stat">
            <div class="tr-stat-icon" style="background:#fffbeb">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#d97706" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
            </div>
            <div>
                <div class="tr-stat-num">{{ $pending }}</div>
                <div class="tr-stat-lbl">Pending</div>
            </div>
        </div>
    </div>

    {{-- Table card --}}
    <div class="tr-card">
        <div class="tr-card-header">
            <span class="tr-card-title">All Trips</span>
            <span class="tr-count">{{ $total }}</span>
            <div class="tr-search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                <input id="tr-search" type="text" placeholder="Search route, driver, or vehicle…" class="tr-search">
            </div>
        </div>

        @if($total > 0)
        <div style="overflow-x:auto">
            <table class="tr-table" id="tr-table">
                <thead>
                    <tr>
                        <th>Trip</th>
                        <th>Route</th>
                        <th>Driver</th>
                        <th>Vehicle</th>
                        <th>Schedule</th>
                        <th>Status</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trips as $trip)
                    <tr data-search="{{ strtolower(($trip->start_location ?? '').' '.($trip->end_location ?? '').' '.($trip->driver->name ?? '').' '.($trip->vehicle->plate_number ?? '')) }}">

                        {{-- Trip --}}
                        <td>
                            <div style="display:flex;align-items:center;gap:.75rem">
                                <div class="tr-avatar">#{{ str_pad($trip->id, 2, '0', STR_PAD_LEFT) }}</div>
                                <div>
                                    <div class="tr-trip-id">Trip #{{ str_pad($trip->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    <div class="tr-trip-dist">{{ $trip->distance ? number_format($trip->distance, 1).' km' : 'N/A' }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Route --}}
                        <td>
                            <div class="tr-route-from">{{ $trip->start_location }}</div>
                            <div class="tr-route-to">→ {{ $trip->end_location }}</div>
                        </td>

                        {{-- Driver --}}
                        <td>
                            <div class="tr-driver-name">{{ $trip->driver->name ?? 'Unassigned' }}</div>
                            <div class="tr-driver-sub">{{ $trip->driver->license_number ?? '—' }}</div>
                        </td>

                        {{-- Vehicle --}}
                        <td><span class="tr-plate">{{ $trip->vehicle->plate_number ?? 'N/A' }}</span></td>

                        {{-- Schedule --}}
                        <td>
                            <div class="tr-sched-date">{{ $trip->start_time->format('M d, Y') }}</div>
                            <div class="tr-sched-time">{{ $trip->start_time->format('h:i A') }}</div>
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($trip->status === 'completed')
                                <span class="tr-status tr-status-completed"><span class="tr-status-dot"></span>Completed</span>
                            @elseif($trip->status === 'in_progress')
                                <span class="tr-status tr-status-progress"><span class="tr-status-dot"></span>In Progress</span>
                            @else
                                <span class="tr-status tr-status-pending"><span class="tr-status-dot"></span>Pending</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="tr-actions">
                                <a href="{{ route('trips.show', $trip->id) }}" class="tr-btn tr-btn-view">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    View
                                </a>
                                <a href="{{ route('trips.edit', $trip->id) }}" class="tr-btn tr-btn-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                    Edit
                                </a>
                                <button type="button" class="tr-btn tr-btn-del"
                                    data-id="{{ $trip->id }}"
                                    data-name="Trip #{{ str_pad($trip->id, 4, '0', STR_PAD_LEFT) }}"
                                    onclick="openTrModal(this.dataset.id, this.dataset.name)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    Delete
                                </button>
                                <form id="tr-del-form-{{ $trip->id }}" action="{{ route('trips.destroy', $trip->id) }}" method="POST" style="display:none">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tr-footer">
            <span class="tr-footer-text" id="tr-row-count">Showing {{ $total }} trip(s)</span>
            <span class="tr-footer-text">Fleet Management System</span>
        </div>

        @else
        <div class="tr-empty">
            <div class="tr-empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-3m-6 3V2m6 15l6-3m-6 3V5m6 9V3m0 0l-6 3m6-3l-6 3"/></svg>
            </div>
            <div class="tr-empty-title">No trips yet</div>
            <p class="tr-empty-sub">No scheduled trips yet. Create your first trip to start managing routes.</p>
            <a href="{{ route('trips.create') }}" class="tr-add-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Add First Trip
            </a>
        </div>
        @endif
    </div>

</div>
</div>

{{-- Delete Modal --}}
<div id="tr-modal" class="tr-modal-bg" onclick="if(event.target===this)closeTrModal()">
    <div id="tr-modal-box" class="tr-modal-box">
        <div class="tr-modal-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
        </div>
        <div class="tr-modal-title">Delete Trip?</div>
        <p class="tr-modal-sub">Permanently delete <strong id="tr-modal-name" style="color:#111"></strong>? This cannot be undone.</p>
        <div class="tr-modal-actions">
            <button onclick="closeTrModal()" class="tr-modal-cancel">Cancel</button>
            <button id="tr-modal-confirm" class="tr-modal-confirm">Yes, Delete</button>
        </div>
    </div>
</div>

<script>
// Search
const trSearch = document.getElementById('tr-search');
const trRows   = document.querySelectorAll('#tr-table tbody tr');
const trCount  = document.getElementById('tr-row-count');
trSearch && trSearch.addEventListener('input', function() {
    const q = this.value.toLowerCase().trim();
    let visible = 0;
    trRows.forEach(r => {
        const match = (r.dataset.search || '').includes(q);
        r.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    if (trCount) trCount.textContent = q ? `Showing ${visible} of {{ $total }} trip(s)` : `Showing {{ $total }} trip(s)`;
});

// Delete modal
let trPendingId = null;
function openTrModal(id, name) {
    trPendingId = id;
    document.getElementById('tr-modal-name').textContent = name;
    const m = document.getElementById('tr-modal'), b = document.getElementById('tr-modal-box');
    m.classList.add('open');
    setTimeout(() => b.classList.add('open'), 10);
}
function closeTrModal() {
    const m = document.getElementById('tr-modal'), b = document.getElementById('tr-modal-box');
    b.classList.remove('open');
    setTimeout(() => { m.classList.remove('open'); trPendingId = null; }, 200);
}
document.getElementById('tr-modal-confirm').addEventListener('click', () => {
    if (trPendingId) document.getElementById('tr-del-form-' + trPendingId).submit();
});
</script>

@endsection