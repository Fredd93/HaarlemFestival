<?php

require_once(__DIR__ . "/BaseModel.php");
require_once __DIR__ . '/../dto/DanceContentDTO.php';

class DanceContentModel extends BaseModel {

    public function getContentByPage(string $page): array {
        $query = "SELECT * FROM content WHERE page = :page ORDER BY content_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':page', $page, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $contents = [];
        foreach ($rows as $row) {
            $contents[] = new DanceContentDTO(
                (int)$row['content_id'],
                $row['page'],
                $row['title'] ?? '',
                $row['description'] ?? '',
                $row['image_url'] ?? '',
                $row['content_type']
            );
        }
        return $contents;
    }
}
