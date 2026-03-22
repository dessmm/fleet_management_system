<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Maintenance Record #{{ str_pad($maintenance_record->id, 4, '0', STR_PAD_LEFT) }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #1f2937; background: #ffffff; }

        /* ── Header ── */
        .header { background: #dc2626; padding: 24px 32px; color: white; }
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

        /* ── Record ID banner ── */
        .id-box { background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; padding: 12px 16px; margin-bottom: 20px; display: table; width: 100%; }
        .id-left  { display: table-cell; vertical-align: middle; }
        .id-right { display: table-cell; vertical-align: middle; text-align: right; }
        .id-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; color: #dc2626; margin-bottom: 3px; }
        .id-value { font-size: 18px; font-weight: 700; color: #991b1b; }
        .issue-tag { background: #fef3c7; border: 1px solid #fde68a; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; }

        /* ── Stats ── */
        .stats-table { width: 100%; border-collapse: separate; border-spacing: 8px 0; margin: 0 -8px 20px; }
        .stat-cell { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; padding: 12px; text-align: center; width: 33.33%; }
        .stat-num  { font-size: 20px; font-weight: 700; color: #dc2626; }
        .stat-lbl  { font-size: 9px; color: #6b7280; margin-top: 2px; text-transform: uppercase; letter-spacing: .3px; }

        /* ── Section ── */
        .section { margin-bottom: 20px; page-break-inside: avoid; }
        .section-title { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: #dc2626; border-bottom: 2px solid #fee2e2; padding-bottom: 5px; margin-bottom: 12px; }

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

        /* ── Cost highlight ── */
        .cost-box { background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; padding: 16px; text-align: center; margin-bottom: 14px; }
        .cost-label { font-size: 10px; color: #6b7280; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px; }
        .cost-value { font-size: 28px; font-weight: 700; color: #dc2626; }

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
                <div class="doc-title">Maintenance Report</div>
                <div class="doc-id">#{{ str_pad($maintenance_record->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>
        <hr class="header-divider">
        <div class="header-meta">
            <span>Generated: {{ now()->format('M d, Y h:i A') }}</span>
            <span>Service Date: {{ $maintenance_record->service_date->format('M d, Y') }}</span>
            <span>Vehicle: {{ $maintenance_record->vehicle->plate_number ?? 'N/A' }}</span>
        </div>
    </div>

    <div class="body">

        {{-- Record ID + Issue banner --}}
        <div class="id-box">
            <div class="id-left">
                <div class="id-label">Maintenance Record</div>
                <div class="id-value">#{{ str_pad($maintenance_record->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="id-right">
                <span class="issue-tag">{{ $maintenance_record->issue }}</span>
            </div>
        </div>

        {{-- Stats --}}
        <table class="stats-table">
            <tr>
                <td class="stat-cell">
                    <div class="stat-num">${{ number_format($maintenance_record->cost, 2) }}</div>
                    <div class="stat-lbl">Total Cost</div>
                </td>
                <td class="stat-cell">
                    <div class="stat-num">{{ $maintenance_record->service_date->format('M d') }}</div>
                    <div class="stat-lbl">Service Date</div>
                </td>
                <td class="stat-cell">
                    <div class="stat-num">{{ $maintenance_record->service_date->diffForHumans() }}</div>
                    <div class="stat-lbl">Time Since Service</div>
                </td>
            </tr>
        </table>

        {{-- Main info --}}
        <table class="two-col-table">
            <tr>
                <td class="col-left">
                    <div class="section">
                        <div class="section-title">Vehicle Information</div>
                        <div class="card">
                            <table class="info-table">
                                <tr class="info-row">
                                    <td class="info-label">Plate Number</td>
                                    <td class="info-value">{{ $maintenance_record->vehicle->plate_number ?? 'N/A' }}</td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Make</td>
                                    <td class="info-value">{{ $maintenance_record->vehicle->make ?? 'N/A' }}</td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Model</td>
                                    <td class="info-value">{{ $maintenance_record->vehicle->model ?? 'N/A' }}</td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Type</td>
                                    <td class="info-value">{{ $maintenance_record->vehicle->type ?? 'N/A' }}</td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Capacity</td>
                                    <td class="info-value">
                                        {{ $maintenance_record->vehicle->capacity ? number_format($maintenance_record->vehicle->capacity) . ' kg' : 'N/A' }}
                                    </td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Status</td>
                                    <td class="info-value">{{ ucfirst($maintenance_record->vehicle->status ?? 'N/A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
                <td class="col-right">
                    <div class="section">
                        <div class="section-title">Service Details</div>

                        {{-- Cost highlight --}}
                        <div class="cost-box">
                            <div class="cost-label">Total Cost</div>
                            <div class="cost-value">${{ number_format($maintenance_record->cost, 2) }}</div>
                        </div>

                        <div class="card">
                            <table class="info-table">
                                <tr class="info-row">
                                    <td class="info-label">Issue / Service</td>
                                    <td class="info-value">{{ $maintenance_record->issue }}</td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Service Date</td>
                                    <td class="info-value">{{ $maintenance_record->service_date->format('M d, Y') }}</td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Technician</td>
                                    <td class="info-value">{{ $maintenance_record->technician_name }}</td>
                                </tr>
                                <tr class="info-row">
                                    <td class="info-label">Record ID</td>
                                    <td class="info-value">#{{ str_pad($maintenance_record->id, 4, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        {{-- Record Info --}}
        <div class="section">
            <div class="section-title">Record Information</div>
            <div class="card">
                <table class="info-table">
                    <tr class="info-row">
                        <td class="info-label">Created At</td>
                        <td class="info-value">{{ $maintenance_record->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                    <tr class="info-row">
                        <td class="info-label">Last Updated</td>
                        <td class="info-value">{{ $maintenance_record->updated_at->format('M d, Y h:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Notes / disclaimer --}}
        <div class="section">
            <div class="card" style="background: #fef2f2; border-color: #fecaca;">
                <p style="font-size: 10px; color: #991b1b; font-weight: 600; margin-bottom: 4px;">Important Note</p>
                <p style="font-size: 10px; color: #6b7280; line-height: 1.5;">
                    This maintenance record serves as an official document of service performed on the vehicle.
                    Keep this record for warranty and compliance purposes.
                    Next scheduled maintenance should be planned within 90 days of this service date.
                </p>
            </div>
        </div>

    </div>
</body>
</html>