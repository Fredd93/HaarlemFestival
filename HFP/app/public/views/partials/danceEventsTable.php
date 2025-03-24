<!-- File: /views/partials/danceEventsTable.php -->

<script>
/**
 * This partial contains the DANCE table logic:
 * - setTable(day)
 * - default day load
 * - day-button listeners
 */

/**
 * Fetch and render the Dance events table for a given day.
 */
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
            if (!tbody) {
                console.warn("No #event-table found on this page.");
                return;
            }
            tbody.innerHTML = ""; // Clear previous data

            // Handle All Access Passes
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

                // Note row
                const noteRow = document.createElement("tr");
                noteRow.innerHTML = `
                    <td colspan="7" class="access-pass-note">
                        * The capacity of the club sessions is very limited. 
                          Availability for all-access pass holders cannot be guaranteed due to safety regulations.
                    </td>
                `;
                tbody.appendChild(noteRow);

                return; // Stop here
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

// Handle day-tab clicks
document.querySelectorAll(".tab-button").forEach(button => {
    button.addEventListener("click", function () {
        // Toggle active class
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
</script>
