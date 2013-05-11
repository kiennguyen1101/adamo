<?php
## File Version -> v6.02
## Email File -> notify seller when a bid is placed
## called only from the bid.php page!

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $bid_details = $db->get_sql_row("SELECT a.*, u.name AS seller_name, u.username, u.email, u.default_bid_placed_email 
	FROM " . DB_PREFIX . "auctions a 
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id
	WHERE a.auction_id='" . $mail_input_id . "'");

  $send = ($bid_details['default_bid_placed_email']) ? true : false;

## text message - editable
  $text_message = 'Kính gửi %1$s,

Một người vừa đặt giá trong phiên đấu giá do bạn khởi tạo, %2$s.

Để xem trang đâu giá, vui lòng bấm vào đường dẫn bên dưới:

%3$s
	
Trân trọng,
Ban quản trị %4$s';

## html message - editable
  $html_message = 'Kính gửi %1$s, <br>
<br>
Một người vừa đặt giá trong phiên đấu giá do bạn khởi tạo, %2$s. <br>
<br>
[ <a href="%3$s">Bấm vào đây</a> ] để xem trang đấu giá. <br>
<br>
Trân trọng, <br>
Ban quản trị %4$s';


  $auction_link = process_link('auction_details', array('name' => $bid_details['name'], 'auction_id' => $bid_details['auction_id']));

  $text_message = sprintf($text_message, $bid_details['seller_name'], $bid_details['name'], $auction_link, $setts['sitename']);
  $html_message = sprintf($html_message, $bid_details['seller_name'], $bid_details['name'], $auction_link, $setts['sitename']);

  send_mail($bid_details['email'], 'Mã đấu giá: ' . $bid_details['auction_id'] . ' - Giá đặt mới', $text_message, $setts['admin_email'], $html_message, null, $send);
?>