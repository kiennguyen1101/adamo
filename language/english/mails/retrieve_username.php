<?php
## Email File -> retrieve username
## called only from the retrieve_password.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT u.username, u.email FROM " . DB_PREFIX . "users u WHERE u.email='" . $mail_input_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'KÃ­nh gá»­i ngÆ°á»i dÃ¹ng,

TÃªn Ä‘Äƒng nháº­p cá»§a báº¡n táº¡i %1$s lÃ : %2$s

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %1$s';

## html message - editable
$html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
TÃªn Ä‘Äƒng nháº­p cá»§a báº¡n táº¡i %1$s lÃ  <b>%2$s</b> <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %1$s';


$text_message = sprintf($text_message, $setts['sitename'], $row_details['username']);
$html_message = sprintf($html_message, $setts['sitename'], $row_details['username']);

send_mail($row_details['email'], $setts['sitename'] . ' - KhÃ´i phá»¥c tÃªn Ä‘Äƒng nháº­p', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>