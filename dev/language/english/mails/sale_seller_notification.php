<?php
## File Version -> v6.05
## Email File -> notify seller on a successful sale
## called only from the $item->assign_winner() function!

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $sale_details = $this->get_sql_row("SELECT w.*, u.name, u.username, u.email, u.mail_item_sold, 
	a.name AS item_name, a.currency FROM " . DB_PREFIX . "winners w 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=w.seller_id
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=w.auction_id
	WHERE w.winner_id='" . $mail_input_id . "'");

  $send = ($sale_details['mail_item_sold']) ? true : false;

## text message - editable
  $text_message = 'KÃ­nh gá»­i %1$s,

Sáº£n pháº©m Ä‘áº¥u giÃ¡ cá»§a báº¡n, %2$s, Ä‘Ã£ Ä‘Æ°á»£c bÃ¡n thÃ nh cÃ´ng.

Chi tiáº¿t:

	- GiÃ¡: %3$s
	- Sá»‘ lÆ°á»£ng: %4$s
	- PhiÃªn Ä‘áº¥u: %7$s
	
Äá»ƒ xem thÃªm chi tiáº¿t , vui lÃ²ng truy cáº­p trang "Sáº£n pháº©m Ä‘Ã£ bÃ¡n" báº±ng cÃ¡ch báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:  

%5$s

Sau khi truy cáº­p trang, vui lÃ²ng báº¥m vÃ o "Báº£ng tin nháº¯n" bÃªn cáº¡nh sáº£n pháº©m.
"Báº£ng tin nháº¯n" lÃ  cÃ´ng cá»¥ liÃªn há»‡ trá»±c tiáº¿p vá»›i ngÆ°á»i mua sáº£n pháº©m. Vui lÃ²ng sá»­ dá»¥ng báº£ng tin nháº¯n Ä‘á»ƒ Ä‘áº·t cÃ¢u há»i liÃªn quan Ä‘áº¿n thanh toÃ¡n vÃ  giao nháº­n.

Quan trá»ng: CÃ¡c trao Ä‘á»•i giá»¯a báº¡n vÃ  ngÆ°á»i bÃ¡n trong Báº£ng tin nháº¯n lÃ  cÆ¡ sá»Ÿ giáº£i quyáº¿t tranh cháº¥p phÃ¡t sinh.

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %6$s';

## html message - editable
  $html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Sáº£n pháº©m Ä‘áº¥u giÃ¡ cá»§a báº¡n, %2$s, Ä‘Ã£ Ä‘Æ°á»£c bÃ¡n thÃ nh cÃ´ng. <br>
<br>
Sale Details: <br>
<ul>
	<li>GiÃ¡: <b>%3$s</b> </li>
	<li>Sá»‘ lÆ°á»£ng: <b>%4$s</b> </li>
	<li>PhiÃªn Ä‘áº¥u: [ <a href="%7$s">Báº¥m vÃ o Ä‘á»ƒ xem</a> ] </li>
</ul>
Äá»ƒ xem thÃªm chi tiáº¿t , vui lÃ²ng truy cáº­p trang [ <a href="%5$s">Sáº£n pháº©m Ä‘Ã£ bÃ¡n</a> ]. <br>
<br>
Sau khi truy cáº­p trang, vui lÃ²ng báº¥m vÃ o "Báº£ng tin nháº¯n" bÃªn cáº¡nh sáº£n pháº©m. <br>
"Báº£ng tin nháº¯n" lÃ  cÃ´ng cá»¥ liÃªn há»‡ trá»±c tiáº¿p vá»›i ngÆ°á»i mua sáº£n pháº©m. Vui lÃ²ng sá»­ dá»¥ng báº£ng tin nháº¯n Ä‘á»ƒ Ä‘áº·t cÃ¢u há»i liÃªn quan Ä‘áº¿n thanh toÃ¡n vÃ  giao nháº­n. <br>
<br>
Quan trá»ng: CÃ¡c trao Ä‘á»•i giá»¯a báº¡n vÃ  ngÆ°á»i bÃ¡n trong Báº£ng tin nháº¯n lÃ  cÆ¡ sá»Ÿ giáº£i quyáº¿t tranh cháº¥p phÃ¡t sinh. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %6$s';


  $items_sold_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'selling', 'section' => 'sold'), true);
  $auction_link = process_link('auction_details', array('name' => $sale_details['item_name'], 'auction_id' => $sale_details['auction_id']));

  $this->fees = new fees();
  $this->fees->setts = $this->setts;
  $sale_price = $this->fees->display_amount($sale_details['bid_amount'], $sale_details['currency']);

  $text_message = sprintf($text_message, $sale_details['name'], $sale_details['item_name'], $sale_price, $sale_details['quantity_offered'], $items_sold_link, $this->setts['sitename'], $auction_link);
  $html_message = sprintf($html_message, $sale_details['name'], $sale_details['item_name'], $sale_price, $sale_details['quantity_offered'], $items_sold_link, $this->setts['sitename'], $auction_link);

  send_mail($sale_details['email'], 'MÃ£ Ä‘áº¥u giÃ¡: ' . $sale_details['auction_id'] . ' - BÃ¡n thÃ nh cÃ´ng', $text_message, $this->setts['admin_email'], $html_message, null, $send);
?>