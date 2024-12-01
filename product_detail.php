<?php
require_once "Product_Database.php";
require_once "Category_Database.php";

// Nhận `id` sản phẩm từ URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = intval($_GET['id']);
} else {
    die("Không tìm thấy sản phẩm.");
}

// Bước 2: Tạo đối tượng từ Product_Database và Category_Database
$product_Database = new Product_Database();
$category_Database = new Category_Database();

// Bước 3: Truy vấn thông tin sản phẩm từ cơ sở dữ liệu
$product = $product_Database->getProductById($product_id);
if (!$product) {
    die("Sản phẩm không tồn tại.");
}
// Bước 4: Truy vấn thông tin danh mục của sản phẩm
$category = $category_Database->getCategoryById($product['category_id']);
if (!$category) {
    $category_name = "Danh mục không xác định"; // Nếu không tìm thấy danh mục
} else {
    $category_name = $category['name']; // Lấy tên danh mục
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/product_detail.css">
    <title>Product Detail</title>
</head>

<!-- header  -->
<?php include "header.php" ?>
<!-- end header  -->

<body>
    <div class="product-detail-container">
        <!-- Phần trái: Hình ảnh sản phẩm -->
        <div class="product-main-image">
            <!-- Hình ảnh của sản phẩm đã nhấp vào xem chi tiết -->
            <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" width="600" height="600">
        </div>

        <!-- Phần phải: Thông tin sản phẩm -->
        <div class="product-info">
            <!-- Đường dẫn của sản phẩm đã nhấp vào xem -->
            <nav class="breadcrumb-navigation" aria-label="Breadcrumb">
                <a href="index.php">Home</a>&nbsp;/&nbsp;
                <a href="category.php?id=<?php echo htmlspecialchars($product['category_id']); ?>">
                    <?php echo htmlspecialchars($category_name); ?>
                </a>&nbsp;/&nbsp;
                <?php echo htmlspecialchars($product['name']); ?>
            </nav>

            <!-- Tên sản phẩm từ dữ liệu thực tế -->
            <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
            <!-- Giá gốc sản phẩm -->
            <p class="product-price">
                <span class="original-price">
                    <bdi><span class="currency-symbol">$</span><?php echo number_format($product['price'], 2); ?></bdi>
                </span>
            </p>

            <!-- Nơi hiển thị mô tả từ sản phẩm thực tế "desc" -->
            <div class="product-short-description">
                <p><?php echo nl2br(htmlspecialchars($product['desc'])); ?></p>
            </div>

            <!-- Điều chỉnh vị trí phần điều khiển số lượng và nút Add to cart -->
            <div class="add-to-cart-wrapper">
                <form class="add-to-cart-form" action="cart.php" method="post">
                    <!-- Input hidden để gửi thông tin sản phẩm -->
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                    <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($product['price']); ?>">

                    <!-- Điều chỉnh số lượng -->
                    <div class="quantity-control">
                        <span class="quantity-button" id="decrease-quantity">-</span>
                        <input type="number" id="quantity-input" class="input-quantity" name="quantity" value="1" min="1" aria-label="Product quantity">
                        <span class="quantity-button" id="increase-quantity">+</span>
                    </div>
                    <!-- Nút thêm vào giỏ hàng -->
                    <button type="submit" name="add-to-cart" value="<?php echo htmlspecialchars($product['id']); ?>" class="add-to-cart-button">Add to cart</button>
                </form>
            </div>

            <div class="product-meta">
                <span class="category-label">Category:
                    <a href="category.php?id=<?php echo htmlspecialchars($product['category_id']); ?>" rel="tag">
                        <?php echo htmlspecialchars($category_name); ?>
                    </a>
                </span>
            </div>
        </div>
    </div>

</body>
<!-- footer  -->
<?php include "footer.php" ?>
<!-- end footer  -->

</html>
<script>
    document.getElementById('decrease-quantity').addEventListener('click', function() {
        let quantityInput = document.getElementById('quantity-input');
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    document.getElementById('increase-quantity').addEventListener('click', function() {
        let quantityInput = document.getElementById('quantity-input');
        let currentValue = parseInt(quantityInput.value);
        quantityInput.value = currentValue + 1;
    });
</script>

<script>
    // JavaScript để tăng giảm số lượng
    const decreaseButton = document.getElementById('decrease-quantity');
    const increaseButton = document.getElementById('increase-quantity');
    const quantityInput = document.getElementById('quantity-input');

    decreaseButton.addEventListener('click', () => {
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    increaseButton.addEventListener('click', () => {
        let currentValue = parseInt(quantityInput.value);
        quantityInput.value = currentValue + 1;
    });
</script>