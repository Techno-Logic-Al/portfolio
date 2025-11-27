<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/mail.php';

function sanitizeField(string $value): string
{
    return trim($value);
}

function validateContact(array $data): array
{
    $errors = [];
    $fieldStatus = [];

    $name = sanitizeField($data['name'] ?? '');
    $email = sanitizeField($data['email'] ?? '');
    $telephone = sanitizeField($data['telephone'] ?? '');
    $message = sanitizeField($data['message'] ?? '');
    $company = sanitizeField($data['company'] ?? '');

    // Name
    if ($name === '') {
        $errors['name'] = [
            'label' => 'your name',
            'type' => 'missing',
            'message' => 'Please enter your name.',
        ];
        $fieldStatus['name'] = 'invalid';
    } else {
        $fieldStatus['name'] = 'valid';
    }

    // Email
    if ($email === '') {
        $errors['email'] = [
            'label' => 'your email',
            'type' => 'missing',
            'message' => 'Please enter your email address.',
        ];
        $fieldStatus['email'] = 'invalid';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = [
            'label' => 'your email',
            'type' => 'invalid',
            'message' => 'Please enter a valid email address.',
        ];
        $fieldStatus['email'] = 'invalid';
    } else {
        $fieldStatus['email'] = 'valid';
    }

    // Telephone
    if ($telephone === '') {
        $errors['telephone'] = [
            'label' => 'your telephone number',
            'type' => 'missing',
            'message' => 'Please enter your telephone number.',
        ];
        $fieldStatus['telephone'] = 'invalid';
    } else {
        $digitCount = strlen(preg_replace('/\D+/', '', $telephone));
        if ($digitCount < 10) {
            $errors['telephone'] = [
                'label' => 'your telephone number',
                'type' => 'invalid',
                'message' => 'Please enter a valid telephone number.',
            ];
            $fieldStatus['telephone'] = 'invalid';
        } else {
            $fieldStatus['telephone'] = 'valid';
        }
    }

    // Message
    if ($message === '') {
        $errors['message'] = [
            'label' => 'message',
            'type' => 'missing',
            'message' => 'Please enter a message.',
        ];
        $fieldStatus['message'] = 'invalid';
    } elseif (mb_strlen($message) < 5) {
        $errors['message'] = [
            'label' => 'message',
            'type' => 'invalid',
            'message' => 'Message must be at least 5 characters.',
        ];
        $fieldStatus['message'] = 'invalid';
    } elseif (mb_strlen($message) > 1000) {
        $errors['message'] = [
            'label' => 'message',
            'type' => 'invalid',
            'message' => 'Message must be 1000 characters or fewer.',
        ];
        $fieldStatus['message'] = 'invalid';
    } else {
        $fieldStatus['message'] = 'valid';
    }

    // Company (optional) – just trim and limit length
    if ($company !== '') {
        $company = mb_substr($company, 0, 150);
    } else {
        $company = null;
    }

    $isValid = empty($errors);

    $clean = [
        'name' => mb_substr($name, 0, 100),
        'email' => mb_substr($email, 0, 255),
        'telephone' => mb_substr($telephone, 0, 30),
        'message' => $message,
        'company' => $company,
    ];

    return [
        'isValid' => $isValid,
        'errors' => $errors,
        'fieldStatus' => $fieldStatus,
        'data' => $clean,
    ];
}

function saveContactMessage(PDO $pdo, array $data): bool
{
    $sql = 'INSERT INTO contact_messages (name, company, email, telephone, message, status)
            VALUES (:name, :company, :email, :telephone, :message, :status)';

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':name' => $data['name'],
        ':company' => $data['company'],
        ':email' => $data['email'],
        ':telephone' => $data['telephone'],
        ':message' => $data['message'],
        ':status' => 'new',
    ]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validation = validateContact($_POST);
    $isValid = $validation['isValid'];
    $errors = $validation['errors'];
    $fieldStatus = $validation['fieldStatus'];

    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

    if ($isAjax) {
        header('Content-Type: application/json');

        if (!$isValid) {
            echo json_encode([
                'ok' => false,
                'errors' => $errors,
                'fieldStatus' => $fieldStatus,
            ]);
            exit;
        }

        try {
            $pdo = getPdo();
            $saved = saveContactMessage($pdo, $validation['data']);

            if (!$saved) {
                echo json_encode([
                    'ok' => false,
                    'message' => 'There was a problem saving your message. Please try again later.',
                ]);
                exit;
            }

            $emailSent = sendContactEmail($validation['data']);

            echo json_encode([
                'ok' => true,
                'message' => 'message sent!',
                'emailSent' => $emailSent,
            ]);
            exit;
        } catch (Throwable $e) {
            echo json_encode([
                'ok' => false,
                'message' => 'There was a problem processing your message. Please try again later.',
            ]);
            exit;
        }
    }

    // Non-AJAX fallback: basic handling could be added here if needed.
}

$pageTitle = "AG's portfolio";
$pageDescription = "Portfolio of web development work by Alastair Grandison.";

