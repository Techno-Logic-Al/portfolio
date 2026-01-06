<?php
require_once __DIR__ . '/bootstrap.php';

if (!isset($pageTitle)) {
    $pageTitle = "AG's portfolio";
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="robots" content="index,follow"/>
    <meta name="color-scheme" content="dark light"/>
    <meta name="theme-color" content="#0b0b12"/>

    <link rel="icon" href="<?= htmlspecialchars(asset('favicon.svg'), ENT_QUOTES, 'UTF-8'); ?>" type="image/svg+xml"/>
    <link rel="manifest" href="<?= htmlspecialchars(asset('site.webmanifest'), ENT_QUOTES, 'UTF-8'); ?>"/>

    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>

<?php
    $cssPath = __DIR__ . '/../public/css/style.css';
    $cssVer = is_readable($cssPath) ? (string) (md5_file($cssPath) ?: time()) : (string) time();
?>
    <link rel="stylesheet" href="<?= htmlspecialchars(asset('css/style.css') . '?v=' . $cssVer, ENT_QUOTES, 'UTF-8'); ?>"/>
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
<?php if (!empty($pageDescription)): ?>
    <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>"/>
<?php endif; ?>

    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>"/>
<?php if (!empty($pageDescription)): ?>
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>"/>
<?php endif; ?>

    <script>
      (() => {
        const stored = localStorage.getItem("mode");
        const theme = stored === "dark" || stored === "light" ? stored : "light";
        document.documentElement.dataset.theme = theme;
      })();
    </script>
  </head>
