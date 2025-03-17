<?php
require_once 'BaseModel.php';
require_once 'dto/UserDTO.php';

class LoginModel extends BaseModel {

    public function loginUser($username, $password) {
        $stmt = self::$pdo->prepare('SELECT * FROM [User] WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id']; // Set session
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
        }
        else{
            ResponseHelper::sendError("Combination of Username and password incorrect", 400);
        }
    }
    public function logoutUser() {
        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_name']);
            unset($_SESSION['user_role']);
        }
    }

    public function getUser($username, $password) {
        $stmt = self::$pdo->prepare('SELECT * FROM [User] WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return getUserByUsername($username);
        }
        else{
            return null;
        }
    }
    public function getUserByUsername($username) {
        $stmt = self::$pdo->prepare('SELECT * FROM [User] WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user) {
            return new UserDTO($user['user_id'], $user['username'], $user['email'], $user['role'], $user['registration_date']);
        }
        else{
            return null;
        }
    }
}
?>
