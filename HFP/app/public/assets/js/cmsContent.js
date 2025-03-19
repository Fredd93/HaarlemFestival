document.addEventListener("DOMContentLoaded", function () {
    const pageSelector = document.getElementById("pageSelector");
    const contentTypeSelector = document.getElementById("contentTypeSelector");

    // Load content types and content when page loads
    loadContentTypes(pageSelector.value).then(() => {
        loadContent(pageSelector.value, contentTypeSelector.value);
    });

    // When user changes the page
    pageSelector.addEventListener("change", function () {
        loadContentTypes(this.value).then(() => {
            loadContent(this.value, contentTypeSelector.value);
        });
    });

    // When user changes the content type
    contentTypeSelector.addEventListener("change", function () {
        loadContent(pageSelector.value, this.value);
    });
});

/**
 * Fetch content types from /api/content/types/{page} 
 * and populate #contentTypeSelector
 */
async function loadContentTypes(page) {
    // Clear the current dropdown
    contentTypeSelector.innerHTML = `<option value="">All</option>`;

    // GET request to fetch content types for that page
    const response = await fetch(`/api/content/types/${page}`);
    if (!response.ok) return; // If there's an error, just exit

    const types = await response.json();
    types.forEach(type => {
        const option = document.createElement("option");
        option.value = type.type_key;
        option.textContent = type.type_label;
        contentTypeSelector.appendChild(option);
    });
}

/**
 * Load content for the selected page & content type
 */
function loadContent(page, contentType) {
    let url = `/api/content/page/${page}`;
    if (contentType) {
        url += `?type=${contentType}`;
    }

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById("contentTable");
            tableBody.innerHTML = "";

            data.forEach(content => {
                const imageTag = content.image_url 
                    ? `<img src="${content.image_url}" class="img-thumbnail" width="50">`
                    : "No Image";

                const row = `
                    <tr>
                        <td>${content.title ?? ''}</td>
                        <td>${content.content_type ?? ''}</td>
                        <td>${content.description_tag?.toUpperCase() ?? ''}</td>
                        <td>${imageTag}</td>
                        <td>
                            <a href="/cms/content/edit/${content.content_id}" class="btn btn-primary btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm" onclick="deleteContent(${content.content_id})">Delete</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        })
        .catch(error => console.error("Error loading content:", error));
}

/**
 * Delete content from the database.
 */
function deleteContent(id) {
    if (!confirm("Are you sure you want to delete this content?")) return;

    fetch(`/api/content/delete/${id}`, { method: "DELETE" })
        .then(response => response.json())
        .then(() => {
            loadContent(
                document.getElementById("pageSelector").value, 
                document.getElementById("contentTypeSelector").value
            );
        })
        .catch(error => console.error("Error deleting content:", error));
}
