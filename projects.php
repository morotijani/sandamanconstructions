<?php
require_once 'db/db.php';
$stmt = $pdo->query('SELECT * FROM projects ORDER BY created_at DESC');
$projects = $stmt->fetchAll();
?>
<?php
$page_title = 'Projects — Sandaman Constructions';
$page_description = 'Browse Sandaman Constructions\' portfolio of road, building, water and earthworks projects delivered across Ghana.';
include 'includes/header.php';
?>

    <main>
        <!-- ============ PAGE BANNER ============ -->
        <section class="page-banner">
            <div class="blueprint-bg"></div>
            <div class="container">
                <p class="breadcrumb"><a href="index">Home</a><span class="sep">/</span>Projects</p>
                <p class="eyebrow">Portfolio</p>
                <h1>Projects On the Ground.</h1>
                <p class="lead">A sample of completed and active contracts. Photos below are placeholders — ready to be
                    swapped
                    for real project photography.</p>
            </div>
        </section>

        <!-- ============ FILTERABLE GRID ============ -->
        <section class="section">
            <div class="container">
                <div class="filter-row reveal">
                    <button class="filter-btn is-active" data-filter="all">All Projects</button>
                    <button class="filter-btn" data-filter="roads">Roads &amp; Highways</button>
                    <button class="filter-btn" data-filter="buildings">Buildings</button>
                    <button class="filter-btn" data-filter="water">Water &amp; Drainage</button>
                    <button class="filter-btn" data-filter="earthworks">Earthworks</button>
                </div>

                <div class="project-grid reveal">
                    <?php if (empty($projects)): ?>
                        <p>No projects found. Add some from the admin dashboard.</p>
                    <?php else: ?>
                        <?php foreach ($projects as $project): ?>
                            <a href="#" class="project-card" data-category="<?= htmlspecialchars($project['category']) ?>">
                                <div class="project-media">
                                    <span class="tag"><?= htmlspecialchars(ucfirst($project['category'])) ?></span>
                                    <?php if (!empty($project['image_url'])): ?>
                                        <img src="<?= htmlspecialchars($project['image_url']) ?>"
                                            alt="<?= htmlspecialchars($project['title']) ?>"
                                            style="width:100%; height:100%; object-fit:cover;">
                                    <?php else: ?>
                                        <div class="ph-photo">Project photo<br>placeholder</div>
                                    <?php endif; ?>
                                </div>
                                <div class="project-body">
                                    <span class="loc"><?= htmlspecialchars($project['location']) ?></span>
                                    <h3><?= htmlspecialchars($project['title']) ?></h3>
                                    <span class="status"><?= htmlspecialchars($project['status']) ?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- ============ CTA BAND ============ -->
        <section class="cta-band">
            <div class="container">
                <h2>Ready to Add Your Project to the List?</h2>
                <a href="contact" class="btn btn-outline">Start a Conversation <span class="btn-arrow">→</span></a>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>