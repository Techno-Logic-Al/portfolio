<?php
$profile = require __DIR__ . '/../config/profile.php';
$name = $profile['name'] ?? 'Alastair Grandison';
$role = $profile['role'] ?? 'Web Developer';
$email = $profile['email'] ?? 'alastairgrandison@rocketmail.com';
$phoneDisplay = $profile['phone_display'] ?? '07941 233159';
$phoneTel = $profile['phone_tel'] ?? '+447941233159';
$github = $profile['github'] ?? null;
$linkedin = $profile['linkedin'] ?? null;

$normaliseUrl = static function (?string $value): ?string {
    if (empty($value)) {
        return null;
    }

    $value = trim($value);
    if ($value === '') {
        return null;
    }

    if (preg_match('#^https?://#i', $value) === 1) {
        return $value;
    }

    return 'https://' . $value;
};

$githubUrl = $normaliseUrl($github);
$linkedinUrl = $normaliseUrl($linkedin);
?>

    <footer class="site-footer" data-glass>
      <div class="container site-footer__inner">
        <div class="site-footer__col">
          <div class="site-footer__brand"><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></div>
          <div class="site-footer__muted">
            <span><?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8'); ?></span>
            <span>JavaScript · PHP · Laravel · SQL</span>
          </div>
        </div>
        <div class="site-footer__col">
          <div class="site-footer__title">Contact</div>
          <a class="site-footer__link" href="mailto:<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></a>
          <a class="site-footer__link" href="tel:<?= htmlspecialchars($phoneTel, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($phoneDisplay, ENT_QUOTES, 'UTF-8'); ?></a>
        </div>
        <div class="site-footer__col">
          <div class="site-footer__title">Socials</div>
<?php if (!empty($githubUrl)): ?>
          <a class="site-footer__link" href="<?= htmlspecialchars($githubUrl, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer" aria-label="GitHub (opens in a new tab)">
            <span class="social-icon social-icon--github" aria-hidden="true"></span>
            GitHub
          </a>
<?php endif; ?>
<?php if (!empty($linkedinUrl)): ?>
          <a class="site-footer__link" href="<?= htmlspecialchars($linkedinUrl, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn (opens in a new tab)">
            <span class="social-icon social-icon--linkedin" aria-hidden="true"></span>
            LinkedIn
          </a>
<?php endif; ?>
<?php if (empty($githubUrl) && empty($linkedinUrl)): ?>
          <span class="site-footer__muted">Add GitHub/LinkedIn to <code>config/profile.php</code>.</span>
<?php endif; ?>
        </div>
        <div class="site-footer__col site-footer__col--right">
          <a class="btn btn--acid" href="#top">Back to top</a>
          <div class="site-footer__muted">© <?= date('Y'); ?> Alastair Grandison</div>
        </div>
      </div>
    </footer>

<?php
    $jsPath = __DIR__ . '/../public/js/main.js';
    $jsVer = is_readable($jsPath) ? (string) (md5_file($jsPath) ?: time()) : (string) time();
?>
    <script type="module" src="<?= htmlspecialchars(asset('js/main.js') . '?v=' . $jsVer, ENT_QUOTES, 'UTF-8'); ?>"></script>
<?php if (!empty($enableCodeHighlight)): ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/highlight.min.js" integrity="sha512-5sDk2FkEw6ur4YwRBW8dxgT5Z8Or1v4jEwdtjrfxgZ5vYkBgwR6K9oZCGyt9PPH2KJg2l/De7mQdWQliVbKx8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
      window.hljs && window.hljs.highlightAll && window.hljs.highlightAll();
    </script>
<?php endif; ?>
  </body>
</html>
