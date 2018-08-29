<?php
require_once '../include/config.php';
require_once '../include/function.php';

if (empty($_POST['user']) || empty($_POST['letter'])) {
    http_response_code(400);
    exit;
}

if (mb_strlen($_POST['letter']) >= 4000) {
    http_response_code(400);
    exit;
}

$link = pg_connect($connection_string);
$letter = mb_strcut($_POST['letter'], 0, 3900);
$user_id = decrypt($_POST['user']);
insertLetter($link, $user_id ,$letter);
pg_close($link);