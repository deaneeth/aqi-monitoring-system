@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #0f172a;
        color: #fff;
        font-family: 'Segoe UI', sans-serif;
    }

    .dashboard-container {
        max-width: 1200px;
        margin: auto;
        padding: 20px;
    }

    .alert-banner {
        background: linear-gradient(to right, #3f0d12, #a71d31);
        border-left: 6px solid #ff4757;
        color: #fff;
        padding: 24px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(255, 71, 87, 0.3);
        animation: fadeInDown 0.5s ease;
    }

    .alert-banner h4 {
        font-size: 20px;
        margin-bottom: 12px;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-banner ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .alert-banner li {
        font-size: 15px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sensor-name {
        font-weight: 600;
        color: #ffe066;
    }

    .sensor-aqi {
        font-weight: bold;
        color: #fff;
    }

    .badge {
        padding: 4px 10px;
        font-size: 12px;
        font-weight: bold;
        border-radius: 999px;
        color: #fff;
    }

    .stat-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        border-radius: 14px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        transition: transform 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
    }

    .stat-icon {
        font-size: 28px;
        background-color: rgba(255, 255, 255, 0.1);
        padding: 14px;
        border-radius: 50%;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 14px;
        opacity: 0.8;
    }

    .stat-value {
        font-size: 24px;
        font-weight: bold;
        margin-top: 4px;
    }

    .chart-wrapper {
        background: #1e293b;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.2);
    }

    .csv-upload-button {
        background: linear-gradient(135deg, #00c6ff, #0072ff);
        color: #fff;
        padding: 12px 20px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(0, 114, 255, 0.4);
        transition: all 0.25s ease-in-out;
        display: inline-flex;
        align-items: center;
    }

    .csv-upload-button:hover {
        background: linear-gradient(135deg, #0090ff, #004cbf);
        box-shadow: 0 6px 14px rgba(0, 114, 255, 0.6);
        transform: translateY(-2px);
        text-decoration: none;
        color: #fff;
    }

    .csv-upload-button i {
        font-size: 16px;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="dashboard-container">
    <h2 class="text-center mb-4">📊 Monitoring Admin Dashboard</h2>
    <div class="d-flex justify-content-end mb-4">
    <a href="{{ route('data.upload.form') }}" class="csv-upload-button">
        <i class="fas fa-upload me-2"></i> Upload AQI CSV
    </a>
</div>


    <!-- Alerts Section -->
    @if($activeAlerts->count() > 0)
        <div class="alert-banner">
            <h4>⚠️ Active AQI Alerts Detected!</h4>
            <ul>
                @foreach($activeAlerts as $sensor)
                    @php
                        $latest = $sensor->data->first();
                        $level = \App\Models\SensorData::getAQILevel($latest->aqi);
                    @endphp
                    <li>
                        <span class="sensor-name">{{ $sensor->name }}</span> –
                        <span class="sensor-aqi">AQI: {{ $latest->aqi }}</span>
                        @if ($level)
                        <span class="badge" style="background-color: {{ $level->color_code ?? '#6c757d' }}">
    {{ $level->level_name ?? 'Unknown' }}
</span>

@else
    <span class="badge bg-secondary">Unknown</span>
@endif

                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Stat Cards -->
    <div class="stat-cards">
        <div class="stat-card">
            <div class="stat-icon">📡</div>
            <div class="stat-info">
                <div class="stat-label">Total Sensors</div>
                <div class="stat-value">{{ $totalSensors }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-info">
                <div class="stat-label">Active Sensors</div>
                <div class="stat-value">{{ $activeSensors }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">❌</div>
            <div class="stat-info">
                <div class="stat-label">Inactive Sensors</div>
                <div class="stat-value">{{ $inactiveSensors }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⚙️</div>
            <div class="stat-info">
                <div class="stat-label">Simulation Status</div>
                <div class="stat-value">{{ ucfirst($simulationStatus) }}</div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="chart-wrapper mt-4">
        <h5 class="text-center mb-3">📈 Overall AQI Trend (Last 24 Hours)</h5>
        <canvas id="aqiTrendChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {!! json_encode($aqiTrends->pluck('hour')->map(fn($h) => $h . ':00')) !!};
    const data = {!! json_encode($aqiTrends->pluck('avg_aqi')) !!};

    const ctx = document.getElementById('aqiTrendChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Average AQI',
                data,
                borderColor: '#ff6b81',
                backgroundColor: 'rgba(255, 107, 129, 0.2)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: { color: '#eee' }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: '#eee' },
                    title: {
                        display: true,
                        text: 'AQI',
                        color: '#eee'
                    }
                },
                x: {
                    ticks: { color: '#eee' },
                    title: {
                        display: true,
                        text: 'Hour',
                        color: '#eee'
                    }
                }
            }
        }
    });
</script>
@endsection
