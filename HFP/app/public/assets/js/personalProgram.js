document.addEventListener("DOMContentLoaded", function () {
    updatePersonalProgramCount();
});

// Open Personal Program Overlay
function openPersonalProgram() {
    document.getElementById("personal-program-overlay").classList.add("show");
}

// Close Personal Program Overlay
function closePersonalProgram() {
    document.getElementById("personal-program-overlay").classList.remove("show");
}

// Update Personal Program Item Count from Backend & Local Storage
function updatePersonalProgramCount() {
    const countElement = document.getElementById("personal-program-count");

    // First, try fetching from the backend
    fetch('/api/personalProgram/count')
        .then(response => response.json())
        .then(data => {
            if (data.count > 0) {
                countElement.innerText = data.count;
                countElement.classList.add("show");
            } else {
                checkLocalStorage(countElement);
            }
        })
        .catch(error => {
            console.error("Error fetching program count:", error);
            checkLocalStorage(countElement); // Use local storage if API fails
        });
}

// Fallback to Local Storage if Backend is Unavailable
function checkLocalStorage(countElement) {
    let items = JSON.parse(localStorage.getItem("personalProgram")) || [];
    

    if (items.length > 0) {
        countElement.innerText = items.length;
        countElement.classList.add("show");
    } else {
        countElement.innerText = "0"; // Reset to 0 if empty
        countElement.classList.remove("show");
    }
}
