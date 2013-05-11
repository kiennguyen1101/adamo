<?php
## File Version -> v6.05
## Email File -> notify seller on a new offer placed 
## called only from the $item->place_offer() function!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$offer_details = $this->get_sql_row("SELECT o.*, u.name, u.username, u.email, a.name AS item_name, a.currency FROM " . DB_PREFIX . "auction_offers o 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=o.seller_id
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=o.auction_id
	WHERE o.offer_id='" . $mail_input_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'Kính gửi %1$s,

Một để xuất giá đã được gửi cho bạn, %2$s.

Chi tiết đề xuất:

	- Giá: %3$s
	- Số lượng yêu cầu: %4$s
	
Để xem tất cả đề xuất trong phiên đấu giá của bạn, vui lòng bấm vào đường dẫn bên dưới:

%5$s

Trân trọng,
Ban quản trị %6$s';

## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Một đề xuất giá đã được gửi cho bạn, %2$s. <br>
<br>
Chi tiết đề xuất: <br>
<ul>
	<li>Giá: <b>%3$s</b> </li>
	<li>Số lượng: <b>%4$s</b> </li>
</ul>
<br>
[ <a href="%5$s">Bấm vào đây</a> ] để xem tất cả đề xuất trong phiên đấu giá của bạn. <br>
<br>
Trân trọng, <br>
Ban quản trị %6$s';


$offer_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'selling', 'section' => 'view_offers', 'auction_id' => $offer_details['auction_id']), true);

$this->fees = new fees();
$this->fees->setts = $this->setts;
$offer_price = $this->fees->display_amount($offer_details['amount'], $offer_details['currency']);

$text_message = sprintf($text_message, $offer_details['name'], $offer_details['item_name'], $offer_price, $offer_details['quantity'], $offer_link, $this->setts['sitename']);
$html_message = sprintf($html_message, $offer_details['name'], $offer_details['item_name'], $offer_price, $offer_details['quantity'], $offer_link, $this->setts['sitename']);

send_mail($offer_details['email'], 'Mã đấu giá: ' . $offer_details['auction_id'] . ' - Đề xuất giá mới', $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>