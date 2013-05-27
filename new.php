<?php

define('IN_SITE', 1);

include_once('includes/global.php');

$user = new user(100023);
var_dump($user->user_id);

