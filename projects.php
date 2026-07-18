<?php
require_once 'db/db.php';
$stmt = $pdo->query('SELECT * FROM projects ORDER BY created_at DESC');
$projects = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects — Sandaman Constructions</title>
    <meta name="description"
        content="Browse Sandaman Constructions' portfolio of road, building, water and earthworks projects delivered across Ghana.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo+Expanded:wght@600;700;800&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/components.css">
</head>

<body>

    <!-- ============ HEADER ============ -->
    <header class="site-header">
        <div class="container">
            <a href="index" class="logo">
                <svg class="mark" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="40" height="40" fill="#1B3A2B" />
                    <path d="M0 40L40 0V14L14 40H0Z" fill="#F5B700" />
                    <path d="M22 40L40 22V32L32 40H22Z" fill="#F5B700" />
                </svg>
                <span class="word">SANDAMAN<small>Constructions</small></span>
            </a>
            <nav>
                <ul class="nav-list" id="nav-list">
                    <li><a href="index">Home</a></li>
                    <li><a href="about">About Us</a></li>
                    <li><a href="sectors">Business Lines</a></li>
                    <li><a href="projects" aria-current="page">Projects</a></li>
                    <li><a href="contact">Contact</a></li>
                </ul>
            </nav>
            <div class="nav-cta">
                <a href="contact" class="btn btn-outline on-dark">Get a Quote</a>
                <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false"><span></span></button>
            </div>
        </div>
    </header>

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

    <!-- ============ FOOTER ============ -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="index" class="logo">
                        <svg class="mark" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="40" height="40" fill="#1B3A2B" />
                            <path d="M0 40L40 0V14L14 40H0Z" fill="#F5B700" />
                            <path d="M22 40L40 22V32L32 40H22Z" fill="#F5B700" />
                        </svg>
                        <span class="word">SANDAMAN<small>Constructions</small></span>
                    </a>
                    <p>A Ghanaian-owned civil engineering and building construction company delivering infrastructure
                        across the
                        country.</p>
                </div>
                <div class="footer-col">
                    <h4>Navigate</h4>
                    <ul>
                        <li><a href="index">Home</a></li>
                        <li><a href="about">About Us</a></li>
                        <li><a href="sectors">Business Lines</a></li>
                        <li><a href="projects">Projects</a></li>
                        <li><a href="contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Business Lines</h4>
                    <ul>
                        <li><a href="sectors">Roads &amp; Highways</a></li>
                        <li><a href="sectors">Building Construction</a></li>
                        <li><a href="sectors">Earthworks &amp; Civil Eng.</a></li>
                        <li><a href="sectors">Water &amp; Drainage</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Contact</h4>
                    <ul class="footer-contact">
                        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M12 21s7-6.3 7-11.5A7 7 0 105 9.5C5 14.7 12 21 12 21z" />
                                <circle cx="12" cy="9.5" r="2.3" />
                            </svg> AG-0196-3430, 37 Biem Gyamfi Street</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path
                                    d="M4 4h4l2 5-2.5 1.5a12 12 0 006 6L15 14l5 2v4a2 2 0 01-2 2C9.6 22 2 14.4 2 6a2 2 0 012-2z" />
                            </svg> +233 24 762 2522 / +233 50 801 1854</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M3 5h18v14H3V5z" />
                                <path d="M3 6l9 7 9-7" />
                            </svg> info@sandamanconstructions.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span class="meta">&copy;
                    <script>
                        const date = new Date();
                        const year = date.getFullYear();
                        document.write(year);
                    </script> Sandaman Constructions Ltd. &nbsp;·&nbsp; Kumasi, Ghana
                </span>
                <div class="footer-social">
                    <a href="https://www.facebook.com/share/1JJFzLcKzm/?mibextid=wwXIfr" aria-label="Facebook"><svg
                            width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.6">
                            <path d="M15 8h2V4h-2a4 4 0 00-4 4v2H9v4h2v6h4v-6h2.5l.5-4H15V8z" />
                        </svg></a>
                    <a href="#" aria-label="LinkedIn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.6">
                            <rect x="3" y="9" width="4" height="10" />
                            <circle cx="5" cy="5" r="1.6" />
                            <path d="M11 19v-6a3 3 0 016 0v6M11 19V9" />
                        </svg></a>
                    <a href="#" aria-label="Instagram"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.6">
                            <rect x="3" y="3" width="18" height="18" rx="4" />
                            <circle cx="12" cy="12" r="4" />
                            <circle cx="17.5" cy="6.5" r="1" />
                        </svg></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/main.js?v=2"></script>
</body>

</html>