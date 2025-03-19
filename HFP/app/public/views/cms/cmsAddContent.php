<?php
require_once(__DIR__ . "/header.php");
?>

<div class="container mt-5">
    <h2>Add New Content</h2>

    <form id="addContentForm">
        <div class="mb-3">
            <label for="content_page" class="form-label">Page</label>
            <select class="form-control" id="content_page">
                <option value="homepage">Homepage</option>
                <option value="yummy">Yummy</option>
                <option value="dance">Dance</option>
                <option value="history">History</option>
                <option value="jazz">Jazz</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="content_title" class="form-label">Title</label>
            <input type="text" class="form-control" id="content_title" required>
        </div>

        <div class="mb-3">
            <label for="content_type" class="form-label">Type</label>
            <select class="form-control" id="content_type">
                <option value="hero">Hero Section</option>
                <option value="festival-info">Festival Info</option>
                <option value="slideshow-image">Slideshow Image</option>
                <option value="festival-highlight">Festival Highlight</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="description_tag" class="form-label">HTML Tag for Description</label>
            <select class="form-control" id="description_tag">
                <option value="p">Paragraph</option>
                <option value="h1">Heading 1</option>
                <option value="h2">Heading 2</option>
                <option value="h3">Heading 3</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="content_description" class="form-label">Description</label>
            <textarea class="form-control tinymce-editor" id="content_description"></textarea>
        </div>

        <div class="mb-3">
            <label for="content_image" class="form-label">Image URL</label>
            <input type="text" class="form-control" id="content_image">
        </div>

        <button type="submit" class="btn btn-success">Create Content</button>
    </form>
</div>

<?php require_once(__DIR__ . "/footer.php"); ?>
<script src="./../../assets/js/cmsAddContent.js"></script>
