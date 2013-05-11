<?php
## File Version -> v6.02
## Email File -> notify user when his auction is approved by the admin
## called only from admin/list_auctions.php

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $db->get_sql_row("SELECT a.*, u.name AS user_name, u.username, u.email FROM " . DB_PREFIX . "auctions a
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id
	WHERE a.auction_id='" . $mail_input_id . "'");

$send = true; ## always sent

## text message - editable
$text_message = 'KÃ­nh gá»­i %1$s,

PhiÃªn Ä‘áº¥u giÃ¡ cá»§a báº¡n , %2$s, Ä‘Ã£ Ä‘Æ°á»£c phÃª duyá»‡t.

Äá»ƒ xem chi tiáº¿t phiÃªn Ä‘áº¥u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n URL bÃªn dÆ°á»›i:
	
%3$s

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %4$s';

## html message - editable
$html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
PhiÃªn Ä‘áº¥u giÃ¡ cá»§a báº¡n , %2$s, Ä‘Ã£ Ä‘Æ°á»£c phÃª duyá»‡t.
<br>
[ <a href="%3$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem chi tiáº¿t phiÃªn Ä‘áº¥u giÃ¡.  <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %4$s ';


$auction_link = process_link('auction_details', array('name' => $row_details['name'], 'auction_id' => $row_details['auction_id']));

$text_message = sprintf($text_message, $row_details['user_name'], $row_details['name'], $auction_link, $setts['sitename']);
$html_message = sprintf($html_message, $row_details['user_name'], $row_details['name'], $auction_link, $setts['sitename']);

send_mail($row_details['email'], 'Auction ID: ' . $row_details['auction_id'] . ' - Approval Successful', $text_message, 
	$setts['admin_email'], $html_message, null, $send);
?>