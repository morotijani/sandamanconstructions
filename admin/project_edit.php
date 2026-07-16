<?php
require_once 'auth.php';
check_login();
require_once '../db/db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $category = $_POST['category'] ?? '';
    $location = $_POST['location'] ?? '';
    $status = $_POST['status'] ?? '';
    
    // Fetch existing project to retain current image if not replacing
    $stmt = $pdo->prepare('SELECT image_url FROM projects WHERE id = ?');
    $stmt->execute([$id]);
    $project = $stmt->fetch();
    $image_url = $project['image_url'];

    if (empty($title) || empty($category)) {
        $error = 'Title and category are required.';
    } else {
        // Handle file upload if a new file is selected
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Delete old image if it exists
                if (!empty($project['image_url'])) {
                    $oldPath = '../' . $project['image_url'];
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $image_url = 'uploads/' . $fileName;
            } else {
                $error = 'Failed to upload new image.';
            }
        } elseif (isset($_POST['remove_image']) && $_POST['remove_image'] === '1') {
            // Remove the old image entirely
            if (!empty($project['image_url'])) {
                $oldPath = '../' . $project['image_url'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $image_url = '';
        }

        if (!$error) {
            try {
                $stmt = $pdo->prepare('UPDATE projects SET title=?, category=?, location=?, status=?, image_url=? WHERE id=?');
                $stmt->execute([$title, $category, $location, $status, $image_url, $id]);
                $success = 'Project updated successfully!';
            } catch (Exception $e) {
                $error = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

// Fetch project for rendering form
$stmt = $pdo->prepare('SELECT * FROM projects WHERE id = ?');
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project — Admin Dashboard</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/components.css">
    <style>
        .admin-header { background: #1B3A2B; color: #fff; padding: 1rem 0; }
        .admin-header .container { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; }
        .admin-header a { color: #F5B700; text-decoration: none; font-weight: bold; }
        .dashboard-section { padding: 3rem var(--gutter); max-width: 600px; }
        .form-card { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        @media (max-width: 600px) { .form-card { padding: 1.2rem; } }
        .form-card .field { margin-bottom: 1rem; }
        .error { color: red; margin-bottom: 1rem; }
        .success { color: green; margin-bottom: 1rem; }
        .current-img { margin-top: 0.5rem; }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <div>Sandaman Admin Dashboard</div>
            <div>
                <a href="index.php" style="margin-right:20px;">&larr; Back to Dashboard</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>

    <main class="container dashboard-section">
        <h2>Edit Project</h2>
        <div class="form-card">
            <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
            <?php if ($success): ?><div class="success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="field">
                    <label for="title">Project Title</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($project['title']) ?>" required>
                </div>
                <div class="field">
                    <label for="category">Category (used for filtering)</label>
                    <select id="category" name="category" required>
                        <option value="roads" <?= $project['category'] === 'roads' ? 'selected' : '' ?>>Roads & Highways</option>
                        <option value="buildings" <?= $project['category'] === 'buildings' ? 'selected' : '' ?>>Buildings</option>
                        <option value="water" <?= $project['category'] === 'water' ? 'selected' : '' ?>>Water & Drainage</option>
                        <option value="earthworks" <?= $project['category'] === 'earthworks' ? 'selected' : '' ?>>Earthworks</option>
                    </select>
                </div>
                <div class="field">
                    <label for="location">Location (e.g. Accra, Ghana)</label>
                    <input type="text" id="location" name="location" value="<?= htmlspecialchars($project['location']) ?>">
                </div>
                <div class="field">
                    <label for="status">Status (e.g. Completed · 14km)</label>
                    <input type="text" id="status" name="status" value="<?= htmlspecialchars($project['status']) ?>">
                </div>
                <div class="field">
                    <label for="image">Project Image (Leave blank to keep current image)</label>
                    <?php if ($project['image_url']): ?>
                        <div class="current-img">
                            <img src="../<?= htmlspecialchars($project['image_url']) ?>" alt="Current Image" style="max-width: 150px; display: block; margin-bottom: 0.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: normal; cursor: pointer; margin-bottom: 1rem;">
                                <input type="checkbox" name="remove_image" value="1">
                                Remove current image
                            </label>
                        </div>
                    <?php endif; ?>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">Update Project</button>
            </form>
        </div>
    </main>
</body>
</html>
