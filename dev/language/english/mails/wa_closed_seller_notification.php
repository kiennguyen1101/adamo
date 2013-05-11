<?php
## Email File -> notify seller if an wanted ad has closed
## called only from the main_cron.php page

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $row_details = $db->get_sql_row("SELECT u.name, u.username, u.email, u.mail_item_closed, 
	w.name AS item_name, w.wanted_ad_id FROM " . DB_PREFIX . "wanted_ads w
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=w.owner_id
	WHERE w.wanted_ad_id='" . $mail_input_id . "'");

  $send = ($row_details['mail_item_closed']) ? true : false;

## text message - editable
  $text_message = 'KÃ­nh gá»­i %1$s,

Rao vÄƒt %2$s cá»§a báº¡n Ä‘Ã£ bá»‹ Ä‘Ã³ng.

Äá»ƒ xem chi tiáº¿t rao váº·t, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:

%3$s

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %4$s';

## html message - editable
  $html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Rao váº·t %2$s cá»§a báº¡n Ä‘Ã£ bá»‹ Ä‘Ã³ng. <br>
[ <a href="%3$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem chi tiáº¿t rao váº·t. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %4$s';


  $auction_link = process_link('wanted_details', array('wanted_ad_id' => $row_details['wanted_ad_id']));

  $text_message = sprintf($text_message, $row_details['name'], $row_details['item_name'], $auction_link, $setts['sitename']);
  $html_message = sprintf($html_message, $row_details['name'], $row_details['item_name'], $auction_link, $setts['sitename']);

  send_mail($row_details['email'], 'MÃ£ rao váº·t: ' . $row_details['wanted_ad_id'] . ' - Rao váº·t Ä‘Ã£ Ä‘Ã³ng', $text_message, $setts['admin_email'], $html_message, null, $send);
?>