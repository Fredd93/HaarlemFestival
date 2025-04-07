
document.addEventListener("DOMContentLoaded", () => {
    fetchJazzEvents();
  });
  
  function fetchJazzEvents() {
    fetch("/api/jazzEvents")
      .then((res) => res.json())
      .then((events) => renderJazzTable(events))
      .catch((err) => console.error("Failed to load jazz events", err));
  }
  
  function renderJazzTable(events) {
    const tbody = document.getElementById("jazz-events-body");
    tbody.innerHTML = "";
  
    events.forEach((event) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${event.name}</td>
        <td>${event.venue}</td>
        <td>&euro;${parseFloat(event.price).toFixed(2)}</td>
        <td>${event.duration}h</td>
        <td>${event.event_date}</td>
        <td>
          <input type="number" min="0" value="${event.seats ?? 0}" class="form-control" id="seats-${event.event_detail_id}">
        </td>
        <td>${event.time ? event.time.substring(0,5) : '-'}</td>
        <td>
          <button class="btn btn-success btn-sm" onclick="updateSeats(${event.event_detail_id})">Save</button>
        </td>
      `;
      tbody.appendChild(row);
    });
  }
  
  function updateSeats(eventId) {
    const input = document.getElementById(`seats-${eventId}`);
    const newSeats = parseInt(input.value);
  
    if (isNaN(newSeats) || newSeats < 0) {
      alert("Please enter a valid number of seats.");
      return;
    }
  
    fetch(`/api/jazzEvents/seats/${eventId}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ seats: newSeats })
    })
      .then(res => {
        if (!res.ok) throw new Error("Update failed");
        return res.json();
      })
      .then(data => {
        alert("Seats updated successfully!");
        fetchJazzEvents();
      })
      .catch(err => {
        console.error("Failed to update seats", err);
        alert("Failed to update seats.");
      });
  }
  