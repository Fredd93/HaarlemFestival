document.addEventListener("DOMContentLoaded", function () {
    let slides = document.querySelectorAll(".about-slide");
    let index = 0;

    function showSlide() {
        slides.forEach(slide => slide.style.display = "none");
        slides[index].style.display = "block";
        index = (index + 1) % slides.length;
    }

    setInterval(showSlide, 3000); 
});
document.addEventListener("DOMContentLoaded", function () {
    fetchRestaurants();
    fetchFoodTypes(); 
});

let allRestaurants = []; 

function fetchRestaurants() {
    fetch('/api/eventDetails/type/Restaurant') 
        .then(response => response.json())
        .then(data => {
            allRestaurants = data;
            renderRestaurants(allRestaurants);
        })
        .catch(error => console.error("Error fetching restaurants:", error));
}

function renderRestaurants(restaurants) {
    const container = document.getElementById("restaurant-list");
    container.innerHTML = ""; 
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

function fetchFoodTypes() {
    fetch('/api/eventDetails/uniqueTags')
        .then(response => response.json())
        .then(tags => populateFilter(tags))
        .catch(error => console.error("Error fetching food types:", error));
}

function populateFilter(tags) {
    const dropdown = document.getElementById("filter-dropdown");

    const allButton = document.createElement("button");
    allButton.classList.add("filter-option");
    allButton.innerText = "All";
    allButton.dataset.type = "all";
    allButton.addEventListener("click", () => filterRestaurants("all")); 

    dropdown.innerHTML = "";
    dropdown.appendChild(allButton);

    tags.forEach(tag => {
        const button = document.createElement("button");
        button.classList.add("filter-option");
        button.innerText = tag;
        button.dataset.type = tag;
        button.addEventListener("click", () => filterRestaurants(tag));
        dropdown.appendChild(button);
    });

    document.getElementById("filter-btn").addEventListener("click", () => {
        dropdown.classList.toggle("show");
    });
}


function filterRestaurants(type) {
    document.getElementById("filter-dropdown").classList.remove("show");

    if (type.toLowerCase() === "all") {  
        renderRestaurants(allRestaurants);
        return;
    }

    const filtered = allRestaurants.filter(restaurant => {
        if (!restaurant.tags) return false; // 
        return restaurant.tags.split(',').map(tag => tag.trim()).includes(type);
    });

    renderRestaurants(filtered);
}


function generateStars(rating) {
    let stars = "";
    for (let i = 1; i <= 5; i++) {
        stars += `<span class="star ${i <= rating ? "filled" : ""}">★</span>`;
    }
    return stars;
}

