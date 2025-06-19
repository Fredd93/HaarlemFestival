document.addEventListener("DOMContentLoaded", function () {
    console.log("📦 DOM loaded, updating personal program count...");
    updatePersonalProgramCount();
});

// Open Personal Program Overlay
function openPersonalProgram() {
    console.log("🧾 Opening personal program overlay...");
    document.getElementById("personal-program-overlay").classList.add("show");
    loadPersonalProgramItems();
}

// Close Personal Program Overlay
function closePersonalProgram() {
    console.log("❌ Closing personal program overlay...");
    document.getElementById("personal-program-overlay").classList.remove("show");
}

// Update Personal Program Item Count from Backend & Local Storage
function updatePersonalProgramCount() {
    const countElement = document.getElementById("personal-program-count");

    fetch('/api/personalProgram', {
        method: 'GET',
        credentials: 'include' // 🔐 Ensure session is sent
    })
        .then(response => {
            if (!response.ok) throw new Error("❌ Failed to fetch personal program");
            return response.json();
        })
        .then(data => {
            console.log("✅ Program items fetched for count:", data);
            const count = data.length || 0;

            if (count > 0) {
                countElement.innerText = count;
                countElement.classList.add("show");
            } else {
                console.log("ℹ️ No items from backend, checking localStorage...");
                checkLocalStorage(countElement);
            }
        })
        .catch(error => {
            console.error("🔥 Error fetching program count:", error);
            checkLocalStorage(countElement);
        });
}

function loadPersonalProgramItems() {
    console.log("🔄 Loading program items...");
    fetch('/api/personalProgram', {
        method: 'GET',
        credentials: 'include'
    })
        .then(response => response.json())
        .then(items => {
            console.log("📥 Program items received for overlay:", items);
            const container = document.getElementById("program-items");
            const purchaseBtn = document.getElementById("purchase-btn");

            container.innerHTML = '';

            if (items.length === 0) {
                container.innerHTML = "<p>Your personal program is empty.</p>";
                purchaseBtn.disabled = true; // 🚫 Disable when empty
                return;
            }

            // ✅ Enable button when there are items
            purchaseBtn.disabled = false;

            items.forEach(item => {
                let card;
                if (item.Event_Type.toLowerCase() === "jazz") {
                    card = renderJazzProgramItem(item);
                } else if (item.Event_Type.toLowerCase() === "history") {
                    card = renderHistoryProgramItem(item);
                }
                else {
                    card = renderGenericProgramItem(item);
                }
                container.appendChild(card);
            });
        })
        .catch(error => {
            console.error("🔥 Error loading program items:", error);
            document.getElementById("program-items").innerHTML = "<p>Failed to load your program.</p>";
            document.getElementById("purchase-btn").disabled = true;
        });
}


function increaseQty(btn) {
    const input = btn.previousElementSibling;
    if (input.max !== input.value) {
        input.value = parseInt(input.value) + 1;
    }
}

