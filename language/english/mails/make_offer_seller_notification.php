<?php
## File Version -> v6.05
## Email File -> notify seller on a new offer placed 
## called only from the $item->place_offer() function!

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $offer_details = $this->get_sql_row("SELECT o.*, u.name, u.username, u.email, a.name AS item_name, a.currency FROM " . DB_PREFIX . "auction_offers o 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=o.seller_id
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=o.auction_id
	WHERE o.offer_id='" . $mail_input_id . "'");

  $send = true; // always sent;
## text message - editable
  $text_message = 'KÃ­nh gá»­i %1$s,

Má»™t Ä‘á»ƒ xuáº¥t giÃ¡ Ä‘Ã£ Ä‘Æ°á»£c gá»­i cho báº¡n, %2$s.

Chi tiáº¿t Ä‘á» xuáº¥t:

	- GiÃ¡: %3$s
	- Sá»‘ lÆ°á»£ng yÃªu cáº§u: %4$s
	
Äá»ƒ xem táº¥t cáº£ Ä‘á» xuáº¥t trong phiÃªn Ä‘áº¥u giÃ¡ cá»§a báº¡n, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:

%5$s

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %6$s';

## html message - editable
  $html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Má»™t Ä‘á» xuáº¥t giÃ¡ Ä‘Ã£ Ä‘Æ°á»£c gá»­i cho báº¡n, %2$s. <br>
<br>
Chi tiáº¿t Ä‘á» xuáº¥t: <br>
<ul>
	<li>GiÃ¡: <b>%3$s</b> </li>
	<li>Sá»‘ lÆ°á»£ng: <b>%4$s</b> </li>
</ul>
<br>
[ <a href="%5$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem táº¥t cáº£ Ä‘á» xuáº¥t trong phiÃªn Ä‘áº¥u giÃ¡ cá»§a báº¡n. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %6$s';


  $offer_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'selling', 'section' => 'view_offers', 'auction_id' => $offer_details['auction_id']), true);

  $this->fees = new fees();
  $this->fees->setts = $this->setts;
  $offer_price = $this->fees->display_amount($offer_details['amount'], $offer_details['currency']);

  $text_message = sprintf($text_message, $offer_details['name'], $offer_details['item_name'], $offer_price, $offer_details['quantity'], $offer_link, $this->setts['sitename']);
  $html_message = sprintf($html_message, $offer_details['name'], $offer_details['item_name'], $offer_price, $offer_details['quantity'], $offer_link, $this->setts['sitename']);

  send_mail($offer_details['email'], 'MÃ£ Ä‘áº¥u giÃ¡: ' . $offer_details['auction_id'] . ' - Äá» xuáº¥t giÃ¡ má»›i', $text_message, $this->setts['admin_email'], $html_message, null, $send);
?>