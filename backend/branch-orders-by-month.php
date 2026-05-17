<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/fetch-class.php';

header('Content-Type: application/json');

$fetch = new fetchClass();

$branchId = $_SESSION['branch_id'];

$fetch = new fetchClass();

$data = $fetch->getLocalBranchOrdersByMonth($branchId);

echo json_encode([
    "status" => "success",
    "data" => $data
]);


