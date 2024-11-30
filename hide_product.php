<?php
require 'CProducts.php';

$products = new CProducts();

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $products->hideProduct($id);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
