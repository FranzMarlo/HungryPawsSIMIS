<?php
session_start();
include 'fetch-class.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    if ($role === 'Inventory Staff' || $role === 'Manager') {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $fetch = new fetchClass();
        $conn = $fetch->getConnection();

        if (empty($username) || empty($password)) {
            echo json_encode(["status" => "empty fields", "message" => "Please fill up all fields."]);
            exit();
        }

        $stmt = $conn->prepare("SELECT user_id, password, first_name, last_name, email, image, is_disabled  FROM main WHERE username = ? AND role = ?");


        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
            exit();
        }

        $stmt->bind_param("ss", $username, $role);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $hashedPassword, $first_name, $last_name, $email, $image, $disabled);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                if ($disabled == 1) {
                    echo json_encode(["status" => "error", "message" => "Account Disabled, Please contact your admin if this is a mistake."]);
                    exit();
                }

                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                $_SESSION['first_name'] = $first_name;
                $_SESSION['last_name'] = $last_name;
                $_SESSION['email'] = $email;
                $_SESSION['image'] = $image;

                echo json_encode(["status" => "success", "message" => "Login successful"]);
                exit();
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid password"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Username not found. Please check your role."]);
        }
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $fetch = new fetchClass();
        $conn = $fetch->getConnection();

        if (empty($username) || empty($password)) {
            echo json_encode(["status" => "empty fields", "message" => "Please fill up all fields."]);
            exit();
        }

        $stmt = $conn->prepare("SELECT user_id, branch_id, password, first_name, last_name, email, image, is_disabled  FROM user WHERE username = ? AND role = ?");


        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
            exit();
        }

        $stmt->bind_param("ss", $username, $role);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $branch_id, $hashedPassword, $first_name, $last_name, $email, $image, $disabled);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                if ($disabled == 1) {
                    echo json_encode(["status" => "error", "message" => "Account Disabled, Please contact your admin if this is a mistake."]);
                    exit();
                }

                $_SESSION['user_id'] = $user_id;
                $_SESSION['branch_id'] = $branch_id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                $_SESSION['first_name'] = $first_name;
                $_SESSION['last_name'] = $last_name;
                $_SESSION['email'] = $email;
                $_SESSION['image'] = $image;

                echo json_encode(["status" => "success", "message" => "Login successful"]);
                exit();
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid password"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Username not found. Please check your role."]);
        }
    }
    $stmt->close();
    $conn->close();
}
?>