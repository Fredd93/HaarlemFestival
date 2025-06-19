document.addEventListener("DOMContentLoaded", () => {
    const pageSelector = document.getElementById("pageSelector");
    const detailTableWrapper = document.getElementById("detailPageTableWrapper");
    const detailTableBody = document.getElementById("detailPageTableBody");
    const contentTable = document.getElementById("contentTable");
    const addContentBtn = document.getElementById("addContentBtn");

    // Pages that have detail pages
    const eventPages = ["yummy", "jazz", "dance", "history", "teylers"];

    // Load the initial page content
    loadInitialPage(pageSelector.value);

    // Change page event
    pageSelector.addEventListener("change", () => {
        loadInitialPage(pageSelector.value);
    });

    // Add Content Button Click
    addContentBtn.addEventListener("click", function (e) {
        e.preventDefault();
    
        const page = pageSelector.value;
        const requiresDetail = ["yummy", "jazz", "dance", "history", "teylers"].includes(page);
        const detailRow = document.querySelector("tr[data-selected='true']");
        const detailId = detailRow ? detailRow.getAttribute("data-detail-id") : null;
    
        // If detail is required but not selected
        if (requiresDetail && !detailId && detailId !== "") {
            alert("Please select a detail page first.");
            return;
        }
    
        let url = `/cms/content/add?page=${encodeURIComponent(page)}`;
        if (detailId !== null) {
            url += `&detail_id=${encodeURIComponent(detailId)}`;
        }
    
        window.location.href = url;
    });
    

    // Load initial page or event detail list
    function loadInitialPage(page) {
        contentTable.innerHTML = "";
        detailTableBody.innerHTML = "";

        if (page === "homepage") {
            detailTableWrapper.style.display = "none";
            fetch(`/api/content/page/homepage`)
                .then(res => handleJsonResponse(res))
                .then(renderContentTable)
                .catch(err => console.error("Error loading homepage content:", err));
        } else {
            fetch(`/api/event-detail-references/type/${page}`)
                .then(res => handleJsonResponse(res))
                .then(details => {
                    detailTableWrapper.style.display = "block";
                    detailTableBody.innerHTML = "";

                    // Add 'Main Page' row manually
                    details.unshift({
                        event_detail_id: null,
                        name: "Main Page"
                    });

                    details.forEach(detail => {
                        const row = document.createElement("tr");
                        row.setAttribute("data-detail-id", detail.event_detail_id ?? "");
                        row.innerHTML = `
                            <td>${detail.name}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary view-detail-btn" 
                                        data-page="${page}" 
                                        data-detail-id="${detail.event_detail_id ?? ''}">
                                    View Content
                                </button>
                            </td>
                        `;
                        detailTableBody.appendChild(row);
                    });

                    // Attach click listeners to buttons
                    attachDetailButtonListeners();
                })
                .catch(err => {
                    console.error("Failed to load event detail pages:", err);
                    detailTableWrapper.style.display = "none";
                });
        }
    }

    // View content for selected detail page
    function attachDetailButtonListeners() {
        document.querySelectorAll(".view-detail-btn").forEach(btn => {
            btn.addEventListener("click", function () {
                const page = this.getAttribute("data-page");
                const detailId = this.getAttribute("data-detail-id") || null;

                // Mark this row as selected
                document.querySelectorAll("#detailPageTableBody tr").forEach(tr => {
                    tr.removeAttribute("data-selected");
                });
                this.closest("tr").setAttribute("data-selected", "true");

                loadDetailContent(page, detailId);
            });
        });
    }

    function loadDetailContent(page, detailId) {
        const url = detailId === null || detailId === "null"
            ? `/api/content/page/${page}`
            : `/api/content/page/${page}/detail/${detailId}`;

        fetch(url)
            .then(res => handleJsonResponse(res))
            .then(renderContentTable)
            .catch(err => console.error("Failed to load content for detail:", err));
    }

    // Render table rows
    function renderContentTable(data) {
        contentTable.innerHTML = "";

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
            contentTable.innerHTML += row;
        });
    }

    // Delete content block
    window.deleteContent = function (id) {
        if (!confirm("Are you sure you want to delete this content?")) return;

        fetch(`/api/content/delete/${id}`, { method: "DELETE" })
            .then(res => handleJsonResponse(res))
            .then(() => {
                const currentPage = pageSelector.value;
                loadInitialPage(currentPage);
            })
            .catch(err => console.error("Error deleting content:", err));
    };

    // Parse JSON safely
    function handleJsonResponse(res) {
        if (!res.ok) {
            throw new Error("Network response was not ok");
        }
        return res.text().then(text => text ? JSON.parse(text) : []);
    }
});
