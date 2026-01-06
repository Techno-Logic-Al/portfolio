<?php
$pageTitle = "About | Alastair Grandison";
$pageDescription = "Learn more about web developer Alastair Grandison.";

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
              <div class="kicker">About</div>
              <h1 class="h1">About me</h1>
              <p class="lead">A teacher-to-developer story with a love of clean code, bold design, and real-world builds.</p>
            </div>
          </div>

          <div class="split">
            <div class="panel" data-glass data-reveal>
              <div class="media-frost rounded">
                <img src="<?= htmlspecialchars(asset('images/AG.jpg'), ENT_QUOTES, 'UTF-8'); ?>" alt="Photo of Alastair Grandison" />
              </div>
            </div>

            <div class="panel prose" data-glass data-reveal>
              <p>
                I’ve always loved computers and technology — ever since I started programming my secondhand Sinclair ZX81 as a child
                (using my parents’ old black and white TV as a display). I remember how exciting it felt to buy the latest issue of
                “ZX Computing” each month, so I could spend an entire day manually inputting a very basic game (and hunting down syntax errors!).
              </p>
              <p>
                My father worked for IBM his whole career, but I followed my mother’s path into teaching. I relished explaining computing and
                technology to young people and showing them how much fun they could have creating digital animations, editing movies and building games.
                Over time, though, I knew I was destined to work in tech — so after 20+ years, I decided to retrain as a web developer.
              </p>
              <p>
                I’m committed, enthusiastic and bring a logical, analytical approach alongside a creative, communicative side.
                Outside of coding, I love exploring forests and mountains (on foot or by mountain bike), and trying to recreate interesting dishes from
                around the world — the spicier the better.
              </p>
              <div class="card__tags" style="margin-top:1rem">
                <span class="tag">PHP</span>
                <span class="tag">Laravel</span>
                <span class="tag">JavaScript</span>
                <span class="tag">CSS/Sass</span>
                <span class="tag">Accessibility</span>
              </div>
              <div class="hero__cta">
                <a class="btn btn--tile-pink" href="<?= htmlspecialchars(url('/projects'), ENT_QUOTES, 'UTF-8'); ?>">View projects</a>
                <a class="btn btn--acid" href="<?= htmlspecialchars(url('/contact'), ENT_QUOTES, 'UTF-8'); ?>">Get in touch</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
