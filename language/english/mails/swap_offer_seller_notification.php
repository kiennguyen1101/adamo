<?php
## File Version -> v6.05
## Email File -> notify seller on a new swap offer placed 
## called only from the $item->place_offer() function!

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $offer_details = $this->get_sql_row("SELECT s.*, u.name, u.username, u.email, a.name AS item_name, a.currency FROM " . DB_PREFIX . "swaps s 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=s.seller_id
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=s.auction_id
	WHERE s.swap_id='" . $mail_input_id . "'");

  $send = true; // always sent;
## text message - editable
  $text_message = 'KÃ­nh gá»­i %1$s,

Má»™t Ä‘á» xuáº¥t trao Ä‘á»•i hÃ ng vá»«a Ä‘Æ°á»£c gá»­i trong phiÃªn Ä‘áº¥u giÃ¡ cá»§a báº¡n, %2$s.

Chi tiáº¿t Ä‘á» xuáº¥t:

	- Sá»‘ lÆ°á»£ng yÃªu cáº§u: %3$s
	
	- Sáº£n pháº©m Ä‘á» xuáº¥t: %4$s
	
Äá»ƒ xem táº¥t cáº£ cÃ¡c Ä‘á» xuáº¥t trong phiÃªn Ä‘áº¥u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:

%5$s

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %6$s';

## html message - editable
  $html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Má»™t Ä‘á» xuáº¥t trao Ä‘á»•i hÃ ng vá»«a Ä‘Æ°á»£c gá»­i trong phiÃªn Ä‘áº¥u giÃ¡ cá»§a báº¡n, %2$s. <br>
<br>
Chi tiáº¿t Ä‘á»u xuáº¥t: <br>
<ul>
	<li>Sá»‘ lÆ°á»£ng yÃªu cáº§u: <b>%3$s</b> </li>
	<li>Sáº£n pháº©m Ä‘á» xuáº¥t: %4$s </li>
</ul>
<br>
[ <a href="%5$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem táº¥t cáº£ cÃ¡c Ä‘á» xuáº¥t trong phiÃªn Ä‘áº¥u giÃ¡. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %6$s';


  $offer_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'selling', 'section' => 'view_offers', 'auction_id' => $offer_details['auction_id']), true);

  $text_message = sprintf($text_message, $offer_details['name'], $offer_details['item_name'], $offer_details['quantity'], $offer_details['description'], $offer_link, $this->setts['sitename']);
  $html_message = sprintf($html_message, $offer_details['name'], $offer_details['item_name'], $offer_details['quantity'], $offer_details['description'], $offer_link, $this->setts['sitename']);

  send_mail($offer_details['email'], 'MÃ£ Ä‘áº¥u giÃ¡: ' . $offer_details['auction_id'] . ' - Äá» xuáº¥t trao Ä‘á»•i hÃ ng', $text_message, $this->setts['admin_email'], $html_message, null, $send);
?>