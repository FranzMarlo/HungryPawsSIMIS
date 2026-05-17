<?php
include 'db.php';
date_default_timezone_set('Asia/Manila');

class postClass extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    public function beginTransaction()
    {
        return $this->conn->begin_transaction();
    }

    public function commit()
    {
        return $this->conn->commit();
    }

    public function rollback()
    {
        return $this->conn->rollback();
    }

    public function addProduct($product_id, $product_name, $barcode, $supplier_id, $category, $unit_cost, $selling_price, $perish)
    {
        $query = $this->conn->prepare("
            INSERT INTO product (product_id, product_name, barcode, supplier_id, category, unit_cost, selling_price, is_perishable)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }

        $query->bind_param("sssssdds", $product_id, $product_name, $barcode, $supplier_id, $category, $unit_cost, $selling_price, $perish);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Product Added",
                "message" => "Product Added Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to add product: " . $query->error
            ];
        }
    }

    public function updateProduct($product_id, $product_name, $barcode, $supplier_id, $category, $unit_cost, $selling_price, $perish)
    {
        $check = $this->conn->prepare("
        SELECT product_name, barcode, supplier_id, category, unit_cost, selling_price, is_perishable 
        FROM product 
        WHERE product_id = ?
    ");
        $check->bind_param("s", $product_id);
        $check->execute();
        $result = $check->get_result()->fetch_assoc();

        if (!$result) {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Product not found."
            ];
        }

        $db_name = trim($result['product_name']);
        $db_barcode = trim($result['barcode']);
        $db_supplier = (string) trim($result['supplier_id']);
        $db_category = trim($result['category']);
        $db_perish = trim($result['is_perishable']);
        $db_unit_cost = (float) $result['unit_cost'];
        $db_selling_price = (float) $result['selling_price'];

        $new_name = trim($product_name);
        $new_barcode = trim($barcode);
        $new_supplier = (string) trim($supplier_id);
        $new_category = trim($category);
        $new_perish = trim($perish);
        $new_unit_cost = (float) $unit_cost;
        $new_selling_price = (float) $selling_price;

        if (
            $db_name === $new_name &&
            $db_barcode === $new_barcode &&
            $db_supplier === $new_supplier &&
            $db_category === $new_category &&
            $db_perish === $new_perish &&
            abs($db_unit_cost - $new_unit_cost) < 0.0001 &&
            abs($db_selling_price - $new_selling_price) < 0.0001
        ) {
            return [
                "status" => "info",
                "title" => "No Changes",
                "message" => "No changes were made to the product."
            ];
        }

        $query = $this->conn->prepare("
        UPDATE product 
        SET product_name = ?, barcode = ?, supplier_id = ?, category = ?, unit_cost = ?, selling_price = ?, is_perishable = ?
        WHERE product_id = ?
    ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }

        $query->bind_param("ssssddss", $new_name, $new_barcode, $new_supplier, $new_category, $new_unit_cost, $new_selling_price, $perish, $product_id);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Product Updated",
                "message" => "Product updated successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to update product: " . $query->error
            ];
        }
    }

    public function addOrder($order_id, $branch_id, $cashier_id, $order_date, $total_amount, $payment_method, $is_service)
    {
        $query = $this->conn->prepare("
            INSERT INTO sale_order (order_id, branch_id, cashier_id, order_date, total_amount, payment_method, is_service)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }

        $is_service = $is_service ? 1 : 0;
        $query->bind_param("ssssdss", $order_id, $branch_id, $cashier_id, $order_date, $total_amount, $payment_method, $is_service);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Order Added",
                "message" => "Order Added Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to add order: " . $query->error
            ];
        }
    }

    public function addOrderDetail($order_detail_id, $order_id, $product_id, $quantity_sold, $unit_price_at_sale)
    {
        $query = $this->conn->prepare("
            INSERT INTO order_detail (order_detail_id, order_id, product_id, quantity_sold, unit_price_at_sale)
            VALUES (?, ?, ?, ?, ?)
        ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }
        $query->bind_param("sssid", $order_detail_id, $order_id, $product_id, $quantity_sold, $unit_price_at_sale);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Order Detail Added",
                "message" => "Order Detail Added Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to add order detail: " . $query->error
            ];
        }
    }

    public function updateProductStock($product_id, $branch_id, $newStock)
    {

        $query = $this->conn->prepare("
            UPDATE inventory 
            SET stock_level = ?
            WHERE product_id = ? AND branch_id = ?;
        ");

        $query->bind_param("iss", $newStock, $product_id, $branch_id);

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Product Stock Updated",
                "message" => "Product Stock Updated Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to update product stock: " . $query->error
            ];
        }

    }

    public function addGroomingDetail($service_id, $order_id, $groomer_id, $pet_type, $pet_size, $schedule_date)
    {
        $query = $this->conn->prepare("
            INSERT INTO grooming_service (service_id, order_id, groomer_id, pet_type, pet_size, schedule_date)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }
        $query->bind_param("ssssss", $service_id, $order_id, $groomer_id, $pet_type, $pet_size, $schedule_date);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Pet Grooming Detail Added",
                "message" => "Pet Grooming Detail Added Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to add pet grooming detail: " . $query->error
            ];
        }
    }

    public function addBookingDetail($booking_id, $order_id, $pet_type, $room_type, $check_in_date, $check_out_date)
    {
        $query = $this->conn->prepare("
            INSERT INTO pet_hotel_booking (booking_id, order_id, pet_type, room_type, check_in_date, check_out_date)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }
        $query->bind_param("ssssss", $booking_id, $order_id, $pet_type, $room_type, $check_in_date, $check_out_date);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Pet Booking Detail Added",
                "message" => "Pet Booking Detail Added Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to add pet booking detail: " . $query->error
            ];
        }
    }

    public function addStockRequest($transfer_id, $product_id, $sending_branch_id, $receiving_branch_id, $quantity, $transfer_date)
    {
        $query = $this->conn->prepare("
            INSERT INTO stock_transfer (transfer_id, product_id, sending_branch_id, receiving_branch_id, quantity, transfer_date)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }
        $query->bind_param("ssssis", $transfer_id, $product_id, $sending_branch_id, $receiving_branch_id, $quantity, $transfer_date);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Product Stock Requested",
                "message" => "Product Stock Requested And Pending For Manager's Approval"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to add stock request detail: " . $query->error
            ];
        }
    }

    public function addTransferItem($transfer_id, $inventory_id, $quantity)
    {
        $query = $this->conn->prepare("
        INSERT INTO stock_transfer_items (
            transfer_id,
            inventory_id,
            quantity
        )
        VALUES (?, ?, ?)
    ");

        $query->bind_param(
            'ssi',
            $transfer_id,
            $inventory_id,
            $quantity
        );

        return $query->execute();
    }

    public function deductInventoryStock($inventory_id, $quantity)
    {
        $query = $this->conn->prepare("
        UPDATE inventory
        SET stock_level = stock_level - ?
        WHERE inventory_id = ?
    ");

        $query->bind_param(
            'ii',
            $quantity,
            $inventory_id
        );

        return $query->execute();
    }

    public function updateTransferStatus($transfer_id, $status)
    {
        $query = $this->conn->prepare("
        UPDATE stock_transfer
        SET status = ?, approved_date = NOW()
        WHERE transfer_id = ?
    ");

        $query->bind_param('ss', $status, $transfer_id);

        return $query->execute();
    }

    public function completeTransferStatus($transfer_id, $status)
    {
        $query = $this->conn->prepare("
        UPDATE stock_transfer
        SET status = ?, received_date = NOW()
        WHERE transfer_id = ?
    ");

        $query->bind_param('ss', $status, $transfer_id);

        return $query->execute();
    }

    public function addInventory($inventory_id, $branch_id, $product_id, $stock_level, $reorder_point, $last_update_date, $expiry_date, $manufactured_date)
    {
        $query = $this->conn->prepare("
            INSERT INTO inventory (inventory_id, branch_id, product_id, stock_level, reorder_point, last_update_date, expiry_date, manufactured_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }
        $query->bind_param("sssiisss", $inventory_id, $branch_id, $product_id, $stock_level, $reorder_point, $last_update_date, $expiry_date, $manufactured_date);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Product Inventory Added",
                "message" => "Product Inventory Added"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to add product inventory: " . $query->error
            ];
        }
    }

    public function updateInventory($inventory_id, $stock_level, $reorder_point, $last_update_date, $expiry_date, $manufactured_date)
    {
        $query = $this->conn->prepare("
            UPDATE inventory SET stock_level = ?, reorder_point = ?, last_update_date = ?, expiry_date = ?, manufactured_date = ?
            WHERE inventory_id = ?;
        ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }
        $query->bind_param("iissss", $stock_level, $reorder_point, $last_update_date, $expiry_date, $manufactured_date, $inventory_id);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Product Inventory Updated",
                "message" => "Product Inventory Updated"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to update product inventory: " . $query->error
            ];
        }
    }

    public function cancelStockRequest($transfer_id)
    {
        $query = $this->conn->prepare("
        UPDATE stock_transfer 
        SET status = 'Cancelled'
        WHERE transfer_id = ?
    ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }

        $query->bind_param("s", $transfer_id);

        if ($query->execute()) {
            if ($query->affected_rows > 0) {
                return [
                    "status" => "success",
                    "title" => "Request Cancelled",
                    "message" => "The stock request has been successfully cancelled."
                ];
            } else {
                return [
                    "status" => "warning",
                    "title" => "No Changes Made",
                    "message" => "Stock request is already cancelled."
                ];
            }
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to cancel stock request: " . $query->error
            ];
        }
    }

    public function receiveInventoryBatch(
        $product_id,
        $branch_id,
        $manufactured_date,
        $expiry_date,
        $reorder_point,
        $quantity
    ) {
        $query = $this->conn->prepare("
        SELECT inventory_id, stock_level
        FROM inventory
        WHERE product_id = ?
        AND branch_id = ?
        AND manufactured_date <=> ?
        AND expiry_date <=> ?
    ");

        $query->bind_param(
            'iiss',
            $product_id,
            $branch_id,
            $manufactured_date,
            $expiry_date
        );

        $query->execute();

        $result = $query->get_result()->fetch_assoc();

        // Existing batch
        if ($result) {

            $newStock = $result['stock_level'] + $quantity;

            $update = $this->conn->prepare("
            UPDATE inventory
            SET stock_level = ?
            WHERE inventory_id = ?
        ");

            $update->bind_param(
                'ii',
                $newStock,
                $result['inventory_id']
            );

            return $update->execute();
        }

        // Create new batch
        $inventoryId = $this->generateInventoryId();

        $insert = $this->conn->prepare("
    INSERT INTO inventory (
        inventory_id,
        product_id,
        branch_id,
        stock_level,
        reorder_point,
        manufactured_date,
        expiry_date
    )
    VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

        $insert->bind_param(
            'siiiiss',
            $inventoryId,
            $product_id,
            $branch_id,
            $quantity,
            $reorder_point,
            $manufactured_date,
            $expiry_date
        );

        return $insert->execute();
    }

    public function generateInventoryId()
    {
        $count = 0;
        do {
            $prefix = '480';
            $randomDigits = str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
            $barcode = substr($prefix . $randomDigits, 0, 13);

            $check = $this->conn->prepare("SELECT COUNT(*) FROM inventory WHERE inventory_id = ?");
            $check->bind_param("s", $barcode);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();
        } while ($count > 0);

        return $barcode;
    }

    public function completeStockRequest($transfer_id)
    {
        $query = $this->conn->prepare("
        UPDATE stock_transfer 
        SET status = 'Completed'
        WHERE transfer_id = ?
    ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }

        $query->bind_param("s", $transfer_id);

        if ($query->execute()) {
            if ($query->affected_rows > 0) {
                return [
                    "status" => "success",
                    "title" => "Request Completed",
                    "message" => "The stock request has been marked as completed."
                ];
            } else {
                return [
                    "status" => "warning",
                    "title" => "No Changes Made",
                    "message" => "Stock request is already marked as completed."
                ];
            }
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to complete stock request: " . $query->error
            ];
        }
    }

    public function approveStockRequest($transfer_id)
    {
        $query = $this->conn->prepare("
        UPDATE stock_transfer 
        SET status = 'Approved'
        WHERE transfer_id = ?
    ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }

        $query->bind_param("s", $transfer_id);

        if ($query->execute()) {
            if ($query->affected_rows > 0) {
                return [
                    "status" => "success",
                    "title" => "Request Approved",
                    "message" => "The stock request has been approved."
                ];
            } else {
                return [
                    "status" => "warning",
                    "title" => "No Changes Made",
                    "message" => "Stock request is already approved."
                ];
            }
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to approve stock request: " . $query->error
            ];
        }
    }

    public function updateStockRequest($transfer_id, $product_id, $sending_branch_id, $receiving_branch_id, $quantity)
    {
        $query = $this->conn->prepare("
        UPDATE stock_transfer SET
        product_id = ?,
        sending_branch_id = ?,
        receiving_branch_id = ?,
        quantity = ?
        WHERE transfer_id = ?;
        ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }
        $query->bind_param("sssis", $product_id, $sending_branch_id, $receiving_branch_id, $quantity, $transfer_id);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Stock Request Updated",
                "message" => "Stock Request Updated And Pending For Manager's Approval"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to update stock request detail: " . $query->error
            ];
        }
    }

    public function updatePassword($user_id, $newPassword)
    {
        $query = $this->conn->prepare("
        UPDATE user SET
        password = ?
        WHERE user_id = ?;
        ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }
        $query->bind_param("ss", $newPassword, $user_id);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Password Updated",
                "message" => "Password Updated Successfully"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to update password: " . $query->error
            ];
        }
    }

    public function updateProfilePhoto($user_id, $filename)
    {
        $sql = "UPDATE user SET image = ? WHERE user_id = ?";
        $query = $this->conn->prepare($sql);
        $query->bind_param("ss", $filename, $user_id);

        return $query->execute();
    }

    public function addUser($user_id, $branch_id, $username, $password, $role, $first_name, $last_name, $email)
    {
        $sql = "INSERT INTO user (user_id, branch_id, username, password, role, first_name, last_name, email)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $query = $this->conn->prepare($sql);
        $query->bind_param("ssssssss", $user_id, $branch_id, $username, $password, $role, $first_name, $last_name, $email);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "User Added",
                "message" => "User Added Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to add user: " . $query->error
            ];
        }
    }

    public function updateUser($user_id, $branch_id, $username, $role, $first_name, $last_name, $email)
    {
        $sql = "UPDATE user SET branch_id = ?, username = ?, role = ?, first_name = ?, last_name = ?, email = ?
                WHERE user_id = ?";
        $query = $this->conn->prepare($sql);
        $query->bind_param("sssssss", $branch_id, $username, $role, $first_name, $last_name, $email, $user_id);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "User Details Updated",
                "message" => "User Details Updated Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to update user details: " . $query->error
            ];
        }
    }

    public function disableUserAccount($user_id)
    {
        $query = $this->conn->prepare("
        UPDATE user 
        SET is_disabled = 1
        WHERE user_id = ?
    ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }

        $query->bind_param("s", $user_id);

        if ($query->execute()) {
            if ($query->affected_rows > 0) {
                return [
                    "status" => "info",
                    "title" => "Account Disabled",
                    "message" => "User Account Disabled And Won't Be Allowed To Login."
                ];
            } else {
                return [
                    "status" => "warning",
                    "title" => "No Changes Made",
                    "message" => "User Account is already disabled."
                ];
            }
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to disable account: " . $query->error
            ];
        }
    }

    public function enableUserAccount($user_id)
    {
        $query = $this->conn->prepare("
        UPDATE user 
        SET is_disabled = 0
        WHERE user_id = ?
    ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }

        $query->bind_param("s", $user_id);

        if ($query->execute()) {
            if ($query->affected_rows > 0) {
                return [
                    "status" => "info",
                    "title" => "Account Enable",
                    "message" => "User Account Enabled And Will Be Allowed To Login."
                ];
            } else {
                return [
                    "status" => "warning",
                    "title" => "No Changes Made",
                    "message" => "User Account is already enabled."
                ];
            }
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to disable account: " . $query->error
            ];
        }
    }

    public function archiveProduct($product_id)
    {
        $query = $this->conn->prepare("
        UPDATE product 
        SET archived = 1
        WHERE product_id = ?
    ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }

        $query->bind_param("s", $product_id);

        if ($query->execute()) {
            if ($query->affected_rows > 0) {
                return [
                    "status" => "info",
                    "title" => "Product Archived",
                    "message" => "Product Archived, Other Users Will Not Be Able To View This Product."
                ];
            } else {
                return [
                    "status" => "warning",
                    "title" => "No Changes Made",
                    "message" => "Product is already archived."
                ];
            }
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to archive product: " . $query->error
            ];
        }
    }

    public function unarchiveProduct($product_id)
    {
        $query = $this->conn->prepare("
        UPDATE product 
        SET archived = 0
        WHERE product_id = ?
    ");

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Database Error",
                "message" => $this->conn->error
            ];
        }

        $query->bind_param("s", $product_id);

        if ($query->execute()) {
            if ($query->affected_rows > 0) {
                return [
                    "status" => "info",
                    "title" => "Product Unarchived",
                    "message" => "Product Unarchived, Other Users Will Be Able To View This Product Again."
                ];
            } else {
                return [
                    "status" => "warning",
                    "title" => "No Changes Made",
                    "message" => "Product is already unarchived."
                ];
            }
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to archive product: " . $query->error
            ];
        }
    }

    public function addCategory($category)
    {
        $query = $this->conn->prepare("INSERT INTO category (category)
                VALUES (?)");
        $query->bind_param("s", $category);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Category Added",
                "message" => "Category Added Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to add category: " . $query->error
            ];
        }
    }

    public function updateCategory($category, $category_id)
    {
        $query = $this->conn->prepare("UPDATE category SET category = ? WHERE category_id = ?");
        $query->bind_param("ss", $category, $category_id);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Category Updated",
                "message" => "Category Updated Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to update category: " . $query->error
            ];
        }
    }

    public function addSupplier($supplier_id, $supplier, $contact_person, $email, $phone)
    {
        $query = $this->conn->prepare("INSERT INTO supplier (supplier_id, supplier_name, contact_person, email, phone)
                VALUES (?, ?, ?, ?, ?)");
        $query->bind_param("sssss", $supplier_id, $supplier, $contact_person, $email, $phone);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Supplier Added",
                "message" => "Supplier Added Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to add supplier: " . $query->error
            ];
        }
    }

    public function updateSupplier($supplier_id, $supplier, $contact_person, $email, $phone)
    {
        $query = $this->conn->prepare("UPDATE supplier SET 
        supplier_name = ?, contact_person = ?, 
        email = ?, phone = ? WHERE supplier_id = ?");
        $query->bind_param("sssss", $supplier, $contact_person, $email, $phone, $supplier_id, );

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Supplier Details Updated",
                "message" => "Supplier Details Updated Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to update supplier details: " . $query->error
            ];
        }
    }

    public function addBranch($branch_name, $address, $contact_number, $branch_color)
    {
        $query = $this->conn->prepare("INSERT INTO branch (
                branch_name,
                address,
                contact_number,
                branch_color
            )
            VALUES (?, ?, ?, ?)");
        $query->bind_param(
            "ssss",
            $branch_name,
            $address,
            $contact_number,
            $branch_color
        );

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Branch Added",
                "message" => "Branch Added Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to add branch: " . $query->error
            ];
        }
    }

    public function updateBranch($branch_id, $branch_name, $address, $contact_number)
    {
        $query = $this->conn->prepare("UPDATE branch SET branch_name = ?, address = ?, contact_number = ? WHERE branch_id = ?");
        $query->bind_param("ssss", $branch_name, $address, $contact_number, $branch_id);

        if ($query->execute()) {
            return [
                "status" => "success",
                "title" => "Branch Updated",
                "message" => "Branch Updated Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "title" => "Error!",
                "message" => "Failed to update branch: " . $query->error
            ];
        }
    }

    public function storeResetToken($email, $token)
    {
        $delete = $this->conn->prepare(
            "DELETE FROM password_resets WHERE email = ?"
        );
        $delete->bind_param("s", $email);
        $delete->execute();

        $query = $this->conn->prepare(
            "INSERT INTO password_resets (email, token, time_stamp)
         VALUES (?, ?, NOW())"
        );
        $query->bind_param("ss", $email, $token);
        return $query->execute();
    }

    public function deleteResetToken($token)
    {
        $query = $this->conn->prepare("DELETE FROM password_resets WHERE token = ?");
        $query->bind_param("s", $token);
        return $query->execute();
    }

    public function updateUserPasswordByEmail($email, $hashedPassword)
    {
        $query = $this->conn->prepare("UPDATE user SET password = ? WHERE email = ?");
        $query->bind_param("ss", $hashedPassword, $email);

        return $query->execute();
    }




}
