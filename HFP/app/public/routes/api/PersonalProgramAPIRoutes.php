<?php

require_once(__DIR__ . "/../../api/PersonalProgramApiController.php");

$controller = new PersonalProgramApiController();

// GET all personal program items for current user
Route::add('/api/personalProgram', [$controller, 'getAllForUser'], 'get');
Route::add('/api/personalProgram/([0-9]+)', [$controller, 'delete'], 'delete');
