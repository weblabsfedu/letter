<?php
require_once 'function.php';

$authorized = false;
$isStudent = false;

$user = getAuthenticatedUser();

if ($user !== null) {
    $email = $user['email'];
    $authorized = true;

    if (!empty($user['r61StId'])) {
        $isAllowed = checkCourse($user['r61StId']);
        $letter = getLetterByUserId($user['r61StId']);
        $encryptedUser = encrypt($user['r61StId']);
    }
}

$loginLink = authUrl();

