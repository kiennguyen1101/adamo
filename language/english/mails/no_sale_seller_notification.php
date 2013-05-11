<?php
## Email File -> notify seller if an item closed but there was no sale
## called only from the main_cron.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name, u.username, u.email, u.mail_item_closed, 
	a.name AS item_name, a.currency, a.auction_id FROM " . DB_PREFIX . "auctions a 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id
	WHERE a.auction_id='" . $mail_input_id . "'");

$send = ($row_details['mail_item_closed']) ? true : false;

## text message - editable
$text_message = 'KÃ­nh gá»­i %1$s,

PhiÃªn Ä‘áº¥u giÃ¡ %2$s cá»§a báº¡n Ä‘Ã£ bá»‹ Ä‘Ã³ng vÃ  chÆ°a tÃ¬m Ä‘Æ°á»£c ngÆ°á»i tháº¯ng cuá»™c.
NguyÃªn nhÃ¢n cÃ³ thá»ƒ do khÃ´ng cÃ³ ngÆ°á»i Ä‘áº¥u giÃ¡ hoáº·c giÃ¡ Ä‘áº¥u chÆ°a Ä‘áº¡t giÃ¡ mong muá»‘n cá»§a báº¡n.

Äá»ƒ xem chi tiáº¿t phiÃªn Ä‘áº¥u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:

%3$s

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %4$s';

## html message - editable
$html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
PhiÃªn Ä‘áº¥u giÃ¡ %2$s cá»§a báº¡n Ä‘Ã£ bá»‹ Ä‘Ã³ng vÃ  chÆ°a tÃ¬m Ä‘Æ°á»£c ngÆ°á»i tháº¯ng cuá»™c. <br>
NguyÃªn nhÃ¢n cÃ³ thá»ƒ do khÃ´ng cÃ³ ngÆ°á»i Ä‘áº¥u giÃ¡ hoáº·c giÃ¡ Ä‘áº¥u chÆ°a Ä‘áº¡t giÃ¡ mong muá»‘n cá»§a báº¡n. <br>
<br>
[ <a href="%3$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem phiÃªn Ä‘áº¥u giÃ¡. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹%4$s';


$auction_link = process_link('auction_details', array('name' => $row_details['item_name'], 'auction_id' => $row_details['auction_id']));

$text_message = sprintf($text_message, $row_details['name'], $row_details['item_name'], $auction_link, $setts['sitename']);
$html_message = sprintf($html_message, $row_details['name'], $row_details['item_name'], $auction_link, $setts['sitename']);

send_mail($row_details['email'], 'MÃ£ Ä‘Ã¡u giÃ¡: ' . $row_details['auction_id'] . ' - Äáº¥u giÃ¡ bá»‹ Ä‘Ã³ng', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>