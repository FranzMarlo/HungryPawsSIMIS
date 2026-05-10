<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/fetch-class.php';

header('Content-Type: application/json');

$fetch = new fetchClass();

$branch_id = $_GET['branch_id'];

$products = $fetch->getStaffProductsByBranch($branch_id);

echo json_encode($products);