document.addEventListener("DOMContentLoaded", function () {
    const eventForm = document.getElementById("eventForm");
    const eventImageInput = document.getElementById("event_image");
    const previewImage = document.getElementById("event_preview");
    const eventModal = new bootstrap.Modal(document.getElementById("eventModal"));

    let existingImagePath = "";

    // Handle "Add Event" button click: reset form and preview
    document.querySelector('[data-bs-target="#eventModal"]').addEventListener("click", () => {
        eventForm.reset();
        document.getElementById("event_id").value = "";
        existingImagePath = "";
        previewImage.src = "";
        previewImage.classList.add("d-none");
    });

    // Auto-fill form on Edit
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            document.getElementById("event_id").value = this.dataset.id;
            document.getElementById("event_name").value = this.dataset.name;
            document.getElementById("event_description").value = this.dataset.description;
            existingImagePath = this.dataset.image;

            if (previewImage && existingImagePath) {
                previewImage.src = existingImagePath.startsWith("/") ? existingImagePath : "/" + existingImagePath;
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

    // Delete event
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

    // Handle form submit (Add or Edit)
    eventForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        const eventId = document.getElementById("event_id").value;
        const name = document.getElementById("event_name").value;
        const description = document.getElementById("event_description").value;
        const method = eventId ? "PUT" : "POST";
        const url = eventId ? `/api/events/update/${eventId}` : "/api/events/create";

        let imagePath = existingImagePath;

        // Upload new image if selected
        if (eventImageInput.files.length > 0) {
            const formData = new FormData();
            formData.append("file", eventImageInput.files[0]);
            formData.append("page", "homepage"); // Optional if you're organizing by page

            try {
                const uploadRes = await fetch("/api/upload-image", {
                    method: "POST",
                    body: formData
                });

                const uploadData = await uploadRes.json();
                if (uploadData.success) {
                    imagePath = uploadData.fileUrl;
                } else {
                    alert("Image upload failed.");
                    return;
                }
            } catch (err) {
                console.error("Upload failed:", err);
                alert("Image upload error.");
                return;
            }
        }

        const body = {
            name,
            description,
            image: imagePath
        };

        console.log("📤 Sending to API:", JSON.stringify(body, null, 2));

        fetch(url, {
            method,
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(body)
        })
            .then(res => res.json())
            .then(data => {
                if (data.message) {
                    location.reload();
                } else {
                    alert("Error saving event");
                    console.error("Response error:", data);
                }
            })
            .catch(err => {
                console.error("Event save failed", err);
                alert("Something went wrong");
            });
    });
});
