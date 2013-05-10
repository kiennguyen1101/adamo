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
$text_message = 'Kính gửi %1$s,

Phiên đấu giá %2$s của bạn đã bị đóng và chưa tìm được người thắng cuộc.
Nguyên nhân có thể do không có người đấu giá hoặc giá đấu chưa đạt giá mong muốn của bạn.

Để xem chi tiết phiên đấu giá, vui lòng bấm vào đường dẫn bên dưới:

%3$s

Trân trọng,
Ban quản trị %4$s';

## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Phiên đấu giá %2$s của bạn đã bị đóng và chưa tìm được người thắng cuộc. <br>
Nguyên nhân có thể do không có người đấu giá hoặc giá đấu chưa đạt giá mong muốn của bạn. <br>
<br>
[ <a href="%3$s">Bấm vào đây</a> ] để xem phiên đấu giá. <br>
<br>
Trân trọng, <br>
Ban quản trị%4$s';


$auction_link = process_link('auction_details', array('name' => $row_details['item_name'], 'auction_id' => $row_details['auction_id']));

$text_message = sprintf($text_message, $row_details['name'], $row_details['item_name'], $auction_link, $setts['sitename']);
$html_message = sprintf($html_message, $row_details['name'], $row_details['item_name'], $auction_link, $setts['sitename']);

send_mail($row_details['email'], 'Mã đáu giá: ' . $row_details['auction_id'] . ' - Đấu giá bị đóng', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>