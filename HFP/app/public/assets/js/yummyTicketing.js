document.addEventListener("DOMContentLoaded", () => {
    fetchAllRestaurants();
});

// We'll store the Yummy events globally so we can find them on restaurant selection
let allYummyEvents = [];

/**
 * Fetch all Yummy restaurants from the API
 */
function fetchAllRestaurants() {
    fetch('/api/yummyEvents') // Matches your YummyApiRoutes => getAllYummyEvents
        .then(response => response.json())
        .then(data => {
            allYummyEvents = data; // store globally
            populateRestaurantDropdown(allYummyEvents);
            console.log("Fetched Yummy Events:", allYummyEvents);
        })
        .catch(err => console.error("Error fetching Yummy events:", err));
}

/**
 * Fill the #restaurant dropdown with the names from the fetched data
 */
function populateRestaurantDropdown(events) {
    const restaurantSelect = document.getElementById("restaurant");
    if (!restaurantSelect) return;

    // Clear existing options (except the default)
    while (restaurantSelect.options.length > 1) {
        restaurantSelect.remove(1);
    }

    // Extract unique restaurant names
    const uniqueNames = [...new Set(events.map(e => e.name))];

    uniqueNames.forEach(name => {
        const option = document.createElement("option");
        option.value = name;
        option.textContent = name;
        restaurantSelect.appendChild(option);
    });

    // Listen for changes
    restaurantSelect.addEventListener("change", onRestaurantChange);
}

/**
 * Called when user picks a restaurant from the dropdown.
 * We find ALL events matching that restaurant name, generate session times,
 * and fill #sessionTime dropdown with all possible session start times.
 */
function onRestaurantChange(e) {
    const selectedName = e.target.value;
    const sessionSelect = document.getElementById("sessionTime");
    if (!sessionSelect) return;

    // Clear old sessions
    sessionSelect.innerHTML = `<option value="">-- Select a session --</option>`;

    if (!selectedName) return; // user picked the default

    // 1) Find all YummyEvent rows that match this restaurant name
    //    In case you have multiple rows for the same restaurant
    const matchedEvents = allYummyEvents.filter(ev => ev.name === selectedName);

    if (matchedEvents.length === 0) {
        console.warn("No events found for restaurant:", selectedName);
        return;
    }

    // 2) Generate session slots for each matching event
    let combinedSlots = [];
    matchedEvents.forEach(eventData => {
        const slots = generateSessionSlots(
            eventData.startTime,
            eventData.sessionDuration,
            eventData.sessions
        );
        // Collect them in a single array
        combinedSlots.push(...slots);
    });

    // 3) Remove duplicates and sort them
    //    (If multiple events overlap or produce the same times)
    const uniqueSlots = [...new Set(combinedSlots)].sort();

    // 4) Populate the session dropdown with the final list
    uniqueSlots.forEach((time, index) => {
        const option = document.createElement("option");
        option.value = time; // e.g. "18:00"
        option.textContent = `Session ${index + 1} (${time})`;
        sessionSelect.appendChild(option);
    });
}

/**
 * Generate session start times based on startTime, sessionDuration (hours), and sessions count.
 * e.g. if startTime="18:00:00", sessionDuration=1.5, sessions=3 => ["18:00","19:30","21:00"]
 */
function generateSessionSlots(startTimeStr, sessionDuration, sessionsCount) {
    const slots = [];
    const dt = new Date(`1970-01-01T${startTimeStr}`);

    for (let i = 0; i < sessionsCount; i++) {
        slots.push(formatTimeYummy(dt));
        dt.setMinutes(dt.getMinutes() + Math.round(sessionDuration * 60));
    }
    return slots;
}

function formatTimeYummy(dateObj) {
    const hh = String(dateObj.getHours()).padStart(2, '0');
    const mm = String(dateObj.getMinutes()).padStart(2, '0');
    return `${hh}:${mm}`;
}

