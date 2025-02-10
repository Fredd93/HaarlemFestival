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
        $_SESSION['user_id'] = 1;
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
            ResponseHelper::sendJson(['error' => 'Unauthorized'], 401);
            return;
        }
    
        try {
            $data = json_decode(file_get_contents("php://input"), true);
    
            if (!isset($data['username']) && !isset($data['email'])) {
                ResponseHelper::sendJson(['error' => 'Invalid input'], 400);
                return;
            }
    
            $userId = $_SESSION['user_id'];
            $userModel = new UserModel();
            $success = $userModel->update($userId, $data['username'] ?? "", $data['email'] ?? "", "user");
    
            if ($success) {
                ResponseHelper::sendJson(['message' => 'User updated successfully']);
            } else {
                ResponseHelper::sendJson(['error' => 'Failed to update user'], 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendJson(['error' => 'Internal Server Error'], 500);
        }
    }
    
    /**
     * Update user password.
     */
    public function updatePassword() {
        if (!isset($_SESSION['user_id'])) {
            ResponseHelper::sendJson(['error' => 'Unauthorized'], 401);
            return;
        }
    
        try {
            $data = json_decode(file_get_contents("php://input"), true);
    
            if (!isset($data['password']) || empty($data['password'])) {
                ResponseHelper::sendJson(['error' => 'Password cannot be empty'], 400);
                return;
            }
    
            $userId = $_SESSION['user_id'];
            $userModel = new UserModel();
            $success = $userModel->updatePassword($userId, $data['password']);
    
            if ($success) {
                ResponseHelper::sendJson(['message' => 'Password updated successfully']);
            } else {
                ResponseHelper::sendJson(['error' => 'Failed to update password'], 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendJson(['error' => 'Internal Server Error'], 500);
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
