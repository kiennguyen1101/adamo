<?php
## File Version -> v6.04
## Email File -> notify bidder when he is outbid
## called only from the bid.php page!

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sql_select_auctions = $db->query("SELECT a.auction_id, a.name AS item_name,  
	u.name AS buyer_name, u.username, u.email, u.mail_outbid FROM " . DB_PREFIX . "bids b
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=b.auction_id
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=b.bidder_id
	WHERE b.auction_id='" . $mail_input_id . "' AND b.bidder_id!='" . $mail_bidder_id . "' AND 
	b.bid_out=1 AND b.email_sent=0 GROUP BY bidder_id");

$send = true; ## always send

## send to all the winners of the auction for which the bank details have been set/changed
while ($bid_details = $db->fetch_array($sql_select_auctions))
{
	## text message - editable
	$text_message = 'Kính gửi %1$s,
	
Giá đặt của bạn trong phiên đấu %2$s đã bị vượt qua.
	
Để xem chi tiết đấu giá, vui lòng bấm vào đường dẫn bên dưới:
	
%3$s
	
Để xem lịch sử đấu giá, vui lòng bấm vào đường dẫn bên dưới:
	
%4$s
	
Trân trọng,
Ban quản trị %5$s';
	
	## html message - editable
	$html_message = 'Kính gửi %1$s, <br>
<br>
Giá đặt của bạn trong phiên đấu %2$s đã bị vượt qua. <br>
<br>
[ <a href="%3$s">Bấm vào đây</a> ] để xem chi tiết đấu giá. <br>
<br>
Để xem lịch sử đấu giá, vui lòng [ <a href="%4$s">bấm vào đây</a> ]. <br>
<br>
Trân trọng, <br>
Ban quản trị %5$s';
	
	
	$bid_history_link = SITE_PATH . 'login.php?redirect=' . process_link('bid_history', array('auction_id' => $bid_details['auction_id']));
	$auction_link = process_link('auction_details', array('name' => $bid_details['item_name'], 'auction_id' => $bid_details['auction_id']));
	
	$text_message = sprintf($text_message, $bid_details['buyer_name'], $bid_details['item_name'], $auction_link, $bid_history_link, $setts['sitename']);
	$html_message = sprintf($html_message, $bid_details['buyer_name'], $bid_details['item_name'], $auction_link, $bid_history_link, $setts['sitename']);

	send_mail($bid_details['email'], 'Mã đấu giá: ' . $bid_details['auction_id'] . ' - Thông báo giá đặt đã bị vượt qua', $text_message, 
		$setts['admin_email'], $html_message, null, $send);
}
?>