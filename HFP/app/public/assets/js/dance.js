// File: /assets/js/dance.js

/**
 * This file ONLY handles the "artist" part now.
 * The table logic (setTable, etc.) has been moved to a partial (danceEventsTable.php).
 */

document.addEventListener("DOMContentLoaded", function () {
    fetchArtists();
});

/**
 * Fetch all Dance artists
 */
function fetchArtists() {
    fetch('/api/artists/all')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch artists');
            }
            return response.json();
        })
        .then(artists => {
            console.log("Artists fetched:", artists);
            displayArtists(artists);
        })
        .catch(error => {
            console.error("Error fetching artists:", error);
        });
}

/**
 * Display the fetched artists in #artist-cards-container
 */
function displayArtists(artists) {
    const container = document.getElementById("artist-cards-container");
    // If container doesn't exist (e.g., ticketing page might omit artists), just skip
    if (!container) return;

    container.innerHTML = ""; // Clear previous content

    artists.forEach(artist => {
        const card = document.createElement("div");
        card.classList.add("artist-card");

        card.innerHTML = `
            <div class="artist-image">
                <img src="/assets/images/dance/${artist.name}.png" alt="${artist.name}">
            </div>
            <div class="artist-content">
                <h2>${artist.name}</h2>
                <p>${artist.description}</p>
                <button class="view-details">View Details</button>
            </div>
        `;

        container.appendChild(card);
    });
}
