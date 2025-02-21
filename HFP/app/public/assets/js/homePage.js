let slideIndex = 0;

function showSlides() {
    let slides = document.querySelectorAll(".slideshow");
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }
    slides[slideIndex - 1].style.display = "block";
    setTimeout(showSlides, 3000); // Change slide every 3 seconds
}

// Initialize slideshow when page loads
document.addEventListener("DOMContentLoaded", function () {
    const eventContainer = document.getElementById("event-container");

    fetch("/api/events/all")
        .then(response => response.json())
        .then(events => {
            eventContainer.innerHTML = ""; // Clear previous content

            events.forEach(event => {
                const eventCard = document.createElement("div");
                eventCard.classList.add("event-card");

                eventCard.innerHTML = `
                    <img src="${event.image}" alt="${event.event_name}">
                    <div class="event-content">
                        <h3>${event.event_name}</h3>
                        <p>${event.event_description}</p>
                        <a href="${event.event_name}" class="event-btn">Learn More</a>
                    </div>
                `;

                eventContainer.appendChild(eventCard);
            });

            setupCarousel();
        })
        .catch(error => console.error("Error fetching events:", error));
});


// Setup Carousel Navigation
function setupCarousel() {
    const eventContainer = document.querySelector(".event-container");
    const prevBtn = document.querySelector(".prev-event");
    const nextBtn = document.querySelector(".next-event");
    
    let isDragging = false;
    let startX;
    let scrollLeft;

    // Drag Functionality
    eventContainer.addEventListener("mousedown", (e) => {
        isDragging = true;
        startX = e.pageX - eventContainer.offsetLeft;
        scrollLeft = eventContainer.scrollLeft;
    });

    eventContainer.addEventListener("mouseleave", () => {
        isDragging = false;
    });

    eventContainer.addEventListener("mouseup", () => {
        isDragging = false;
    });

    eventContainer.addEventListener("mousemove", (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX - eventContainer.offsetLeft;
        const walk = (x - startX) * 2;
        eventContainer.scrollLeft = scrollLeft - walk;
    });

    // Arrow Navigation
    nextBtn.addEventListener("click", () => {
        eventContainer.scrollBy({ left: 300, behavior: "smooth" });
    });

    prevBtn.addEventListener("click", () => {
        eventContainer.scrollBy({ left: -300, behavior: "smooth" });
    });
}
