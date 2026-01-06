<?php
require_once __DIR__ . '/bootstrap.php';

$path = currentPath();

$navItems = [
    [
        'href' => '/',
        'label' => 'Home',
        'icon' => 'home',
    ],
    [
        'href' => '/about-me',
        'label' => 'About',
        'icon' => 'user',
    ],
    [
        'href' => '/projects',
        'label' => 'Projects',
        'icon' => 'spark',
    ],
    [
        'href' => '/coding-examples',
        'label' => 'Snippets',
        'icon' => 'code',
    ],
    [
        'href' => '/scion-scheme',
        'label' => 'Scion',
        'icon' => 'cap',
    ],
    [
        'href' => '/contact',
        'label' => 'Contact',
        'icon' => 'mail',
    ],
];

function isActiveNav(string $currentPath, string $href): bool
{
    $href = rtrim($href, '/') ?: '/';
    if ($href === '/') {
        return $currentPath === '/';
    }

    return $currentPath === $href;
}

function svgIcon(string $name): string
{
    $icons = [
        'home' => '<path d="M12 3l9 8h-3v10h-5v-6H11v6H6V11H3l9-8z"/>',
        'user' => '<path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4zm0 2c-4.42 0-8 2-8 4.5V21h16v-2.5C20 16 16.42 14 12 14z"/>',
        'spark' => '<path d="M12 2l1.8 5.7L20 10l-6.2 2.3L12 18l-1.8-5.7L4 10l6.2-2.3L12 2z"/>',
        'code' => '<path d="M9 18l-6-6 6-6 1.4 1.4L5.8 12l4.6 4.6L9 18zm6 0l-1.4-1.4L18.2 12l-4.6-4.6L15 6l6 6-6 6z"/>',
        'cap' => '<path d="M12 3l10 5-10 5L2 8l10-5zm-7 7v6c0 2.2 3.1 4 7 4s7-1.8 7-4v-6l-7 3.5L5 10z"/>',
        'mail' => '<path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/>',
        'sun' => '<path d="M6.76 4.84l-1.8-1.8-1.41 1.41 1.8 1.8 1.41-1.41zM1 11h3v2H1v-2zm10-10h2v3h-2V1zm7.45 3.45-1.41-1.41-1.8 1.8 1.41 1.41 1.8-1.8zM20 11h3v2h-3v-2zm-9 9h2v3h-2v-3zM6.76 19.16l-1.41 1.41-1.8-1.8 1.41-1.41 1.8 1.8zm10.48 0 1.8 1.8 1.41-1.41-1.8-1.8-1.41 1.41zM12 6a6 6 0 1 0 6 6 6 6 0 0 0-6-6z"/>',
        'moon' => '<path d="M21 14.5A7.5 7.5 0 0 1 9.5 3a6.5 6.5 0 1 0 11.5 11.5z"/>',
    ];

    $path = $icons[$name] ?? '';
    return '<svg class="icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">' . $path . '</svg>';
}
?>

<a class="skip-link" href="#main">Skip to content</a>

<div id="top" aria-hidden="true"></div>

<header class="site-header" data-glass>
  <div class="container site-header__inner">
    <div class="header-pill header-pill--brand">
      <a class="brand" href="<?= htmlspecialchars(url('/'), ENT_QUOTES, 'UTF-8'); ?>" aria-label="Homepage">
        <span class="brand__mark" aria-hidden="true">AG</span>
        <span class="brand__text brand__btn">Alastair Grandison</span>
      </a>
    </div>

    <nav class="site-nav" aria-label="Primary">
      <?php foreach ($navItems as $item): ?>
        <?php $isActive = isActiveNav($path, $item['href']); ?>
        <a class="site-nav__link<?= $isActive ? ' is-active' : '' ?>"
           href="<?= htmlspecialchars(url($item['href']), ENT_QUOTES, 'UTF-8'); ?>"
           <?= $isActive ? 'aria-current="page"' : '' ?>>
          <?= svgIcon($item['icon']); ?>
          <span class="site-nav__label"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?></span>
        </a>
      <?php endforeach; ?>
    </nav>

    <div class="header-pill header-pill--theme">
      <button class="theme-toggle" type="button" id="themeToggle" aria-label="Toggle theme">
          <span class="theme-toggle__icons" aria-hidden="true">
          <span class="theme-toggle__img theme-toggle__img--granite"></span>
          <span class="theme-toggle__img theme-toggle__img--groovy"></span>
        </span>
        <span class="theme-toggle__label">Granite mode</span>
      </button>
    </div>
  </div>
</header>

<nav class="dock" data-glass aria-label="Mobile navigation">
  <?php foreach ($navItems as $item): ?>
    <?php $isActive = isActiveNav($path, $item['href']); ?>
    <a class="dock__link<?= $isActive ? ' is-active' : '' ?>"
       href="<?= htmlspecialchars(url($item['href']), ENT_QUOTES, 'UTF-8'); ?>"
       <?= $isActive ? 'aria-current="page"' : '' ?>>
      <?= svgIcon($item['icon']); ?>
      <span class="dock__label"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?></span>
    </a>
  <?php endforeach; ?>
</nav>
