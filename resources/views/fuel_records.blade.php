@extends('app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

    .fr-page * { font-family: 'DM Sans', sans-serif; box-sizing: border-box; }
    .fr-mono { font-family: 'DM Mono', monospace; }

    .fr-page {
        min-height: 100vh;
        background: #f7f6f3;
        background-image:
            radial-gradient(circle at 15% 0%, rgba(234,88,12,.06) 0%, transparent 55%),
            radial-gradient(circle at 90% 85%, rgba(234,88,12,.04) 0%, transparent 50%);
        padding: 2.5rem 2rem;
    }

    .fr-wrap { max-width: 1400px; margin: 0 auto; }

    .fr-breadcrumb {
        display: flex; align-items: center; gap: .5rem;
        margin-bottom: 2rem; color: #9e9b95; font-size: .8125rem;
    }
    .fr-breadcrumb a { color: #9e9b95; text-decoration: none; transition: color .15s; }
    .fr-breadcrumb a:hover { color: #111; }
    .fr-breadcrumb svg { width: 14px; height: 14px; }

    .fr-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.75rem; gap: 1rem; flex-wrap: wrap;
    }
    .fr-header-left { display: flex; align-items: center; gap: 1rem; }
    .fr-icon {
        width: 52px; height: 52px; border-radius: 14px;
        background: #ea580c;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; box-shadow: 0 4px 14px rgba(234,88,12,.3);
        font-size: 1.35rem;
    }
    .fr-title { font-size: 1.5rem; font-weight: 600; color: #111; letter-spacing: -.02em; line-height: 1.2; }
    .fr-subtitle { font-size: .8125rem; color: #9e9b95; margin-top: .2rem; }

    .fr-add-btn {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .6rem 1.25rem; border-radius: 11px;
        font-size: .8125rem; font-weight: 600; text-decoration: none;
        background: #ea580c; color: #fff;
        box-shadow: 0 4px 14px rgba(234,88,12,.3);
        transition: all .15s; white-space: nowrap;
    }
    .fr-add-btn:hover { background: #c2410c; box-shadow: 0 6px 18px rgba(234,88,12,.35); transform: translateY(-1px); }
    .fr-add-btn svg { width: 15px; height: 15px; }

    .fr-stats {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 1rem; margin-bottom: 1.5rem;
    }
    @media (max-width: 640px) { .fr-stats { grid-template-columns: repeat(2, 1fr); } }

    .fr-stat {
        background: #fff; border: 1px solid #e8e6e1;
        border-radius: 16px; padding: 1.1rem 1.25rem;
        display: flex; align-items: center; gap: .875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
        transition: box-shadow .2s, transform .2s;
    }
    .fr-stat:hover { box-shadow: 0 6px 20px rgba(0,0,0,.08); transform: translateY(-2px); }
    .fr-stat-icon {
        width: 40px; height: 40px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .fr-stat-icon svg { width: 18px; height: 18px; }
    .fr-stat-num { font-size: 1.4rem; font-weight: 700; color: #111; letter-spacing: -.03em; line-height: 1; }
    .fr-stat-lbl { font-size: .75rem; color: #9e9b95; font-weight: 500; margin-top: .2rem; }

    .fr-card {
        background: #fff; border: 1px solid #e8e6e1; border-radius: 18px;
        overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 16px rgba(0,0,0,.04);
    }
    .fr-card-header {
        padding: .875rem 1.5rem; border-bottom: 1px solid #f0ede8;
        display: flex; align-items: center; gap: .75rem; flex-wrap: wrap;
    }
    .fr-card-title { font-size: .8125rem; font-weight: 600; color: #333; }
    .fr-count {
        display: inline-flex; align-items: center;
        background: #fff3ed; border: 1px solid #fed7aa;
        color: #c2410c; font-size: .7rem; font-weight: 700;
        padding: .15rem .55rem; border-radius: 99px;
        font-family: 'DM Mono', monospace;
    }

    .fr-search-wrap { margin-left: auto; position: relative; }
    .fr-search-wrap svg { position: absolute; left: .75rem; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: #b0ada7; pointer-events: none; }
    .fr-search {
        padding: .5rem .875rem .5rem 2.25rem; font-size: .8125rem; background: #fafaf8;
        border: 1px solid #e8e6e1; border-radius: 9px; color: #333; width: 220px;
        font-family: 'DM Sans', sans-serif; transition: all .15s;
    }
    .fr-search::placeholder { color: #c0bdb8; }
    .fr-search:focus { outline: none; background: #fff; border-color: #fdba74; box-shadow: 0 0 0 3px rgba(253,186,116,.2); width: 260px; }

    .fr-table { width: 100%; border-collapse: collapse; }
    .fr-table thead tr { background: #fafaf8; border-bottom: 1px solid #f0ede8; }
    .fr-table th {
        padding: .75rem 1.25rem; text-align: left;
        font-size: .7rem; font-weight: 600; letter-spacing: .07em;
        text-transform: uppercase; color: #b0ada7; white-space: nowrap;
    }
    .fr-table th:last-child { text-align: right; }
    .fr-table tbody tr { border-bottom: 1px solid #f7f6f3; transition: background .12s; }
    .fr-table tbody tr:last-child { border-bottom: none; }
    .fr-table tbody tr:hover { background: #fdf9f6; }
    .fr-table td { padding: .875rem 1.25rem; vertical-align: middle; }

    .fr-avatar {
        width: 36px; height: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: .7rem; font-weight: 700; color: #fff; flex-shrink: 0;
        font-family: 'DM Mono', monospace; letter-spacing: .02em;
    }
    .fr-rec-meta { margin-left: .75rem; }
    .fr-rec-id-text { font-family: 'DM Mono', monospace; font-size: .8rem; font-weight: 600; color: #111; }
    .fr-rec-sub { font-size: .7rem; color: #b0ada7; margin-top: .1rem; }

    .fr-plate {
        font-family: 'DM Mono', monospace; font-size: .8rem; font-weight: 500;
        background: #f5f4f1; border: 1px solid #e8e6e1;
        color: #111; padding: .15rem .5rem; border-radius: 5px;
        letter-spacing: .04em; display: inline-block;
    }
    .fr-vehicle-sub { font-size: .72rem; color: #b0ada7; margin-top: .2rem; }
    .fr-fuel-pill {
        display: inline-flex; align-items: center;
        background: #fffbeb; border: 1px solid #fde68a;
        color: #92400e; font-size: .75rem; font-weight: 600;
        padding: .2rem .65rem; border-radius: 7px;
    }
    .fr-qty { font-size: .875rem; font-weight: 500; color: #444; }
    .fr-qty span { font-size: .72rem; color: #b0ada7; margin-left: .2rem; }
    .fr-price { font-family: 'DM Mono', monospace; font-size: .8rem; color: #6b6860; }
    .fr-cost  { font-family: 'DM Mono', monospace; font-size: .875rem; font-weight: 500; color: #374151; }
    .fr-date-primary { font-size: .8375rem; font-weight: 500; color: #333; }
    .fr-date-sub { font-size: .72rem; color: #b0ada7; margin-top: .15rem; }
    .fr-station { font-size: .8375rem; color: #6b6860; }
    .fr-station-empty { font-size: .8375rem; color: #d1cdc7; }

    .fr-actions { display: flex; align-items: center; justify-content: flex-end; gap: .4rem; }
    .fr-btn {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .4rem .8rem; border-radius: 8px;
        font-size: .75rem; font-weight: 600; text-decoration: none; cursor: pointer;
        border: 1px solid transparent; transition: all .15s;
        font-family: 'DM Sans', sans-serif; white-space: nowrap;
    }
    .fr-btn svg { width: 12px; height: 12px; flex-shrink: 0; }
    .fr-btn-view { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
    .fr-btn-view:hover { background: #dbeafe; }
    .fr-btn-edit { background: #fffbeb; border-color: #fde68a; color: #92400e; }
    .fr-btn-edit:hover { background: #fef3c7; }
    .fr-btn-del  { background: #fff5f5; border-color: #fecaca; color: #dc2626; }
    .fr-btn-del:hover { background: #fee2e2; }

    .fr-footer {
        padding: .75rem 1.5rem; border-top: 1px solid #f0ede8;
        background: #fafaf8; display: flex; align-items: center; justify-content: space-between;
    }
    .fr-footer-text { font-size: .72rem; color: #b0ada7; }

    .fr-empty {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; padding: 5rem 2rem; text-align: center;
    }
    .fr-empty-icon {
        width: 72px; height: 72px; border-radius: 20px;
        background: #fff3ed; border: 1px solid #fed7aa;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.75rem; margin-bottom: 1.25rem;
    }
    .fr-empty-title { font-size: 1rem; font-weight: 600; color: #333; margin-bottom: .4rem; }
    .fr-empty-sub { font-size: .8375rem; color: #9e9b95; max-width: 280px; line-height: 1.5; margin-bottom: 1.5rem; }

    .fr-modal-bg {
        position: fixed; inset: 0; z-index: 50;
        display: none; align-items: center; justify-content: center;
        padding: 1rem; background: rgba(0,0,0,.45); backdrop-filter: blur(4px);
    }
    .fr-modal-bg.open { display: flex; }
    .fr-modal-box {
        background: #fff; border-radius: 20px; width: 100%; max-width: 360px; padding: 2rem;
        transform: scale(.95); opacity: 0; transition: all .2s; box-shadow: 0 20px 60px rgba(0,0,0,.2);
    }
    .fr-modal-box.open { transform: scale(1); opacity: 1; }
    .fr-modal-icon {
        width: 56px; height: 56px; border-radius: 16px;
        background: #fff1f2; border: 1px solid #fecdd3;
        display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;
    }
    .fr-modal-icon svg { width: 24px; height: 24px; color: #dc2626; }
    .fr-modal-title { font-size: 1.05rem; font-weight: 700; color: #111; text-align: center; margin-bottom: .5rem; }
    .fr-modal-sub   { font-size: .8375rem; color: #9e9b95; text-align: center; margin-bottom: 1.5rem; line-height: 1.5; }
    .fr-modal-actions { display: flex; gap: .625rem; }
    .fr-modal-cancel {
        flex: 1; padding: .65rem; border-radius: 10px; font-size: .875rem; font-weight: 600;
        background: #f5f4f1; color: #444; border: none; cursor: pointer; transition: background .15s;
        font-family: 'DM Sans', sans-serif;
    }
    .fr-modal-cancel:hover { background: #eae8e3; }
    .fr-modal-confirm {
        flex: 1; padding: .65rem; border-radius: 10px; font-size: .875rem; font-weight: 600;
        background: #dc2626; color: #fff; border: none; cursor: pointer; transition: background .15s;
        box-shadow: 0 4px 12px rgba(220,38,38,.25); font-family: 'DM Sans', sans-serif;
    }
    .fr-modal-confirm:hover { background: #b91c1c; }
</style>

@php
    $total        = count($fuel_records);
    $totalLiters  = $fuel_records->sum('quantity');
    $totalCost    = $fuel_records->sum('cost');
    $avgPrice     = $total > 0 ? $fuel_records->avg('price_per_liter') : 0;
    $avatarColors = [
        ['#ea580c','#f97316'], ['#d97706','#f59e0b'], ['#0891b2','#06b6d4'],
        ['#7c3aed','#8b5cf6'], ['#0d9488','#14b8a6'], ['#db2777','#ec4899'],
    ];
@endphp

<div class="fr-page">
<div class="fr-wrap">

    <nav class="fr-breadcrumb">
        <a href="/">Home</a>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span>Fuel Records</span>
    </nav>

    <div class="fr-header">
        <div class="fr-header-left">
            <div class="fr-icon">⛽</div>
            <div>
                <div class="fr-title">Fuel Records</div>
                <div class="fr-subtitle">Track fuel refills, costs, and consumption</div>
            </div>
        </div>
        <a href="{{ route('fuel_records.create') }}" class="fr-add-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Add Record
        </a>
    </div>

    <div class="fr-stats">
        <div class="fr-stat">
            <div class="fr-stat-icon" style="background:#fff3ed">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
            </div>
            <div><div class="fr-stat-num">{{ $total }}</div><div class="fr-stat-lbl">Total Records</div></div>
        </div>
        <div class="fr-stat">
            <div class="fr-stat-icon" style="background:#eff6ff">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#3b82f6" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714a2.25 2.25 0 001.357 2.059l.537.268a2.25 2.25 0 001.161.263M9.75 3.104a24.3 24.3 0 00-4.5.082M3 14.5l2.686-2.686A2.25 2.25 0 016.75 11h10.5a2.25 2.25 0 011.064.314L21 14.5M3 14.5h18M3 14.5l-1.5 5.25h21L21 14.5"/></svg>
            </div>
            <div>
                <div class="fr-stat-num" style="font-size:1.2rem">{{ number_format($totalLiters, 0) }}<span style="font-size:.8rem;font-weight:500;color:#9e9b95;margin-left:.2rem">L</span></div>
                <div class="fr-stat-lbl">Total Liters</div>
            </div>
        </div>
        <div class="fr-stat">
            <div class="fr-stat-icon" style="background:#f0fdf4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="fr-stat-num" style="font-size:1.1rem">₱{{ number_format($totalCost, 0) }}</div>
                <div class="fr-stat-lbl">Total Cost</div>
            </div>
        </div>
        <div class="fr-stat">
            <div class="fr-stat-icon" style="background:#fffbeb">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#d97706" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
            </div>
            <div>
                <div class="fr-stat-num" style="font-size:1.1rem">₱{{ number_format($avgPrice, 2) }}</div>
                <div class="fr-stat-lbl">Avg Price/L</div>
            </div>
        </div>
    </div>

    <div class="fr-card">
        <div class="fr-card-header">
            <span class="fr-card-title">Fuel History</span>
            <span class="fr-count">{{ $total }}</span>
            <div class="fr-search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                <input id="fr-search" type="text" placeholder="Search records…" class="fr-search">
            </div>
        </div>

        @if($total > 0)
        <div style="overflow-x:auto">
            <table class="fr-table" id="fr-table">
                <thead>
                    <tr>
                        <th>Record</th>
                        <th>Vehicle</th>
                        <th>Fuel Type</th>
                        <th>Quantity</th>
                        <th>Price/L</th>
                        <th>Total Cost</th>
                        <th>Date</th>
                        <th>Gas Station</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fuel_records as $record)
                    @php $clr = $avatarColors[$record->id % count($avatarColors)]; @endphp
                    <tr data-search="{{ strtolower($record->vehicle->plate_number ?? '') }} {{ strtolower($record->fuel_type ?? '') }} {{ strtolower($record->gas_station ?? '') }}">
                        <td>
                            <div style="display:flex;align-items:center">
                                <div class="fr-avatar" style="background:linear-gradient(135deg, {{ $clr[0] }}, {{ $clr[1] }})">
                                    #{{ str_pad($record->id, 2, '0', STR_PAD_LEFT) }}
                                </div>
                                <div class="fr-rec-meta">
                                    <div class="fr-rec-id-text">#{{ str_pad($record->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    <div class="fr-rec-sub">{{ \Carbon\Carbon::parse($record->date)->format('M d') }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fr-plate">{{ $record->vehicle->plate_number ?? 'N/A' }}</span>
                            <div class="fr-vehicle-sub">{{ $record->vehicle->make ?? 'N/A' }} {{ $record->vehicle->model ?? '' }}</div>
                        </td>
                        <td><span class="fr-fuel-pill">{{ $record->fuel_type }}</span></td>
                        <td><span class="fr-qty">{{ number_format($record->quantity, 2) }}<span>L</span></span></td>
                        <td><span class="fr-price">₱{{ number_format($record->price_per_liter, 2) }}</span></td>
                        <td><span class="fr-cost">₱{{ number_format($record->cost, 2) }}</span></td>
                        <td>
                            <div class="fr-date-primary">{{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}</div>
                            <div class="fr-date-sub">{{ \Carbon\Carbon::parse($record->date)->diffForHumans() }}</div>
                        </td>
                        <td>
                            @if($record->gas_station)
                                <span class="fr-station">{{ $record->gas_station }}</span>
                            @else
                                <span class="fr-station-empty">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="fr-actions">
                                <a href="{{ route('fuel_records.show', $record->id) }}" class="fr-btn fr-btn-view">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    View
                                </a>
                                <a href="{{ route('fuel_records.edit', $record->id) }}" class="fr-btn fr-btn-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                    Edit
                                </a>
                                <button type="button" class="fr-btn fr-btn-del"
                                    data-id="{{ $record->id }}"
                                    data-label="#{{ str_pad($record->id, 4, '0', STR_PAD_LEFT) }} · {{ $record->vehicle->plate_number ?? 'N/A' }}"
                                    onclick="openFrModal(this.dataset.id, this.dataset.label)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    Delete
                                </button>
                                <form id="fr-del-form-{{ $record->id }}" action="{{ route('fuel_records.destroy', $record->id) }}" method="POST" style="display:none">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="fr-footer">
            <span class="fr-footer-text" id="fr-row-count">Showing {{ $total }} record(s)</span>
            <span class="fr-footer-text">Fleet Management System</span>
        </div>
        @else
        <div class="fr-empty">
            <div class="fr-empty-icon">⛽</div>
            <div class="fr-empty-title">No fuel records yet</div>
            <p class="fr-empty-sub">Start tracking fuel activity by adding your first refill record.</p>
            <a href="{{ route('fuel_records.create') }}" class="fr-add-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Add First Record
            </a>
        </div>
        @endif
    </div>

</div>
</div>

<div id="fr-modal" class="fr-modal-bg" onclick="if(event.target===this)closeFrModal()">
    <div id="fr-modal-box" class="fr-modal-box">
        <div class="fr-modal-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
        </div>
        <div class="fr-modal-title">Delete Fuel Record?</div>
        <p class="fr-modal-sub">Permanently delete record <strong id="fr-modal-label" style="color:#111"></strong>? This cannot be undone.</p>
        <div class="fr-modal-actions">
            <button onclick="closeFrModal()" class="fr-modal-cancel">Cancel</button>
            <button id="fr-modal-confirm" class="fr-modal-confirm">Yes, Delete</button>
        </div>
    </div>
</div>

<script>
const frSearch = document.getElementById('fr-search');
const frRows   = document.querySelectorAll('#fr-table tbody tr');
const frCount  = document.getElementById('fr-row-count');
frSearch && frSearch.addEventListener('input', function() {
    const q = this.value.toLowerCase().trim();
    let visible = 0;
    frRows.forEach(r => {
        const match = (r.dataset.search || '').includes(q);
        r.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    if (frCount) frCount.textContent = q ? `Showing ${visible} of {{ $total }} record(s)` : `Showing {{ $total }} record(s)`;
});

let frPendingId = null;
function openFrModal(id, label) {
    frPendingId = id;
    document.getElementById('fr-modal-label').textContent = label;
    const m = document.getElementById('fr-modal'), b = document.getElementById('fr-modal-box');
    m.classList.add('open');
    setTimeout(() => b.classList.add('open'), 10);
}
function closeFrModal() {
    const m = document.getElementById('fr-modal'), b = document.getElementById('fr-modal-box');
    b.classList.remove('open');
    setTimeout(() => { m.classList.remove('open'); frPendingId = null; }, 200);
}
document.getElementById('fr-modal-confirm').addEventListener('click', () => {
    if (frPendingId) document.getElementById('fr-del-form-' + frPendingId).submit();
});
</script>

@endsection