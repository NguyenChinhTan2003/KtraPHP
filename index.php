<?php

spl_autoload_register(function ($class_name) {
    $dirs = ['app/config', 'app/controllers', 'app/models'];
    foreach ($dirs as $dir) {
        $file = "$dir/$class_name.php";
        if (file_exists($file)) {
            require_once $file;
        }
    }
});

session_start(); // Bắt đầu session ở đầu file index.php để có thể sử dụng session ở mọi nơi

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'nhanvien'; // Mặc định là 'nhanvien' controller
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Xử lý controller 'auth' riêng
if ($controller === 'auth') {
    $controllerName = ucfirst($controller) . 'Controller';
} else {
    // Kiểm tra đăng nhập cho các controller khác (ngoại trừ 'auth')
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?controller=auth&action=login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        exit();
    }
    $controllerName = ucfirst($controller) . 'Controller';
}


if (class_exists($controllerName)) {
    $controllerInstance = new $controllerName();
    if (method_exists($controllerInstance, $action)) {
        if ($id) {
            $controllerInstance->$action($id);
        } else {
            $controllerInstance->$action();
        }
    } else {
        echo "Action not found!";
    }
} else {
    echo "Controller not found!";
}
?>