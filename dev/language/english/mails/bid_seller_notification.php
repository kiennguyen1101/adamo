<?php
## File Version -> v6.02
## Email File -> notify seller when a bid is placed
## called only from the bid.php page!

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $bid_details = $db->get_sql_row("SELECT a.*, u.name AS seller_name, u.username, u.email, u.default_bid_placed_email 
	FROM " . DB_PREFIX . "auctions a 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id
	WHERE a.auction_id='" . $mail_input_id . "'");

  $send = ($bid_details['default_bid_placed_email']) ? true : false;

## text message - editable
  $text_message = 'KÃ­nh gá»­i %1$s,

Má»™t ngÆ°á»i vá»«a Ä‘áº·t giÃ¡ trong phiÃªn Ä‘áº¥u giÃ¡ do báº¡n khá»Ÿi táº¡o, %2$s.

Äá»ƒ xem trang Ä‘Ã¢u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:

%3$s
	
TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %4$s';

## html message - editable
  $html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Má»™t ngÆ°á»i vá»«a Ä‘áº·t giÃ¡ trong phiÃªn Ä‘áº¥u giÃ¡ do báº¡n khá»Ÿi táº¡o, %2$s. <br>
<br>
[ <a href="%3$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem trang Ä‘áº¥u giÃ¡. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %4$s';


  $auction_link = process_link('auction_details', array('name' => $bid_details['name'], 'auction_id' => $bid_details['auction_id']));

  $text_message = sprintf($text_message, $bid_details['seller_name'], $bid_details['name'], $auction_link, $setts['sitename']);
  $html_message = sprintf($html_message, $bid_details['seller_name'], $bid_details['name'], $auction_link, $setts['sitename']);

  send_mail($bid_details['email'], 'MÃ£ Ä‘áº¥u giÃ¡: ' . $bid_details['auction_id'] . ' - GiÃ¡ Ä‘áº·t má»›i', $text_message, $setts['admin_email'], $html_message, null, $send);
?>