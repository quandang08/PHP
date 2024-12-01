<!-- File update_cart.php  -->

<?php
session_start();

// Lấy dữ liệu từ yêu cầu AJAX
$data = json_decode(file_get_contents('php://input'), true);
$productId = $data['id'];
$newQuantity = $data['quantity'];

// Kiểm tra nếu sản phẩm tồn tại trong giỏ hàng
if (isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId]['quantity'] = $newQuantity; // Cập nhật số lượng mới
    echo json_encode(['status' => 'success', 'message' => 'Cart updated']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Product not found in cart']);
}
?>
