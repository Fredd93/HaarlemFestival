<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/ContentDTO.php");

class ContentModel extends BaseModel {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all content for a specific page and optional detail_id
     */
    public function getContentByPage(string $page, ?int $detailId = null): array {
        $sql = "SELECT * FROM Content WHERE [page] = :page AND (detail_id IS NULL)";
        if ($detailId !== null) {
            $sql .= " AND detail_id = :detail_id";
        }

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":page", $page, PDO::PARAM_STR);
        if ($detailId !== null) {
            $stmt->bindParam(":detail_id", $detailId, PDO::PARAM_INT);
        }
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
        string $description_tag,
        ?int $detail_id = null
    ): ?ContentDTO {
        $sql = "INSERT INTO Content (page, title, description, image_url, content_type, description_tag, detail_id)
                VALUES (:page, :title, :description, :image_url, :content_type, :description_tag, :detail_id)";

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":page", $page);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":image_url", $image_url);
        $stmt->bindParam(":content_type", $content_type);
        $stmt->bindParam(":description_tag", $description_tag);
        $stmt->bindParam(":detail_id", $detail_id);

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
        string $content_type,
        ?string $image_url,
        string $description_tag
    ): bool {
        $sql = "UPDATE Content 
                SET title = :title,
                    description = :description,
                    image_url = :image_url,
                    content_type = :content_type,
                    description_tag = :description_tag
                WHERE content_id = :id";

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":content_type", $content_type);
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
     * Fetch content types for a given page from DB
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
            $row["description_tag"] ?? 'p',
            $row["detail_id"] ?? null
        );
    }
        // Get all distinct detail_ids for a given page (e.g. yummy, jazz)
    public function getDetailPagesForEvent(string $page): array {
        $sql = "SELECT DISTINCT detail_id FROM Content WHERE page = :page AND detail_id IS NOT NULL";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":page", $page);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get content by page + detail_id (used when managing detailed pages)
    public function getContentByPageAndDetail(string $page, $detailId): array {
        if ($detailId === null) {
            $sql = "SELECT * FROM Content WHERE page = :page AND detail_id IS NULL";
            $stmt = self::$pdo->prepare($sql);
            $stmt->bindParam(":page", $page);
        } else {
            $sql = "SELECT * FROM Content WHERE page = :page AND detail_id = :detail_id";
            $stmt = self::$pdo->prepare($sql);
            $stmt->bindParam(":page", $page);
            $stmt->bindParam(":detail_id", $detailId, PDO::PARAM_INT);
        }
    
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => $this->mapToDTO($row), $results);
    }
    
    public function getSubpagesByPage(string $page): array {
        $sql = "SELECT DISTINCT detail_id, MAX(title) AS name
                FROM Content
                WHERE page = :page AND detail_id IS NOT NULL
                GROUP BY detail_id
                ORDER BY detail_id ASC";
    
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":page", $page);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}
