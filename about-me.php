<?php
$pageTitle = "about me";
$pageDescription = "Learn more about web developer Alastair Grandison.";

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
            <h1>about me</h1>
            <p>
              I’ve always loved computers and technology - ever since I started
              programming my secondhand Sinclair ZX81 as a child (using my
              parents’ old black and white TV as a display). I remember how
              exciting it felt to buy the latest issue of ‘ZX Computing’ every
              month, so I could spend an entire day manually inputting a very
              basic game - that invariably turned out to be somewhat underwhelming
              (even assuming I could spot all of the syntax errors!)
            </p>
            <p>
              My father worked for IBM his whole career but I decided to follow my
              mother’s career path into teaching. I relished explaining computing
              and technology to young people and showing them how much fun they
              could have producing digital animations, editing movies and creating
              their own games using simple block coding. However, I always felt
              that I was destined to work in the tech industry one day; so after
              over 20 years of teaching, I decided to retrain as a web developer.
            </p>
            <p>
              I’m totally committed, incredibly enthusiastic and have both a
              logical/ analytical approach yet also a very creative/communicative
              side to my personality. In my free time I love to explore forests
              and mountains, either on foot or on my mountain bike. I also enjoy
              sampling and trying to recreate interesting dishes from around the
              world - the spicier the better!
            </p>
          </div>
        </div>
      </div>
    </div>
<?php include __DIR__ . '/includes/footer.php'; ?>

