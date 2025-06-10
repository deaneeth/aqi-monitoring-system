@extends('layouts.app')

@section('content')
<div class="alert-center-container">
    <h2>🚨 AQI Alert Center</h2>

    @if($activeAlerts->count() > 0)
        <div class="alert-box danger">
            ⚠️ <strong>Active AQI Alerts Detected!</strong>
        </div>

        <div class="table-container">
            <table class="alert-table">
                <thead>
                    <tr>
                        <th>📍 Sensor Name</th>
                        <th>📈 Latest AQI</th>
                        <th>🛑 Alert Level</th>
                        <th>⏰ Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activeAlerts as $sensor)
                        @php
                            $latest = $sensor->data->first();
                        @endphp

                        @if($latest)
                            @php
                                $level = \App\Models\SensorData::getAQILevel($latest->aqi);
                            @endphp
                            <tr>
                                <td>{{ $sensor->name }}</td>
                                <td><strong>{{ $latest->aqi }}</strong></td>
                                <td>
                                    <span class="alert-badge" style="background: {{ $level->color_code }}">
                                        {{ $level->level_name }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($latest->timestamp)->format('Y-m-d h:i A') }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert-box success">
            ✅ No active AQI alerts at the moment.
        </div>
    @endif
</div>

<!-- Internal CSS -->
<style>
    .alert-center-container {
        max-width: 1100px;
        margin: 30px auto;
        padding: 25px;
        background: #111827;
        color: white;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.5);
        font-family: 'Segoe UI', sans-serif;
    }

    .alert-center-container h2 {
        margin-bottom: 20px;
        color: #00e0ff;
        text-align: center;
        font-weight: 600;
    }

    .alert-box {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .alert-box.success {
        background-color: #1e5631;
        color: #d4edda;
        border-left: 6px solid #28a745;
    }

    .alert-box.danger {
        background-color: #661919;
        color: #f8d7da;
        border-left: 6px solid #dc3545;
    }

    .table-container {
        overflow-x: auto;
        margin-top: 15px;
    }

    .alert-table {
        width: 100%;
        border-collapse: collapse;
        background: #1f2937;
        color: white;
        border-radius: 8px;
        overflow: hidden;
    }

    .alert-table thead {
        background-color: #111827;
        text-align: left;
    }

    .alert-table th,
    .alert-table td {
        padding: 16px;
        border-bottom: 1px solid #333;
    }

    .alert-table tbody tr:hover {
        background-color: #2a2f4a;
    }

    .alert-badge {
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: bold;
        display: inline-block;
    }
</style>
@endsection
