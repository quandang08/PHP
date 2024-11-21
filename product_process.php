<?php
require_once 'Product_Database.php';

$product_database = new Product_Database();

if (!isset($_GET["action"])) {
    header("Location: product_crud.php");
    exit();
}

$action = $_GET["action"];

if ($action == "delete" && isset($_GET["id"])) {
    $id = $_GET["id"];
    if (filter_var($id, FILTER_VALIDATE_INT)) {
        $product_database->deleteProduct($id);
    }
} elseif ($action == "add" && isset($_POST["name"], $_POST["desc"], $_POST["price"], $_POST["category_id"])) {
    $name = $_POST["name"];
    $desc = $_POST["desc"]; // Lấy mô tả
    $price = $_POST["price"];
    $category_id = $_POST["category_id"];
    
    // Xử lý upload hình ảnh
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = "uploads/"; // Thư mục lưu hình ảnh
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Đặt tên hình ảnh mới để tránh trùng lặp
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $upload_dir . $image_name;

        // Di chuyển file đến thư mục uploads
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $image_name; // Lưu tên file vào cơ sở dữ liệu
        }
    }

    // Thêm sản phẩm với mô tả và hình ảnh
    $product_database->addProduct($name, $desc, $price, $category_id, $image);

} elseif ($action == "edit" && isset($_POST["id"], $_POST["name"], $_POST["price"], $_POST["category_id"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $category_id = $_POST["category_id"];
    $product_database->editProduct($id, $name, $price, $category_id);
}

header("Location: product_crud.php");
exit();
