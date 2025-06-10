@extends('layouts.app')

@section('content')
<style>
    .map-wrapper {
        max-width: 1100px;
        margin: 0 auto;
        padding-top: 30px;
        padding-bottom: 30px;
    }

    #map {
        width: 100%;
        height: 600px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .legend-wrapper {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 12px;
        margin-top: 25px;
    }

    .legend-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 14px;
        color: white;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
    }

    .legend-good { background: #009966; }
    .legend-moderate { background: #ffde33; color: #000; }
    .legend-sensitive { background: #ff9933; }
    .legend-unhealthy { background: #cc0033; }
    .legend-very-unhealthy { background: #660099; }
    .legend-hazardous { background: #7e0023; }

    .page-title {
        text-align: center;
        font-weight: 600;
        color: white;
        font-size: 24px;
        margin-bottom: 20px;
    }
</style>

<div class="map-wrapper">
    <h2 class="page-title">📍 Live Air Quality Map - Colombo</h2>

    <div id="map"></div>

    <div class="legend-wrapper">
        <span class="legend-badge legend-good">Good</span>
        <span class="legend-badge legend-moderate">Moderate</span>
        <span class="legend-badge legend-sensitive">Unhealthy for Sensitive Groups</span>
        <span class="legend-badge legend-unhealthy">Unhealthy</span>
        <span class="legend-badge legend-very-unhealthy">Very Unhealthy</span>
        <span class="legend-badge legend-hazardous">Hazardous</span>
    </div>
</div>

<!-- Leaflet + Chart.js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const sensors = @json($sensors);
    const activeSensors = sensors.filter(sensor => sensor.status === 'active');

    const map = L.map('map').setView([6.9271, 79.8612], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    function getAQICategory(aqi) {
        if (aqi <= 50) return { label: "Good", color: "#009966", emoji: "🟢" };
        if (aqi <= 100) return { label: "Moderate", color: "#ffde33", emoji: "😐" };
        if (aqi <= 150) return { label: "Unhealthy for Sensitive Groups", color: "#ff9933", emoji: "😷" };
        if (aqi <= 200) return { label: "Unhealthy", color: "#cc0033", emoji: "🤢" };
        if (aqi <= 300) return { label: "Very Unhealthy", color: "#660099", emoji: "☠️" };
        return { label: "Hazardous", color: "#7e0023", emoji: "💀" };
    }

    activeSensors.forEach(sensor => {
        const latestData = sensor.data && sensor.data.length > 0? sensor.data[0] : null;

        if (!latestData) {
    const marker = L.circleMarker([sensor.latitude, sensor.longitude], {
        radius: 10,
        fillColor: '#999',
        color: '#000',
        weight: 1,
        opacity: 1,
        fillOpacity: 0.5
    }).addTo(map);

    marker.bindPopup(`
        <strong>${sensor.name}</strong><br>
        AQI: <em>Pending</em><br>
        <small style="color:#888;">No data yet. Waiting for simulation.</small>
    `);

    return;
}


        const latestAQI = latestData.aqi;
        const lastUpdated = new Date(latestData.timestamp).toLocaleString();
        const { label, color, emoji } = getAQICategory(latestAQI);
        const canvasId = `chart-${sensor.id}`;

        const marker = L.circleMarker([sensor.latitude, sensor.longitude], {
            radius: 10,
            fillColor: color,
            color: '#000',
            weight: 1,
            opacity: 1,
            fillOpacity: 0.8
        }).addTo(map);

        marker.bindPopup(() => `
            <div style="font-family: sans-serif; min-width: 220px;">
                <strong>${sensor.name}</strong><br>
                AQI: <strong>${latestAQI}</strong><br>
                <div style="
                    display: inline-block;
                    margin: 6px 0;
                    background: ${color};
                    color: ${color === '#ffde33' ? '#000' : '#fff'};
                    padding: 6px 14px;
                    border-radius: 20px;
                    font-weight: bold;
                    font-size: 13px;
                ">
                    ${emoji} ${label}
                </div><br>
                <small style="color:#444;">Updated at ${lastUpdated}</small>
                <canvas id="${canvasId}" width="220" height="100" style="margin-top: 10px;"></canvas>
            </div>
        `);

        marker.on('popupopen', () => {
            fetch(`/api/sensor/${sensor.id}/aqi-history`)
                .then(res => res.json())
                .then(data => {
                    if (!data.length) return;

                    const labels = data.map(d => new Date(d.timestamp).toLocaleTimeString());
                    const values = data.map(d => d.aqi);
                    const ctx = document.getElementById(canvasId).getContext('2d');

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels,
                            datasets: [{
                                label: 'AQI (Last 24 Hours)',
                                data: values,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                tension: 0.3,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: false,
                            scales: {
                                y: { beginAtZero: true },
                                x: { display: false }
                            },
                            plugins: {
                                legend: { display: false },
                                title: { display: false }
                            }
                        }
                    });
                });
        });
    });
</script>
@endsection
