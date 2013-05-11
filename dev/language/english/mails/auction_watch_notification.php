<?php
## File Version -> v6.05
## Email File -> notify user when a bid is placed on an auction on his watch list
## called only from the bid.php page!

if ( !defined('INCLUDED') ) { die("Access Denied"); }
 
$sql_select_auctions = $db->query("SELECT a.auction_id, a.name AS item_name,  
	u.name AS buyer_name, u.username, u.email FROM " . DB_PREFIX . "auction_watch aw
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=aw.auction_id
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=aw.user_id
	WHERE aw.auction_id='" . $mail_input_id . "'");

$send = true; ## always send

## send to all the winners of the auction for which the bank details have been set/changed
while ($watch_details = $db->fetch_array($sql_select_auctions))
{
	## text message - editable
	$text_message = 'KÃ­nh gá»­i %1$s,
	
Má»™t ngÆ°á»i vá»«a Ä‘áº·t giÃ¡ cho sáº£n pháº©m náº±m trong danh sÃ¡ch theo dÃµi cá»§a báº¡n, %2$s.
	
Äá»ƒ xem chi tiáº¿t phiÃªn Ä‘áº¥u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n URL bÃªn dÆ°á»›i:
	
%3$s
	
Äá»ƒ xem lá»‹ch sá»­ phiÃªn Ä‘áº¥u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n sau:
	
%4$s
	
TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %5$s';
	
	## html message - editable
	$html_message = 'Dear %1$s, <br>
<br>
Má»™t ngÆ°á»i vá»«a Ä‘áº·t giÃ¡ cho sáº£n pháº©m náº±m trong danh sÃ¡ch theo dÃµi cá»§a báº¡n, %2$s. <br>
<br>
[ <a href="%3$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem chi tiáº¿t phiÃªn Ä‘áº¥u giÃ¡. <br>
<br>
Äá»ƒ xem lá»‹ch sá»­ phiÃªn Ä‘áº¥u giÃ¡, vui lÃ²ng [ <a href="%4$s">báº¥m vÃ o Ä‘Ã¢y</a> ]. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %5$s';
	
	
	$bid_history_link = SITE_PATH . 'login.php?redirect=' . process_link('bid_history', array('auction_id' => $watch_details['auction_id']));
	$auction_link = process_link('auction_details', array('name' => $watch_details['item_name'], 'auction_id' => $watch_details['auction_id']));
	
	$text_message = sprintf($text_message, $watch_details['buyer_name'], $watch_details['item_name'], $auction_link, $bid_history_link, $setts['sitename']);
	$html_message = sprintf($html_message, $watch_details['buyer_name'], $watch_details['item_name'], $auction_link, $bid_history_link, $setts['sitename']);
	
	send_mail($watch_details['email'], 'MÃ£ Ä‘áº¥u giÃ¡: ' . $watch_details['auction_id'] . ' - Theo dÃµi sáº£n pháº©m', $text_message, 
		$setts['admin_email'], $html_message, null, $send);
}
?>