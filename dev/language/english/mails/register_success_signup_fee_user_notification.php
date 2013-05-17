<?php
## File Version -> v6.04
## Email File -> registration success - signup fee enabled
## called only from the $fees->callback_procees() function

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $this->get_sql_row("SELECT u.name, u.username, u.email FROM " . DB_PREFIX . "users u WHERE u.user_id='" . $mail_input_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'Kính gửi %1$s,

Tài khoản của bạn tại %2$s đã được kích hoạt thành công.

Chi tiết đăng nhập:

	- Tên đăng nhập: %3$s
	- Mật khẩu: -ẩn-

Trân trọng,
Ban quản trị %2$s';

## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Tài khoản của bạn tại <b>%2$s</b> đã được kích hoạt thành công. <br>
<br>
Chi tiết đăng nhập:<br>
<ul>
	<li>Tên đăng nhập: <b>%3$s</b></li>
	<li>Mật khẩu: -ẩn-</li>
</ul>
Trân trọng, <br>
Ban quản trị %2$s';


$text_message = sprintf($text_message, $row_details['name'], $this->setts['sitename'], $row_details['username']);
$html_message = sprintf($html_message, $row_details['name'], $this->setts['sitename'], $row_details['username']);

send_mail($row_details['email'], $this->setts['sitename'] . ' - Đăng ký thành công', $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>