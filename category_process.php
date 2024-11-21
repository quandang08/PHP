<?php
require_once 'Category_Database.php';

// Khởi tạo session để lưu thông báo
session_start();

if (!isset($_GET["action"])) {
    header("Location: category_crud.php");
    exit();
}

$action = $_GET["action"];
$category_database = new Category_Database();

if ($action == "delete") {
    //Xóa danh mục
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        if (filter_var($id, FILTER_VALIDATE_INT)) {
            $category_database->deleteCategory($id);
            $_SESSION['message'] = "Xóa danh mục thành công";
        }
    }
} elseif ($action == "add") {
    //Thêm danh mục
    if (isset($_POST["name"])) {
        $name = $_POST["name"];
        if (!empty($name)) {
            $category_database->addCategory($name);
            $_SESSION['message'] = "Thêm danh mục thành công";
        }
    }
    }elseif($action == "edit"){
        //Chinh sua danh muc
        if(isset($_POST["id"]) && isset($_POST["name"])){
            $id = $_POST["id"];
            $name = $_POST["name"];
        
        if(filter_var($id, FILTER_VALIDATE_INT) && !empty($name)){
            $category_database->editCategory($id, $name);
            $_SESSION['message'] = "Cập nhật danh mục thành công";
        }
    }
}

// Chuyển hướng về trang quản lý danh mục sau khi hoàn tất
header("Location: category_crud.php");
exit();
