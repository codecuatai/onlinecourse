<h2>Chỉnh Sửa Khóa Học: <?php echo htmlspecialchars($course['title']); ?></h2>

<form action="/course/edit/<?php echo $course['id']; ?>" method="POST" enctype="multipart/form-data">
    <label for="title">Tiêu đề khóa học:</label>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($course['title']); ?>" required>
    
    <label for="description">Mô tả:</label>
    <textarea id="description" name="description" rows="5" required><?php echo htmlspecialchars($course['description']); ?></textarea>

    <p>Ảnh hiện tại: <img src="/assets/uploads/courses/<?php echo $course['image']; ?>" width="100"></p>
    <input type="hidden" name="current_image" value="<?php echo $course['image']; ?>">

    <label for="course_image">Thay đổi ảnh bìa:</label>
    <input type="file" id="course_image" name="course_image">
    
    <button type="submit">Cập Nhật Khóa Học</button>
</form>