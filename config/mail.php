<?php

$autoload = __DIR__ . '/../vendor/autoload.php';
if (is_readable($autoload)) {
    require_once $autoload;
}

/**
 * Send a contact notification email using Outlook SMTP (or any SMTP configured in .env).
 */
function sendContactEmail(array $data): bool
{
    if (!class_exists(\PHPMailer\PHPMailer\PHPMailer::class)) {
        if (getenv('MAIL_DEBUG') === '1') {
            error_log('[portfolio] PHPMailer not installed (vendor/autoload.php missing or composer not run).');
        }
        return false;
    }

    $host = getenv('SMTP_HOST') ?: 'smtp.office365.com';
    $port = getenv('SMTP_PORT') ?: '587';
    $username = getenv('SMTP_USER') ?: '';
    $password = getenv('SMTP_PASS') ?: '';
    $encryption = getenv('SMTP_ENCRYPTION') ?: 'tls';
    $from = getenv('SMTP_FROM') ?: $username;
    $to = getenv('SMTP_TO') ?: $username;

    if ($host === '' || $username === '' || $password === '' || $from === '' || $to === '') {
        return false;
    }

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->Port = (int) $port;
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;

        $enc = strtolower(trim((string) $encryption));
        if (defined(\PHPMailer\PHPMailer\PHPMailer::class . '::ENCRYPTION_STARTTLS') && $enc === 'tls') {
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        } elseif (defined(\PHPMailer\PHPMailer\PHPMailer::class . '::ENCRYPTION_SMTPS') && ($enc === 'ssl' || $enc === 'smtps')) {
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mail->SMTPSecure = $enc;
        }

        $mail->setFrom($from, 'Portfolio contact form');
        $mail->addAddress($to);

        $mail->isHTML(false);
        $mail->Subject = 'New portfolio contact form submission';

        $bodyLines = [
            "You have received a new message from your portfolio contact form:",
            "",
            "Name: " . $data['name'],
            "Company: " . ($data['company'] ?: '(not provided)'),
            "Email: " . $data['email'],
            "Telephone: " . $data['telephone'],
            "",
            "Message:",
            $data['message'],
        ];

        $mail->Body = implode("\n", $bodyLines);

        $mail->send();

        return true;
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        if (getenv('MAIL_DEBUG') === '1') {
            $safeHost = preg_replace('/[^a-z0-9\\.-]+/i', '', (string) $host);
            $safePort = preg_replace('/[^0-9]+/', '', (string) $port);
            error_log('[portfolio] SMTP send failed (host=' . $safeHost . ' port=' . $safePort . '): ' . $e->getMessage());
            if (!empty($mail->ErrorInfo)) {
                error_log('[portfolio] PHPMailer ErrorInfo: ' . $mail->ErrorInfo);
            }
        }
        return false;
    }
}
