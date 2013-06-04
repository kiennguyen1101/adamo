<?php

if (!$_SESSION)
    session_start();

define('IN_SITE', 1);

include_once('../includes/global.php');

//redirect to login if there's no session recorded
//redirect parameter set to current URI
if ($session->value('user_id'))
    $user = new user($session->value('user_id'));
else
    header_redirect(SITE_PATH.'login.php?'. http_build_query( array('redirect'=> $_SERVER['REQUEST_URI'])));


$template = clone $smarty;
$template->assign('session', $session);
require(BASE_DIR.'global_header1.php');

//require(BASE_DIR.'global_footer1.php');

$template->display('members_area.tpl');
