function bookDanceTicket(eventDetailId, price) {
    if (price === 25) danceType = "main event";
    else if (price === 15) danceType = "secondary event";

    const payload = {
        ticket_type: "standard",
        event_detail_id: eventDetailId,
        price: price
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
            updatePersonalProgramCount();
            if (document.getElementById("personal-program-overlay").classList.contains("show")) {
            loadPersonalProgramItems();
            }

        } else {
            alert(`❌ ${result.error}`);
        }
    })
    .catch(error => {
        console.error("Booking error:", error);
        alert("❌ Failed to book ticket.");
    });
}
