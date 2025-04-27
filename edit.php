<?php
require 'auth.php';
require 'db.php';

// Fetch the post by ID
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: dashboard.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    die('Post not found!');
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $photo = $post['photo'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        // Delete old photo if exists
        if ($photo && file_exists('uploads/' . $photo)) {
            unlink('uploads/' . $photo);
        }

        $photo = uniqid() . '_' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . $photo);
    }

    $stmt = $pdo->prepare('UPDATE posts SET title = ?, content = ?, photo = ? WHERE id = ?');
    $stmt->execute([$title, $content, $photo, $id]);

    header('Location: dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Navbar -->
<nav class="bg-blue-600 p-4">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <a href="dashboard.php" class="text-white font-semibold text-xl">Post Manager</a>
        <div class="flex space-x-4">
            <a href="dashboard.php" class="bg-white text-blue-600 px-4 py-2 rounded hover:bg-gray-100">Back</a>
            <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</a>
        </div>
    </div>
</nav>

<!-- Form Section -->
<div class="flex items-center justify-center mt-10">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl">
        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Edit Post</h2>

        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label for="title" class="block text-gray-700 font-semibold mb-2">Post Title</label>
                <input type="text" name="title" id="title" value="<?= htmlspecialchars($post['title']) ?>" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div>
                <label for="content" class="block text-gray-700 font-semibold mb-2">Content</label>
                <textarea name="content" id="content" rows="5" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required><?= htmlspecialchars($post['content']) ?></textarea>
            </div>

            <div>
                <label for="photo" class="block text-gray-700 font-semibold mb-2">Change Photo (optional)</label>
                <input type="file" name="photo" id="photo" class="w-full border p-2 rounded">
            </div>

            <?php if ($post['photo']): ?>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Current Photo:</label>
                    <img src="uploads/<?= htmlspecialchars($post['photo']) ?>" class="rounded shadow w-48">
                </div>
            <?php endif; ?>

            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded hover:bg-blue-700 transition">Update Post</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
