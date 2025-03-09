document.addEventListener("DOMContentLoaded", function () {
    fetchJazzEvents();

    function fetchJazzEvents() {
        fetch("/api/jazzEvents")
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(events => {
                console.log('Fetched Events:', events);
                if (events.error) {
                    console.error("Error fetching events:", events.error);
                    return;
                }
                displayJazzEvents(events);
            })
            .catch(error => console.error("Error fetching Jazz events:", error));
    }

    // Setup Carousel Navigation
    function setupCarousel(carousel, prevBtn, nextBtn) {
        nextBtn.addEventListener("click", () => {
            carousel.scrollBy({ left: 300, behavior: "smooth" });
        });
        prevBtn.addEventListener("click", () => {
            carousel.scrollBy({ left: -300, behavior: "smooth" });
        });
    
        // Optional: drag-to-scroll code
        let isDragging = false;
        let startX, scrollLeft;
    
        carousel.addEventListener("mousedown", (e) => {
            isDragging = true;
            startX = e.pageX - carousel.offsetLeft;
            scrollLeft = carousel.scrollLeft;
        });

        carousel.addEventListener("mouseleave", () => {
            isDragging = false;
        });

        carousel.addEventListener("mouseup", () => {
            isDragging = false;
        });

        carousel.addEventListener("mousemove", (e) => {
            if (!isDragging) return;
            e.preventDefault();
            const x = e.pageX - carousel.offsetLeft;
            const walk = (x - startX) * 2;
            carousel.scrollLeft = scrollLeft - walk;
        });
    }

    function displayJazzEvents(events) {
        const container = document.getElementById("jazzEventsContainer");
        container.innerHTML = ""; // Clear previous content

        const eventsByDate = groupEventsByDate(events);
        console.log('Grouped Events:', eventsByDate);

        for (const date in eventsByDate) {
            // Create a header for each date
            const dayHeader = document.createElement("h2");
            dayHeader.textContent = formatDate(date);
            dayHeader.classList.add("day-header");
            container.appendChild(dayHeader);

            // A wrapper to hold everything for this day
            const dayWrapper = document.createElement("div");
            dayWrapper.classList.add("day-wrapper");

            // .carousel-wrapper will hold the carousel + arrow buttons
            const carouselWrapper = document.createElement("div");
            carouselWrapper.classList.add("carousel-wrapper");

            // The actual carousel container for the cards
            const carousel = document.createElement("div");
            carousel.classList.add("event-carousel");

            // Add each event as a card
            eventsByDate[date].forEach(event => {
                const eventCard = createEventCard(event);
                carousel.appendChild(eventCard);
            });

            // Create navigation buttons
            const prevBtn = document.createElement("button");
            prevBtn.classList.add("prev-event");
            prevBtn.textContent = "❮";

            const nextBtn = document.createElement("button");
            nextBtn.classList.add("next-event");
            nextBtn.textContent = "❯";

            // Append carousel + arrows to the wrapper
            carouselWrapper.appendChild(prevBtn);
            carouselWrapper.appendChild(carousel);
            carouselWrapper.appendChild(nextBtn);

            // Add the wrapper to the dayWrapper
            dayWrapper.appendChild(carouselWrapper);

            // Finally, add dayWrapper to the container
            container.appendChild(dayWrapper);

            // Setup arrow + drag behavior
            setupCarousel(carousel, prevBtn, nextBtn);
        }
    }

    // Create a single event card
    function createEventCard(event) {
        const card = document.createElement("div");
        card.classList.add("event-card");

        // Image
        const img = document.createElement("img");
        const eventDay = new Date(event.event_date).toLocaleString('en-us', { weekday: 'long' }).toLowerCase();
        img.src = `/assets/images/jazz/${eventDay}Events/${event.image}`;
        img.alt = event.name;

        // Title
        const title = document.createElement("h3");
        title.textContent = event.name;

        // Time & Venue
        const timeVenue = document.createElement("p");
        timeVenue.textContent = formatTime(event.time, event.duration) + ` at the ${event.venue}`;

        // Description
        const description = document.createElement("p");
        description.textContent = `Description: ${event.description}`;

        // Price
        const price = document.createElement("p");
        price.textContent = (event.price === 0)
            ? "Free for all visitors. No reservation needed."
            : `Ticket price €${event.price}`;

        // Buttons
        const buttonContainer = document.createElement("div");
        buttonContainer.classList.add("button-container");

        const detailsBtn = document.createElement("button");
        detailsBtn.classList.add("details-btn");
        detailsBtn.textContent = "Artist details";

        const saveBtn = document.createElement("button");
        saveBtn.classList.add("save-btn");
        saveBtn.textContent = "Save to program";

        buttonContainer.appendChild(detailsBtn);
        buttonContainer.appendChild(saveBtn);

        // Assemble card
        card.appendChild(img);
        card.appendChild(title);
        card.appendChild(timeVenue);
        card.appendChild(description);
        card.appendChild(price);
        card.appendChild(buttonContainer);

        return card;
    }

    // Group events by date, avoiding duplicates
    function groupEventsByDate(events) {
        const uniqueEvents = {};
        events.forEach(event => {
            const eventDate = event.event_date;
            if (!uniqueEvents[eventDate]) {
                uniqueEvents[eventDate] = [];
            }
            // Avoid adding duplicates
            if (!uniqueEvents[eventDate].some(e => e.name === event.name)) {
                uniqueEvents[eventDate].push(event);
            }
        });
        return uniqueEvents;
    }

    // Format date as e.g. "Thursday, August 7"
    function formatDate(dateString) {
        const options = { weekday: "long", month: "long", day: "numeric" };
        return new Date(dateString).toLocaleDateString("en-US", options);
    }

    // Format time range from startTime + duration
    function formatTime(startTimeString, duration) {
        const startTime = new Date(`1970-01-01T${startTimeString}Z`);
        const endTime = new Date(startTime.getTime() + duration * 60 * 1000);

        const startFormatted = startTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const endFormatted = endTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        return `${startFormatted} - ${endFormatted}`;
    }
});
