<?php
## File Version -> v6.05
## Email File -> notify user when a message is sent
## called only from the messaging() class!

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

## will be called only from the messaging() class!
  $msg_details = $this->get_sql_row("SELECT u.name, u.email, u.mail_messaging_sent FROM " . DB_PREFIX . "messaging m
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=m.sender_id WHERE 
	m.message_id='" . $mail_input_id . "'");

  $send = ($msg_details['mail_messaging_sent']) ? true : false;

## text message - editable
  $text_message = 'KÃ­nh gá»­i %1$s,

Báº¡n vá»«a gá»­i má»™t tin nháº¯n má»›i thÃ´ng qua há»‡ thá»‘ng cá»§a Adamo.

Äá»ƒ xem tin nháº¯n Ä‘Ã£ gá»­i, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:

%2$s

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %3$s';

## html message - editable
  $html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Báº¡n vá»«a gá»­i má»™t tin nháº¯n má»›i thÃ´ng qua há»‡ thá»‘ng cá»§a Adamo.. <br>
<br>
<a href="%2$s">Báº¥m vÃ o Ä‘Ã¢y</a> Ä‘á»ƒ xem tin nháº¯n Ä‘Ã£ gá»­i. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %3$s';

  $msg_board_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'messaging', 'section' => 'sent'), true);

  $text_message = sprintf($text_message, $msg_details['name'], $msg_board_link, $this->setts['sitename']);
  $html_message = sprintf($html_message, $msg_details['name'], $msg_board_link, $this->setts['sitename']);

  send_mail($msg_details['email'], 'Tin nháº¯n Ä‘Ã£ gá»­i - ' . $this->setts['sitename'], $text_message, $this->setts['admin_email'], $html_message, null, $send);
?>