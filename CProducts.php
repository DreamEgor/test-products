<?php
require 'config.php';

class CProducts {
    private $db;

    public function __construct() {
        // Подключение к базе данных
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Проверка соединения
        if ($this->db->connect_error) {
            die("Ошибка подключения: " . $this->db->connect_error);
        }
    }

    public function getProducts($limit = 10) {
        $sql = "SELECT * FROM Products WHERE IS_HIDDEN = FALSE ORDER BY DATE_CREATE DESC LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $products;
    }

    public function hideProduct($productId) {
        $sql = "UPDATE Products SET IS_HIDDEN = TRUE WHERE ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->close();
    }

    public function updateQuantity($productId, $newQuantity) {
        $sql = "UPDATE Products SET PRODUCT_QUANTITY = ? WHERE ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $newQuantity, $productId);
        $stmt->execute();
        $stmt->close();
    }
}
?>
