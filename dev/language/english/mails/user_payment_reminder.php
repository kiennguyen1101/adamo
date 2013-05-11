<?php
## File Version -> v6.02
## Email File -> invoice users periodically if site is in account mode and 
## called only from the invoice_cron.php page!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name AS buyer_name, u.username, u.email, u.balance FROM " . DB_PREFIX . "users u WHERE 
	u.user_id='" . $mail_input_id . "'");

$send = true; ## always send

## text message - editable
$text_message = 'Kính gửi %1$s,
	
Sau đây là hóa đơn để bạn thanh toán dư nợ tài khoản của mình tại %2$s.

Dư nợ của bạn là: %3$s

Vui lòng bấm vào đường dẫn bên dưới để truy cập trang thanh toán:
	
%4$s
	
Vui lòng đăng nhập trước khi vào trang.
	
Trân trọng,
Ban quản trị %2$s';
	
## html message - editable
$html_message = 'Kính gửi %1$s,<br>
<br>
Sau đây là hóa đơn để bạn thanh toán dư nợ tài khoản của mình tại %2$s. <br>
<br>
Dư nợ của bạn là: <b>%3$s</b> <br>
<br>
Vui lòng[ <a href="%4$s">bấm vào đây</a> ] để truy cập trang thanh toán. <br>
<br>
vui lòng đăng nhập trước khi vào trang. <br>
<br>
Trân trọng, <br>
Ban quản trị %2$s';
	
	
$payment_link = SITE_PATH . 'login.php?redirect=' . process_link('fee_payment', array('do' => 'clear_balance'));
$balance_amount = $fees->display_amount($row_details['balance'], $setts['currency']);
	
$text_message = sprintf($text_message, $row_details['buyer_name'], $setts['sitename'], $balance_amount, $payment_link);
$html_message = sprintf($html_message, $row_details['buyer_name'], $setts['sitename'], $balance_amount, $payment_link);
	
send_mail($row_details['email'], $setts['sitename'] . ' Hóa đơn thanh toán dư nợ', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>