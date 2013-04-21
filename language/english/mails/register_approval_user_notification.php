<?php
## File Version -> v6.04
## Email File -> registration approval - user notification
## called only from the register.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.user_id, u.name, u.username, u.email FROM " . DB_PREFIX . "users u WHERE 
	u.user_id='" . $mail_input_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'Kính gửi %1$s,

Tài khoản của bạn tại %2$s đã được đăng ký thành công. 

Chi tiết đăng nhập:

	- Tên đăng nhập: %3$s
	- Mật khẩu: -ẩn-

Tài khoản của bạn sẽ được quản trị viên kích hoạt.
Bạn sẽ nhận được email thông báo ngay khi tài khoản được kích hoạt.
	
Trân trọng,
Ban quản trị %2$s';

## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Tài khoản của bạn tại <b>%2$s</b> đã được đăng ký thành công. <br>
<br>
Chi tiết đăng nhập:<br>
<ul>
	<li>Tên đăng nhập: <b>%3$s</b></li>
	<li>Mật khẩu: -ẩn-</li>
</ul>
Tài khoản của bạn sẽ được quản trị viên kích hoạt.<br>
YBạn sẽ nhận được email thông báo ngay khi tài khoản được kích hoạt.<br>
<br>
Trân trọng, <br>
Ban quản trị %2$s';


$text_message = sprintf($text_message, $row_details['name'], $setts['sitename'], $row_details['username']);
$html_message = sprintf($html_message, $row_details['name'], $setts['sitename'], $row_details['username']);

send_mail($row_details['email'], $setts['sitename'] . ' - Xác nhận đăng ký', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>