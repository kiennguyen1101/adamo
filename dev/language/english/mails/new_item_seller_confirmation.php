<?php
## Email File -> confirm posting to the seller
## called only from the sell_item.php page

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $row_details = $db->get_sql_row("SELECT a.*, u.name AS user_name, u.email, u.mail_confirm_to_seller FROM " . DB_PREFIX . "auctions a
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id WHERE a.auction_id='" . $mail_input_id . "'");

  $send = ($row_details['mail_confirm_to_seller']) ? true : false;

## text message - editable
  $text_message = 'KÃ­nh gá»­i %1$s,

Báº¡n vá»«a khá»Ÿi táº¡o phiÃªn Ä‘áº¥u giÃ¡ táº¡i %2$s:

	- TÃªn Ä‘áº¥u giÃ¡: %3$s
	- Sá»‘ lÆ°á»£ng sáº£n pháº©m: %5$s
	- NhÃ³m sáº£n pháº©m: %6$s

	- GiÃ¡ khá»Ÿi Ä‘iá»ƒm: %8$s
	- GiÃ¡ mua ngay: %9$s
	- GiÃ¡ mong muá»‘n: %10$s

	- NgÃ y káº¿t thÃºc: %11$s

Äá»ƒ xem trang Ä‘áº¥u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:

%12$s

Cáº£m Æ¡n báº¡n vÃ¬ Ä‘Ã£ sá»­ dá»¥ng dá»‹ch vá»¥ cá»§a Adamo.

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %13$s';

## html message - editable
  $html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Báº¡n vá»«a khá»Ÿi táº¡o phiÃªn Ä‘áº¥u giÃ¡ táº¡i <b>%2$s</b>: <br>
<ul>
	<li>TÃªn Ä‘áº¥u giÃ¡: <b>%3$s</b> </li>
	<li>Loáº¡i Ä‘áº¥u giÃ¡: <b>%4$s</b> </li>
	<li>Sá»‘ lÆ°á»£ng Ä‘áº¥u giÃ¡: <b>%5$s</b> </li>
</ul>
<ul>
	<li>NhÃ³m sáº£n pháº©m: <b>%6$s</b> </li>
	<li>NhÃ³m phá»¥: <b>%7$s</b> </li>
</ul>
<ul>
	<li>GiÃ¡ khá»Ÿi Ä‘iá»ƒm: <b>%8$s</b> </li>
	<li>GiÃ¡ mua ngay: <b>%9$s</b> </li>
	<li>GiÃ¡ mong muá»‘n: <b>%10$s</b> </li>
</ul>
<ul>
	<li>NgÃ y káº¿t thÃºc: <b>%11$s</b> </li>
</ul>
[ <a href="%12$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem trang Ä‘áº¥u giÃ¡. <br>
<br>
Cáº£m Æ¡n báº¡n vÃ¬ Ä‘Ã£ sá»­ dá»¥ng dá»‹ch vá»¥ cá»§a Adamo. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %13$s';


  $main_category = category_navigator($row_details['category_id'], false, true, null, null, GMSG_NONE_CAT);
  $addl_category = category_navigator($row_details['addl_category_id'], false, true, null, null, GMSG_NONE_CAT);

  $start_price = $fees->display_amount($row_details['start_price'], $row_details['currency']);
  $buyout_price = $fees->display_amount($row_details['buyout_price'], $row_details['currency']);
  $reserve_price = $fees->display_amount($row_details['reserve_price'], $row_details['currency']);

  $closing_date = show_date($row_details['end_time']);

  $auction_link = process_link('auction_details', array('name' => $row_details['name'], 'auction_id' => $row_details['auction_id']));


  $text_message = sprintf($text_message, $row_details['user_name'], $setts['sitename'], $row_details['name'], $row_details['auction_type'], $row_details['quantity'], $main_category, $addl_category, $start_price, $buyout_price, $reserve_price, $closing_date, $auction_link, $setts['sitename']);

  $html_message = sprintf($html_message, $row_details['user_name'], $setts['sitename'], $row_details['name'], $row_details['auction_type'], $row_details['quantity'], $main_category, $addl_category, $start_price, $buyout_price, $reserve_price, $closing_date, $auction_link, $setts['sitename']);

  send_mail($row_details['email'], 'XÃ¡c nháº­n khá»Ÿi táº¡o Ä‘áº¥u giÃ¡', $text_message, $setts['admin_email'], $html_message, null, $send);
?>