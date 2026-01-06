<?php
$pageTitle = "Alastair Grandison | Web Developer";
$pageDescription = "A radically modern portfolio of web development work by Alastair Grandison.";

require_once __DIR__ . '/../includes/head.php';
?>
  <body>
    <?php include __DIR__ . '/../includes/background-video.php'; ?>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main id="main">
      <div class="container">
        <section class="hero" data-reveal data-glass>
          <div class="hero__content">
            <div class="kicker">Welcome</div>
            <h1 class="hero__title">
              I build <strong>fast</strong>, <strong>clean</strong> and <strong>playful</strong> web experiences.
            </h1>
            <p class="hero__subtitle">
              I’m Alastair Grandison — a full-stack developer who loves crafting smooth UI, accessible layouts, and
              solid back-end plumbing (PHP/Laravel) that just works.
            </p>
              <div class="hero__cta">
              <a class="btn btn--tile-pink" href="<?= htmlspecialchars(url('/projects'), ENT_QUOTES, 'UTF-8'); ?>">Explore projects</a>
              <a class="btn btn--acid" href="<?= htmlspecialchars(url('/contact'), ENT_QUOTES, 'UTF-8'); ?>">Contact me</a>
            </div>
          </div>
        </section>
      </div>

      <section class="section">
        <div class="container" data-reveal>
          <div class="panel" data-glass>
            <div class="kicker">About</div>
            <h2 class="h2">A quick intro</h2>
            <p class="lead">
              After 20+ years teaching, I retrained as a web developer and threw myself into building real projects.
              I care about legibility, performance, and making interfaces feel delightful — without sacrificing robustness.
            </p>
            <div class="hero__cta">
              <a class="btn btn--tile-pink" href="<?= htmlspecialchars(url('/about-me'), ENT_QUOTES, 'UTF-8'); ?>">Read my story</a>
              <a class="btn btn--acid" href="<?= htmlspecialchars(url('/coding-examples'), ENT_QUOTES, 'UTF-8'); ?>">Browse code snippets</a>
            </div>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <div class="section__header" data-reveal>
            <div>
              <div class="kicker">Work</div>
              <h2 class="h2">Featured projects</h2>
            </div>
            <a class="btn btn--acid" href="<?= htmlspecialchars(url('/projects'), ENT_QUOTES, 'UTF-8'); ?>">View all</a>
          </div>

          <div class="grid grid--cards">
            <article class="card" data-reveal>
              <div class="card__inner">
                <a class="card__media media-frost" href="https://laravel.alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">
                  <img src="<?= htmlspecialchars(asset('images/admin-station.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="Screenshot of Admin Station web app" />
                </a>
                <div class="card__body">
                  <h3 class="card__title">admin<[station]</h3>
                  <p class="card__meta">Admin panel for company and employee data with real workflows.</p>
                  <div class="card__tags">
                    <span class="tag">Laravel</span><span class="tag">Blade</span><span class="tag">PHP</span>
                  </div>
                  <div class="card__actions">
                    <a class="btn btn--acid" href="https://laravel.alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">View live</a>
                  </div>
                </div>
              </div>
            </article>

            <article class="card" data-reveal>
              <div class="card__inner">
                <a class="card__media media-frost" href="https://netmatters.alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">
                  <img src="<?= htmlspecialchars(asset('images/Rebuilding-Netmatters-Webpage.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="Screenshot of my Netmatters homepage rebuild" />
                </a>
                <div class="card__body">
                  <h3 class="card__title">Netmatters homepage rebuild</h3>
                  <p class="card__meta">A pixel-pushed rebuild of the Netmatters homepage from scratch.</p>
                  <div class="card__tags">
                    <span class="tag">HTML</span><span class="tag">Sass</span><span class="tag">JavaScript</span><span class="tag">PHP</span>
                  </div>
                  <div class="card__actions">
                    <a class="btn btn--acid" href="https://netmatters.alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">View live</a>
                  </div>
                </div>
              </div>
            </article>

            <article class="card" data-reveal>
              <div class="card__inner">
                <a class="card__media media-frost" href="https://js-array.alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">
                  <img src="<?= htmlspecialchars(asset('images/Pick-a-pic!.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="Screenshot of Pick-a-pic web app" />
                </a>
                <div class="card__body">
                  <h3 class="card__title">Pick-a-pic web app</h3>
                  <p class="card__meta">Builds galleries of favourite images with a smooth, app-like feel.</p>
                  <div class="card__tags">
                    <span class="tag">JavaScript</span><span class="tag">HTML</span><span class="tag">Sass</span>
                  </div>
                  <div class="card__actions">
                    <a class="btn btn--acid" href="https://js-array.alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">View live</a>
                  </div>
                </div>
              </div>
            </article>
          </div>
        </div>
      </section>

    </main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
