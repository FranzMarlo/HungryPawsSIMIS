<?php
header('Content-Type: application/json');
require_once 'post-class.php';
require_once 'helper.php';

$helper = new helperFunctions();
$postClass = new postClass();
$submitType = $_POST['submitType'] ?? '';

switch ($submitType) {
    case 'addProduct':
        $product_name = ucwords($_POST['productName']) ?? '';
        $barcode = $_POST['barcode'] ?? '';
        $supplier_id = $_POST['supplierSelect'] ?? '';
        $category = $_POST['categorySelect'] ?? '';
        $perish = $_POST['perishSelect'] ?? '';
        $unit_cost = $_POST['unitCost'] ?? '';
        $selling_price = $_POST['sellingPrice'] ?? '';

        if (empty($product_name)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Product Name Cannot Be Empty"]);
            exit;
        }
        if (empty($barcode)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Barcode Of Product"]);
            exit;
        }
        if (empty($supplier_id) || $supplier_id === "Null") {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select The Supplier Of The Product"]);
            exit;
        }
        if (empty($category) || $category === "Null") {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select The Category Of The Product"]);
            exit;
        }
        if ($perish === null || $perish === "") {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select If The Product Is Perishable or Non-Perishable"]);
            exit;
        }
        if (empty($unit_cost)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Unit Cost Of The Product"]);
            exit;
        }
        if (empty($selling_price)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Selling Price Of The Product"]);
            exit;
        }

        $checkBarcode = $helper->checkBarcode($barcode);
        if ($checkBarcode) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Barcode Must Be Unique, Please Check Input"]);
            exit;
        }

        $product_id = $helper->generateUniqueProductBarcode();

        $response = $postClass->addProduct($product_id, $product_name, $barcode, $supplier_id, $category, $unit_cost, $selling_price, $perish);

        echo json_encode($response);
        break;

    case 'updateProduct':
        $product_id = $_POST['product_id'] ?? '';
        $barcode = $_POST['barcode'] ?? '';
        $product_name = ucwords($_POST['productName']) ?? '';
        $supplier_id = $_POST['supplierSelect'] ?? '';
        $category = $_POST['categorySelect'] ?? '';
        $perish = $_POST['perishSelect'] ?? '';
        $unit_cost = $_POST['unitCost'] ?? '';
        $selling_price = $_POST['sellingPrice'] ?? '';

        if (empty($product_name)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Product Name Cannot Be Empty"]);
            exit;
        } elseif (empty($supplier_id) || $supplier_id === "Null") {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select The Supplier Of The Product"]);
            exit;
        } elseif (empty($category) || $category === "Null") {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select The Category Of The Product"]);
            exit;
        } else if ($perish === null || $perish === "") {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select If The Product Is Perishable or Non-Perishable"]);
            exit;
        } elseif (empty($unit_cost)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Unit Cost Of The Product"]);
            exit;
        } elseif (empty($selling_price)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Selling Price Of The Product"]);
            exit;
        }

        $checkBarcode = $helper->recheckBarcode($barcode);
        if ($checkBarcode) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Barcode Must Be Unique, Please Check Input"]);
            exit;
        }


        $response = $postClass->updateProduct($product_id, $product_name, $barcode, $supplier_id, $category, $unit_cost, $selling_price, $perish);

        echo json_encode($response);
        break;

    case 'addOrder':
        $orderDateTime = (new DateTime('now'))->format('Y-m-d H:i:s');
        $currentDate = date('Y-m-d');

        $branchId = $_POST['orderBranch'];
        $cashierId = $_POST['orderCashier'];
        $service = $_POST['service'] ?? '';
        $serviceCost = $_POST['serviceCost'] ?? '';
        $paymentMethod = $_POST['paymentMethod'] ?? '';

        //For Pet Grooming Only
        $groomerSelect = $_POST['groomerSelect'] ?? '';
        $groomingPetType = $_POST['groomingPetType'] ?? '';
        $petSize = $_POST['petSize'] ?? '';
        $scheduledDateRaw = $_POST['scheduledDate'] ?? '';

        //For Pet Hotel Only
        $bookingPetType = $_POST['bookingPetType'] ?? '';
        $roomType = $_POST['roomType'] ?? '';
        $checkinDateRaw = $_POST['checkinDate'] ?? '';
        $checkoutDateRaw = $_POST['checkoutDate'] ?? '';

        $checkinDate = '';
        $checkoutDate = '';

        if (!empty($checkinDateRaw)) {
            $dateObj = DateTime::createFromFormat('m/d/Y', $checkinDateRaw);
            if ($dateObj !== false) {
                $checkinDate = $dateObj->format('Y-m-d');
            }
        }

        if (!empty($checkoutDateRaw)) {
            $dateObj = DateTime::createFromFormat('m/d/Y', $checkoutDateRaw);
            if ($dateObj !== false) {
                $checkoutDate = $dateObj->format('Y-m-d');
            }
        }

        $orderTotalVal = $_POST['orderTotalVal'] ?? '';
        $products = $_POST['products'] ?? [];

        if (empty($service)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select Service Type"]);
            exit;
        } elseif (empty($serviceCost) && $service != "none") {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Service Cost"]);
            exit;
        } else if (empty($paymentMethod)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select Payment Method"]);
            exit;
        }

        //For Pet Grooming
        if (($service === "grooming" || $service === "both") && empty($groomerSelect)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select A Groomer To Be Assigned For The Service"]);
            exit;
        } else if (($service === "grooming" || $service === "both") && empty($groomingPetType)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Pet Type For Grooming"]);
            exit;
        } else if (($service === "grooming" || $service === "both") && empty($petSize)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Pet Size For Pet Grooming"]);
            exit;
        } else if (($service === "grooming" || $service === "both") && empty($petSize)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Pet Size For Pet Grooming"]);
            exit;
        }

        if (!empty($scheduledDateRaw)) {
            $scheduledDateObj = DateTime::createFromFormat('m/d/Y', $scheduledDateRaw);
            if ($scheduledDateObj) {
                $scheduledDate = $scheduledDateObj->format('Y-m-d');
            } else {
                echo json_encode([
                    "status" => "warning",
                    "title" => "Warning!",
                    "message" => "Please Set A Valid Scheduled Date For Grooming"
                ]);
                exit;
            }
        } else if (($service === "grooming" || $service === "both")) {
            echo json_encode([
                "status" => "warning",
                "title" => "Warning!",
                "message" => "Please Set A Valid Scheduled Date For Grooming"
            ]);
            exit;
        }



        if (($service === "grooming" || $service === "both") && $scheduledDate < $currentDate) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Scheduled Date Cannot Be At The Past"]);
            exit;
        }

        //For Pet Hotel Booking
        if (($service === "pet_hotel" || $service === "both") && empty($bookingPetType)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Pet Type For Pet Hotel Booking"]);
            exit;
        } else if (($service === "pet_hotel" || $service === "both") && empty($roomType)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Room Type For Booking"]);
            exit;
        } else if (($service === "pet_hotel" || $service === "both") && (empty($checkinDate) || !strtotime($checkinDate))) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Set A Valid Check In Date For Booking"]);
            exit;
        } else if (($service === "pet_hotel" || $service === "both") && (empty($checkoutDate) || !strtotime($checkoutDate))) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Set A Valid Check Out Date For Booking"]);
            exit;
        } else if (($service === "pet_hotel" || $service === "both") && (strtotime($checkinDate) > strtotime($checkoutDate))) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Check In Date Cannot Be A Day After Check Out Date"]);
            exit;
        }

        if (($service === "pet_hotel" || $service === "both" || $service === "grooming")) {
            $isService = true;
        } else {
            $isService = false;
        }

        if (!empty($products) && is_array($products)) {
            $errors = [];
            $insertedProducts = [];

            $insufficientStock = false;
            foreach ($products as $barcode => $product) {
                $productId = $product['id'] ?? '';
                $productName = trim($product['name'] ?? '');
                $price = floatval($product['price'] ?? 0);
                $total = floatval($product['total'] ?? 0);
                $quantity = intval($product['quantity'] ?? 0);

                if (empty($productId) || empty($productName)) {
                    $errors[] = "Missing product ID or name.";
                    continue;
                }

                if ($quantity <= 0) {
                    $errors[] = "Invalid quantity for product: {$productName}.";
                    continue;
                }

                if ($price <= 0) {
                    $errors[] = "Invalid price for product: {$productName}.";
                    continue;
                }

                $stock = $helper->getProductStock($productId, $branchId);
                if ($quantity > $stock['stock_level']) {
                    $errors[] = "Insufficient stock for {$productName} (available: {$stock['stock_level']}, requested: {$quantity}).";
                }
            }

            if (!empty($errors)) {
                echo json_encode([
                    "status" => "error",
                    "title" => "Order Validation Failed",
                    "message" => implode("<br>", $errors)
                ]);
                exit;
            }

            $orderId = $helper->generateUniqueOrderId();

            $addOrder = $postClass->addOrder($orderId, $branchId, $cashierId, $orderDateTime, $orderTotalVal, $paymentMethod, $isService);

            if ($addOrder['status'] === "success" && $service === "none") {
                foreach ($products as $barcode => $product) {
                    $productId = $product['id'] ?? '';
                    $productName = trim($product['name'] ?? '');
                    $price = floatval($product['price'] ?? 0);
                    $quantity = intval($product['quantity'] ?? 0);
                    $total = floatval($product['total'] ?? 0);

                    $orderDetailId = $helper->generateUniqueOrderDetailId();

                    $addOrderDetail = $postClass->addOrderDetail($orderDetailId, $orderId, $productId, $quantity, $price);
                    if ($addOrderDetail['status'] === "success") {
                        $stock = $helper->getProductStock($productId, $branchId);
                        $newStock = intval($stock['stock_level']) - $quantity;
                        $insertedProducts[] = $productName;
                        $updateStock = $postClass->updateProductStock($productId, $branchId, $newStock);

                        if (!$updateStock) {
                            echo json_encode($updateStock);
                            exit;
                        }
                    } else {
                        echo json_encode($addOrderDetail);
                        exit;
                    }
                }

                $response = [
                    "status" => "success",
                    "title" => "All Order Details Added",
                    "message" => "Order Details Added Successfully!",
                    "orderId" => $orderId
                ];
            } else if (($addOrder['status'] === "success") && $service === "grooming") {
                $serviceId = $helper->generateUniqueGroomingId();
                $addGroomingDetail = $postClass->addGroomingDetail($serviceId, $orderId, $groomerSelect, $groomingPetType, $petSize, $scheduledDate);

                if (!$addGroomingDetail) {
                    echo json_encode($addGroomingDetail);
                }

                foreach ($products as $barcode => $product) {
                    $productId = $product['id'] ?? '';
                    $productName = trim($product['name'] ?? '');
                    $price = floatval($product['price'] ?? 0);
                    $quantity = intval($product['quantity'] ?? 0);
                    $total = floatval($product['total'] ?? 0);

                    $orderDetailId = $helper->generateUniqueOrderDetailId();

                    $addOrderDetail = $postClass->addOrderDetail($orderDetailId, $orderId, $productId, $quantity, $price);
                    if ($addOrderDetail['status'] === "success") {
                        $stock = $helper->getProductStock($productId, $branchId);
                        $newStock = intval($stock['stock_level']) - $quantity;
                        $insertedProducts[] = $productName;
                        $updateStock = $postClass->updateProductStock($productId, $branchId, $newStock);

                        if (!$updateStock) {
                            echo json_encode($updateStock);
                            exit;
                        }
                    } else {
                        echo json_encode($addOrderDetail);
                        exit;
                    }
                }

                $response = [
                    "status" => "success",
                    "title" => "All Order Details Added",
                    "message" => "Order and Pet Grooming Service Details Added Successfully!",
                    "orderId" => $orderId
                ];
            } else if (($addOrder['status'] === "success") && $service === "pet_hotel") {
                $bookingId = $helper->generateUniqueBookingId();
                $addBookingDetail = $postClass->addBookingDetail($bookingId, $orderId, $bookingPetType, $roomType, $checkinDate, $checkoutDate);

                if (!$addBookingDetail) {
                    echo json_encode($addBookingDetail);
                }

                foreach ($products as $barcode => $product) {
                    $productId = $product['id'] ?? '';
                    $productName = trim($product['name'] ?? '');
                    $price = floatval($product['price'] ?? 0);
                    $quantity = intval($product['quantity'] ?? 0);
                    $total = floatval($product['total'] ?? 0);

                    $orderDetailId = $helper->generateUniqueOrderDetailId();

                    $addOrderDetail = $postClass->addOrderDetail($orderDetailId, $orderId, $productId, $quantity, $price);
                    if ($addOrderDetail['status'] === "success") {
                        $stock = $helper->getProductStock($productId, $branchId);
                        $newStock = intval($stock['stock_level']) - $quantity;
                        $insertedProducts[] = $productName;
                        $updateStock = $postClass->updateProductStock($productId, $branchId, $newStock);

                        if (!$updateStock) {
                            echo json_encode($updateStock);
                            exit;
                        }
                    } else {
                        echo json_encode($addOrderDetail);
                        exit;
                    }
                }

                $response = [
                    "status" => "success",
                    "title" => "All Order Details Added",
                    "message" => "Order and Pet Hotel Service Details Added Successfully!",
                    "orderId" => $orderId
                ];

            } else {
                $serviceId = $helper->generateUniqueGroomingId();
                $addGroomingDetail = $postClass->addGroomingDetail($serviceId, $orderId, $groomerSelect, $groomingPetType, $petSize, $scheduledDate);

                if (!$addGroomingDetail) {
                    echo json_encode($addGroomingDetail);
                }

                $bookingId = $helper->generateUniqueBookingId();
                $addBookingDetail = $postClass->addBookingDetail($bookingId, $orderId, $bookingPetType, $roomType, $checkinDate, $checkoutDate);

                if (!$addBookingDetail) {
                    echo json_encode($addBookingDetail);
                }

                foreach ($products as $barcode => $product) {
                    $productId = $product['id'] ?? '';
                    $productName = trim($product['name'] ?? '');
                    $price = floatval($product['price'] ?? 0);
                    $quantity = intval($product['quantity'] ?? 0);
                    $total = floatval($product['total'] ?? 0);

                    $orderDetailId = $helper->generateUniqueOrderDetailId();

                    $addOrderDetail = $postClass->addOrderDetail($orderDetailId, $orderId, $productId, $quantity, $price);
                    if ($addOrderDetail['status'] === "success") {
                        $stock = $helper->getProductStock($productId, $branchId);
                        $newStock = intval($stock['stock_level']) - $quantity;
                        $insertedProducts[] = $productName;
                        $updateStock = $postClass->updateProductStock($productId, $branchId, $newStock);

                        if (!$updateStock) {
                            echo json_encode($updateStock);
                            exit;
                        }
                    } else {
                        echo json_encode($addOrderDetail);
                        exit;
                    }
                }

                $response = [
                    "status" => "success",
                    "title" => "All Order Details Added",
                    "message" => "Order and Service Details Added Successfully!",
                    "orderId" => $orderId
                ];
            }


        } else {

            $orderId = $helper->generateUniqueOrderId();

            $addOrder = $postClass->addOrder($orderId, $branchId, $cashierId, $orderDateTime, $orderTotalVal, $paymentMethod, $isService);

            if (($addOrder['status'] === "success") && $service === "grooming") {
                $serviceId = $helper->generateUniqueGroomingId();
                $addGroomingDetail = $postClass->addGroomingDetail($serviceId, $orderId, $groomerSelect, $groomingPetType, $petSize, $scheduledDate);

                if (!$addGroomingDetail) {
                    echo json_encode($addGroomingDetail);
                }

                $response = [
                    "status" => "success",
                    "title" => "All Order Details Added",
                    "message" => "Pet Grooming Service Details Added Successfully!",
                    "orderId" => $orderId
                ];

            } else if (($addOrder['status'] === "success") && $service === "pet_hotel") {
                $bookingId = $helper->generateUniqueBookingId();
                $addBookingDetail = $postClass->addBookingDetail($bookingId, $orderId, $bookingPetType, $roomType, $checkinDate, $checkoutDate);

                if (!$addBookingDetail) {
                    echo json_encode($addBookingDetail);
                }

                $response = [
                    "status" => "success",
                    "title" => "All Order Details Added",
                    "message" => "Pet Hotel Service Details Added Successfully!",
                    "orderId" => $orderId
                ];

            } else {
                $serviceId = $helper->generateUniqueGroomingId();
                $addGroomingDetail = $postClass->addGroomingDetail($serviceId, $orderId, $groomerSelect, $groomingPetType, $petSize, $scheduledDate);

                if (!$addGroomingDetail) {
                    echo json_encode($addGroomingDetail);
                }

                $bookingId = $helper->generateUniqueBookingId();
                $addBookingDetail = $postClass->addBookingDetail($bookingId, $orderId, $bookingPetType, $roomType, $checkinDate, $checkoutDate);

                if (!$addBookingDetail) {
                    echo json_encode($addBookingDetail);
                }

                $response = [
                    "status" => "success",
                    "title" => "All Order Details Added",
                    "message" => "Pet Grooming and Pet Hotel Service Details Added Successfully!",
                    "orderId" => $orderId
                ];
            }
        }

        echo json_encode($response);
        break;

    case 'requestStock':
        $productSelect = $_POST['productSelect'] ?? '';
        $quantity = $_POST['quantity'] ?? '';
        $branchSelect = $_POST['branchSelect'] ?? '';
        $branch1Select = $_POST['branch1Select'] ?? '';

        if (empty($productSelect)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select A Product To Be Requested"]);
            exit;
        } elseif (empty($quantity)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Product Quantity To Be Requested"]);
            exit;
        } elseif (empty($branchSelect)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select The Sending Branch For The Request"]);
            exit;
        } elseif (empty($branch1Select)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select The Receiving Branch For The Request"]);
            exit;
        } elseif ($branchSelect === $branch1Select) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Sending and Receiving Branch Cannot Be The Same Branch To Process Request"]);
            exit;
        }
        $totalBranchStock = $helper->sumProductStock($productSelect, $branchSelect);
        if ($quantity >= $totalBranchStock['total_stock']) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Quantity Requested Exceeds Branch Stock Of Product"]);
            exit;
        }

        $requestId = $helper->generateUniqueRequestId();
        $currentDateTime = date('Y-m-d H:i:s');

        $response = $postClass->addStockRequest($requestId, $productSelect, $branchSelect, $branch1Select, $quantity, $currentDateTime);

        echo json_encode($response);
        break;

    case 'addInventory':
        $inventoryBranch = $_POST['inventoryBranch'] ?? '';
        $productSelect = $_POST['productSelect'] ?? '';
        $productQuantity = $_POST['productQuantity'] ?? '';
        $productPoint = $_POST['productPoint'] ?? '';
        $isPerish = $_POST['isPerish'] ?? '';
        $manufacturedDate = $_POST['manufacturedDate'] ?? '';
        $expiryDate = $_POST['expiryDate'] ?? '';


        if (empty($productSelect)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select A Product To Be Added For Inventory"]);
            exit;
        }

        if (empty($inventoryBranch)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select Branch For Inventory"]);
            exit;
        }

        if (empty($productQuantity)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Product's Current Quantity On Hand"]);
            exit;
        }

        if (empty($productPoint)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Set The Reorder Point For Product"]);
            exit;
        }

        if (intval($productPoint) >= intval($productQuantity)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Product Quantity Must Be At Least Larger Than Re-order Point"]);
            exit;
        }

        if (empty($manufacturedDate)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Set The Manufactured Date For Product's Inventory"]);
            exit;
        }

        if (empty($expiryDate) && $isPerish == 1) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Set The Expiry Date For Product's Inventory"]);
            exit;
        }

        if ($isPerish == 1) {
            $expiryDate = trim($expiryDate);
            $timestamp = strtotime($expiryDate);

            if ($timestamp === false) {
                echo json_encode([
                    "status" => "warning",
                    "title" => "Warning!",
                    "message" => "Invalid Expiry Date Format. Please Set Valid Date (YYYY-MM-DD)."
                ]);
                exit;
            }

            $manufacturedDate = trim($manufacturedDate);
            $timestamp1 = strtotime($manufacturedDate);

            if ($timestamp1 === false) {
                echo json_encode([
                    "status" => "warning",
                    "title" => "Warning!",
                    "message" => "Invalid Manufactured Date Format. Please Set Valid Date (YYYY-MM-DD)."
                ]);
                exit;
            }

            $date = new DateTime("@$timestamp");
            $date->setTimezone(new DateTimeZone(date_default_timezone_get())); // normalize timezone
            $formattedExpiryDate = $date->format('Y-m-d');

            $today = new DateTime('today');
            if ($date < $today) {
                echo json_encode([
                    "status" => "warning",
                    "title" => "Warning!",
                    "message" => "Expiry Date Cannot Be In The Past"
                ]);
                exit;
            }

            $date1 = new DateTime("@$timestamp1");
            $date1->setTimezone(new DateTimeZone(date_default_timezone_get())); // normalize timezone
            $formattedManufacturedDate = $date1->format('Y-m-d');

            if ($date1 > $today) {
                echo json_encode([
                    "status" => "warning",
                    "title" => "Warning!",
                    "message" => "Manufactured Date Cannot Be In The Future"
                ]);
                exit;
            }

            $inventoryCount = $helper->checkProductInventory($productSelect, $inventoryBranch, $formattedExpiryDate);
            if ($inventoryCount > 0) {
                echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "An Inventory For Product With The Same Expiry Date Already Exists, Please Update It's Product Inventory If You Want To Modify The Stock."]);
                exit;
            }

            $inventoryId = $helper->generateInventoryId();
            $currentDateTime = date('Y-m-d H:i:s');

            $response = $postClass->addInventory($inventoryId, $inventoryBranch, $productSelect, $productQuantity, $productPoint, $currentDateTime, $formattedExpiryDate, $formattedManufacturedDate);

            echo json_encode($response);

        } else {


            $manufacturedDate = trim($manufacturedDate);
            $timestamp = strtotime($manufacturedDate);

            if ($timestamp === false) {
                echo json_encode([
                    "status" => "warning",
                    "title" => "Warning!",
                    "message" => "Invalid Manufactured Date Format. Please Set Valid Date (YYYY-MM-DD)."
                ]);
                exit;
            }

            $date = new DateTime("@$timestamp");
            $date->setTimezone(new DateTimeZone(date_default_timezone_get())); // normalize timezone
            $formattedManufacturedDate = $date->format('Y-m-d');

            $today = new DateTime('today');
            if ($date > $today) {
                echo json_encode([
                    "status" => "warning",
                    "title" => "Warning!",
                    "message" => "Manufactured Date Cannot Be In The Future"
                ]);
                exit;
            }

            $inventoryCount = $helper->checkManufacturedInventory($productSelect, $inventoryBranch, $formattedManufacturedDate);
            if ($inventoryCount > 0) {
                echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "An Inventory For Product With The Same Manufactured Date Already Exists, Please Update It's Product Inventory If You Want To Modify The Stock."]);
                exit;
            }

            $inventoryId = $helper->generateInventoryId();
            $currentDateTime = date('Y-m-d H:i:s');

            $response = $postClass->addInventory($inventoryId, $inventoryBranch, $productSelect, $productQuantity, $productPoint, $currentDateTime, "", $formattedManufacturedDate);

            echo json_encode($response);
        }
        break;

    case 'updateInventory':
        $inventoryId = $_POST['inventoryId'] ?? '';
        $productName = $_POST['productName'] ?? '';
        $productId = $_POST['productId'] ?? '';
        $branchId = $_POST['branchId'] ?? '';
        $productQuantity = $_POST['productQuantity'] ?? '';
        $productPoint = $_POST['productPoint'] ?? '';
        $isPerish = $_POST['isPerish'] ?? '';
        $manufacturedDate = $_POST['manufacturedDate'] ?? '';
        $expiryDate = $_POST['expiryDate'] ?? '';


        if (empty($productQuantity)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Product's Current Quantity On Hand"]);
            exit;
        }

        if (empty($productPoint)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Set The Reorder Point For Product"]);
            exit;
        }

        if (intval($productPoint) >= intval($productQuantity)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Product Quantity Must Be At Least Larger Than Re-order Point"]);
            exit;
        }

        if (empty($manufacturedDate)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Set The Manufactured Date For Product's Inventory"]);
            exit;
        }

        if (empty($expiryDate) && $isPerish == 1) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Set The Expiry Date For Product's Inventory"]);
            exit;
        }
        if ($isPerish == 1) {
            $expiryDate = trim($expiryDate);
            $timestamp = strtotime($expiryDate);

            if ($timestamp === false) {
                echo json_encode([
                    "status" => "warning",
                    "title" => "Warning!",
                    "message" => "Invalid Expiry Date Format. Please Set Valid Date (YYYY-MM-DD)."
                ]);
                exit;
            }

            $manufacturedDate = trim($manufacturedDate);
            $timestamp1 = strtotime($manufacturedDate);

            if ($timestamp1 === false) {
                echo json_encode([
                    "status" => "warning",
                    "title" => "Warning!",
                    "message" => "Invalid Manufactured Date Format. Please Set Valid Date (YYYY-MM-DD)."
                ]);
                exit;
            }

            $date = new DateTime("@$timestamp");
            $date->setTimezone(new DateTimeZone(date_default_timezone_get())); // normalize timezone
            $formattedExpiryDate = $date->format('Y-m-d');

            $today = new DateTime('today');
            if ($date < $today) {
                echo json_encode([
                    "status" => "warning",
                    "title" => "Warning!",
                    "message" => "Expiry Date Cannot Be In The Past"
                ]);
                exit;
            }

            $date1 = new DateTime("@$timestamp1");
            $date1->setTimezone(new DateTimeZone(date_default_timezone_get())); // normalize timezone
            $formattedManufacturedDate = $date1->format('Y-m-d');

            if ($date1 > $today) {
                echo json_encode([
                    "status" => "warning",
                    "title" => "Warning!",
                    "message" => "Manufactured Date Cannot Be In The Future"
                ]);
                exit;
            }

            $inventoryCount = $helper->checkProductInventory($productId, $branchId, $formattedExpiryDate);
            if ($inventoryCount > 1) {
                echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "An Inventory For Product With The Same Expiry Date Already Exists, Please Update It's Product Inventory If You Want To Modify The Stock."]);
                exit;
            }

            $inventoryInfo = $helper->getInventoryInfo($inventoryId);
            if ($inventoryInfo['archived'] == 1) {
                echo json_encode(["status" => "error", "title" => "Invalid Action", "message" => "Archived Products Are Not Allowed To Be Updated"]);
                exit;
            }

            if (
                $productQuantity == $inventoryInfo['stock_level'] && $productPoint == $inventoryInfo['reorder_point']
                && $formattedExpiryDate == $inventoryInfo['expiry_date'] && $formattedManufacturedDate == $inventoryInfo['manufactured_date']
            ) {
                echo json_encode(["status" => "info", "title" => "Info", "message" => "No Changes Made"]);
                exit;
            }

            $currentDateTime = date('Y-m-d H:i:s');

            $response = $postClass->updateInventory($inventoryId, $productQuantity, $productPoint, $currentDateTime, $formattedExpiryDate, $formattedManufacturedDate);

            echo json_encode($response);
        } else {

            $manufacturedDate = trim($manufacturedDate);
            $timestamp1 = strtotime($manufacturedDate);

            if ($timestamp1 === false) {
                echo json_encode([
                    "status" => "warning",
                    "title" => "Warning!",
                    "message" => "Invalid Manufactured Date Format. Please Set Valid Date (YYYY-MM-DD)."
                ]);
                exit;
            }
            $today = new DateTime('today');

            $date1 = new DateTime("@$timestamp1");
            $date1->setTimezone(new DateTimeZone(date_default_timezone_get())); // normalize timezone
            $formattedManufacturedDate = $date1->format('Y-m-d');

            if ($date1 > $today) {
                echo json_encode([
                    "status" => "warning",
                    "title" => "Warning!",
                    "message" => "Manufactured Date Cannot Be In The Future"
                ]);
                exit;
            }

            $inventoryCount = $helper->checkManufacturedInventory($productId, $branchId, $formattedManufacturedDate);
            if ($inventoryCount > 0) {
                echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "An Inventory For Product With The Same Manufactured Date Already Exists, Please Update It's Product Inventory If You Want To Modify The Stock."]);
                exit;
            }

            $inventoryInfo = $helper->getInventoryInfo($inventoryId);
            if ($inventoryInfo['archived'] == 1) {
                echo json_encode(["status" => "error", "title" => "Invalid Action", "message" => "Archived Products Are Not Allowed To Be Updated"]);
                exit;
            }

            if (
                $productQuantity == $inventoryInfo['stock_level'] && $productPoint == $inventoryInfo['reorder_point']
                && "0000-00-00" == $inventoryInfo['expiry_date'] && $formattedManufacturedDate == $inventoryInfo['manufactured_date']
            ) {
                echo json_encode(["status" => "info", "title" => "Info", "message" => "No Changes Made"]);
                exit;
            }

            $currentDateTime = date('Y-m-d H:i:s');

            $response = $postClass->updateInventory($inventoryId, $productQuantity, $productPoint, $currentDateTime, "", $formattedManufacturedDate);

            echo json_encode($response);
        }


        break;

    case 'cancelStockRequest':
        $transferId = $_POST['transferId'];

        $requestInfo = $helper->getRequestInfo($transferId);

        if ($requestInfo['status'] !== "Requested") {
            echo json_encode(["status" => "error", "title" => "Invalid Action!", "message" => "Only Requests With Requested Status Are Eligible For Cancellation"]);
            exit;
        }

        $post = new postClass();
        $response = $post->cancelStockRequest($transferId);

        echo json_encode($response);
        break;

    case 'completeStockRequest':

        $transferId = $_POST['transferId'];

        $requestInfo = $helper->getRequestInfo($transferId);

        if (!$requestInfo) {

            echo json_encode([
                "status" => "error",
                "title" => "Error!",
                "message" => "Transfer Request Not Found"
            ]);
            exit;
        }

        if ($requestInfo['status'] !== "Approved") {

            echo json_encode([
                "status" => "error",
                "title" => "Invalid Action!",
                "message" => "Only Approved Requests Can Be Completed"
            ]);
            exit;
        }

        $receiving_branch = $requestInfo['receiving_branch_id'];

        $transferItems = $helper->getTransferItems($transferId);

        if (empty($transferItems)) {

            echo json_encode([
                "status" => "error",
                "title" => "No Transfer Items",
                "message" => "No transfer breakdown found."
            ]);
            exit;
        }

        $postClass->beginTransaction();

        try {

            foreach ($transferItems as $item) {

                $postClass->receiveInventoryBatch(
                    $item['product_id'],
                    $receiving_branch,
                    $item['manufactured_date'],
                    $item['expiry_date'],
                    $item['reorder_point'],
                    $item['quantity']
                );
            }

            $postClass->completeTransferStatus(
                $transferId,
                'Completed'
            );

            $postClass->commit();

            echo json_encode([
                "status" => "success",
                "title" => "Completed!",
                "message" => "Stock successfully received by branch."
            ]);

        } catch (Exception $e) {

            $postClass->rollback();

            echo json_encode([
                "status" => "error",
                "title" => "Transaction Failed",
                "message" => $e->getMessage()
            ]);
        }

        break;

    case 'approveStockRequest':

        $transferId = $_POST['transferId'];

        $requestInfo = $helper->getTransferInfo($transferId);

        if (!$requestInfo) {

            echo json_encode([
                "status" => "error",
                "title" => "Error!",
                "message" => "Transfer Request Not Found"
            ]);
            exit;
        }

        if ($requestInfo['status'] !== "Requested") {

            echo json_encode([
                "status" => "error",
                "title" => "Invalid Action!",
                "message" => "Only Requested Transfers Can Be Approved"
            ]);
            exit;
        }

        $product_id = $requestInfo['product_id'];
        $sending_branch = $requestInfo['sending_branch_id'];
        $requested_qty = (int) $requestInfo['quantity'];

        // Fetch FEFO batches
        $batches = $helper->getInventoryBatchesForTransfer(
            $product_id,
            $sending_branch
        );

        if (empty($batches)) {

            echo json_encode([
                "status" => "error",
                "title" => "No Stock!",
                "message" => "No Available Inventory Batches"
            ]);
            exit;
        }

        $totalAvailable = 0;

        foreach ($batches as $b) {
            $totalAvailable += (int) $b['stock_level'];
        }

        if ($totalAvailable < $requested_qty) {

            echo json_encode([
                "status" => "error",
                "title" => "Insufficient Stock",
                "message" => "Cannot approve request. Not enough inventory in sending branch."
            ]);
            exit;
        }

        $postClass->beginTransaction();

        try {

            $remaining = $requested_qty;

            foreach ($batches as $batch) {

                if ($remaining <= 0) {
                    break;
                }

                $available = (int) $batch['stock_level'];

                $deduct = min($available, $remaining);

                // Insert transfer breakdown (stock_transfer_items)
                $postClass->addTransferItem(
                    $transferId,
                    $batch['inventory_id'],
                    $deduct
                );

                // Deduct inventory stock
                $postClass->deductInventoryStock(
                    $batch['inventory_id'],
                    $deduct
                );

                $remaining -= $deduct;
            }

            // Final status update
            $postClass->updateTransferStatus(
                $transferId,
                'Approved'
            );

            $postClass->commit();

            echo json_encode([
                "status" => "success",
                "title" => "Approved!",
                "message" => "Stock request approved and inventory deducted successfully."
            ]);

        } catch (Exception $e) {

            $postClass->rollback();

            echo json_encode([
                "status" => "error",
                "title" => "Transaction Failed",
                "message" => $e->getMessage()
            ]);
        }

        break;

    case 'updateRequestStock':
        $requestId = $_POST['requestId'] ?? '';
        $productSelect = $_POST['productSelect'] ?? '';
        $quantity = $_POST['quantity'] ?? '';
        $branchSelect = $_POST['branchSelect'] ?? '';
        $branch1Select = $_POST['branch1Select'] ?? '';

        if (empty($productSelect)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select A Product To Be Requested"]);
            exit;
        } elseif (empty($quantity)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Product Quantity To Be Requested"]);
            exit;
        } elseif (empty($branchSelect)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select The Sending Branch For The Request"]);
            exit;
        } elseif (empty($branch1Select)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select The Receiving Branch For The Request"]);
            exit;
        } elseif ($branchSelect === $branch1Select) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Sending and Receiving Branch Cannot Be The Same Branch To Process Request"]);
            exit;
        }

        $totalBranchStock = $helper->sumProductStock($productSelect, $branchSelect);
        if ($quantity >= $totalBranchStock['total_stock']) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Quantity Requested Exceeds Branch Stock Of Product"]);
            exit;
        }

        $requestInfo = $helper->getRequestInfo($requestId);

        if ($requestInfo['status'] !== "Requested") {
            echo json_encode(["status" => "error", "title" => "Invalid Action!", "message" => "Only Requests With Requested Status Are Eligible For Updates"]);
            exit;
        }

        if ($requestInfo['product_id'] == $productSelect && $requestInfo['quantity'] == $quantity && $requestInfo['sending_branch_id'] == $branchSelect && $requestInfo['receiving_branch_id'] == $branch1Select) {
            echo json_encode(["status" => "info", "title" => "Info", "message" => "No Changes Made"]);
            exit;
        }

        $response = $postClass->updateStockRequest($requestId, $productSelect, $branchSelect, $branch1Select, $quantity);

        echo json_encode($response);
        break;

    case 'updatePassword':
        $userId = $_POST['userId'] ?? '';
        $currentPassword = $_POST['currentPassword'] ?? '';
        $newPassword = $_POST['newPassword'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';

        if (empty($currentPassword)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Current Password"]);
            exit;
        }

        if (empty($newPassword)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter New Password"]);
            exit;
        }

        if (empty($confirmPassword)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Confirm New Password"]);
            exit;
        }

        if (strlen($newPassword) < 6) {
            echo json_encode([
                "status" => "warning",
                "title" => "Warning!",
                "message" => "Password Must Be At Least 6 Characters Long"
            ]);
            exit;
        }

        if ($confirmPassword !== $newPassword) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "New Password and Confirm Password Does Not Match, Please Try Again"]);
            exit;
        }

        $hashedPassword = $helper->getCurrentPassword($userId);

        if (!password_verify($currentPassword, $hashedPassword)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Incorrect Current Password, Please Try Again"]);
            exit;
        }

        if (password_verify($newPassword, $hashedPassword)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Use Different Password, Old Password Cannot Be Used For New Password"]);
            exit;
        }

        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $response = $postClass->updatePassword($userId, $newHashedPassword);

        echo json_encode($response);
        break;

    case 'addUser':
        $firstName = ucwords(strtolower($_POST['firstName'] ?? ''));
        $lastName = ucwords(strtolower($_POST['lastName'] ?? ''));
        $email = $_POST['email'] ?? '';
        $roleSelect = $_POST['roleSelect'] ?? '';
        $branchSelect = $_POST['branchSelect'] ?? '';
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';

        if (empty($firstName)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter First Name Of User"]);
            exit;
        }

        if (empty($lastName)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Last Name Of User"]);
            exit;
        }

        if (empty($email)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Email Of User"]);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter A Valid Email Address"]);
            exit;
        }

        $checkEmail = $helper->checkEmail($email);

        if ($checkEmail) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Email Already In Use"]);
            exit;
        }

        if (empty($roleSelect)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select Role Of User"]);
            exit;
        }

        if (empty($branchSelect)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select Branch To Be Assigned For User"]);
            exit;
        }

        if (empty($username)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Username For User"]);
            exit;
        }

        if (strlen($username) < 4 || strlen($username) > 20) {
            echo json_encode([
                "status" => "warning",
                "title" => "Warning!",
                "message" => "Username Must Be Between 4 To 20 Characters Long"
            ]);
            exit;
        }

        $checkUsername = $helper->checkUsername($username);

        if ($checkUsername) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Username Already In Use"]);
            exit;
        }

        if (empty($password)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Password"]);
            exit;
        }

        if (strlen($password) < 6) {
            echo json_encode([
                "status" => "warning",
                "title" => "Warning!",
                "message" => "Password Must Be At Least 6 Characters Long"
            ]);
            exit;
        }

        if (empty($confirmPassword)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Re-Enter Password"]);
            exit;
        }

        if ($confirmPassword !== $password) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Passwords Does Not Match, Please Try Again"]);
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userId = $helper->generateUserId();

        $post = new postClass();
        $response = $post->addUser($userId, $branchSelect, $username, $hashedPassword, $roleSelect, $firstName, $lastName, $email);

        echo json_encode($response);
        break;

    case 'updateUser':
        $userId = $_POST['userId'] ?? '';
        $firstName = ucwords(strtolower($_POST['firstName'] ?? ''));
        $lastName = ucwords(strtolower($_POST['lastName'] ?? ''));
        $email = $_POST['email'] ?? '';
        $roleSelect = $_POST['roleSelect'] ?? '';
        $branchSelect = $_POST['branchSelect'] ?? '';
        $username = $_POST['username'] ?? '';

        $userDetails = $helper->getUserDetails($userId);

        if ($userDetails['status'] == 1) {
            echo json_encode(["status" => "error", "title" => "Invalid Action", "message" => "Disabled Accounts Are Not Allowed To Be Updated"]);
            exit;
        }

        if (empty($firstName)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter First Name Of User"]);
            exit;
        }

        if (empty($lastName)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Last Name Of User"]);
            exit;
        }

        if (empty($email)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Email Of User"]);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter A Valid Email Address"]);
            exit;
        }

        $checkEmail = $helper->reCheckEmail($email);

        if ($checkEmail) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Email Already In Use By Another Account"]);
            exit;
        }

        if (empty($username)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Username For User"]);
            exit;
        }

        if (strlen($username) < 4 || strlen($username) > 20) {
            echo json_encode([
                "status" => "warning",
                "title" => "Warning!",
                "message" => "Username Must Be Between 4 To 20 Characters Long"
            ]);
            exit;
        }

        $checkUsername = $helper->reCheckUsername($username);

        if ($checkUsername) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Username Already In Use By Another Account"]);
            exit;
        }

        if (empty($roleSelect)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select Role Of User"]);
            exit;
        }

        if (empty($branchSelect)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select Branch To Be Assigned For User"]);
            exit;
        }

        if (
            $userDetails['first_name'] == $firstName && $userDetails['last_name'] == $lastName && $userDetails['email'] == $email
            && $userDetails['role'] == $roleSelect && $userDetails['branch_id'] == $branchSelect && $userDetails['username'] == $username
        ) {
            echo json_encode(["status" => "info", "title" => "Info", "message" => "No Changes Made"]);
            exit;
        }


        $post = new postClass();
        $response = $post->updateUser($userId, $branchSelect, $username, $roleSelect, $firstName, $lastName, $email);

        echo json_encode($response);
        break;

    case 'disableUser':
        $userId = $_POST['userId'];

        $userDetails = $helper->getUserDetails($userId);

        if ($userDetails['status'] == 1) {
            echo json_encode(["status" => "error", "title" => "Invalid Action", "message" => "Account Is Already Disabled"]);
            exit;
        }

        $post = new postClass();
        $response = $post->disableUserAccount($userId);

        echo json_encode($response);
        break;

    case 'enableUser':
        $userId = $_POST['userId'];

        $userDetails = $helper->getUserDetails($userId);

        if ($userDetails['status'] == 0) {
            echo json_encode(["status" => "error", "title" => "Invalid Action", "message" => "Account Is Already Enabled"]);
            exit;
        }

        $post = new postClass();
        $response = $post->enableUserAccount($userId);

        echo json_encode($response);
        break;

    case 'archiveProduct':
        $productId = $_POST['productId'];

        $productDetails = $helper->getProductDetails($productId);

        if ($productDetails['archived'] == 1) {
            echo json_encode(["status" => "error", "title" => "Invalid Action", "message" => "Product Is Already Archived"]);
            exit;
        }

        $post = new postClass();
        $response = $post->archiveProduct($productId);

        echo json_encode($response);
        break;

    case 'unarchiveProduct':
        $productId = $_POST['productId'];

        $productDetails = $helper->getProductDetails($productId);

        if ($productDetails['archived'] == 0) {
            echo json_encode(["status" => "error", "title" => "Invalid Action", "message" => "Product Is Already Unarchived"]);
            exit;
        }

        $post = new postClass();
        $response = $post->unarchiveProduct($productId);

        echo json_encode($response);
        break;

    case 'addCategory':
        $category = ucwords(strtolower($_POST['categoryName'] ?? ''));

        if (empty($category)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Category Name"]);
            exit;
        }

        $checkCategory = $helper->checkCategory($category);

        if ($checkCategory) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Category Already Added"]);
            exit;
        }

        $post = new postClass();
        $response = $post->addCategory($category);

        echo json_encode($response);
        break;

    case 'updateCategory':
        $categoryId = $_POST['categoryId'];
        $category = ucwords(strtolower($_POST['categoryName'] ?? ''));

        if (empty($category)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Category Name"]);
            exit;
        }
        $categoryDetails = $helper->getCategoryDetails($categoryId);

        if ($category == $categoryDetails['category']) {
            echo json_encode(["status" => "info", "title" => "Info", "message" => "No Changes Made"]);
            exit;
        }

        $checkCategory = $helper->recheckCategory($category);

        if ($checkCategory) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Category Already Added"]);
            exit;
        }

        $post = new postClass();
        $response = $post->updateCategory($category, $categoryId);

        echo json_encode($response);
        break;

    case 'addSupplier':
        $supplierName = ucwords(strtolower($_POST['supplierName'] ?? ''));
        $contactPerson = $_POST['contactPerson'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        if (empty($supplierName)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Supplier Name"]);
            exit;
        }

        if (empty($contactPerson)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Contact Person For Supplier"]);
            exit;
        }

        if (empty($email)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Email Of Contact Person For Supplier"]);
            exit;
        }

        if (empty($phone)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Phone Number Of Contact Person For Supplier"]);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Valid Email Address Of Contact Person"]);
            exit;
        }

        if (!preg_match('/^09\d{2}-\d{3}-\d{4}$/', $phone)) {
            echo json_encode([
                "status" => "warning",
                "title" => "Invalid Phone Format!",
                "message" => "Phone Number Must Be In The Format 09XX-XXX-XXXX"
            ]);
            exit;
        }

        $supplierId = $helper->generateSupplierId();

        $post = new postClass();
        $response = $post->addSupplier($supplierId, $supplierName, $contactPerson, $email, $phone);

        echo json_encode($response);
        break;

    case 'updateSupplier':
        $supplierId = $_POST['supplierId'];
        $supplierName = ucwords(strtolower($_POST['supplierName'] ?? ''));
        $contactPerson = $_POST['contactPerson'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        if (empty($supplierName)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Supplier Name"]);
            exit;
        }

        if (empty($contactPerson)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Contact Person For Supplier"]);
            exit;
        }

        if (empty($email)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Email Of Contact Person For Supplier"]);
            exit;
        }

        if (empty($phone)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Phone Number Of Contact Person For Supplier"]);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Valid Email Address Of Contact Person"]);
            exit;
        }

        if (!preg_match('/^09\d{2}-\d{3}-\d{4}$/', $phone)) {
            echo json_encode([
                "status" => "warning",
                "title" => "Invalid Phone Format!",
                "message" => "Phone Number Must Be In The Format 09XX-XXX-XXXX"
            ]);
            exit;
        }

        $supplierDetails = $helper->getSupplierDetails($supplierId);

        if (
            $supplierDetails['supplier_name'] == $supplierName && $supplierDetails['contact_person'] == $contactPerson
            && $supplierDetails['email'] == $email && $supplierDetails['phone'] == $phone
        ) {
            echo json_encode(["status" => "info", "title" => "Info", "message" => "No Changes Made"]);
            exit;
        }

        $post = new postClass();
        $response = $post->updateSupplier($supplierId, $supplierName, $contactPerson, $email, $phone);

        echo json_encode($response);
        break;

    case 'addBranch':
        $branchName = $_POST['branchName'] ?? '';
        $country = $_POST['country'] ?? '';
        $region = $_POST['region_name'] ?? '';
        $province = $_POST['province_name'] ?? '';
        $city = $_POST['city_name'] ?? '';
        $barangay = $_POST['barangay_name'] ?? '';
        $street = $_POST['street'] ?? '';
        $contactNumber = $_POST['contactNumber'] ?? '';

        if (empty($branchName)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Branch Name"]);
            exit;
        }

        if (empty($region)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select Region For Address"]);
            exit;
        }

        if ($region !== "NCR" && empty($province)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please select Province"]);
            exit;
        }

        if (empty($city)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select City/Municipality For Address"]);
            exit;
        }

        if (empty($barangay)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Select Barangay For Address"]);
            exit;
        }

        if (empty($street)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Street/Building For Address"]);
            exit;
        }

        if (empty($contactNumber)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Contact Number For Branch"]);
            exit;
        }

        if (!preg_match('/^09\d{2}-\d{3}-\d{4}$/', $contactNumber)) {
            echo json_encode([
                "status" => "warning",
                "title" => "Invalid Contact Number Format!",
                "message" => "Contact Number Must Be In The Format 09XX-XXX-XXXX"
            ]);
            exit;
        }

        if ($region === "NCR") {
            $fullAddress = "$street, $barangay, $city, $country";
        } else {
            $fullAddress = "$street, $barangay, $city, $province, $country";
        }

        $branchColors = [
            '#4F8CFF', // Bright Blue
            '#EC4899', // Hot Pink
            '#8B5CF6', // Purple
            '#38BDF8', // Sky Blue
            '#FB7185', // Rose Pink
            '#C084FC'  // Soft Violet
        ];

        // get used colors
        $usedColors = $helper->getUsedBranchColors();

        // remove used colors
        $availableColors = array_diff($branchColors, $usedColors);

        // fallback if all colors used
        if (empty($availableColors)) {
            $availableColors = $branchColors;
        }

        // pick random available color
        $branchColor = $availableColors[array_rand($availableColors)];

        $post = new postClass();
        $response = $post->addBranch(
            $branchName,
            $fullAddress,
            $contactNumber,
            $branchColor
        );

        echo json_encode($response);
        break;

    case 'updateBranch':
        $branchId = $_POST['branchId'] ?? '';
        $branchName = $_POST['branchName'] ?? '';
        $address = $_POST['address'] ?? '';
        $contactNumber = $_POST['contactNumber'] ?? '';

        if (empty($branchName)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Branch Name"]);
            exit;
        }

        if (empty($address)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Address"]);
            exit;
        }

        if (empty($contactNumber)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Contact Number For Branch"]);
            exit;
        }

        if (!preg_match('/^09\d{2}-\d{3}-\d{4}$/', $contactNumber)) {
            echo json_encode([
                "status" => "warning",
                "title" => "Invalid Contact Number Format!",
                "message" => "Contact Number Must Be In The Format 09XX-XXX-XXXX"
            ]);
            exit;
        }

        $branchDetails = $helper->getBranchDetails($branchId);

        if (
            $branchDetails['branch_name'] == $branchName && $branchDetails['address'] == $address
            && $branchDetails['contact_number'] == $contactNumber
        ) {
            echo json_encode(["status" => "info", "title" => "Info", "message" => "No Changes Made"]);
            exit;
        }

        $post = new postClass();
        $response = $post->updateBranch($branchId, $branchName, $address, $contactNumber);

        echo json_encode($response);
        break;

    case 'forgotPassword':
        $email = $_POST['email'] ?? '';

        if (empty($email)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter Email Associated With Your Account"]);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter A Valid Email Address"]);
            exit;
        }

        $checkEmail = $helper->getUserByEmail($email);

        if (!$checkEmail) {
            echo json_encode(["status" => "error", "title" => "Error", "message" => "Email Not Found"]);
            exit;
        }
        $fullName = $checkEmail['first_name'] . ' ' . $checkEmail['last_name'];
        $username = $checkEmail['username'];

        $token = bin2hex(random_bytes(32));

        $post = new postClass();
        $post->storeResetToken($email, $token);

        $resetLink = "http://localhost/HungryPaws/reset-password?token=$token";

        include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/send-reset-email.php';
        sendResetPasswordEmail($email, $resetLink, $username, $fullName);

        echo json_encode([
            "status" => "success",
            "title" => "Success",
            "message" => "Password Reset Instructions Sent To Your Email."
        ]);
        break;

    case 'resetPassword':
        $token = $_POST['token'] ?? '';
        $newPassword = $_POST['newPassword'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';

        if (empty($token)) {
            echo json_encode(["status" => "error", "title" => "Error", "message" => "Invalid Or Missing Token, Please Try To Relogin"]);
            exit;
        }

        $resetData = $helper->getResetData($token);

        if (!$resetData) {
            echo json_encode(["status" => "error", "title" => "Error", "message" => "Invalid Or Expired Reset Link, Please Try To Relogin"]);
            exit;
        }

        if (empty($newPassword)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Enter New Password"]);
            exit;
        }

        if (empty($confirmPassword)) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Please Confirm New Password"]);
            exit;
        }

        if (strlen($newPassword) < 6) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "Password Must Be At Least 6 Characters Long"]);
            exit;
        }

        if ($confirmPassword !== $newPassword) {
            echo json_encode(["status" => "warning", "title" => "Warning!", "message" => "New Password and Confirm Password Does Not Match, Please Try Again"]);
            exit;
        }

        $email = $resetData['email'];

        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $post = new postClass();

        $updateSuccess = $post->updateUserPasswordByEmail($email, $newHashedPassword);

        if (!$updateSuccess) {
            echo json_encode(["status" => "error", "title" => "Error", "message" => "Failed To Update Password, Please Try Again"]);
            exit;
        }

        $post->deleteResetToken($token);

        echo json_encode([
            "status" => "success",
            "title" => "Success!",
            "message" => "Your Password Has Been Updated Successfully."
        ]);
        break;

    default:
        echo json_encode(["status" => "error", "title" => "Error!", "message" => "Invalid Action"]);
        break;
}
