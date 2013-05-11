<?php
## File Version -> v6.04
## Email File -> registration success - signup fee disabled
## called only from the register.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.name, u.username, u.email FROM " . DB_PREFIX . "users u WHERE u.user_id='" . $mail_input_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'KÃ­nh gá»­i %1$s,

TÃ i khoáº£n cá»§a báº¡n táº¡i %2$s Ä‘Ã£ Ä‘Æ°á»£c kÃ­ch hoáº¡t thÃ nh cÃ´ng.

Chi tiáº¿t Ä‘Äƒng nháº­p:

	- TÃªn Ä‘Äƒng nháº­p: %3$s
	- Máº­t kháº©u: -áº©n-

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %2$s';

## html message - editable
$html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
TÃ i khoáº£n cá»§a báº¡n táº¡i <b>%2$s</b> Ä‘Ã£ Ä‘Æ°á»£c kÃ­ch hoáº¡t thÃ nh cÃ´ng. <br>
<br>
Chi tiáº¿t Ä‘Äƒng nháº­p:<br>
<ul>
	<li>TÃªn Ä‘Äƒng nháº­p: <b>%3$s</b></li>
	<li>Máº­t kháº©u: -áº©n-</li>
</ul>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %2$s';


$text_message = sprintf($text_message, $row_details['name'], $setts['sitename'], $row_details['username']);
$html_message = sprintf($html_message, $row_details['name'], $setts['sitename'], $row_details['username']);

send_mail($row_details['email'], $setts['sitename'] . ' - ÄÄƒng kÃ½ thÃ nh cÃ´ng', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>