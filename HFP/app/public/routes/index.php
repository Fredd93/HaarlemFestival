<?php
    require_once(__DIR__ . "/../controllers/ContentController.php");


    Route::add('/', function () {
        require(__DIR__ . "/../views/pages/index.php");
    });
    Route::add('/my-account', function () {
        require(__DIR__ . "/../views/pages/my-account.php");
    });
    Route::add('/yummy', function () {
        require(__DIR__ . "/../views/pages/yummyMain.php");
    });
    Route::add('/dance', function () {
        require(__DIR__ . "/../views/pages/danceMain.php");
    });

    Route::add('/yummy/ratatouille', function () {
    
        $controller = new ContentController();
        $page = 'yummy';
        $detailId = 2;
    
        $contentBlocks = $controller->getContentForPage($page, $detailId);
    
        // Now pass $contentBlocks to the view
        require(__DIR__ . "/../views/pages/ratatouille.php");
    });
    
    Route::add('/yummy/Café de Roemer', function () {
        require(__DIR__ . "/../views/pages/roemer.php");
    });
    Route::add('/a stroll through history', function() {
        require(__DIR__ . "/../views/pages/history.php");
    });
    Route::add('/history', function() {
        require(__DIR__ . "/../views/pages/history.php");
    });
    Route::add('/teylers', function() {
        require(__DIR__ . "/../views/pages/teylersMain.php");
    });
    Route::add('/jazz', function () {
        require(__DIR__ . "/../views/pages/jazz.php");
    });

?>
