<?php
require_once 'config.php';

class Database
{
    private static $connection;

    // Phương thức này trả về kết nối cơ sở dữ liệu duy nhất
    public static function getConnection()
    {
        if (!self::$connection) {
            self::$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            if (self::$connection->connect_error) {
                die("Error Connection: " . self::$connection->connect_error);
            }
            self::$connection->set_charset(DB_CHARSET);
        }
        return self::$connection;
    }

    // Tạo hàm hủy để tránh việc tạo mới đối tượng mà không bị đóng
    private function __construct() {}
    private function __clone() {}
}
