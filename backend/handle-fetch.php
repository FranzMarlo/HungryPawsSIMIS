<?php
header('Content-Type: application/json');
require_once 'fetch-class.php';

$fetchClass = new fetchClass();
$submitType = $_POST['submitType'] ?? '';

switch ($submitType) {

    case 'getMonthlyRevenue':
        $branchId = $_POST['branchId'] ?? '';
        $response = $fetchClass->getMonthlyRevenue($branchId);
        break;

    case 'getCashierProducts':
        $branchId = $_POST['branchId'] ?? null;
        if ($branchId) {
            $response = $fetchClass->getCashierProducts($branchId);
        } else {
            $response = [];
        }
        echo json_encode($response);
        break;

    case 'generateInventoryStatusReport':
        $branch_id = $_POST['branch_id'] ?? '';
        $startDate = $_POST['startDate'] ?? '';
        $endDate = $_POST['endDate'] ?? '';
        $filterType = $_POST['filterType'] ?? '';

        if (empty($startDate)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Set The Start Date For Report"]);
            exit;
        }

        if (empty($endDate)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Set The End Date For Report"]);
            exit;
        }

        if (empty($filterType)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select The Filter Type For Report"]);
            exit;
        }

        $startDate = DateTime::createFromFormat('m/d/Y', $startDate)->format('Y-m-d');
        $endDate = DateTime::createFromFormat('m/d/Y', $endDate)->format('Y-m-d');

        if ($startDate >= $endDate) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Start Date Cannot Be Later Than End Date"]);
            exit;
        }

        $response = $fetchClass->getInventoryStatusReport($branch_id, $startDate, $endDate, $filterType);
        echo json_encode($response);
        exit;

    case 'generateGroomingReport':
        $branchId = $_POST['branch_id'] ?? '';
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
        $groomingList = $fetchClass->getGroomingReport($branchId, $startDate, $endDate);
        $groomingCount = $fetchClass->getGroomingCount($branchId, $startDate, $endDate);
        $petCount = $fetchClass->getGroomingPetCount($branchId, $startDate, $endDate);

        if ($groomingList["status"] !== "success") {
            echo json_encode($groomingList);
            exit;
        }

        if ($groomingCount["status"] !== "success") {
            echo json_encode($groomingCount);
            exit;
        }

        if ($petCount["status"] !== "success") {
            echo json_encode($petCount);
            exit;
        }
        echo json_encode([
            "status" => "success",
            "title" => "Success",
            "message" => "Sales Report Loaded Successfully",
            "grooming_list" => $groomingList["data"],
            "total_grooming" => $groomingCount["data"],
            "total_pet" => $petCount["data"]
        ]);
        exit;

    case 'generateBookingReport':
        $branchId = $_POST['branch_id'] ?? '';
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
        $bookingList = $fetchClass->getBookingReport($branchId, $startDate, $endDate);
        $bookingCount = $fetchClass->getBookingCount($branchId, $startDate, $endDate);
        $petCount = $fetchClass->getBookingPetCount($branchId, $startDate, $endDate);

        if ($bookingList["status"] !== "success") {
            echo json_encode($bookingList);
            exit;
        }

        if ($bookingCount["status"] !== "success") {
            echo json_encode($bookingCount);
            exit;
        }

        if ($petCount["status"] !== "success") {
            echo json_encode($petCount);
            exit;
        }
        echo json_encode([
            "status" => "success",
            "title" => "Success",
            "message" => "Sales Report Loaded Successfully",
            "booking_list" => $bookingList["data"],
            "total_booking" => $bookingCount["data"],
            "total_pet" => $petCount["data"]
        ]);
        exit;

    default:
        echo json_encode(["status" => "error", "title" => "Error!", "message" => "Invalid Action"]);
        break;
}
