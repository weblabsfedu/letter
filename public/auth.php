<?php

require_once '../include/config.php';
require_once '../include/function.php';

$user = getOpenidUser();

if ($user !== null) {
    session_start();
    createUserIfNotExists($user);
    $_SESSION['user'] = encrypt(serialize($user));
}

header('Location: /');


