<?php
require 'app/config/database.php'; // Kết nối CSDL

$query = "SELECT * FROM categories";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý danh mục</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Quản lý danh mục</h2>
        <a href="category_add.php" class="btn btn-primary mb-3">Thêm danh mục</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td>
                            <a href="category_edit.php?id=<?= $row['id'] ?>" class="btn btn-warning">Sửa</a>
                            <a href="category_delete.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
