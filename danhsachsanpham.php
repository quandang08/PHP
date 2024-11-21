<?php
require_once "Product_Database.php";
require_once "Category_Database.php";

// Khởi tạo các đối tượng cần thiết
$product_Database = new Product_Database();
$category_Database = new Category_Database();

// Lấy danh sách danh mục
$categories = $category_Database->getAllCategories();

// Kiểm tra có tìm kiếm từ khóa không
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// Kiểm tra có chọn danh mục không
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

// Truy vấn sản phẩm
if ($category_id) {
    // Nếu có category_id, lấy sản phẩm của danh mục đó
    $products = $product_Database->getProductsByCategory($category_id);
} elseif ($keyword) {
    // Nếu có từ khóa, tìm sản phẩm theo tên
    $products = $product_Database->searchProductsByKeyword($keyword);
} else {
    // Nếu không có gì, lấy tất cả sản phẩm
    $products = $product_Database->getAllProducts();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Shop
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                            foreach ($categories as $category) {
                                echo '<li><a class="dropdown-item" href="trang2.php?category_id=' . $category['id'] . '">' . $category['name'] . '</a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex" action="result.php" method="GET">
                    <div class="mb-3">
                        <label for="keyword" class="form-label">Từ khóa:</label>
                        <input class="form-control me-2" id="keyword" name="keyword" type="search" placeholder="Nhập tên sản phẩm cần tìm" aria-label="Search" required>
                        <button class="btn btn-outline-success" type="submit">Tìm kiếm</button>
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <?php
    if ($category_id) {
        // Hiển thị danh mục nếu có chọn
        $categorie = $category_Database->getCategoryById($category_id);
        echo '<h2>Sản phẩm của ' . htmlspecialchars($categorie['name']) . '</h2>';
    } elseif ($keyword) {
        // Hiển thị nếu có từ khóa tìm kiếm
        echo '<h2>Kết quả tìm kiếm cho: ' . htmlspecialchars($keyword) . '</h2>';
    } else {
        // Nếu không có gì, hiển thị tất cả sản phẩm
        echo '<h2>Tất cả các sản phẩm</h2>';
    }
    ?>

    <div class="container mt-4">
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="path_to_image.jpg" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($product['price']); ?> VND</p>
                            <a href="product_detail.php?id=<?= $product['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>
