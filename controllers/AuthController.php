<?php
require_once "./models/User.php";

class AuthController
{
    public function showLogin()
    {
        require_once "./views/login.php";
    }

    public function login()
    {
        $model = new User();

        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";

        $user = $model->findByEmail($email);

        if ($user && password_verify($password, $user["password"])) {

            $_SESSION["user"] = $user;

            // Nếu là admin → vào admin dashboard
            if ($user["role"] === "admin") {
                header("Location: index.php?admin=1&page=category");
            } else {
                header("Location: index.php");
            }
            exit;
        }

        $_SESSION["error"] = "Sai tài khoản hoặc mật khẩu!";
        header("Location: index.php?page=login");
    }

    public function showRegister()
    {
        require_once "./views/register.php";
    }

    public function register()
    {
        $model = new User();

        $fullname = $_POST["fullname"] ?? "";
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";

        // check email tồn tại
        if ($model->findByEmail($email)) {
            $_SESSION["error"] = "Email đã tồn tại!";
            header("Location: index.php?page=register");
            exit;
        }

        $model->createUser($fullname, $email, $password);

        $_SESSION["success"] = "Đăng ký thành công! Mời bạn đăng nhập.";
        header("Location: index.php?page=login");
    }

    public function logout()
    {
        unset($_SESSION["user"]);
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}
