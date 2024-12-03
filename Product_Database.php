<!-- File Product_Database.php  -->
<?php
require_once 'Database.php';

class Product_Database
{
    private $db;

    // Khởi tạo kết nối cơ sở dữ liệu
    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // Lấy tất cả sản phẩm (gọi phương thức getProducts)
    public function getAllProducts()
    {
        return $this->getProducts();
    }

    // Lấy thông tin sản phẩm theo ID
    public function getProductById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Products WHERE id = ?");
        $stmt->bind_param("i", $id); // Liên kết tham số kiểu int
        $stmt->execute(); // Thực thi truy vấn
        $result = $stmt->get_result(); // Lấy kết quả
        return $result->fetch_assoc(); // Trả về kết quả dưới dạng mảng liên kết
    }

    // Xóa sản phẩm theo ID
    public function deleteProduct($id)
    {
        $stmt = $this->db->prepare("DELETE FROM Products WHERE id = ?");
        $stmt->bind_param("i", $id); // Liên kết tham số kiểu int
        return $stmt->execute(); // Thực thi câu lệnh xóa
    }

    // Thêm sản phẩm mới vào cơ sở dữ liệu
    public function addProduct($name, $desc, $price, $category_id, $image = null)
    {
        $stmt = $this->db->prepare("INSERT INTO Products (name, `desc`, price, category_id, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdis", $name, $desc, $price, $category_id, $image); // Liên kết tham số
        return $stmt->execute(); // Thực thi câu lệnh thêm sản phẩm
    }

    // Cập nhật thông tin sản phẩm
    public function updateProduct($id, $name, $desc, $price, $category_id, $image = null)
    {
        // Tạo câu lệnh SQL cập nhật sản phẩm
        $query = "UPDATE Products SET name = ?, `desc` = ?, price = ?, category_id = ?";
        if ($image) {
            $query .= ", image = ?";
        }
        $query .= " WHERE id = ?"; // Điều kiện WHERE để chọn sản phẩm theo ID

        $stmt = $this->db->prepare($query); // Chuẩn bị câu lệnh
        if ($image) {
            // Nếu có ảnh, liên kết các tham số với câu lệnh
            $stmt->bind_param("ssdssi", $name, $desc, $price, $category_id, $image, $id);
        } else {
            // Nếu không có ảnh, không liên kết tham số ảnh
            $stmt->bind_param("ssdsi", $name, $desc, $price, $category_id, $id);
        }
        return $stmt->execute(); // Thực thi câu lệnh cập nhật
    }

    // Lấy danh sách sản phẩm với các bộ lọc như category_id, keyword, phân trang (offset, limit)
    public function getProducts($category_id = null, $keyword = null, $offset = 0, $limit = 10)
    {
        $query = "SELECT * FROM Products WHERE 1"; // Truy vấn cơ bản lấy tất cả sản phẩm
        $params = []; // Mảng chứa tham số truy vấn
        $types = ""; // Kiểu dữ liệu của các tham số

        if ($category_id) {
            $query .= " AND category_id = ?"; // Thêm điều kiện lọc theo category_id
            $params[] = $category_id; // Thêm giá trị tham số vào mảng
            $types .= "i"; // Kiểu dữ liệu của category_id là int
        }

        if ($keyword) {
            $query .= " AND name LIKE ?"; // Thêm điều kiện lọc theo từ khóa tìm kiếm
            $params[] = "%" . $keyword . "%"; // Thêm từ khóa vào mảng tham số
            $types .= "s"; // Kiểu dữ liệu của keyword là string
        }

        $query .= " ORDER BY id ASC LIMIT ?, ?"; // Thêm phân trang với LIMIT
        $params[] = $offset; // Thêm giá trị offset
        $params[] = $limit; // Thêm giá trị limit
        $types .= "ii"; // Kiểu dữ liệu của offset và limit là int

        $stmt = $this->db->prepare($query); // Chuẩn bị câu lệnh SQL
        $stmt->bind_param($types, ...$params); // Liên kết tham số với câu lệnh
        $stmt->execute(); // Thực thi câu lệnh
        $result = $stmt->get_result(); // Lấy kết quả
        return $result->fetch_all(MYSQLI_ASSOC); // Trả về danh sách sản phẩm dưới dạng mảng liên kết
    }

    // Lấy tổng số lượng sản phẩm với các bộ lọc như category_id và keyword
    public function getTotalProductsCount($category_id = null, $keyword = null)
    {
        $query = "SELECT COUNT(*) AS total FROM Products WHERE 1"; // Truy vấn đếm tổng số sản phẩm
        $params = []; // Mảng chứa tham số truy vấn
        $types = ""; // Kiểu dữ liệu của các tham số

        if ($category_id) {
            $query .= " AND category_id = ?"; // Thêm điều kiện lọc theo category_id
            $params[] = $category_id; // Thêm giá trị tham số vào mảng
            $types .= "i"; // Kiểu dữ liệu của category_id là int
        }

        if ($keyword) {
            $query .= " AND name LIKE ?"; // Thêm điều kiện lọc theo từ khóa tìm kiếm
            $params[] = "%" . $keyword . "%"; // Thêm từ khóa vào mảng tham số
            $types .= "s"; // Kiểu dữ liệu của keyword là string
        }

        $stmt = $this->db->prepare($query); // Chuẩn bị câu lệnh SQL

        // Kiểm tra nếu $types không rỗng
        if (!empty($types)) {
            $stmt->bind_param($types, ...$params); // Liên kết tham số với câu lệnh
        }

        $stmt->execute(); // Thực thi câu lệnh
        $result = $stmt->get_result(); // Lấy kết quả
        $row = $result->fetch_assoc(); // Lấy kết quả duy nhất
        return $row['total']; // Trả về tổng số sản phẩm
    }
}
