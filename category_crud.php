<!-- File category_crud.php  -->
<?php
require_once 'Category_Database.php';

session_start();

$category_database = new Category_Database();
$categories = $category_database->getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Danh mục</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Danh sách Danh mục</h1>

        <?php
        // Kiểm tra nếu có thông báo trong session
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);  // Xóa thông báo sau khi đã hiển thị
        }
        ?>

        <h2 class="mb-3">Thêm Danh mục mới</h2>
        <form action="category_process.php?action=add" method="POST" class="mb-4">
            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['id']); ?></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>
                            <a href="edit_category.php?id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="category_process.php?action=delete&id=<?php echo $item['id']; ?>" 
                            class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>