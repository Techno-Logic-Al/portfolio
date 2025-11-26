<?php
$pageTitle = "coding examples";
$pageDescription = "Selected coding examples from Alastair Grandison, including regex form validation and responsive navigation.";

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
      <div class="coding-examples">
        <div class="coding-examples-container">
          <div class="coding-examples-content">
            <h1>coding examples</h1>

            <div class="regex-section">
              <h2>regex form validation</h2>
              <h3>javaScript</h3>
              <p>
                verifies if contact form user input matches specific valid patterns:
                if form is completed correctly, user is notified of successful submission;
                if there are errors, an inline warning message appears.
              </p>
              <img class="regex pic" src="./images/regex.png" alt="an image of JavaScript code showing regular expressions (regex)"/>
            </div>

            <div class="responsive-nav-section">
              <div class="responsive-nav-tile">
                <h2>responsive service navigation</h2>
                <h3>sass</h3>
                <p>
                  dynamic, themed navigation styles generated per service via Sass loop.
                  @each iterates service colour map to emit .nav-service styles, switching backgrounds/text on hover/focus, drawing downward 'arrow', revealing a full-width dropdown.
                  uses a custom media query mixin to keep breakpoints DRY; bar height and dropdown/container widths adjust cleanly at 992px and 1260px.
                </p>
                <div class="responsive-nav-pair">
                  <img class="responsive service navigation pic" src="./images/Responsive service navigation 1.png" alt="first image of Sass code showing responsive service navigation"/>
                  <img class="responsive service navigation pic" src="./images/Responsive service navigation 2.png" alt="second image of Sass code showing responsive service navigation"/>
                </div>
              </div>
            </div>

            <div class="layout-section">
              <h2>layout-related tweaks</h2>
              <h3>javaScript</h3>
              <p>
                layout.js handles layout-related tweaks: it keeps the assignment panel's height in sync with the preview panel on wide screens and throttles that work with requestAnimationFrame. It also updates toast positioning during resize/scroll events by coordinating with the shared DOM/state utilities.
              </p>
              <img class="layout-related tweaks pic" src="./images/code from pick-a-pick's layout js file.png" alt="an image of JavaScript code showing layout-related tweaks"/>
            </div>

          </div>
        </div>
      </div>
<?php include __DIR__ . '/includes/footer.php'; ?>
