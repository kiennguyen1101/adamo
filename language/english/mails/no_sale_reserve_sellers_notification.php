<?php
## File Version -> 6.05
## Email File -> notify the seller when the auction was not sold due to the reserve price not being met
## called only from item::assign_winner()

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sql_select_auctions = $this->query("SELECT a.auction_id, a.owner_id, a.name AS item_name,  
	u.name AS seller_name, u.username, u.email, u.mail_item_sold FROM " . DB_PREFIX . "bids b
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=b.auction_id
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id
	WHERE b.auction_id='" . $mail_input_id . "' AND b.bid_out=0 AND b.bid_invalid=0 GROUP BY b.auction_id");


## send to the seller only
while ($row_details = $this->fetch_array($sql_select_auctions))
{
	$send = ($row_details['mail_item_sold']) ? true : false;
	## text message - editable
	$text_message = 'Kính gửi %1$s,
	
Phiên đấu giá %$2s do bạn khởi tạo đã bị đóng.
Không có người thắng cuộc do chưa đạt giá mong muốn.
	
Để xem trang đấu giá, vui lòng bấm vào đường dẫn bên dưới:
	
%3$s
	
Để xem lịch sử đấu giá, vui lòng bấm vào đường dẫn bên dưới:
	
%4$s
	
Trân trọng,
Ban quản trị %5$s';
	
	## html message - editable
	$html_message = 'Kính gửi %1$s, <br>
<br>
Phiên đấu giá %$2s do bạn khởi tạo đã bị đóng. <br>
Không có người thắng cuộc do chưa đạt giá mong muốn. <br>
<br>
[ <a href="%3$s">Bấm vào đây</a> ] để xem trang đấu giá. <br>
<br>
Để xem lịch sử đấu giá, vui lòng [ <a href="%4$s">bấm vào đây</a> ]. <br>
<br>
Trân trọng, <br>
Ban quản trị %5$s';
	
	
	$bid_history_link = SITE_PATH . 'login.php?redirect=' . process_link('bid_history', array('auction_id' => $row_details['auction_id']));
	$auction_link = process_link('auction_details', array('name' => $row_details['item_name'], 'auction_id' => $row_details['auction_id']));
	
	$text_message = sprintf($text_message, $row_details['seller_name'], $row_details['item_name'], $auction_link, $bid_history_link, $this->setts['sitename']);
	$html_message = sprintf($html_message, $watch_details['seller_name'], $watch_details['item_name'], $auction_link, $bid_history_link, $this->setts['sitename']);
	
	send_mail($row_details['email'], 'Mã đấu giá: ' . $row_details['auction_id'] . ' - Đấu giá bị đóng', $text_message, 
		$this->setts['admin_email'], $html_message, null, $send);
}
?>