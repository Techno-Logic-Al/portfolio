<?php
$pageTitle = "Scion Scheme | Alastair Grandison";
$pageDescription = "Information about the Scion Coalition Scheme and training with Netmatters.";

require_once __DIR__ . '/../includes/head.php';
?>
  <body class="page-scion-scheme">
    <?php include __DIR__ . '/../includes/background-video.php'; ?>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main id="main">
      <section class="section">
        <div class="container">
          <div class="section__header" data-reveal>
            <div>
              <div class="kicker">Training</div>
              <h1 class="h1">Scion Coalition Scheme</h1>
              <p class="lead">An intensive route into the industry, supported by senior developers at Netmatters.</p>
            </div>
          </div>

          <div class="grid" style="gap:1.25rem">
            <div class="panel prose" data-glass data-reveal>
              <h2>Introduction</h2>
              <p>
                The <a class="text-pink link-glow" href="https://www.netmatters.co.uk/train-for-a-career-in-tech" target="_blank" rel="noopener noreferrer">Scion Coalition Scheme</a>
                is an intensive, specially-tailored training programme run by <a class="text-acid link-glow" href="https://www.netmatters.co.uk/" target="_blank" rel="noopener noreferrer">Netmatters</a> to give willing candidates
                the opportunity to enter the industry as web developers. Under the supervision of senior web developers, scions generally aim to complete
                training within six to nine months. The course is intensive and the level of learning achieved is extensive in a short space of time.
              </p>
            </div>

            <div class="panel prose" data-glass data-reveal>
              <h2>Treehouse</h2>
              <p>
                <a class="text-pink link-glow" href="https://teamtreehouse.com/" target="_blank" rel="noopener noreferrer">Treehouse</a> is an online learning community, featuring videos covering a number of topics from basic HTML to C# programming, iOS development,
                data analysis, and more. By completing courses, users can earn points and track progress.
              </p>
              <p>
                <strong><span class="text-orange">Total score</span>:</strong> 8,410<br/>
                <a class="text-acid link-glow" href="https://teamtreehouse.com/technological" target="_blank" rel="noopener noreferrer">teamtreehouse.com/technological</a>
              </p>
            </div>

            <div class="panel prose" data-glass data-reveal>
              <div class="about-netmatters">
                <div class="about-netmatters__list">
                  <h2>About Netmatters</h2>
                  <ul>
                    <li>Established in 2008</li>
                    <li>Norfolk's leading technology company</li>
                    <li>Winner of the Princess Royal Training Award</li>
                    <li>Winner of EDP Skills of Tomorrow Award</li>
                    <li>80+ staff, 2 locations across Norfolk</li>
                    <li>Digital marketing, website &amp; software development, and IT support</li>
                    <li>Broad spectrum of clients, working nationwide</li>
                    <li>Operate to strict company values</li>
                  </ul>
                </div>
                <div class="about-netmatters__media">
                  <a class="media-frost rounded link-glow" href="https://www.netmatters.co.uk/" target="_blank" rel="noopener noreferrer" aria-label="Visit Netmatters website">
                    <img class="rounded" src="<?= htmlspecialchars(asset('images/netmatters.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="Netmatters logo" />
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
