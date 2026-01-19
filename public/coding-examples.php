<?php
$pageTitle = "Coding Examples | Alastair Grandison";
$pageDescription = "Selected coding examples from Alastair Grandison, displayed as readable code (not screenshots).";
$enableCodeHighlight = true;

require_once __DIR__ . '/../includes/code-snippets.php';
require_once __DIR__ . '/../includes/head.php';
?>
  <body class="page-coding-examples">
    <?php include __DIR__ . '/../includes/background-video.php'; ?>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main id="main">
      <section class="section">
        <div class="container">
          <div class="section__header">
            <div>
              <div class="kicker">Snippets</div>
              <h1 class="h1">Coding examples</h1>
              <p class="lead">
                Real bits of code taken from my projects, with one-click copy.
              </p>
            </div>
          </div>

          <div class="grid" style="gap:1.25rem">
            <div class="panel prose" data-glass>
              <h2>Regex form validation</h2>
              <p>
                Validates contact form input client-side with a simple email regex plus a few human-friendly checks.
                Fields get inline styling and the user gets a clear message if anything is missing or invalid.
              </p>
              <?php renderCodeBlock('regex-validation.js', 'regex-validation.js', 'javascript'); ?>
            </div>

            <div class="panel prose" data-glass>
              <h2>Responsive service navigation (Sass)</h2>
              <p>
                Uses a Sass map plus an <code>@each</code> loop to generate themed navigation styles. The result is DRY, consistent and scalable.
              </p>
              <?php renderCodeBlock('service-nav.scss', 'service-nav.scss', 'scss'); ?>
            </div>

            <div class="panel prose" data-glass>
              <h2>Layout-related tweaks (JavaScript)</h2>
              <p>
                A tiny utility that keeps layout in sync on wide screens and throttles work with <code>requestAnimationFrame</code>
                so resize/scroll stays smooth.
              </p>
              <?php renderCodeBlock('layout-tweaks.js', 'layout-tweaks.js', 'javascript'); ?>
            </div>

            <div class="panel prose" data-glass>
              <h2>Product filters hook (React/TypeScript)</h2>
              <p>
                A pure TypeScript React hook that memoizes the filtering logic and keeps all the domain rules
                (category, price range, stock status, text search and so on) in one place.
              </p>
              <?php renderCodeBlock('useProductFilters.ts', 'useProductFilters.ts', 'typescript'); ?>
            </div>

            <div class="panel prose" data-glass>
              <h2>SMTP mail config (PHP)</h2>
              <p>
                Sends a contact notification email using PHPMailer, reading SMTP configuration from environment variables.
              </p>
              <?php renderCodeBlock('mail.php', 'mail.php', 'php'); ?>
            </div>

            <div class="panel prose" data-glass>
              <h2>Server-side contact handler (PHP)</h2>
              <p>
                Validates request data and builds a structured error response so the front end can show which fields need attention.
              </p>
              <?php renderCodeBlock('contact-handler.php', 'contact-handler.php', 'php'); ?>
            </div>
          </div>
        </div>
      </section>
    </main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
