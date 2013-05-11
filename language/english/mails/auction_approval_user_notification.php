<?php
## File Version -> v6.02
## Email File -> notify user when his auction is approved by the admin
## called only from admin/list_auctions.php

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $row_details = $db->get_sql_row("SELECT a.*, u.name AS user_name, u.username, u.email FROM " . DB_PREFIX . "auctions a
	LEFT JOIN " . DB_PREFIX . "users u ON u.user_id=a.owner_id
	WHERE a.auction_id='" . $mail_input_id . "'");

  $send = true; ## always sent
## text message - editable
  $text_message = 'Kính gửi %1$s,

Phiên đấu giá của bạn , %2$s, đã được phê duyệt.

Để xem chi tiết phiên đấu giá, vui lòng bấm vào đường dẫn URL bên dưới:
	
%3$s

Trân trọng,
Ban quản trị %4$s';

## html message - editable
  $html_message = 'Kính gửi %1$s, <br>
<br>
Phiên đấu giá của bạn , %2$s, đã được phê duyệt.
<br>
[ <a href="%3$s">Bấm vào đây</a> ] để xem chi tiết phiên đấu giá.  <br>
<br>
Trân trọng, <br>
Ban quản trị %4$s ';


  $auction_link = process_link('auction_details', array('name' => $row_details['name'], 'auction_id' => $row_details['auction_id']));

  $text_message = sprintf($text_message, $row_details['user_name'], $row_details['name'], $auction_link, $setts['sitename']);
  $html_message = sprintf($html_message, $row_details['user_name'], $row_details['name'], $auction_link, $setts['sitename']);

  send_mail($row_details['email'], 'Auction ID: ' . $row_details['auction_id'] . ' - Approval Successful', $text_message, $setts['admin_email'], $html_message, null, $send);
?>