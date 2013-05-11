<?php
## File Version -> v6.05
## Email File -> notify seller on a successful sale
## called only from the $item->assign_winner() function!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sale_details = $this->get_sql_row("SELECT w.*, u.name, u.username, u.email, u.mail_item_sold, 
	a.name AS item_name, a.currency FROM " . DB_PREFIX . "winners w 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=w.seller_id
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=w.auction_id
	WHERE w.winner_id='" . $mail_input_id . "'");

$send = ($sale_details['mail_item_sold']) ? true : false;

## text message - editable
$text_message = 'Kính gửi %1$s,

Sản phẩm đấu giá của bạn, %2$s, đã được bán thành công.

Chi tiết:

	- Giá: %3$s
	- Số lượng: %4$s
	- Phiên đấu: %7$s
	
Để xem thêm chi tiết , vui lòng truy cập trang "Sản phẩm đã bán" bằng cách bấm vào đường dẫn bên dưới:  

%5$s

Sau khi truy cập trang, vui lòng bấm vào "Bảng tin nhắn" bên cạnh sản phẩm.
"Bảng tin nhắn" là công cụ liên hệ trực tiếp với người mua sản phẩm. Vui lòng sử dụng bảng tin nhắn để đặt câu hỏi liên quan đến thanh toán và giao nhận.

Quan trọng: Các trao đổi giữa bạn và người bán trong Bảng tin nhắn là cơ sở giải quyết tranh chấp phát sinh.

Trân trọng,
Ban quản trị %6$s';

## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Sản phẩm đấu giá của bạn, %2$s, đã được bán thành công. <br>
<br>
Sale Details: <br>
<ul>
	<li>Giá: <b>%3$s</b> </li>
	<li>Số lượng: <b>%4$s</b> </li>
	<li>Phiên đấu: [ <a href="%7$s">Bấm vào để xem</a> ] </li>
</ul>
Để xem thêm chi tiết , vui lòng truy cập trang [ <a href="%5$s">Sản phẩm đã bán</a> ]. <br>
<br>
Sau khi truy cập trang, vui lòng bấm vào "Bảng tin nhắn" bên cạnh sản phẩm. <br>
"Bảng tin nhắn" là công cụ liên hệ trực tiếp với người mua sản phẩm. Vui lòng sử dụng bảng tin nhắn để đặt câu hỏi liên quan đến thanh toán và giao nhận. <br>
<br>
Quan trọng: Các trao đổi giữa bạn và người bán trong Bảng tin nhắn là cơ sở giải quyết tranh chấp phát sinh. <br>
<br>
Trân trọng, <br>
Ban quản trị %6$s';


$items_sold_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'selling', 'section' => 'sold'), true);
$auction_link = process_link('auction_details', array('name' => $sale_details['item_name'], 'auction_id' => $sale_details['auction_id']));

$this->fees = new fees();
$this->fees->setts = $this->setts;
$sale_price = $this->fees->display_amount($sale_details['bid_amount'], $sale_details['currency']);

$text_message = sprintf($text_message, $sale_details['name'], $sale_details['item_name'], $sale_price, $sale_details['quantity_offered'], $items_sold_link, $this->setts['sitename'], $auction_link);
$html_message = sprintf($html_message, $sale_details['name'], $sale_details['item_name'], $sale_price, $sale_details['quantity_offered'], $items_sold_link, $this->setts['sitename'], $auction_link);

send_mail($sale_details['email'], 'Mã đấu giá: ' . $sale_details['auction_id'] . ' - Bán thành công', $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>