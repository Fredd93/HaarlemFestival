document.addEventListener("DOMContentLoaded", function () {
    // Initialize the map
    let map = L.map("festival-map").setView([52.3874, 4.6462], 14); // Center on Haarlem

    // Load OpenStreetMap tiles
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Event locations
    const eventLocations = [
        { name: "Jazz", category: "jazz", lat: 52.3811, lng: 4.6355 },
        { name: "Yummy", category: "yummy", lat: 52.3852, lng: 4.6574 },
        { name: "Teylers Museum", category: "teylers", lat: 52.3752, lng: 4.6409 },
        { name: "A Stroll Through History", category: "history", lat: 52.3876, lng: 4.6390 },
        { name: "Dance", category: "dance", lat: 52.3700, lng: 4.6300 }
    ];

    // Add markers for each event
    let markers = [];
    eventLocations.forEach(event => {
        let marker = L.marker([event.lat, event.lng])
            .addTo(map)
            .bindPopup(`<b>${event.name}</b>`);
        marker.category = event.category;
        markers.push(marker);
    });

    // Filter functionality
    document.querySelectorAll(".filter-buttons button").forEach(button => {
        button.addEventListener("click", () => {
            let filter = button.getAttribute("data-filter");
            markers.forEach(marker => {
                if (marker.category === filter) {
                    marker.addTo(map);
                } else {
                    map.removeLayer(marker);
                }
            });
        });
    });
});
