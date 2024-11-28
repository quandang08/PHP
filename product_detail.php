<?php
// Import lớp Database
require_once 'Database.php';

// Lấy ID sản phẩm từ URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Lấy kết nối cơ sở dữ liệu từ phương thức getConnection
    $connection = Database::getConnection();

    // Truy vấn chi tiết sản phẩm
    $stmt = $connection->prepare("SELECT * FROM products WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Kiểm tra nếu sản phẩm tồn tại
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
        } else {
            echo "Sản phẩm không tồn tại.";
            exit;
        }
    } else {
        echo "Lỗi trong truy vấn cơ sở dữ liệu.";
        exit;
    }
} else {
    echo "ID sản phẩm không hợp lệ.";
    exit;
}

// Hiển thị thông tin sản phẩm (nếu cần)
echo "<h1>Chi tiết sản phẩm</h1>";
echo "Tên sản phẩm: " . htmlspecialchars($product['name']) . "<br>";
echo "Mô tả: " . htmlspecialchars($product['desc']) . "<br>";
echo "Giá: " . number_format($product['price'], 0, ',', '.') . " VND<br>";
echo "Ảnh sản phẩm: <img src='" . htmlspecialchars($product['image']) . "' alt='Hình sản phẩm'><br>";
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']); ?> - Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="styles.css"> <!-- Thêm CSS tùy chỉnh nếu cần -->
</head>

<body>
    <div class="container">
        <h1><?= htmlspecialchars($product['name']); ?></h1>
        <div class="product-detail">
            <div class="row">
                <!-- Hình ảnh sản phẩm -->
                <div class="col-md-6">
                    <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="img-fluid">
                </div>

                <!-- Thông tin sản phẩm -->
                <div class="col-md-6">
                    <p><strong>Giá:</strong> <?= number_format($product['price'], 0, ',', '.'); ?> VND</p>
                    <p><strong>Mô tả:</strong> <?= nl2br(htmlspecialchars($product['desc'])); ?></p>
                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                        <label for="quantity">Số lượng:</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1">
                        <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
                    </form>
                </div>
            </div>
        </div>
        <a href="danhsachsanpham.php" class="btn btn-secondary mt-3">Quay lại</a>
    </div>
</body>

</html>