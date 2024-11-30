<?php
session_start();

// Kiểm tra yêu cầu AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax']) && $_POST['ajax'] === 'true') {
    // Lấy thông tin từ POST
    $product_id = $_POST['product_id'] ?? null;
    $product_name = $_POST['product_name'] ?? null;
    $product_price = $_POST['product_price'] ?? null;
    $product_quantity = $_POST['quantity'] ?? 1;


    // Kiểm tra các dữ liệu có hợp lệ không
    if ($product_id && $product_name && $product_price) {
        // Tạo thông tin sản phẩm
        $product = [
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $product_quantity
            
        ];

        // Kiểm tra giỏ hàng
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
        $exists = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product_id) {
                $item['quantity'] += $product_quantity; // Cộng dồn số lượng
                $exists = true;
                break;
            }
        }

        // Nếu sản phẩm chưa tồn tại, thêm mới
        if (!$exists) {
            $_SESSION['cart'][] = $product;
        }

        // Trả về kết quả dưới dạng JSON cho AJAX
        echo json_encode(['success' => true, 'message' => 'Product added to cart successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid product data']);
    }

    exit(); // Kết thúc script
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    /* Reset cơ bản */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
        color: #333;
    }

    /* Trang giỏ hàng */
    .cart-page {
        max-width: 1200px;
        margin: 50px auto;
        padding: 20px;
    }

    h1 {
        text-align: left;
        margin-bottom: 20px;
    }

    /* Bố cục giỏ hàng */
    .cart-wrapper {
        display: flex;
        gap: 20px;
    }

    /* Bảng sản phẩm */
    .cart-table-container {
        flex: 2;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cart-table th,
    .cart-table td {
        text-align: center;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .cart-table th {
        background: #f4f4f4;
    }

    .product-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .product-img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
    }

    /* Điều khiển số lượng */
    .quantity-controls {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
    }

    .quantity {
        width: 50px;
        text-align: center;
    }

    /* Tổng tiền */
    .cart-summary {
        flex: 1;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        text-align: left;
    }

    .cart-summary h3 {
        margin-bottom: 10px;
    }

    .cart-summary p {
        margin: 10px 0;
        font-size: 16px;
    }

    .checkout-btn {
        background: #0071c2;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        display: block;
        width: 100%;
        margin-top: 20px;
        text-align: center;
    }

    .checkout-btn:hover {
        background: #005da2;
    }

    .undo-notification {
        display: none;
        /* Ẩn thông báo mặc định */
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        margin-bottom: 15px;
        font-size: 16px;
        text-align: center;
    }

    .undo-link {
        color: #007bff;
        cursor: pointer;
        font-weight: bold;
    }

    .cart-wrapper {
        position: relative;
        padding-top: 10px;
        /* Khoảng cách cho thông báo */
    }
</style>

<body>
    <!-- header  -->
    <?php include "header.php" ?>
    <!-- end header  -->
    <div class="cart-page">
        <h1>Cart</h1>

        <!-- Thông báo Undo (hiển thị trên danh sách sản phẩm) -->
        <div id="undo-notification" class="undo-notification">
            <span id="removed-product-text"></span>
            <span id="undo-link" class="undo-link">Undo?</span>
        </div>

        <div class="cart-wrapper">
            <!-- Bảng sản phẩm -->
            <div class="cart-table-container">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>X</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($_SESSION['cart'])): ?>
                            <?php foreach ($_SESSION['cart'] as $item): ?>
                                <tr>
                                    <td><button class="remove-btn">X</button></td>
                                    <td>
                                        <div class="product-info">
                                            <img src="<?= $item['image'] ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="product-img">
                                            <span><?= htmlspecialchars($item['name']) ?></span>
                                        </div>
                                    </td>
                                    <td class="price" data-price="<?= $item['price'] ?>">
                                        <?= number_format($item['price'], 2) ?> đ
                                    </td>
                                    <td>
                                        <div class="quantity-controls">
                                            <input type="number" value="<?= $item['quantity'] ?>" class="quantity" min="1">
                                        </div>
                                    </td>
                                    <td class="subtotal">
                                        <?= number_format($item['price'] * $item['quantity'], 2) ?>$
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">Your cart is empty!</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Thông tin tổng tiền -->
            <div class="cart-summary">
                <h3>Cart totals</h3>
                <?php
                // Tính tổng phụ và tổng cộng từ session giỏ hàng
                $subtotal = 0;
                if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                    foreach ($_SESSION['cart'] as $item) {
                        $subtotal += $item['price'] * $item['quantity'];
                    }
                }
                ?>
                <p>Subtotal: <span id="subtotal"><?php echo number_format($subtotal, 0, ',', '.') . "₫"; ?></span></p>
                <p>Total: <span id="total"><?php echo number_format($subtotal, 0, ',', '.') . "₫"; ?></span></p>
                <button class="checkout-btn">Proceed to checkout</button>
            </div>

        </div>
    </div>
    <!-- footer  -->
    <?php include "footer.php" ?>
    <!-- end footer  -->
    <script src="/public/script.js"></script>
