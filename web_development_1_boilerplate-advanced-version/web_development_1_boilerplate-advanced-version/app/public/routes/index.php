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