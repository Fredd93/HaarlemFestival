<?php
require_once(__DIR__ . '/../models/ContentModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class ContentApiController {
    private $contentModel;

    public function __construct() {
        $this->contentModel = new ContentModel();
    }

    /**
     * Get all content for a specific page (optionally filtered by detail_id).
     */
    public function getContentByPage($page) {
        try {
            $detailId = isset($_GET['detail_id']) ? (int)$_GET['detail_id'] : null;
            $content = $this->contentModel->getContentByPage($page, $detailId);
            ResponseHelper::sendJson($content);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve content", 500);
        }
    }

    /**
     * Get a specific content block by ID.
     */
    public function getContentById($id) {
        try {
            $content = $this->contentModel->getContentById($id);
            if ($content) {
                ResponseHelper::sendJson($content);
            } else {
                ResponseHelper::sendError("Content not found", 404);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve content", 500);
        }
    }

    /**
     * Create a new content block.
     */
    public function createContent() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['page'], $data['title'], $data['description'], $data['content_type'], $data['description_tag'])) {
                ResponseHelper::sendError("Invalid input", 400);
                return;
            }

            $image_url = $data['image_url'] ?? null;
            $detail_id = isset($data['detail_id']) ? (int)$data['detail_id'] : null;

            $content = $this->contentModel->createContent(
                $data['page'],
                $data['title'],
                $data['description'],
                $image_url,
                $data['content_type'],
                $data['description_tag'],
                $detail_id
            );

            if ($content) {
                ResponseHelper::sendJson($content, 201);
            } else {
                ResponseHelper::sendError("Failed to create content", 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Internal Server Error", 500);
        }
    }

    /**
     * Update existing content
     */
    public function updateContent($id) {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['title'], $data['description'], $data['description_tag'])) {
                ResponseHelper::sendError("Invalid input", 400);
                return;
            }

            $image_url = $data['image_url'] ?? null;

            $success = $this->contentModel->updateContent(
                $id,
                $data['title'],
                $data['description'],
                $data['content_type'],
                $image_url,
                $data['description_tag']
            );

            if ($success) {
                ResponseHelper::sendJson(["message" => "Content updated successfully"]);
            } else {
                ResponseHelper::sendError("Failed to update content", 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Internal Server Error", 500);
        }
    }

    /**
     * Delete content by ID.
     */
    public function deleteContent($id) {
        try {
            $success = $this->contentModel->deleteContent($id);

            if ($success) {
                ResponseHelper::sendJson(["message" => "Content deleted successfully"]);
            } else {
                ResponseHelper::sendError("Failed to delete content", 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Internal Server Error", 500);
        }
    }

    /**
     * Get content types for a specific page
     */
    public function getContentTypesByPage($page) {
        try {
            $types = $this->contentModel->getContentTypesByPage($page);
            ResponseHelper::sendJson($types);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to fetch content types", 500);
        }
    }

        // Get all detail pages (detail_id) for an event page like 'yummy'
    public function getDetailPages($page) {
        try {
            $pages = $this->contentModel->getDetailPagesForEvent($page);
            ResponseHelper::sendJson($pages);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve detail pages", 500);
        }
    }
    
    // Get content for a specific detail page
    public function getContentByPageAndDetail($page, $detailId) {
        try {
            $content = $this->contentModel->getContentByPageAndDetail($page, (int)$detailId);
            ResponseHelper::sendJson($content);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve detailed content", 500);
        }
    }
    
}