</body>

</html>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const cartTable = document.querySelector(".cart-table");
        const subtotalEl = document.getElementById("subtotal");
        const totalEl = document.getElementById("total");
        const undoNotification = document.getElementById("undo-notification");
        const undoLink = document.getElementById("undo-link");
        let removedProduct = null; // Để lưu trữ thông tin sản phẩm đã xóa

        // Hàm định dạng số tiền theo VND
        function formatCurrencyVND(amount) {
            return new Intl.NumberFormat("vi-VN", {
                style: "currency",
                currency: "VND",
            }).format(amount);
        }

        function updateTotal() {
            let subtotal = 0;
            document.querySelectorAll(".cart-table tbody tr").forEach((row) => {
                const price = parseInt(row.querySelector(".price").dataset.price);
                const quantity = parseInt(row.querySelector(".quantity").value);
                const subtotalRow = price * quantity;

                // Cập nhật subtotal cho từng sản phẩm
                row.querySelector(".subtotal").textContent = formatCurrencyVND(subtotalRow);
                subtotal += subtotalRow;
            });

            // Cập nhật tổng phụ và tổng cộng
            subtotalEl.textContent = formatCurrencyVND(subtotal);
            totalEl.textContent = formatCurrencyVND(subtotal);
        }

        // Hàm xử lý sự kiện nhấn vào nút "X" để xóa sản phẩm
        cartTable.addEventListener("click", (e) => {
            if (e.target.classList.contains("increase") || e.target.classList.contains("decrease")) {
                const quantityInput = e.target.closest(".quantity-controls").querySelector(".quantity");
                let currentValue = parseInt(quantityInput.value);
                currentValue += e.target.classList.contains("increase") ? 1 : -1;
                if (currentValue < 1) currentValue = 1;
                quantityInput.value = currentValue;
                updateTotal();
            }

            if (e.target.classList.contains("remove-btn")) {
                const row = e.target.closest("tr");
                const productName = row.querySelector(".product-info span").textContent;
                const productPrice = row.querySelector(".price").textContent;
                const productSubtotal = row.querySelector(".subtotal").textContent;

                // Lưu thông tin sản phẩm đã xóa
                removedProduct = {
                    row,
                    productName,
                    productPrice,
                    productSubtotal
                };

                // Xóa sản phẩm khỏi giỏ hàng
                row.remove();

                // Hiển thị thông báo "Product removed"
                document.getElementById('removed-product-text').textContent = `${productName} removed. `;
                undoNotification.style.display = 'block';

                // Cập nhật tổng tiền sau khi xóa sản phẩm
                updateTotal();
            }
        });

        // Xử lý undo (hoàn tác xóa sản phẩm)
        undoLink.addEventListener("click", () => {
            if (removedProduct) {
                // Thêm lại sản phẩm đã xóa vào giỏ hàng
                const cartTableBody = document.querySelector('.cart-table tbody');
                const newRow = removedProduct.row.cloneNode(true);
                cartTableBody.appendChild(newRow);

                // Ẩn thông báo và cập nhật lại tổng tiền
                undoNotification.style.display = 'none';
                updateTotal();

                // Đặt lại thông tin sản phẩm đã xóa
                removedProduct = null;
            }
        });

        // Cập nhật lại tổng tiền khi thay đổi số lượng
        cartTable.addEventListener("input", (e) => {
            if (e.target.classList.contains("quantity")) {
                updateTotal();
            }
        });

        // Cập nhật tổng tiền khi tải trang lần đầu
        updateTotal();
    });
</script>