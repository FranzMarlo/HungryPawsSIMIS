<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/fetch-class.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "No user ID found in session"
    ]);
    exit;
}

$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];
$fetch = new fetchClass();
if ($role == "Manager" || $role == "Inventory Staff") {
    $userStatus = $fetch->checkMainUserStatus($userId);

    echo json_encode([
        "status" => "success",
        "data" => [
            "is_disabled" => (int) $userStatus
        ]
    ]);
} else {

    $userStatus = $fetch->checkUserStatus($userId);

    echo json_encode([
        "status" => "success",
        "data" => [
            "is_disabled" => (int) $userStatus
        ]
    ]);
}
