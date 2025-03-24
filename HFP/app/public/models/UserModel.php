<?php

require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/UserDTO.php");

class UserModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all users.
     */
    public function getAll(): array
    {
        $sql = "SELECT user_id, username, email, role, registration_date FROM [User]";
        $stmt = self::$pdo->query($sql);

        $users = [];
        while ($row = $stmt->fetch()) {
            $users[] = new UserDTO(
                $row["user_id"],
                $row["username"],
                $row["email"],
                $row["role"],
                $row["registration_date"]
            );
        }
        return $users;
    }

    /**
     * Get a user by ID.
     */
    public function get(int $id): ?UserDTO
    {
        $sql = "SELECT user_id, username, email, role, registration_date FROM [User] WHERE user_id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();
        if ($row) {
            return new UserDTO(
                $row["user_id"],
                $row["username"],
                $row["email"],
                $row["role"],
                $row["registration_date"]
            );
        }
        return null;
    }

    /**
     * Create a new user.
     */
    public function create(string $username, string $email, string $password, string $role): ?UserDTO
    {
        $sql = "INSERT INTO [User] (username, email, password, role, registration_date) 
                VALUES (:username, :email, :password, :role, CURRENT_TIMESTAMP)";

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":role", $role);

        if ($stmt->execute()) {
            $id = self::$pdo->lastInsertId();
            return $this->get($id);
        }
        return null;
    }

    /**
     * Update user information.
     */
    public function update(int $id, string $username, string $email, string $role): bool
    {
        $sql = "UPDATE [User] SET username = :username, email = :email, [role] = :role WHERE user_id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Update user password.
     */
    public function updatePassword(int $id, string $newPassword): bool
    {
        $sql = "UPDATE [User] SET password = :password WHERE user_id = :id";
        $hashed_password = password_hash($newPassword, PASSWORD_BCRYPT);
        error_log("New Hashed Password: " . $hashed_password);

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Delete a user.
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM [User] WHERE user_id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

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
        }
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            //Email invalid
            ResponseHelper::sendError("Email invalid", 400);
        }
        else{
            $user = null;
            $stmt = self::$pdo->prepare('SELECT email FROM [User] WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            if($user){
                //There is already a user with that email
                ResponseHelper::sendError("Email already taken", 400);
            }else{
                $this->create($username, $email, $password, "user");
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
