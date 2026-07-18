<?php
require_once 'auth.php';
check_login();
require_once '../db/db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // First, find out the current status
    $stmt = $pdo->prepare('SELECT is_featured FROM projects WHERE id = ?');
    $stmt->execute([$id]);
    $project = $stmt->fetch();
    
    if ($project) {
        $currently_featured = (int)$project['is_featured'];
        
        if ($currently_featured === 1) {
            // Unfeature it (always allowed)
            $stmt = $pdo->prepare('UPDATE projects SET is_featured = 0 WHERE id = ?');
            $stmt->execute([$id]);
        } else {
            // Attempting to feature it. Check how many are currently featured.
            $stmt = $pdo->query('SELECT COUNT(*) FROM projects WHERE is_featured = 1');
            $featured_count = $stmt->fetchColumn();
            
            if ($featured_count >= 3) {
                // Limit reached
                header('Location: index.php?error=feature_limit');
                exit;
            } else {
                // Feature it
                $stmt = $pdo->prepare('UPDATE projects SET is_featured = 1 WHERE id = ?');
                $stmt->execute([$id]);
            }
        }
    }
}

header('Location: index.php');
exit;
