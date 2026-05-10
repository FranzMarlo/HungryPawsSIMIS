<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/fetch-class.php';

header('Content-Type: application/json');

$fetch = new fetchClass();

$items = $fetch->getLowStockItems();

echo json_encode([
    "status" => "success",
    "data" => $items
]);
