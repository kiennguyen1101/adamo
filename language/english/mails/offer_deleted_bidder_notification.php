<?php
## Email File -> notify bidder if his offer is deleted (works with all 3 offer types)
## called only from the $item->delete_offer() function!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$bidder_row = ($offer_table == 'bids') ? 'bidder_id' : 'buyer_id';

$row_details = $this->get_sql_row("SELECT a.*, u.name AS user_name, u.email FROM 
	" . DB_PREFIX . $offer_table . " o
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=o.auction_id 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=o." . $bidder_row . " WHERE
	o." . $offer_id_name . "='" . $offer_id . "' AND a.owner_id='" . $user_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'Kính gửi %1$s,

Đề xuất giá %2$s của bạn trong phiên đấu %3$s đã bị xóa bởi người bán.

Để xem chi tiết phiên đấu giá, vui lòng bấm vào đường dẫn bên dưới:
	
%4$s

Trân trọng
Ban quản trị %5$s';

## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Đề xuất giá %2$s của bạn trong phiên đấu %3$s đã bị xóa bởi người bán. <br>
<br>
[ <a href="%4$s">Bấm vào đây</a> ] để xem chi tiết phiên đấu giá. <br>
<br>

Trân trọng, <br>
Ban quản trị %5$s';


$offer_type = ($offer_table == 'bids') ? 'reserve' : 'fixed price';
$offer_type = ($offer_table == 'swaps') ? 'swap' : $offer_type;

$auction_link = process_link('auction_details', array('name' => $row_details['name'], 'auction_id' => $row_details['auction_id']));

$text_message = sprintf($text_message, $row_details['user_name'], $offer_type, $row_details['name'], $auction_link, $this->setts['sitename']);
$html_message = sprintf($html_message, $row_details['user_name'], $offer_type, $row_details['name'], $auction_link, $this->setts['sitename']);

send_mail($row_details['email'], 'Mã đấu giá: ' . $offer_details['auction_id'] . ' - Đề xuất giá bị từ chối', $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>