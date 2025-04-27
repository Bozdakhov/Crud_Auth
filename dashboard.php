<?php
require 'auth.php';
require 'db.php';

$stmt = $pdo->query('SELECT * FROM posts');
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

<!-- Navbar -->
<nav class="bg-blue-600 p-4 mb-6">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <h1 class="text-white text-2xl font-bold">Dashboard</h1>
        <div class="flex space-x-4">
            <a href="create.php" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Create New Post</a>
            <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Logout</a>
        </div>
    </div>
</nav>

<!-- Posts -->
<div class="max-w-7xl mx-auto space-y-6">
    <?php foreach ($posts as $post): ?>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-2xl font-semibold mb-4"><?= htmlspecialchars($post['title']) ?></h3>

            <?php if ($post['photo']): ?>
                <img src="uploads/<?= htmlspecialchars($post['photo']) ?>" class="rounded mb-4 w-48 shadow">
            <?php endif; ?>

            <p class="text-gray-700 mb-6"><?= nl2br(htmlspecialchars($post['content'])) ?></p>

            <div class="flex space-x-3">
                <a href="edit.php?id=<?= $post['id'] ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm">Edit</a>
                <a href="delete.php?id=<?= $post['id'] ?>" onclick="return confirm('Are you sure?')" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm">Delete</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
