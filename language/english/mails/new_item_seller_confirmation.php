<?php
## Email File -> confirm posting to the seller
## called only from the sell_item.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT a.*, u.name AS user_name, u.email, u.mail_confirm_to_seller FROM " . DB_PREFIX . "auctions a
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id WHERE a.auction_id='" . $mail_input_id . "'");

$send = ($row_details['mail_confirm_to_seller']) ? true : false;

## text message - editable
$text_message = 'Kính gửi %1$s,

Bạn vừa khởi tạo phiên đấu giá tại %2$s:

	- Tên đấu giá: %3$s
	- Số lượng sản phẩm: %5$s
	- Nhóm sản phẩm: %6$s

	- Giá khởi điểm: %8$s
	- Giá mua ngay: %9$s
	- Giá mong muốn: %10$s

	- Ngày kết thúc: %11$s

Để xem trang đấu giá, vui lòng bấm vào đường dẫn bên dưới:

%12$s

Cảm ơn bạn vì đã sử dụng dịch vụ của Adamo.

Trân trọng,
Ban quản trị %13$s';

## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Bạn vừa khởi tạo phiên đấu giá tại <b>%2$s</b>: <br>
<ul>
	<li>Tên đấu giá: <b>%3$s</b> </li>
	<li>Loại đấu giá: <b>%4$s</b> </li>
	<li>Số lượng đấu giá: <b>%5$s</b> </li>
</ul>
<ul>
	<li>Nhóm sản phẩm: <b>%6$s</b> </li>
	<li>Nhóm phụ: <b>%7$s</b> </li>
</ul>
<ul>
	<li>Giá khởi điểm: <b>%8$s</b> </li>
	<li>Giá mua ngay: <b>%9$s</b> </li>
	<li>Giá mong muốn: <b>%10$s</b> </li>
</ul>
<ul>
	<li>Ngày kết thúc: <b>%11$s</b> </li>
</ul>
[ <a href="%12$s">Bấm vào đây</a> ] để xem trang đấu giá. <br>
<br>
Cảm ơn bạn vì đã sử dụng dịch vụ của Adamo. <br>
<br>
Trân trọng, <br>
Ban quản trị %13$s';


$main_category = category_navigator($row_details['category_id'], false, true, null, null, GMSG_NONE_CAT);
$addl_category = category_navigator($row_details['addl_category_id'], false, true, null, null, GMSG_NONE_CAT);

$start_price = $fees->display_amount($row_details['start_price'], $row_details['currency']);
$buyout_price = $fees->display_amount($row_details['buyout_price'], $row_details['currency']);
$reserve_price = $fees->display_amount($row_details['reserve_price'], $row_details['currency']);

$closing_date = show_date($row_details['end_time']);

$auction_link = process_link('auction_details', array('name' => $row_details['name'], 'auction_id' => $row_details['auction_id']));


$text_message = sprintf($text_message, $row_details['user_name'], $setts['sitename'], $row_details['name'], $row_details['auction_type'], 
	$row_details['quantity'], $main_category, $addl_category, $start_price, $buyout_price, $reserve_price, $closing_date, $auction_link, 
	$setts['sitename']);
	
$html_message = sprintf($html_message, $row_details['user_name'], $setts['sitename'], $row_details['name'], $row_details['auction_type'], 
	$row_details['quantity'], $main_category, $addl_category, $start_price, $buyout_price, $reserve_price, $closing_date, $auction_link, 
	$setts['sitename']);
	
send_mail($row_details['email'], 'Xác nhận khởi tạo đấu giá', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>