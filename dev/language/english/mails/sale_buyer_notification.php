<?php
## File Version -> v6.05
## Email File -> notify buyer on a successful purchase
## called only from the $item->assign_winner() function!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sale_details = $this->get_sql_row("SELECT w.*, u.name, u.username, u.email, u.mail_item_won, 
	a.name AS item_name, a.currency FROM " . DB_PREFIX . "winners w 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=w.buyer_id
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=w.auction_id
	WHERE w.winner_id='" . $mail_input_id . "'");

$send = ($sale_details['mail_item_won']) ? true : false;

## text message - editable
$text_message = 'Kính gửi %1$s,

Bạn đã mua thành công sản phẩm %2$s.

Chi tiết mua sản phẩm:

	- Giá: %3$s
	- Số lượng: %4$s
	- Phiên đấu giá: %7$s
	
Để xem chi tiết mua sản phẩm, vui lòng truy cập trang "Các phiên đã thắng" bằng cách bấm vào đường dẫn dưới đây:  

%5$s

Sau khi truy cập trang bên trên, vui lòng bấm vào "Bảng tin nhắn" cạnh sản phẩm chiến thắng.
"Bảng tin nhắn" là là công cụ liên hệ trực tiếp với người bán. Vui lòng sử dụng bảng tin nhắn để đặt câu hỏi liên quan đến sản phẩm cho người bán.

Quan trọng: Các trao đổi giữa bạn và người bán trong Bảng tin nhắn là cơ sở giải quyết tranh chấp phát sinh.

Trân trọng,
Ban quản trị %6$s';

## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Bạn đã mua thành công sản phẩm %2$s. <br>
<br>
Chi tiết mua sản phẩm: <br>
<ul>
	<li>Giá: <b>%3$s</b> </li>
	<li>Số lượng: <b>%4$s</b> </li>
	<li>Phiên đấu giá: [ <a href="%7$s">Bấm vào đây</a> ] </li>
</ul>
Để xem chi tiết mua sản phẩm, vui lòng truy cập trang [ <a href="%5$s">Các phiên đã thắng</a> ]. <br>
<br>
Sau khi truy cập trang bên trên, vui lòng bấm vào "Bảng tin nhắn" cạnh sản phẩm chiến thắng. <br>
"Bảng tin nhắn" là là công cụ liên hệ trực tiếp với người bán. Vui lòng sử dụng bảng tin nhắn để đặt câu hỏi liên quan đến sản phẩm cho người bán. <br>
<br>
Quan trọng: Các trao đổi giữa bạn và người bán trong Bảng tin nhắn là cơ sở giải quyết tranh chấp phát sinh. <br>
<br>
Trân trọng, <br>
Ban quản trị %6$s';


$items_won_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'bidding', 'section' => 'won_items'), true);
$auction_link = process_link('auction_details', array('name' => $sale_details['item_name'], 'auction_id' => $sale_details['auction_id']));

$this->fees = new fees();
$this->fees->setts = $this->setts;
$sale_price = $this->fees->display_amount($sale_details['bid_amount'], $sale_details['currency']);

$text_message = sprintf($text_message, $sale_details['name'], $sale_details['item_name'], $sale_price, $sale_details['quantity_offered'], $items_won_link, $this->setts['sitename'], $auction_link);
$html_message = sprintf($html_message, $sale_details['name'], $sale_details['item_name'], $sale_price, $sale_details['quantity_offered'], $items_won_link, $this->setts['sitename'], $auction_link);

send_mail($sale_details['email'], 'Mã đấu giá: ' . $sale_details['auction_id'] . ' - Mua thành công', $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>