document.addEventListener("DOMContentLoaded", function () {
    fetchArtists();
    setTable("FRIDAY");
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
                <img src="/assets/images/dance/${artist.image_url}">
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
                fetch('/api/artists/passes')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to fetch passes');
                        }
                        return response.json();
                    })
                    .then(passes => {
                        passes.forEach(pass => {
                            const row = document.createElement("tr");
                            row.innerHTML = `
                                <td colspan="5" class="access-pass-title"><strong>${pass.pass_name}</strong></td>
                                <td>€${pass.price}</td>
                                <td><button class="add-to-program">Add To Program</button></td>
                            `;
                            tbody.appendChild(row);
                        });
            
                        const noteRow = document.createElement("tr");
                        noteRow.innerHTML = `
                            <td colspan="8" class="access-pass-note">
                                * The capacity of the club sessions is very limited. Availability for all-access pass holders cannot be guaranteed due to safety regulations.
                            </td>
                        `;
                        tbody.appendChild(noteRow);
                    })
                    .catch(error => {
                        console.error("Error fetching passes:", error);
                    });
                return;
            }
            

            // Map day to date
            const dayToDateMap = {
                "FRIDAY": "2025-07-25",
                "SATURDAY": "2025-07-26",
                "SUNDAY": "2025-07-27"
            };
            const selectedDate = dayToDateMap[day.toUpperCase()];

            // Filter events by date
            const filteredEvents = events.filter(event => event.event_date === selectedDate);

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
                    <td>${event.tickets_available}</td>
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