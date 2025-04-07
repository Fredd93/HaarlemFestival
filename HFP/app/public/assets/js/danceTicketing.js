document.addEventListener("DOMContentLoaded", () => {
    fetchDanceDays();
});

function fetchDanceDays() {
    fetch('/api/artists/events')
        .then(res => res.json())
        .then(events => {
            // Assuming the DB returns an 'event_date' field:
            const uniqueDates = [...new Set(events.map(e => e.event_date))];
            const container = document.getElementById("dance-day-buttons");
            if (!container) return;
            container.innerHTML = "";

            uniqueDates.forEach(dateStr => {
                const btn = document.createElement("button");
                btn.classList.add("tab-button", "dance-day-tab");
                btn.dataset.day = dateStr;
                btn.textContent = formatDayLabel(dateStr);
                btn.addEventListener("click", () => {
                    document.querySelectorAll(".dance-day-tab").forEach(b => b.classList.remove("active"));
                    btn.classList.add("active");
                    setTable(dateStr);
                });
                container.appendChild(btn);
            });

            // Optionally, auto-load the first date:
            if (uniqueDates.length > 0) {
                setTable(uniqueDates[0]);
            }
        })
        .catch(err => console.error("Error fetching dance events for day buttons:", err));
}

function formatDayLabel(dateStr) {
    if (/^\d{4}-\d{2}-\d{2}$/.test(dateStr)) {
        const [yyyy, mm, dd] = dateStr.split("-");
        const dateObj = new Date(`${yyyy}-${mm}-${dd}`);
        const options = { weekday: 'short', day: 'numeric', month: 'short' };
        return dateObj.toLocaleDateString('en-GB', options);
    }
    return dateStr;
}

function setTable(day) {
    fetch('/api/artists/events')
        .then(response => response.json())
        .then(events => {
            const tbody = document.querySelector("#event-table tbody");
            if (!tbody) return;
            tbody.innerHTML = "";

            // Filter events by the selected day (using event_date)
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
                    <td>${event.tickets_available}</td>
                    <td><button class="add-to-program">Add To Program</button></td>
                `;
                tbody.appendChild(row);
            });
        })
        .catch(error => console.error("Error fetching events:", error));
}
