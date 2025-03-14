<?php
require_once(__DIR__ . "/../models/ContentModel.php");
require_once(__DIR__ . "/../dto/ContentDTO.php");

class ContentController {
    private $contentModel;

    public function __construct() {
        $this->contentModel = new ContentModel();
    }

    /**
     * Fetch all content for a specific page.
     */
    public function getContentForPage(string $page): array {
        return $this->contentModel->getContentByPage($page);
    }

    /**
     * Fetch a specific content block by ID.
     */
    public function getContentById(int $id): ?ContentDTO {
        return $this->contentModel->getContentById($id);
    }

    /**
     * Fetch the allowed content types for a specific page
     * from the database (e.g., 'hero', 'slideshow-image', etc.).
     */
    public function getContentTypesForPage(string $page): array {
        return $this->contentModel->getContentTypesByPage($page);
    }

    /**
     * Handle the updating of content via a normal POST request.
     * This method:
     * 1. Validates input.
     * 2. Validates the content_type against what's allowed for this page.
     * 3. Handles image upload (if provided).
     * 4. Updates the content in the database.
     * 5. Redirects back to the CMS content list.
     */
    public function updateContent(array $post, array $files): void {
        // Extract POST data
        $id              = (int)($post['content_id'] ?? 0);
        $page            = $post['content_page'] ?? '';
        $title           = $post['content_title'] ?? '';
        $contentType     = $post['content_type'] ?? '';
        $descriptionTag  = $post['description_tag'] ?? 'p';
        $description     = $post['content_description'] ?? '';
        $currentImageUrl = $post['current_image_url'] ?? null;

        // 1. Validate required fields
        if (!$id || !$title || !$page) {
            echo "<p class='alert alert-danger'>Invalid input data.</p>";
            return;
        }

        // 2. Validate content_type for this page
        $validTypes = $this->contentModel->getContentTypesByPage($page);
        $validKeys  = array_map(fn($t) => $t['type_key'], $validTypes);

        if (!in_array($contentType, $validKeys)) {
            echo "<p class='alert alert-danger'>Invalid content type '{$contentType}' for page '{$page}'.</p>";
            return;
        }

        // 3. Handle image upload (if a new file is uploaded)
        $newImageUrl = $this->handleImageUpload($files, $currentImageUrl);

        // 4. Perform the update in the model
        $success = $this->contentModel->updateContent(
            $id,
            $title,
            $description,
            $newImageUrl,
            $descriptionTag
        );

        // 5. Redirect back to the CMS content list
        if ($success) {
            header("Location: /cms/content");
            exit;
        } else {
            echo "<p class='alert alert-danger'>Failed to update content.</p>";
        }
    }

    /**
     * Handle local image upload and return the new file path (or existing path if no new file).
     */
    private function handleImageUpload(array $files, ?string $existingPath): ?string {
        // If no file was uploaded or there's an error, keep existing path
        if (!isset($files['image_upload']) || $files['image_upload']['error'] !== UPLOAD_ERR_OK) {
            return $existingPath;
        }

        // Ensure upload directory exists (e.g., /public/images/)
        $uploadDir = __DIR__ . "/../../public/assets/images/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Generate a unique filename
        $filename = time() . "_" . basename($files['image_upload']['name']);
        $targetPath = $uploadDir . $filename;

        // Move uploaded file to target
        if (move_uploaded_file($files['image_upload']['tmp_name'], $targetPath)) {
            // Return the relative path to store in DB
            return "/assets/images/" . $filename;
        }

        // If move fails, fallback to existing path
        return $existingPath;
    }
}
