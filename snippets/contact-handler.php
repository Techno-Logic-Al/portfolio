<?php

// A server-side contact handler: validate → save to database → send email.
function validateContact(array $post): array
{
    $errors = [];
    $fieldStatus = [];

    $name = trim($post['name'] ?? '');
    $email = trim($post['email'] ?? '');
    $telephone = trim($post['telephone'] ?? '');
    $message = trim($post['message'] ?? '');

    if ($name === '') {
        $errors['name'] = ['type' => 'missing', 'message' => 'Please enter your name.'];
        $fieldStatus['name'] = 'invalid';
    } else {
        $fieldStatus['name'] = 'valid';
    }

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = ['type' => 'invalid', 'message' => 'Please enter a valid email address.'];
        $fieldStatus['email'] = 'invalid';
    } else {
        $fieldStatus['email'] = 'valid';
    }

    $digits = strlen(preg_replace('/\D+/', '', $telephone));
    if ($digits < 10) {
        $errors['telephone'] = ['type' => 'invalid', 'message' => 'Please enter a valid telephone number.'];
        $fieldStatus['telephone'] = 'invalid';
    } else {
        $fieldStatus['telephone'] = 'valid';
    }

    if (mb_strlen($message) < 5 || mb_strlen($message) > 1000) {
        $errors['message'] = ['type' => 'invalid', 'message' => 'Message must be between 5 and 1000 characters.'];
        $fieldStatus['message'] = 'invalid';
    } else {
        $fieldStatus['message'] = 'valid';
    }

    return ['isValid' => empty($errors), 'errors' => $errors, 'fieldStatus' => $fieldStatus];
}

