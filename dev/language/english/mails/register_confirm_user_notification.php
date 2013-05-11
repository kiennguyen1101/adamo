<?php
## File Version -> v6.04
## Email File -> registration confirmation message
## called only from the register.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

if ($mail_input_id)
{
	$row_details = $db->get_sql_row("SELECT u.user_id, u.name, u.username, u.email FROM " . DB_PREFIX . "users u WHERE 
		u.user_id='" . $mail_input_id . "'");
}
## otherwise row_details is provided from the file calling this email

$send = true; // always sent;

## text message - editable
$text_message = 'Kính gửi %1$s,

Tài khoản của bạn tại %2$s đã được đăng ký thành công.

Chi tiết đăng nhập:

	- Tên đăng nhập: %3$s
	- Mật khẩu: -ẩn-

Để kích hoạt tài khoản, vui lòng bấm vào đường dẫn bên dưới:

%4$s
	
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
Vui lòng [ <a href="%4$s">bấm vào đây</a> ] để kích hoạt tài khoản của bạn. <br>
<br>
Trân trọng, <br>
Ban quản trị %2$s';


$activation_link = SITE_PATH . 'account_activate.php?user_id=' . $row_details['user_id'] . '&username=' . $row_details['username'];

$text_message = sprintf($text_message, $row_details['name'], $setts['sitename'], $row_details['username'], $activation_link);
$html_message = sprintf($html_message, $row_details['name'], $setts['sitename'], $row_details['username'], $activation_link);

send_mail($row_details['email'], $setts['sitename'] . ' - Xác nhận đăng ký', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>