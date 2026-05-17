<?php
include 'db.php';
date_default_timezone_set('Asia/Manila');

class fetchClass extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function getProducts()
    {
        $query = $this->conn->prepare(
            "SELECT 
                    p.barcode,
                    p.product_id,
                    p.product_name,
                    p.category,
                    p.unit_cost,
                    p.selling_price,
                    p.archived,
                    p.is_perishable,
                    s.supplier_name
                FROM product AS p
                INNER JOIN supplier AS s 
                    ON p.supplier_id = s.supplier_id
                ORDER BY p.product_name ASC;
                "
        );
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function staffGetProducts()
    {
        $query = $this->conn->prepare(
            "SELECT 
                    p.product_id,
                    p.product_name,
                    p.category,
                    p.unit_cost,
                    p.selling_price,
                    p.archived,
                    p.is_perishable,
                    s.supplier_name
                FROM product AS p
                INNER JOIN supplier AS s 
                    ON p.supplier_id = s.supplier_id
                WHERE p.archived = 0
                ORDER BY p.product_name ASC;
                "
        );
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getSupplierNames()
    {
        $query = $this->conn->prepare("SELECT supplier_id, supplier_name FROM supplier ORDER BY supplier_name ASC");
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getSuppliers()
    {
        $query = $this->conn->prepare("SELECT * FROM supplier ORDER BY supplier_name ASC");
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategories()
    {
        $query = $this->conn->prepare("SELECT category FROM category ORDER BY category ASC");
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAdminCategories()
    {
        $query = $this->conn->prepare("SELECT * FROM category ORDER BY category ASC");
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductDetails($product_id)
    {
        $query = $this->conn->prepare(
            "SELECT 
                    p.barcode,
                    p.product_id,
                    p.product_name,
                    p.category,
                    p.unit_cost,
                    p.selling_price,
                    s.supplier_name,
                    s.supplier_id,
                    p.is_perishable,
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

    public function getProductCount()
    {
        $query = $this->conn->prepare("SELECT COUNT(*) as product_count FROM product");
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getProductCountOnStock($branch_id)
    {
        $query = $this->conn->prepare("SELECT COUNT(*) as product_count FROM inventory WHERE branch_id = ? AND stock_level > 0");
        $query->bind_param('s', $branch_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getGlobalProductCountOnStock()
    {
        $query = $this->conn->prepare("SELECT COUNT(*) as product_count FROM inventory WHERE stock_level > 0");
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getOrderCount($branch_id)
    {
        $query = $this->conn->prepare("SELECT COUNT(*) as order_count FROM sale_order WHERE branch_id = ?");
        $query->bind_param('s', $branch_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getGlobalOrderCount()
    {
        $query = $this->conn->prepare("SELECT COUNT(*) as order_count FROM sale_order");
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getOrderTrend($branch_id)
    {
        $query1 = $this->conn->prepare("
        SELECT COUNT(*) AS recent 
        FROM sale_order 
        WHERE branch_id = ? 
        AND order_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");
        $query1->bind_param('s', $branch_id);
        $query1->execute();
        $recent = $query1->get_result()->fetch_assoc()['recent'];

        $query2 = $this->conn->prepare("
        SELECT COUNT(*) AS previous
        FROM sale_order
        WHERE branch_id = ? 
        AND order_date >= DATE_SUB(CURDATE(), INTERVAL 60 DAY)
        AND order_date < DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");
        $query2->bind_param('s', $branch_id);
        $query2->execute();
        $previous = $query2->get_result()->fetch_assoc()['previous'];

        return [
            "recent" => $recent,
            "previous" => $previous,
        ];
    }

    public function getGlobalOrderTrend()
    {
        $query1 = $this->conn->prepare("
        SELECT COUNT(*) AS recent 
        FROM sale_order 
        WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");
        $query1->execute();
        $recent = $query1->get_result()->fetch_assoc()['recent'];

        $query2 = $this->conn->prepare("
        SELECT COUNT(*) AS previous
        FROM sale_order
        WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 60 DAY)
        AND order_date < DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");
        $query2->execute();
        $previous = $query2->get_result()->fetch_assoc()['previous'];

        return [
            "recent" => $recent,
            "previous" => $previous,
        ];
    }

    public function getAveragePrice($branch_id)
    {
        $query = $this->conn->prepare("
            SELECT AVG(p.selling_price) 
            as avg_price 
            FROM inventory i
            INNER JOIN product p
            ON i.product_id = p.product_id
            WHERE i.branch_id = ?");
        $query->bind_param('s', $branch_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getGlobalAveragePrice()
    {
        $query = $this->conn->prepare("
            SELECT AVG(p.selling_price) 
            as avg_price 
            FROM inventory i
            INNER JOIN product p
            ON i.product_id = p.product_id");
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getUserCount($branch_id)
    {
        $query = $this->conn->prepare("SELECT COUNT(*) as user_count FROM user WHERE branch_id = ?");
        $query->bind_param('s', $branch_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getGlobalUserCount()
    {
        $query = $this->conn->prepare("SELECT COUNT(*) as user_count FROM user");
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getRevenue($branch_id)
    {
        $revenue = [];
        $query = $this->conn->prepare("
            SELECT SUM(total_amount) AS revenue
            FROM sale_order
            WHERE MONTH(order_date) = MONTH(CURRENT_DATE())
            AND YEAR(order_date) = YEAR(CURRENT_DATE())
            AND branch_id = ?
        ");

        $query->bind_param('s', $branch_id);
        $query->execute();
        $currentMonth = $query->get_result()->fetch_assoc();
        $revenue['currentMonth'] = $currentMonth['revenue'] ?? 0;

        $query2 = $this->conn->prepare("
            SELECT SUM(total_amount) AS revenue
            FROM sale_order
            WHERE MONTH(order_date) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
            AND YEAR(order_date) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)
            AND branch_id = ?
        ");

        $query2->bind_param('s', $branch_id);
        $query2->execute();
        $lastMonth = $query2->get_result()->fetch_assoc();
        $revenue['lastMonth'] = $lastMonth['revenue'] ?? 0;

        $query3 = $this->conn->prepare("
            SELECT 
                (
                    -- Product profit
                    IFNULL(SUM((p.selling_price - p.unit_cost) * od.quantity_sold), 0)
                ) +
                (
                    -- Service revenue for the same branch
                    IFNULL((
                        SELECT SUM(so2.total_amount)
                        FROM sale_order so2
                        WHERE so2.is_service = 1
                        AND so2.branch_id = ?
                    ), 0)
                ) AS total_profit
            FROM order_detail od
            JOIN product p ON od.product_id = p.product_id
            JOIN sale_order so ON od.order_id = so.order_id
            WHERE so.is_service = 0
            AND so.branch_id = ?;
        ");

        $query3->bind_param('ss', $branch_id, $branch_id); // 2 parameters

        $query3->execute();
        $total = $query3->get_result()->fetch_assoc();
        $revenue['total'] = $total['total_profit'] ?? 0;

        return $revenue;
    }

    public function getGlobalRevenue()
    {
        $revenue = [];
        $query = $this->conn->prepare("
            SELECT SUM(total_amount) AS revenue
            FROM sale_order
            WHERE MONTH(order_date) = MONTH(CURRENT_DATE())
            AND YEAR(order_date) = YEAR(CURRENT_DATE())
        ");

        $query->execute();
        $currentMonth = $query->get_result()->fetch_assoc();
        $revenue['currentMonth'] = $currentMonth['revenue'] ?? 0;

        $query2 = $this->conn->prepare("
            SELECT SUM(total_amount) AS revenue
            FROM sale_order
            WHERE MONTH(order_date) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
            AND YEAR(order_date) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)
        ");

        $query2->execute();
        $lastMonth = $query2->get_result()->fetch_assoc();
        $revenue['lastMonth'] = $lastMonth['revenue'] ?? 0;

        $query3 = $this->conn->prepare("
            SELECT 
                (
                    -- Product profit
                    IFNULL(SUM((p.selling_price - p.unit_cost) * od.quantity_sold), 0)
                ) +
                (
                    -- Service revenue for the same branch
                    IFNULL((
                        SELECT SUM(so2.total_amount)
                        FROM sale_order so2
                        WHERE so2.is_service = 1
                    ), 0)
                ) AS total_profit
            FROM order_detail od
            JOIN product p ON od.product_id = p.product_id
            JOIN sale_order so ON od.order_id = so.order_id
            WHERE so.is_service = 0
        ");

        $query3->execute();
        $total = $query3->get_result()->fetch_assoc();
        $revenue['total'] = $total['total_profit'] ?? 0;

        return $revenue;
    }

    public function getMonthlyRevenue($branch_id)
    {
        $query = $this->conn->prepare("
        SELECT 
            MONTH(order_date) AS month_number,
            MONTHNAME(order_date) AS month_name,
            SUM(total_amount) AS total_revenue
        FROM sale_order
        WHERE YEAR(order_date) = YEAR(CURRENT_DATE())
        AND branch_id = ?
        GROUP BY MONTH(order_date), MONTHNAME(order_date)
        ORDER BY MONTH(order_date)
    ");
        $query->bind_param('s', $branch_id);
        $query->execute();
        $result = $query->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                "y" => $row['month_name'],
                "a" => (float) number_format($row['total_revenue'], 2, '.', ''),
            ];
        }

        echo json_encode($data);
    }

    public function getGlobalMonthlyRevenue()
    {
        $query = $this->conn->prepare("
        SELECT 
            MONTH(order_date) AS month_number,
            MONTHNAME(order_date) AS month_name,
            SUM(total_amount) AS total_revenue
        FROM sale_order
        WHERE YEAR(order_date) = YEAR(CURRENT_DATE())
        GROUP BY MONTH(order_date), MONTHNAME(order_date)
        ORDER BY MONTH(order_date)
    ");
        $query->execute();
        $result = $query->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                "y" => $row['month_name'],
                "a" => (float) number_format($row['total_revenue'], 2, '.', ''),
            ];
        }

        echo json_encode($data);
    }

    public function getCashierProducts($branch_id)
    {
        $query = $this->conn->prepare(
            "SELECT 
                    p.product_id,
                    p.barcode,
                    p.product_name,
                    p.category,
                    i.stock_level,
                    i.reorder_point,
                    p.unit_cost,
                    p.selling_price,
                    s.supplier_name,
                    i.last_update_date,
                    i.expiry_date
                FROM product AS p
                INNER JOIN supplier AS s 
                    ON p.supplier_id = s.supplier_id
                INNER JOIN inventory AS i
                    ON p.product_id = i.product_id
                WHERE i.branch_id = ?
                ORDER BY p.product_name ASC;
                "
        );
        $query->bind_param('s', $branch_id);
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getGlobalProducts()
    {
        $query = $this->conn->prepare(
            "SELECT 
                    p.product_id,
                    p.barcode,
                    p.product_name,
                    p.category,
                    b.branch_name,
                    i.stock_level,
                    i.reorder_point,
                    p.unit_cost,
                    p.selling_price,
                    s.supplier_name,
                    i.expiry_date,
                    i.manufactured_date
                FROM product AS p
                INNER JOIN supplier AS s 
                    ON p.supplier_id = s.supplier_id
                INNER JOIN inventory AS i
                    ON p.product_id = i.product_id
                INNER JOIN branch AS b
                    ON i.branch_id = b.branch_id
                ORDER BY p.product_name ASC;
                "
        );
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getStaffProducts()
    {
        $query = $this->conn->prepare(
            "SELECT 
                    p.product_id,
                    p.product_name,
                    p.category,
                    i.stock_level,
                    i.reorder_point,
                    p.unit_cost,
                    p.selling_price,
                    s.supplier_name,
                    i.last_update_date,
                    i.expiry_date
                FROM product AS p
                INNER JOIN supplier AS s 
                    ON p.supplier_id = s.supplier_id
                INNER JOIN inventory AS i
                    ON p.product_id = i.product_id
                AND p.archived = 0
                ORDER BY p.product_name ASC;
                "
        );
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getStaffProductsByBranch($branch_id)
    {
        $query = $this->conn->prepare(
            "SELECT 
            p.product_id,
            p.product_name,
            p.category,
            COALESCE(SUM(i.stock_level), 0) AS total_stock,
            p.unit_cost,
            p.selling_price,
            s.supplier_name
        FROM product AS p
        INNER JOIN supplier AS s 
            ON p.supplier_id = s.supplier_id
        INNER JOIN inventory AS i
            ON p.product_id = i.product_id
        WHERE 
            i.branch_id = ?
        AND 
            p.archived = 0
        GROUP BY 
            p.product_id, p.product_name, p.category, 
            p.unit_cost, p.selling_price, s.supplier_name
        ORDER BY p.product_name ASC"
        );

        $query->bind_param('s', $branch_id);
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getCashierOrders($branch_id)
    {
        $query = $this->conn->prepare(
            "SELECT 
                    o.order_id,
                    o.total_amount,
                    o.order_date,
                    u.first_name,
                    u.last_name,
                    o.payment_method,
                    o.is_service
                FROM sale_order AS o
                INNER JOIN user AS u 
                    ON o.cashier_id = u.user_id
                WHERE o.branch_id = ?
                ORDER BY o.order_date DESC;
                "
        );
        $query->bind_param('s', $branch_id);
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getGlobalOrders()
    {
        $query = $this->conn->prepare(
            "SELECT 
                    o.order_id,
                    o.total_amount,
                    o.order_date,
                    o.payment_method,
                    o.is_service,
                    b.branch_name
                FROM sale_order AS o
                INNER JOIN branch AS b
                    ON o.branch_id = b.branch_id
                ORDER BY o.order_date DESC;
                "
        );
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getBranchDetails($branch_id)
    {
        $query = $this->conn->prepare("SELECT * FROM branch WHERE branch_id = ?");
        $query->bind_param('s', $branch_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getGroomerList($branch_id)
    {
        $query = $this->conn->prepare(
            "SELECT 
                    user_id,
                    first_name,
                    last_name
                FROM user
                WHERE branch_id = ?
                ORDER BY last_name ASC;
                "
        );
        $query->bind_param('s', $branch_id);
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrderInfo($order_id)
    {
        $query = $this->conn->prepare(
            "SELECT 
                    o.order_id,
                    o.total_amount,
                    o.order_date,
                    u.first_name,
                    u.last_name,
                    o.payment_method,
                    o.is_service,
                    b.branch_name,
                    b.address,
                    b.contact_number
                FROM sale_order AS o
                INNER JOIN branch AS b
                    ON o.branch_id = b.branch_id
                INNER JOIN user AS u 
                    ON o.cashier_id = u.user_id
                WHERE o.order_id = ?;
                "
        );
        $query->bind_param('s', $order_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getOrderDetails($order_id)
    {
        $query = $this->conn->prepare(
            "SELECT
                    o.product_id,
                    p.barcode,
                    p.product_name,
                    o.quantity_sold,
                    o.unit_price_at_sale,
                    o.unit_price_at_sale * o.quantity_sold AS total_price
                FROM order_detail AS o
                INNER JOIN product AS p 
                    ON o.product_id = p.product_id
                WHERE o.order_id = ?;
                "
        );
        $query->bind_param('s', $order_id);
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getGroomingDetails($order_id)
    {
        $query = $this->conn->prepare(
            "SELECT
                    g.service_id,
                    g.groomer_id,
                    u.first_name,
                    u.last_name,
                    g.pet_type,
                    g.pet_size,
                    g.schedule_date
                FROM grooming_service AS g
                INNER JOIN user AS u
                ON g.groomer_id = u.user_id
                WHERE g.order_id = ?;
                "
        );
        $query->bind_param('s', $order_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getBookingDetails($order_id)
    {
        $query = $this->conn->prepare(
            "SELECT
                    b.booking_id,
                    b.pet_type,
                    b.room_type,
                    b.check_in_date,
                    b.check_out_date
                FROM pet_hotel_booking AS b
                WHERE b.order_id = ?;
                "
        );
        $query->bind_param('s', $order_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getBranches()
    {
        $query = $this->conn->prepare("SELECT * FROM branch");
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getLowStockItems()
    {
        $query = $this->conn->prepare("
        SELECT 
            p.product_id,
            p.product_name,

            COALESCE(SUM(i.stock_level), 0) AS total_stock,

            MAX(i.reorder_point) AS reorder_point,

            b.branch_name,
            b.branch_id

        FROM inventory i

        JOIN product p 
            ON i.product_id = p.product_id

        JOIN branch b 
            ON i.branch_id = b.branch_id

        GROUP BY
            p.product_id,
            p.product_name,
            b.branch_id,
            b.branch_name

        HAVING total_stock <= reorder_point

        ORDER BY total_stock ASC
    ");

        $query->execute();

        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getStockRequestAlert()
    {
        $query = $this->conn->prepare("
        SELECT 
            s.transfer_id,

            p.product_name,

            COALESCE(SUM(i.stock_level), 0) AS total_stock,

            s.quantity,

            b.branch_name,

            s.transfer_date

        FROM stock_transfer s

        JOIN product p 
            ON s.product_id = p.product_id

        JOIN branch b 
            ON s.receiving_branch_id = b.branch_id

        LEFT JOIN inventory i
            ON i.product_id = s.product_id
            AND i.branch_id = s.receiving_branch_id

        WHERE s.status = 'Requested'

        GROUP BY
            s.transfer_id,
            p.product_name,
            s.quantity,
            b.branch_name,
            s.transfer_date

        ORDER BY s.transfer_date DESC
    ");

        $query->execute();

        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getBranchStockRequestAlert($branch_id)
    {
        $query = $this->conn->prepare("
        SELECT 
            p.product_name,
            i.stock_level,
            s.quantity,
            b.branch_name,
            s.transfer_date
        FROM stock_transfer s

        INNER JOIN product p 
            ON s.product_id = p.product_id

        INNER JOIN branch b 
            ON s.sending_branch_id = b.branch_id

        LEFT JOIN inventory i 
            ON i.product_id = s.product_id
            AND i.branch_id = s.receiving_branch_id

        WHERE 
            s.receiving_branch_id = ?
        AND 
            s.status = 'Approved'

        ORDER BY s.transfer_date DESC
    ");

        $query->bind_param('s', $branch_id);
        $query->execute();

        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getInventoryProducts()
    {
        $query = $this->conn->prepare(
            "SELECT
                    i.inventory_id,
                    p.barcode,
                    p.product_id,
                    p.product_name,
                    p.category,
                    i.stock_level,
                    i.reorder_point,
                    p.unit_cost,
                    p.selling_price,
                    s.supplier_name,
                    i.expiry_date,
                    i.manufactured_date,
                    i.branch_id,
                    b.branch_name,
                    p.unit_cost,
                    p.selling_price
                FROM inventory AS i
                INNER JOIN product AS p
                    ON p.product_id = i.product_id
                INNER JOIN supplier AS s 
                    ON p.supplier_id = s.supplier_id
                INNER JOIN branch AS b 
                    ON i.branch_id = b.branch_id
                ORDER BY i.expiry_date ASC;
                "
        );
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getInventoryInfo($inventory_id)
    {
        $query = $this->conn->prepare(
            "SELECT 
                    i.inventory_id, 
                    i.product_id,
                    p.product_name,
                    i.stock_level,
                    i.reorder_point,
                    i.expiry_date,
                    i.manufactured_date,
                    p.is_perishable,
                    i.branch_id,
                    b.branch_name
                    FROM inventory AS i
                    INNER JOIN product AS p
                    ON i.product_id = p.product_id
                    INNER JOIN branch AS b
                    ON b.branch_id = i.branch_id
                    WHERE i.inventory_id = ?;"
        );
        $query->bind_param('s', $inventory_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getStockRequests()
    {
        $query = $this->conn->prepare(
            "SELECT
                    t.transfer_id, 
                    p.product_id,
                    p.product_name,
                    t.quantity,
                    sb.branch_name AS sending_branch,
                    rb.branch_name AS receiving_branch,
                    t.transfer_date,
                    t.status
                FROM stock_transfer AS t
                INNER JOIN product AS p 
                    ON t.product_id = p.product_id
                INNER JOIN branch AS sb
                    ON t.sending_branch_id = sb.branch_id
                INNER JOIN branch AS rb
                    ON t.receiving_branch_id = rb.branch_id
                ORDER BY t.transfer_date DESC;
                "
        );
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getBranchStockTransfer($branch_id)
    {
        $query = $this->conn->prepare(
            "SELECT
                    t.transfer_id, 
                    p.product_id,
                    p.product_name,
                    t.quantity,
                    sb.branch_name AS sending_branch,
                    rb.branch_name AS receiving_branch,
                    t.transfer_date,
                    t.status
                FROM stock_transfer AS t
                INNER JOIN product AS p 
                    ON t.product_id = p.product_id
                INNER JOIN branch AS sb
                    ON t.sending_branch_id = sb.branch_id
                INNER JOIN branch AS rb
                    ON t.receiving_branch_id = rb.branch_id
                WHERE rb.branch_id = ?
                AND t.status = 'Approved'
                ORDER BY t.transfer_date DESC;
                "
        );
        $query->bind_param('s', $branch_id);
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
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

            COALESCE(SUM(i.stock_level), 0) AS total_stock,

            sb.branch_name AS sending_branch,
            rb.branch_name AS receiving_branch,

            t.transfer_date,
            t.status,

            s.supplier_name,

            sb.branch_id AS sending_branch_id,
            sb.address AS sending_address,
            sb.contact_number AS sending_contact,

            rb.branch_id AS receiving_branch_id,
            rb.address AS receiving_address,
            rb.contact_number AS receiving_contact

        FROM stock_transfer AS t

        INNER JOIN product AS p 
            ON t.product_id = p.product_id

        INNER JOIN branch AS sb
            ON t.sending_branch_id = sb.branch_id

        INNER JOIN branch AS rb
            ON t.receiving_branch_id = rb.branch_id

        INNER JOIN inventory AS i
            ON i.product_id = t.product_id
            AND i.branch_id = t.sending_branch_id

        INNER JOIN supplier AS s
            ON p.supplier_id = s.supplier_id

        WHERE t.transfer_id = ?

        GROUP BY
            t.transfer_id,
            p.product_id,
            p.product_name,
            p.category,
            t.quantity,
            sb.branch_name,
            rb.branch_name,
            t.transfer_date,
            t.status,
            s.supplier_name,
            sb.branch_id,
            sb.address,
            sb.contact_number,
            rb.branch_id,
            rb.address,
            rb.contact_number
        "
        );

        $query->bind_param('s', $transfer_id);

        $query->execute();

        return $query->get_result()->fetch_assoc();
    }

    public function getGroomingList()
    {
        $query = $this->conn->prepare(
            "SELECT
                    g.service_id, 
                    g.order_id,
                    u.first_name,
                    u.last_name,
                    g.pet_type,
                    g.pet_size,
                    g.schedule_date,
                    b.branch_name,
                    b.branch_id
                FROM grooming_service AS g
                INNER JOIN sale_order AS o
                    ON o.order_id = g.order_id
                INNER JOIN user AS u
                    ON u.user_id = g.groomer_id
                INNER JOIN branch AS b
                    ON b.branch_id = o.branch_id
                ORDER BY g.schedule_date DESC;
                "
        );
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getBookingList()
    {
        $query = $this->conn->prepare(
            "SELECT
                    h.booking_id, 
                    h.order_id,
                    h.pet_type,
                    h.room_type,
                    h.check_in_date,
                    h.check_out_date,
                    b.branch_name,
                    b.branch_id
                FROM pet_hotel_booking AS h
                INNER JOIN sale_order AS o
                    ON o.order_id = h.order_id
                INNER JOIN branch AS b
                    ON b.branch_id = o.branch_id
                ORDER BY o.order_date DESC;
                "
        );
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getManagerStockRequests()
    {
        $query = $this->conn->prepare(
            "SELECT
            t.transfer_id, 
            p.product_id,
            p.product_name,
            t.quantity,
            sb.branch_name AS sending_branch,
            rb.branch_name AS receiving_branch,
            t.transfer_date,
            t.status
        FROM stock_transfer AS t
        INNER JOIN product AS p 
            ON t.product_id = p.product_id
        INNER JOIN branch AS sb
            ON t.sending_branch_id = sb.branch_id
        INNER JOIN branch AS rb
            ON t.receiving_branch_id = rb.branch_id
        ORDER BY t.transfer_date DESC"
        );

        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getInventoryStatusReport($branch_id, $startDate, $endDate, $filterType)
    {
        $allowedFilters = ['last_update_date', 'expiry_date'];
        if (!in_array($filterType, $allowedFilters)) {
            return [
                "status" => "error",
                "message" => "Invalid filter type"
            ];
        }

        $sql = "
        SELECT 
            i.inventory_id,
            i.branch_id,
            p.product_name,
            p.category,
            i.stock_level,
            i.reorder_point,
            p.unit_cost,
            p.selling_price,
            CASE 
                WHEN i.stock_level = 0 THEN 'No Stock'
                WHEN i.stock_level <= i.reorder_point THEN 'Low Stock'
                ELSE  'Sufficient Stock'
            END AS stock_status,
            DATE_FORMAT(i.last_update_date, '%Y-%m-%d') AS last_update_date,
            DATE_FORMAT(i.expiry_date, '%Y-%m-%d') AS expiry_date
        FROM 
            INVENTORY i
        JOIN 
            PRODUCT p ON i.product_id = p.product_id
        WHERE
            i.branch_id = ? 
            AND i.$filterType BETWEEN ? AND ?
        ORDER BY p.category, p.product_name;
    ";

        $query = $this->conn->prepare($sql);
        if (!$query) {
            return [
                "status" => "error",
                "message" => "Inventory Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("sss", $branch_id, $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "message" => "Inventory Status Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        return [
            "status" => "success",
            "data" => $result
        ];

    }

    public function getGlobalInventoryStatusReport($startDate, $endDate, $filterType)
    {
        $allowedFilters = ['last_update_date', 'expiry_date'];
        if (!in_array($filterType, $allowedFilters)) {
            return [
                "status" => "error",
                "message" => "Invalid filter type"
            ];
        }

        $sql = "
        SELECT 
            i.inventory_id,
            i.branch_id,
            p.product_name,
            p.category,
            i.stock_level,
            i.reorder_point,
            p.unit_cost,
            p.selling_price,
            CASE 
                WHEN i.stock_level = 0 THEN 'No Stock'
                WHEN i.stock_level <= i.reorder_point THEN 'Low Stock'
                ELSE  'Sufficient Stock'
            END AS stock_status,
            DATE_FORMAT(i.last_update_date, '%Y-%m-%d') AS last_update_date,
            DATE_FORMAT(i.expiry_date, '%Y-%m-%d') AS expiry_date
        FROM 
            INVENTORY i
        JOIN 
            PRODUCT p ON i.product_id = p.product_id
        WHERE i.$filterType BETWEEN ? AND ?
        ORDER BY p.category, p.product_name;
    ";

        $query = $this->conn->prepare($sql);
        if (!$query) {
            return [
                "status" => "error",
                "message" => "Inventory Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("ss", $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "message" => "Inventory Status Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        return [
            "status" => "success",
            "data" => $result
        ];

    }

    public function getSalesPerformanceReport($branch_id, $startDate, $endDate)
    {

        $sql = "
        SELECT 
            DATE(order_date) AS date,
            COUNT(order_id) AS total_orders,
            SUM(total_amount) AS total_sales,
            ROUND(AVG(total_amount), 2) AS avg_order_value
        FROM sale_order
        WHERE branch_id = ?
        AND order_date BETWEEN ? AND ?
        GROUP BY DATE(order_date)
        ORDER BY order_date ASC;
    ";

        $query = $this->conn->prepare($sql);
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Sales Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("sss", $branch_id, $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Sales Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Sale Record Found",
                "message" => "No sales records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Sales Report Loaded Successfully",
            "data" => $result
        ];

    }


    public function getGlobalSalesPerformanceReport($startDate, $endDate)
    {

        $sql = "
        SELECT 
            DATE(order_date) AS date,
            COUNT(order_id) AS total_orders,
            SUM(total_amount) AS total_sales,
            ROUND(AVG(total_amount), 2) AS avg_order_value
        FROM sale_order
        WHERE order_date BETWEEN ? AND ?
        GROUP BY DATE(order_date)
        ORDER BY order_date ASC;
    ";

        $query = $this->conn->prepare($sql);
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Sales Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("ss", $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Sales Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Sale Record Found",
                "message" => "No sales records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Sales Report Loaded Successfully",
            "data" => $result
        ];

    }

    public function getTopProducts($branch_id, $startDate, $endDate)
    {
        $sql = "
            SELECT 
                p.product_name,
                SUM(od.quantity_sold) AS total_sold
            FROM order_detail od
            INNER JOIN sale_order so ON so.order_id = od.order_id
            INNER JOIN product p ON p.product_id = od.product_id
            WHERE so.branch_id = ?
            AND so.order_date BETWEEN ? AND ?
            GROUP BY od.product_id
            ORDER BY total_sold DESC
            LIMIT 10";

        $query = $this->conn->prepare($sql);
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Sales Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("sss", $branch_id, $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Sales Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Sale Record Found",
                "message" => "No sales records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Sales Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getGlobalTopProducts($startDate, $endDate)
    {
        $sql = "
            SELECT 
                p.product_name,
                SUM(od.quantity_sold) AS total_sold
            FROM order_detail od
            INNER JOIN sale_order so ON so.order_id = od.order_id
            INNER JOIN product p ON p.product_id = od.product_id
            AND so.order_date BETWEEN ? AND ?
            GROUP BY od.product_id
            ORDER BY total_sold DESC
            LIMIT 10";

        $query = $this->conn->prepare($sql);
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Sales Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("ss", $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Sales Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Sale Record Found",
                "message" => "No sales records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Sales Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getPaymentMethodBreakdown($branch_id, $startDate, $endDate)
    {
        $sql = "
        SELECT 
            payment_method, COUNT(*) AS total_orders, 
            SUM(total_amount) AS total_sales
        FROM sale_order
        WHERE branch_id = ?
        AND order_date BETWEEN ? AND ?
        GROUP BY payment_method
    ";

        $query = $this->conn->prepare($sql);
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Sales Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("sss", $branch_id, $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Sales Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Sale Record Found",
                "message" => "No sales records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Sales Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getGlobalPaymentMethodBreakdown($startDate, $endDate)
    {
        $sql = "
        SELECT 
            payment_method, COUNT(*) AS total_orders, 
            SUM(total_amount) AS total_sales
        FROM sale_order
        WHERE order_date BETWEEN ? AND ?
        GROUP BY payment_method
    ";

        $query = $this->conn->prepare($sql);
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Sales Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("ss", $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Sales Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Sale Record Found",
                "message" => "No sales records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Sales Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getCategoryBreakdown($branch_id, $startDate, $endDate)
    {
        $sql = "
        SELECT 
            p.category,
            SUM(od.quantity_sold) AS total_sold
        FROM order_detail od
        INNER JOIN sale_order so ON so.order_id = od.order_id
        INNER JOIN product p ON p.product_id = od.product_id
        WHERE so.branch_id = ?
        AND so.order_date BETWEEN ? AND ?
        GROUP BY p.category
    ";

        $query = $this->conn->prepare($sql);
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Sales Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("sss", $branch_id, $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Sales Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Sale Record Found",
                "message" => "No sales records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Sales Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getGlobalCategoryBreakdown($startDate, $endDate)
    {
        $sql = "
        SELECT 
            p.category,
            SUM(od.quantity_sold) AS total_sold
        FROM order_detail od
        INNER JOIN sale_order so ON so.order_id = od.order_id
        INNER JOIN product p ON p.product_id = od.product_id
        AND so.order_date BETWEEN ? AND ?
        GROUP BY p.category
    ";

        $query = $this->conn->prepare($sql);
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Sales Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("ss", $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Sales Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Sale Record Found",
                "message" => "No sales records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Sales Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getMostTransferredProducts($branch_id, $startDate, $endDate)
    {
        $sql = "
        SELECT 
            p.product_name,
            SUM(st.quantity) AS total_transferred
        FROM stock_transfer st
        JOIN product p ON st.product_id = p.product_id
        WHERE st.transfer_date BETWEEN ? AND ?
        AND sending_branch_id = ?
        AND st.status = 'Completed'
        GROUP BY st.product_id
        ORDER BY total_transferred DESC
        LIMIT 10;
    ";

        $query = $this->conn->prepare($sql);
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Transfer Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("sss", $startDate, $endDate, $branch_id);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Transfer Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Sale Record Found",
                "message" => "No sales records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Transfer Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getGlobalMostTransferredProducts($startDate, $endDate)
    {
        $sql = "
        SELECT 
            p.product_name,
            SUM(st.quantity) AS total_transferred
        FROM stock_transfer st
        JOIN product p ON st.product_id = p.product_id
        WHERE st.transfer_date BETWEEN ? AND ?
        AND st.status = 'Completed'
        GROUP BY st.product_id
        ORDER BY total_transferred DESC
        LIMIT 10;
    ";

        $query = $this->conn->prepare($sql);
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Transfer Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("ss", $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Transfer Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Sale Record Found",
                "message" => "No sales records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Transfer Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getTransferCostValue($branch_id, $startDate, $endDate)
    {
        $sql = "
        SELECT
            p.product_name,
            SUM(st.quantity) AS total_quantity,
            SUM(st.quantity * p.unit_cost) AS total_cost_value,
            SUM(st.quantity * p.selling_price) AS total_sales_value,
            SUM(st.quantity * (p.selling_price - p.unit_cost)) AS total_potential_profit
        FROM stock_transfer st
        JOIN product p ON st.product_id = p.product_id
        WHERE st.transfer_date BETWEEN ? AND ?
        AND st.sending_branch_id = ?
        AND st.status = 'Completed'
        GROUP BY st.product_id
        ORDER BY total_quantity DESC
        LIMIT 10;
    ";

        $query = $this->conn->prepare($sql);
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Transfer Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("sss", $startDate, $endDate, $branch_id);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Transfer Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Sale Record Found",
                "message" => "No sales records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Transfer Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getGlobalTransferCostValue($startDate, $endDate)
    {
        $sql = "
        SELECT
            p.product_name,
            SUM(st.quantity) AS total_quantity,
            SUM(st.quantity * p.unit_cost) AS total_cost_value,
            SUM(st.quantity * p.selling_price) AS total_sales_value,
            SUM(st.quantity * (p.selling_price - p.unit_cost)) AS total_potential_profit
        FROM stock_transfer st
        JOIN product p ON st.product_id = p.product_id
        WHERE st.transfer_date BETWEEN ? AND ?
        AND st.status = 'Completed'
        GROUP BY st.product_id
        ORDER BY total_quantity DESC
        LIMIT 10;
    ";

        $query = $this->conn->prepare($sql);
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Transfer Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("ss", $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Transfer Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Sale Record Found",
                "message" => "No sales records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Transfer Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getTransferStatus($branch_id, $startDate, $endDate)
    {
        $sql = "
        SELECT 
            status,
            COUNT(*) AS total_transfers
        FROM stock_transfer
        WHERE transfer_date BETWEEN ? AND ?
        AND sending_branch_id = ?
        GROUP BY status;
    ";

        $query = $this->conn->prepare($sql);
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Transfer Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("sss", $startDate, $endDate, $branch_id);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Transfer Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Sale Record Found",
                "message" => "No sales records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Transfer Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getGlobalTransferStatus($startDate, $endDate)
    {
        $sql = "
        SELECT 
            status,
            COUNT(*) AS total_transfers
        FROM stock_transfer
        WHERE transfer_date BETWEEN ? AND ?
        GROUP BY status;
    ";

        $query = $this->conn->prepare($sql);
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Transfer Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("ss", $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Transfer Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Sale Record Found",
                "message" => "No sales records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Transfer Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getTransferTrend($branch_id, $startDate, $endDate)
    {
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        $diffDays = $start->diff($end)->days;

        if ($diffDays <= 31) {
            $groupFormat = "%Y-%m-%d";
            $labelFormat = "%b %d, %Y";
        } elseif ($diffDays <= 365) {
            $groupFormat = "%Y-%m";
            $labelFormat = "%M %Y";
        } else {
            $groupFormat = "%Y";
            $labelFormat = "%Y";
        }

        $sql = "
        SELECT 
            DATE_FORMAT(st.transfer_date, '$groupFormat') AS period,
            DATE_FORMAT(st.transfer_date, '$labelFormat') AS period_label,
            SUM(st.quantity) AS total_transfers
        FROM stock_transfer st
        WHERE st.transfer_date BETWEEN ? AND ?
        AND st.sending_branch_id = ?
        AND st.status = 'Completed'
        GROUP BY DATE_FORMAT(st.transfer_date, '$groupFormat')
        ORDER BY period;
    ";

        $query = $this->conn->prepare($sql);

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Transfer Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("sss", $startDate, $endDate, $branch_id);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Transfer Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Transfer Record Found",
                "message" => "No transfer records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Transfer Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getGlobalTransferTrend($startDate, $endDate)
    {
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        $diffDays = $start->diff($end)->days;

        if ($diffDays <= 31) {
            $groupFormat = "%Y-%m-%d";
            $labelFormat = "%b %d, %Y";
        } elseif ($diffDays <= 365) {
            $groupFormat = "%Y-%m";
            $labelFormat = "%M %Y";
        } else {
            $groupFormat = "%Y";
            $labelFormat = "%Y";
        }

        $sql = "
        SELECT 
            DATE_FORMAT(st.transfer_date, '$groupFormat') AS period,
            DATE_FORMAT(st.transfer_date, '$labelFormat') AS period_label,
            SUM(st.quantity) AS total_transfers
        FROM stock_transfer st
        WHERE st.transfer_date BETWEEN ? AND ?
        AND st.status = 'Completed'
        GROUP BY DATE_FORMAT(st.transfer_date, '$groupFormat')
        ORDER BY period;
    ";

        $query = $this->conn->prepare($sql);

        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Transfer Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("ss", $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Transfer Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Transfer Record Found",
                "message" => "No transfer records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Transfer Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getGroomingReport($branch_id, $startDate, $endDate)
    {
        $query = $this->conn->prepare(
            "SELECT
                    g.service_id, 
                    g.order_id,
                    u.first_name,
                    u.last_name,
                    g.pet_type,
                    g.pet_size,
                    g.schedule_date
                FROM grooming_service AS g
                INNER JOIN sale_order AS o
                    ON o.order_id = g.order_id
                INNER JOIN user AS u
                    ON u.user_id = g.groomer_id
                WHERE o.branch_id = ?
                AND o.order_date BETWEEN ? AND ?
                ORDER BY g.schedule_date DESC;
                "
        );
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Grooming Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("sss", $branch_id, $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Grooming Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Pet Grooming Record Found",
                "message" => "No Pet Grooming records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Grooming Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getGlobalGroomingReport($startDate, $endDate)
    {
        $query = $this->conn->prepare(
            "SELECT
                    g.service_id, 
                    g.order_id,
                    u.first_name,
                    u.last_name,
                    g.pet_type,
                    g.pet_size,
                    g.schedule_date
                FROM grooming_service AS g
                INNER JOIN sale_order AS o
                    ON o.order_id = g.order_id
                INNER JOIN user AS u
                    ON u.user_id = g.groomer_id
                AND o.order_date BETWEEN ? AND ?
                ORDER BY g.schedule_date DESC;
                "
        );
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Grooming Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("ss", $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Grooming Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Pet Grooming Record Found",
                "message" => "No Pet Grooming records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Grooming Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getGroomingCount($branch_id, $startDate, $endDate)
    {
        $query = $this->conn->prepare(
            "SELECT
                    COUNT(g.service_id) AS total_grooming
                FROM grooming_service AS g
                INNER JOIN sale_order AS o
                    ON o.order_id = g.order_id
                WHERE o.branch_id = ?
                AND o.order_date BETWEEN ? AND ?;
                "
        );
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Grooming Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("sss", $branch_id, $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Grooming Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_assoc();

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Pet Grooming Record Found",
                "message" => "No Pet Grooming records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Grooming Report Loaded Successfully",
            "data" => $result['total_grooming']
        ];
    }

    public function getGlobalGroomingCount($startDate, $endDate)
    {
        $query = $this->conn->prepare(
            "SELECT
                    COUNT(g.service_id) AS total_grooming
                FROM grooming_service AS g
                INNER JOIN sale_order AS o
                    ON o.order_id = g.order_id
                AND o.order_date BETWEEN ? AND ?;
                "
        );
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Grooming Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("ss", $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Grooming Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_assoc();

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Pet Grooming Record Found",
                "message" => "No Pet Grooming records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Grooming Report Loaded Successfully",
            "data" => $result['total_grooming']
        ];
    }

    public function getGroomingPetCount($branch_id, $startDate, $endDate)
    {
        $query = $this->conn->prepare(
            "SELECT
                    COUNT(DISTINCT g.pet_type) AS total_pet
                FROM grooming_service AS g
                INNER JOIN sale_order AS o
                    ON o.order_id = g.order_id
                WHERE o.branch_id = ?
                AND o.order_date BETWEEN ? AND ?;
                "
        );
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Grooming Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("sss", $branch_id, $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Grooming Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_assoc();

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Pet Grooming Record Found",
                "message" => "No Pet Grooming records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Grooming Report Loaded Successfully",
            "data" => $result['total_pet']
        ];
    }

    public function getGlobalGroomingPetCount($startDate, $endDate)
    {
        $query = $this->conn->prepare(
            "SELECT
                    COUNT(DISTINCT g.pet_type) AS total_pet
                FROM grooming_service AS g
                INNER JOIN sale_order AS o
                    ON o.order_id = g.order_id
                AND o.order_date BETWEEN ? AND ?;
                "
        );
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Grooming Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("ss", $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Grooming Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_assoc();

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Pet Grooming Record Found",
                "message" => "No Pet Grooming records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Grooming Report Loaded Successfully",
            "data" => $result['total_pet']
        ];
    }

    public function getBookingReport($branch_id, $startDate, $endDate)
    {
        $query = $this->conn->prepare(
            "SELECT
                    h.booking_id, 
                    h.order_id,
                    h.pet_type,
                    h.room_type,
                    h.check_in_date,
                    h.check_out_date
                FROM pet_hotel_booking AS h
                INNER JOIN sale_order AS o
                    ON o.order_id = h.order_id
                WHERE o.branch_id = ?
                AND o.order_date BETWEEN ? AND ?
                ORDER BY o.order_date DESC;
                "
        );
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Hotel Booking Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("sss", $branch_id, $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Hotel Booking Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Pet Hotel Booking Record Found",
                "message" => "No Pet Hotel Booking records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Pet Hotel Booking Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getGlobalBookingReport($startDate, $endDate)
    {
        $query = $this->conn->prepare(
            "SELECT
                    h.booking_id, 
                    h.order_id,
                    h.pet_type,
                    h.room_type,
                    h.check_in_date,
                    h.check_out_date
                FROM pet_hotel_booking AS h
                INNER JOIN sale_order AS o
                    ON o.order_id = h.order_id
                AND o.order_date BETWEEN ? AND ?
                ORDER BY o.order_date DESC;
                "
        );
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Hotel Booking Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("ss", $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Hotel Booking Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Pet Hotel Booking Record Found",
                "message" => "No Pet Hotel Booking records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Pet Hotel Booking Report Loaded Successfully",
            "data" => $result
        ];
    }

    public function getBookingCount($branch_id, $startDate, $endDate)
    {
        $query = $this->conn->prepare(
            "SELECT
                    COUNT(h.booking_id) AS total_booking
                FROM pet_hotel_booking AS h
                INNER JOIN sale_order AS o
                    ON o.order_id = h.order_id
                WHERE o.branch_id = ?
                AND o.order_date BETWEEN ? AND ?;
                "
        );
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Hotel Booking Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("sss", $branch_id, $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Hotel Booking Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_assoc();

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Pet Hotel Booking Record Found",
                "message" => "No Pet Hotel Booking records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Pet Hotel Booking Report Loaded Successfully",
            "data" => $result['total_booking']
        ];
    }

    public function getGlobalBookingCount($startDate, $endDate)
    {
        $query = $this->conn->prepare(
            "SELECT
                    COUNT(h.booking_id) AS total_booking
                FROM pet_hotel_booking AS h
                INNER JOIN sale_order AS o
                    ON o.order_id = h.order_id
                AND o.order_date BETWEEN ? AND ?;
                "
        );
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Hotel Booking Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("ss", $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Hotel Booking Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_assoc();

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Pet Hotel Booking Record Found",
                "message" => "No Pet Hotel Booking records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Pet Hotel Booking Report Loaded Successfully",
            "data" => $result['total_booking']
        ];
    }

    public function getBookingPetCount($branch_id, $startDate, $endDate)
    {
        $query = $this->conn->prepare(
            "SELECT
                    COUNT(DISTINCT h.pet_type) AS total_pet
                FROM pet_hotel_booking AS h
                INNER JOIN sale_order AS o
                    ON o.order_id = h.order_id
                WHERE o.branch_id = ?
                AND o.order_date BETWEEN ? AND ?;
                "
        );
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Hotel Booking Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("sss", $branch_id, $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Hotel Booking Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_assoc();

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Pet Hotel Booking Record Found",
                "message" => "No Pet Hotel Booking records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Pet Hotel Booking Report Loaded Successfully",
            "data" => $result['total_pet']
        ];
    }

    public function getGlobalBookingPetCount($startDate, $endDate)
    {
        $query = $this->conn->prepare(
            "SELECT
                    COUNT(DISTINCT h.pet_type) AS total_pet
                FROM pet_hotel_booking AS h
                INNER JOIN sale_order AS o
                    ON o.order_id = h.order_id
                AND o.order_date BETWEEN ? AND ?;
                "
        );
        if (!$query) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Hotel Booking Report Query Failed: " . $this->conn->error
            ];
        }

        $query->bind_param("ss", $startDate, $endDate);

        if (!$query->execute()) {
            return [
                "status" => "error",
                "title" => "Error",
                "message" => "Pet Hotel Booking Report Fetching Failed: " . $query->error
            ];
        }

        $result = $query->get_result()->fetch_assoc();

        if (empty($result)) {
            return [
                "status" => "info",
                "title" => "No Pet Hotel Booking Record Found",
                "message" => "No Pet Hotel Booking records found within the selected date range.",
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "title" => "Success",
            "message" => "Pet Hotel Booking Report Loaded Successfully",
            "data" => $result['total_pet']
        ];
    }

    public function getTop5Products($branch_id)
    {
        $sql = "
            SELECT 
                p.product_id,
                p.product_name,
                SUM(od.quantity_sold) AS total_sold,
                p.selling_price
            FROM order_detail od
            INNER JOIN sale_order so ON so.order_id = od.order_id
            INNER JOIN product p ON p.product_id = od.product_id
            WHERE so.branch_id = ?
            GROUP BY od.product_id
            ORDER BY total_sold DESC
            LIMIT 5";

        $query = $this->conn->prepare($sql);

        $query->bind_param("s", $branch_id);

        $query->execute();

        return $query->get_result()->fetch_all(MYSQLI_ASSOC);

    }

    public function getGlobalTop5Products()
    {
        $sql = "
            SELECT 
                p.product_id,
                p.product_name,
                SUM(od.quantity_sold) AS total_sold,
                p.selling_price
            FROM order_detail od
            INNER JOIN sale_order so ON so.order_id = od.order_id
            INNER JOIN product p ON p.product_id = od.product_id
            GROUP BY od.product_id
            ORDER BY total_sold DESC
            LIMIT 5";

        $query = $this->conn->prepare($sql);


        $query->execute();

        return $query->get_result()->fetch_all(MYSQLI_ASSOC);

    }

    public function getMostExpensiveProducts($branch_id)
    {
        $sql = "
            SELECT 
                p.product_id,
                p.product_name,
                p.selling_price
            FROM inventory i
            INNER JOIN product p ON p.product_id = i.product_id
            WHERE i.branch_id = ?
            GROUP BY p.product_id
            ORDER BY p.selling_price DESC
            LIMIT 5";

        $query = $this->conn->prepare($sql);

        $query->bind_param("s", $branch_id);

        $query->execute();

        return $query->get_result()->fetch_all(MYSQLI_ASSOC);

    }

    public function getGlobalMostExpensiveProducts()
    {
        $sql = "
            SELECT 
                p.product_id,
                p.product_name,
                p.selling_price
            FROM inventory i
            INNER JOIN product p ON p.product_id = i.product_id
            GROUP BY p.product_id
            ORDER BY p.selling_price DESC
            LIMIT 5";

        $query = $this->conn->prepare($sql);

        $query->execute();

        return $query->get_result()->fetch_all(MYSQLI_ASSOC);

    }

    public function getOrdersByMonth($branch_id, $user_id)
    {
        $sql = "
        SELECT
            YEAR(order_date) AS year,
            MONTH(order_date) AS month,
            COUNT(*) AS order_count
        FROM SALE_ORDER
        WHERE branch_id = ?
        AND cashier_id = ?
        AND order_date >= DATE_SUB(CURDATE(), INTERVAL 5 YEAR)
        GROUP BY YEAR(order_date), MONTH(order_date)
        ORDER BY YEAR(order_date), MONTH(order_date)
    ";

        $query = $this->conn->prepare($sql);
        $query->bind_param("ss", $branch_id, $user_id);
        $query->execute();
        $result = $query->get_result();

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $year = $row["year"];
            $month = $row["month"];
            $count = $row["order_count"];

            if (!isset($data[$year])) {
                $data[$year] = array_fill(1, 12, 0); // months 1–12
            }

            $data[$year][$month] = (int) $count;
        }

        return $data;
    }

    public function getGlobalBranchOrdersByMonth()
    {
        $sql = "
        SELECT
            YEAR(order_date) AS year,
            MONTH(order_date) AS month,
            COUNT(*) AS order_count
        FROM SALE_ORDER
        WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 5 YEAR)
        GROUP BY YEAR(order_date), MONTH(order_date)
        ORDER BY YEAR(order_date), MONTH(order_date)
    ";

        $query = $this->conn->prepare($sql);
        $query->execute();
        $result = $query->get_result();

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $year = $row["year"];
            $month = $row["month"];
            $count = $row["order_count"];

            if (!isset($data[$year])) {
                $data[$year] = array_fill(1, 12, 0); // months 1–12
            }

            $data[$year][$month] = (int) $count;
        }

        return $data;
    }
    public function getLocalBranchOrdersByMonth($branch_id)
    {
        $sql = "
        SELECT
            YEAR(order_date) AS year,
            MONTH(order_date) AS month,
            COUNT(*) AS order_count
        FROM SALE_ORDER
        WHERE branch_id = ?
        AND order_date >= DATE_SUB(CURDATE(), INTERVAL 5 YEAR)
        GROUP BY YEAR(order_date), MONTH(order_date)
        ORDER BY YEAR(order_date), MONTH(order_date)
    ";

        $query = $this->conn->prepare($sql);
        $query->bind_param("s", $branch_id);
        $query->execute();
        $result = $query->get_result();

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $year = $row["year"];
            $month = $row["month"];
            $count = $row["order_count"];

            if (!isset($data[$year])) {
                $data[$year] = array_fill(1, 12, 0); // months 1–12
            }

            $data[$year][$month] = (int) $count;
        }

        return $data;
    }

    public function getGlobalOrdersByMonth($user_id)
    {
        $sql = "
        SELECT
            YEAR(order_date) AS year,
            MONTH(order_date) AS month,
            COUNT(*) AS order_count
        FROM SALE_ORDER
        WHERE cashier_id = ?
        AND order_date >= DATE_SUB(CURDATE(), INTERVAL 5 YEAR)
        GROUP BY YEAR(order_date), MONTH(order_date)
        ORDER BY YEAR(order_date), MONTH(order_date)
    ";

        $query = $this->conn->prepare($sql);
        $query->bind_param("ss", $branch_id, $user_id);
        $query->execute();
        $result = $query->get_result();

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $year = $row["year"];
            $month = $row["month"];
            $count = $row["order_count"];

            if (!isset($data[$year])) {
                $data[$year] = array_fill(1, 12, 0); // months 1–12
            }

            $data[$year][$month] = (int) $count;
        }

        return $data;
    }

    public function getSaleStats($branch_id, $user_id)
    {
        $sql = "
        SELECT
            COUNT(order_id) AS total_orders,
            SUM(total_amount) AS total_amount
        FROM sale_order
        WHERE branch_id = ?
        AND cashier_id = ?
    ";

        $query = $this->conn->prepare($sql);
        $query->bind_param("ss", $branch_id, $user_id);
        $query->execute();
        $orderData = $query->get_result()->fetch_assoc();

        $sql2 = "
        SELECT
            COUNT(service_id) AS total_grooming
        FROM grooming_service
        WHERE groomer_id = ?
    ";

        $query2 = $this->conn->prepare($sql2);
        $query2->bind_param("s", $user_id);
        $query2->execute();
        $groomingData = $query2->get_result()->fetch_assoc();

        return [
            "status" => "success",
            "total_orders" => $orderData['total_orders'],
            "total_amount" => $orderData['total_amount'] ?? '0.00',
            "total_grooming" => $groomingData['total_grooming']
        ];

    }


    public function getAdminSaleStats($branch_id)
    {
        $sql = "
        SELECT
            COUNT(order_id) AS total_orders,
            SUM(total_amount) AS total_amount
        FROM sale_order
        WHERE branch_id = ?
    ";

        $query = $this->conn->prepare($sql);
        $query->bind_param("s", $branch_id);
        $query->execute();
        $orderData = $query->get_result()->fetch_assoc();

        $sql2 = "
        SELECT
            COUNT(user_id) AS total_cashier
        FROM user
        WHERE branch_id = ?
        AND role = 'Cashier'
    ";

        $query2 = $this->conn->prepare($sql2);
        $query2->bind_param("s", $branch_id);
        $query2->execute();
        $cashierData = $query2->get_result()->fetch_assoc();

        $sql3 = "
        SELECT
            COUNT(product_id) AS total_products
        FROM product
    ";

        $query3 = $this->conn->prepare($sql3);
        $query3->execute();
        $productData = $query3->get_result()->fetch_assoc();

        return [
            "status" => "success",
            "total_orders" => $orderData['total_orders'],
            "total_amount" => $orderData['total_amount'] ?? '0.00',
            "total_cashier" => $cashierData['total_cashier'],
            "total_products" => $productData['total_products']
        ];

    }

    public function getGlobalBranchStats()
    {
        $sql = "
        SELECT
            COUNT(order_id) AS total_orders,
            SUM(total_amount) AS total_amount
        FROM sale_order
    ";

        $query = $this->conn->prepare($sql);
        $query->execute();
        $orderData = $query->get_result()->fetch_assoc();

        $sql2 = "
        SELECT
            COUNT(transfer_id) AS total_completed
        FROM stock_transfer
        WHERE status = 'Completed'
    ";

        $query2 = $this->conn->prepare($sql2);
        $query2->execute();
        $completeData = $query2->get_result()->fetch_assoc();

        $sql3 = "
        SELECT
            COUNT(transfer_id) AS total_approved
        FROM stock_transfer
        WHERE status = 'Approved'
    ";

        $query3 = $this->conn->prepare($sql3);
        $query3->execute();
        $approvedData = $query3->get_result()->fetch_assoc();

        $sql4 = "
        SELECT
            COUNT(transfer_id) AS total_requested
        FROM stock_transfer
        WHERE status = 'Requested'
    ";

        $query4 = $this->conn->prepare($sql4);
        $query4->execute();
        $requestedData = $query4->get_result()->fetch_assoc();

        return [
            "status" => "success",
            "total_orders" => $orderData['total_orders'],
            "total_amount" => $orderData['total_amount'] ?? '0.00',
            "total_completed" => $completeData['total_completed'],
            "total_approved" => $approvedData['total_approved'],
            "total_requested" => $requestedData['total_requested']
        ];

    }

    public function getStaffBranchStats()
    {
        $sql = "
        SELECT
            COUNT(order_id) AS total_orders,
            SUM(total_amount) AS total_amount
        FROM sale_order
    ";

        $query = $this->conn->prepare($sql);
        $query->execute();
        $orderData = $query->get_result()->fetch_assoc();

        $sql2 = "
        SELECT
            COUNT(product_id) AS total_products
        FROM product
    ";

        $query2 = $this->conn->prepare($sql2);
        $query2->execute();
        $productData = $query2->get_result()->fetch_assoc();

        $sql3 = "
        SELECT
            COUNT(inventory_id) AS total_inventory
        FROM inventory
        WHERE stock_level > 0
    ";

        $query3 = $this->conn->prepare($sql3);
        $query3->execute();
        $inventoryData = $query3->get_result()->fetch_assoc();

        $sql4 = "
        SELECT
            COUNT(transfer_id) AS total_requested
        FROM stock_transfer
        WHERE status = 'Requested'
    ";

        $query4 = $this->conn->prepare($sql4);
        $query4->execute();
        $requestedData = $query4->get_result()->fetch_assoc();


        $sql5 = "
        SELECT
            COUNT(inventory_id) AS total_stock
        FROM inventory
        WHERE stock_level > reorder_point
    ";

        $query5 = $this->conn->prepare($sql5);
        $query5->execute();
        $stockData = $query5->get_result()->fetch_assoc();

        return [
            "status" => "success",
            "total_orders" => $orderData['total_orders'],
            "total_amount" => $orderData['total_amount'] ?? '0.00',
            "total_requested" => $requestedData['total_requested'],
            "total_products" => $productData['total_products'],
            "total_inventory" => $inventoryData['total_inventory'],
            "total_stock" => $stockData['total_stock']
        ];

    }

    public function getUsers()
    {

        $query = $this->conn->prepare(
            "SELECT 
                        u.user_id, u.username, 
                        u.branch_id, u.role, 
                        u.first_name, u.last_name, 
                        u.email, u.image,
                        u.is_disabled AS status, b.branch_name
                    FROM user u
                    INNER JOIN branch b
                    ON u.branch_id = b.branch_id
                    ORDER BY u.last_name ASC
                    "
        );
        $query->execute();

        return $query->get_result()->fetch_all(MYSQLI_ASSOC);

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

    public function checkUserStatus($user_id)
    {
        $query = $this->conn->prepare(
            "SELECT 
                    u.is_disabled AS status
                FROM user u
                WHERE u.user_id = ?;
                "
        );
        $query->bind_param('s', $user_id);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        return $result['status'];
    }

    public function checkMainUserStatus($user_id)
    {
        $query = $this->conn->prepare(
            "SELECT 
                    u.is_disabled AS status
                FROM main u
                WHERE u.user_id = ?;
                "
        );
        $query->bind_param('s', $user_id);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        return $result['status'];
    }

    public function getCategoryDetails($category_id)
    {
        $query = $this->conn->prepare("SELECT * FROM category WHERE category_id = ?");
        $query->bind_param('s', $category_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
        ;
    }

    public function getSupplierDetails($supplier_id)
    {
        $query = $this->conn->prepare("SELECT * FROM supplier WHERE supplier_id = ?");
        $query->bind_param('s', $supplier_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getRequestCount($branch_id)
    {
        $query = $this->conn->prepare("SELECT COUNT(*) as request_count FROM stock_transfer WHERE sending_branch_id = ? OR receiving_branch_id = ? AND status = 'Completed'");
        $query->bind_param('ss', $branch_id, $branch_id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getGlobalRequestCount()
    {
        $query = $this->conn->prepare("SELECT COUNT(*) as request_count FROM stock_transfer WHERE status = 'Requested'");
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getGlobalCompletedRequestCount()
    {
        $query = $this->conn->prepare("SELECT COUNT(*) as request_count FROM stock_transfer WHERE status = 'Completed'");
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function checkToken($token)
    {
        $query = $this->conn->prepare(
            "SELECT * FROM password_resets WHERE token = ? LIMIT 1"
        );
        $query->bind_param('s', $token);
        $query->execute();
        $result = $query->get_result();

        return $result->num_rows > 0;
    }

    public function checkProductBarcode($barcode, $branch_id)
    {
        $query = $this->conn->prepare(
            "SELECT 
            p.product_id,
            p.barcode,
            p.product_name,
            i.stock_level,
            p.selling_price
        FROM product AS p
        INNER JOIN inventory AS i
            ON p.product_id = i.product_id
        WHERE i.branch_id = ?
        AND p.barcode = ?"
        );

        $query->bind_param("ss", $branch_id, $barcode);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $mapped = [
                "id" => $row["product_id"],
                "barcode" => $row["barcode"],
                "name" => $row["product_name"],
                "stock" => $row["stock_level"],
                "price" => $row["selling_price"]
            ];

            return [
                "isValid" => true,
                "data" => $mapped
            ];
        }

        return [
            "isValid" => false,
            "data" => null
        ];
    }


}
?>