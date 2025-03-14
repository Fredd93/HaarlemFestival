<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/ContentDTO.php");

class ContentModel extends BaseModel {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all content for a specific page
     */
    public function getContentByPage(string $page): array {
        $sql = "SELECT * FROM Content WHERE [page] = :page";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":page", $page, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->mapToDTO($row), $results);
    }

    /**
     * Get a specific content block by ID
     */
    public function getContentById(int $id): ?ContentDTO {
        $sql = "SELECT * FROM Content WHERE content_id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->mapToDTO($row) : null;
    }

    /**
     * Create a new content block
     */
    public function createContent(
        string $page, 
        string $title, 
        string $description, 
        ?string $image_url, 
        string $content_type, 
        string $description_tag
    ): ?ContentDTO {
        $sql = "INSERT INTO Content (page, title, description, image_url, content_type, description_tag) 
                VALUES (:page, :title, :description, :image_url, :content_type, :description_tag)";

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":page", $page);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":image_url", $image_url);
        $stmt->bindParam(":content_type", $content_type);
        $stmt->bindParam(":description_tag", $description_tag);

        if ($stmt->execute()) {
            return $this->getContentById(self::$pdo->lastInsertId());
        }
        return null;
    }

    /**
     * Update existing content
     */
    public function updateContent(
        int $id, 
        string $title, 
        string $description, 
        ?string $image_url, 
        string $description_tag
    ): bool {
        $sql = "UPDATE Content 
                SET title = :title, 
                    description = :description, 
                    image_url = :image_url, 
                    description_tag = :description_tag
                WHERE content_id = :id";

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":image_url", $image_url);
        $stmt->bindParam(":description_tag", $description_tag);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Delete content by ID
     */
    public function deleteContent(int $id): bool {
        $sql = "DELETE FROM Content WHERE content_id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Fetch content types for a given page from DB.
     * Table structure: content_types(page, type_key, type_label)
     */
    public function getContentTypesByPage(string $page): array {
        $sql = "SELECT type_key, type_label 
                FROM content_types
                WHERE page = :page
                ORDER BY type_label ASC";

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":page", $page, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows ?: [];
    }

    /**
     * Map a database row to ContentDTO
     */
    private function mapToDTO(array $row): ContentDTO {
        return new ContentDTO(
            (int) $row["content_id"],
            $row["page"],
            $row["title"] ?? '',
            $row["description"] ?? '',
            $row["image_url"] ?? null,
            $row["content_type"] ?? '',
            $row["description_tag"] ?? 'p'
        );
    }
}
