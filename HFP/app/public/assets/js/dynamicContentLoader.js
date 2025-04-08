/**
 * Load content for a specific page from the Content API.
 */
function loadPageContent(page) {
    fetch(`/api/content/page/${page}`)
        .then(response => response.json())
        .then(data => {
            console.log("Loaded content:", data); // Debugging

            data.forEach(content => {
                switch (content.content_type) {
                    case "hero":
                        document.getElementById("hero-title").innerText = content.title || "Haarlem Festival";
                        document.getElementById("hero-subtitle").innerText = content.description || "Experience Haarlem Like Never Before";
                        break;

                    case "festival-info":
                        document.getElementById("festival-title").innerText = content.title || "What is the Haarlem Festival?";
                        document.getElementById("festival-description").innerHTML = decodeHtml(content.description) || "The Haarlem Festival is a unique celebration of culture, food, and history."; 
                        break;

                    case "slideshow-image":
                        const slideshowContainer = document.getElementById("slideshow-container");
                        const img = document.createElement("img");
                        img.src = content.image_url;
                        img.alt = "Festival Image";
                        img.classList.add("slideshow");
                        slideshowContainer.appendChild(img);
                        break;

                    case "festival-highlight":
                        document.getElementById("highlight-title").innerText = content.title || "Why You’ll Love the Haarlem Festival?";
                        document.getElementById("highlight-content").innerHTML = decodeHtml(content.description) || "Cultural Diversity, Dining Experiences, and World-Class Performances."; 
                        if (content.image_url) {
                            document.getElementById("highlight-image").src = content.image_url;
                        }
                        break;

                    default:
                        console.warn("Unknown content type:", content.content_type);
                }
            });
        })
        .catch(error => console.error("Error loading content:", error));
}

/**
 * ✅ Function to decode escaped HTML entities in JSON.
 */
function decodeHtml(html) {
    const txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}
