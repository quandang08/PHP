<?php
require_once 'Database.php';

class Product_Database
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // Lấy tất cả sản phẩm
    public function getAllProducts()
    {
        $result = $this->db->query("SELECT * FROM Products");
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Lấy sản phẩm theo ID
    public function getProductById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        $stmt = $this->db->prepare("DELETE FROM Products WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute() && $stmt->affected_rows > 0;
    }

    // Thêm sản phẩm mới
    public function addProduct($name, $desc, $price, $image, $category_id)
    {
        $stmt = $this->db->prepare("INSERT INTO Products (name, `desc`, price, image, category_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsi", $name, $desc, $price, $image, $category_id);
        return $stmt->execute();
    }


    // Cập nhật sản phẩm
    public function editProduct($id, $name, $price, $category_id)
    {
        $stmt = $this->db->prepare("UPDATE Products SET name = ?, price = ?, category_id = ? WHERE id = ?");
        $stmt->bind_param("sdii", $name, $price, $category_id, $id);
        return $stmt->execute();
    }

    // Tìm kiếm sản phẩm theo tên
    public function searchProducts($keyword)
    {
        $stmt = $this->db->prepare("SELECT * FROM Products WHERE name LIKE ?");
        $search_keyword = "%" . $keyword . "%";
        $stmt->bind_param("s", $search_keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy sản phẩm theo danh mục
    public function getProductsByCategory($category_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Products WHERE category_id = ?");
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Tìm kiếm sản phẩm theo từ khóa
    public function searchProductsByKeyword($keyword)
    {
        $stmt = $this->db->prepare("SELECT * FROM Products WHERE name LIKE ?");
        $search_keyword = "%" . $keyword . "%";
        $stmt->bind_param("s", $search_keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
