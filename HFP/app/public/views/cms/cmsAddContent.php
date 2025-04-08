<?php
require_once(__DIR__ . "/header.php");
require_once(__DIR__ . "/../../controllers/ContentController.php");

$page = $_GET['page'] ?? null;
$detailId = isset($_GET['detail_id']) ? (int)$_GET['detail_id'] : null;

if (!$page) {
    echo "<p class='alert alert-danger'>No page specified.</p>";
    exit;
}


$contentController = new ContentController();
$contentTypes = $contentController->getContentTypesForPage($page);
?>

<div class="container mt-5">
    <h2>Add New Content for <strong><?= htmlspecialchars($page) ?></strong></h2>

    <form id="addContentForm" enctype="multipart/form-data">
        <input type="hidden" name="page" id="content_page" value="<?= htmlspecialchars($page) ?>">
        <?php $detailId = $detailId ?? ''; ?>
        <input type="hidden" id="content_detail_id" name="content_detail_id" value="<?= htmlspecialchars($detailId, ENT_QUOTES, 'UTF-8') ?>">

        <div class="mb-3">
            <label for="content_title" class="form-label">Title</label>
            <input type="text" class="form-control" name="content_title" id="content_title" required>
        </div>

        <div class="mb-3">
            <label for="content_type" class="form-label">Type</label>
            <select class="form-control" name="content_type" id="content_type" required>
                <?php foreach ($contentTypes as $type): ?>
                    <option value="<?= htmlspecialchars($type['type_key'], ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($type['type_label'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="description_tag" class="form-label">HTML Tag for Description</label>
            <select class="form-control" name="description_tag" id="description_tag">
                <option value="p">Paragraph</option>
                <option value="h1">Heading 1</option>
                <option value="h2">Heading 2</option>
                <option value="h3">Heading 3</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="content_description" class="form-label">Description</label>
            <textarea class="form-control tinymce-editor" name="content_description" id="content_description"></textarea>
        </div>

        <div class="mb-3">
            <label for="image_upload" class="form-label">Image</label>
            <input type="file" class="form-control" name="image_upload" id="image_upload">
            <img id="previewImage" class="img-thumbnail d-none mt-2" width="200" />
        </div>

        <button type="submit" class="btn btn-primary">Add Content</button>
    </form>
</div>

<?php require_once(__DIR__ . "/footer.php"); ?>
<script src="../../assets/js/cmsAddContent.js"></script>

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
