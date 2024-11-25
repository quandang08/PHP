<?php
require_once "Product_Database.php";
require_once "Category_Database.php";

$product_Database = new Product_Database();
$category_Database = new Category_Database();

$categories = $category_Database->getAllCategories();

// Lọc đầu vào từ GET
$keyword = filter_input(INPUT_GET, 'keyword', FILTER_SANITIZE_STRING);
$keyword = $keyword ? htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') : null;

$category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
$category_id = ($category_id && $category_id > 0) ? $category_id : null; // Kiểm tra category_id hợp lệ

// Thiết lập phân trang
$items_per_page = 6;
$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
$page = ($page && $page > 0) ? $page : 1;
$offset = ($page - 1) * $items_per_page;

// Gọi phương thức để lấy danh sách sản phẩm và tổng số sản phẩm
$productsData = $product_Database->getProducts($category_id, $keyword, $offset, $items_per_page);
$total_products = $product_Database->getTotalProductsCount($category_id, $keyword);

// Kiểm tra xem $productsData có phải là mảng không và có dữ liệu không
if (is_array($productsData) && count($productsData) > 0) {
    $products = $productsData; // Lấy danh sách sản phẩm
} else {
    // Xử lý khi không có dữ liệu hoặc có lỗi
    $products = []; // Gán mảng rỗng nếu không có dữ liệu
}

// Tính toán số trang
$total_pages = ceil($total_products / $items_per_page);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/style.css">
</head>
<style>
    .product-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    section.above-header {
        background-color: #0769DA !important;
        color: #fff;
    }

    .below-header {
        background-color: #0572ED !important;
    }

    ul.nav .nav-item .nav-link {
        color: white;
        /* Màu chữ trắng */
    }
</style>

