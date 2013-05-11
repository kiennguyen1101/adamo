<?php
## File Version -> v6.05
## Email File -> notify user on keywords watch
## called only from the insert() function!

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $keyword_search_string = $item_details['name'] . ' ' . $item_details['description'];

  $sql_select_auctions = $this->query("SELECT kw.keyword, a.auction_id, a.name AS item_name,  
	u.name AS user_name, u.username, u.email FROM " . DB_PREFIX . "keywords_watch kw
	INNER JOIN " . DB_PREFIX . "auctions a ON a.auction_id='" . $mail_input_id . "'
	INNER JOIN " . DB_PREFIX . "users u ON u.user_id=kw.user_id WHERE 
	MATCH (kw.keyword) AGAINST ('" . $keyword_search_string . "')");


  $send = true; ## always send
## send to all the winners of the auction for which the bank details have been set/changed
  while ($watch_details = $this->fetch_array($sql_select_auctions)) {
    ## text message - editable
    $text_message = 'KÃ­nh gá»­i %1$s,
	
Má»™t phiÃªn Ä‘áº¥u giÃ¡ phÃ¹ há»£p vá»›i tá»« khÃ³a trong danh sÃ¡ch theo dÃµi cá»§a báº¡n Ä‘Ã£ Ä‘Æ°á»£c khá»Ÿi táº¡o.

TÃªn phiÃªn Ä‘áº¥u giÃ¡: %2$s.
	
Äá»ƒ xem chi tiáº¿t phiÃªn Ä‘áº¥u giÃ¡, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:
	
%3$s
	
TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %4$s';

    ## html message - editable
    $html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Má»™t phiÃªn Ä‘áº¥u giÃ¡ phÃ¹ há»£p vá»›i tá»« khÃ³a trong danh sÃ¡ch theo dÃµi cá»§a báº¡n Ä‘Ã£ Ä‘Æ°á»£c khá»Ÿi táº¡o.<br>
<br>
TÃªn phiÃªn Ä‘áº¥u giÃ¡: <b>%2$s</b><br>
<br>
[ <a href="%3$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem chi tiáº¿t phiÃªn Ä‘áº¥u giÃ¡. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %4$s';


    $auction_link = process_link('auction_details', array('name' => $watch_details['item_name'], 'auction_id' => $watch_details['auction_id']));

    $text_message = sprintf($text_message, $watch_details['user_name'], $watch_details['item_name'], $auction_link, $this->setts['sitename']);
    $html_message = sprintf($html_message, $watch_details['user_name'], $watch_details['item_name'], $auction_link, $this->setts['sitename']);

    if (!empty($watch_details['email'])) {
      send_mail($watch_details['email'], 'Theo dÃµi báº±ng tá»« khÃ³a: ' . $watch_details['keyword'], $text_message, $this->setts['admin_email'], $html_message, null, $send);
    }
  }
?>