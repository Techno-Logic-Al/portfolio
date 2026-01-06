<?php
$pageTitle = "Projects | Alastair Grandison";
$pageDescription = "A selection of web development projects by Alastair Grandison.";

require_once __DIR__ . '/../includes/head.php';
?>
  <body>
    <?php include __DIR__ . '/../includes/background-video.php'; ?>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main id="main">
      <section class="section">
        <div class="container">
          <div class="section__header" data-reveal>
            <div>
              <div class="kicker">Portfolio</div>
              <h1 class="h1">Projects</h1>
              <p class="lead">Glass cards. Glowing buttons. Real work behind the visuals.</p>
            </div>
          </div>
        </div>

        <div class="projects-cascade" data-projects-cascade aria-label="Projects carousel">
          <div class="projects-cascade__track" data-projects-track>
            <article class="card" data-disabled="true" data-project-card data-project-key="coming-soon" aria-label="Coming soon project (not yet available)">
              <div class="card__inner">
                <div class="card__media media-frost">
                  <img src="<?= htmlspecialchars(asset('images/coming-soon.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="Coming soon placeholder image" />
                </div>
                <div class="card__body">
                  <h2 class="card__title">Coming soon</h2>
                  <p class="card__meta">A new build is in the lab. More details soon.</p>
                  <div class="card__tags">
                    <span class="tag">In progress</span>
                  </div>
                </div>
              </div>
            </article>

            <article class="card" data-project-card data-project-key="admin-station">
              <div class="card__inner">
                <a class="card__media media-frost" href="https://laravel.alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">
                  <img src="<?= htmlspecialchars(asset('images/admin-station.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="Screenshot of Admin Station web app" />
                </a>
                <div class="card__body">
                  <h2 class="card__title">admin<[station]</h2>
                  <p class="card__meta">Laravel admin panel for company and employee data with seeded demo content.</p>
                  <div class="card__tags">
                    <span class="tag">Laravel</span><span class="tag">Blade</span><span class="tag">PHP</span>
                  </div>
                  <div class="card__actions">
                    <a class="btn btn--acid" href="https://laravel.alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">View live</a>
                  </div>
                </div>
              </div>
            </article>

            <article class="card" data-project-card data-project-key="netmatters">
              <div class="card__inner">
                <a class="card__media media-frost" href="https://netmatters.alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">
                  <img src="<?= htmlspecialchars(asset('images/Rebuilding-Netmatters-Webpage.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="Screenshot of my Netmatters homepage rebuild" />
                </a>
                <div class="card__body">
                  <h2 class="card__title">Netmatters homepage rebuild</h2>
                  <p class="card__meta">A full rebuild of the Netmatters homepage with responsive layout and UI details.</p>
                  <div class="card__tags">
                    <span class="tag">HTML</span><span class="tag">Sass</span><span class="tag">JavaScript</span><span class="tag">PHP</span>
                  </div>
                  <div class="card__actions">
                    <a class="btn btn--acid" href="https://netmatters.alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">View live</a>
                  </div>
                </div>
              </div>
            </article>

            <article class="card" data-project-card data-project-key="pick-a-pick">
              <div class="card__inner">
                <a class="card__media media-frost" href="https://js-array.alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">
                  <img src="<?= htmlspecialchars(asset('images/Pick-a-Pic!.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="Screenshot of Pick-a-pic web app" />
                </a>
                <div class="card__body">
                  <h2 class="card__title">Pick-a-pic web app</h2>
                  <p class="card__meta">A JavaScript app for building galleries and saving favourites.</p>
                  <div class="card__tags">
                    <span class="tag">JavaScript</span><span class="tag">HTML</span><span class="tag">Sass</span>
                  </div>
                  <div class="card__actions">
                    <a class="btn btn--acid" href="https://js-array.alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">View live</a>
                  </div>
                </div>
              </div>
            </article>

            <article class="card" data-project-card data-project-key="latest-portfolio">
              <div class="card__inner">
                <a class="card__media media-frost" href="https://alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">
                  <img src="<?= htmlspecialchars(asset('images/updated.portfolio.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="Screenshot of my portfolio website" />
                </a>
                <div class="card__body">
                  <h2 class="card__title">Portfolio website</h2>
                  <p class="card__meta">The newest iteration: glass UI, animated background, and refreshed components.</p>
                  <div class="card__tags">
                    <span class="tag">PHP</span><span class="tag">JavaScript</span><span class="tag">CSS</span>
                  </div>
                  <div class="card__actions">
                    <a class="btn btn--acid" href="https://alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">View live</a>
                  </div>
                </div>
              </div>
            </article>
          </div>
        </div>
      </section>
    </main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
