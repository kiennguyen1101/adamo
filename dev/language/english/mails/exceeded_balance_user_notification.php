<?php
## Email File -> notify user that his account has been suspended because the debit limit was exceeded.
## called only from the suspend_debit_users() function

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name AS buyer_name, u.username, u.email, u.balance FROM " . DB_PREFIX . "users u WHERE
	u.user_id=" . $mail_input_id);

$send = true; ## always send

## text message - editable
$text_message = 'KÃ­nh gá»­i %1$s,
	
TÃ i khoáº£n cá»§a báº¡n táº¡i %2$s Ä‘Ã£ bá»‹ Ä‘Ã¬nh chá»‰ vÃ¬ Ä‘Ã£ vÆ°á»£t quÃ¡ dÆ° ná»£ tá»‘i Ä‘a.

DÆ° ná»£ cá»§a báº¡n lÃ : %3$s

Äá»ƒ kÃ­ch hoáº¡t láº¡i tÃ i khoáº£n, báº¡n cáº§n thanh toÃ¡n dÆ° ná»£ tÃ i khoáº£n. 
Vui lÃ²ng bÃ¢m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i Ä‘á»ƒ Ä‘áº¿n trang thanh toÃ¡n:
	
%4$s
	
Báº¡n cáº§n Ä‘Äƒng nháº­p Ä‘á»ƒ cÃ³ thá»ƒ truy cáº­p trang.
	
TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %2$s';

## html message - editable
$html_message = 'KÃ­nh gá»­i %1$s,<br>
<br>
TÃ i khoáº£n cá»§a báº¡n táº¡i %2$s Ä‘Ã£ bá»‹ Ä‘Ã¬nh chá»‰ vÃ¬ Ä‘Ã£ vÆ°á»£t quÃ¡ dÆ° ná»£ tá»‘i Ä‘a.<br>
<br>
DÆ° ná»£ cá»§a báº¡n lÃ : <b>%3$s</b> <br>
<br>
Äá»ƒ kÃ­ch hoáº¡t láº¡i tÃ i khoáº£n, báº¡n cáº§n thanh toÃ¡n dÆ° ná»£ tÃ i khoáº£n. <br>
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

send_mail($row_details['email'], $setts['sitename'] . ' - TÃ i khoáº£n bá»‹ Ä‘Ã¬nh chá»‰', $text_message,
	$setts['admin_email'], $html_message, null, $send);
?>