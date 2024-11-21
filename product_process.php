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
}elseif ($action == "add" && isset($_POST["name"], $_POST["desc"], $_POST["price"], $_POST["image"], $_POST["category_id"])) {
    $name = $_POST["name"];
    $desc = $_POST["desc"];
    $price = $_POST["price"];
    $image = $_POST["image"];
    $category_id = $_POST["category_id"];
    // Thêm sản phẩm mới
    $product_database->addProduct($name, $desc, $price, $image, $category_id);

}elseif ($action == "edit" && isset($_POST["id"], $_POST["name"], $_POST["price"], $_POST["category_id"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $category_id = $_POST["category_id"];
    $product_database->editProduct($id, $name, $price, $category_id);
}

header("Location: product_crud.php");
exit();
?>
