<?php
## File Version -> v6.05
## Email File -> notify user when a message is sent
## called only from the messaging() class!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

## will be called only from the messaging() class!
$msg_details = $this->get_sql_row("SELECT u.name, u.email, u.mail_messaging_sent FROM " . DB_PREFIX . "messaging m
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=m.sender_id WHERE 
	m.message_id='" . $mail_input_id . "'");

$send = ($msg_details['mail_messaging_sent']) ? true : false;

## text message - editable
$text_message = 'Kính gửi %1$s,

Bạn vừa gửi một tin nhắn mới thông qua hệ thống của Adamo.

Để xem tin nhắn đã gửi, vui lòng bấm vào đường dẫn bên dưới:

%2$s

Trân trọng,
Ban quản trị %3$s';

## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Bạn vừa gửi một tin nhắn mới thông qua hệ thống của Adamo.. <br>
<br>
<a href="%2$s">Bấm vào đây</a> để xem tin nhắn đã gửi. <br>
<br>
Trân trọng, <br>
Ban quản trị %3$s';

$msg_board_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'messaging', 'section' => 'sent'), true);

$text_message = sprintf($text_message, $msg_details['name'], $msg_board_link, $this->setts['sitename']);
$html_message = sprintf($html_message, $msg_details['name'], $msg_board_link, $this->setts['sitename']);

send_mail($msg_details['email'], 'Tin nhắn đã gửi - ' . $this->setts['sitename'], $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>