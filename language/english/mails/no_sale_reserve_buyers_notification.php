<?php
## Email File -> notify user when a bid is placed on an auction on his watch list
## called only from the $item->assign_winner() function

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sql_select_auctions = $this->query("SELECT a.auction_id, a.name AS item_name,  
	u.name AS buyer_name, u.username, u.email, u.mail_item_won FROM " . DB_PREFIX . "bids b
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=b.auction_id
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=b.bidder_id
	WHERE b.auction_id='" . $mail_input_id . "' AND b.bid_out=0 AND b.bid_invalid=0");


## send to all the high bidder of the auction
while ($row_details = $this->fetch_array($sql_select_auctions))
{
	$send = ($row_details['mail_item_won']) ? true : false;
	## text message - editable
	$text_message = 'KÃ­nh gá»­i %1$s,
	
PhiÃªn Ä‘áº¥u giÃ¡ %$2s, mÃ  báº¡n hiá»‡n lÃ  ngÆ°á»i Ä‘áº·t giÃ¡ cao nháº¥t Ä‘Ã£ bá»‹ Ä‘Ã³ng.
PhiÃªn Ä‘áº¥u khÃ´ng cÃ³ ngÆ°á»i tháº¯ng cuá»™c vÃ¬ chÆ°a Ä‘áº¡t giÃ¡ mong muá»‘n cá»§a ngÆ°á»i bÃ¡n.
	
Äá»ƒ xem trang Ä‘áº¥u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:
	
%3$s
	
Äá»ƒ xem lá»‹ch sá»­ Ä‘áº¥u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:
	
%4$s
	
TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %5$s';
	
	## html message - editable
	$html_message = 'Dear %1$s, <br>
<br>
PhiÃªn Ä‘áº¥u giÃ¡ %$2s, mÃ  báº¡n hiá»‡n lÃ  ngÆ°á»i Ä‘áº·t giÃ¡ cao nháº¥t Ä‘Ã£ bá»‹ Ä‘Ã³ng. <br>
PhiÃªn Ä‘áº¥u khÃ´ng cÃ³ ngÆ°á»i tháº¯ng cuá»™c vÃ¬ chÆ°a Ä‘áº¡t giÃ¡ mong muá»‘n cá»§a ngÆ°á»i bÃ¡n. <br>
<br>
[ <a href="%3$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem trang Ä‘áº¥u giÃ¡. <br>
<br>
Äá»ƒ xem lá»‹ch sá»­ Ä‘áº¥u giÃ¡, vui lÃ²ng [ <a href="%4$s">báº¥m vÃ o Ä‘Ã¢y</a> ]. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %5$s';
	
	
	$bid_history_link = SITE_PATH . 'login.php?redirect=' . process_link('bid_history', array('auction_id' => $row_details['auction_id']));
	$auction_link = process_link('auction_details', array('name' => $row_details['item_name'], 'auction_id' => $row_details['auction_id']));
	
	$text_message = sprintf($text_message, $row_details['buyer_name'], $row_details['item_name'], $auction_link, $bid_history_link, $this->setts['sitename']);
	$html_message = sprintf($html_message, $watch_details['buyer_name'], $watch_details['item_name'], $auction_link, $bid_history_link, $this->setts['sitename']);
	
	send_mail($row_details['email'], 'MÃ£ Ä‘áº¥u giÃ¡: ' . $row_details['auction_id'] . ' - Äáº¥u giÃ¡ bá»‹ Ä‘Ã³ng', $text_message, 
		$this->setts['admin_email'], $html_message, null, $send);
}
?>