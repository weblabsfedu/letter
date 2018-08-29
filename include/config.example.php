<?php
$connection_string = "host=dbserver port=123 dbname=dbname user=dbuser password=dbpassword";
$openid_conf = [
    'host' => 'my.domain',
    'identity' => 'openid.identity.url',
    'required' => ['required', 'attributes'],
    'optional' => ['optional', 'attributes'],
];
$secret = "some.secret.key";