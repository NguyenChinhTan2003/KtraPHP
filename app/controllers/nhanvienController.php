<?php

// app/controllers/NhanVienController.php

require_once 'app/config/Database.php';
require_once 'app/models/NhanVienModel.php';
require_once 'app/models/PhongBanModel.php';

class NhanVienController
{
    private $nhanVienModel;
    private $phongBanModel;
    private $itemsPerPage = 5;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->nhanVienModel = new NhanVienModel($db);
        $this->phongBanModel = new PhongBanModel($db);
    }

    public function index()
    {
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($page - 1) * $this->itemsPerPage;

        $totalEmployees = count($this->nhanVienModel->getAll());
        $totalPages = ceil($totalEmployees / $this->itemsPerPage);

        $employees = $this->getEmployeesWithDepartmentAndPagination($offset, $this->itemsPerPage);

        // Truyền vai trò người dùng vào view để kiểm tra quyền hiển thị nút Sửa/Xóa
        $userRole = $_SESSION['role'] ?? 0; // Lấy role_id từ session, mặc định là 0 nếu không có session
        include 'app/views/nhan_vien_view.php';
    }

    private function getEmployeesWithDepartmentAndPagination($offset, $limit)
    {
        $allEmployees = $this->nhanVienModel->getAll();
        $paginatedEmployees = array_slice($allEmployees, $offset, $limit);

        $employeesWithDeptNames = [];
        foreach ($paginatedEmployees as $employee) {
            $phongBan = $this->phongBanModel->find($employee['Ma_Phong']);
            $employee['Ten_Phong'] = $phongBan ? $phongBan['Ten_Phong'] : 'N/A';
            $employeesWithDeptNames[] = $employee;
        }
        return $employeesWithDeptNames;
    }

    // **Action Thêm nhân viên (chỉ admin)**
    public function add()
    {
        // Kiểm tra vai trò admin
        if (!$this->isAdmin()) {
            $this->redirectToUnauthorized(); // Hàm chuyển hướng nếu không có quyền
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý logic thêm nhân viên (tương tự như create trong model)
            $data = [
                'Ma_NV' => $_POST['Ma_NV'],
                'Ten_NV' => $_POST['Ten_NV'],
                'Phai' => $_POST['Phai'],
                'Noi_Sinh' => $_POST['Noi_Sinh'],
                'Ma_Phong' => $_POST['Ma_Phong'],
                'Luong' => $_POST['Luong']
            ];

            if ($this->nhanVienModel->create($data)) {
                header('Location: index.php?controller=nhanvien&action=index&message=add_success'); // Chuyển hướng về trang danh sách với thông báo
                exit();
            } else {
                $error = "Lỗi khi thêm nhân viên.";
                include 'app/views/add_nhan_vien_view.php'; // Hiển thị lại form thêm với lỗi
            }
        } else {
            // Hiển thị form thêm nhân viên
            include 'app/views/add_nhan_vien_view.php';
        }
    }

    // **Action Sửa nhân viên (chỉ admin)**
    public function edit($ma_nv)
    {
        // Kiểm tra vai trò admin
        if (!$this->isAdmin()) {
            $this->redirectToUnauthorized(); // Hàm chuyển hướng nếu không có quyền
            return;
        }

        $employee = $this->nhanVienModel->find($ma_nv);
        if (!$employee) {
            echo "Không tìm thấy nhân viên."; // Hoặc chuyển hướng trang lỗi
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý logic cập nhật nhân viên (tương tự như update trong model)
            $data = [
                'Ten_NV' => $_POST['Ten_NV'],
                'Phai' => $_POST['Phai'],
                'Noi_Sinh' => $_POST['Noi_Sinh'],
                'Ma_Phong' => $_POST['Ma_Phong'],
                'Luong' => $_POST['Luong']
            ];

            if ($this->nhanVienModel->update($ma_nv, $data)) {
                header('Location: index.php?controller=nhanvien&action=index&message=edit_success'); // Chuyển hướng về trang danh sách với thông báo
                exit();
            } else {
                $error = "Lỗi khi cập nhật nhân viên.";
                include 'app/views/edit_nhan_vien_view.php'; // Hiển thị lại form sửa với lỗi và dữ liệu cũ
            }
        } else {
            // Hiển thị form sửa nhân viên với dữ liệu hiện tại
            include 'app/views/edit_nhan_vien_view.php';
        }
    }

    // **Action Xóa nhân viên (chỉ admin)**
    public function delete($ma_nv)
    {
        // Kiểm tra vai trò admin
        if (!$this->isAdmin()) {
            $this->redirectToUnauthorized(); // Hàm chuyển hướng nếu không có quyền
            return;
        }

        if ($this->nhanVienModel->delete($ma_nv)) {
            header('Location: index.php?controller=nhanvien&action=index&message=delete_success'); // Chuyển hướng về trang danh sách với thông báo
            exit();
        } else {
            echo "Lỗi khi xóa nhân viên."; // Hoặc trang lỗi
        }
    }

    public function userList()
    {
        // **Kiểm tra vai trò người dùng (chỉ cho phép vai trò 'user' truy cập)**
        if (!$this->isUserRole()) { // Gọi hàm isUserRole() để kiểm tra vai trò
            echo "Bạn không có quyền xem danh sách nhân viên với vai trò hiện tại.";
            return; // Dừng thực thi action nếu không phải vai trò 'user'
        }

        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($page - 1) * $this->itemsPerPage;

        $totalEmployees = count($this->nhanVienModel->getAll());
        $totalPages = ceil($totalEmployees / $this->itemsPerPage);

        $employees = $this->getEmployeesWithDepartmentAndPagination($offset, $this->itemsPerPage);

        // **Tái sử dụng view nhan_vien_view.php - hoặc tạo view riêng nếu cần tùy chỉnh**
        // Truyền vai trò người dùng vào view (vẫn cần để ẩn/hiện nút sửa xóa nếu cần trong tương lai)
        $userRole = $_SESSION['role'] ?? 0;
        include 'app/views/nhan_vien_view.php'; // **Sử dụng lại view nhan_vien_view.php**
    }

    private function isUserRole() {
        // Lấy role_id từ session (đã được thiết lập khi đăng nhập)
        $userRoleId = $_SESSION['role'] ?? 0; // Mặc định là 0 nếu không có session

        // Giả sử role_id = 1 là 'user' (KIỂM TRA LẠI BẢNG roles CỦA BẠN)
        return $userRoleId == 1; // **Quan trọng:** Thay 1 bằng role_id của vai trò 'user' trong bảng roles của bạn
    }


    // **Hàm kiểm tra vai trò admin**
    private function isAdmin()
    {
        // Lấy role_id từ session (đã được thiết lập khi đăng nhập)
        $userRoleId = $_SESSION['role'] ?? 0; // Mặc định là 0 nếu không có session

        // Giả sử role_id = 2 là admin (kiểm tra lại bảng roles của bạn)
        return $userRoleId == 2; // Thay 2 bằng role_id của admin trong bảng roles của bạn
    }

    // **Hàm chuyển hướng khi không có quyền**
    private function redirectToUnauthorized()
    {
        echo "Bạn không có quyền thực hiện chức năng này."; // Có thể thay bằng trang báo lỗi đẹp hơn
        // header('HTTP/1.0 403 Forbidden'); // Thêm header báo lỗi (tùy chọn)
        // include 'app/views/unauthorized_view.php'; // Có thể tạo view báo lỗi riêng
        exit();
    }
}
