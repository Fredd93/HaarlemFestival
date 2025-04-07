<?php
require_once(__DIR__ . '/../../api/UserAPIController.php');

$controller = new UserApiController();

// Get authenticated user info
Route::add('/api/user/me', function () use ($controller) {
    $controller->getUserById();
}, ['GET']);

// Get all users
Route::add('/api/user/all', function () use ($controller) {
    $controller->getAllUsers();
}, ['GET']);

// Create a user directly (admin)
Route::add('/api/user/create', function () use ($controller) {
    $controller->createUser();
}, ['POST']);

// Update user details
Route::add('/api/user/update', function () use ($controller) {
    $controller->updateUser();
}, ['PUT']);

// Update password
Route::add('/api/user/updatePassword', function () use ($controller) {
    $controller->updatePassword();
}, ['PATCH']);

// Delete user
Route::add('/api/user/delete/([0-9]+)', function ($id) use ($controller) {
    $controller->deleteUser((int) $id);
}, ['DELETE']);


// ✅ NEW: Register
Route::add('/api/user/register', function () use ($controller) {
    $controller->register();
}, ['POST']);

// ✅ NEW: Login
Route::add('/api/user/login', function () use ($controller) {
    $controller->login();
}, ['POST']);

// ✅ NEW: Logout
Route::add('/api/user/logout', function () use ($controller) {
    $controller->logout();
}, ['POST']);
?>
