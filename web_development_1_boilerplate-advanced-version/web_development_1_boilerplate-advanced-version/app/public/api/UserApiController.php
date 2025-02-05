<?php
require_once(__DIR__ . '/../models/UserModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');


class UserApiController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    /**
     * Get the authenticated user's information.
     */
    public function getUserById() {
        if (isset($_SESSION['user_id'])) {
            try {
                $user = $this->userModel->get($_SESSION['user_id']);
                if ($user) {
                    ResponseHelper::sendJson($user);
                } else {
                    ResponseHelper::sendError('User not found', 404);
                }
            } catch (Exception $e) {
                ResponseHelper::sendError('Failed to fetch user', 500);
            }
        } else {
            ResponseHelper::sendError('Unauthorized', 401);
        }
    }

    public function getAllUsers()
    {
        $user = $this->userModel->getAll();
        if ($user) {
            ResponseHelper::sendJson($user);
        } else {
            ResponseHelper::sendError('User not found', 404);
        }
    }

    /**
     * Create a new user.
     */
    public function createUser() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['username'], $data['email'], $data['password'], $data['role'])) {
                ResponseHelper::sendError('Invalid input', 400);
                return;
            }

            $user = $this->userModel->create(
                $data['username'],
                $data['email'],
                $data['password'],
                $data['role']
            );

            if ($user) {
                ResponseHelper::sendJson($user, 201);
            } else {
                ResponseHelper::sendError('Failed to create user', 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError('Internal Server Error', 500);
        }
    }

    /**
     * Update user details (excluding password).
     */
    public function updateUser() {
        if (!isset($_SESSION['user_id'])) {
            ResponseHelper::sendError('Unauthorized', 401);
            return;
        }

        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['username'], $data['email'], $data['role'])) {
                ResponseHelper::sendError('Invalid input', 400);
                return;
            }

            $success = $this->userModel->update($_SESSION['user_id'], $data['username'], $data['email'], $data['role']);

            if ($success) {
                ResponseHelper::sendJson(['message' => 'User updated successfully']);
            } else {
                ResponseHelper::sendError('Failed to update user', 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError('Internal Server Error', 500);
        }
    }

    /**
     * Update user password.
     */
    public function updatePassword() {
        if (!isset($_SESSION['user_id'])) {
            ResponseHelper::sendError('Unauthorized', 401);
            return;
        }

        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['password'])) {
                ResponseHelper::sendError('Invalid input', 400);
                return;
            }

            $success = $this->userModel->updatePassword($_SESSION['user_id'], $data['password']);

            if ($success) {
                ResponseHelper::sendJson(['message' => 'Password updated successfully']);
            } else {
                ResponseHelper::sendError('Failed to update password', 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError('Internal Server Error', 500);
        }
    }

    /**
     * Delete user account.
     */
    public function deleteUser() {
        if (!isset($_SESSION['user_id'])) {
            ResponseHelper::sendError('Unauthorized', 401);
            return;
        }

        try {
            $success = $this->userModel->delete($_SESSION['user_id']);

            if ($success) {
                ResponseHelper::sendJson(['message' => 'User deleted successfully']);
            } else {
                ResponseHelper::sendError('Failed to delete user', 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError('Internal Server Error', 500);
        }
    }
}
?>
