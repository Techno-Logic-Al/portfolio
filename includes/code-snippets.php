<?php

function renderCodeBlock(string $relativePath, string $label, string $language): void
{
    $fullPath = __DIR__ . '/../snippets/' . ltrim($relativePath, '/');

    $code = '';
    if (is_readable($fullPath)) {
        $code = file_get_contents($fullPath) ?: '';
    }

    $safeLabel = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
    $safeLanguage = htmlspecialchars($language, ENT_QUOTES, 'UTF-8');
    $safeCode = htmlspecialchars($code, ENT_QUOTES, 'UTF-8');
    $languageClass = 'language-' . preg_replace('/[^a-z0-9\-_]+/i', '', $language);
    ?>
    <div class="code-block">
      <div class="code-block__head">
        <div class="code-block__label">
          <span class="code-file"><?= $safeLabel; ?></span>
          <span class="code-lang"><?= $safeLanguage; ?></span>
        </div>
        <button class="btn btn--acid code-copy" type="button" data-copy>Copy</button>
      </div>
      <pre><code class="<?= htmlspecialchars($languageClass, ENT_QUOTES, 'UTF-8'); ?> hljs"><?= $safeCode; ?></code></pre>
    </div>
    <?php
}
