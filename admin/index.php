<?php
require_once 'auth.php';
check_login();

require_once '../db/db.php';

// Pagination setup
$limit = 5;

// Contacts Pagination
$p_cont = isset($_GET['p_cont']) ? max(1, (int)$_GET['p_cont']) : 1;
$offset_cont = ($p_cont - 1) * $limit;
$stmt = $pdo->query('SELECT COUNT(*) FROM contacts');
$total_contacts = $stmt->fetchColumn();
$total_p_cont = ceil($total_contacts / $limit);

$stmt = $pdo->prepare('SELECT * FROM contacts ORDER BY created_at DESC LIMIT :limit OFFSET :offset');
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset_cont, PDO::PARAM_INT);
$stmt->execute();
$contacts = $stmt->fetchAll();

// Projects Pagination
$p_proj = isset($_GET['p_proj']) ? max(1, (int)$_GET['p_proj']) : 1;
$offset_proj = ($p_proj - 1) * $limit;
$stmt = $pdo->query('SELECT COUNT(*) FROM projects');
$total_projects = $stmt->fetchColumn();
$total_p_proj = ceil($total_projects / $limit);

$stmt = $pdo->prepare('SELECT * FROM projects ORDER BY created_at DESC LIMIT :limit OFFSET :offset');
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset_proj, PDO::PARAM_INT);
$stmt->execute();
$projects = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — Sandaman Constructions</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/components.css">
    <style>
        .admin-header { background: #1B3A2B; color: #fff; padding: 1rem 0; }
        .admin-header .container { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; }
        .admin-header a { color: #F5B700; text-decoration: none; font-weight: bold; }
        .dashboard-section { padding: 3rem var(--gutter); }
        .table-responsive { width: 100%; overflow-x: auto; margin-top: 1rem; }
        table { width: 100%; border-collapse: collapse; min-width: 800px; }
        th, td { border: 1px solid #ddd; padding: 0.75rem; text-align: left; }
        th { background: #f4f5f5; }
        .actions a { margin-right: 10px; color: #1B3A2B; font-weight: bold; }
        .actions a.delete { color: red; }
        .header-actions { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem; }
        .header-actions h2 { margin-bottom: 0; }
        
        /* Modal Styles */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000; }
        .modal-overlay.is-visible { display: flex; }
        .modal-box { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); max-width: 400px; width: 90%; text-align: center; }
        .modal-box h3 { margin-top: 0; margin-bottom: 1rem; color: #1B3A2B; }
        .modal-actions { margin-top: 1.5rem; display: flex; justify-content: center; gap: 1rem; }
        .btn-danger { background: #e63946; color: white; border-color: #e63946; }
        .btn-danger:hover { background: #d62828; }
        .btn-secondary { background: #f4f5f5; color: #333; border-color: #ccc; }
        .btn-secondary:hover { background: #e0e0e0; }
        .pagination { margin-top: 1rem; display: flex; gap: 0.5rem; justify-content: flex-end; }
        .pagination a { padding: 0.5rem 1rem; background: #f4f5f5; color: #1B3A2B; text-decoration: none; border: 1px solid #ddd; border-radius: 4px; }
        .pagination a:hover { background: #e0e0e0; }
        .pagination a.active { background: #1B3A2B; color: #fff; border-color: #1B3A2B; }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <div>Sandaman Admin Dashboard</div>
            <div>
                <a href="../index" target="_blank" style="margin-right:20px;">View Site</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>

    <main class="container dashboard-section">
        <?php if (isset($_GET['error']) && $_GET['error'] === 'feature_limit'): ?>
            <div style="background: #e63946; color: white; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; text-align: center;">
                <strong>Error:</strong> You can only feature a maximum of 3 projects on the homepage. Please unfeature an existing project first.
            </div>
        <?php endif; ?>
        
        <div class="header-actions">
            <h2>Projects</h2>
            <a href="project_add.php" class="btn btn-primary">Add New Project</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($projects)): ?>
                    <tr><td colspan="7">No projects found.</td></tr>
                <?php else: ?>
                    <?php foreach ($projects as $index => $p): ?>
                        <tr>
                            <td><?= ($offset_proj + $index + 1) ?></td>
                            <td>
                                <?php if ($p['image_url']): ?>
                                    <img src="../<?= htmlspecialchars($p['image_url']) ?>" alt="Img" style="width:50px; height:50px; object-fit:cover;">
                                <?php else: ?>
                                    No Image
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($p['is_featured']): ?>
                                    <span style="color: #F5B700;" title="Featured on Homepage">★</span>
                                <?php endif; ?>
                                <?= htmlspecialchars($p['title']) ?>
                            </td>
                            <td><?= htmlspecialchars($p['category']) ?></td>
                            <td><?= htmlspecialchars($p['location']) ?></td>
                            <td><?= htmlspecialchars($p['status']) ?></td>
                            <td class="actions">
                                <?php if ($p['is_featured']): ?>
                                    <a href="project_feature.php?id=<?= $p['id'] ?>" style="color: #F5B700;">★ Unfeature</a>
                                <?php else: ?>
                                    <a href="project_feature.php?id=<?= $p['id'] ?>">☆ Feature</a>
                                <?php endif; ?>
                                <a href="project_edit.php?id=<?= $p['id'] ?>">Edit</a>
                                <a href="#" class="delete" onclick="openDeleteModal('project_delete.php?id=<?= $p['id'] ?>'); return false;">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        </div>

        <?php if ($total_p_proj > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_p_proj; $i++): ?>
                <a href="?p_proj=<?= $i ?>&p_cont=<?= $p_cont ?>" class="<?= $i === $p_proj ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>

        <hr style="margin: 4rem 0;">

        <h2>Contact Enquiries</h2>
        <div class="table-responsive">
            <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Service</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($contacts)): ?>
                    <tr><td colspan="6">No enquiries yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($contacts as $c): ?>
                        <tr>
                            <td><?= date('Y-m-d H:i', strtotime($c['created_at'])) ?></td>
                            <td><?= htmlspecialchars($c['name']) ?> <br><small><?= htmlspecialchars($c['company']) ?></small></td>
                            <td><a href="mailto:<?= htmlspecialchars($c['email']) ?>"><?= htmlspecialchars($c['email']) ?></a></td>
                            <td><?= htmlspecialchars($c['phone']) ?></td>
                            <td><?= htmlspecialchars($c['service']) ?> <br><small><?= htmlspecialchars($c['location']) ?></small></td>
                            <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= htmlspecialchars($c['message']) ?>">
                                <?= htmlspecialchars($c['message']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        </div>

        <?php if ($total_p_cont > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_p_cont; $i++): ?>
                <a href="?p_proj=<?= $p_proj ?>&p_cont=<?= $i ?>" class="<?= $i === $p_cont ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </main>

    <!-- Delete Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <h3>Confirm Deletion</h3>
            <p>Are you sure you want to delete this project? This action cannot be undone.</p>
            <div class="modal-actions">
                <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                <a href="#" class="btn btn-danger" id="confirmDeleteBtn">Delete Project</a>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(url) {
            document.getElementById('confirmDeleteBtn').href = url;
            document.getElementById('deleteModal').classList.add('is-visible');
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('is-visible');
        }
    </script>
</body>
</html>
