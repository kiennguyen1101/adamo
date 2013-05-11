<?php
## File Version -> v6.05
## Email File -> notify seller if multiple wanted ads have closed
## called only from the main_cron.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name, u.username, u.email, u.mail_item_closed 
	FROM " . DB_PREFIX . "users u WHERE u.user_id='" . $mail_input_id . "'");

$send = ($row_details['mail_item_closed']) ? true : false;

## text message - editable
$text_message = 'KÃ­nh gá»­i %1$s,

Má»™t sá»‘ rao váº·t cá»§a báº¡n Ä‘Ã£ bá»‹ Ä‘Ã³ng.

Äá»ƒ xem chi tiáº¿t rao váº·t bá»‹ Ä‘Ã³ng, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n sau Ä‘Ã¢y:

%2$s

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %3$s';

## html message - editable
$html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Má»™t sá»‘ rao váº·t cá»§a báº¡n Ä‘Ã£ bá»‹ Ä‘Ã³ng. <br>
<br>
[ <a href="%2$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem chi tiáº¿t rao váº·t bá»‹ Ä‘Ã³ng. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %3$s';


$items_closed_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'wanted_ads', 'section' => 'closed'), true);

$text_message = sprintf($text_message, $row_details['name'], $items_closed_link, $setts['sitename']);
$html_message = sprintf($html_message, $row_details['name'], $items_closed_link, $setts['sitename']);

send_mail($row_details['email'], 'CÃ¡c rao váº·t bá»‹ Ä‘Ã³ng', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>