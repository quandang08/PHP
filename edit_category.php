<!-- File edit_category.php  -->
<?php
require_once 'Category_Database.php';

$category_database = new Category_Database();

// Lấy ID của danh mục từ URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Kiểm tra nếu ID không hợp lệ thì chuyển về trang danh sách
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// Lấy thông tin của danh mục theo ID
$category = $category_database->getCategoryById($id);
if (!$category) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa Danh mục</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Chỉnh sửa Danh mục</h1>
        
        <form action="category_process.php?action=edit" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($category['id']); ?>">
            
            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục:</label>
                <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($category['name']); ?>" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            <a href="index.php" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
