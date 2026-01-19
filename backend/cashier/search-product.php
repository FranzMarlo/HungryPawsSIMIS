<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/fetch-class.php';

header('Content-Type: application/json');
$branchId = $_SESSION['branch_id'];
$barcode = $_POST['barcode'] ?? '';

$fetch = new fetchClass();

$product = $fetch->checkProductBarcode($barcode, $branchId);

if ($product['isValid']) {
    echo json_encode([
        "status" => "success",
        "data" => $product['data']
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Product not found."
    ]);
}
