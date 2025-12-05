<?php require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
?>

<div class="container-fluid mt-4">

    <!-- Header + nút quay lại -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Quản lý bài học - Python cho Người Mới</h4>

        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <!-- Nút tạo bài học mới -->
    <div class="mb-3">
        <a class="btn btn-success" href="./create.php">
            <i class="fas fa-plus"></i> Tạo bài học mới
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Tên bài học</th>
                            <th>Video</th>
                            <th>Tài liệu</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- Bài học 1 -->
                        <tr class="text-center">
                            <th>1</th>
                            <td class="text-start">Giới thiệu Python</td>
                            <td>
                                <a href="video1.mp4" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-video"></i> Xem video
                                </a>
                            </td>
                            <td>
                                <a href="doc1.pdf" target="_blank" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-file-pdf"></i> Tài liệu
                                </a>
                            </td>
                            <td>01/12/2025</td>
                            <td>
                                <div class="d-flex justify-content-center flex-wrap gap-1">
                                    <a href="./edit.php" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Bài học 2 -->
                        <tr class="text-center">
                            <th>2</th>
                            <td class="text-start">Biến và kiểu dữ liệu</td>
                            <td>
                                <a href="video2.mp4" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-video"></i> Xem video
                                </a>
                            </td>
                            <td>
                                <a href="doc2.pdf" target="_blank" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-file-pdf"></i> Tài liệu
                                </a>
                            </td>
                            <td>02/12/2025</td>
                            <td>
                                <div class="d-flex justify-content-center flex-wrap gap-1">
                                    <a href="./edit.php" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Nếu chưa có dữ liệu -->
                        <!-- 
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                Chưa có bài học nào.
                            </td>
                        </tr>
                        -->

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
