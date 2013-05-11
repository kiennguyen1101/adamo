<?php
## File Version -> 6.05
## Email File -> notify the seller when the auction was not sold due to the reserve price not being met
## called only from item::assign_winner()

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $sql_select_auctions = $this->query("SELECT a.auction_id, a.owner_id, a.name AS item_name,  
	u.name AS seller_name, u.username, u.email, u.mail_item_sold FROM " . DB_PREFIX . "bids b
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=b.auction_id
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id
	WHERE b.auction_id='" . $mail_input_id . "' AND b.bid_out=0 AND b.bid_invalid=0 GROUP BY b.auction_id");


## send to the seller only
  while ($row_details = $this->fetch_array($sql_select_auctions)) {
    $send = ($row_details['mail_item_sold']) ? true : false;
    ## text message - editable
    $text_message = 'KÃ­nh gá»­i %1$s,
	
PhiÃªn Ä‘áº¥u giÃ¡ %$2s do báº¡n khá»Ÿi táº¡o Ä‘Ã£ bá»‹ Ä‘Ã³ng.
KhÃ´ng cÃ³ ngÆ°á»i tháº¯ng cuá»™c do chÆ°a Ä‘áº¡t giÃ¡ mong muá»‘n.
	
Äá»ƒ xem trang Ä‘áº¥u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:
	
%3$s
	
Äá»ƒ xem lá»‹ch sá»­ Ä‘áº¥u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:
	
%4$s
	
TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %5$s';

    ## html message - editable
    $html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
PhiÃªn Ä‘áº¥u giÃ¡ %$2s do báº¡n khá»Ÿi táº¡o Ä‘Ã£ bá»‹ Ä‘Ã³ng. <br>
KhÃ´ng cÃ³ ngÆ°á»i tháº¯ng cuá»™c do chÆ°a Ä‘áº¡t giÃ¡ mong muá»‘n. <br>
<br>
[ <a href="%3$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem trang Ä‘áº¥u giÃ¡. <br>
<br>
Äá»ƒ xem lá»‹ch sá»­ Ä‘áº¥u giÃ¡, vui lÃ²ng [ <a href="%4$s">báº¥m vÃ o Ä‘Ã¢y</a> ]. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %5$s';


    $bid_history_link = SITE_PATH . 'login.php?redirect=' . process_link('bid_history', array('auction_id' => $row_details['auction_id']));
    $auction_link = process_link('auction_details', array('name' => $row_details['item_name'], 'auction_id' => $row_details['auction_id']));

    $text_message = sprintf($text_message, $row_details['seller_name'], $row_details['item_name'], $auction_link, $bid_history_link, $this->setts['sitename']);
    $html_message = sprintf($html_message, $watch_details['seller_name'], $watch_details['item_name'], $auction_link, $bid_history_link, $this->setts['sitename']);

    send_mail($row_details['email'], 'MÃ£ Ä‘áº¥u giÃ¡: ' . $row_details['auction_id'] . ' - Äáº¥u giÃ¡ bá»‹ Ä‘Ã³ng', $text_message, $this->setts['admin_email'], $html_message, null, $send);
  }
?>