<?php
session_start();
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/post-class.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error",
        "title" => "System Error",
        "message" => "Please Relogin"
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_FILES['profilePhoto'])) {
    echo json_encode([
        "status" => "warning",
        "title" => "Warning",
        "message" => "Please Upload A Photo"
    ]);
    exit;
}

$img = $_FILES['profilePhoto'];

if ($img['error'] !== 0) {
    echo json_encode([
        "status" => "error",
        "title" => "System Error",
        "message" => "Error In Uploading Photo, Plese Try Again",
        "error_code" => $img['error']
    ]);
    exit;
}

$allowedExt = ["jpg", "jpeg", "png"];

$allowedMime = ["image/jpeg", "image/png"];

$fileExt = strtolower(pathinfo($img["name"], PATHINFO_EXTENSION));

if (!in_array($fileExt, $allowedExt)) {
    echo json_encode([
        "status" => "warning",
        "title" => "Invalid File Type",
        "message" => "Only JPG And PNG Files Are Allowed"
    ]);
    exit;
}

if (!in_array($img["type"], $allowedMime)) {
    echo json_encode([
        "status" => "warning",
        "title" => "Invalid File Type",
        "message" => "Uploaded File Is Not A Valid Image"
    ]);
    exit;
}

$ext = "." . $fileExt;
$filename = "img_" . $user_id . "_" . time() . $ext;

$targetDir = $_SERVER['DOCUMENT_ROOT'] . "/HungryPaws/uploads/image/profile/";
$path = $targetDir . $filename;

if (!move_uploaded_file($img['tmp_name'], $path)) {
    echo json_encode([
        "status" => "error",
        "title" => "System Error",
        "message" => "Failed To Save Uploaded Image, Please Try Again"
    ]);
    exit;
}

$post = new postClass();
$update = $post->updateProfilePhoto($user_id, $filename);

if ($update) {
    $_SESSION['image'] = $filename;
    echo json_encode([
        "status" => "success",
        "title" => "Success",
        "message" => "Profile Photo Updated Successfully",
        "data" => [
            "filename" => $filename,
            "url" => "/HungryPaws/uploads/image/profile/" . $filename
        ]
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "title" => "System Error",
        "message" => "Database update failed"
    ]);
}

