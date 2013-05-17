<?php
## File Version -> v6.05
## Email File -> notify seller if multiple items closed but there was no sale
## called only from the main_cron.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name, u.username, u.email, u.mail_item_closed 
	FROM " . DB_PREFIX . "users u WHERE u.user_id='" . $mail_input_id . "'");

$send = ($row_details['mail_item_closed']) ? true : false;

## text message - editable
$text_message = 'Kính gửi %1$s,

Một số phiên đấu giá của bạn đã bị đóng.
Nguyên nhân có thể do không có người đặt giá hoặc giá đấu chưa đạt giá mong muốn của bạn.

Để xem chi tiết các phiên đấu giá bị đóng, vui lòng bấm vào đường dẫn bên dưới:

%2$s

Trân trọng,
Ban quản trị %3$s';

## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Một số phiên đấu giá của bạn đã bị đóng. <br>
Nguyên nhân có thể do không có người đặt giá hoặc giá đấu chưa đạt giá mong muốn của bạn. <br>
<br>
[ <a href="%2$s">Bấm vào đây</a> ] để xem chi tiết các phiên đấu giá. <br>
<br>
Trân trọng, <br>
Ban quản trị %3$s';


$items_closed_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'selling', 'section' => 'closed'), true);

$text_message = sprintf($text_message, $row_details['name'], $items_closed_link, $setts['sitename']);
$html_message = sprintf($html_message, $row_details['name'], $items_closed_link, $setts['sitename']);

send_mail($row_details['email'], 'Các phiên đấu giá bị đóng', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>