<?php

class helperFunctions extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    public function generateUniqueProductBarcode()
    {
        $count = 0;
        do {
            $prefix = '480';
            $randomDigits = str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
            $barcode = substr($prefix . $randomDigits, 0, 13);

            $check = $this->conn->prepare("SELECT COUNT(*) FROM product WHERE product_id = ?");
            $check->bind_param("s", $barcode);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();
        } while ($count > 0);

        return $barcode;
    }

    public function generateUniqueOrderId()
    {
        $count = 0;
        do {
            $prefix = '480';
            $randomDigits = str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
            $barcode = substr($prefix . $randomDigits, 0, 13);

            $check = $this->conn->prepare("SELECT COUNT(*) FROM sale_order WHERE order_id = ?");
            $check->bind_param("s", $barcode);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();
        } while ($count > 0);

        return $barcode;
    }

    public function generateUniqueGroomingId()
    {
        $count = 0;
        do {
            $prefix = '480';
            $randomDigits = str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
            $barcode = substr($prefix . $randomDigits, 0, 13);

            $check = $this->conn->prepare("SELECT COUNT(*) FROM grooming_service WHERE service_id = ?");
            $check->bind_param("s", $barcode);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();
        } while ($count > 0);

        return $barcode;
    }

    public function generateUniqueBookingId()
    {
        $count = 0;
        do {
            $prefix = '480';
            $randomDigits = str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
            $barcode = substr($prefix . $randomDigits, 0, 13);

            $check = $this->conn->prepare("SELECT COUNT(*) FROM pet_hotel_booking WHERE booking_id = ?");
            $check->bind_param("s", $barcode);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();
        } while ($count > 0);

        return $barcode;
    }

    public function generateUniqueOrderDetailId()
    {
        $count = 0;
        do {
            $prefix = '480';
            $randomDigits = str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
            $barcode = substr($prefix . $randomDigits, 0, 13);

            $check = $this->conn->prepare("SELECT COUNT(*) FROM order_detail WHERE order_detail_id = ?");
            $check->bind_param("s", $barcode);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();
        } while ($count > 0);

        return $barcode;
    }

    public function getProductStock($product_id, $branch_id)
    {
        $query = $this->conn->prepare(
            "SELECT 
                    i.stock_level
                FROM product AS p
                INNER JOIN inventory AS i
                    ON p.product_id = i.product_id
                WHERE 
                i.product_id = ?
                AND
                i.branch_id = ?;
                "
        );
        $query->bind_param('ss', $product_id, $branch_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function sumProductStock($product_id, $branch_id)
    {
        $query = $this->conn->prepare(
            "SELECT 
            SUM(i.stock_level) AS total_stock
        FROM inventory AS i
        WHERE 
            i.product_id = ?
        AND
            i.branch_id = ?"
        );

        $query->bind_param('ss', $product_id, $branch_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getInventoryBatchesForTransfer($product_id, $branch_id)
    {
        $query = $this->conn->prepare("
        SELECT
            inventory_id,
            stock_level,
            expiry_date,
            manufactured_date
        FROM inventory
        WHERE
            product_id = ?
            AND branch_id = ?
            AND stock_level > 0
        ORDER BY
            expiry_date ASC,
            manufactured_date ASC
    ");

        $query->bind_param('ss', $product_id, $branch_id);
        $query->execute();

        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTransferInfo($transfer_id)
    {
        $query = $this->conn->prepare("
        SELECT *
        FROM stock_transfer
        WHERE transfer_id = ?
    ");

        $query->bind_param('s', $transfer_id);
        $query->execute();

        return $query->get_result()->fetch_assoc();
    }

    public function generateUniqueRequestId()
    {
        $count = 0;
        do {
            $prefix = '480';
            $randomDigits = str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
            $barcode = substr($prefix . $randomDigits, 0, 13);

            $check = $this->conn->prepare("SELECT COUNT(*) FROM stock_transfer WHERE transfer_id = ?");
            $check->bind_param("s", $barcode);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();
        } while ($count > 0);

        return $barcode;
    }

    public function checkProductInventory($product_id, $branch_id, $expiryDate)
    {
        $query = $this->conn->prepare(
            "SELECT 
                    COUNT(inventory_id) as count
                FROM inventory
                WHERE
                product_id = ?
                AND
                branch_id = ?
                AND
                expiry_date = ?;
                "
        );
        $query->bind_param('sss', $product_id, $branch_id, $expiryDate);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        return $result['count'];
    }

    public function checkManufacturedInventory($product_id, $branch_id, $manufacturedDate)
    {
        $query = $this->conn->prepare(
            "SELECT 
                    COUNT(inventory_id) as count
                FROM inventory
                WHERE
                product_id = ?
                AND
                branch_id = ?
                AND
                manufactured_date = ?;
                "
        );
        $query->bind_param('sss', $product_id, $branch_id, $manufacturedDate);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        return $result['count'];
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

    public function getInventoryInfo($inventory_id)
    {
        $query = $this->conn->prepare(
            "SELECT 
                    i.stock_level,
                    i.reorder_point,
                    i.expiry_date,
                    i.manufactured_date,
                    p.archived
                    FROM inventory AS i
                    INNER JOIN product p
                    ON p.product_id = i.product_id
                    WHERE i.inventory_id = ?;"
        );
        $query->bind_param('s', $inventory_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getRequestInfo($transfer_id)
    {
        $query = $this->conn->prepare(
            "SELECT
                    t.transfer_id, 
                    p.product_id,
                    p.product_name,
                    p.category,
                    t.quantity,
                    t.sending_branch_id,
                    t.receiving_branch_id,
                    t.transfer_date,
                    t.status,
                    i.stock_level,
                    s.supplier_name,
                    b.branch_name,
                    b.address,
                    b.contact_number
                FROM stock_transfer AS t
                INNER JOIN product AS p 
                    ON t.product_id = p.product_id
                INNER JOIN branch AS b
                    ON t.sending_branch_id = b.branch_id
                INNER JOIN inventory AS i
                    ON i.product_id = t.product_id
                INNER JOIN supplier AS s
                    ON p.supplier_id = s.supplier_id
                WHERE t.transfer_id = ?;
                "
        );
        $query->bind_param('s', $transfer_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getTransferItems($transfer_id)
    {
        $query = $this->conn->prepare("
        SELECT 
            sti.inventory_id,
            sti.quantity,

            i.product_id,
            i.manufactured_date,
            i.expiry_date,
            i.reorder_point

        FROM stock_transfer_items sti

        INNER JOIN inventory i
            ON sti.inventory_id = i.inventory_id

        WHERE sti.transfer_id = ?
    ");

        $query->bind_param('s', $transfer_id);

        $query->execute();

        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getCurrentPassword($user_id)
    {
        $query = $this->conn->prepare(
            "SELECT password FROM user WHERE user_id = ?;"
        );
        $query->bind_param('s', $user_id);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();

        return $result['password'];
    }

    public function getMainCurrentPassword($user_id)
    {
        $query = $this->conn->prepare(
            "SELECT password FROM main WHERE user_id = ?;"
        );
        $query->bind_param('s', $user_id);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();

        return $result['password'];
    }

    public function checkEmail($email)
    {
        $query = $this->conn->prepare(
            "SELECT user_id FROM user WHERE email = ? LIMIT 1"
        );

        $query->bind_param('s', $email);
        $query->execute();
        $result = $query->get_result();

        return $result->num_rows > 0;
    }

    public function checkUsername($username)
    {
        $query = $this->conn->prepare(
            "SELECT user_id FROM user WHERE username = ? LIMIT 1"
        );
        $query->bind_param('s', $username);
        $query->execute();
        $result = $query->get_result();

        return $result->num_rows > 0;
    }

    public function reCheckEmail($email)
    {
        $query = $this->conn->prepare(
            "SELECT user_id FROM user WHERE email = ? LIMIT 2"
        );

        $query->bind_param('s', $email);
        $query->execute();
        $result = $query->get_result();

        return $result->num_rows > 1;
    }

    public function reCheckUsername($username)
    {
        $query = $this->conn->prepare(
            "SELECT user_id FROM user WHERE username = ? LIMIT 2"
        );
        $query->bind_param('s', $username);
        $query->execute();
        $result = $query->get_result();

        return $result->num_rows > 1;
    }

    public function generateUserId()
    {
        $count = 0;
        do {
            $randomDigits = str_pad(mt_rand(0, 99999999999), 11, '0', STR_PAD_LEFT);
            $user_id = substr($randomDigits, 0, 11);

            $check = $this->conn->prepare("SELECT COUNT(*) FROM user WHERE user_id = ?");
            $check->bind_param("s", $user_id);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();
        } while ($count > 0);

        return $user_id;
    }

    public function getUserDetails($user_id)
    {
        $query = $this->conn->prepare(
            "SELECT 
                    u.user_id, u.username, 
                    u.branch_id, u.role, 
                    u.first_name, u.last_name, 
                    u.email, u.image,
                    u.is_disabled AS status, b.branch_name,
                    u.branch_id
                FROM user u
                INNER JOIN branch b
                ON u.branch_id = b.branch_id
                WHERE u.user_id = ?;
                "
        );
        $query->bind_param('s', $user_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getProductDetails($product_id)
    {
        $query = $this->conn->prepare(
            "SELECT 
                    p.product_id,
                    p.product_name,
                    p.category,
                    p.unit_cost,
                    p.selling_price,
                    s.supplier_name,
                    s.supplier_id,
                    p.archived
                FROM product AS p
                INNER JOIN supplier AS s 
                    ON p.supplier_id = s.supplier_id
                WHERE p.product_id = ?;
                "
        );
        $query->bind_param('s', $product_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function checkCategory($category)
    {
        $query = $this->conn->prepare(
            "SELECT category_id FROM category WHERE category = ? LIMIT 1"
        );
        $query->bind_param('s', $category);
        $query->execute();
        $result = $query->get_result();

        return $result->num_rows > 0;
    }

    public function recheckCategory($category)
    {
        $query = $this->conn->prepare(
            "SELECT category_id FROM category WHERE category = ? LIMIT 2"
        );
        $query->bind_param('s', $category);
        $query->execute();
        $result = $query->get_result();

        return $result->num_rows > 1;
    }

    public function getCategoryDetails($category_id)
    {
        $query = $this->conn->prepare(
            "SELECT * FROM category WHERE category_id = ?"
        );
        $query->bind_param('s', $category_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function generateSupplierId()
    {
        $count = 0;
        do {
            $randomDigits = str_pad(mt_rand(0, 99999999999), 11, '0', STR_PAD_LEFT);
            $supplier_id = substr($randomDigits, 0, 11);

            $check = $this->conn->prepare("SELECT COUNT(*) FROM supplier WHERE supplier_id = ?");
            $check->bind_param("s", $supplier_id);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();
        } while ($count > 0);

        return $supplier_id;
    }

    public function getSupplierDetails($supplier_id)
    {
        $query = $this->conn->prepare(
            "SELECT * FROM supplier WHERE supplier_id = ?"
        );
        $query->bind_param('s', $supplier_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getUsedBranchColors()
    {
        $query = $this->conn->prepare("
        SELECT branch_color 
        FROM branch
    ");

        $query->execute();

        $result = $query->get_result();

        $colors = [];

        while ($row = $result->fetch_assoc()) {
            $colors[] = $row['branch_color'];
        }

        return $colors;
    }

    public function getBranchDetails($branch_id)
    {
        $query = $this->conn->prepare(
            "SELECT * FROM branch WHERE branch_id = ?"
        );
        $query->bind_param('s', $branch_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getUserByEmail($email)
    {
        $query = $this->conn->prepare(
            "SELECT user_id, email, username, first_name, last_name FROM user WHERE email = ? LIMIT 1"
        );

        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_assoc();
    }


    public function getMainUserByEmail($email)
    {
        $query = $this->conn->prepare(
            "SELECT user_id, email, username, first_name, last_name FROM main WHERE email = ? LIMIT 1"
        );

        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_assoc();
    }

    public function getResetData($token)
    {
        $query = $this->conn->prepare("SELECT * FROM password_resets WHERE token = ?");
        $query->bind_param("s", $token);
        $query->execute();

        return $query->get_result()->fetch_assoc();
    }

    public function checkBarcode($barcode)
    {
        $query = $this->conn->prepare(
            "SELECT barcode FROM product WHERE barcode = ? LIMIT 1"
        );
        $query->bind_param('s', $barcode);
        $query->execute();
        $result = $query->get_result();

        return $result->num_rows > 0;
    }

    public function recheckBarcode($barcode)
    {
        $query = $this->conn->prepare(
            "SELECT barcode FROM product WHERE barcode = ? LIMIT 2"
        );
        $query->bind_param('s', $barcode);
        $query->execute();
        $result = $query->get_result();

        return $result->num_rows > 1;
    }

}

