<?php

class UserDTO {
    public int $user_id;
    public string $username;
    public string $email;
    public string $role;
    public string $registration_date;

    public function __construct(int $user_id, string $username, string $email, string $role, string $registration_date) {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->email = $email;
        $this->role = $role;
        $this->registration_date = $registration_date;
    }
}
?>
