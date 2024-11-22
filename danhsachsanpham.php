<?php
require_once "Product_Database.php";
require_once "Category_Database.php";

$product_Database = new Product_Database();
$category_Database = new Category_Database();

$categories = $category_Database->getAllCategories();

$keyword = htmlspecialchars(filter_input(INPUT_GET, 'keyword'), ENT_QUOTES, 'UTF-8');
if (!empty($keyword)) {
    $products = $product_Database->searchProductsByKeyword($keyword);
}

$category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);

if ($category_id) {
    $products = $product_Database->getProductsByCategory($category_id);
} elseif ($keyword) {
    $products = $product_Database->searchProductsByKeyword($keyword);
} else {
    $products = $product_Database->getAllProducts();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .product-card img {
        width: 100%; 
        height: 200px; 
        object-fit: cover; 
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="http://localhost:81/Tuan7_BE1_dangquan/Tuan7_dangquan/BaiTap_BE1_dangquan/danhsachsanpham.php">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">Danh mục</a>
                        <ul class="dropdown-menu">
                            <?php foreach ($categories as $category): ?>
                                <li><a class="dropdown-item" href="?category_id=<?= $category['id']; ?>"><?= htmlspecialchars($category['name']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex" method="GET">
                    <input class="form-control me-2" type="search" name="keyword" placeholder="Tìm kiếm" value="<?= htmlspecialchars($keyword ?? ''); ?>">
                    <button class="btn btn-outline-success" type="submit">Tìm</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type']; ?>"><?= $_SESSION['message']; ?></div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <?php if ($category_id): ?>
            <h2>Sản phẩm thuộc danh mục: <?= htmlspecialchars($category_Database->getCategoryById($category_id)['name']); ?></h2>
        <?php elseif ($keyword): ?>
            <h2>Kết quả tìm kiếm cho: "<?= htmlspecialchars($keyword); ?>"</h2>
        <?php else: ?>
            <h2>Tất cả sản phẩm</h2>
        <?php endif; ?>

        <?php if (empty($products)): ?>
            <p class="text-center text-muted">Không có sản phẩm nào để hiển thị.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card product-card">
                            <img src="uploads/<?= htmlspecialchars($product['image'] ?? 'no_image.png'); ?>" class="card-img-top" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text"><?= number_format((float)str_replace('.', '', $product['price']), 0, ',', '.'); ?> VND</p>
                                <a href="product_detail.php?id=<?= $product['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</html>

