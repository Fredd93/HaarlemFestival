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
                } else {
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
    input.value = parseInt(input.value) + 1;
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


function renderGenericProgramItem(item) {
    const card = document.createElement("div");
    card.className = "program-card";
    card.innerHTML = `
        <div class="program-card-header">
            <img src="assets/images/default-event.jpg" alt="Event Image" />
            <div class="event-title">${item.Event_Name || "Event"}</div>
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
            document.getElementById("purchase-btn").addEventListener("click", async function () {
        try {
            const response = await fetch('/api/personalProgram', {
                method: 'GET',
                credentials: 'include'
            });

            if (!response.ok) throw new Error("Failed to fetch program items");
            const items = await response.json();


            const sessionResponse = await fetch('/api/create-checkout-session.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ items })
            });

            const contentType = sessionResponse.headers.get("content-type") || "";
            if (!contentType.includes("application/json")) {
                throw new Error("Invalid response from server (not JSON)");
            }


            const sessionData = await sessionResponse.json();

            if (!sessionResponse.ok) throw new Error(sessionData.message || "Failed to create Stripe session");

            const stripe = Stripe("pk_test_51RP6DB2NUICtS7JXogct449MpayKlKOCM1FnNQ8IIBe7ZLZNXqclG2nkGh3OOj54id5xiziOLCEgWHA9dTH0HuRy00i9r8HfXd");
            stripe.redirectToCheckout({ sessionId: sessionData.sessionId });

        } catch (error) {
            console.error("❌ Error during payment process:", error);
            alert("Could not start payment: " + error.message);
        }
    });
}

