<?php
## File Version -> v6.02
## Email File -> confirm posting to the seller
## called only from the sell_item.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sql_select_fav_stores = $db->query("SELECT a.*, u.name AS user_name, u.email FROM " . DB_PREFIX . "favourite_stores fs,
	" . DB_PREFIX . "auctions a, " . DB_PREFIX . "users u WHERE 
	a.auction_id='" . $mail_input_id . "' AND a.owner_id=fs.store_id AND u.user_id=fs.user_id" );

$send = true; // always sent

while ($row_details = $db->fetch_array($sql_select_fav_stores))
{
	## text message - editable
	$text_message = 'Kính gửi %1$s,

Một phiên đấu giá mới được khởi tạo trong gian hàng ưa thích của bạn:

	- Tên đấu giá: %3$s
	- Loại đấu giá: %4$s
	- Số lượng sản phẩm: %5$s

	- Giá khởi điểm: %6$s
	- Giá mua ngay: %7$s
	- Giá mong muốn: %8$s

	- Ngày kết thúc: %9$s

Để xem trang đấu giá, vui lòng bấm vào đường dẫn bên dưới:

%10$s

Trân trọng,
Ban quản trị %11$s';

	## html message - editable
	$html_message = 'Kính gửi %1$s, <br>
<br>
Một phiên đấu giá mới được khởi tạo trong gian hàng ưa thích của bạn: <br>
<ul>
	<li>Tên đấu giá: <b>%3$s</b> </li>
	<li>Loại đấu giá: <b>%4$s</b> </li>
	<li>Số lượng sản phẩm: <b>%5$s</b> </li>
</ul>
<ul>
	<li>Giá khởi điểm: <b>%6$s</b> </li>
	<li>Giá mua ngay: <b>%7$s</b> </li>
	<li>Giá mong muốn: <b>%8$s</b> </li>
</ul>
<ul>
	<li>Ngày kết thúc: <b>%9$s</b> </li>
</ul>
[ <a href="%10$s">Bâm vào đây</a> ] để xem trang đâu giá. <br>
<br>
Trân trọng, <br>
Ban quản trị %11$s';


	$start_price = $fees->display_amount($row_details['start_price'], $row_details['currency']);
	$buyout_price = $fees->display_amount($row_details['buyout_price'], $row_details['currency']);
	$reserve_price = $fees->display_amount($row_details['reserve_price'], $row_details['currency']);

	$closing_date = show_date($row_details['end_time']);

	$auction_link = process_link('auction_details', array('name' => $row_details['name'], 'auction_id' => $row_details['auction_id']));


	$text_message = sprintf($text_message, $row_details['user_name'], $setts['sitename'], $row_details['name'], $row_details['auction_type'], 
		$row_details['quantity'], $start_price, $buyout_price, $reserve_price, $closing_date, $auction_link, 
		$setts['sitename']);
	
	$html_message = sprintf($html_message, $row_details['user_name'], $setts['sitename'], $row_details['name'], $row_details['auction_type'], 
		$row_details['quantity'], $start_price, $buyout_price, $reserve_price, $closing_date, $auction_link, 
		$setts['sitename']);
	
	send_mail($row_details['email'], 'Gian hàng ưa thích - Một phiên đấu giá mới được khởi tạo', $text_message, 
		$setts['admin_email'], $html_message, null, $send);
}
?>