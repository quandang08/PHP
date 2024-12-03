<!-- File edit_product.php  -->
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product ? "Chỉnh sửa" : "Thêm" ?> sản phẩm</title>
    <!-- Thêm liên kết đến Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center"><?= $product ? "Chỉnh sửa" : "Thêm" ?> sản phẩm</h1>

        <form action="product_process.php?action=<?= $product ? "edit" : "add" ?>" method="POST" enctype="multipart/form-data">
            <?php if ($product): ?>
                <input type="hidden" name="id" value="<?= $product['id']; ?>">
            <?php endif; ?>

            <!-- Tên sản phẩm -->
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm:</label>
                <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($product['name'] ?? ''); ?>" required>
            </div>

            <!-- Mô tả sản phẩm -->
            <div class="mb-3">
                <label for="desc" class="form-label">Mô tả sản phẩm:</label>
                <textarea class="form-control" name="desc" id="desc" rows="4"><?= htmlspecialchars($product['desc'] ?? ''); ?></textarea>
            </div>

            <!-- Giá sản phẩm -->
            <div class="mb-3">
                <label for="price" class="form-label">Giá:</label>
                <input type="number" class="form-control" step="0.01" name="price" id="price" value="<?= htmlspecialchars($product['price'] ?? ''); ?>" required>
            </div>

            <!-- Hình ảnh sản phẩm -->
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh:</label>
                <?php if ($product && $product['image']): ?>
                    <div class="mb-2">
                        <img src="uploads/<?= htmlspecialchars($product['image']); ?>" alt="Product Image" width="100">
                    </div>
                <?php endif; ?>
                <input type="file" class="form-control" name="image" id="image" accept="image/*">
            </div>

            <!-- Dropdown chọn danh mục -->
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục:</label>
                <select class="form-select" name="category_id" id="category_id" required>
                    <option value="" disabled <?= $product ? "" : "selected"; ?>>Chọn danh mục</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['id']); ?>"
                            <?= isset($product['category_id']) && $product['category_id'] == $category['id'] ? "selected" : ""; ?>>
                            <?= htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Nút submit -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary"><?= $product ? "Cập nhật" : "Thêm mới" ?></button>
            </div>
        </form>
    </div>

    <!-- Thêm Bootstrap JS và Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
