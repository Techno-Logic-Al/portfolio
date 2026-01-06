<?php
$pageTitle = "Contact | Alastair Grandison";
$pageDescription = "Contact Alastair Grandison via the portfolio contact form.";

require_once __DIR__ . '/../includes/contact-handler.php';

/** @var array{name:string,role:string,email:string,phone_display:string,phone_tel:string,github:?string,linkedin:?string} $profile */
$profile = require __DIR__ . '/../config/profile.php';

$serverMessage = null;
$serverMessageClass = '';
$serverErrors = [];

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = contactHandleSubmission($_POST);

    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    $serverMessage = $result['message'] ?? null;
    $serverMessageClass = ($result['ok'] ?? false) ? 'success' : 'has-error';
    $serverErrors = $result['errors'] ?? [];
}

$sticky = function (string $name): string {
    $value = $_POST[$name] ?? '';
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

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
              <div class="kicker">Let’s build</div>
              <h1 class="h1">Contact</h1>
              <p class="lead">Send me a message and I’ll get back to you.</p>
            </div>
          </div>

          <div class="split">
            <div class="panel" data-glass data-reveal>
              <div class="kicker">Direct</div>
              <div class="prose">
                <p><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars($profile['email'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($profile['email'], ENT_QUOTES, 'UTF-8'); ?></a></p>
                <p><strong>Phone:</strong> <a href="tel:<?= htmlspecialchars($profile['phone_tel'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($profile['phone_display'], ENT_QUOTES, 'UTF-8'); ?></a></p>
                <p>
                  I’m happy to discuss roles, freelance projects, collaborations, or just talk shop about UI/UX and code.
                </p>
              </div>
            </div>

            <form class="panel" data-glass data-reveal data-contact-form method="post" action="<?= htmlspecialchars(url('/contact'), ENT_QUOTES, 'UTF-8'); ?>">
              <div class="kicker">Message</div>

              <span class="form-message <?= htmlspecialchars($serverMessageClass, ENT_QUOTES, 'UTF-8'); ?>" aria-live="polite">
                <?= $serverMessage ? htmlspecialchars($serverMessage, ENT_QUOTES, 'UTF-8') : '' ?>
              </span>

              <div class="form-grid form-grid--2">
                <div class="field">
                  <label class="label" for="name">Name <span class="required" aria-hidden="true">*</span></label>
                  <input id="name" name="name" type="text" required value="<?= $sticky('name'); ?>"/>
                  <?php if (!empty($serverErrors['name']['message'])): ?>
                    <span class="form-message has-error"><?= htmlspecialchars($serverErrors['name']['message'], ENT_QUOTES, 'UTF-8'); ?></span>
                  <?php endif; ?>
                </div>

                <div class="field">
                  <label class="label" for="company">Company name</label>
                  <input id="company" name="company" type="text" value="<?= $sticky('company'); ?>"/>
                </div>
              </div>

              <div class="form-grid form-grid--2">
                <div class="field">
                  <label class="label" for="email">Email <span class="required" aria-hidden="true">*</span></label>
                  <input id="email" name="email" type="email" required value="<?= $sticky('email'); ?>"/>
                  <?php if (!empty($serverErrors['email']['message'])): ?>
                    <span class="form-message has-error"><?= htmlspecialchars($serverErrors['email']['message'], ENT_QUOTES, 'UTF-8'); ?></span>
                  <?php endif; ?>
                </div>

                <div class="field">
                  <label class="label" for="telephone">Telephone <span class="required" aria-hidden="true">*</span></label>
                  <input id="telephone" name="telephone" type="tel" required value="<?= $sticky('telephone'); ?>"/>
                  <?php if (!empty($serverErrors['telephone']['message'])): ?>
                    <span class="form-message has-error"><?= htmlspecialchars($serverErrors['telephone']['message'], ENT_QUOTES, 'UTF-8'); ?></span>
                  <?php endif; ?>
                </div>
              </div>

              <div class="field">
                <label class="label" for="message">Message <span class="required" aria-hidden="true">*</span></label>
                <textarea id="message" name="message" required><?= $sticky('message'); ?></textarea>
                <?php if (!empty($serverErrors['message']['message'])): ?>
                  <span class="form-message has-error"><?= htmlspecialchars($serverErrors['message']['message'], ENT_QUOTES, 'UTF-8'); ?></span>
                <?php endif; ?>
              </div>

              <div style="position:absolute; left:-10000px; top:auto; width:1px; height:1px; overflow:hidden;" aria-hidden="true">
                <label for="website">Website</label>
                <input id="website" name="website" type="text" tabindex="-1" autocomplete="off"/>
              </div>

              <div class="hero__cta" style="margin-top:1.1rem">
                <button class="btn btn--tile-pink" type="submit">Send message</button>
                <a class="btn btn--acid" href="<?= htmlspecialchars(url('/projects'), ENT_QUOTES, 'UTF-8'); ?>">See projects</a>
                <span class="required-note"><span class="required" aria-hidden="true">*</span>required</span>
              </div>
            </form>
          </div>
        </div>
      </section>
    </main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
