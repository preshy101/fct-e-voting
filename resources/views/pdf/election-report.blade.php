<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Official Election Report - {{ $election->title }}</title>
    <style>
        @page {
            margin: 25px 35px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            line-height: 1.4;
            font-size: 12px;
        }
        .header-container {
            border-bottom: 3px solid #008751;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header-title {
            color: #008751;
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header-sub {
            color: #475569;
            font-size: 13px;
            margin: 4px 0 0 0;
            font-weight: 600;
        }
        .meta-grid {
            width: 100%;
            margin-bottom: 20px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
        }
        .meta-grid td {
            padding: 10px 14px;
            vertical-align: top;
        }
        .meta-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .meta-value {
            font-size: 13px;
            font-weight: bold;
            color: #0f172a;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-active { background-color: #dcfce7; color: #15803d; }
        .badge-inactive { background-color: #f1f5f9; color: #475569; }

        /* Chart & Legend layout */
        .chart-section {
            width: 100%;
            margin-bottom: 25px;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
        }
        .section-header {
            background-color: #f8fafc;
            padding: 8px 14px;
            font-weight: bold;
            font-size: 12px;
            color: #1e293b;
            border-bottom: 1px solid #e2e8f0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .chart-layout-table {
            width: 100%;
        }
        .chart-col {
            width: 45%;
            text-align: center;
            padding: 15px 10px;
            vertical-align: middle;
        }
        .legend-col {
            width: 55%;
            padding: 15px 20px 15px 5px;
            vertical-align: middle;
        }
        .legend-item {
            margin-bottom: 8px;
        }
        .color-dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 3px;
            margin-right: 6px;
            vertical-align: middle;
        }

        /* Results Table */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .table th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 9px 12px;
            text-align: left;
        }
        .table td {
            border-bottom: 1px solid #e2e8f0;
            padding: 9px 12px;
            font-size: 11px;
        }
        .table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .progress-bar-bg {
            background-color: #e2e8f0;
            border-radius: 4px;
            height: 8px;
            width: 100px;
            display: inline-block;
            vertical-align: middle;
            margin-right: 8px;
            overflow: hidden;
        }
        .progress-bar-fill {
            background-color: #008751;
            height: 8px;
            border-radius: 4px;
        }

        .footer {
            margin-top: 30px;
            border-top: 1px solid #e2e8f0;
            padding-top: 12px;
            font-size: 9px;
            color: #64748b;
            text-align: center;
        }
    </style>
</head>
<body>

    @php
        $totalVotes = $election->votes()->count();
        $candidates = $election->candidates;
        $palette = ['#008751', '#3b82f6', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4', '#10b981', '#6366f1', '#f97316', '#14b8a6'];
        
        $candidateData = [];
        foreach($candidates as $idx => $candidate) {
            $votes = $candidate->votes->count();
            $percentage = $totalVotes > 0 ? ($votes / $totalVotes) * 100 : 0;
            $color = $palette[$idx % count($palette)];
            $candidateData[] = [
                'name' => $candidate->full_name,
                'votes' => $votes,
                'percentage' => round($percentage, 2),
                'fraction' => $totalVotes > 0 ? ($votes / $totalVotes) : 0,
                'color' => $color,
            ];
        }

        // Generate high-resolution Pie Chart PNG via PHP GD
        $chartWidth = 460;
        $chartHeight = 460;
        $img = imagecreatetruecolor($chartWidth, $chartHeight);
        imagealphablending($img, false);
        imagesavealpha($img, true);
        $transparent = imagecolorallocatealpha($img, 255, 255, 255, 127);
        imagefilledrectangle($img, 0, 0, $chartWidth, $chartHeight, $transparent);
        imagealphablending($img, true);

        $cx = $chartWidth / 2;
        $cy = $chartHeight / 2;
        $diameter = $chartWidth - 40;

        if ($totalVotes == 0) {
            $gray = imagecolorallocate($img, 226, 232, 240);
            imagefilledellipse($img, $cx, $cy, $diameter, $diameter, $gray);
        } else {
            $currentAngle = 0;
            foreach ($candidateData as $c) {
                if ($c['fraction'] <= 0) continue;
                $angleSpan = $c['fraction'] * 360;
                $endAngle = $currentAngle + $angleSpan;

                $hex = ltrim($c['color'], '#');
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));

                $sliceColor = imagecolorallocate($img, $r, $g, $b);
                imagefilledarc($img, $cx, $cy, $diameter, $diameter, (int)round($currentAngle), (int)round($endAngle), $sliceColor, IMG_ARC_PIE);

                $currentAngle = $endAngle;
            }

            // Donut center hole for modern presentation
            $white = imagecolorallocate($img, 255, 255, 255);
            $holeDiameter = $diameter * 0.45;
            imagefilledellipse($img, $cx, $cy, (int)$holeDiameter, (int)$holeDiameter, $white);
        }

        ob_start();
        imagepng($img);
        $chartBase64 = 'data:image/png;base64,' . base64_encode(ob_get_clean());
        imagedestroy($img);
    @endphp

    <div class="header-container">
        <table style="width: 100%;">
            <tr>
                <td>
                    <h1 class="header-title"> E-Voting System</h1>
                    <h2 class="header-sub">Official Certified Election Report: {{ $election->title }}</h2>
                </td>
                <td style="text-align: right; vertical-align: bottom;">
                    <span style="font-size: 10px; color: #64748b;">Generated: {{ now()->format('M d, Y h:i A') }}</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- Meta Information Cards -->
    <table class="meta-grid">
        <tr>
            <td style="width: 25%;">
                <div class="meta-label">Election Year</div>
                <div class="meta-value">{{ $election->year ?? 'N/A' }}</div>
            </td>
            <td style="width: 25%;">
                <div class="meta-label">Status</div>
                <div class="meta-value">
                    <span class="badge {{ $election->is_active ? 'badge-active' : 'badge-inactive' }}">
                        {{ $election->is_active ? 'ACTIVE' : 'INACTIVE' }}
                    </span>
                </div>
            </td>
            <td style="width: 25%;">
                <div class="meta-label">Total Candidates</div>
                <div class="meta-value">{{ $candidates->count() }}</div>
            </td>
            <td style="width: 25%;">
                <div class="meta-label">Total Votes Cast</div>
                <div class="meta-value" style="color: #008751;">{{ number_format($totalVotes) }}</div>
            </td>
        </tr>
    </table>

    <!-- Pie Chart Section -->
    <div class="chart-section">
        <div class="section-header">Votes Distribution (Pie Chart Diagram)</div>
        <table class="chart-layout-table">
            <tr>
                <!-- Generated PNG Pie Chart Column -->
                <td class="chart-col">
                    <img src="{{ $chartBase64 }}" width="200" height="200" style="display: block; margin: 0 auto;" alt="Votes Pie Chart" />
                </td>

                <!-- Legend Column -->
                <td class="legend-col">
                    @foreach($candidateData as $c)
                        <table style="width: 100%; margin-bottom: 6px;">
                            <tr>
                                <td style="width: 16px; vertical-align: middle;">
                                    <div class="color-dot" style="background-color: {{ $c['color'] }};"></div>
                                </td>
                                <td style="vertical-align: middle; font-size: 11px; font-weight: 600; color: #1e293b;">
                                    {{ $c['name'] }}
                                </td>
                                <td style="text-align: right; vertical-align: middle; font-size: 11px; font-weight: bold; color: #0f172a;">
                                    {{ number_format($c['votes']) }} <span style="font-weight: normal; color: #64748b;">({{ $c['percentage'] }}%)</span>
                                </td>
                            </tr>
                        </table>
                    @endforeach
                </td>
            </tr>
        </table>
    </div>

    <!-- Tabular Breakdown -->
    <div style="font-weight: bold; font-size: 12px; margin-bottom: 4px; text-transform: uppercase; color: #1e293b;">
        Tabular Candidate Breakdown
    </div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 35px;">#</th>
                <th>Candidate Name</th>
                <th style="width: 100px; text-align: right;">Votes</th>
                <th style="width: 160px;">Share (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($candidateData as $index => $c)
                <tr>
                    <td style="color: #64748b; font-weight: bold;">{{ $index + 1 }}</td>
                    <td style="font-weight: bold; color: #0f172a;">
                        <span class="color-dot" style="background-color: {{ $c['color'] }};"></span>
                        {{ $c['name'] }}
                    </td>
                    <td style="text-align: right; font-weight: bold; color: #008751;">
                        {{ number_format($c['votes']) }}
                    </td>
                    <td>
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width: {{ $c['percentage'] }}%; background-color: {{ $c['color'] }};"></div>
                        </div>
                        <span style="font-weight: bold; font-size: 10px;">{{ $c['percentage'] }}%</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This document is an authentic automated summary generated by the E-Voting Platform. All vote counts have been cryptographically audited.</p>
    </div>

</body>
</html>

