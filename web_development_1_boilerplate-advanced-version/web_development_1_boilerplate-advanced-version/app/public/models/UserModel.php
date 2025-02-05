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
                VALUES (:username, :email, :password, :role, NOW())";

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
        $sql = "UPDATE [User] SET username = :username, email = :email, role = :role WHERE user_id = :id";
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
}
?>
