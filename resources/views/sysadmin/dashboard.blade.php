@extends('layouts.app')

@section('content')
<style>
    .sysadmin-container {
        max-width: 1300px;
        margin: 60px auto;
        padding: 40px;
        font-family: 'Segoe UI', sans-serif;
        color: #f8f9fa;
        display: grid;
        gap: 30px;
    }

    .dashboard-header {
        text-align: center;
        font-size: 38px;
        font-weight: 700;
        color: #00eaff;
        margin-bottom: 10px;
        text-shadow: 0 2px 10px rgba(0,255,255,0.3);
    }

    .grid-layout {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .dashboard-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 25px 30px;
        backdrop-filter: blur(14px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }

    .dashboard-card:hover {
        transform: scale(1.015);
        box-shadow: 0 25px 50px rgba(0, 255, 255, 0.08);
    }

    .dashboard-card h4 {
        font-size: 22px;
        color: #00eaff;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .card-value {
        font-size: 20px;
        font-weight: bold;
        color: #ffd369;
        margin-top: 5px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .data-table th, .data-table td {
        padding: 12px 18px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        text-align: left;
    }

    .data-table th {
        background: rgba(0, 255, 255, 0.1);
        color: #00f0ff;
    }

    .data-table td {
        color: #f1f1f1;
    }

    .info-list {
        list-style: none;
        padding-left: 0;
    }

    .info-list li {
        padding: 10px 0;
        border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: space-between;
    }

    .info-key {
        color: #00ffc3;
        font-weight: 600;
    }

    .info-value {
        color: #f1f1f1;
    }

    .icon {
        font-size: 20px;
        margin-right: 10px;
        color: #00ffea;
    }
</style>

<div class="sysadmin-container">
    <h2 class="dashboard-header">🛡️ System Administrator Dashboard</h2>

    <div class="grid-layout">
        <!-- Database Size -->
        <div class="dashboard-card">
            <h4><i class="fas fa-database icon"></i>Database Usage</h4>
            <p>Total Size:</p>
            <div class="card-value">{{ $dbSizeMB }} MB</div>
        </div>

        <!-- Laravel Config -->
        <div class="dashboard-card">
            <h4><i class="fas fa-cogs icon"></i>App Configuration</h4>
            <ul class="info-list">
                <li><span class="info-key">Laravel:</span><span class="info-value">{{ $config['laravel_version'] }}</span></li>
                <li><span class="info-key">PHP:</span><span class="info-value">{{ $config['php_version'] }}</span></li>
                <li><span class="info-key">Environment:</span><span class="info-value">{{ strtoupper($config['env']) }}</span></li>
                <li><span class="info-key">DB Driver:</span><span class="info-value">{{ $config['db_connection'] }}</span></li>
            </ul>
        </div>

        <!-- Security -->
        <div class="dashboard-card">
            <h4><i class="fas fa-shield-alt icon"></i>Security Overview</h4>
            <ul class="info-list">
                <li><span class="info-key">HTTPS:</span><span class="info-value">{{ $security['https'] ? '✅ Enabled' : '❌ Disabled' }}</span></li>
                <li><span class="info-key">Debug Mode:</span><span class="info-value">{{ $security['debug_mode'] ? '🟡 ON' : '🟢 OFF' }}</span></li>
                <li><span class="info-key">CSRF:</span><span class="info-value">{{ $security['csrf_protection'] ? '🛡️ Active' : '⚠️ Missing' }}</span></li>
                <li><span class="info-key">Session:</span><span class="info-value">{{ $security['session_driver'] }}</span></li>
            </ul>
        </div>
    </div>

    <!-- Admin Users -->
    <div class="dashboard-card">
        <h4><i class="fas fa-users-cog icon"></i>Registered Monitoring Admins</h4>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registered On</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($admins as $admin)
                    <tr>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No admin accounts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
