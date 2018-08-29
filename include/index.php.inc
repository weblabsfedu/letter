<?php
require_once 'function.php';
require_once 'openid.php';

$user = getAuthenticatedUser();
$isFirstCourse = checkFirstCourse($user);
$authorized = ($user !== null && $user['isStudent'] === true && $isFirstCourse);

$loginLink = authUrl();

if ($authorized){
    $encryptedUser = encrypt($user['r61StId']);
    createUserIfNotExists($user);
    $letter = getLetterByUserId($user['r61StId']);
}
