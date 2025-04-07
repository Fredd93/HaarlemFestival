document.addEventListener("DOMContentLoaded", () => {
    fetchAllRestaurants();
    renderYummyEventsTable();
});

// Global variable to store fetched events
let allYummyEvents = [];

/**
 * Fetch all Yummy events from your API.
 */
function fetchAllRestaurants() {
    fetch('/api/yummyEvents')
        .then(response => response.json())
        .then(data => {
            console.log("API Response:", data);
            allYummyEvents = data;
            populateRestaurantDropdown(allYummyEvents);
        })
        .catch(err => console.error("Error fetching Yummy events:", err));
}

/**
 * Populate the restaurant dropdown with unique restaurant names.
 */
function populateRestaurantDropdown(events) {
    const restaurantSelect = document.getElementById("restaurant");
    if (!restaurantSelect) return;

    while (restaurantSelect.options.length > 1) {
        restaurantSelect.remove(1);
    }

    const uniqueNames = [...new Set(events.map(e => e.name))];

    uniqueNames.forEach(name => {
        const option = document.createElement("option");
        option.value = name;
        option.textContent = name;
        restaurantSelect.appendChild(option);
    });

    restaurantSelect.addEventListener("change", onRestaurantChange);
}

/**
 * When a restaurant is selected, update session dropdown with available slots.
 */
function onRestaurantChange(e) {
    const selectedRestaurant = e.target.value;
    if (!selectedRestaurant) return;

    const sessionSelect = document.getElementById("sessionTime");
    if (!sessionSelect) return;

    // Clear existing session options
    sessionSelect.innerHTML = `<option value="">-- Select a session --</option>`;

    const eventObj = allYummyEvents.find(evt => evt.name === selectedRestaurant);
    if (!eventObj) {
        console.log("No event found for selected restaurant:", selectedRestaurant);
        return;
    }

    const slots = generateDynamicSessionSlots(
        eventObj.startTime,
        eventObj.sessionDuration,
        eventObj.sessions,
        eventObj.seats
    );

    slots.forEach(slot => {
        const option = document.createElement("option");
        option.value = slot.time;
        option.textContent = slot.time + (slot.disabled ? " (Fully Booked)" : "");
        option.disabled = slot.disabled;
        sessionSelect.appendChild(option);
    });
}

/**
 * Generate session start times and disable them if no seats are left.
 */
function generateDynamicSessionSlots(startTimeStr, sessionDuration, sessionsCount, remainingSeats) {
    const slots = [];
    const dt = new Date(`1970-01-01T${startTimeStr}`);
    const seatsPerSession = Math.floor(remainingSeats / sessionsCount);

    for (let i = 0; i < sessionsCount; i++) {
        const timeLabel = formatYummyTime(dt);
        const disabled = seatsPerSession <= 0;
        slots.push({
            time: timeLabel,
            disabled: disabled
        });
        dt.setMinutes(dt.getMinutes() + Math.round(sessionDuration * 60));
    }

    return slots;
}

/**
 * Render the Yummy Events Table.
 */
function renderYummyEventsTable() {
    fetch('/api/yummyEvents')
        .then(response => response.json())
        .then(events => {
            const tbody = document.querySelector("#yummy-events-table tbody");
            if (!tbody) return;
            tbody.innerHTML = "";

            events.forEach(event => {
                const slots = generateSessionSlots(event.startTime, event.sessionDuration, event.sessions);

                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${event.name}</td>
                    <td>${event.sessionDuration} hours</td>
                    <td>${slots.join(", ")}</td>
                    <td>${event.seats}</td>
                    <td>€${event.price} (Adult) / €${event.childPrice} (Child)</td>
                `;
                tbody.appendChild(row);
            });
        })
        .catch(error => console.error("Error fetching yummy events:", error));
}

/**
 * Generate session time labels for the table (not dropdown).
 */
function generateSessionSlots(startTimeStr, sessionDuration, sessionsCount) {
    const slots = [];
    const dt = new Date(`1970-01-01T${startTimeStr}`);
    for (let i = 0; i < sessionsCount; i++) {
        slots.push(formatYummyTime(dt));
        dt.setMinutes(dt.getMinutes() + Math.round(sessionDuration * 60));
    }
    return slots;
}

/**
 * Yummy-specific time formatter (HH:MM).
 */
function formatYummyTime(dateObj) {
    const hh = String(dateObj.getHours()).padStart(2, '0');
    const mm = String(dateObj.getMinutes()).padStart(2, '0');
    return `${hh}:${mm}`;
}
