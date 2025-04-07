document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("restaurant-reservation-form");
    if (!form) return;

    populateYummyDates();
    bindRestaurantReservationForm(form);
});

function populateYummyDates() {
    const dateSelect = document.getElementById("date");
    const start = new Date("2025-08-21");
    const end = new Date("2025-08-25");

    for (let d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
        const opt = document.createElement("option");
        opt.value = d.toISOString().split("T")[0];
        opt.textContent = d.toDateString();
        dateSelect.appendChild(opt);
    }
}

function bindRestaurantReservationForm(form) {
    const restaurantId = document.getElementById("restaurant_id").value;
    const eventDetailId = document.getElementById("event_detail_reference_id").value;
    const dateSelect = document.getElementById("date");
    const sessionSelect = document.getElementById("session");
    const sessionIdInput = document.getElementById("session_id");

    // Fetch sessions when date changes
    dateSelect.addEventListener("change", () => {
        const selectedDate = dateSelect.value;
        sessionSelect.innerHTML = `<option value="">Select a session</option>`;

        fetch(`/api/yummy/sessions?event_id=${restaurantId}&date=${selectedDate}`)
            .then(res => res.json())
            .then(sessions => {
                sessions.forEach(s => {
                    const opt = document.createElement("option");
                    opt.value = s.session_id;
                    opt.textContent = `${s.session_time} (${s.available_seats} seats)`;
                    sessionSelect.appendChild(opt);
                });
            })
            .catch(err => console.error("Error loading sessions:", err));
    });

    // Store selected session_id
    sessionSelect.addEventListener("change", () => {
        sessionIdInput.value = sessionSelect.value;
    });

    // Submit reservation
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const payload = {
            event_id: parseInt(restaurantId),
            event_detail_reference_id: parseInt(eventDetailId),
            restaurant_id: parseInt(restaurantId),
            session_id: parseInt(sessionIdInput.value),
            num_adults: parseInt(document.getElementById("adults").value),
            num_children: parseInt(document.getElementById("children").value),
            client_name: document.getElementById("name").value,
            special_request: document.getElementById("requests").value
        };

        try {
            const res = await fetch("/api/yummy/book", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(payload)
            });

            const result = await res.json();

            if (res.ok) {
                alert(result.message || "Reservation successful!");
                form.reset();
                sessionSelect.innerHTML = `<option value="">Select a session</option>`;
            } else {
                alert(result.error || "Something went wrong.");
            }
        } catch (err) {
            console.error("Reservation failed:", err);
            alert("Network error.");
        }
    });
}
