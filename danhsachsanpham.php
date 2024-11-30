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

// Include header
include "header.php"
?>

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
                            <a href="product_detail.php?id=<?= $product['id']; ?>" class="btn btn-primary w-100 mb-2">Xem chi tiết</a>
                            <!-- Add to Cart Button -->
                            <form action="add_to_cart.php" method="POST" class="d-inline" id="add-to-cart-form-<?= $product['id']; ?>">
                                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="button" class="btn add-to-cart-btn w-100"
                                    onclick="addToCart(<?= $product['id']; ?>, '<?= htmlspecialchars($product['name']); ?>', <?= $product['price']; ?>)">
                                    <i class="bi bi-cart-plus me-2"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Modal for Cart Drawer -->
    <div id="cart-drawer" class="cart-drawer">
        <div class="cart-drawer-header">
            <div class="cart-drawer-title">Shopping Cart</div>
            <button type="button" class="cart-drawer-close" aria-label="Close Cart">
                ✖
            </button>
        </div>
        <div class="cart-drawer-content">
            <ul class="cart-items">
                <li class="cart-item">
                    <img src="https://via.placeholder.com/50" alt="Product Name" class="cart-item-img">
                    <div class="cart-item-info">
                        <p class="cart-item-name">Product Name</p>
                        <div class="cart-item-quantity">
                            <button class="quantity-btn minus">-</button>
                            <input type="number" class="quantity-input" value="1" min="1">
                            <button class="quantity-btn plus">+</button>
                        </div>
                        <p class="cart-item-price">309,000 VND</p>
                    </div>
                    <button class="cart-item-remove">✖</button>
                </li>
            </ul>
            <div class="cart-summary">
                <p><strong>Subtotal:</strong> <span class="cart-subtotal">309,000 VND</span></p>
            </div>
            <div class="cart-actions">
                <a href="cart.php" class="btn btn-view-cart">View Cart</a>
                <a href="checkout.php" class="btn btn-checkout">Checkout</a>
            </div>
        </div>
    </div>

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
// Include footer
include "footer.php";
?>
<script>
    function addToCart(productId, productName, productPrice) {
        // Dữ liệu gửi đến server
        const data = {
            product_id: productId,
            product_name: productName,
            product_price: productPrice,
            quantity: 1, // Số lượng mặc định là 1
            ajax: 'true' // Đánh dấu đây là yêu cầu AJAX
        };

        // Gửi yêu cầu đến cart.php bằng AJAX
        fetch('cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams(data) // Gửi dữ liệu dưới dạng URL encoded
            })
            .then(response => response.json()) // Chuyển phản hồi thành JSON
            .then(data => {
                if (data.success) {
                    // Hiển thị thông báo thành công với SweetAlert
                    Swal.fire({
                        title: 'Product Added!',
                        text: 'Your product has been successfully added to the cart.',
                        icon: 'success',
                        confirmButtonText: 'Go to Cart'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'cart.php'; // Chuyển hướng đến giỏ hàng
                        }
                    });
                } else {
                    // Hiển thị thông báo lỗi
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.');
            });
    }
</script>
<script>
    // Lấy các phần tử
    const cartDrawer = document.getElementById('cart-drawer');
    const closeBtn = document.querySelector('.cart-drawer-close');
    const openCartDrawerBtn = document.querySelector('#open-cart-drawer'); // Nút mở cart drawer

    // Hàm mở Cart Drawer
    openCartDrawerBtn.addEventListener('click', () => {
        cartDrawer.classList.add('active'); // Thêm class active để hiển thị
    });

    // Hàm đóng Cart Drawer
    closeBtn.addEventListener('click', () => {
        cartDrawer.classList.remove('active'); // Xóa class active để ẩn đi
    });

</script>

</html>