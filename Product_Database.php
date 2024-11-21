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
    public function addProduct($name, $desc, $price, $category_id, $image = null)
    {
        $stmt = $this->db->prepare("INSERT INTO Products (name, `desc`, price, category_id, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdis", $name, $desc, $price, $category_id, $image);
        return $stmt->execute();
    }

    // Cập nhật sản phẩm
    public function updateProduct($id, $name, $desc, $price, $category_id, $image = null)
    {
        // Tạo truy vấn SQL
        $query = "UPDATE Products SET name = ?, `desc` = ?, price = ?, category_id = ?";
        if ($image) {
            $query .= ", image = ?"; // Thêm cập nhật hình ảnh nếu có
        }
        $query .= " WHERE id = ?";

        $stmt = $this->db->prepare($query);

        // Xử lý tham số dựa trên việc có hình ảnh hay không
        if ($image) {
            $stmt->bind_param("ssdssi", $name, $desc, $price, $category_id, $image, $id);
        } else {
            $stmt->bind_param("ssdsi", $name, $desc, $price, $category_id, $id);
        }

        // Thực thi câu lệnh và trả về kết quả
        if ($stmt->execute()) {
            return true;
        } else {
            // Ghi log nếu có lỗi
            error_log("Error executing update query: " . $stmt->error);
            return false;
        }
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
