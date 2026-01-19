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

$startDate = DateTime::createFromFormat('m/d/Y', $startDate)->format('Y-m-d');
$endDate = DateTime::createFromFormat('m/d/Y', $endDate)->format('Y-m-d');

if ($startDate >= $endDate) {
    echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Start Date Cannot Be Later Than End Date"]);
    exit;
}

$salesPerformance = $fetch->getSalesPerformanceReport($branchId, $startDate, $endDate);
$topProducts = $fetch->getTopProducts($branchId, $startDate, $endDate);
$paymentMethods = $fetch->getPaymentMethodBreakdown($branchId, $startDate, $endDate);
$categories = $fetch->getCategoryBreakdown($branchId, $startDate, $endDate);

if ($salesPerformance["status"] !== "success") {
    echo json_encode($salesPerformance);
    exit;
}

if ($topProducts["status"] !== "success") {
    echo json_encode($topProducts);
    exit;
}

if ($paymentMethods["status"] !== "success") {
    echo json_encode($paymentMethods);
    exit;
}

if ($categories["status"] !== "success") {
    echo json_encode($categories);
    exit;
}


echo json_encode([
    "status" => "success",
    "title" => "Success",
    "message" => "Sales Report Loaded Successfully",
    "sales_performance" => $salesPerformance["data"],
    "top_product" => $topProducts["data"],
    "payment_method" => $paymentMethods["data"],
    "category" => $categories["data"]
]);
exit;