require_once __DIR__ . '/includes/head.php';
?>
  <body>
    <div class="page-position">
      <?php include __DIR__ . '/includes/sidebar.php'; ?>
      <div class="main-content">
        <header>
          <div class="banner">
            <div class="banner-particles"></div>
            <div class="banner-message zen-dots">
              <a href="about-me.php">
                <h1 class="banner-name">
                  <span class="banner-line">alastair</span>
                  <span class="banner-line">Grandison</span>
                </h1>
              </a>
              <a href="about-me.php">
                <img class="banner-pic" src="./images/AG.jpg" alt="an image of Alastair Grandison"/>
              </a>
              <a href="coding-examples.php">
                <h2 class="banner-role">
                  <span class="banner-line">coder</span>
                  <span class="banner-line">&amp; web</span>
                  <span class="banner-line">developer</span>
                </h2>
              </a>
              <a href="#portfolio">
                <h2 class="banner-welcome">
                  <span class="banner-line">welcome to</span>
                  <span class="banner-line">my portfolio</span>
                </h2>
              </a>
            </div>
            <button class="header-btn" type="button" id="sidebarToggle">
              <span class="burger-menu burger-line-1"></span>
              <span class="burger-menu burger-line-2"></span>
              <span class="burger-menu burger-line-3"></span>
            </button>
          </div>
        </header>
        <div class="container portfolio-bg" id="portfolio">
          <div class="portfolio">
            <div class="project project-1">
              <a href="https://netmatters.alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">
                <img src="images/Rebuilding-Netmatters-Webpage.png" alt="an image of my netmatters webpage rebuild"/>
              </a>
              <a href="https://netmatters.alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">
                <h2 class="portfolio-h2">netmatters website</h2>
              </a>
              <p>this project rebuilt the netmatters homepage from scratch</p>
              <h3>HTML, Sass<br>JavaScript & PHP</h3>
            </div>
            <div class="project project-2">
              <a href="https://alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">
                <img src="images/portfolio.png" alt="An image of my portfolio"/>
              </a>
              <a href="https://alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">
                <h2 class="portfolio-h2">portfolio<br>website</h2>
              </a>  
              <p>this project created a<br>portfolio of my coding work</p>
              <h3>HTML, Sass<br>JavaScript & PHP</h3>
            </div>
            <div class="project project-3">
              <a href="https://js-array.alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">
                <img src="images/Pick-a-pic!.png" alt="an image of my Pick-a-pic app"/>
              </a>
              <a href="https://js-array.alastair-grandison.netmatters-scs.co.uk/" target="_blank" rel="noopener noreferrer">
                <h2 class="portfolio-h2">pick-a-pic!<br>web app</h2>
              </a>
              <p>this project builds galleries of favourite images</p>
              <h3>HTML, Sass<br>JavaScript</h3>
            </div>
            <div class="project project-4">
              <img src="images/placeholder.png" alt="A 'coming soon!' placeholder image"/>
              <h2 class="portfolio-h2">coming soon</h2>
            </div>
            <div class="project project-5">
              <img src="images/placeholder.png" alt="A 'coming soon!' placeholder image"/>
              <h2 class="portfolio-h2">coming soon</h2>
            </div>
            <div class="project project-6">
              <img src="images/placeholder.png" alt="A 'coming soon!' placeholder image"/>
              <h2 class="portfolio-h2">coming soon</h2>
            </div>
          </div>
        </div>
        <div class="container contact-info-bg">
          <div class="contact-info" id="contact-me">
            <div class="blurb">
              <h3 class="contact-me">contact me</h3>
              <p>for further information or<br>to discuss working together<br>on a project you have in mind, <br>please contact me:</p>
              <p>07941 233159<br>alastairgrandison@rocketmail.com</p>
            </div>
            <form class="contact-box">
              <div class="contact-row">
                <div class="search-bar-container">
                  <label class="field-label" for="name">
                    your name
                    <span class="required-asterisk" aria-hidden="true">*</span>
                  </label>
                  <input
                    class="search-bar"
                    id="name"
                    name="name"
                    type="text"
                    minlength="1"
                    required
                    aria-required="true"
                  />
                  <!-- Required is a fallback validation for if JavaScript is not working -->
                </div>
                <div class="search-bar-container">
                  <label class="field-label" for="company">
                    company name
                  </label>
                  <input
                    class="search-bar"
                    id="company"
                    name="company"
                    type="text"
                  />
                </div>
              </div>
              <div class="contact-row">
                <div class="search-bar-container">
                  <label class="field-label" for="email">
                    your email
                    <span class="required-asterisk" aria-hidden="true">*</span>
                  </label>
                  <input
                    class="search-bar"
                    id="email"
                    name="email"
                    type="email"
                    required
                    aria-required="true"
                  />
                </div>
                <div class="search-bar-container">
                  <label class="field-label" for="telephone">
                    your telephone number
                    <span class="required-asterisk" aria-hidden="true">*</span>
                  </label>
                  <input
                    class="search-bar"
                    id="telephone"
                    name="telephone"
                    type="tel"
                    minlength="10"
                    required
                    aria-required="true"
                  />
                </div>
              </div>
              <div class="text-area-container">
                <div class="message-header">
                  <label class="field-label" for="message">
                    message
                    <span class="required-asterisk" aria-hidden="true">*</span>
                  </label>
                  <div class="contact-footer-text">
                    <span class="required-note">
                      <span class="required-asterisk" aria-hidden="true">*</span> fields required
                    </span>
                  </div>
                </div>
                <textarea
                  class="text-area"
                  id="message"
                  name="message"
                  minlength="5"
                  maxlength="1000"
                  required
                  aria-required="true"
                ></textarea>
              </div>
              <div class="contact-footer">
                <button class="contact-button" type="submit">submit</button>
                <span class="form-message" aria-live="polite"></span>
              </div>
            </form>
          </div>
        </div>
        <footer>
          <div class="back-to-top">
            <a class="btt-link" href="/">back to top</a>
          </div>
        </footer>
      </div>
    </div>
<?php include __DIR__ . '/includes/footer.php'; ?>
