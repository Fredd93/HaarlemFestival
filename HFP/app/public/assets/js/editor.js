tinymce.init({
    selector: '.tinymce-editor',
    menubar: false,
    plugins: 'image link lists code',
    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | image | bullist numlist outdent indent | code',
    images_upload_url: '/api/upload-image', // ✅ API route for handling image uploads
    images_upload_handler: function (blobInfo, success, failure) {
        let formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        fetch('/api/upload-image', { // ✅ Sends image to backend
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                success(data.fileUrl); // ✅ Returns image URL to TinyMCE
            } else {
                failure('Image upload failed');
            }
        })
        .catch(() => failure('Upload error'));
    },
    entity_encoding: 'raw', // Prevents encoding issues
    forced_root_block: 'p' // Ensures consistent paragraph formatting
});


document.addEventListener("DOMContentLoaded", function () {
    console.log("Initializing TinyMCE...");
    tinymce.init({
        selector: '.tinymce-editor',
        height: 300,
        menubar: false,
        plugins: 'link image lists',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image',
        setup: function (editor) {
            editor.on('init', function () {
                console.log("TinyMCE Initialized.");
            });
        }
    });
});