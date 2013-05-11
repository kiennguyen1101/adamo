<?php
## Email File -> email an auction to a friend
## called only from the $item->auction_friend() function!
## File Version -> v6.04

if ( !defined('INCLUDED') ) { die("Access Denied"); }

//$sender_details = $this->get_sql_row("SELECT u.name, u.email FROM " . DB_PREFIX . "users u WHERE u.user_id='" . $user_id . "'");

$send = true; // always sent;

## text message - editable
$text_message = 'KÃ­nh gá»­i %1$s,

Báº¡n cá»§a báº¡n, %2$s, Ä‘Ã£ chuyá»ƒn tiáº¿p má»™t phiÃªn Ä‘áº¥u giÃ¡, Ä‘Äƒng trÃªn %3$s Ä‘á»ƒ báº¡n cÃ³ thá»ƒ xem.

Äá»ƒ xem chi tiáº¿t phiÃªn Ä‘áº¥u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n URL bÃªn dÆ°á»›i:

%4$s

CÃ¡c bÃ¬nh luáº­n thÃªm: %5%s
TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %6$s';

## html message - editable
$html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Báº¡n cá»§a báº¡n, %2$s, Ä‘Ã£ chuyá»ƒn tiáº¿p má»™t phiÃªn Ä‘áº¥u giÃ¡, Ä‘Äƒng trÃªn %3$s Ä‘á»ƒ báº¡n cÃ³ thá»ƒ xem. <br>
<br>
[ <a href="%4$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem phiÃªn Ä‘áº¥u giÃ¡. <br>
<br>
CÃ¡c bÃ¬nh luáº­n thÃªm: %5$s <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %6$s';


$auction_link = process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));

$text_message = sprintf($text_message, $friend_name, $sender_name, $this->setts['sitename'], $auction_link, $comments, $this->setts['sitename']);
$html_message = sprintf($html_message, $friend_name, $sender_name, $this->setts['sitename'], $auction_link, $comments, $this->setts['sitename']);

send_mail($friend_email, 'HÃ£y xem phiÃªn Ä‘áº¥u giÃ¡', $text_message, 
	$sender_email, $html_message, $sender_name, $send);
?>