function decreaseQty(btn) {
    const input = btn.nextElementSibling;
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

// Call API to delete an item from the backend
function removeProgramItem(programId) {
    if (!confirm("Remove this item from your program?")) return;

    fetch(`/api/personalProgram/${programId}`, {
        method: 'DELETE'
    })
    .then(response => {
        if (!response.ok) throw new Error("Failed to delete item");
        return response.json();
    })
    .then(() => {
        updatePersonalProgramCount();
        loadPersonalProgramItems();
    })
    .catch(err => {
        console.error("Error deleting item:", err);
    });
}

// Fallback to Local Storage if Backend is Unavailable
function checkLocalStorage(countElement) {
    console.log("🧊 Checking localStorage for fallback...");
    let items = JSON.parse(localStorage.getItem("personalProgram")) || [];

    if (items.length > 0) {
        countElement.innerText = items.length;
        countElement.classList.add("show");
        console.log("✅ Loaded count from localStorage:", items.length);
    } else {
        countElement.innerText = "0";
        countElement.classList.remove("show");
        console.log("❌ No local items. Count reset.");
    }
}

// Optional: Click outside overlay to close it
window.addEventListener("click", function (e) {
    const overlay = document.getElementById("personal-program-overlay");

    if (
        overlay.classList.contains("show") &&
        !overlay.contains(e.target) &&
        !e.target.closest(".personal-program-btn")
    ) {
        closePersonalProgram();
    }
});

/**
 * Renders a personal program card for a jazz event.
 * Uses jazz-specific fields (e.g. Event_Image and Event_Name) provided by the backend.
 */
function renderJazzProgramItem(item) {
    const card = document.createElement("div");
    card.className = "program-card";
    // If the backend provided the image filename in Event_Image, use it; otherwise, fallback to a default image.
    const imgSrc = item.Event_Image ? `assets/images/jazz/${item.Event_Image}` : 'assets/images/default-event.jpg';
    card.innerHTML = `
        <div class="program-card-header">
            <img src="${imgSrc}" alt="${item.Event_Name || 'Jazz Event'}" />
            <div class="event-title">${item.Event_Name || "Jazz Event"}</div>
        </div>
        <div class="program-card-body">
            <p><strong>Day:</strong> ${item.Day || "N/A"}</p>
            <p><strong>Location:</strong> ${item.Location || "N/A"}</p>
            <p><strong>Time:</strong> ${item.Start_Time ? item.Start_Time.substring(0, 5) : "N/A"}</p>
            <div class="quantity-container">
                <button class="qty-btn" onclick="decreaseQty(this)">−</button>
                <input type="number" min="1" value="1" class="qty-input" />
                <button class="qty-btn" onclick="increaseQty(this)">+</button>
            </div>
            <div class="card-footer">
                <span class="price">€${parseFloat(item.Price).toFixed(2)}</span>
                <button class="delete-btn" onclick="removeProgramItem(${item.Program_Id})">🗑️</button>
            </div>
        </div>
    `;
    return card;
}
function renderHistoryProgramItem(item) {
    const card = document.createElement("div");
    card.className = "program-card";
    card.innerHTML = `
        <div class="program-card-header">
            <img src="assets/images/history/bavoKerkImage.png" alt="${item.Event_Name || 'A stroll through history'}" />
            <div class="event-title">A stroll through history</div>
        </div>
        <div class="program-card-body">
            <p><strong>Day:</strong> ${item.Day || "N/A"}</p>
            <p><strong>Location:</strong> ${item.Location || "N/A"}</p>
            <p><strong>Time:</strong> ${item.Start_Time ? item.Start_Time.substring(0,5) : "N/A"}</p>
            <p id="historyTicketLanguage"><strong>Language:</strong> ${item.Event_Language}</p>
            <div class="quantity-container">
                <button class="qty-btn" onclick="decreaseQty(this)">−</button>
                <input type="number" min="1" value="${item.Ticket_Count}" max="12" class="qty-input" />
                <button class="qty-btn" onclick="increaseQty(this)">+</button>
            </div>
            <div class="card-footer">
                <span class="price">€${parseFloat(item.Price).toFixed(2)}</span>
                <button class="delete-btn" onclick="removeProgramItem(${item.Program_Id})">🗑️</button>
            </div>
        </div>
    `;
    return card;
}

/**
 * Renders a generic personal program card for non-jazz events.
 * You can expand this function as needed for different event types.
 */
function renderGenericProgramItem(item) {
    const card = document.createElement("div");
    card.className = "program-card";
    card.innerHTML = `
        <div class="program-card-header">
            <img src="assets/images/default-event.jpg" alt="Event Image" />
            <div class="event-title">${item.Location || "Event"}</div>
        </div>
        <div class="program-card-body">
            <p><strong>Day:</strong> ${item.Day || "N/A"}</p>
            <p><strong>Location:</strong> ${item.Location || "N/A"}</p>
            <p><strong>Time:</strong> ${item.Start_Time ? item.Start_Time.substring(0,5) : "N/A"}</p>
            <div class="quantity-container">
                <button class="qty-btn" onclick="decreaseQty(this)">−</button>
                <input type="number" min="1" value="1" class="qty-input" />
                <button class="qty-btn" onclick="increaseQty(this)">+</button>
            </div>
            <div class="card-footer">
                <span class="price">€${parseFloat(item.Price).toFixed(2)}</span>
                <button class="delete-btn" onclick="removeProgramItem(${item.Program_Id})">🗑️</button>
            </div>
        </div>
    `;
    return card;
}
function goToPayment() {
    console.log("💳 Proceeding to payment...");

    // Optional: You could gather quantity inputs here if needed
    // For now we just redirect to payment page
    window.location.href = "/payment";
}

