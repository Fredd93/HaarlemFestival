document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("eventContainer");

    fetch("/api/events/all")
        .then(response => response.json())
        .then(data => {
            if (!data || !Array.isArray(data)) {
                container.innerHTML = "<p class='text-danger'>Failed to load events.</p>";
                return;
            }

            container.innerHTML = ""; // clear loading state
            data.forEach(event => {
                const card = document.createElement("div");
                card.className = "col-md-4";

                card.innerHTML = `
                    <div class="card shadow-sm">
                    <img src="${'/' + event.image.replace(/^\/+/, '')}" class="card-img-top" alt="${event.event_name}">
                        <div class="card-body">
                            <h5 class="card-title">${event.event_name}</h5>
                            <p class="card-text">${event.event_description}</p>
                            <a href="/cms/tickets/dispatcher/${event.event_name}" class="btn btn-primary">Manage Tickets</a>
                        </div>
                    </div>
                `;

                container.appendChild(card);
            });
        })
        .catch(error => {
            console.error("Error fetching events:", error);
            container.innerHTML = "<p class='text-danger'>Something went wrong while loading events.</p>";
        });
});
