<?php
## Email File -> retrieve username
## called only from the retrieve_password.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.username, u.email FROM " . DB_PREFIX . "users u WHERE u.email='" . $mail_input_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'Kính gửi người dùng,

Tên đăng nhập của bạn tại %1$s là: %2$s

Trân trọng,
Ban quản trị %1$s';

## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Tên đăng nhập của bạn tại %1$s là <b>%2$s</b> <br>
<br>
Trân trọng, <br>
Ban quản trị %1$s';


$text_message = sprintf($text_message, $setts['sitename'], $row_details['username']);
$html_message = sprintf($html_message, $setts['sitename'], $row_details['username']);

send_mail($row_details['email'], $setts['sitename'] . ' - Khôi phục tên đăng nhập', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>