<?php
require_once 'BaseModel.php';
require_once 'dto/UserDTO.php';

class LoginModel extends BaseModel {

    public function loginUser($username, $email, $password) {
        $stmt = self::$pdo->prepare('SELECT * FROM [User] WHERE username = :username AND email = :email');
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id']; // Set session
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_email'] = $user['email'];
        }
        else{
            ResponseHelper::sendError("Combination of Username, Email and password incorrect", 400);
        }
    }
    public function logoutUser() {
        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            unset($_SESSION['user_role']);
        }else{
            ResponseHelper::sendError("User not logged in", 400);
        }
    }
    public function registerUser($username, $email, $password) {
        $stmt = self::$pdo->prepare('SELECT username FROM [User] WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if($user){
            //There is already a user with that username
            ResponseHelper::sendError("Username already taken", 400);
        }else{
            $user = null;
            $stmt = self::$pdo->prepare('SELECT email FROM [User] WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            if($user){
                //There is already a user with that email
                ResponseHelper::sendError("Email already taken", 400);
            }else{
                $usermodel = new UserModel();
                $usermodel->create($username, $email, $password, "user");
                //Immediately log in the user too.
                $this->loginUser($username, $email, $password);
            }
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
