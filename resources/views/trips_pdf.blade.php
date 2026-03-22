<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trip Report #{{ str_pad($trip->id, 4, '0', STR_PAD_LEFT) }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #1f2937; background: #ffffff; }

        /* ── Header ── */
        .header { background: #7c3aed; padding: 24px 32px; color: white; }
        .header-top { display: table; width: 100%; }
        .header-left { display: table-cell; vertical-align: top; }
        .header-right { display: table-cell; vertical-align: top; text-align: right; }
        .company-name { font-size: 18px; font-weight: 700; }
        .company-sub  { font-size: 10px; opacity: .75; margin-top: 2px; }
        .doc-title    { font-size: 20px; font-weight: 700; }
        .doc-id       { font-size: 11px; opacity: .8; margin-top: 3px; }
        .header-divider { border: none; border-top: 1px solid rgba(255,255,255,.3); margin: 14px 0; }
        .header-meta  { font-size: 11px; opacity: .85; }
        .header-meta span { margin-right: 24px; }

        /* ── Status badge ── */
        .badge { display: inline-block; padding: 2px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; }
        .badge-completed   { background: #d1fae5; color: #065f46; }
        .badge-in_progress { background: #dbeafe; color: #1e40af; }
        .badge-pending     { background: #fef3c7; color: #92400e; }

        /* ── Body ── */
        .body { padding: 24px 32px; }

        /* ── Route box ── */
        .route-box { background: #ede9fe; border: 1px solid #c4b5fd; border-radius: 6px; padding: 12px 16px; margin-bottom: 20px; }
        .route-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; color: #7c3aed; margin-bottom: 4px; }
        .route-text  { font-size: 15px; font-weight: 700; color: #4c1d95; }

        /* ── Stats ── */
        .stats-table { width: 100%; border-collapse: separate; border-spacing: 8px 0; margin: 0 -8px 20px; }
        .stat-cell { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; padding: 12px; text-align: center; width: 25%; }
        .stat-num  { font-size: 20px; font-weight: 700; color: #7c3aed; }
        .stat-lbl  { font-size: 9px; color: #6b7280; margin-top: 2px; text-transform: uppercase; letter-spacing: .3px; }

        /* ── Section ── */
        .section { margin-bottom: 20px; page-break-inside: avoid; }
        .section-title { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: #7c3aed; border-bottom: 2px solid #ede9fe; padding-bottom: 5px; margin-bottom: 12px; }

        /* ── Two columns ── */
        .two-col-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .col-left  { width: 50%; vertical-align: top; padding-right: 12px; }
        .col-right { width: 50%; vertical-align: top; padding-left: 12px; border-left: 1px solid #e5e7eb; }

        /* ── Card ── */
        .card { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; padding: 14px; margin-bottom: 14px; }

        /* ── Info table ── */
        .info-table { width: 100%; border-collapse: collapse; }
        .info-label { width: 40%; padding: 5px 8px 5px 0; font-size: 10px; color: #6b7280; font-weight: 600; vertical-align: top; }
        .info-value { padding: 5px 0; font-size: 11px; color: #111827; font-weight: 500; vertical-align: top; }
        .info-row + .info-row td { border-top: 1px solid #f3f4f6; }

        /* ── Alert badges ── */
        .alert-high { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; padding: 1px 7px; border-radius: 4px; font-size: 10px; font-weight: 600; }
        .alert-none { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 1px 7px; border-radius: 4px; font-size: 10px; font-weight: 600; }

        /* ── Timeline ── */
        .timeline-table { width: 100%; border-collapse: collapse; }
        .tl-dot-cell { width: 24px; vertical-align: top; padding-top: 1px; padding-bottom: 14px; }
        .tl-dot { width: 12px; height: 12px; border-radius: 50%; border: 2px solid #7c3aed; background: #ede9fe; display: inline-block; }
        .tl-dot-done { background: #7c3aed; border-color: #6d28d9; }
        .tl-dot-orange { background: #f97316; border-color: #ea580c; }
        .tl-dot-green  { background: #16a34a; border-color: #15803d; }
        .tl-dot-gray   { background: #f3f4f6; border-color: #d1d5db; }
        .tl-line-cell { width: 24px; padding-bottom: 0; }
        .tl-line { width: 2px; height: 16px; background: #e5e7eb; margin: 0 auto; }
        .tl-content { vertical-align: top; padding-bottom: 4px; }
        .tl-title { font-size: 11px; font-weight: 700; color: #111827; }
        .tl-desc  { font-size: 10px; color: #6b7280; margin-top: 2px; }
        .tl-time  { font-size: 9px; color: #9ca3af; margin-top: 1px; }
        .tl-muted { color: #9ca3af; }

        /* ── Watermark ── */
        .watermark { position: fixed; top: 45%; left: 10%; font-size: 72px; font-weight: 900; color: rgba(124,58,237,.05); text-transform: uppercase; letter-spacing: 6px; transform: rotate(-30deg); }

        /* ── Footer ── */
        .footer { position: fixed; bottom: 0; left: 0; right: 0; padding: 8px 32px; background: #f9fafb; border-top: 1px solid #e5e7eb; }
        .footer-table { width: 100%; border-collapse: collapse; }
        .footer-left  { font-size: 9px; color: #9ca3af; }
        .footer-right { font-size: 9px; color: #9ca3af; text-align: right; }

        /* ── Page break ── */
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    {{-- Watermark --}}
    @if($trip->status !== 'completed')
        <div class="watermark">{{ strtoupper(str_replace('_', ' ', $trip->status)) }}</div>
    @endif

    {{-- Fixed Footer --}}
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td class="footer-left">Fleet Management System — Confidential</td>
                <td class="footer-right">Generated {{ now()->format('M d, Y') }}</td>
            </tr>
        </table>
    </div>

    {{-- Header --}}
    <div class="header">
        <div class="header-top">
            <div class="header-left">
                <div class="company-name">Fleet Manager</div>
                <div class="company-sub">Fleet Management System</div>
            </div>
            <div class="header-right">
                <div class="doc-title">Trip Report</div>
                <div class="doc-id">#{{ str_pad($trip->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>
        <hr class="header-divider">
        <div class="header-meta">
            <span>Generated: {{ now()->format('M d, Y h:i A') }}</span>
            <span>Status: <span class="badge badge-{{ $trip->status }}">{{ ucfirst(str_replace('_', ' ', $trip->status)) }}</span></span>
            @if($trip->distance)<span>Distance: {{ number_format($trip->distance, 1) }} km</span>@endif
        </div>
    </div>

    <div class="body">

        {{-- Route --}}
        <div class="route-box">
            <div class="route-label">Route</div>
            <div class="route-text">{{ $trip->start_location }} &rarr; {{ $trip->end_location }}</div>
        </div>

        {{-- Stats --}}
        <table class="stats-table">
            <tr>
                <td class="stat-cell">
                    <div class="stat-num">{{ $trip->distance ? number_format($trip->distance, 1) : '—' }}</div>
                    <div class="stat-lbl">Distance (km)</div>
                </td>
                <td class="stat-cell">
                    @if($trip->start_time && $trip->end_time)
                        <div class="stat-num">{{ $trip->start_time->diffInMinutes($trip->end_time) }}</div>
                    @else
                        <div class="stat-num">—</div>
                    @endif
                    <div class="stat-lbl">Duration (min)</div>
                </td>
                <td class="stat-cell">
                    <div class="stat-num">{{ $trafficCount }}</div>
                    <div class="stat-lbl">Traffic Alerts</div>
                </td>
                <td class="stat-cell">
                    <div class="stat-num">{{ $routeCount }}</div>
                    <div class="stat-lbl">Routes Accepted</div>
                </td>
            </tr>
        </table>

        {{-- Trip Info + Assignment --}}
        <table class="two-col-table">
            <tr>
                <td class="col-left">
                    <div class="section">
                        <div class="section-title">Trip Information</div>
                        <div class="card">
                            <table class="info-table">
                                <tr class="info-row"><td class="info-label">Trip ID</td><td class="info-value">#{{ str_pad($trip->id, 4, '0', STR_PAD_LEFT) }}</td></tr>
                                <tr class="info-row"><td class="info-label">Start Location</td><td class="info-value">{{ $trip->start_location }}</td></tr>
                                <tr class="info-row"><td class="info-label">End Location</td><td class="info-value">{{ $trip->end_location }}</td></tr>
                                <tr class="info-row"><td class="info-label">Start Time</td><td class="info-value">{{ $trip->start_time->format('M d, Y h:i A') }}</td></tr>
                                <tr class="info-row"><td class="info-label">End Time</td><td class="info-value">{{ $trip->end_time ? $trip->end_time->format('M d, Y h:i A') : 'Not finished' }}</td></tr>
                                <tr class="info-row"><td class="info-label">Status</td><td class="info-value"><span class="badge badge-{{ $trip->status }}">{{ ucfirst(str_replace('_', ' ', $trip->status)) }}</span></td></tr>
                                <tr class="info-row"><td class="info-label">Distance</td><td class="info-value">{{ $trip->distance ? number_format($trip->distance, 1) . ' km' : 'N/A' }}</td></tr>
                            </table>
                        </div>
                    </div>
                </td>
                <td class="col-right">
                    <div class="section">
                        <div class="section-title">Assignment</div>
                        <div class="card">
                            <table class="info-table">
                                <tr class="info-row"><td class="info-label">Driver</td><td class="info-value">{{ $trip->driver->name ?? 'Unassigned' }}</td></tr>
                                <tr class="info-row"><td class="info-label">License No.</td><td class="info-value">{{ $trip->driver->license_number ?? 'N/A' }}</td></tr>
                                <tr class="info-row"><td class="info-label">Vehicle</td><td class="info-value">{{ $trip->vehicle->plate_number ?? 'N/A' }}</td></tr>
                                <tr class="info-row"><td class="info-label">Make & Model</td><td class="info-value">{{ ($trip->vehicle->make ?? '') . ' ' . ($trip->vehicle->model ?? '') }}</td></tr>
                                <tr class="info-row"><td class="info-label">Vehicle Type</td><td class="info-value">{{ $trip->vehicle->type ?? 'N/A' }}</td></tr>
                            </table>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">Traffic Summary</div>
                        <div class="card">
                            <table class="info-table">
                                <tr class="info-row">
                                    <td class="info-label">High/Severe Alerts</td>
                                    <td class="info-value">
                                        @if($trafficCount > 0)
                                            <span class="alert-high">{{ $trafficCount }} alert{{ $trafficCount > 1 ? 's' : '' }}</span>
                                        @else
                                            <span class="alert-none">No alerts</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="info-row"><td class="info-label">Routes Accepted</td><td class="info-value">{{ $routeCount }}</td></tr>
                                @php
                                    try { $latestTraffic = $trip->trafficData()->latest('timestamp')->first(); } catch(\Exception $e) { $latestTraffic = null; }
                                @endphp
                                @if($latestTraffic)
                                    <tr class="info-row"><td class="info-label">Last Speed</td><td class="info-value">{{ number_format($latestTraffic->speed, 1) }} km/h</td></tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        {{-- Timeline --}}
        <div class="section">
            <div class="section-title">Trip Timeline</div>
            <div class="card">
                <table class="timeline-table">

                    {{-- Created --}}
                    <tr>
                        <td class="tl-dot-cell"><div class="tl-dot tl-dot-done"></div></td>
                        <td class="tl-content">
                            <div class="tl-title">Trip Created</div>
                            <div class="tl-desc">Scheduled from {{ $trip->start_location }} to {{ $trip->end_location }}</div>
                            <div class="tl-time">{{ $trip->created_at->format('M d, Y h:i A') }}</div>
                        </td>
                    </tr>
                    <tr><td class="tl-line-cell"><div class="tl-line"></div></td><td></td></tr>

                    {{-- Started --}}
                    @if(in_array($trip->status, ['in_progress', 'completed']))
                    <tr>
                        <td class="tl-dot-cell"><div class="tl-dot tl-dot-done"></div></td>
                        <td class="tl-content">
                            <div class="tl-title">Trip Started</div>
                            <div class="tl-desc">Departed from {{ $trip->start_location }}</div>
                            <div class="tl-time">{{ $trip->start_time->format('M d, Y h:i A') }}</div>
                        </td>
                    </tr>
                    <tr><td class="tl-line-cell"><div class="tl-line"></div></td><td></td></tr>
                    @endif

                    {{-- Traffic --}}
                    @if($trafficCount > 0)
                    <tr>
                        <td class="tl-dot-cell"><div class="tl-dot tl-dot-orange"></div></td>
                        <td class="tl-content">
                            <div class="tl-title">Traffic Alerts Encountered</div>
                            <div class="tl-desc">{{ $trafficCount }} high/severe congestion incident{{ $trafficCount > 1 ? 's' : '' }} recorded</div>
                        </td>
                    </tr>
                    <tr><td class="tl-line-cell"><div class="tl-line"></div></td><td></td></tr>
                    @endif

                    {{-- Completed / Pending --}}
                    @if($trip->status === 'completed' && $trip->end_time)
                    <tr>
                        <td class="tl-dot-cell"><div class="tl-dot tl-dot-green"></div></td>
                        <td class="tl-content">
                            <div class="tl-title">Trip Completed</div>
                            <div class="tl-desc">
                                Arrived at {{ $trip->end_location }}
                                &middot; Duration: {{ $trip->start_time->diffInMinutes($trip->end_time) }} min
                                @if($trip->distance) &middot; {{ number_format($trip->distance, 1) }} km @endif
                            </div>
                            <div class="tl-time">{{ $trip->end_time->format('M d, Y h:i A') }}</div>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td class="tl-dot-cell"><div class="tl-dot tl-dot-gray"></div></td>
                        <td class="tl-content">
                            <div class="tl-title tl-muted">Trip not yet completed</div>
                            <div class="tl-desc">End time will be recorded upon completion</div>
                        </td>
                    </tr>
                    @endif

                </table>
            </div>
        </div>

        {{-- Record Info --}}
        <div class="section">
            <div class="section-title">Record Information</div>
            <div class="card">
                <table class="info-table">
                    <tr class="info-row"><td class="info-label">Created At</td><td class="info-value">{{ $trip->created_at->format('M d, Y h:i A') }}</td></tr>
                    <tr class="info-row"><td class="info-label">Last Updated</td><td class="info-value">{{ $trip->updated_at->format('M d, Y h:i A') }}</td></tr>
                </table>
            </div>
        </div>

    </div>
</body>
</html>