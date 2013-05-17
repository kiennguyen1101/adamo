<?php
## File Version -> v6.04
## Email File -> invoice users periodically if site is in account mode and 
## called only from the invoice_cron.php page!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sql_select_users = $db->query("SELECT u.name AS buyer_name, u.username, u.email, u.balance FROM " . DB_PREFIX . "users u WHERE 
	u.balance>" . $setts['min_invoice_value']);

$send = true; ## always send

## send to all the winners of the auction for which the bank details have been set/changed
while ($row_details = $db->fetch_array($sql_select_users))
{
	## text message - editable
	$text_message = 'Kính gửi %1$s,
	
Sau đây là hóa đơn để thanh toán dư nợ trong tài khoản của bạn, 
%2$s.

Dư nợ của bạn là: %3$s

Vui lòng bấm vào đường dẫn bên dưới để đến trang thanh toán:
	
%4$s
	
Bạn cần đăng nhập để có thể truy cập trang.
	
Trân trọng,
Ban quản trị %2$s';
	
	## html message - editable
	$html_message = 'Kính gửi %1$s,<br>
<br>
Sau đây là hóa đơn để thanh toán dư nợ trong tài khoản của bạn, <br>
%2$s.<br>
<br>
Dư nợ của bạn là: <b>%3$s</b> <br>
<br>
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
	
	send_mail($row_details['email'], $setts['sitename'] . ' Hóa đơn', $text_message, 
		$setts['admin_email'], $html_message, null, $send);
}
?>