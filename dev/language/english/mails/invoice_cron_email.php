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
	$text_message = 'KÃ­nh gá»­i %1$s,
	
Sau Ä‘Ã¢y lÃ  hÃ³a Ä‘Æ¡n Ä‘á»ƒ thanh toÃ¡n dÆ° ná»£ trong tÃ i khoáº£n cá»§a báº¡n, 
%2$s.

DÆ° ná»£ cá»§a báº¡n lÃ : %3$s

Vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i Ä‘á»ƒ Ä‘áº¿n trang thanh toÃ¡n:
	
%4$s
	
Báº¡n cáº§n Ä‘Äƒng nháº­p Ä‘á»ƒ cÃ³ thá»ƒ truy cáº­p trang.
	
TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %2$s';
	
	## html message - editable
	$html_message = 'KÃ­nh gá»­i %1$s,<br>
<br>
Sau Ä‘Ã¢y lÃ  hÃ³a Ä‘Æ¡n Ä‘á»ƒ thanh toÃ¡n dÆ° ná»£ trong tÃ i khoáº£n cá»§a báº¡n, <br>
%2$s.<br>
<br>
DÆ° ná»£ cá»§a báº¡n lÃ : <b>%3$s</b> <br>
<br>
Vui lÃ²ng [ <a href="%4$s">báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ Ä‘áº¿n trang thanh toÃ¡n. <br>
<br>
Báº¡n cáº§n Ä‘Äƒng nháº­p Ä‘á»ƒ cÃ³ thá»ƒ truy cáº­p trang. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %2$s';
	
	
	$payment_link = SITE_PATH . 'login.php?redirect=' . process_link('fee_payment', array('do' => 'clear_balance'));
	$balance_amount = $fees->display_amount($row_details['balance'], $setts['currency']);
	
	$text_message = sprintf($text_message, $row_details['buyer_name'], $setts['sitename'], $balance_amount, $payment_link);
	$html_message = sprintf($html_message, $row_details['buyer_name'], $setts['sitename'], $balance_amount, $payment_link);
	
	send_mail($row_details['email'], $setts['sitename'] . ' HÃ³a Ä‘Æ¡n', $text_message, 
		$setts['admin_email'], $html_message, null, $send);
}
?>