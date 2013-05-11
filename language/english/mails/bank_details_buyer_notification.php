<?php
## File Version -> v6.05
## Email File -> notify buyer when the seller has posted bank details for an auction
## called only from the popup_bank_details.php page!

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $sql_select_auctions = $db->query("SELECT a.auction_id, a.name AS item_name, a.bank_details, 
	u.name AS buyer_name, u.username, u.email FROM " . DB_PREFIX . "winners w
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=w.auction_id
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=w.buyer_id
	WHERE w.auction_id='" . $mail_input_id . "'");

  $send = true; ## always send
## send to all the winners of the auction for which the bank details have been set/changed
  while ($bank_details = $db->fetch_array($sql_select_auctions)) {
    ## text message - editable
    $text_message = 'KÃ­nh gá»­i %1$s,
	
NgÆ°á»i khá»Ÿi táº¡o phiÃªn Ä‘áº¥u giÃ¡ %2$s, mÃ  báº¡n Ä‘Ã£ chiáº¿n tháº¯ng, vá»«a cáº­p nháº­t thÃ´ng tin tÃ i khoáº£n ngÃ¢n hÃ ng.
	
ThÃ´ng tin tÃ i khoáº£n cá»§a ngÆ°á»i bÃ¡n nhÆ° sau:
	
%3$s
	
Äá»ƒ xem chi tiáº¿t, vui lÃ²ng truy cáº­p trang CÃ¡c phiÃªn Ä‘Ã£ tháº¯ng, báº±ng cÃ¡ch báº¥m vÃ o Ä‘Æ°á»ng dáº«n URL dÆ°á»›i Ä‘Ã¢y:  
	
%4$s
	
Sau khi truy cáº­p vÃ o trang bÃªn trÃªn, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n "Xem thÃ´ng tin tÃ i khoáº£n ngÃ¢n hÃ ng" bÃªn cáº¡nh sáº£n pháº©m báº¡n chiáº¿n tháº¯ng.
	
TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %5$s';

    ## html message - editable
    $html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
NgÆ°á»i khá»Ÿi táº¡o phiÃªn Ä‘áº¥u giÃ¡ <b>%2$s</b>, mÃ  báº¡n Ä‘Ã£ chiáº¿n tháº¯ng, vá»«a cáº­p nháº­t thÃ´ng tin tÃ i khoáº£n ngÃ¢n hÃ ng. <br>
<br>
ThÃ´ng tin tÃ i khoáº£n cá»§a ngÆ°á»i bÃ¡n nhÆ° sau: <br>
<ul>
	<li>%3$s </li>
</ul>
<br>
Äá»ƒ xem chi tiáº¿t quÃ¡ trÃ¬nh mua hÃ ng, vui lÃ²ng truy cáº­p trang[ <a href="%4$s">CÃ¡c phiÃªn Ä‘Ã£ tháº¯ng</a> ]. <br>
<br>
Sau khi truy cáº­p vÃ o trang bÃªn trÃªn, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n "Xem thÃ´ng tin tÃ i khoáº£n ngÃ¢n hÃ ng" bÃªn cáº¡nh sáº£n pháº©m báº¡n chiáº¿n tháº¯ng. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %5$s';


    $items_won_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'bidding', 'section' => 'won_items'), true);
    //$auction_link = process_link('auction_details', array('name' => $bank_details['item_name'], 'auction_id' => $bank_details['auction_id']));

    $text_message = sprintf($text_message, $bank_details['buyer_name'], $bank_details['item_name'], $bank_details['bank_details'], $items_won_link, $setts['sitename']);
    $html_message = sprintf($html_message, $bank_details['buyer_name'], $bank_details['item_name'], $bank_details['bank_details'], $items_won_link, $setts['sitename']);

    send_mail($bank_details['email'], 'MÃ£ Ä‘áº¥u giÃ¡: ' . $bank_details['auction_id'] . ' - ThÃ´ng tin tÃ i khoáº£n ngÃ¢n hÃ ng', $text_message, $setts['admin_email'], $html_message, null, $send);
  }
?>