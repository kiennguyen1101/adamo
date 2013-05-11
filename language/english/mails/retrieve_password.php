<?php
## Email File -> retrieve username
## called only from the retrieve_password.php page

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $row_details = $db->get_sql_row("SELECT u.name, u.username, u.email FROM " . DB_PREFIX . "users u WHERE u.username='" . $mail_input_id . "'");

  $send = true; // always sent;
## text message - editable
  $text_message = 'KÃ­nh gá»­i %1$s,

Máº­t kháº©u cá»§a báº¡n táº¡i %2$s Ä‘Ã£ Ä‘Æ°á»£c thiáº¿t láº­p láº¡i.

Chi tiáº¿t Ä‘Äƒng nháº­p:

	- TÃªn Ä‘Äƒng nháº­p: %3$s
	- Máº­t kháº©u: %4$s

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %2$s';

## html message - editable
  $html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Máº­t kháº©u cá»§a báº¡n táº¡i <b>%2$s</b> Ä‘Ã£ Ä‘Æ°á»£c thiáº¿t láº­p láº¡i. <br>
<br>
Chi tiáº¿t Ä‘Äƒng nháº­p:<br>
<ul>
	<li>TÃªn Ä‘Äƒng nháº­p: <b>%3$s</b></li>
	<li>Máº­t kháº©u: <b>%4$s</b></li>
</ul>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %2$s';


  $text_message = sprintf($text_message, $row_details['name'], $setts['sitename'], $row_details['username'], $new_password);
  $html_message = sprintf($html_message, $row_details['name'], $setts['sitename'], $row_details['username'], $new_password);

  send_mail($row_details['email'], $setts['sitename'] . ' - KhÃ´i phá»¥c thÃ´ng tin Ä‘Äƒng nháº­p', $text_message, $setts['admin_email'], $html_message, null, $send);
?>