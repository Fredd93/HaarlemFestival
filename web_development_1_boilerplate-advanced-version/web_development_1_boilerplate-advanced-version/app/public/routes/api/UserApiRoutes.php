<?php
require_once(__DIR__ . '/../../api/UserAPIController.php');


$controller = new UserApiController();

// Get authenticated user info
Route::add('/api/user/me', function () use ($controller) {
    $controller->getUserById();
}, ['GET']);

Route::add('/api/user/all', function () use ($controller) {
    $controller->getAllUsers();
}, ['GET']);

// Create a new user
Route::add('/api/user/create', function () use ($controller) {
    $controller->createUser();
}, ['POST']);

// Update user details
Route::add('/api/user/update', function () use ($controller) {
    $controller->updateUser();
}, ['PUT']);

// Update user password
Route::add('/api/user/updatePassword', function () use ($controller) {
    $controller->updatePassword();
}, ['PATCH']);

// Delete user account
Route::add('/api/user/delete', function () use ($controller) {
    $controller->deleteUser();
}, ['DELETE']);

?>
