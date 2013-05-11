<?php
## Email File -> notify seller if an wanted ad has closed
## called only from the main_cron.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name, u.username, u.email, u.mail_item_closed, 
	w.name AS item_name, w.wanted_ad_id FROM " . DB_PREFIX . "wanted_ads w
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=w.owner_id
	WHERE w.wanted_ad_id='" . $mail_input_id . "'");

$send = ($row_details['mail_item_closed']) ? true : false;

## text message - editable
$text_message = 'Kính gửi %1$s,

Rao văt %2$s của bạn đã bị đóng.

Để xem chi tiết rao vặt, vui lòng bấm vào đường dẫn bên dưới:

%3$s

Trân trọng,
Ban quản trị %4$s';

## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Rao vặt %2$s của bạn đã bị đóng. <br>
[ <a href="%3$s">Bấm vào đây</a> ] để xem chi tiết rao vặt. <br>
<br>
Trân trọng, <br>
Ban quản trị %4$s';


$auction_link = process_link('wanted_details', array('wanted_ad_id' => $row_details['wanted_ad_id']));

$text_message = sprintf($text_message, $row_details['name'], $row_details['item_name'], $auction_link, $setts['sitename']);
$html_message = sprintf($html_message, $row_details['name'], $row_details['item_name'], $auction_link, $setts['sitename']);

send_mail($row_details['email'], 'Mã rao vặt: ' . $row_details['wanted_ad_id'] . ' - Rao vặt đã đóng', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>