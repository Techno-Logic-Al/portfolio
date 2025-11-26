<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Send a contact notification email using Outlook SMTP (or any SMTP configured in .env).
 */
function sendContactEmail(array $data): bool
{
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

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->Port = (int) $port;
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->SMTPSecure = $encryption;

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
    } catch (Exception $e) {
        return false;
    }
}

