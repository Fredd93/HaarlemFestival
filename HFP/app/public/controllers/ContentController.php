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
    public function getContentForPage(string $page, ?int $detailId = null): array {
        if ($detailId !== null) {
            return $this->contentModel->getContentByPageAndDetail($page, $detailId);
        }
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
     * from the database.
     */
    public function getContentTypesForPage(string $page): array {
        return $this->contentModel->getContentTypesByPage($page);
    }

    /**
     * Handle the updating of content via a normal POST request.
     */
   

    /**
     * Handle local image upload.
     * Stores the file inside `/assets/images/{page}/` and deletes the old image.
     */
    private function handleImageUpload(array $files, string $page, ?string $existingPath): ?string {
        if (!isset($files['image_upload']) || $files['image_upload']['error'] !== UPLOAD_ERR_OK) {
            return $existingPath; // No new image uploaded, return existing path
        }

        // Determine the base folder for images
        $basePage = explode("/", $page)[0]; // Extract the parent page name
        $uploadDir = __DIR__ . "/../../public/assets/images/{$basePage}/";

        // Ensure the directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Generate a unique filename
        $filename = time() . "_" . basename($files['image_upload']['name']);
        $targetPath = $uploadDir . $filename;

        // Move the uploaded file
        if (move_uploaded_file($files['image_upload']['tmp_name'], $targetPath)) {
            // Delete the old image if it exists
            if ($existingPath && file_exists(__DIR__ . "/../../public" . $existingPath)) {
                unlink(__DIR__ . "/../../public" . $existingPath);
            }

            // Return the relative path to store in the DB
            return "/assets/images/{$basePage}/" . $filename;
        }

        // If move fails, fallback to existing path
        return $existingPath;
    }
}
?>
