<h2>Tạo Khóa Học Mới</h2>

<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<form action="/course/create" method="POST" enctype="multipart/form-data">
    <label for="title">Tiêu đề khóa học:</label>
    <input type="text" id="title" name="title" required>

    <label for="description">Mô tả:</label>
    <textarea id="description" name="description" rows="5" required></textarea>

    <label for="course_image">Ảnh bìa:</label>
    <input type="file" id="course_image" name="course_image">

    <button type="submit">Tạo Khóa Học</button>
</form>