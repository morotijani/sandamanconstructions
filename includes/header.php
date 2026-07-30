<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Sandaman Constructions — Building Ghana\'s Infrastructure') ?></title>
    <meta name="description"
        content="<?= htmlspecialchars($page_description ?? 'Sandaman Constructions is a civil engineering and building construction company delivering roads, earthworks, water infrastructure and commercial developments across Ghana.') ?>">
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
                    <li><a href="index" <?= (basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == '') ? 'aria-current="page"' : '' ?>>Home</a></li>
                    <li><a href="about" <?= (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'aria-current="page"' : '' ?>>About Us</a></li>
                    <li><a href="team" <?= (basename($_SERVER['PHP_SELF']) == 'team.php') ? 'aria-current="page"' : '' ?>>Our Team</a></li>
                    <li><a href="sectors" <?= (basename($_SERVER['PHP_SELF']) == 'sectors.php') ? 'aria-current="page"' : '' ?>>Business Lines</a></li>
                    <li><a href="projects" <?= (basename($_SERVER['PHP_SELF']) == 'projects.php') ? 'aria-current="page"' : '' ?>>Projects</a></li>
                    <li><a href="contact" <?= (basename($_SERVER['PHP_SELF']) == 'contact.php') ? 'aria-current="page"' : '' ?>>Contact</a></li>
                </ul>
            </nav>
            <div class="nav-cta">
                <a href="contact" class="btn btn-outline on-dark">Get a Quote</a>
                <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false"><span></span></button>
            </div>
        </div>
    </header>