<?php
require_once(__DIR__ . "/header.php");
require_once(__DIR__ . "/../../controllers/ContentController.php");

$contentController = new ContentController();
$content = null;

// 1. Fetch the content item
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $content = $contentController->getContentById($id);
}

// If not found, show error
if (!$content) {
    echo "<p class='alert alert-danger'>Content not found.</p>";
    exit;
}

// 2. Fetch content types for this specific page from DB
$contentTypes = $contentController->getContentTypesForPage($content->page);
?>

<div class="container mt-5">
    <h2>Edit Content</h2>

    <!-- Submitting to a normal route that calls 
         ContentController->updateContent($_POST, $_FILES)
    -->
    <form action="/cms/content/update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="content_id" value="<?= $content->content_id ?>">

        <div class="mb-3">
            <label for="content_page" class="form-label">Page</label>
            <input type="text" class="form-control" name="content_page" id="content_page" 
                   value="<?= htmlspecialchars($content->page, ENT_QUOTES, 'UTF-8') ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="content_title" class="form-label">Title</label>
            <!-- Provide a fallback empty string if title is null -->
            <input type="text" class="form-control" name="content_title" id="content_title" 
                   value="<?= htmlspecialchars($content->title ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        </div>

        <!-- 3. Dynamic Content Types from DB -->
        <div class="mb-3">
            <label for="content_type" class="form-label">Type</label>
            <select class="form-control" name="content_type" id="content_type">
                <?php foreach ($contentTypes as $type): ?>
                    <option value="<?= htmlspecialchars($type['type_key'], ENT_QUOTES, 'UTF-8') ?>"
                        <?= ($content->content_type === $type['type_key']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($type['type_label'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="description_tag" class="form-label">HTML Tag for Description</label>
            <select class="form-control" name="description_tag" id="description_tag">
                <option value="p"  <?= $content->description_tag === 'p'  ? 'selected' : '' ?>>Paragraph</option>
                <option value="h1" <?= $content->description_tag === 'h1' ? 'selected' : '' ?>>Heading 1</option>
                <option value="h2" <?= $content->description_tag === 'h2' ? 'selected' : '' ?>>Heading 2</option>
                <option value="h3" <?= $content->description_tag === 'h3' ? 'selected' : '' ?>>Heading 3</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="content_description" class="form-label">Description</label>
            <!-- Provide a fallback empty string if description is null -->
            <textarea class="form-control tinymce-editor" name="content_description" id="content_description">
                <?= htmlspecialchars($content->description ?? '', ENT_QUOTES, 'UTF-8') ?>
            </textarea>
        </div>

        <!-- Hidden field for the existing image URL -->
        <input type="hidden" name="current_image_url" 
               value="<?= htmlspecialchars($content->image_url ?? '', ENT_QUOTES, 'UTF-8') ?>">

        <div class="mb-3">
            <label class="form-label">Current Image</label>
            <?php if ($content->image_url): ?>
                <img src="<?= htmlspecialchars($content->image_url, ENT_QUOTES, 'UTF-8') ?>" 
                     class="img-thumbnail d-block mb-2" width="150">
            <?php else: ?>
                <p>No image available</p>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="image_upload" class="form-label">Upload New Image</label>
            <input type="file" class="form-control" name="image_upload" id="image_upload">
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
    </form>
</div>

<?php require_once(__DIR__ . "/footer.php"); ?>

<!-- TinyMCE Integration -->
<script src="https://cdn.tiny.cloud/1/khvhmotzuceh8kzk60ml7xmqejpnp6td7ng8he45bdyb64wh/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '.tinymce-editor',
    height: 300,
    menubar: false,
    plugins: 'image code',
    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | image code',
});
</script>
