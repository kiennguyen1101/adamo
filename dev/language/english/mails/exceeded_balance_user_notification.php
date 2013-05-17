<?php
## Email File -> notify user that his account has been suspended because the debit limit was exceeded.
## called only from the suspend_debit_users() function

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name AS buyer_name, u.username, u.email, u.balance FROM " . DB_PREFIX . "users u WHERE
	u.user_id=" . $mail_input_id);

$send = true; ## always send

## text message - editable
$text_message = 'Kính gửi %1$s,
	
Tài khoản của bạn tại %2$s đã bị đình chỉ vì đã vượt quá dư nợ tối đa.

Dư nợ của bạn là: %3$s

Để kích hoạt lại tài khoản, bạn cần thanh toán dư nợ tài khoản. 
Vui lòng bâm vào đường dẫn bên dưới để đến trang thanh toán:
	
%4$s
	
Bạn cần đăng nhập để có thể truy cập trang.
	
Trân trọng,
Ban quản trị %2$s';

## html message - editable
$html_message = 'Kính gửi %1$s,<br>
<br>
Tài khoản của bạn tại %2$s đã bị đình chỉ vì đã vượt quá dư nợ tối đa.<br>
<br>
Dư nợ của bạn là: <b>%3$s</b> <br>
<br>
Để kích hoạt lại tài khoản, bạn cần thanh toán dư nợ tài khoản. <br>
Vui lòng [ <a href="%4$s">bấm vào đây</a> ] để đến trang thanh toán. <br>
<br>
Bạn cần đăng nhập để có thể truy cập trang. <br>
<br>
Trân trọng, <br>
Ban quản trị %2$s';


$payment_link = SITE_PATH . 'login.php?redirect=' . process_link('fee_payment', array('do' => 'clear_balance'));
$balance_amount = $fees->display_amount($row_details['balance'], $setts['currency']);

$text_message = sprintf($text_message, $row_details['buyer_name'], $setts['sitename'], $balance_amount, $payment_link);
$html_message = sprintf($html_message, $row_details['buyer_name'], $setts['sitename'], $balance_amount, $payment_link);

send_mail($row_details['email'], $setts['sitename'] . ' - Tài khoản bị đình chỉ', $text_message,
	$setts['admin_email'], $html_message, null, $send);
?>