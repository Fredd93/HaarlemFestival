<?php
    require_once(__DIR__ . "/../controllers/ContentController.php");
    require_once(__DIR__ . "/../middleware/apiAuthMiddleware.php");


    Route::add('/', function () {

    $contentController = new ContentController();
    $homepageContent = $contentController->getContentForPage("homepage");
        require(__DIR__ . "/../views/pages/index.php");
    });
    Route::add('/my-account', function () {
        require(__DIR__ . "/../views/pages/my-account.php");
    });
    Route::add('/yummy', function () {
        $controller = new ContentController();
        $page = 'yummy';
        $detailId = 0;
    
        $contentBlocks = $controller->getContentForPage("yummy");
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
        //redirecting to make it easier for detailpages
        //I don't know why I am doing this instead of making 
        //the button that sends you to this link send you to /history instead
        header('Location: /history');
        //Some functions really sound brutal
        die();
    });
    Route::add('/history', function() {
        require(__DIR__ . "/../views/pages/history.php");
    });
    Route::add('/history/Church_of_St.Bavo', function() {
        require(__DIR__ . "/../views/pages/St_Bavo.php");
    });
    Route::add('/history/Amsterdamse_Poort', function() {
        require(__DIR__ . "/../views/pages/Amsterdam_gate.php");
    });
    Route::add('/teylers', function() {
        require(__DIR__ . "/../views/pages/teylersMain.php");
    });
    Route::add('/jazz', function () {
        require(__DIR__ . "/../views/pages/jazz.php");
    });
    Route::add('/ticketing', function () {
        requireApiLogin();
        requireApiRole(['user']);
        require(__DIR__ . "/../views/pages/ticketing.php");
    });
    Route::add('/danceDetail1', function () {
        require(__DIR__ . "/../views/pages/danceDetail1.php");
    });

?>
