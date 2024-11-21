<?php
require_once 'Product_Database.php';
require_once 'Category_Database.php'; // Thêm để lấy danh mục

$product_database = new Product_Database();
$category_database = new Category_Database(); // Khởi tạo đối tượng danh mục
$categories = $category_database->getAllCategories(); // Lấy danh sách danh mục
$product = null;

if (isset($_GET["action"]) && $_GET["action"] == "edit" && isset($_GET["id"])) {
    $id = $_GET["id"];
    $product = $product_database->getProductById($id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $product ? "Chỉnh sửa" : "Thêm" ?> sản phẩm</title>
</head>
<body>
    <h1><?= $product ? "Chỉnh sửa" : "Thêm" ?> sản phẩm</h1>
    <form action="product_process.php?action=<?= $product ? "edit" : "add" ?>" method="POST">
        <?php if ($product): ?>
        <input type="hidden" name="id" value="<?= $product['id']; ?>">
        <?php endif; ?>
        
        <!-- Tên sản phẩm -->
        <label for="name">Tên sản phẩm:</label>
        <input type="text" name="name" id="name" value="<?= $product['name'] ?? ''; ?>" required>
        
        <!-- Giá sản phẩm -->
        <label for="price">Giá:</label>
        <input type="number" step="0.01" name="price" id="price" value="<?= $product['price'] ?? ''; ?>" required>
        
        <!-- Dropdown chọn danh mục -->
        <label for="category_id">Danh mục:</label>
        <select name="category_id" id="category_id" required>
            <option value="" disabled <?= $product ? "" : "selected"; ?>>Chọn danh mục</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['id']); ?>"
                    <?= isset($product['category_id']) && $product['category_id'] == $category['id'] ? "selected" : ""; ?>>
                    <?= htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Nút submit -->
        <button type="submit"><?= $product ? "Cập nhật" : "Thêm mới" ?></button>
    </form>
</body>
</html>
