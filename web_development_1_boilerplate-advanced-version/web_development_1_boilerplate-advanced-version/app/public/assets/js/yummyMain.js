document.addEventListener("DOMContentLoaded", function () {
    fetchRestaurants();
    fetchFoodTypes(); 
});

let allRestaurants = []; // Store all restaurants globally for filtering

function fetchRestaurants() {
    fetch('/api/yummyEvents')  // 🔹 New API endpoint for Yummy events
        .then(response => response.json())
        .then(data => {
            allRestaurants = data;
            renderRestaurants(allRestaurants);
        })
        .catch(error => console.error("Error fetching restaurants:", error));
}

function renderRestaurants(restaurants) {
    const container = document.getElementById("restaurant-list");
    container.innerHTML = ""; // Clear previous content

    restaurants.forEach(restaurant => {
        const card = document.createElement("div");
        card.classList.add("restaurant-card");

        // 🔹 Format time correctly as HH:mm (24-hour format)
        const formattedStartTime = formatTime(restaurant.startTime);
        const formattedEndTime = formatTime(restaurant.endTime);

        card.innerHTML = `
            <div class="card">
                <img src="${restaurant.img || '../../assets/images/default-restaurant.jpg'}" alt="${restaurant.name}" class="restaurant-image">
                <div class="card-content">
                    <h3 class="restaurant-name">${restaurant.name}</h3>
                    <p class="restaurant-description">${restaurant.description || "No description available."}</p>
                    <p class="restaurant-tags">${restaurant.type}</p>
                    <p class="restaurant-time">${formattedStartTime} - ${formattedEndTime}</p>
                    <p class="restaurant-price">€${restaurant.price}</p>
                    <div class="restaurant-rating">${generateStars(restaurant.stars)}</div>
                    <a href="/yummy/${restaurant.name}" class="details-button">View Details</a>
                </div>
            </div>
        `;

        container.appendChild(card);
    });
}
function formatTime(timeString) {
    if (!timeString) return "Unknown"; // Handle empty or undefined time

    const time = timeString.split(":"); 
    return `${time[0]}:${time[1]}`; // Extracts hours and minutes only
}


function fetchFoodTypes() {
    fetch('/api/yummyEvents/types')  // 🔹 Updated API route for types
        .then(response => response.json())
        .then(types => populateFilter(types))
        .catch(error => console.error("Error fetching food types:", error));
}

function populateFilter(types) {
    const dropdown = document.getElementById("filter-dropdown");
    dropdown.innerHTML = ""; 

    // "All" button
    const allButton = document.createElement("button");
    allButton.classList.add("filter-option");
    allButton.innerText = "All";
    allButton.dataset.type = "all";
    allButton.addEventListener("click", () => filterRestaurants("all"));
    dropdown.appendChild(allButton);

    // Create buttons for each type
    types.forEach(type => {
        const button = document.createElement("button");
        button.classList.add("filter-option");
        button.innerText = type;
        button.dataset.type = type;
        button.addEventListener("click", () => filterRestaurants(type));
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

    const filtered = allRestaurants.filter(restaurant => restaurant.type.includes(type));
    renderRestaurants(filtered);
}

function generateStars(rating) {
    let stars = "";
    for (let i = 1; i <= 5; i++) {
        stars += `<span class="star ${i <= rating ? "filled" : ""}">★</span>`;
    }
    return stars;
}
