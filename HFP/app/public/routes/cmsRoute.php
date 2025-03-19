<?php


require_once(__DIR__ . "/../controllers/ContentController.php");
Route::add('/cms', function () {
    
    require(__DIR__ . "/../views/cms/cms.php"); // Main CMS dashboard
});

Route::add('/cms/events', function () {
    
    require(__DIR__ . "/../views/cms/events.php"); // Event management page
});

Route::add('/cms/content', function () {
    
    require(__DIR__ . "/../views/cms/content.php"); // Content manager page
});

Route::add('/cms/users', function () {
    
    require(__DIR__ . "/../views/cms/users.php"); // User management page
});

Route::add('/cms/tickets', function () {
    
    require(__DIR__ . "/../views/cms/tickets.php"); // Ticket management page (future)
});

Route::add('/cms/content/add', function () {
    require(__DIR__ . "/../views/cms/cmsAddContent.php");
});

// Edit Content Page
Route::add('/cms/content/edit/([0-9]+)', function ($id) {
    $_GET['id'] = intval($id); // Pass ID to GET request for content retrieval
    require(__DIR__ . "/../views/cms/cmsEditContent.php");
});

Route::add('/cms/content/update', function () {
    $controller = new ContentController();
    $controller->updateContent($_POST, $_FILES);
}, ['POST']);

// If an unauthorized user tries to access CMS
Route::add('/cms/unauthorized', function () {
    http_response_code(403);
    echo "<p class='alert alert-danger'>Access Denied: You do not have permission to access this page.</p>";
    exit;
});

?>
