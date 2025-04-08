<?php

require_once __DIR__ . '/../models/DanceContentModel.php';
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class DanceContentApiController {

    private DanceContentModel $model;

    public function __construct() {
        $this->model = new DanceContentModel();
    }

    public function getContentByPage(array $params): void {
        if (!isset($params['page'])) {
            ResponseHelper::sendError("Missing 'page' parameter", 400);
            return;
        }

        $page = $params['page'];
        try {
            $data = $this->model->getContentByPage($page);
            ResponseHelper::sendJson($data);
        } catch (Exception $e) {
            error_log($e->getMessage());
            ResponseHelper::sendError("Failed to load content", 500);
        }
    }
}
