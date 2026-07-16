<?php
require_once 'auth.php';
check_login();
require_once '../db/db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Fetch the project to optionally delete the image file
    $stmt = $pdo->prepare('SELECT image_url FROM projects WHERE id = ?');
    $stmt->execute([$id]);
    $project = $stmt->fetch();

    if ($project) {
        if (!empty($project['image_url'])) {
            $filePath = '../' . $project['image_url'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Delete from database
        $stmt = $pdo->prepare('DELETE FROM projects WHERE id = ?');
        $stmt->execute([$id]);
    }
}

header('Location: index.php');
exit;
?>
