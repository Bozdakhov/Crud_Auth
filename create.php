<?php
require 'auth.php';
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $photo = '';

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo = uniqid() . '_' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . $photo);
    }

    $stmt = $pdo->prepare('INSERT INTO posts (title, content, photo) VALUES (?, ?, ?)');
    $stmt->execute([$title, $content, $photo]);

    header('Location: dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
    <h1>Create New Post</h1>
    <form method="POST" enctype="multipart/form-data" class="card p-4">
        <div class="mb-3">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="content">Content:</label>
            <textarea name="content" id="content" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="photo">Photo:</label>
            <input type="file" name="photo" id="photo" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary w-100">Create Post</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
