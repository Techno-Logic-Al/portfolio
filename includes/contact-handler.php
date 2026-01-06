<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/mail.php';

function contactSanitizeField(string $value): string
{
    return trim($value);
}

function contactValidate(array $data): array
{
    $errors = [];
    $fieldStatus = [];

    $name = contactSanitizeField($data['name'] ?? '');
    $email = contactSanitizeField($data['email'] ?? '');
    $telephone = contactSanitizeField($data['telephone'] ?? '');
    $message = contactSanitizeField($data['message'] ?? '');
    $company = contactSanitizeField($data['company'] ?? '');

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

function contactSaveMessage(PDO $pdo, array $data): bool
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

function contactHandleSubmission(array $post): array
{
    if (!empty($post['website'])) {
        return [
            'ok' => true,
            'message' => 'Message sent!',
            'emailSent' => false,
            'errors' => [],
            'fieldStatus' => [],
        ];
    }

    $validation = contactValidate($post);

    if (!$validation['isValid']) {
        return [
            'ok' => false,
            'message' => 'Please check the form fields and try again.',
            'errors' => $validation['errors'],
            'fieldStatus' => $validation['fieldStatus'],
        ];
    }

    try {
        $pdo = getPdo();

        $saved = contactSaveMessage($pdo, $validation['data']);
        if (!$saved) {
            return [
                'ok' => false,
                'message' => 'There was a problem saving your message. Please try again later.',
                'errors' => [],
                'fieldStatus' => $validation['fieldStatus'],
            ];
        }

        $emailSent = sendContactEmail($validation['data']);

        return [
            'ok' => true,
            'message' => 'Message sent!',
            'emailSent' => $emailSent,
            'errors' => [],
            'fieldStatus' => $validation['fieldStatus'],
        ];
    } catch (Throwable $e) {
        return [
            'ok' => false,
            'message' => 'There was a problem processing your message. Please try again later.',
            'errors' => [],
            'fieldStatus' => $validation['fieldStatus'],
        ];
    }
}

