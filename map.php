<!DOCTYPE html>
<html>
<head>
<title>Tour Map – Reliance Travels</title>

<style>
body {
    margin: 0;
    font-family: Poppins, sans-serif;
    background: #ffe6f4;
}

#map {
    width: 100%;
    height: 90vh;
    border-radius: 20px;
    margin: 20px auto;
    box-shadow: 0 8px 25px rgba(255, 27, 133, 0.35);
}

/* Title */
.title {
    text-align: center;
    font-size: 32px;
    margin-top: 20px;
    font-weight: 700;
    color: #ff1b85;
}
</style>
</head>

<body>

<h2 class="title">Sri Lanka Tour Route Map</h2>

<div id="map"></div>

<script>
// ✅ Locations
const locations = [
    { name: "Kandy",    lat: 7.2906,  lng: 80.6337 },
    { name: "Ella",     lat: 6.8667,  lng: 81.0470 },
    { name: "Jaffna",   lat: 9.6615,  lng: 80.0255 },
    { name: "Sigiriya", lat: 7.9570,  lng: 80.7603 }
];

// ✅ Initialize Map
function initMap() {
    const SLcenter = { lat: 7.8731, lng: 80.7718 };

    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 7,
        center: SLcenter,
        mapId: "DEMO_MAP_ID",  // uses default unless you add Maps Styling
    });

    // ✅ Pink Marker Icon
    const icon = {
        url: "https://cdn-icons-png.flaticon.com/512/3177/3177361.png",
        scaledSize: new google.maps.Size(40, 40)
    };

    // ✅ Info Windows + Markers
    locations.forEach((loc) => {
        const marker = new google.maps.Marker({
            position: { lat: loc.lat, lng: loc.lng },
            map,
            icon,
            animation: google.maps.Animation.DROP
        });

        const info = new google.maps.InfoWindow({
            content: `
                <div style='text-align:center; font-size:16px; font-weight:600; color:#ff1b85;'>
                    ${loc.name}
                </div>
            `
        });

        marker.addListener("click", () => info.open(map, marker));
    });
}
</script>

<!-- ✅ Google Maps API Key -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>

</body>
</html>
