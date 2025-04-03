// File: jazzTicketing.js

document.addEventListener('DOMContentLoaded', () => {
    // On page load, build the dynamic date buttons
    fetchJazzDates();
});

/**
 * 1) Fetch all Jazz events from the API
 * 2) Extract unique dates
 * 3) Create date buttons in #jazz-day-buttons
 * 4) Also add a "Full Access Passes" button
 */
function fetchJazzDates() {
    fetch('/api/jazzEvents') // Adjust if your endpoint differs
        .then(response => response.json())
        .then(events => {
            console.log("Jazz events fetched:", events);
            const uniqueDates = [...new Set(events.map(e => e.event_date))];
            createJazzDateButtons(uniqueDates);
        })
        .catch(err => console.error("Error fetching Jazz events:", err));
}

/**
 * Create a button for each unique date, plus a "Full Access Passes" button.
 */
function createJazzDateButtons(dates) {
    const container = document.getElementById("jazz-day-buttons");
    if (!container) {
        console.warn("No #jazz-day-buttons container found in the HTML.");
        return;
    }

    // Clear any old content
    container.innerHTML = "";

    // Build one button per unique date
    dates.forEach(dateStr => {
        const btn = document.createElement("button");
        btn.classList.add("jazz-day-btn");
        btn.textContent = formatJazzDate(dateStr); // e.g. parse "2025-08-07" => "Thu, 07 Aug"

        // When clicked, fetch events for that date
        btn.addEventListener("click", () => {
            // Remove 'active' from other date buttons
            document.querySelectorAll(".jazz-day-btn").forEach(b => b.classList.remove("active"));
            btn.classList.add("active");

            fetchJazzEventsByDate(dateStr);
        });

        container.appendChild(btn);
    });

    // Add "Full Access Passes" button
    const fullPassBtn = document.createElement("button");
    fullPassBtn.classList.add("jazz-day-btn");
    fullPassBtn.textContent = "Full Access Passes";
    fullPassBtn.addEventListener("click", () => {
        document.querySelectorAll(".jazz-day-btn").forEach(b => b.classList.remove("active"));
        fullPassBtn.classList.add("active");
        renderJazzPassesStatic();
    });
    container.appendChild(fullPassBtn);

    // Optionally auto-click the first date
    if (dates.length > 0) {
        fetchJazzEventsByDate(dates[0]);
    }
}

/**
 * Format a date string like "2025-08-07" into a user-friendly label (e.g. "Thu, 07 Aug").
 */
function formatJazzDate(dateStr) {
    // If your DB returns something like "2025-08-07"
    const [yyyy, mm, dd] = dateStr.split("-");
    const dateObj = new Date(`${yyyy}-${mm}-${dd}`);
    // Example format: "Thu, 07 Aug"
    const options = { weekday: 'short', day: 'numeric', month: 'short' };
    return dateObj.toLocaleDateString('en-GB', options);
}

/**
 * Fetch & display Jazz events for a given date (unchanged from your existing logic).
 */
function fetchJazzEventsByDate(date) {
    fetch(`/api/jazzEvents/date/${date}`)
        .then(res => res.json())
        .then(data => renderJazzEvents(data))
        .catch(err => console.error("Error fetching Jazz events:", err));
}

/**
 * Renders the fetched Jazz events into the table body (#jazzTableBody).
 */
function renderJazzEvents(events) {
    const tableBody = document.querySelector('#jazzTableBody');
    tableBody.innerHTML = '';

    if (!events || events.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="4">No Jazz events available for this date.</td>
            </tr>
        `;
        return;
    }

    events.forEach(event => {
        // Create the time range string, e.g. "21:00 - 22:00"
        const timeRange = formatTimeRange(event.time, event.duration);

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${event.name}</td>
            <td>${timeRange}</td>
            <td>${event.venue}</td>
            <td>
                <button onclick="addJazzToProgram(${event.event_detail_id})">
                    Add to Program
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

/**
 * Displays static "Full Day Pass" & "Full Festival Pass" rows in #jazzTableBody.
 */
function renderJazzPassesStatic() {
    const tableBody = document.querySelector('#jazzTableBody');
    tableBody.innerHTML = '';

    // Example pass data
    const passOptions = [
        {
            name: "Full Day Pass - Thursday",
            time: "18:00",
            duration: 4.0,
            price: 35.00
        },
        {
            name: "Full Day Pass - Friday",
            time: "18:00",
            duration: 4.0,
            price: 35.00
        },
        {
            name: "Full Day Pass - Saturday",
            time: "18:00",
            duration: 4.0,
            price: 35.00
        },
        {
            name: "Full Day Pass - Sunday",
            time: "18:00",
            duration: 4.0,
            price: 35.00
        },
        {
            name: "Full Festival Pass",
            time: "18:00",
            duration: 16.0,
            price: 80.00
        }
    ];

    passOptions.forEach(pass => {
        const timeRange = formatTimeRange(pass.time, pass.duration);
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><strong>${pass.name}</strong></td>
            <td>${timeRange}</td>
            <td>€${pass.price}</td>
            <td>
                <button onclick="addJazzToProgram('${pass.name}')">
                    Add to Program
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });

    // Optional note row
    const noteRow = document.createElement('tr');
    noteRow.innerHTML = `
        <td colspan="4" class="access-pass-note">
            * Full Day Pass covers all artists on that specific day.
              Full Festival Pass covers all days (Thu-Sun).
        </td>
    `;
    tableBody.appendChild(noteRow);
}

/**
 * Adds a selected event or pass to the user's program/cart (placeholder).
 */
function addJazzToProgram(eventId) {
    console.log("Adding event to program:", eventId);
    // e.g., localStorage or a POST to your server
}

/* ----------------------------------------------------
   TIME FORMAT HELPERS (unchanged)
   ---------------------------------------------------- */
function parseTime(timeStr) {
    // "21:00" or "21:00:00.0000000"
    const [hh, mm] = timeStr.split(':');
    return {
        hour: parseInt(hh, 10),
        minute: parseInt(mm, 10)
    };
}

function formatTime(hour, minute) {
    const hh = hour.toString().padStart(2, '0');
    const mm = minute.toString().padStart(2, '0');
    return `${hh}:${mm}`;
}

function addDuration(hour, minute, durationHours) {
    const startMinutes = hour * 60 + minute;
    const addedMinutes = Math.round(durationHours * 60);
    const endMinutes = startMinutes + addedMinutes;
    return {
        hour: Math.floor(endMinutes / 60),
        minute: endMinutes % 60
    };
}

function formatTimeRange(timeStr, durationHours) {
    const { hour, minute } = parseTime(timeStr);
    const endTime = addDuration(hour, minute, durationHours);
    const startStr = formatTime(hour, minute);
    const endStr = formatTime(endTime.hour, endTime.minute);
    return `${startStr} - ${endStr}`;
}
