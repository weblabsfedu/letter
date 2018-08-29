<?php
require_once 'function.php';

$user = getAuthenticatedUser();
$authorized = ($user !== null && !empty($user['r61StId']));

if ($authorized) {
    $email = $user['email'];
    $letter = getLetterByUserId($user['r61StId']);
    $encryptedUser = encrypt($user['r61StId']);
}

$loginLink = authUrl();

