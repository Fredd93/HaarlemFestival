<?php
require_once(__DIR__ . '/../../api/ContentApiController.php');

$controller = new ContentApiController();

// Get content by page
Route::add('/api/content/page/([a-zA-Z0-9_-]+)', function ($page) use ($controller) {
    $controller->getContentByPage($page);
}, ['GET']);

// Get content by ID
Route::add('/api/content/([0-9]+)', function ($id) use ($controller) {
    $controller->getContentById(intval($id));
}, ['GET']);

// Create new content
Route::add('/api/content/create', function () use ($controller) {
    $controller->createContent();
}, ['POST']);

// Update content
Route::add('/api/content/update/([0-9]+)', function ($id) use ($controller) {
    $controller->updateContent(intval($id));
}, ['PUT']);

// Delete content
Route::add('/api/content/delete/([0-9]+)', function ($id) use ($controller) {
    $controller->deleteContent(intval($id));
}, ['DELETE']);

// Get content types for a page
Route::add('/api/content/types/([a-zA-Z0-9_-]+)', function ($page) use ($controller) {
    $controller->getContentTypesByPage($page);
}, ['GET']);

// Upload image route
Route::add('/api/upload-image', function () {
    require(__DIR__ . '/../../api/uploadImage.php');
}, ['POST']);
