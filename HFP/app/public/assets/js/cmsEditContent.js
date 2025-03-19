document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("editContentForm");
    const imageUpload = document.getElementById("image_upload");
    const imagePreview = document.querySelector(".img-thumbnail");
    const contentDescription = document.getElementById("content_description");

    // Initialize WYSIWYG Editor (TinyMCE)
    tinymce.init({
        selector: "#content_description",
        height: 300,
        menubar: false,
        plugins: "image code",
        toolbar: "undo redo | bold italic | alignleft aligncenter alignright | image code",
        images_upload_handler: function (blobInfo, success, failure) {
            uploadImage(blobInfo, success, failure);
        }
    });

    // Handle Form Submission (Update Content)
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const id = document.getElementById("content_id").value;
        const page = document.getElementById("content_page").value;
        const title = document.getElementById("content_title").value;
        const type = document.getElementById("content_type").value;
        const descriptionTag = document.getElementById("description_tag").value;
        const description = tinymce.activeEditor.getContent();
        let imageUrl = imagePreview.src; // Keep existing image unless changed

        // If an image is selected, upload it first
        if (imageUpload.files.length > 0) {
            uploadImageFile(imageUpload.files[0], (newImageUrl) => {
                imageUrl = newImageUrl;
                submitContentUpdate(id, page, title, type, descriptionTag, description, imageUrl);
            });
        } else {
            submitContentUpdate(id, page, title, type, descriptionTag, description, imageUrl);
        }
    });

    /**
     * Upload Image File Locally & Get Path
     */
    function uploadImageFile(file, callback) {
        let formData = new FormData();
        formData.append("file", file);

        fetch("/api/upload-image", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    callback(data.fileUrl);
                } else {
                    alert("Failed to upload image.");
                }
            })
            .catch(error => console.error("Error uploading image:", error));
    }

    /**
     * Submit Content Update
     */
    function submitContentUpdate(id, page, title, type, descriptionTag, description, imageUrl) {
        fetch(`/api/content/update/${id}`, {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                page,
                title,
                content_type: type,
                description_tag: descriptionTag,
                description,
                image_url: imageUrl
            })
        })
            .then(response => response.json())
            .then(() => {
                alert("Content updated successfully!");
                window.location.href = "/cms/content";
            })
            .catch(error => console.error("Error updating content:", error));
    }

    /**
     * Preview Selected Image Before Upload
     */
    imageUpload.addEventListener("change", function () {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
});
