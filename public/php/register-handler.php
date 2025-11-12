<?php
session_start();
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO players (name, email, password, admin) VALUES (?, ?, ?, 0)");
    $stmt->execute([$name, $email, $password]);

    $_SESSION['user_id'] = $pdo->lastInsertId();
    $_SESSION['user_name'] = $name;
    $_SESSION['is_admin'] = 0;

    header("Location: /resources/views/dashboard.blade.php");
    exit;
}
?>
