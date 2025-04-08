document.addEventListener("DOMContentLoaded", () => {
    fetchAllRestaurants();
    renderYummyEventsTable();
    bindReservationForm();
    populateYummyDateDropdown(); 
});

let allYummyEvents = [];

/**
 * Fetch all Yummy events from your API and populate dropdown.
 */
function fetchAllRestaurants() {
    fetch('/api/yummyEvents')
    
        .then(response => response.json())
        .then(data => {
            console.log("Sample event object:", data[0]);
            allYummyEvents = data;
            populateRestaurantDropdown(data);
        })
        .catch(err => console.error("Error fetching Yummy events:", err));
}

function populateRestaurantDropdown(events) {
    const restaurantSelect = document.getElementById("restaurant");
    if (!restaurantSelect) return;

    while (restaurantSelect.options.length > 1) {
        restaurantSelect.remove(1);
    }

    events.forEach(event => {
        const option = document.createElement("option");
        option.value = event.eventDetailId; 
        option.textContent = event.name;
        option.dataset.eventDetailId = event.eventDetailId; // used as event_detail_reference_id
        restaurantSelect.appendChild(option);
    });

    restaurantSelect.addEventListener("change", fetchSessionsForSelectedRestaurant);
    document.getElementById("date").addEventListener("change", fetchSessionsForSelectedRestaurant);
}

function fetchSessionsForSelectedRestaurant() {
    const restaurantSelect = document.getElementById("restaurant");
    const dateInput = document.getElementById("date");
    const sessionSelect = document.getElementById("sessionTime");

    const eventId = restaurantSelect.value;
    const date = dateInput.value;

    console.log("Fetching sessions for:", eventId, date); // ✅ Add this


    if (!eventId || !date) return;

    sessionSelect.innerHTML = `<option value="">-- Select a session --</option>`;

    fetch(`/api/yummy/sessions?event_id=${eventId}&date=${date}`)
        .then(response => response.json())
        .then(sessions => {
            console.log("Sessions received:", sessions); // ✅ Add this
            sessions.forEach(session => {
                const option = document.createElement("option");
                option.value = session.session_id;
                option.textContent = `${session.session_time} (${session.available_seats} seats)`;
                sessionSelect.appendChild(option);
            });
        })
        .catch(err => console.error("Error fetching sessions:", err));
}

/**
 * Binds the form submission to fetch reservation booking.
 */
function bindReservationForm() {
    const form = document.querySelector(".yummy-form-section form");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const restaurantSelect = document.getElementById("restaurant");
        const selectedOption = restaurantSelect.selectedOptions[0];

        const payload = {
            event_id: parseInt(restaurantSelect.value),
            event_detail_reference_id: parseInt(selectedOption.dataset.eventDetailId),
            restaurant_id: parseInt(restaurantSelect.value),
            session_id: parseInt(document.getElementById("sessionTime").value),
            num_adults: parseInt(document.getElementById("adults").value),
            num_children: parseInt(document.getElementById("children").value),
            client_name: document.getElementById("custName").value,
            special_request: document.getElementById("specialRequests").value
        };

        try {
            const response = await fetch("/api/yummy/book", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.message || "Reservation successful!");
                form.reset();
                document.getElementById("sessionTime").innerHTML = `<option value="">-- Select a session --</option>`;
            } else {
                alert(result.error || "Something went wrong.");
            }
        } catch (err) {
            alert("Network error.");
            console.error("Booking error:", err);
        }
    });
}

/**
 * Renders the Yummy Events Table.
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
 * Local-only time label generator for table (not for live seat status).
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

function formatYummyTime(dateObj) {
    const hh = String(dateObj.getHours()).padStart(2, '0');
    const mm = String(dateObj.getMinutes()).padStart(2, '0');
    return `${hh}:${mm}`;
}
function populateYummyDateDropdown() {
    const dateSelect = document.getElementById("date");

    // Static date range for the event (or fetch dynamically)
    const start = new Date("2025-08-21");
    const end = new Date("2025-08-25");

    for (let d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
        const option = document.createElement("option");
        option.value = d.toISOString().split("T")[0]; // YYYY-MM-DD
        option.textContent = d.toDateString(); // e.g., "Thu Aug 21 2025"
        dateSelect.appendChild(option);
    }
}
