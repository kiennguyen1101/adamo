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
    $text_message = 'Kính gửi %1$s,
	
	Một người đã hủy giá đấu trong phiên đấu giá có bạn tham gia, %2$s.
	
	Để xem trang đấu giá, vui lòng bấm vào đường dẫn bên dưới:
	
	%3$s
	
	Để xem lịch sử đấu giá, vui lòng bấm vào đường dẫn bên dưới:
	
	%4$s
		
	Trân trọng,
	Ban quản trị %5$s';

    ## html message - editable
    $html_message = 'Dear %1$s, <br>
	<br>
	Một người đã hủy giá đấu trong phiên đấu giá có bạn tham gia, %2$s. <br>
	<br>
	[ <a href="%3$s">Bấm vào đây</a> ] để xem trang đấu giá. <br>
	[ <a href="%4$s">Bấm vào đây</a> ] để xem lịch sử đấu giá. <br>
	<br>
	Trân trọng, <br>
	Ban quản trị %5$s';


    $auction_link = process_link('auction_details', array('auction_id' => $bid_details['auction_id']));
    $bids_link = process_link('bid_history', array('auction_id' => $bid_details['auction_id']));

    $text_message = sprintf($text_message, $bid_details['user_name'], $bid_details['name'], $auction_link, $bids_link, $this->setts['sitename']);
    $html_message = sprintf($html_message, $bid_details['user_name'], $bid_details['name'], $auction_link, $bids_link, $this->setts['sitename']);

    send_mail($bid_details['email'], 'Mã đấu giá: ' . $bid_details['auction_id'] . ' - Giá đấu bị hủy', $text_message, $this->setts['admin_email'], $html_message, null, $send);
  }
?>