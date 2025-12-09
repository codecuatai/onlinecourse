<?php
// C:\xampp\htdocs\onlinecourse\controllers\AdminController.php
require_once './models/User.php';

class AdminController
{
    private $userModel;

    public function __construct()
    {
        // Khởi tạo User Model để tương tác với CSDL
        $this->userModel = new User();
    }

    public function viewUser()
    {
        $users = $this->userModel->getAllUsers();
        $_SESSION['list_user'] = $users;
        // Gọi view và truyền dữ liệu
        header("Location: ?views=users&action=manage");
    }

    // Xử lý POST để tạo người dùng
    public function createUser()
    {
        // Kiểm tra xem form đã submit chưa
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'fullname' => $_POST['fullname'] ?? '',
                'role' => $_POST['role'] ?? 0
            ];

            // Gọi model để tạo user
            $result = $this->userModel->createUser($data);

            if ($result) {
                // Thành công, redirect về danh sách người dùng
                header('Location: ?controllers=AdminController&action=viewUser');
                exit;
            } else {
                // Thất bại
                $error = "Không thể tạo người dùng mới.";
                header('Location: ?views=users&action=create');
            }
        }
    }
    public function deleteUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = (int) $_POST['id'];
            $this->userModel->deleteUser($id);
        }
        header('Location: ?controllers=AdminController&action=viewUser');
        exit;
    }


    public function editUserForm()
    {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header('Location: ?controllers=AdminController&action=viewUser');
            exit;
        }

        $id = (int) $_GET['id'];
        $user = $this->userModel->getUserById($id); // bạn nên thêm getUserById trong model
        $_SESSION['user'] = $user;
        header('Location: ?views=users&action=edit');
    }

    // Xử lý POST để cập nhật người dùng
    public function updateUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = (int) $_POST['id'];
            $data = [
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'fullname' => $_POST['fullname'] ?? '',
                'role' => $_POST['role'] ?? 0,
                'password' => $_POST['password'] ?? '' // nếu bỏ trống, password không thay đổi
            ];

            $result = $this->userModel->updateUser($id, $data);

            // Chuyển về danh sách user sau khi cập nhật
            header('Location: ?controllers=AdminController&action=viewUser');
            exit;
        } else {
            // Nếu truy cập trực tiếp, chuyển về danh sách
            header('Location: ?controllers=AdminController&action=viewUser');
            exit;
        }
    }
}
