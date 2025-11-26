<?php
$pageTitle = "Page not found | AG's portfolio";
$pageDescription = "The page you requested could not be found.";

require_once __DIR__ . '/includes/head.php';
?>
  <body>
    <div class="page-position">
      <?php include __DIR__ . '/includes/sidebar.php'; ?>
      <button class="header-btn" type="button" id="sidebarToggle">
        <span class="burger-menu burger-line-1"></span>
        <span class="burger-menu burger-line-2"></span>
        <span class="burger-menu burger-line-3"></span>
      </button>
      <div class="about-me">
        <div class="about-me-container">
          <div class="about-me-content">
            <h1>page not found</h1>
            <p>
              The page you're looking for doesn't exist, has been moved,
              or is temporarily unavailable.
            </p>
            <p>
              You can return to the <a class="link-subtle-orange" href="/">homepage</a> or use the sidebar
              to navigate to another section of the portfolio.
            </p>
          </div>
        </div>
      </div>
    </div>
<?php include __DIR__ . '/includes/footer.php'; ?>
