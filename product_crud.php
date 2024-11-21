<?php
require_once 'Category_Database.php';

$category_database = new Category_Database();
$categories = $category_database->getAllCategories(); // Lấy danh sách danh mục

require_once 'Product_Database.php';

$product_database = new Product_Database();
$products = $product_database->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Danh sách Sản phẩm</h1>
        <a href="edit_product.php?action=add" class="btn btn-primary mb-3">Thêm sản phẩm mới</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Danh mục</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['id']); ?></td>
                    <td><?= htmlspecialchars($product['name']); ?></td>
                    <td><?= htmlspecialchars($product['price']); ?></td>
                    <td><?= htmlspecialchars($product['category_id']); ?></td>
                    <td>
                        <a href="edit_product.php?action=edit&id=<?= $product['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="product_process.php?action=delete&id=<?= $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
