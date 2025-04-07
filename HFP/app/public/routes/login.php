<?php

Route::add('/login', function () {
    
    require(__DIR__ . "/../views/pages/login.php");
});
Route::add('/register', function () {
    
    require(__DIR__ . "/../views/pages/register.php");
});

