<?php
## Email File -> notify bidder if his offer is deleted (works with all 3 offer types)
## called only from the $item->delete_offer() function!

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $bidder_row = ($offer_table == 'bids') ? 'bidder_id' : 'buyer_id';

  $row_details = $this->get_sql_row("SELECT a.*, u.name AS user_name, u.email FROM 
	" . DB_PREFIX . $offer_table . " o
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=o.auction_id 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=o." . $bidder_row . " WHERE
	o." . $offer_id_name . "='" . $offer_id . "' AND a.owner_id='" . $user_id . "'");

  $send = true; // always sent;
## text message - editable
  $text_message = 'KÃ­nh gá»­i %1$s,

Äá» xuáº¥t giÃ¡ %2$s cá»§a báº¡n trong phiÃªn Ä‘áº¥u %3$s Ä‘Ã£ bá»‹ xÃ³a bá»Ÿi ngÆ°á»i bÃ¡n.

Äá»ƒ xem chi tiáº¿t phiÃªn Ä‘áº¥u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:
	
%4$s

TrÃ¢n trá»ng
Ban quáº£n trá»‹ %5$s';

## html message - editable
  $html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Äá» xuáº¥t giÃ¡ %2$s cá»§a báº¡n trong phiÃªn Ä‘áº¥u %3$s Ä‘Ã£ bá»‹ xÃ³a bá»Ÿi ngÆ°á»i bÃ¡n. <br>
<br>
[ <a href="%4$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem chi tiáº¿t phiÃªn Ä‘áº¥u giÃ¡. <br>
<br>

TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %5$s';


  $offer_type = ($offer_table == 'bids') ? 'reserve' : 'fixed price';
  $offer_type = ($offer_table == 'swaps') ? 'swap' : $offer_type;

  $auction_link = process_link('auction_details', array('name' => $row_details['name'], 'auction_id' => $row_details['auction_id']));

  $text_message = sprintf($text_message, $row_details['user_name'], $offer_type, $row_details['name'], $auction_link, $this->setts['sitename']);
  $html_message = sprintf($html_message, $row_details['user_name'], $offer_type, $row_details['name'], $auction_link, $this->setts['sitename']);

  send_mail($row_details['email'], 'MÃ£ Ä‘áº¥u giÃ¡: ' . $offer_details['auction_id'] . ' - Äá» xuáº¥t giÃ¡ bá»‹ tá»« chá»‘i', $text_message, $this->setts['admin_email'], $html_message, null, $send);
?>