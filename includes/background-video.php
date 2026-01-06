<?php
require_once __DIR__ . '/bootstrap.php';

$webmPath = __DIR__ . '/../public/media/hero.webm';
$mp4Path = __DIR__ . '/../public/media/hero.mp4';

$hasWebm = is_readable($webmPath);
$hasMp4 = is_readable($mp4Path);

if (!$hasWebm && !$hasMp4) {
    return;
}
?>

<div class="bg-video" aria-hidden="true">
  <video class="bg-video__video" autoplay muted loop playsinline webkit-playsinline preload="auto">
<?php if ($hasMp4): ?>
    <source src="<?= htmlspecialchars(asset('media/hero.mp4'), ENT_QUOTES, 'UTF-8'); ?>" type="video/mp4" />
<?php endif; ?>
<?php if ($hasWebm): ?>
    <source src="<?= htmlspecialchars(asset('media/hero.webm'), ENT_QUOTES, 'UTF-8'); ?>" type="video/webm" />
<?php endif; ?>
  </video>
  <div class="bg-video__overlay"></div>
</div>
