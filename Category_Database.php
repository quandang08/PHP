<?php
require_once 'Database.php';

class Category_Database
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // Lấy tất cả danh mục từ cơ sở dữ liệu
    public function getAllCategories()
    {
        $result = $this->db->query("SELECT * FROM Category");
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Lấy danh mục theo ID
    public function getCategoryById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Category WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    // Xóa danh mục theo ID
    public function deleteCategory($id)
    {
        $stmt = $this->db->prepare("DELETE FROM Category WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute() && $stmt->affected_rows > 0;
    }

    // Thêm một danh mục mới
    public function addCategory($name)
    {
        $stmt = $this->db->prepare("INSERT INTO Category (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    // Chỉnh sửa danh mục hiện có theo ID
    public function editCategory($id, $name)
    {
        $stmt = $this->db->prepare("UPDATE Category SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);
        return $stmt->execute();
    }
    
}

// **************** Note ******************
// Phương thức đã đóng comment - Lấy tất cả danh mục
    /*
    public function getAllCategories()
    {
        $result = $this->db->query("SELECT * FROM Category");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    */

    // Phương thức đã đóng comment - Lấy danh mục theo ID
    /*
    public function getCategoryById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Category WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    */

    // Phương thức đã đóng comment - Xóa danh mục
    /*
    public function deleteCategory($id)
    {
        $stmt = $this->db->prepare("DELETE FROM Category WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute() && $stmt->affected_rows > 0;
    }
    */