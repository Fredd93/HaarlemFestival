<?php
require_once(__DIR__ . '/../models/UserModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');
require_once(__DIR__ . '/../middleware/apiAuthMiddleware.php'); 

class UserApiController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function getUserById() {
        requireApiLogin(); // 🔐

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
    }

    public function getAllUsers() {
        requireApiRole(['admin']); // 🔐

        $users = $this->userModel->getAll();
        if ($users) {
            ResponseHelper::sendJson($users);
        } else {
            ResponseHelper::sendError('Users not found', 404);
        }
    }

    public function createUser() {
        requireApiRole(['admin']); // 🔐

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

    public function updateUser() {
        requireApiRole(['admin']); // 🔐

        try {
            $data = json_decode(file_get_contents("php://input"), true);

            $user_id = isset($data['user_id']) ? (int) $data['user_id'] : null;
            if (!$user_id) {
                ResponseHelper::sendError("User ID is required for updating", 400);
                return;
            }

            $username = $data['username'] ?? null;
            $email = $data['email'] ?? null;
            $role = $data['role'] ?? null;

            if (!$username || !$email || !$role) {
                ResponseHelper::sendError("Missing required fields", 400);
                return;
            }

            $success = $this->userModel->update($user_id, $username, $email, $role);

            if ($success) {
                ResponseHelper::sendJson(["message" => "User updated successfully"]);
            } else {
                ResponseHelper::sendError("Failed to update user", 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Internal Server Error: " . $e->getMessage(), 500);
        }
    }

    public function updatePassword() {
        requireApiLogin(); // 🔐

        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['password']) || empty($data['password'])) {
                ResponseHelper::sendError('Password cannot be empty', 400);
                return;
            }

            $userId = $_SESSION['user_id'];
            $success = $this->userModel->updatePassword($userId, $data['password']);

            if ($success) {
                ResponseHelper::sendJson(['message' => 'Password updated successfully']);
            } else {
                ResponseHelper::sendError('Failed to update password', 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError('Internal Server Error', 500);
        }
    }

    public function deleteUser(int $userId) {
        requireApiRole(['admin']); // 🔐

        try {
            $success = $this->userModel->delete($userId);

            if ($success) {
                ResponseHelper::sendJson(['message' => 'User deleted successfully']);
            } else {
                ResponseHelper::sendError('Failed to delete user', 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError('Internal Server Error', 500);
        }
    }

    public function login() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['username'], $data['password'])) {
                ResponseHelper::sendError("Missing credentials", 400);
                return;
            }

            $username = trim($data['username']);
            $password = trim($data['password']);

            $user = $this->userModel->loginUser($username, $password);

            if ($user) {
                ResponseHelper::sendJson($user);
            } else {
                ResponseHelper::sendError("Invalid username or password", 401);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError('Login failed', 500);
        }
    }

    public function register() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['username'], $data['password'], $data['email'])) {
                ResponseHelper::sendError("Missing credentials", 400);
                return;
            }

            $username = trim($data['username']);
            $password = trim($data['password']);
            $email = trim($data['email']);

            $user = $this->userModel->create($username, $email, $password, 'user');

            if ($user) {
                ResponseHelper::sendJson($user, 201);
            } else {
                ResponseHelper::sendError("User registration failed", 500);
            }
        } catch (Exception $e) {
            error_log("Registration exception: " . $e->getMessage());
            ResponseHelper::sendError('Registration failed', 500);
        }
    }

    public function logout() {
        requireApiLogin(); // 🔐

        try {
            $this->userModel->logoutUser();
            ResponseHelper::sendJson(['message' => 'Logged out successfully']);
        } catch (Exception $e) {
            ResponseHelper::sendError('Logout failed', 500);
        }
    }
}
?>
