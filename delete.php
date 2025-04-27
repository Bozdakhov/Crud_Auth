<?php
require 'auth.php';
require 'db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT photo FROM posts WHERE id = ?');
$stmt->execute([$id]);
$post = $stmt->fetch();

if ($post && $post['photo'] && file_exists('uploads/' . $post['photo'])) {
    unlink('uploads/' . $post['photo']);
}

$stmt = $pdo->prepare('DELETE FROM posts WHERE id = ?');
$stmt->execute([$id]);

header('Location: dashboard.php');
?>
