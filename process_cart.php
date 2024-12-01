<?php
session_start();

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

        // Dữ liệu sản phẩm giả định (nên lấy từ cơ sở dữ liệu thực tế)
        $product_data = [
            'name' => "Product $product_id",
            'price' => 100, // Giá giả định
            'image' => 'https://via.placeholder.com/100' // Hình ảnh giả định
        ];

        // Thêm sản phẩm vào giỏ hàng
        add_to_cart($product_id, $product_data, $quantity);

        // Trả về phản hồi dưới dạng JSON cho AJAX
        echo json_encode([
            'success' => true,
            'message' => 'Product added to cart successfully!'
        ]);
        exit();
    }
    // Xử lý hành động xóa sản phẩm
    elseif (isset($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);

        // Xóa sản phẩm khỏi giỏ hàng
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($product_id) {
            return $item['id'] !== $product_id;
        });

        // Đảm bảo giỏ hàng không có các phần tử null sau khi xóa
        $_SESSION['cart'] = array_values($_SESSION['cart']);

        // Trả về phản hồi dưới dạng JSON cho AJAX
        echo json_encode([
            'success' => true,
            'message' => 'Product removed successfully!'
        ]);
        exit();
    }
} else {
    // Nếu yêu cầu không phải từ AJAX, xử lý theo cách thông thường
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
            $product_id = intval($_POST['product_id']);
            $quantity = intval($_POST['quantity']);

            // Dữ liệu sản phẩm giả định (nên lấy từ cơ sở dữ liệu thực tế)
            $product_data = [
                'name' => "Product $product_id",
                'price' => 100, // Giá giả định
                'image' => 'https://via.placeholder.com/100' // Hình ảnh giả định
            ];

            // Thêm sản phẩm vào giỏ hàng
            add_to_cart($product_id, $product_data, $quantity);

            // Trả về thông báo thành công (nếu cần cho trang thông thường)
            echo "Product added to cart successfully!";
            header('Location: cart.php');
            exit();
        } elseif ($_POST['action'] === 'remove' && isset($_POST['product_id'])) {
            // Xóa sản phẩm khỏi giỏ hàng
            $product_id = intval($_POST['product_id']);

            // Xóa sản phẩm khỏi giỏ hàng
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($product_id) {
                return $item['id'] !== $product_id;
            });

            // Đảm bảo giỏ hàng không có các phần tử null sau khi xóa
            $_SESSION['cart'] = array_values($_SESSION['cart']);

            // Trả về thông báo cho trang thông thường
            echo "Product removed successfully!";
            header('Location: cart.php');
            exit();
        }
    }
}

/**
 * Hàm thêm sản phẩm vào giỏ hàng
 */
function add_to_cart($product_id, $product_data, $quantity) {
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
