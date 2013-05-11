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
	$text_message = 'KÃ­nh gá»­i %1$s,

Má»™t phiÃªn Ä‘áº¥u giÃ¡ má»›i Ä‘Æ°á»£c khá»Ÿi táº¡o trong gian hÃ ng Æ°a thÃ­ch cá»§a báº¡n:

	- TÃªn Ä‘áº¥u giÃ¡: %3$s
	- Loáº¡i Ä‘áº¥u giÃ¡: %4$s
	- Sá»‘ lÆ°á»£ng sáº£n pháº©m: %5$s

	- GiÃ¡ khá»Ÿi Ä‘iá»ƒm: %6$s
	- GiÃ¡ mua ngay: %7$s
	- GiÃ¡ mong muá»‘n: %8$s

	- NgÃ y káº¿t thÃºc: %9$s

Äá»ƒ xem trang Ä‘áº¥u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:

%10$s

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %11$s';

	## html message - editable
	$html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Má»™t phiÃªn Ä‘áº¥u giÃ¡ má»›i Ä‘Æ°á»£c khá»Ÿi táº¡o trong gian hÃ ng Æ°a thÃ­ch cá»§a báº¡n: <br>
<ul>
	<li>TÃªn Ä‘áº¥u giÃ¡: <b>%3$s</b> </li>
	<li>Loáº¡i Ä‘áº¥u giÃ¡: <b>%4$s</b> </li>
	<li>Sá»‘ lÆ°á»£ng sáº£n pháº©m: <b>%5$s</b> </li>
</ul>
<ul>
	<li>GiÃ¡ khá»Ÿi Ä‘iá»ƒm: <b>%6$s</b> </li>
	<li>GiÃ¡ mua ngay: <b>%7$s</b> </li>
	<li>GiÃ¡ mong muá»‘n: <b>%8$s</b> </li>
</ul>
<ul>
	<li>NgÃ y káº¿t thÃºc: <b>%9$s</b> </li>
</ul>
[ <a href="%10$s">BÃ¢m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem trang Ä‘Ã¢u giÃ¡. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %11$s';


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
	
	send_mail($row_details['email'], 'Gian hÃ ng Æ°a thÃ­ch - Má»™t phiÃªn Ä‘áº¥u giÃ¡ má»›i Ä‘Æ°á»£c khá»Ÿi táº¡o', $text_message, 
		$setts['admin_email'], $html_message, null, $send);
}
?>