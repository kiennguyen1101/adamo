<?php
## File Version -> v6.05
## Email File -> notify user when a bid is placed on an auction on his watch list
## called only from the bid.php page!

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $sql_select_auctions = $db->query("SELECT a.auction_id, a.name AS item_name,  
	u.name AS buyer_name, u.username, u.email FROM " . DB_PREFIX . "auction_watch aw
	LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=aw.auction_id
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=aw.user_id
	WHERE aw.auction_id='" . $mail_input_id . "'");

  $send = true; ## always send
## send to all the winners of the auction for which the bank details have been set/changed
  while ($watch_details = $db->fetch_array($sql_select_auctions)) {
    ## text message - editable
    $text_message = 'Kính gửi %1$s,
	
Một người vừa đặt giá cho sản phẩm nằm trong danh sách theo dõi của bạn, %2$s.
	
Để xem chi tiết phiên đấu giá, vui lòng bấm vào đường dẫn URL bên dưới:
	
%3$s
	
Để xem lịch sử phiên đấu giá, vui lòng bấm vào đường dẫn sau:
	
%4$s
	
Trân trọng,
Ban quản trị %5$s';

    ## html message - editable
    $html_message = 'Dear %1$s, <br>
<br>
Một người vừa đặt giá cho sản phẩm nằm trong danh sách theo dõi của bạn, %2$s. <br>
<br>
[ <a href="%3$s">Bấm vào đây</a> ] để xem chi tiết phiên đấu giá. <br>
<br>
Để xem lịch sử phiên đấu giá, vui lòng [ <a href="%4$s">bấm vào đây</a> ]. <br>
<br>
Trân trọng, <br>
Ban quản trị %5$s';


    $bid_history_link = SITE_PATH . 'login.php?redirect=' . process_link('bid_history', array('auction_id' => $watch_details['auction_id']));
    $auction_link = process_link('auction_details', array('name' => $watch_details['item_name'], 'auction_id' => $watch_details['auction_id']));

    $text_message = sprintf($text_message, $watch_details['buyer_name'], $watch_details['item_name'], $auction_link, $bid_history_link, $setts['sitename']);
    $html_message = sprintf($html_message, $watch_details['buyer_name'], $watch_details['item_name'], $auction_link, $bid_history_link, $setts['sitename']);

    send_mail($watch_details['email'], 'Mã đấu giá: ' . $watch_details['auction_id'] . ' - Theo dõi sản phẩm', $text_message, $setts['admin_email'], $html_message, null, $send);
  }
?>