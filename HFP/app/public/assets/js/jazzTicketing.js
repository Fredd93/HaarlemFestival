// jazzTicketing.js

document.addEventListener('DOMContentLoaded', () => {
    // Fetch the default day’s events on page load
    fetchJazzEventsByDate('2025-08-07');

    // Set up listeners for each day button (assuming these buttons exist in your HTML)
    document.querySelector('#thursdayBtn').addEventListener('click', () => {
        fetchJazzEventsByDate('2025-08-07');
    });
    document.querySelector('#fridayBtn').addEventListener('click', () => {
        fetchJazzEventsByDate('2025-08-08');
    });
    document.querySelector('#saturdayBtn').addEventListener('click', () => {
        fetchJazzEventsByDate('2025-08-09');
    });
    document.querySelector('#sundayBtn').addEventListener('click', () => {
        fetchJazzEventsByDate('2025-08-10');
    });

    // NEW: Full Access Pass button
    document.querySelector('#fullPassBtn').addEventListener('click', () => {
        renderJazzPassesStatic(); 
    });
});

/**
 * Fetches Jazz events from your API for a given date.
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
 * 1) STATIC array approach for passes
 *    If you want each pass to have a time + duration, just store them here.
 */
function renderJazzPassesStatic() {
    const tableBody = document.querySelector('#jazzTableBody');
    tableBody.innerHTML = '';

    // Example: each pass has time + duration so we can show a range
    const passOptions = [
        {
            name: "Full Day Pass - Thursday",
            time: "18:00",     // e.g. starts at 18:00
            duration: 4.0,     // 4 hours, so it ends at 22:00
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
            time: "18:00",     // or "00:00" if it covers entire day
            duration: 16.0,    // maybe 16 hours, or however long you want
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
 * Adds a selected event to the user's program/cart (placeholder example).
 */
function addJazzToProgram(eventId) {
    console.log("Adding event to program:", eventId);
    // e.g. localStorage usage
    // let cart = JSON.parse(localStorage.getItem("jazzCart")) || [];
    // cart.push(eventId);
    // localStorage.setItem("jazzCart", JSON.stringify(cart));
}

/* ----------------------------------------------------
   TIME FORMAT HELPERS
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
