document.addEventListener("DOMContentLoaded", () => {
    FetchHistorySchedule();
  });
  
  function FetchHistorySchedule() {
    fetch('/api/history/schedule')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch schedule');
            }
            return response.json();
        })
        .then(schedule => {
            renderHistoryTable(schedule);
        })
        .catch(error => {
            console.error("Error fetching schedule:", error);
        });
  }
  
  function renderHistoryTable(events) {
    const tbody = document.getElementById("history-events-body");
    tbody.innerHTML = "";
  
    events.forEach((event) => {
      const row = document.createElement("tr");
      console.log(event);
      row.innerHTML = `
        <td>${event.language}</td>
        <td>${event.date.split(' ')[0]}</td>
        <td>${event.date.split(' ')[1]}</td>
        <td>
          <input type="number" min="0" value="${event.maxTickets ?? 0}" class="form-control" id="tickets-${event.event_detail_id}">
        </td>
        <td>
          <button class="btn btn-success btn-sm" onclick="updateTickets(${event.event_detail_id}, '${event.language}', '${event.date}')">Save</button>
        </td>
      `;
      tbody.appendChild(row);
    });
  }
  
  function updateTickets(eventId, language, date) {
    const input = document.getElementById(`tickets-${eventId}`);
    const newAmount = parseInt(input.value);
  
    if (isNaN(newAmount) || newAmount < 0) {
      alert("Please enter a valid ticket amount.");
      return;
    }
    console.log(eventId);
    fetch(`/api/history/schedule/${eventId}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(
        { 
            language: language,
            timeStamp: date,
            maxTickets: newAmount ,
        })
    })
      .then(res => {
        if (!res.ok) throw new Error("Update failed");
        return res.json();
      })
      .then(data => {
        alert("Tickets updated successfully!");
        FetchHistorySchedule();
      })
      .catch(err => {
        console.error("Failed to update tickets", err);
        alert("Failed to update tickets.");
      });
  }
  