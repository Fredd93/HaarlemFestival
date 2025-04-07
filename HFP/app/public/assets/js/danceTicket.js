document.addEventListener("DOMContentLoaded", () => {
    fetchDanceEvents();
  });
  
  function fetchDanceEvents() {
    fetch("/api/dance-events")
      .then((res) => res.json())
      .then((events) => {
        console.log("Fetched dance events:", events);
        renderDanceTable(events);
      })
      .catch((err) => console.error("Failed to load dance events", err));
  }
  
  function renderDanceTable(events) {
    const tbody = document.getElementById("dance-events-body");
    tbody.innerHTML = "";
  
    events.forEach((event) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${event.artist}</td>
        <td>${event.venue}</td>
        <td>${event.session_type}</td>
        <td>${event.time}</td>
        <td>${event.duration} min</td>
        <td>&euro;${event.price}</td>
        <td>${event.day}</td>
        <td>
          <input type="number" min="0" value="${event.tickets_available ?? 0}" class="form-control" id="tickets-${event.event_detail_id}">
        </td>
        <td>
          <button class="btn btn-success btn-sm" onclick="updateTickets(${event.event_detail_id})">Save</button>
        </td>
      `;
      tbody.appendChild(row);
    });
  }
  
  function updateTickets(eventId) {
    const input = document.getElementById(`tickets-${eventId}`);
    const newAmount = parseInt(input.value);
  
    if (isNaN(newAmount) || newAmount < 0) {
      alert("Please enter a valid ticket amount.");
      return;
    }
  
    fetch(`/api/danceEvents/tickets/${eventId}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ tickets_available: newAmount })
    })
      .then(res => {
        if (!res.ok) throw new Error("Update failed");
        return res.json();
      })
      .then(data => {
        alert("Tickets updated successfully!");
        fetchDanceEvents();
      })
      .catch(err => {
        console.error("Failed to update tickets", err);
        alert("Failed to update tickets.");
      });
  }
  