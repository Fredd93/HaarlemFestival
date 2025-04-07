function bookDanceTicket(eventDetailId, price) {
    let danceType = "free";

    if (price === 25) danceType = "main event";
    else if (price === 15) danceType = "secondary event";

    const payload = {
        dance_type: danceType,
        ticket_type: "standard",
        event_detail_id: eventDetailId
    };

    fetch("/api/danceTickets/book", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(result => {
        if (result.message) {
            alert(`✅ ${result.message}`);
        } else {
            alert(`❌ ${result.error}`);
        }
    })
    .catch(error => {
        console.error("Booking error:", error);
        alert("❌ Failed to book ticket.");
    });
}
