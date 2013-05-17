<?php
## File Version -> v6.05
## Email File -> notify seller if multiple wanted ads have closed
## called only from the main_cron.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name, u.username, u.email, u.mail_item_closed 
	FROM " . DB_PREFIX . "users u WHERE u.user_id='" . $mail_input_id . "'");

$send = ($row_details['mail_item_closed']) ? true : false;

## text message - editable
$text_message = 'Kính gửi %1$s,

Một số rao vặt của bạn đã bị đóng.

Để xem chi tiết rao vặt bị đóng, vui lòng bấm vào đường dẫn sau đây:

%2$s

Trân trọng,
Ban quản trị %3$s';

## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Một số rao vặt của bạn đã bị đóng. <br>
<br>
[ <a href="%2$s">Bấm vào đây</a> ] để xem chi tiết rao vặt bị đóng. <br>
<br>
Trân trọng, <br>
Ban quản trị %3$s';


$items_closed_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'wanted_ads', 'section' => 'closed'), true);

$text_message = sprintf($text_message, $row_details['name'], $items_closed_link, $setts['sitename']);
$html_message = sprintf($html_message, $row_details['name'], $items_closed_link, $setts['sitename']);

send_mail($row_details['email'], 'Các rao vặt bị đóng', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>