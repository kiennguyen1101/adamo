<?php
## File Version -> v6.05
## Email File -> notify user when a message is received
## called only from the messaging() class!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

## will be called only from the messaging() class!
$msg_details = $this->get_sql_row("SELECT u.name, u.email, u.mail_messaging_received FROM " . DB_PREFIX . "messaging m
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=m.receiver_id WHERE 
	m.message_id='" . $mail_input_id . "'");

$send = ($msg_details['mail_messaging_received']) ? true : false;

## text message - editable
$text_message = 'KÃ­nh gá»­i %1$s,

Má»™t tin nháº¯n má»›i Ä‘Ã£ Ä‘Æ°á»£c gá»­i cho báº¡n trong báº£ng tin nháº¯n.

Äá»ƒ xem tin Ä‘Ã£ nháº­n, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:

%2$s

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %3$s';

## html message - editable
$html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Má»™t tin nháº¯n má»›i Ä‘Ã£ Ä‘Æ°á»£c gá»­i cho báº¡n trong báº£ng tin nháº¯n. <br>
<br>
<a href="%2$s">Báº¥m vÃ o Ä‘Ã¢y</a> Ä‘á»ƒ xem tin Ä‘Ã£ nháº­n. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %3$s';

$msg_board_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'messaging', 'section' => 'received'), true);

$text_message = sprintf($text_message, $msg_details['name'], $msg_board_link, $this->setts['sitename']);
$html_message = sprintf($html_message, $msg_details['name'], $msg_board_link, $this->setts['sitename']);

send_mail($msg_details['email'], 'Tin nháº¯n má»›i - ' . $setts['sitename'], $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>