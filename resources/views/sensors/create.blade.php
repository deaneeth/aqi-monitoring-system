@extends('layouts.app')

@section('content')
<div class="add-sensor-container">
    <h2>➕ Add New Sensor</h2>

    <!-- Error Display -->
    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Sensor Form -->
    <form action="{{ route('sensors.store') }}" method="POST" class="sensor-form">
        @csrf

        <label for="name">Sensor Name</label>
        <input type="text" name="name" id="name" placeholder="e.g. Colombo Central" required>

        <label for="latitude">Latitude</label>
        <input type="text" name="latitude" id="latitude" required readonly>

        <label for="longitude">Longitude</label>
        <input type="text" name="longitude" id="longitude" required readonly>

        <label for="initial_aqi">Initial AQI</label>
        <input type="number" name="baseline_aqi" id="baseline_aqi" min="0" max="500" placeholder="e.g. 50" value="{{ old('baseline_aqi') }}" required>

        <input type="hidden" name="status" value="active">



        <div id="map" style="height: 300px; border-radius: 10px; margin-top: 10px;"></div>

        <div class="form-buttons">
            <button type="submit" class="btn-add">➕ Add Sensor</button>
            <a href="{{ route('sensors.index') }}" class="btn-cancel">❌ Cancel</a>
        </div>
    </form>
</div>

<!-- Leaflet.js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Initialize map
    const map = L.map('map').setView([6.9271, 79.8612], 11); // Centered in Colombo

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker;

    // Map click handler
    map.on('click', function(e) {
        const { lat, lng } = e.latlng;

        // Set inputs
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);

        // Add or move marker
        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }
    });
</script>

<!-- Internal CSS (from previous) -->
<style>
    .add-sensor-container {
        max-width: 650px;
        margin: 40px auto;
        padding: 30px;
        background-color: #1e1e2f;
        color: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.4);
        font-family: 'Segoe UI', sans-serif;
    }

    .add-sensor-container h2 {
        text-align: center;
        margin-bottom: 25px;
        font-weight: 600;
        color: #00d9ff;
    }

    .error-box {
        background-color: #ffdddd;
        border-left: 5px solid #dc3545;
        color: #721c24;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 6px;
    }

    .sensor-form {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .sensor-form label {
        font-weight: bold;
    }

    .sensor-form input {
        padding: 10px;
        border: none;
        border-radius: 6px;
        background-color: #2c2f4a;
        color: white;
    }

    .sensor-form input[readonly] {
        background-color: #444;
        cursor: not-allowed;
    }

    .sensor-form input::placeholder {
        color: #aaa;
        font-style: italic;
    }

    .sensor-form input:focus {
        outline: 2px solid #00bfff;
    }

    #map {
        margin-top: 10px;
        border: 2px solid #444;
    }

    .form-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .btn-add {
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-cancel {
        background-color: #dc3545;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-add:hover,
    .btn-cancel:hover {
        opacity: 0.9;
    }
</style>
@endsection
