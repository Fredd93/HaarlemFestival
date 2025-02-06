document.addEventListener("DOMContentLoaded", function () {
    let slides = document.querySelectorAll(".about-slide");
    let index = 0;

    function showSlide() {
        slides.forEach(slide => slide.style.display = "none");
        slides[index].style.display = "block";
        index = (index + 1) % slides.length;
    }

    setInterval(showSlide, 3000); // Change slide every 3 seconds
});
document.addEventListener("DOMContentLoaded", function () {
    fetchRestaurants();
});

function fetchRestaurants() {
    fetch('/api/eventDetails/type/Restaurant')  // API Call to fetch restaurants
        .then(response => response.json())
        .then(data => renderRestaurants(data))
        .catch(error => console.error("Error fetching restaurants:", error));
}

function renderRestaurants(restaurants) {
    const container = document.getElementById("restaurant-list");
    container.innerHTML = ""; // Clear previous content

    restaurants.forEach(restaurant => {
        const card = document.createElement("div");
        card.classList.add("restaurant-card");

        card.innerHTML = `
            <div class="card">
                <img src="${restaurant.image_url || '../../assets/images/default-restaurant.jpg'}" alt="${restaurant.name}" class="restaurant-image">
                <div class="card-content">
                    <h3 class="restaurant-name">${restaurant.name}</h3>
                    <p class="restaurant-description">${restaurant.description || "No description available."}</p>
                    <p class="restaurant-tags">${restaurant.tags}</p>
                    <p class="restaurant-time">${restaurant.event_time} - ${restaurant.event_date}</p>
                    <p class="restaurant-price">€${restaurant.event_price}</p>
                    <div class="restaurant-rating">${generateStars(restaurant.rating)}</div>
                    <button class="details-button">View Details</button>
                </div>
            </div>
        `;

        container.appendChild(card);
    });
}

function generateStars(rating) {
    let stars = "";
    for (let i = 1; i <= 5; i++) {
        stars += `<span class="star ${i <= rating ? "filled" : ""}">★</span>`;
    }
    return stars;
}

