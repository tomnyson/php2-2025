<?php
require_once "model/UserModel.php";
require_once "view/helpers.php";

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function register() {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->userModel->register($name, $email, $password)) {
                header("Location: /login");
                exit;
            } else {
                $error = "Registration failed. Email may already be in use.";
            }
        }
        renderView("view/auth/register.php", compact('error'), "Register");
    }

    public function login() {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->login($email, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                header("Location: /");
                exit;
            } else {
                $error = "Invalid email or password.";
            }
        }
        renderView("view/auth/login.php", compact('error'), "Login");
    }

    public function logout() {
        session_destroy();
        header("Location: /login");
        exit;
    }

    public function dashboard() {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $user = $_SESSION['user'];
        renderView("view/auth/dashboard.php", compact('user'), "Dashboard");
    }
}
?>