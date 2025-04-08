document.addEventListener("DOMContentLoaded", () => {
  fetchRestaurants();
  document.getElementById("restaurantDropdown").addEventListener("change", loadSessionsForRestaurant);
});

function fetchRestaurants() {
  fetch("/api/yummyEvents")
      .then(res => res.json())
      .then(data => {
          const dropdown = document.getElementById("restaurantDropdown");
          data.forEach(event => {
              const option = document.createElement("option");
              option.value = event.eventDetailId;
              option.textContent = event.name;
              dropdown.appendChild(option);
          });
      })
      .catch(err => console.error("Error fetching restaurants:", err));
}

function loadSessionsForRestaurant() {
  const eventId = document.getElementById("restaurantDropdown").value;
  const tbody = document.querySelector("#sessionTable tbody");
  tbody.innerHTML = "";

  if (!eventId) return;

  fetch(`/api/yummy/sessions/manage?event_id=${eventId}`)
      .then(res => res.json())
      .then(sessions => {
          sessions.forEach(session => {
              const row = document.createElement("tr");
              row.innerHTML = `
                  <td>${session.session_date}</td>
                  <td>${session.session_time}</td>
                  <td><input type="number" value="${session.max_seats}" class="form-control max-seats-input" min="1"></td>
                  <td><input type="number" value="${session.available_seats}" class="form-control available-seats-input" min="0"></td>
                  <td>
                      <button class="btn btn-primary btn-sm update-btn" data-id="${session.session_id}">
                          Update
                      </button>
                  </td>
              `;
              tbody.appendChild(row);
          });

          attachUpdateHandlers();
      })
      .catch(err => console.error("Error loading sessions:", err));
}

function attachUpdateHandlers() {
  document.querySelectorAll(".update-btn").forEach(button => {
      button.addEventListener("click", () => {
          const sessionId = button.dataset.id;
          const row = button.closest("tr");
          const maxSeats = row.querySelector(".max-seats-input").value;
          const availableSeats = row.querySelector(".available-seats-input").value;

          fetch("/api/yummy/sessions/update", {
              method: "PUT",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify({
                  session_id: parseInt(sessionId),
                  max_seats: parseInt(maxSeats),
                  available_seats: parseInt(availableSeats)
              })
          })
          .then(res => res.json())
          .then(data => {
              showMessage(data.message || "Session updated successfully.");
          })
          .catch(err => {
              console.error("Update error:", err);
              showMessage("Failed to update session.", true);
          });
      });
  });
}

function showMessage(msg, isError = false) {
  const msgBox = document.getElementById("cms-message");
  msgBox.innerHTML = `
      <div class="alert ${isError ? 'alert-danger' : 'alert-success'} alert-dismissible fade show" role="alert">
          ${msg}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
  `;
}
