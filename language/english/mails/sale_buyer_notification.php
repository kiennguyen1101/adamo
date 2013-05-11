<?php
## File Version -> v6.05
## Email File -> notify buyer on a successful purchase
## called only from the $item->assign_winner() function!

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $sale_details = $this->get_sql_row("SELECT w.*, u.name, u.username, u.email, u.mail_item_won, 
	a.name AS item_name, a.currency FROM " . DB_PREFIX . "winners w 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=w.buyer_id
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=w.auction_id
	WHERE w.winner_id='" . $mail_input_id . "'");

  $send = ($sale_details['mail_item_won']) ? true : false;

## text message - editable
  $text_message = 'KÃ­nh gá»­i %1$s,

Báº¡n Ä‘Ã£ mua thÃ nh cÃ´ng sáº£n pháº©m %2$s.

Chi tiáº¿t mua sáº£n pháº©m:

	- GiÃ¡: %3$s
	- Sá»‘ lÆ°á»£ng: %4$s
	- PhiÃªn Ä‘áº¥u giÃ¡: %7$s
	
Äá»ƒ xem chi tiáº¿t mua sáº£n pháº©m, vui lÃ²ng truy cáº­p trang "CÃ¡c phiÃªn Ä‘Ã£ tháº¯ng" báº±ng cÃ¡ch báº¥m vÃ o Ä‘Æ°á»ng dáº«n dÆ°á»›i Ä‘Ã¢y:  

%5$s

Sau khi truy cáº­p trang bÃªn trÃªn, vui lÃ²ng báº¥m vÃ o "Báº£ng tin nháº¯n" cáº¡nh sáº£n pháº©m chiáº¿n tháº¯ng.
"Báº£ng tin nháº¯n" lÃ  lÃ  cÃ´ng cá»¥ liÃªn há»‡ trá»±c tiáº¿p vá»›i ngÆ°á»i bÃ¡n. Vui lÃ²ng sá»­ dá»¥ng báº£ng tin nháº¯n Ä‘á»ƒ Ä‘áº·t cÃ¢u há»i liÃªn quan Ä‘áº¿n sáº£n pháº©m cho ngÆ°á»i bÃ¡n.

Quan trá»ng: CÃ¡c trao Ä‘á»•i giá»¯a báº¡n vÃ  ngÆ°á»i bÃ¡n trong Báº£ng tin nháº¯n lÃ  cÆ¡ sá»Ÿ giáº£i quyáº¿t tranh cháº¥p phÃ¡t sinh.

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %6$s';

## html message - editable
  $html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Báº¡n Ä‘Ã£ mua thÃ nh cÃ´ng sáº£n pháº©m %2$s. <br>
<br>
Chi tiáº¿t mua sáº£n pháº©m: <br>
<ul>
	<li>GiÃ¡: <b>%3$s</b> </li>
	<li>Sá»‘ lÆ°á»£ng: <b>%4$s</b> </li>
	<li>PhiÃªn Ä‘áº¥u giÃ¡: [ <a href="%7$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] </li>
</ul>
Äá»ƒ xem chi tiáº¿t mua sáº£n pháº©m, vui lÃ²ng truy cáº­p trang [ <a href="%5$s">CÃ¡c phiÃªn Ä‘Ã£ tháº¯ng</a> ]. <br>
<br>
Sau khi truy cáº­p trang bÃªn trÃªn, vui lÃ²ng báº¥m vÃ o "Báº£ng tin nháº¯n" cáº¡nh sáº£n pháº©m chiáº¿n tháº¯ng. <br>
"Báº£ng tin nháº¯n" lÃ  lÃ  cÃ´ng cá»¥ liÃªn há»‡ trá»±c tiáº¿p vá»›i ngÆ°á»i bÃ¡n. Vui lÃ²ng sá»­ dá»¥ng báº£ng tin nháº¯n Ä‘á»ƒ Ä‘áº·t cÃ¢u há»i liÃªn quan Ä‘áº¿n sáº£n pháº©m cho ngÆ°á»i bÃ¡n. <br>
<br>
Quan trá»ng: CÃ¡c trao Ä‘á»•i giá»¯a báº¡n vÃ  ngÆ°á»i bÃ¡n trong Báº£ng tin nháº¯n lÃ  cÆ¡ sá»Ÿ giáº£i quyáº¿t tranh cháº¥p phÃ¡t sinh. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %6$s';


  $items_won_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'bidding', 'section' => 'won_items'), true);
  $auction_link = process_link('auction_details', array('name' => $sale_details['item_name'], 'auction_id' => $sale_details['auction_id']));

  $this->fees = new fees();
  $this->fees->setts = $this->setts;
  $sale_price = $this->fees->display_amount($sale_details['bid_amount'], $sale_details['currency']);

  $text_message = sprintf($text_message, $sale_details['name'], $sale_details['item_name'], $sale_price, $sale_details['quantity_offered'], $items_won_link, $this->setts['sitename'], $auction_link);
  $html_message = sprintf($html_message, $sale_details['name'], $sale_details['item_name'], $sale_price, $sale_details['quantity_offered'], $items_won_link, $this->setts['sitename'], $auction_link);

  send_mail($sale_details['email'], 'MÃ£ Ä‘áº¥u giÃ¡: ' . $sale_details['auction_id'] . ' - Mua thÃ nh cÃ´ng', $text_message, $this->setts['admin_email'], $html_message, null, $send);
?>