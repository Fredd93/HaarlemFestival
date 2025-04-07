document.addEventListener("DOMContentLoaded", () => {
    fetchYummyEvents();
  });
  
  function fetchYummyEvents() {
    fetch("/api/yummyEvents")
      .then((res) => res.json())
      .then((events) => renderTable(events))
      .catch((err) => console.error("Failed to load events", err));
  }
  
  function renderTable(events) {
    const tbody = document.getElementById("yummy-events-body");
    tbody.innerHTML = "";
  
    events.forEach((event) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${event.name}</td>
        <td>${event.type}</td>
        <td>&euro;${parseFloat(event.price).toFixed(2)}</td>
        <td>${event.child_price !== null ? `&euro;${parseFloat(event.childPrice).toFixed(2)}` : '-'}</td>
        <td>
          <input type="number" min="0" value="${event.seats}" class="form-control" id="seats-${event.eventDetailId}">
        </td>
        <td>${event.startTime ? event.startTime.substring(0,5) : '-'}</td>
        <td>${event.endTime ? event.endTime.substring(0,5) : '-'}</td>
        <td>
          <button class="btn btn-success btn-sm" onclick="updateSeats(${event.eventDetailId})">Save</button>
        </td>
      `;
      tbody.appendChild(row);
    });
  }
  
  function updateSeats(eventId) {
    const input = document.getElementById(`seats-${eventId}`);
    const newSeats = parseInt(input.value);
    console.log("Updating seats for event ID:", eventId, "New seats:", newSeats);
  
    if (isNaN(newSeats) || newSeats < 0) {
      alert("Please enter a valid seat number.");
      return;
    }
  
    fetch(`/api/yummyEvents/seats/${eventId}`, {
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
        fetchYummyEvents();
      })
      .catch(err => {
        console.error("Failed to update seats", err);
        alert("Failed to update seats.");
      });
  }
  