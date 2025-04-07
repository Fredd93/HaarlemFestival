
function bookYummyReservation(reservationData) {
    fetch('/api/reservations', {  // Ensure this endpoint maps to your ReservationApiController.
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(reservationData)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(errData => { 
                throw new Error(errData.message || "Booking failed"); 
            });
        }
        return response.json();
    })
    .then(data => {
        console.log("Reservation successful", data);
        // Update the session dropdown to reflect the booked slot.
        removeBookedSlot(reservationData.reservation_time);
    })
    .catch(error => console.error("Error booking reservation:", error));
}

/**
 * Disables or removes the booked slot from the session dropdown.
 */
function removeBookedSlot(bookedTime) {
    const sessionTimeSelect = document.getElementById("sessionTime");
    if (!sessionTimeSelect) return;
    
    for (let i = 0; i < sessionTimeSelect.options.length; i++) {
        if (sessionTimeSelect.options[i].value === bookedTime) {
            // Option 1: Remove the option
            // sessionTimeSelect.remove(i);
            
            // Option 2: Disable the option and mark it as booked
            sessionTimeSelect.options[i].disabled = true;
            sessionTimeSelect.options[i].textContent += " (Booked)";
            break;
        }
    }
}

/**
 * Attach event listener to the reservation form on page load.
 */
document.addEventListener("DOMContentLoaded", () => {
    const reservationForm = document.querySelector('.yummy-form-section form');
    if (reservationForm) {
        reservationForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Extract values from the form
            const clientName = document.getElementById('custName').value;
            const restaurantName = document.getElementById('restaurant').value;
            const reservationDate = document.getElementById('date').value;
            const reservationTime = document.getElementById('sessionTime').value;
            const numAdults = parseInt(document.getElementById('adults').value, 10);
            const numChildren = parseInt(document.getElementById('children').value, 10);
            const specialRequest = document.getElementById('specialRequests').value;
            
            // Find the restaurant event from the global allYummyEvents array (populated by yummyTicketing.js)
            const eventObj = allYummyEvents.find(evt => evt.name === restaurantName);
            if (!eventObj) {
                console.error("Selected restaurant not found");
                return;
            }
            const restaurantId = eventObj.eventDetailId;
            
            const reservationData = {
                restaurant_id: restaurantId,
                num_adults: numAdults,
                num_children: numChildren,
                reservation_date: reservationDate,
                reservation_time: reservationTime,
                client_name: clientName,
                special_request: specialRequest
            };
            
            // Call the API to book the reservation.
            bookYummyReservation(reservationData);
        });
    }
});
