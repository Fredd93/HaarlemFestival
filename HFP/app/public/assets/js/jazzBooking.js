document.addEventListener('DOMContentLoaded', () => {
    const bookingForm = document.getElementById('jazz-booking-form');

    if (!bookingForm) return;

    bookingForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const jazzType = document.getElementById('jazz_type').value;
        const ticketType = document.getElementById('ticket_type').value;
        const eventDetailId = parseInt(document.getElementById('event_detail_id').value);
        const passIdField = document.getElementById('pass_id');
        const passId = passIdField && passIdField.value ? parseInt(passIdField.value) : null;

        if (!jazzType || !ticketType || !eventDetailId) {
            alert("Please fill in all required fields.");
            return;
        }

        const payload = {
            jazz_type: jazzType,
            ticket_type: ticketType,
            event_detail_id: eventDetailId,
            pass_id: passId
        };

        try {
            const response = await fetch('/api/jazzTickets/book', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.message || "Ticket booked successfully!");
                bookingForm.reset();
            } else {
                alert(result.error || "Booking failed.");
            }
        } catch (error) {
            alert("An error occurred while booking the ticket.");
            console.error(error);
        }
    });
});