<body>
    <div class="container-fluid">
        <!-- Header Wrapper -->
        <header id="main-header">
            <!-- Above Header -->
            <section class="above-header bg-light py-2">
                <div class="container d-flex justify-content-between align-items-center">
                    <!-- Left Section -->
                    <div class="above-header-left">
                        <p class="mb-0">24/7 Customer service <strong>1-800-234-5678</strong></p>
                    </div>
                    <!-- Right Section -->
                    <div class="above-header-right">
                        <nav>
                            <ul class="nav">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Shipping & Return</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Track Order</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </section>

            <!-- Main Header -->
            <div class="ast-main-header-wrap main-header-bar-wrap bg-primary text-white">
                <div class="container py-3">
                    <div class="row align-items-center">
                        <!-- Logo Section -->
                        <div class="col-md-4">
                            <a href="#" class="d-inline-block">
                                <img src="https://websitedemos.net/electronic-store-04/wp-content/uploads/sites/1055/2022/03/electronic-store-logo.svg"
                                    alt="Electronic Store" width="150" height="40">
                            </a>
                        </div>
                        <!-- Search Section -->
                        <div class="col-md-4 text-center">
                            <form role="search" method="get" class="d-flex">
                                <input type="search" class="form-control me-2" placeholder="Search product..." name="s">
                                <button type="submit" class="btn btn-outline-light">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>
                        </div>
                        <!-- Cart & Login Section -->
                        <div class="col-md-4 text-end">
                            <div class="d-inline-flex align-items-center">
                                <!-- Cart -->
                                <a href="/cart" class="text-white me-3 d-flex align-items-center">
                                    <i class="bi bi-cart4 fs-5"></i>
                                    <span class="ms-2">Cart</span>
                                </a>
                                <!-- Login -->
                                <a href="/login" class="text-white d-flex align-items-center">
                                    <i class="bi bi-person fs-5"></i>
                                    <span class="ms-2">Log In</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Below Header -->
            <nav class="below-header bg-primary py-2">
                <div class="container d-flex justify-content-center">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">All products</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">Home appliances</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">Audio & Video</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">Refrigerator</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">New arrivals</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">Today's Deal</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">Gift Cards</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>


        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Logo</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" href="danhsachsanpham.php">Home</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">Shop</a>
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
            <?php if ($category_id): ?>
                <?php $category = $category_Database->getCategoryById($category_id); ?>
                <?php if ($category): ?>
                    <h2 class="mb-4">Sản phẩm thuộc danh mục: <span class="text-primary"><?= htmlspecialchars($category['name']); ?></span></h2>
                <?php else: ?>
                    <h2 class="mb-4 text-danger">Danh mục không tồn tại.</h2>
                <?php endif; ?>
            <?php elseif ($keyword): ?>
                <h2 class="mb-4">Kết quả tìm kiếm cho: <span class="text-primary">"<?= htmlspecialchars($keyword); ?>"</span></h2>
            <?php else: ?>
                <h2 class="mb-4">Tất cả sản phẩm</h2>
            <?php endif; ?>

            <?php if (empty($products)): ?>
                <p class="text-center text-muted">Không có sản phẩm nào để hiển thị.</p>
            <?php else: ?>
                <div class="row product-row">
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4">
                            <div class="card product-card shadow-sm">
                                <img src="<?= file_exists("uploads/" . $product['image']) && $product['image'] ? "uploads/" . htmlspecialchars($product['image']) : "uploads/no_image.png"; ?>" class="card-img-top" alt="Product Image">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                                    <p class="card-text text-success fw-bold"><?= number_format((float)$product['price'], 0, ',', '.'); ?> VND</p>
                                    <a href="product_detail.php?id=<?= $product['id']; ?>" class="btn btn-primary w-100">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Nút phân trang -->
            <nav>
                <ul class="pagination justify-content-center mt-4">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page - 1; ?>&keyword=<?= urlencode($keyword ?? ''); ?>&category_id=<?= $category_id; ?>" aria-label="Previous">
                                &laquo;
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?= $i; ?>&keyword=<?= urlencode($keyword ?? ''); ?>&category_id=<?= $category_id; ?>"><?= $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page + 1; ?>&keyword=<?= urlencode($keyword ?? ''); ?>&category_id=<?= $category_id; ?>" aria-label="Next">
                                &raquo;
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <!-- Footer Top Section -->
            <div class="row">
                <!-- Footer Logo Section -->
                <div class="col-md-3 mb-4">
                    <div class="footer-logo">
                        <img src="https://websitedemos.net/electronic-store-04/wp-content/uploads/sites/1055/2022/03/electronic-store-logo-mono.svg" alt="Logo" class="img-fluid">
                    </div>
                </div>

                <!-- Footer Links Section 1 -->
                <div class="col-md-3 mb-4">
                    <h5>Shop</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Hot deals</a></li>
                        <li><a href="#" class="text-white">Categories</a></li>
                        <li><a href="#" class="text-white">Brands</a></li>
                        <li><a href="#" class="text-white">Rebates</a></li>
                        <li><a href="#" class="text-white">Weekly deals</a></li>
                    </ul>
                </div>

                <!-- Footer Links Section 2 -->
                <div class="col-md-3 mb-4">
                    <h5>Need Help?</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Contact</a></li>
                        <li><a href="#" class="text-white">Order tracking</a></li>
                        <li><a href="#" class="text-white">FAQs</a></li>
                        <li><a href="#" class="text-white">Return policy</a></li>
                        <li><a href="#" class="text-white">Privacy policy</a></li>
                    </ul>
                </div>

                <!-- Footer Contact Section -->
                <div class="col-md-3 mb-4">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">123 Fifth Avenue, New York, NY 10160</a></li>
                        <li><a href="#" class="text-white">contact@info.com</a></li>
                        <li><a href="#" class="text-white">929-242-6868</a></li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom Section -->
            <div class="row">
                <!-- Left Section (Copyright) -->
                <div class="col-md-6 text-start mt-4">
                    <p>© 2024 Electronic Store. Powered by Electronic Store</p>
                </div>
                <!-- Right Section (Payment Icons) -->
                <div class="col-md-6 text-end mt-4">
                    <div class="footer-payment-icons">
                        <img src="https://websitedemos.net/electronic-store/wp-content/uploads/sites/1055/2022/03/electronic-store-footer-payment-gateway-icon.png" alt="Payment Icons" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</html>