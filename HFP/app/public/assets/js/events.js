document.addEventListener("DOMContentLoaded", function () {
    const eventForm = document.getElementById("eventForm");
    const eventImageInput = document.getElementById("event_image");
    const previewImage = document.getElementById("event_preview");
    const eventModal = new bootstrap.Modal(document.getElementById("eventModal"));

    let existingImagePath = "";

    // Auto-fill form on Edit
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            document.getElementById("event_id").value = this.dataset.id;
            document.getElementById("event_name").value = this.dataset.name;
            document.getElementById("event_description").value = this.dataset.description;
            existingImagePath = this.dataset.image;

            if (previewImage && existingImagePath) {
                previewImage.src = "/" + existingImagePath;
                previewImage.classList.remove("d-none");
            }
        });
    });

    // Preview selected image
    eventImageInput.addEventListener("change", function () {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewImage.classList.remove("d-none");
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Delete logic (no changes)
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function () {
            const eventId = this.dataset.id;
            if (confirm("Are you sure you want to delete this event?")) {
                fetch(`/api/events/delete/${eventId}`, { method: "DELETE" })
                    .then(res => res.json())
                    .then(data => {
                        if (data.message) location.reload();
                        else alert("Error deleting event");
                    });
            }
        });
    });

    // Handle form submit
    eventForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const eventId = document.getElementById("event_id").value;
        const name = document.getElementById("event_name").value;
        const description = document.getElementById("event_description").value;
        const method = eventId ? "POST" : "POST"; // Always POST because we're uploading files
        const url = eventId ? `/api/events/update/${eventId}` : "/api/events/create";

        const formData = new FormData();
        formData.append("name", name);
        formData.append("description", description);

        if (eventImageInput.files.length > 0) {
            formData.append("image", eventImageInput.files[0]);
        } else if (eventId) {
            formData.append("existingImage", existingImagePath); // let backend fallback to this
        }

        fetch(url, {
            method,
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.message) location.reload();
                else alert("Error saving event");
            })
            .catch(err => {
                console.error("Event save failed", err);
                alert("Something went wrong");
            });
    });
});
