<?php

require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        if (!session_id()) session_start();

        $this->userModel = new User();
    }

    /* ------------------------------------------------------
     * HIỂN THỊ TRANG PROFILE
     * ------------------------------------------------------ */
    public function profile()
    {
        // Nếu chưa login -> về login
        if (empty($_SESSION['user_id'])) {
            header('Location: ?views=auth&action=login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $user   = $this->userModel->getUserById($userId);

        if (!$user) {
            $_SESSION['error_message'] = "Không tìm thấy người dùng.";
            header('Location: ?views=home&action=index');
            exit;
        }

        // Load view
        include_once __DIR__ . '/../views/users/profile.php';
    }


    /* ------------------------------------------------------
     * XỬ LÝ UPDATE PROFILE (POST)
     * ------------------------------------------------------ */
    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?views=users&action=profile');
            exit;
        }

        if (empty($_SESSION['user_id'])) {
            header('Location: ?views=auth&action=login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $user   = $this->userModel->getUserById($userId);

        if (!$user) {
            $_SESSION['error_message'] = "Không tìm thấy người dùng.";
            header('Location: ?views=home&action=index');
            exit;
        }

        /* ---------------------------
     * LẤY DỮ LIỆU FORM
     * --------------------------- */
        $fullname = trim($_POST['fullname'] ?? '');
        $email    = trim($_POST['email'] ?? '');

        $errors = [];
        if (empty($fullname)) $errors[] = "Họ tên không được để trống.";
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email không hợp lệ.";

        /* ---------------------------
     * XỬ LÝ AVATAR (NẾU CÓ)
     * - Validate kiểu file (mime + extension)
     * - Giới hạn kích thước (ví dụ 2 MB)
     * - Tạo tên file an toàn
     * - Upload vào folder assets/uploads/avatars/
     * - Xóa avatar cũ (nếu tồn tại và không phải default)
     * --------------------------- */
        $newAvatarPath = null;

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
            $file = $_FILES['avatar'];
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errors[] = "Lỗi khi upload ảnh (code {$file['error']}).";
            } else {

                $maxSize = 2 * 1024 * 1024; // 2MB
                if ($file['size'] > $maxSize) {
                    $errors[] = "Kích thước ảnh không được vượt quá 2MB.";
                }

                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime  = $finfo->file($file['tmp_name']);
                $allowedMimes = [
                    'image/jpeg' => 'jpg',
                    'image/png'  => 'png',
                    'image/gif'  => 'gif',
                    'image/webp' => 'webp'
                ];

                if (!array_key_exists($mime, $allowedMimes)) {
                    $errors[] = "Định dạng ảnh không hợp lệ. Chỉ chấp nhận jpg, png, gif, webp.";
                } else {

                    // *** ĐÚNG - đường dẫn tuyệt đối
                    $uploadDirAbs = __DIR__ . '/../assets/avatars/';

                    if (!is_dir($uploadDirAbs)) {
                        mkdir($uploadDirAbs, 0775, true);
                    }

                    try {
                        $random = bin2hex(random_bytes(8));
                    } catch (Exception $e) {
                        $random = time() . rand(1000, 9999);
                    }

                    $ext = $allowedMimes[$mime];
                    $filename = "user_{$userId}_{$random}." . $ext;
                    $targetAbs = $uploadDirAbs . $filename;

                    if (!move_uploaded_file($file['tmp_name'], $targetAbs)) {
                        $errors[] = "Không lưu được file ảnh lên server.";
                    } else {

                        // *** ĐÚNG - path tương đối lưu DB
                        $newAvatarPath = 'assets/avatars/' . $filename;

                        // Xóa avatar cũ
                        if (!empty($user['avatar'])) {
                            $oldAbs = __DIR__ . '/../' . ltrim($user['avatar'], '/\\');

                            $defaultPaths = [
                                'assets/img/default-avatar.png',
                                'assets/images/default-avatar.png'
                            ];

                            if (file_exists($oldAbs) && !in_array(str_replace('\\', '/', $user['avatar']), $defaultPaths, true)) {
                                @unlink($oldAbs);
                            }
                        }
                    }
                }
            }
        }
        // Nếu có lỗi, lưu session và redirect về profile
        if (!empty($errors)) {
            $_SESSION['profile_errors'] = $errors;
            header("Location: ?controllers=UserController&action=profile");
            exit;
        }

        /* ---------------------------
         * CẬP NHẬT DATABASE
         * --------------------------- */
        $this->userModel->updateProfile($userId, $fullname, $email, $newAvatarPath);

        // Cập nhật session info để UI hiển thị ngay
        $_SESSION['fullname'] = $fullname;
        $_SESSION['email']    = $email;
        if ($newAvatarPath) $_SESSION['avatar'] = $newAvatarPath;

        header("Location: ?controllers=UserController&action=profile");
        exit;
    }
}
