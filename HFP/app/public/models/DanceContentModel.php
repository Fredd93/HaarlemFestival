<?php

require_once(__DIR__ . "/BaseModel.php");
require_once __DIR__ . '/../dto/DanceContentDTO.php';

class DanceContentModel extends BaseModel {

    public function __construct() {
        parent::__construct();
    }

    public function getContentByPage(string $page): array {
        $sql = "SELECT * FROM content WHERE page = :page ORDER BY content_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindValue(':page', $page, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->mapToDTO($row), $results);
    }

    public function getAllContent(): array {
        $sql = "SELECT * FROM content ORDER BY content_id";
        $stmt = self::$pdo->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->mapToDTO($row), $results);
    }

    private function mapToDTO(array $row): DanceContentDTO {
        return new DanceContentDTO(
            (int) $row['content_id'],
            $row['page'],
            $row['title'] ?? '',
            $row['description'] ?? '',
            $row['image_url'] ?? '',
            $row['content_type']
        );
    }
}
