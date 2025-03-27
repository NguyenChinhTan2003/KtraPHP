<?php

// app/controllers/AuthController.php

require_once 'app/config/Database.php';
require_once 'app/models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->userModel = new UserModel($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->findByUsername($username);

            // **THAY ĐỔI XÁC THỰC MẬT KHẨU - KHÔNG MÃ HÓA**
            if ($user && $password === $user['password']) { // So sánh mật khẩu KHÔNG MÃ HÓA
                // Đăng nhập thành công
                session_start();
                $_SESSION['user_id'] = $user['Id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role_id'];

                header('Location: index.php?controller=nhanvien&action=index');
                exit();
            } else {
                // Đăng nhập thất bại
                $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
                include 'app/views/login_view.php';
            }
        } else {
            include 'app/views/login_view.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?controller=auth&action=login');
        exit();
    }
}
?>