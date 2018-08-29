<?php
require_once 'config.php';

function insertLetter($link, $user_id, $letter){
    $result = false;
    $now = date('Y-m-d');

    $selectResult = pg_query_params($link, 'SELECT letter FROM letters WHERE user_id = $1', [$user_id]);

    if (pg_num_rows($selectResult) == 0) {
        $letterData = [
            'letter' => $letter,
            'user_id' => $user_id,
            'submit_date' => $now,
        ];

        $insertResult = pg_insert($link, 'letters', $letterData);
        if (pg_affected_rows($insertResult) === 1) {
            $result = true;
        }
    }
    else {
        $letterData = [
            'letter' => $letter,
            'user_id' => $user_id,
            'submit_date' => $now,
        ];
        $updateConditions = ['user_id' => $user_id];

        $updateResult = pg_update($link, 'letters', $letterData, $updateConditions, $options = PGSQL_DML_EXEC);
        if (pg_affected_rows($updateResult) === 1) {
            $result = true;
        }
    }

    return $result;


}

function getLetterByUserId($id){
    global $connection_string;
    $letter = '';
    $link = pg_connect($connection_string);

    $result = pg_query_params($link, 'select letter from letters where user_id=$1', ['user_id'=>$id]);
    if (pg_num_rows($result)) {
        $letter = pg_fetch_result($result, 0, 0);
    }

    pg_close($link);
    return $letter;
}

function authUrl() {
    global $openid_conf;

    $openid = new \LightOpenID($openid_conf['host']);
    $openid->identity = $openid_conf['identity'];
    $openid->required = $openid_conf['required'];
    $openid->optional = $openid_conf['optional'];
    $openid->returnUrl = $openid->realm.$_SERVER['REQUEST_URI'];

    $loginLink = $openid->authUrl();

    return $loginLink;
}

function getAuthenticatedUser() {
    global $openid_conf;

    $openid = new \LightOpenID($openid_conf['host']);
    $openid->identity = $openid_conf['identity'];
    $openid->required = $openid_conf['required'];
    $openid->optional = $openid_conf['optional'];
    $openid->returnUrl = $openid->realm.$_SERVER['REQUEST_URI'];

    if (!$openid->mode) {
        return null;
    }

    $attributes = $openid->getAttributes();

    $user = [];
    $user['email'] = $attributes['email'];
    $user['fio'] = mb_substr($attributes['fullname'], 0, mb_strrpos($attributes['fullname'], ' '));
    $user['r61GK'] = $attributes["r61globalkey"];
    $user['r61StId'] = isset($attributes["r61studentid"]) ? $attributes["r61studentid"] : '';
    $user['isStudent'] = $attributes["student"] === "1";

    return $user;
}

function encrypt($plaintext) {
    global $secret;
    $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $secret, $options = OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext_raw, $secret, $as_binary = true);
    $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );

    return $ciphertext;
}

function decrypt($ciphertext) {
    global $secret;
    $c = base64_decode($ciphertext);
    $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len = 32);
    $ciphertext_raw = substr($c, $ivlen + $sha2len);
    $plaintext = openssl_decrypt($ciphertext_raw, $cipher, $secret, $options = OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $secret, $as_binary = true);
    if (hash_equals($hmac, $calcmac))
    {
        return $plaintext;
    }
    return null;
}

function createUserIfNotExists($user) {
    global $connection_string;
    $link = pg_connect($connection_string);
    $result = false;

    $selectResult = pg_query_params($link, 'SELECT r61_student_id FROM users WHERE r61_student_id = $1', [$user['r61StId']]);

    if (pg_num_rows($selectResult) == 0) {
        $userData = array(
            'r61_student_id' => $user['r61StId'],
            'r61_global_key' => $user['r61GK'],
            'fio' => $user['fio'],
            'email' => $user['email']
        );

        $insertResult = pg_insert($link, 'users', $userData);
        if (pg_affected_rows($insertResult) === 1) {
            $result = true;
        }
    }
    else {
        $result = true;
    }

    pg_close($link);
    return $result;
}

function checkFirstCourse($user) {
    return true;
}