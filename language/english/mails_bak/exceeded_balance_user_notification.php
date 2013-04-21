<?php
## Email File -> notify user that his account has been suspended because the debit limit was exceeded.
## called only from the suspend_debit_users() function

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name AS buyer_name, u.username, u.email, u.balance FROM " . DB_PREFIX . "users u WHERE
	u.user_id=" . $mail_input_id);

$send = true; ## always send

## text message - editable
$text_message = 'Kính g&#7917;i %1$s,
	
Tài kho&#7843;n c&#7911;a b&#7841;n trên %2$s &#273;ã b&#7883; t&#7841;m ng&#7915;ng ho&#7841;t &#273;&#7897;ng vì b&#7841;n &#273;ã v&#432;&#7907;t quá gi&#7899;i h&#7841;n ghi n&#7907; cho phép.

S&#7889; d&#432; c&#7911;a b&#7841;n là: %3$s

&#272;&#7875; kích ho&#7841;t l&#7841;i tài kho&#7843;n, b&#7841;n c&#7847;n thanh toán s&#7889; d&#432; trong tài kho&#7843;n. 
Vui lòng b&#7845;m vào &#273;&#432;&#7901;ng d&#7851;n bên d&#432;&#7899;i &#273;&#7875; &#273;&#7871;n trang thanh toán:
	
%4$s
	
B&#7841;n c&#7847;n &#273;&#259;ng nh&#7853;p tr&#432;&#7899;c khi thanh toán.
	
Trân tr&#7885;ng,
The %2$s staff';

## html message - editable
$html_message = 'Kính g&#7917;i %1$s,<br>
<br>
Your account on %2$s has been suspended because you have exceeded the maximum debit limit allowed.<br>
<br>
Your balance is: <b>%3$s</b> <br>
<br>
In order to reactivate your account, you will need to clear your account balance. <br>
Please [ <a href="%4$s">click here</a> ] to access the payment page. <br>
<br>
Please note that you will have to login first. <br>
<br>
Best regards, <br>
The %2$s staff';


$payment_link = SITE_PATH . 'login.php?redirect=' . process_link('fee_payment', array('do' => 'clear_balance'));
$balance_amount = $fees->display_amount($row_details['balance'], $setts['currency']);

$text_message = sprintf($text_message, $row_details['buyer_name'], $setts['sitename'], $balance_amount, $payment_link);
$html_message = sprintf($html_message, $row_details['buyer_name'], $setts['sitename'], $balance_amount, $payment_link);

send_mail($row_details['email'], $setts['sitename'] . ' - Account Suspended', $text_message,
	$setts['admin_email'], $html_message, null, $send);
?>