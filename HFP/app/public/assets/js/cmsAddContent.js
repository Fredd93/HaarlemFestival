document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("addContentForm");
    const imageUpload = document.getElementById("image_upload");
    const previewImage = document.getElementById("previewImage");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const page = document.getElementById("content_page").value;
        const detailId = document.getElementById("content_detail_id")?.value || null;
        const title = document.getElementById("content_title").value;
        const type = document.getElementById("content_type").value;
        const descriptionTag = document.getElementById("description_tag").value;
        const description = tinymce.get("content_description").getContent();

        // Console debug
        console.log("Form values:", {
            page, detailId, title, type, descriptionTag, description
        });

        if (imageUpload.files.length > 0) {
            uploadImageFile(imageUpload.files[0], (imageUrl) => {
                submitAddContent(page, title, type, detailId, descriptionTag, description, imageUrl);
            });
        } else {
            submitAddContent(page, title, type, detailId, descriptionTag, description, null);
        }
    });

    function uploadImageFile(file, callback) {
        const page = document.getElementById("content_page").value;
        let formData = new FormData();
        formData.append("file", file);
        formData.append("page", page); // Pass the page name
    
        fetch("/api/upload-image", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    callback(data.fileUrl);
                } else {
                    alert("Image upload failed.");
                }
            })
            .catch(error => console.error("Error uploading image:", error));
    }
    

    function submitAddContent(page, title, type, detailId, descriptionTag, description, imageUrl) {
        fetch("/api/content/create", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                page,
                title,
                content_type: type,
                description_tag: descriptionTag,
                description,
                image_url: imageUrl,
                detail_id: detailId // make sure it's named correctly!
            })
        })
        .then(async res => {
            const text = await res.text();
            let json;
        
            try {
                json = JSON.parse(text);
            } catch (err) {
                console.error("❌ Response was not valid JSON:", text);
                throw new Error("Invalid JSON response");
            }
        
            if (!res.ok) {
                console.error("❌ Server returned error:", json);
                alert(json?.error || "Something went wrong.");
                return;
            }
        
            alert("Content added successfully!");
            window.location.href = `/cms/content?page=${page}`;
        })
        .catch(err => {
            console.error("❌ Failed to add content", err);
        });
        
    }

    imageUpload.addEventListener("change", function () {
        if (this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewImage.classList.remove("d-none");
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
});
