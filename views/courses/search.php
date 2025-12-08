<h2>Kết quả tìm kiếm</h2>

<a href="index.php?controller=course&action=index">← Quay lại</a>

<hr>

<?php if ($courses->rowCount() > 0): ?>
    <?php while ($row = $courses->fetch(PDO::FETCH_ASSOC)) : ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <h3><?php echo $row['title']; ?></h3>
            <p>Giá: <?php echo number_format($row['price']); ?> VNĐ</p>

            <a href="index.php?controller=course&action=detail&id=<?php echo $row['id']; ?>">
                Xem chi tiết
            </a>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>Không tìm thấy khóa học nào!</p>
<?php endif; ?>
