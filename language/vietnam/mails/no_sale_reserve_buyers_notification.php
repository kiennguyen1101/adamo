﻿<?php
## Email File -> notify user when a bid is placed on an auction on his watch list
## called only from the $item->assign_winner() function

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $sql_select_auctions = $this->query("SELECT a.auction_id, a.name AS item_name,  
	u.name AS buyer_name, u.username, u.email, u.mail_item_won FROM " . DB_PREFIX . "bids b
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=b.auction_id
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=b.bidder_id
	WHERE b.auction_id='" . $mail_input_id . "' AND b.bid_out=0 AND b.bid_invalid=0");


## send to all the high bidder of the auction
  while ($row_details = $this->fetch_array($sql_select_auctions)) {
    $send = ($row_details['mail_item_won']) ? true : false;
    ## text message - editable
    $text_message = 'Dear %1$s,
	
The auction %$2s, on which you were the high bidder, has been closed.
No winner was assigned because the reserve price for the auction has not been met.
	
To view the details of the auction, please click on the URL below:
	
%3$s
	
To view the bid history for the auction, please click on the following link:
	
%4$s
	
Best regards,
The %5$s staff';

    ## html message - editable
    $html_message = 'Dear %1$s, <br>
<br>
The auction %$2s, on which you were the high bidder, has been closed. <br>
No winner was assigned because the reserve price for the auction has not been met. <br>
<br>
[ <a href="%3$s">Click here</a> ] to view the auction details page. <br>
<br>
To view the bid history for the auction, please [ <a href="%4$s">click here</a> ]. <br>
<br>
Best regards, <br>
The %5$s staff';


    $bid_history_link = SITE_PATH . 'login.php?redirect=' . process_link('bid_history', array('auction_id' => $row_details['auction_id']));
    $auction_link = process_link('auction_details', array('name' => $row_details['item_name'], 'auction_id' => $row_details['auction_id']));

    $text_message = sprintf($text_message, $row_details['buyer_name'], $row_details['item_name'], $auction_link, $bid_history_link, $this->setts['sitename']);
    $html_message = sprintf($html_message, $watch_details['buyer_name'], $watch_details['item_name'], $auction_link, $bid_history_link, $this->setts['sitename']);

    send_mail($row_details['email'], 'Auction ID: ' . $row_details['auction_id'] . ' - Auction Closed', $text_message, $this->setts['admin_email'], $html_message, null, $send);
  }
?>