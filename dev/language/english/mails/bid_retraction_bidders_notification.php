<?php
## File Version -> v6.04
## Email File -> notify remaining bidders that a user has retracted his bids on an auction
## called only from the item->retract_bid() function!

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $sql_select_bids = $this->query("SELECT b.auction_id, a.name, u.name AS user_name, u.email FROM " . DB_PREFIX . "bids b 
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=b.auction_id 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=b.bidder_id WHERE 
	b.auction_id='" . $auction_id . "' AND b.bid_invalid=0 GROUP BY b.bidder_id");

  $send = true;

  while ($bid_details = $this->fetch_array($sql_select_bids)) {
    ## text message - editable
    $text_message = 'KÃ­nh gá»­i %1$s,
	
	Má»™t ngÆ°á»i Ä‘Ã£ há»§y giÃ¡ Ä‘áº¥u trong phiÃªn Ä‘áº¥u giÃ¡ cÃ³ báº¡n tham gia, %2$s.
	
	Äá»ƒ xem trang Ä‘áº¥u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:
	
	%3$s
	
	Äá»ƒ xem lá»‹ch sá»­ Ä‘áº¥u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:
	
	%4$s
		
	TrÃ¢n trá»ng,
	Ban quáº£n trá»‹ %5$s';

    ## html message - editable
    $html_message = 'Dear %1$s, <br>
	<br>
	Má»™t ngÆ°á»i Ä‘Ã£ há»§y giÃ¡ Ä‘áº¥u trong phiÃªn Ä‘áº¥u giÃ¡ cÃ³ báº¡n tham gia, %2$s. <br>
	<br>
	[ <a href="%3$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem trang Ä‘áº¥u giÃ¡. <br>
	[ <a href="%4$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem lá»‹ch sá»­ Ä‘áº¥u giÃ¡. <br>
	<br>
	TrÃ¢n trá»ng, <br>
	Ban quáº£n trá»‹ %5$s';


    $auction_link = process_link('auction_details', array('auction_id' => $bid_details['auction_id']));
    $bids_link = process_link('bid_history', array('auction_id' => $bid_details['auction_id']));

    $text_message = sprintf($text_message, $bid_details['user_name'], $bid_details['name'], $auction_link, $bids_link, $this->setts['sitename']);
    $html_message = sprintf($html_message, $bid_details['user_name'], $bid_details['name'], $auction_link, $bids_link, $this->setts['sitename']);

    send_mail($bid_details['email'], 'MÃ£ Ä‘áº¥u giÃ¡: ' . $bid_details['auction_id'] . ' - GiÃ¡ Ä‘áº¥u bá»‹ há»§y', $text_message, $this->setts['admin_email'], $html_message, null, $send);
  }
?>