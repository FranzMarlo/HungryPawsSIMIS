<?php
include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/fetch-class.php';
$fetch = new fetchClass();

$branchId = $_POST['branchId'] ?? '';
$startDate = $_POST['startDate'] ?? '';
$endDate = $_POST['endDate'] ?? '';

if (empty($startDate)) {
    echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Set The Start Date For Report"]);
    exit;
}

if (empty($endDate)) {
    echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Set The End Date For Report"]);
    exit;
}

if (empty($branchId)) {
    $startDate = DateTime::createFromFormat('m/d/Y', $startDate)->format('Y-m-d');
    $endDate = DateTime::createFromFormat('m/d/Y', $endDate)->format('Y-m-d');

    if ($startDate >= $endDate) {
        echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Start Date Cannot Be Later Than End Date"]);
        exit;
    }

    $topProducts = $fetch->getGlobalMostTransferredProducts($startDate, $endDate);
    $transferCostValue = $fetch->getGlobalTransferCostValue($startDate, $endDate);
    $transferStatus = $fetch->getGlobalTransferStatus($startDate, $endDate);
    $transferTrend = $fetch->getGlobalTransferTrend($startDate, $endDate);

    if ($topProducts["status"] !== "success") {
        echo json_encode($topProducts);
        exit;
    }

    if ($transferCostValue["status"] !== "success") {
        echo json_encode($transferCostValue);
        exit;
    }

    if ($transferStatus["status"] !== "success") {
        echo json_encode($transferStatus);
        exit;
    }

    if ($transferTrend["status"] !== "success") {
        echo json_encode($transferTrend);
        exit;
    }

    echo json_encode([
        "status" => "success",
        "title" => "Success",
        "message" => "Sales Report Loaded Successfully",
        "top_product" => $topProducts["data"],
        "transfer_cost" => $transferCostValue["data"],
        "transfer_trend" => $transferTrend["data"],
        "transfer_status" => $transferStatus["data"]
    ]);
} else {
    $startDate = DateTime::createFromFormat('m/d/Y', $startDate)->format('Y-m-d');
    $endDate = DateTime::createFromFormat('m/d/Y', $endDate)->format('Y-m-d');

    if ($startDate >= $endDate) {
        echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Start Date Cannot Be Later Than End Date"]);
        exit;
    }

    $topProducts = $fetch->getMostTransferredProducts($branchId, $startDate, $endDate);
    $transferCostValue = $fetch->getTransferCostValue($branchId, $startDate, $endDate);
    $transferStatus = $fetch->getTransferStatus($branchId, $startDate, $endDate);
    $transferTrend = $fetch->getTransferTrend($branchId, $startDate, $endDate);

    if ($topProducts["status"] !== "success") {
        echo json_encode($topProducts);
        exit;
    }

    if ($transferCostValue["status"] !== "success") {
        echo json_encode($transferCostValue);
        exit;
    }

    if ($transferStatus["status"] !== "success") {
        echo json_encode($transferStatus);
        exit;
    }

    if ($transferTrend["status"] !== "success") {
        echo json_encode($transferTrend);
        exit;
    }


    echo json_encode([
        "status" => "success",
        "title" => "Success",
        "message" => "Sales Report Loaded Successfully",
        "top_product" => $topProducts["data"],
        "transfer_cost" => $transferCostValue["data"],
        "transfer_trend" => $transferTrend["data"],
        "transfer_status" => $transferStatus["data"]
    ]);
}

exit;
