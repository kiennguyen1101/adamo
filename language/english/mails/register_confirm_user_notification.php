<?php
## File Version -> v6.04
## Email File -> registration confirmation message
## called only from the register.php page

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  if ($mail_input_id) {
    $row_details = $db->get_sql_row("SELECT u.user_id, u.name, u.username, u.email FROM " . DB_PREFIX . "users u WHERE 
		u.user_id='" . $mail_input_id . "'");
  }
## otherwise row_details is provided from the file calling this email

  $send = true; // always sent;
## text message - editable
  $text_message = 'KÃ­nh gá»­i %1$s,

TÃ i khoáº£n cá»§a báº¡n táº¡i %2$s Ä‘Ã£ Ä‘Æ°á»£c Ä‘Äƒng kÃ½ thÃ nh cÃ´ng.

Chi tiáº¿t Ä‘Äƒng nháº­p:

	- TÃªn Ä‘Äƒng nháº­p: %3$s
	- Máº­t kháº©u: -áº©n-

Äá»ƒ kÃ­ch hoáº¡t tÃ i khoáº£n, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:

%4$s
	
TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %2$s';

## html message - editable
  $html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
TÃ i khoáº£n cá»§a báº¡n táº¡i <b>%2$s</b> Ä‘Ã£ Ä‘Æ°á»£c Ä‘Äƒng kÃ½ thÃ nh cÃ´ng. <br>
<br>
Chi tiáº¿t Ä‘Äƒng nháº­p:<br>
<ul>
	<li>TÃªn Ä‘Äƒng nháº­p: <b>%3$s</b></li>
	<li>Máº­t kháº©u: -áº©n-</li>
</ul>
Vui lÃ²ng [ <a href="%4$s">báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ kÃ­ch hoáº¡t tÃ i khoáº£n cá»§a báº¡n. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %2$s';


  $activation_link = SITE_PATH . 'account_activate.php?user_id=' . $row_details['user_id'] . '&username=' . $row_details['username'];

  $text_message = sprintf($text_message, $row_details['name'], $setts['sitename'], $row_details['username'], $activation_link);
  $html_message = sprintf($html_message, $row_details['name'], $setts['sitename'], $row_details['username'], $activation_link);

  send_mail($row_details['email'], $setts['sitename'] . ' - XÃ¡c nháº­n Ä‘Äƒng kÃ½', $text_message, $setts['admin_email'], $html_message, null, $send);
?>