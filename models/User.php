<?php
require_once "BaseModel.php";

class User extends BaseModel
{
    protected $table = "users";

    // tìm user theo email
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM $this->table WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["email" => $email]);
        return $stmt->fetch();
    }

    // đăng ký
    public function createUser($fullname, $email, $password)
    {
        $sql = "INSERT INTO $this->table (fullname, email, password) 
                VALUES (:fullname, :email, :password)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            "fullname" => $fullname,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_BCRYPT)
        ]);
    }
}
