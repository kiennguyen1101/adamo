<?php
## File Version -> v6.05
## Email File -> notify seller if multiple items closed but there was no sale
## called only from the main_cron.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name, u.username, u.email, u.mail_item_closed 
	FROM " . DB_PREFIX . "users u WHERE u.user_id='" . $mail_input_id . "'");

$send = ($row_details['mail_item_closed']) ? true : false;

## text message - editable
$text_message = 'KÃ­nh gá»­i %1$s,

Má»™t sá»‘ phiÃªn Ä‘áº¥u giÃ¡ cá»§a báº¡n Ä‘Ã£ bá»‹ Ä‘Ã³ng.
NguyÃªn nhÃ¢n cÃ³ thá»ƒ do khÃ´ng cÃ³ ngÆ°á»i Ä‘áº·t giÃ¡ hoáº·c giÃ¡ Ä‘áº¥u chÆ°a Ä‘áº¡t giÃ¡ mong muá»‘n cá»§a báº¡n.

Äá»ƒ xem chi tiáº¿t cÃ¡c phiÃªn Ä‘áº¥u giÃ¡ bá»‹ Ä‘Ã³ng, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:

%2$s

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %3$s';

## html message - editable
$html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Má»™t sá»‘ phiÃªn Ä‘áº¥u giÃ¡ cá»§a báº¡n Ä‘Ã£ bá»‹ Ä‘Ã³ng. <br>
NguyÃªn nhÃ¢n cÃ³ thá»ƒ do khÃ´ng cÃ³ ngÆ°á»i Ä‘áº·t giÃ¡ hoáº·c giÃ¡ Ä‘áº¥u chÆ°a Ä‘áº¡t giÃ¡ mong muá»‘n cá»§a báº¡n. <br>
<br>
[ <a href="%2$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem chi tiáº¿t cÃ¡c phiÃªn Ä‘áº¥u giÃ¡. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %3$s';


$items_closed_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'selling', 'section' => 'closed'), true);

$text_message = sprintf($text_message, $row_details['name'], $items_closed_link, $setts['sitename']);
$html_message = sprintf($html_message, $row_details['name'], $items_closed_link, $setts['sitename']);

send_mail($row_details['email'], 'CÃ¡c phiÃªn Ä‘áº¥u giÃ¡ bá»‹ Ä‘Ã³ng', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>