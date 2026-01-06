<?php
$pageTitle = "Page not found | Alastair Grandison";
$pageDescription = "The page you requested could not be found.";

require_once __DIR__ . '/../includes/head.php';
?>
  <body>
    <?php include __DIR__ . '/../includes/background-video.php'; ?>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main id="main">
      <section class="section">
        <div class="container">
          <div class="panel" data-glass data-reveal>
            <div class="kicker">404</div>
            <h1 class="h1">Page not found</h1>
            <p class="lead">
              The page you’re looking for doesn’t exist, has been moved, or is temporarily unavailable.
            </p>
            <div class="hero__cta">
              <a class="btn" href="<?= htmlspecialchars(url('/'), ENT_QUOTES, 'UTF-8'); ?>">Go home</a>
              <a class="btn btn--acid" href="<?= htmlspecialchars(url('/projects'), ENT_QUOTES, 'UTF-8'); ?>">View projects</a>
            </div>
          </div>
        </div>
      </section>
    </main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
