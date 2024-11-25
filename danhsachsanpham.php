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
                    <li class="nav-item"><a class="nav-link active" href="danhsachsanpham.php">Home</a></li>
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
        <?php if ($category_id): ?>
            <?php $category = $category_Database->getCategoryById($category_id); ?>
            <?php if ($category): ?>
                <h2>Sản phẩm thuộc danh mục: <?= htmlspecialchars($category['name']); ?></h2>
            <?php else: ?>
                <h2>Danh mục không tồn tại.</h2>
            <?php endif; ?>
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
                            <img src="<?= file_exists("uploads/" . $product['image']) && $product['image'] ? "uploads/" . htmlspecialchars($product['image']) : "uploads/no_image.png"; ?>" class="card-img-top" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text"><?= number_format((float)$product['price'], 0, ',', '.'); ?> VND</p>
                                <a href="product_detail.php?id=<?= $product['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Nút phân trang -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page - 1; ?>&keyword=<?= urlencode($keyword ?? ''); ?>&category_id=<?= $category_id; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
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
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</html>
