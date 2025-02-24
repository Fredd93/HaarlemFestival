document.addEventListener("DOMContentLoaded", function () {
    fetchArtists();
});

function fetchArtists() {
    fetch('/api/artists/all')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch artists');
            }
            return response.json();
        })
        .then(Artists => {
            console.log("Artists fetched:", Artists);
            displayArtists(Artists);
        })
        .catch(error => {
            console.error("Error fetching artists:", error);
        });
}

function displayArtists(artists) {
    const container = document.getElementById("artist-cards-container");
    container.innerHTML = ""; // Clear previous content

    artists.forEach(artist => {
        const card = document.createElement("div");
        card.classList.add("artist-card");

        card.innerHTML = `
            <div class="artist-image">
                <img src="/assets/images/dance/${artist.name}.png">
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

function setTable(day) {
    fetch('/api/artists/events')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch events');
            }
            return response.json();
        })
        .then(events => {
            const tbody = document.querySelector("#event-table tbody");
            tbody.innerHTML = ""; // Clear previous data

            if (day.toUpperCase() === "ALL ACCESS PASSES") {
                const accessPasses = [
                    { name: "ALL ACCESS PASS - FRIDAY 25 JULY", price: 125 },
                    { name: "ALL ACCESS PASS - SATURDAY 26 JULY", price: 150 },
                    { name: "ALL ACCESS PASS - SUNDAY 27 JULY", price: 150 },
                    { name: "ALL ACCESS PASS - FRIDAY 25 JULY, SATURDAY 26 JULY, SUNDAY 27 JULY", price: 250 },
                ];

                accessPasses.forEach(pass => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td colspan="5" class="access-pass-title"><strong>${pass.name}</strong></td>
                        <td>€${pass.price}</td>
                        <td><button class="add-to-program">Add To Program</button></td>
                    `;
                    tbody.appendChild(row);
                });

                // Add a small note under the table
                const noteRow = document.createElement("tr");
                noteRow.innerHTML = `
                    <td colspan="7" class="access-pass-note">
                        * The capacity of the club sessions is very limited. Availability for all-access pass holders cannot be guaranteed due to safety regulations.
                    </td>
                `;
                tbody.appendChild(noteRow);

                return; // Stop further execution
            }

            // Filter events by selected day
            const filteredEvents = events.filter(event => event.day.toUpperCase() === day.toUpperCase());

            // Populate table with filtered events
            filteredEvents.forEach(event => {
                console.log("Processing event:", event.artist);
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${event.time}</td>
                    <td>${event.venue}</td>
                    <td>${event.artist}</td>
                    <td>${event.session_type}</td>
                    <td>${event.duration} MINUTES</td>
                    <td>€${event.price}</td>
                    <td><button class="add-to-program">Add To Program</button></td>
                `;
                tbody.appendChild(row);
            });
        })
        .catch(error => {
            console.error("Error fetching events:", error);
        });
}

// Event Listener for Tab Clicks
document.querySelectorAll(".tab-button").forEach(button => {
    button.addEventListener("click", function () {
        document.querySelectorAll(".tab-button").forEach(btn => btn.classList.remove("active"));
        this.classList.add("active");

        const selectedDay = this.dataset.day;
        setTable(selectedDay);
    });
});

// Load the table for the default day (Friday) on page load
document.addEventListener("DOMContentLoaded", function () {
    setTable("FRIDAY");
});
