document.addEventListener('DOMContentLoaded', function () {
    if (typeof apartmentLatitude !== 'undefined' && typeof apartmentLongitude !== 'undefined') {
        const map = L.map('map', { zoomControl: true }).setView([apartmentLatitude, apartmentLongitude], 13);

        if (map) {
            // Add OpenStreetMap tiles as the default layer
            const openStreetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: ''
            }).addTo(map);

            // Add satellite view layer
            const satelliteView = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: ''
            });

            // Add a layer control button
            const baseMaps = {
                "Street Map": openStreetMap,
                "Satellite View": satelliteView
            };
            L.control.layers(baseMaps).addTo(map);

            // Add a marker for the location
            L.marker([apartmentLatitude, apartmentLongitude])
                .addTo(map)
                .bindPopup('<b>Östermalmsgatan 34</b><br>Stockholm');
        }
    } else {
        console.error('Latitude and Longitude not defined.');
    }
});
