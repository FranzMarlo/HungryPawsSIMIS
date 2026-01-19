<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/fetch-class.php';

header('Content-Type: application/json');

if (!isset($_SESSION['branch_id'])) {
    echo json_encode(["status" => "error", "message" => "No branch ID found in session"]);
    exit;
}

$branchId = $_SESSION['branch_id'];

$fetch = new fetchClass();

$items = $fetch->getLowStockItems($branchId);

echo json_encode([
    "status" => "success",
    "data" => $items
]);
