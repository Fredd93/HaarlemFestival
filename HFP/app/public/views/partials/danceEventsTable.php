<!-- /views/partials/danceEventsTable.php -->

<script>
/**
 * 1) This file contains:
 *    - setTable(day) for filtering events by event_date
 *    - fetchDanceDays() for building dynamic date buttons
 *    - formatDayLabel() if you want to parse date strings into a user-friendly label
 */

/**
 * Called by dynamic buttons to filter & render the Dance events table for a given date (stored in "event_date").
 */
function setTable(day) {
    console.log("setTable called with day:", day);

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

            // If user selected "ALL ACCESS PASSES"
            if (day === "ALL ACCESS PASSES") {
                const accessPasses = [
                    { name: "ALL ACCESS PASS - FRIDAY 25 JULY", price: 125 },
                    { name: "ALL ACCESS PASS - SATURDAY 26 JULY", price: 150 },
                    { name: "ALL ACCESS PASS - SUNDAY 27 JULY",   price: 150 },
                    { name: "ALL ACCESS PASS - FRI/SAT/SUN (25-27 JULY)", price: 250 },
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

            // Filter events by the chosen date
            // event.event_date is something like "2025-07-25"
            const filteredEvents = events.filter(event => event.event_date === day);

            filteredEvents.forEach(event => {
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

/**
 * Fetch all dance events, find unique "event_date", build the dynamic date buttons in #dance-day-buttons.
 */
function fetchDanceDays() {
    console.log("fetchDanceDays called...");

    fetch('/api/artists/events')
        .then(res => res.json())
        .then(events => {
            console.log("Dance events fetched:", events);

            // e.g. if your DB column is "event_date": "2025-07-25"
            const uniqueDates = [...new Set(events.map(e => e.event_date))];

            const container = document.getElementById("dance-day-buttons");
            if (!container) {
                console.warn("No #dance-day-buttons container found!");
                return;
            }
            container.innerHTML = ""; // Clear any old content

            // Create a button for each unique date
            uniqueDates.forEach(dateStr => {
                const btn = document.createElement("button");
                btn.classList.add("tab-button", "dance-day-tab");
                btn.dataset.day = dateStr;    // store the date string
                btn.textContent = formatDayLabel(dateStr);

                btn.addEventListener("click", () => {
                    document.querySelectorAll(".dance-day-tab").forEach(b => b.classList.remove("active"));
                    btn.classList.add("active");
                    setTable(dateStr);
                });

                container.appendChild(btn);
            });

            // Add "All Access Passes" button
            const allAccessBtn = document.createElement("button");
            allAccessBtn.classList.add("tab-button", "dance-day-tab");
            allAccessBtn.dataset.day = "ALL ACCESS PASSES";
            allAccessBtn.textContent = "All Access Passes";
            allAccessBtn.addEventListener("click", () => {
                document.querySelectorAll(".dance-day-tab").forEach(b => b.classList.remove("active"));
                allAccessBtn.classList.add("active");
                setTable("ALL ACCESS PASSES");
            });
            container.appendChild(allAccessBtn);

            // Optionally auto-click the first date
            if (uniqueDates.length > 0) {
                setTable(uniqueDates[0]);
            }
        })
        .catch(err => console.error("Error fetching dance events for day buttons:", err));
}

/**
 * Convert "YYYY-MM-DD" into a user-friendly label, e.g. "Fri, 25 Jul"
 * If your DB used to store "FRIDAY", just return the string as is.
 */
function formatDayLabel(dateStr) {
    if (/^\d{4}-\d{2}-\d{2}$/.test(dateStr)) {
        const [yyyy, mm, dd] = dateStr.split("-");
        const dateObj = new Date(`${yyyy}-${mm}-${dd}`);
        const options = { weekday: 'short', day: 'numeric', month: 'short' };
        return dateObj.toLocaleDateString('en-GB', options); // e.g. "Fri, 25 Jul"
    }
    // If it's still "FRIDAY"/"SATURDAY", just return dateStr
    return dateStr;
}

// On DOMContentLoaded, build dynamic date buttons
document.addEventListener("DOMContentLoaded", () => {
    console.log("danceEventsTable partial loaded. Calling fetchDanceDays()...");
    fetchDanceDays();
});
</script>
