@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Sensor Map - Monitoring Admin</h2>

    <!-- Leaflet Map -->
    <div id="map" style="height: 600px; width: 100%; border-radius: 10px;"></div>

    <!-- Chart Modal -->
    <div id="aqiModal" style="display:none; position:fixed; top:10%; left:10%; width:80%; height:70%; background:#fff; border-radius:8px; z-index:9999; padding:20px; box-shadow: 0 0 15px rgba(0,0,0,0.4);">
        <h3 id="chartTitle" style="margin-bottom: 15px;"></h3>
        <canvas id="aqiChart" width="400" height="200"></canvas>
        <br>
        <button onclick="document.getElementById('aqiModal').style.display='none'"
                style="margin-top:15px; padding:8px 16px; background:#dc3545; color:white; border:none; border-radius:4px;">
            Close
        </button>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const sensors = @json($sensors);
    const thresholds = @json($thresholds);
    const map = L.map('map').setView([6.9271, 79.8612], 12); // Colombo center

    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Add markers for each sensor
    sensors.forEach(sensor => {
        const color = sensor.status === 'active' ? 'green' : 'red';

        const icon = L.icon({
            iconUrl: `http://maps.google.com/mapfiles/ms/icons/${color}-dot.png`,
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        const marker = L.marker([sensor.latitude, sensor.longitude], { icon }).addTo(map);

        marker.bindPopup(`
            <strong>${sensor.name}</strong><br>
            Status: <span style="color:${color}; font-weight: bold;">${sensor.status.toUpperCase()}</span><br>
            <button onclick="showAQIChart(${sensor.id}, '${sensor.name}')" style="margin-top:6px; padding:5px 10px; background:#007bff; color:white; border:none; border-radius:4px;">View AQI Trend</button>
        `);
    });

    // Chart function
    function showAQIChart(sensorId, sensorName) {
        fetch(`/api/sensor/${sensorId}/aqi-history`)
            .then(res => res.json())
            .then(data => {
                const labels = data.map(d => new Date(d.timestamp).toLocaleTimeString());
                const values = data.map(d => d.aqi);

                // Destroy old chart
                if (window.aqiChartInstance) {
                    window.aqiChartInstance.destroy();
                }

                const ctx = document.getElementById('aqiChart').getContext('2d');
                window.aqiChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'AQI (last 24h)',
                            data: values,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                document.getElementById('chartTitle').innerText = `AQI Trend for ${sensorName}`;
                document.getElementById('aqiModal').style.display = 'block';
            });
    }
</script>
@endsection
