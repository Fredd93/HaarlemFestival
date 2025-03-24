<?php
require_once(__DIR__ . '/../../api/AuthController.php');


//Because passwords and such have to be kept secure i'm not using query parameters. 
//This limits me to HAVING to use POST requests to send data encoded in the body.

//Purely returns data about the user. If the user is an admin you only need to give the username, otherwise the password is also required.
//THIS IS NOT TO LOG IN!
//turns out to be useless since its already in the CMS. This is theoretically securer though
Route::add('/api/login/get', function () {
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;
    $role = $_SESSION['user_role'];
    $Controller = new AuthController();
    //Information is only returned if the password and username is given OR the role is admins
    if($role === 'admin'){
        $Controller->getUserByUsername($username);
    }else{
        $Controller->getUser($username, $password);
    }
}, ['POST']);

Route::add('/api/login/register', function () {
    $username = $_POST['username'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $Controller = new AuthController();
    $Controller->registerUser($username, $email, $password);
}, ['POST']);

Route::add('/api/login/login', function () {
    $username = $_POST['username'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $Controller = new AuthController();
    $Controller->loginUser($username, $email, $password);
}, ['POST']);

Route::add('/api/login/logout', function () {
    $Controller = new AuthController();
    $Controller->logoutUser();
}, ['POST']); //Keeping it as POST so its the same as the rest although its not really needed in this case.
