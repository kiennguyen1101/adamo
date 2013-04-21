<?php
## File Version -> v6.05
## Email File -> notify seller on a new swap offer placed 
## called only from the $item->place_offer() function!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$offer_details = $this->get_sql_row("SELECT s.*, u.name, u.username, u.email, a.name AS item_name, a.currency FROM " . DB_PREFIX . "swaps s 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=s.seller_id
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=s.auction_id
	WHERE s.swap_id='" . $mail_input_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'Kính gửi %1$s,

Một đề xuất trao đổi hàng vừa được gửi trong phiên đấu giá của bạn, %2$s.

Chi tiết đề xuất:

	- Số lượng yêu cầu: %3$s
	
	- Sản phẩm đề xuất: %4$s
	
Để xem tất cả các đề xuất trong phiên đấu giá, vui lòng bấm vào đường dẫn bên dưới:

%5$s

Trân trọng,
Ban quản trị %6$s';

## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Một đề xuất trao đổi hàng vừa được gửi trong phiên đấu giá của bạn, %2$s. <br>
<br>
Chi tiết đều xuất: <br>
<ul>
	<li>Số lượng yêu cầu: <b>%3$s</b> </li>
	<li>Sản phẩm đề xuất: %4$s </li>
</ul>
<br>
[ <a href="%5$s">Bấm vào đây</a> ] để xem tất cả các đề xuất trong phiên đấu giá. <br>
<br>
Trân trọng, <br>
Ban quản trị %6$s';


$offer_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'selling', 'section' => 'view_offers', 'auction_id' => $offer_details['auction_id']), true);

$text_message = sprintf($text_message, $offer_details['name'], $offer_details['item_name'], $offer_details['quantity'], $offer_details['description'], $offer_link, $this->setts['sitename']);
$html_message = sprintf($html_message, $offer_details['name'], $offer_details['item_name'], $offer_details['quantity'], $offer_details['description'], $offer_link, $this->setts['sitename']);

send_mail($offer_details['email'], 'Mã đấu giá: ' . $offer_details['auction_id'] . ' - Đề xuất trao đổi hàng', $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>