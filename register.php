<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
    $stmt->execute([$email, $password]);

    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
    <h1 class="text-center mb-4">Register</h1>
    <div class="card p-4">
        <form method="POST">
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required> 
            </div>
            <div class="mb-3">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" required> 
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
            <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
