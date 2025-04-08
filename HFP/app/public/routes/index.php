<?php

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

    Route::add('/yummy/Ratatouille', function () {
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
    Route::add('/jazz', function () {
        require(__DIR__ . "/../views/pages/jazz.php");
    });
    Route::add('/payment', function () {
        require(__DIR__ . "/../views/pages/paymentPage.php");
    });
    Route::add('/paymentSuccess', function () {
        require(__DIR__ . "/../views/pages/paymentSuccess.php");
    });
    
?>