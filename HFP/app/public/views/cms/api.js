document.addEventListener("DOMContentLoaded", function () {
    const eventForm = document.getElementById("eventForm");
    const eventModal = new bootstrap.Modal(document.getElementById("eventModal"));

    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            document.getElementById("event_id").value = this.dataset.id;
            document.getElementById("event_name").value = this.dataset.name;
            tinymce.get("event_description").setContent(this.dataset.description);
            document.getElementById("event_image").value = this.dataset.image;
        });
    });

    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function () {
            const eventId = this.dataset.id;
            if (confirm("Are you sure you want to delete this event?")) {
                fetch(`/api/events/delete/${eventId}`, { method: "DELETE" })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            location.reload();
                        } else {
                            alert("Error deleting event");
                        }
                    });
            }
        });
    });

    eventForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const eventId = document.getElementById("event_id").value;
        const eventName = document.getElementById("event_name").value;
        const eventDescription = tinymce.get("event_description").getContent();
        const eventImage = document.getElementById("event_image").value;

        const method = eventId ? "PUT" : "POST";
        const url = eventId ? `/api/events/update/${eventId}` : "/api/events/create";

        fetch(url, {
            method: method,
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ name: eventName, description: eventDescription, image: eventImage })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                location.reload();
            } else {
                alert("Error saving event");
            }
        });
    });
});
