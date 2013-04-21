<?php
## Email File -> retrieve username
## called only from the retrieve_password.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name, u.username, u.email FROM " . DB_PREFIX . "users u WHERE u.username='" . $mail_input_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'Kính gửi %1$s,

Mật khẩu của bạn tại %2$s đã được thiết lập lại.

Chi tiết đăng nhập:

	- Tên đăng nhập: %3$s
	- Mật khẩu: %4$s

Trân trọng,
Ban quản trị %2$s';

## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Mật khẩu của bạn tại <b>%2$s</b> đã được thiết lập lại. <br>
<br>
Chi tiết đăng nhập:<br>
<ul>
	<li>Tên đăng nhập: <b>%3$s</b></li>
	<li>Mật khẩu: <b>%4$s</b></li>
</ul>
Trân trọng, <br>
Ban quản trị %2$s';


$text_message = sprintf($text_message, $row_details['name'], $setts['sitename'], $row_details['username'], $new_password);
$html_message = sprintf($html_message, $row_details['name'], $setts['sitename'], $row_details['username'], $new_password);

send_mail($row_details['email'], $setts['sitename'] . ' - Khôi phục thông tin đăng nhập', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>