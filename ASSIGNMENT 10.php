<?php
$ip = $_SERVER['REMOTE_ADDR'];

// Fetch geolocation using shell curl (PHP curl disabled on CLAMV)
$response = shell_exec("curl -s https://ipinfo.io/json");
$details = json_decode($response, true);

// Fallback if no location
if (!isset($details['loc'])) {
    $details["loc"] = "50.7214,10.4439";
}

list($lat, $lon) = explode(",", $details["loc"]);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assignment 10 — IP Map</title>

    <!-- Leaflet -->
    <link rel="stylesheet" href="http://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="http://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        body {
            margin: 0;
            font-family: system-ui, Arial, sans-serif;
            background-color: #0f172a;
            color: #f9fafb;
        }

        .header {
            background-color: #1e3a8a;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .header .logo {
            font-size: 22px;
            font-weight: bold;
            color: #f9fafb;
        }

        .header nav a {
            color: #f9fafb;
            margin-left: 20px;
            text-decoration: none;
            font-size: 16px;
        }

        .header nav a:hover {
            color: #f59e0b;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
        }

        .info-card {
            background-color: #1e293b;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.4);
            margin-bottom: 20px;
        }

        .info-card h2 {
            margin-top: 0;
            color: #38bdf8;
        }

        .info-card b {
            color: #f59e0b;
        }

        #map {
            height: 500px;
            border-radius: 12px;
            overflow: hidden;
            background: white;
            border: 2px solid #1e3a8a;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }

        .footer {
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            color: #94a3b8;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="logo">📘 BookVerse</div>
    <nav>
        <a href="/~naliyev/bookreviews_input_site/index.php">Home</a>
        <a href="/~naliyev/index.php">🗺 Map</a>
        <a href="/~naliyev/bookreviews_input_site/imprint.php">Imprint</a>
    </nav>
</div>

<div class="container">

    <div class="info-card">
        <h2>🌍 Your Location Information</h2>
        <p><b>IP:</b> <?php echo htmlspecialchars($details["ip"]); ?></p>
        <p><b>City:</b> <?php echo htmlspecialchars($details["city"]); ?></p>
        <p><b>Region:</b> <?php echo htmlspecialchars($details["region"]); ?></p>
        <p><b>Country:</b> <?php echo htmlspecialchars($details["country"]); ?></p>
        <p><b>Postal Code:</b> <?php echo htmlspecialchars($details["postal"]); ?></p>
        <p><b>ISP / Org:</b> <?php echo htmlspecialchars($details["org"]); ?></p>
    </div>

    <div id="map"></div>

</div>

<div class="footer">
    BookVerse — Databases Project 2025 • Constructor University
</div>

<script>
var lat = <?php echo $lat; ?>;
var lon = <?php echo $lon; ?>;

// Create map
var map = L.map('map').setView([lat, lon], 12);

L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19
}).addTo(map);

// Marker for server location
L.marker([lat, lon])
 .addTo(map)
 .bindPopup("📍 Server Location (IP-based)")
 .openPopup();

// Real device location (Bremen)
navigator.geolocation.getCurrentPosition(function(pos) {
    var userLat = pos.coords.latitude;
    var userLon = pos.coords.longitude;

    map.setView([userLat, userLon], 13);

    L.marker([userLat, userLon])
      .addTo(map)
      .bindPopup("📍 Your REAL location (device)")
      .openPopup();
});
</script>

</body>
</html>
