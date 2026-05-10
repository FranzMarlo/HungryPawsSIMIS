<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/fetch-class.php';

header('Content-Type: application/json');

$branch_id = $_SESSION['branch_id'] ?? null;

if (!$branch_id) {
    echo json_encode(["status" => "error", "message" => "No branch ID found in session, please relogin."]);
    exit;
}

$fetch = new fetchClass();

$items = $fetch->getBranchStockRequestAlert($branch_id);

echo json_encode([
    "status" => "success",
    "data" => $items
]);