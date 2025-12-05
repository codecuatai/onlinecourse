<?php require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
?>

<main class="container py-5">

    <div class="row g-5">

        <!-- LEFT CONTENT -->
        <div class="col-lg-8">

            <!-- Title -->
            <h1 class="fw-bold display-5 mb-3">
                Master Python từ con số 0
            </h1>

            <div class="d-flex align-items-center text-muted mb-4 small">
                <span class="me-3"><i class="bi bi-star-fill text-warning"></i> 4.9 (532 đánh giá)</span>
                <span class="me-3"><i class="bi bi-people"></i> 1.243 học viên</span>
                <span><i class="bi bi-play-circle"></i> 47 bài học</span>
            </div>

            <!-- Featured Image -->
            <div class="ratio ratio-16x9 rounded shadow-sm overflow-hidden mb-4">
                <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?w=1200"
                    class="w-100 h-100 object-fit-cover"
                    alt="course">
            </div>

            <!-- Description -->
            <h4 class="fw-bold mb-3">Mô tả khóa học</h4>
            <p class="text-secondary fs-5">
                Khóa học giúp bạn xây dựng nền tảng Python vững chắc, áp dụng vào xây dựng ứng dụng web,
                xử lý dữ liệu và tự động hóa. Phù hợp cho người mới và người muốn đi làm trong lĩnh vực IT.
            </p>

            <!-- What you will learn -->
            <h4 class="fw-bold mt-5 mb-3">Bạn sẽ học được</h4>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 rounded-4 bg-light">
                        <i class="bi bi-check2-circle text-success fs-4 me-2"></i>
                        Hiểu rõ cú pháp, hàm, class trong Python
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 rounded-4 bg-light">
                        <i class="bi bi-check2-circle text-success fs-4 me-2"></i>
                        Làm việc với file, dữ liệu, API
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 rounded-4 bg-light">
                        <i class="bi bi-check2-circle text-success fs-4 me-2"></i>
                        Xây dựng web với Flask/Django
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 rounded-4 bg-light">
                        <i class="bi bi-check2-circle text-success fs-4 me-2"></i>
                        Thực chiến qua dự án thực tế
                    </div>
                </div>
            </div>

        </div>


        <!-- RIGHT SIDEBAR -->
        <div class="col-lg-4">

            <div class="border-0 shadow rounded-4 overflow-hidden position-sticky" style="top: 100px;">

                <!-- Thumbnail -->
                <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?w=600"
                    class="w-100 object-fit-cover"
                    style="height: 200px;" alt="course">

                <div class="p-4">

                    <!-- Price -->
                    <p class="fw-bold display-6 mb-0">499.000₫</p>
                    <p class="text-muted small mb-4">Truy cập trọn đời</p>

                    <!-- CTA -->
                    <button class="btn btn-dark w-100 py-3 fw-bold mb-3 rounded-4">
                        <i class="bi bi-bag-check me-2"></i>
                        Thanh toán ngay
                    </button>


                    <hr class="my-4">

                    <!-- Instructor -->
                    <div class="d-flex align-items-center">
                        <img src="https://i.pravatar.cc/60?img=5"
                            class="rounded-circle me-3"
                            width="60" height="60">

                        <div>
                            <h6 class="fw-bold mb-0">Trần Minh Khoa</h6>
                            <small class="text-muted">Giảng viên chuyên nghiệp</small>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</main>


<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
