<!-- File process_cart.php  -->
<?php
session_start();
require_once "Product_Database.php";

$product_Database = new Product_Database();

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Kiểm tra yêu cầu từ AJAX
if (isset($_POST['ajax']) && $_POST['ajax'] === 'true') {
    // Xử lý hành động thêm sản phẩm
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);

        // Lấy dữ liệu sản phẩm từ cơ sở dữ liệu
        $product_data = $product_Database->getProductById($product_id);

        // Kiểm tra xem sản phẩm có tồn tại hay không
        if ($product_data) {
            //Đường dẫn tương đối
            $product_data['image'] = 'uploads/' . $product_data['image'];

            // Thêm sản phẩm vào giỏ hàng
            add_to_cart($product_id, [
                'name' => $product_data['name'],
                'price' => $product_data['price'],
                'image' => $product_data['image']
            ], $quantity);

            // Trả về phản hồi dưới dạng JSON cho AJAX
            echo json_encode([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart' => $_SESSION['cart'] // Tùy chọn: gửi lại dữ liệu giỏ hàng
            ]);
        } else {
            // Sản phẩm không tồn tại
            echo json_encode([
                'success' => false,
                'message' => 'Product not found!'
            ]);
        }
        exit();
    }
    // Xử lý hành động xóa sản phẩm
    elseif (isset($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);

        // Xóa sản phẩm khỏi giỏ hàng
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($product_id) {
            return $item['id'] !== $product_id;
        });

        // Đảm bảo giỏ hàng không có các phần tử null sau khi xóa
        $_SESSION['cart'] = array_values($_SESSION['cart']);

        // Trả về phản hồi dưới dạng JSON cho AJAX
        echo json_encode([
            'success' => true,
            'message' => 'Product removed successfully!',
            'cart' => $_SESSION['cart']
        ]);
        exit();
    }
}

/**
 * Hàm thêm sản phẩm vào giỏ hàng
 */
function add_to_cart($product_id, $product_data, $quantity)
{
    $found = false;

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] === $product_id) {
            $item['quantity'] += $quantity; // Cộng thêm số lượng nếu sản phẩm đã có
            $found = true;
            break;
        }
    }

    if (!$found) {
        // Nếu sản phẩm chưa có, thêm sản phẩm mới
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'name' => $product_data['name'],
            'price' => $product_data['price'],
            'quantity' => $quantity,
            'image' => $product_data['image']
        ];
    }
}
