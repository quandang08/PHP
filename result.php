<?php
require_once 'Product_Database.php';

if (!isset($_GET['keyword'])) {
    header("Location: search.php");
    exit();
}

$keyword = $_GET['keyword'];
$product_database = new Product_Database();
$products = $product_database->searchProducts($keyword);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Kết quả tìm kiếm cho: "<?= htmlspecialchars($keyword); ?>"</h1>
        <?php if (!empty($products)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>ID Danh mục</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['id']); ?></td>
                        <td><?= htmlspecialchars($product['name']); ?></td>
                        <td><?= htmlspecialchars($product['price']); ?></td>
                        <td><?= htmlspecialchars($product['category_id']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Không tìm thấy sản phẩm nào khớp với từ khóa "<?= htmlspecialchars($keyword); ?>"</p>
        <?php endif; ?>
        <a href="search.php" class="btn btn-secondary">Quay lại</a>
    </div>
</body>
</html>
