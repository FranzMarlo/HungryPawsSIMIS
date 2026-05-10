<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/fetch-class.php';

header('Content-Type: application/json');

if (!isset($_SESSION['branch_id'])) {
    $userId = $_SESSION['user_id'];

    $fetch = new fetchClass();

    $data = $fetch->getOrdersByMonth($branchId, $userId);

    echo json_encode([
        "status" => "success",
        "data" => $data
    ]);
} else {
    $branchId = $_SESSION['branch_id'];
    $userId = $_SESSION['user_id'];

    $fetch = new fetchClass();

    $data = $fetch->getOrdersByMonth($branchId, $userId);

    echo json_encode([
        "status" => "success",
        "data" => $data
    ]);
}


