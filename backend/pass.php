<?php
$password = "111111"; // the plain password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo $hashedPassword;
?>