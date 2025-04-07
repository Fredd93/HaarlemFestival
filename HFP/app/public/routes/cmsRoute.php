<?php
require_once(__DIR__ . "/../controllers/ContentController.php");
require_once(__DIR__ . "/../middleware/apiAuthMiddleware.php");

// CMS dashboard
Route::add('/cms', function () {
    requireApiLogin();
    requireApiRole(['admin']);
    require(__DIR__ . "/../views/cms/cms.php");
});

// Event management
Route::add('/cms/events', function () {
    requireApiLogin();
    requireApiRole(['admin']);
    require(__DIR__ . "/../views/cms/events.php");
});

// Content manager
Route::add('/cms/content', function () {
    requireApiLogin();
    requireApiRole(['admin']);
    require(__DIR__ . "/../views/cms/content.php");
});

// User management
Route::add('/cms/users', function () {
    requireApiLogin();
    requireApiRole(['admin']);
    require(__DIR__ . "/../views/cms/users.php");
});

// Ticket overview
Route::add('/cms/tickets', function () {
    requireApiLogin();
    requireApiRole(['admin']);
    require(__DIR__ . "/../views/cms/tickets.php");
});

// Add content page
Route::add('/cms/content/add', function () {
    requireApiLogin();
    requireApiRole(['admin']);
    require(__DIR__ . "/../views/cms/cmsAddContent.php");
});

// Edit content by ID
Route::add('/cms/content/edit/([0-9]+)', function ($id) {
    requireApiLogin();
    requireApiRole(['admin']);
    $_GET['id'] = intval($id);
    require(__DIR__ . "/../views/cms/cmsEditContent.php");
});

// Ticket dispatcher for event types
Route::add('/cms/tickets/([a-zA-Z0-9_-]+)', function ($eventType) {
    requireApiLogin();
    requireApiRole(['admin']);
    $eventType = strtolower($eventType);
    require(__DIR__ . "/../views/cms/tickets/ticketsDispatcher.php");
});

// Orders page
Route::add('/cms/orders', function () {
    requireApiLogin();
    requireApiRole(['admin']);
    require(__DIR__ . "/../views/cms/orders.php");
});

// Unauthorized fallback route
Route::add('/cms/unauthorized', function () {
    http_response_code(403);
    echo "<p class='alert alert-danger'>Access Denied: You do not have permission to access this page.</p>";
    exit;
});
