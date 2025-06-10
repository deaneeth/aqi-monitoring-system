@extends('layouts.app')

@section('content')
<style>
    .sim-settings {
        max-width: 720px;
        margin: 50px auto;
        background: linear-gradient(145deg, #1a1c2b, #23263b);
        padding: 35px 30px;
        border-radius: 20px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.4);
        color: #f1f1f1;
        font-family: 'Segoe UI', sans-serif;
    }

    .sim-settings h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #00e5ff;
        font-weight: 700;
    }

    .form-label {
        font-weight: 600;
        font-size: 15px;
        margin-bottom: 6px;
        display: block;
        color: #bbb;
    }

    .form-control,
    select {
        background-color: #2b2f47;
        border: 1px solid #444;
        color: #fff;
        border-radius: 10px;
        padding: 12px 15px;
        margin-bottom: 22px;
        transition: 0.3s;
        width: 100%;
    }

    .form-control:focus {
        border-color: #00e5ff;
        box-shadow: 0 0 6px #00e5ff77;
        outline: none;
    }

    .btn-save {
        background: linear-gradient(135deg, #00e6ff, #007bff);
        border: none;
        padding: 14px 30px;
        border-radius: 50px;
        font-weight: bold;
        font-size: 16px;
        color: white;
        display: block;
        margin: 0 auto;
        transition: 0.3s;
        box-shadow: 0 6px 14px rgba(0, 123, 255, 0.4);
    }

    .btn-save:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #00aaff, #0062cc);
        box-shadow: 0 8px 20px rgba(0, 123, 255, 0.6);
    }

    .status {
        text-align: center;
        margin-top: 20px;
        font-weight: 600;
        font-size: 15px;
    }
</style>

<div class="sim-settings">
    <h2>🧪 Simulation Settings</h2>

    <form action="{{ route('simulation.settings.update') }}" method="POST">
        @csrf

        <label class="form-label">Variation Range</label>
        <input type="number" name="variation_range" class="form-control"
               value="{{ optional($settings)->variation_range ?? 10 }}" required>

        <label class="form-label">Simulation Frequency (in minutes)</label>
        <select name="frequency" class="form-control">
            <option value="1"  {{ optional($settings)->frequency == 1 ? 'selected' : '' }}>Every Minute</option>
            <option value="5"  {{ optional($settings)->frequency == 5 ? 'selected' : '' }}>Every 5 Minutes</option>
            <option value="15" {{ optional($settings)->frequency == 15 ? 'selected' : '' }}>Every 15 Minutes</option>
        </select>

        <label class="form-label">Variation Pattern</label>
        <select name="pattern" class="form-control">
            <option value="random"        {{ optional($settings)->pattern == 'random' ? 'selected' : '' }}>Random</option>
            <option value="wave"          {{ optional($settings)->pattern == 'wave' ? 'selected' : '' }}>Wave (Sinusoidal)</option>
            <option value="rush_hour"     {{ optional($settings)->pattern == 'rush_hour' ? 'selected' : '' }}>Rush Hour Pattern</option>
            <option value="industrial"    {{ optional($settings)->pattern == 'industrial' ? 'selected' : '' }}>Industrial Zones</option>
            <option value="stable"        {{ optional($settings)->pattern == 'stable' ? 'selected' : '' }}>Stable / Rural</option>
            <option value="weather"       {{ optional($settings)->pattern == 'weather' ? 'selected' : '' }}>Weather-Driven</option>
            <option value="cumulative"    {{ optional($settings)->pattern == 'cumulative' ? 'selected' : '' }}>Cumulative Increase</option>
            <option value="night_recovery"{{ optional($settings)->pattern == 'night_recovery' ? 'selected' : '' }}>Night Recovery</option>
        </select>

        <label class="form-label">Apply To</label>
        <select name="sensor_scope" class="form-control">
            <option value="all"   {{ optional($settings)->sensor_scope == 'all' ? 'selected' : '' }}>All Sensors</option>
            <option value="active"{{ optional($settings)->sensor_scope == 'active' ? 'selected' : '' }}>Only Active</option>
        </select>

        <label class="form-label">Simulation Status</label>
        <select name="status" class="form-control">
            <option value="active"   {{ optional($settings)->status == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ optional($settings)->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>

        <button type="submit" class="btn-save">💾 Save Simulation Settings</button>
    </form>

    <p class="status">
        Current Simulation Status:
        <span style="color: {{ optional($settings)->status == 'active' ? '#00ff88' : '#ffcc00' }}">
            {{ ucfirst(optional($settings)->status ?? 'unknown') }}
        </span>
    </p>
</div>
@endsection
