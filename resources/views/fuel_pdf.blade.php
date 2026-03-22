<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fuel Record #{{ str_pad($fuel_record->id, 4, '0', STR_PAD_LEFT) }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #1f2937; background: #ffffff; }

        /* ── Header ── */
        .header { background: #ea580c; padding: 24px 32px; color: white; }
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

        /* ── Body ── */
        .body { padding: 24px 32px; }

        /* ── ID banner ── */
        .id-box { background: #fff7ed; border: 1px solid #fed7aa; border-radius: 6px; padding: 12px 16px; margin-bottom: 20px; display: table; width: 100%; }
        .id-left  { display: table-cell; vertical-align: middle; }
        .id-right { display: table-cell; vertical-align: middle; text-align: right; }
        .id-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; color: #ea580c; margin-bottom: 3px; }
        .id-value { font-size: 18px; font-weight: 700; color: #9a3412; }
        .fuel-tag { background: #fef3c7; border: 1px solid #fde68a; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; }

        /* ── Stats ── */
        .stats-table { width: 100%; border-collapse: separate; border-spacing: 8px 0; margin: 0 -8px 20px; }
        .stat-cell { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; padding: 12px; text-align: center; }
        .stat-num  { font-size: 18px; font-weight: 700; color: #ea580c; }
        .stat-lbl  { font-size: 9px; color: #6b7280; margin-top: 2px; text-transform: uppercase; letter-spacing: .3px; }

        /* ── Section ── */
        .section { margin-bottom: 20px; page-break-inside: avoid; }
        .section-title { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: #ea580c; border-bottom: 2px solid #fed7aa; padding-bottom: 5px; margin-bottom: 12px; }

        /* ── Two columns ── */
        .two-col-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .col-left  { width: 50%; vertical-align: top; padding-right: 12px; }
        .col-right { width: 50%; vertical-align: top; padding-left: 12px; border-left: 1px solid #e5e7eb; }

        /* ── Card ── */
        .card { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; padding: 14px; margin-bottom: 14px; }

        /* ── Info table ── */
        .info-table { width: 100%; border-collapse: collapse; }
        .info-label { width: 45%; padding: 5px 8px 5px 0; font-size: 10px; color: #6b7280; font-weight: 600; vertical-align: top; }
        .info-value { padding: 5px 0; font-size: 11px; color: #111827; font-weight: 500; vertical-align: top; }
        .info-row + .info-row td { border-top: 1px solid #f3f4f6; }

        /* ── Cost breakdown ── */
        .cost-table { width: 100%; border-collapse: collapse; }
        .cost-row td { padding: 8px 0; border-bottom: 1px solid #f3f4f6; font-size: 11px; }
        .cost-row:last-child td { border-bottom: none; }
        .cost-label-cell { color: #6b7280; }
        .cost-value-cell { text-align: right; font-weight: 600; color: #111827; }
        .cost-total-row td { padding-top: 10px; border-top: 2px solid #e5e7eb; font-size: 14px; font-weight: 700; color: #ea580c; }

        /* ── Fuel gauge visual ── */
        .gauge-box { background: #fff7ed; border: 1px solid #fed7aa; border-radius: 6px; padding: 14px; margin-bottom: 14px; text-align: center; }
        .gauge-label { font-size: 9px; color: #6b7280; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 8px; }
        .gauge-bar-bg { background: #e5e7eb; border-radius: 99px; height: 12px; width: 100%; margin-bottom: 6px; overflow: hidden; }
        .gauge-bar-fill { background: linear-gradient(to right, #f97316, #ea580c); height: 12px; border-radius: 99px; }
        .gauge-nums { display: table; width: 100%; font-size: 9px; color: #9ca3af; }
        .gauge-left  { display: table-cell; text-align: left; }
        .gauge-right { display: table-cell; text-align: right; }
        .gauge-center { display: table-cell; text-align: center; font-weight: 700; font-size: 18px; color: #ea580c; }

        /* ── Footer ── */
        .footer { position: fixed; bottom: 0; left: 0; right: 0; padding: 8px 32px; background: #f9fafb; border-top: 1px solid #e5e7eb; }
        .footer-table { width: 100%; border-collapse: collapse; }
        .footer-left  { font-size: 9px; color: #9ca3af; }
        .footer-right { font-size: 9px; color: #9ca3af; text-align: right; }
    </style>
</head>
<body>

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
                <div class="doc-title">Fuel Record</div>
                <div class="doc-id">#{{ str_pad($fuel_record->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>
        <hr class="header-divider">
        <div class="header-meta">
            <span>Generated: {{ now()->format('M d, Y h:i A') }}</span>
            <span>Date: {{ \Carbon\Carbon::parse($fuel_record->date)->format('M d, Y') }}</span>
            <span>Vehicle: {{ $fuel_record->vehicle->plate_number ?? 'N/A' }}</span>
        </div>
    </div>

    <div class="body">

        {{-- ID + Fuel Type banner --}}
        <div class="id-box">
            <div class="id-left">
                <div class="id-label">Fuel Record</div>
                <div class="id-value">#{{ str_pad($fuel_record->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="id-right">
                <span class="fuel-tag">{{ $fuel_record->fuel_type }}</span>
            </div>
        </div>

        {{-- Stats --}}
        <table class="stats-table">
            <tr>
                <td class="stat-cell">
                    <div class="stat-num">{{ number_format($fuel_record->quantity, 2) }}L</div>
                    <div class="stat-lbl">Quantity</div>
                </td>
                <td class="stat-cell">
                    <div class="stat-num">&#8369;{{ number_format($fuel_record->price_per_liter ?? 0, 2) }}</div>
                    <div class="stat-lbl">Price / Liter</div>
                </td>
                <td class="stat-cell">
                    <div class="stat-num">&#8369;{{ number_format($fuel_record->cost, 2) }}</div>
                    <div class="stat-lbl">Total Cost</div>
                </td>
                <td class="stat-cell">
                    <div class="stat-num">{{ $fuel_record->odometer ? number_format($fuel_record->odometer) : '—' }}</div>
                    <div class="stat-lbl">Odometer (km)</div>
                </td>
            </tr>
        </table>

        {{-- Main Info --}}
        <table class="two-col-table">
            <tr>
                <td class="col-left">
                    <div class="section">
                        <div class="section-title">Vehicle Information</div>
                        <div class="card">
                            <table class="info-table">
                                <tr class="info-row">
                                    <td class="info-label">Plate Number</td>
                                    <td class="info-value">{{ $fuel_record->vehicle->plate_number ?? 'N/A' }}</td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Make</td>
                                    <td class="info-value">{{ $fuel_record->vehicle->make ?? 'N/A' }}</td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Model</td>
                                    <td class="info-value">{{ $fuel_record->vehicle->model ?? 'N/A' }}</td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Type</td>
                                    <td class="info-value">{{ $fuel_record->vehicle->type ?? 'N/A' }}</td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Status</td>
                                    <td class="info-value">{{ ucfirst($fuel_record->vehicle->status ?? 'N/A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">Fuel Details</div>
                        <div class="card">
                            <table class="info-table">
                                <tr class="info-row">
                                    <td class="info-label">Fuel Type</td>
                                    <td class="info-value">{{ $fuel_record->fuel_type }}</td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Date</td>
                                    <td class="info-value">{{ \Carbon\Carbon::parse($fuel_record->date)->format('M d, Y') }}</td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Gas Station</td>
                                    <td class="info-value">{{ $fuel_record->gas_station ?? '—' }}</td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Odometer</td>
                                    <td class="info-value">{{ $fuel_record->odometer ? number_format($fuel_record->odometer) . ' km' : '—' }}</td>
                                </tr>
                                @if($fuel_record->notes)
                                <tr class="info-row">
                                    <td class="info-label">Notes</td>
                                    <td class="info-value">{{ $fuel_record->notes }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </td>

                <td class="col-right">
                    <div class="section">
                        <div class="section-title">Cost Breakdown</div>

                        {{-- Fuel gauge visual --}}
                        <div class="gauge-box">
                            <div class="gauge-label">Quantity Filled</div>
                            <div class="gauge-nums">
                                <span class="gauge-left">0L</span>
                                <span class="gauge-center">{{ number_format($fuel_record->quantity, 1) }}L</span>
                                <span class="gauge-right">100L</span>
                            </div>
                            <div class="gauge-bar-bg">
                                <div class="gauge-bar-fill" style="width: {{ min(100, ($fuel_record->quantity / 100) * 100) }}%;"></div>
                            </div>
                        </div>

                        <div class="card">
                            <table class="cost-table">
                                <tr class="cost-row">
                                    <td class="cost-label-cell">Quantity</td>
                                    <td class="cost-value-cell">{{ number_format($fuel_record->quantity, 2) }} L</td>
                                </tr>
                                <tr class="cost-row">
                                    <td class="cost-label-cell">Price per Liter</td>
                                    <div class="stat-num">PHP {{ number_format($fuel_record->price_per_liter ?? 0, 2) }}</div>
                                </tr>
                                <tr class="cost-row cost-total-row">
                                    <td class="cost-label-cell">Total Cost</td>
                                    <td class="cost-value-cell">&#8369;{{ number_format($fuel_record->cost, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">Record Information</div>
                        <div class="card">
                            <table class="info-table">
                                <tr class="info-row">
                                    <td class="info-label">Record ID</td>
                                    <td class="info-value">#{{ str_pad($fuel_record->id, 4, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Created At</td>
                                    <td class="info-value">{{ $fuel_record->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Last Updated</td>
                                    <td class="info-value">{{ $fuel_record->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

    </div>
</body>
</html>