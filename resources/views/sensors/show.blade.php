@extends('layouts.app')

@section('content')
<style>
    .sensor-card {
        background: linear-gradient(to right, #1e3c72, #2a5298);
        border-radius: 12px;
        padding: 30px;
        color: #fff;
        max-width: 600px;
        margin: 40px auto;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        font-family: 'Segoe UI', sans-serif;
    }

    .sensor-card h2 {
        margin-bottom: 25px;
        font-weight: bold;
        border-bottom: 1px solid rgba(255,255,255,0.3);
        padding-bottom: 10px;
    }

    .sensor-card p {
        font-size: 16px;
        margin-bottom: 12px;
    }

    .sensor-card p strong {
        display: inline-block;
        width: 120px;
        color: #ccc;
    }

    .sensor-card .status-indicator {
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: bold;
        color: white;
        font-size: 14px;
        display: inline-block;
    }

    .sensor-card .status-active {
        background-color: #28a745;
    }

    .sensor-card .status-inactive {
        background-color: #dc3545;
    }

    .back-link {
        display: inline-block;
        margin-top: 20px;
        text-decoration: none;
        color: #fff;
        background: #444;
        padding: 8px 16px;
        border-radius: 6px;
        transition: background 0.3s;
    }

    .back-link:hover {
        background: #666;
    }
</style>

<div class="sensor-card">
    <h2>📍 Sensor Details</h2>

    <p><strong>Name:</strong> {{ $sensor->name }}</p>
    <p><strong>Latitude:</strong> {{ $sensor->latitude }}</p>
    <p><strong>Longitude:</strong> {{ $sensor->longitude }}</p>
    <p><strong>Status:</strong>
        <span class="status-indicator {{ $sensor->status === 'active' ? 'status-active' : 'status-inactive' }}">
            {{ ucfirst($sensor->status) }}
        </span>
    </p>

    <a href="{{ route('sensors.index') }}" class="back-link">← Back to Sensor List</a>
</div>
@endsection
