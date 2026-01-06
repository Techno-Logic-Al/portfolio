<?php
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Send a contact email using SMTP settings from environment variables.
 */
function sendContactEmail(array $data): bool
{
    $host = getenv('SMTP_HOST') ?: '';
    $port = (int) (getenv('SMTP_PORT') ?: 587);
    $username = getenv('SMTP_USER') ?: '';
    $password = getenv('SMTP_PASS') ?: '';

    if ($host === '' || $username === '' || $password === '') {
        return false;
    }

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = $host;
    $mail->Port = $port;
    $mail->SMTPAuth = true;
    $mail->Username = $username;
    $mail->Password = $password;
    $mail->SMTPSecure = getenv('SMTP_ENCRYPTION') ?: 'tls';

    $mail->setFrom(getenv('SMTP_FROM') ?: $username, 'Portfolio contact form');
    $mail->addAddress(getenv('SMTP_TO') ?: $username);
    $mail->isHTML(false);
    $mail->Subject = 'New portfolio contact form submission';

    $mail->Body = implode("\n", [
        "Name: {$data['name']}",
        "Company: " . ($data['company'] ?: '(not provided)'),
        "Email: {$data['email']}",
        "Telephone: {$data['telephone']}",
        "",
        $data['message'],
    ]);

    return $mail->send();
}

