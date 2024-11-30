<?php
require 'CProducts.php';

$products = new CProducts();

if (isset($_POST['id']) && isset($_POST['quantity'])) {
    $id = intval($_POST['id']);
    $quantity = intval($_POST['quantity']);
    $products->updateQuantity($id, $quantity);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
