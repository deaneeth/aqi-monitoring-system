<!DOCTYPE html>
<html>
<head>
    <title>Colombo AQI Map - Leaflet</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        #map {
            height: 600px;
            width: 100%;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <h2>Colombo Air Quality Map</h2>
    <div id="map"></div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Initialize the map centered on Colombo
        const map = L.map('map').setView([6.9271, 79.8612], 12);

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Example marker (later replace with dynamic sensor data)
        const marker = L.marker([6.9271, 79.8612]).addTo(map)
            .bindPopup("<b>Sample Sensor</b><br>AQI: 42 (Good)")
            .openPopup();
    </script>
</body>
</html>
