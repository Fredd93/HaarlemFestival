<?php
require_once(__DIR__ . '/../models/PersonalProgramModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class PersonalProgramAPIController {
    private $PersonalProgramModel;

    public function __construct() {
        $this->PersonalProgramModel = new PersonalProgramModel();
    }

    public function getById($userId)
    {
        $Programs = $this->PersonalProgramModel->getAllById($userId);
        if ($Programs) {
            ResponseHelper::sendJson($Programs);
        } else {
            ResponseHelper::sendError('Programs not found', 404);
        }
    }
}
?>