<?php
## Email File -> email an auction to a friend
## called only from the $item->auction_friend() function!
## File Version -> v6.04

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

//$sender_details = $this->get_sql_row("SELECT u.name, u.email FROM " . DB_PREFIX . "users u WHERE u.user_id='" . $user_id . "'");

  $send = true; // always sent;
## text message - editable
  $text_message = 'Kính gửi %1$s,

Bạn của bạn, %2$s, đã chuyển tiếp một phiên đấu giá, đăng trên %3$s để bạn có thể xem.

Để xem chi tiết phiên đấu giá, vui lòng bấm vào đường dẫn URL bên dưới:

%4$s

Các bình luận thêm: %5%s
Trân trọng,
Ban quản trị %6$s';

## html message - editable
  $html_message = 'Kính gửi %1$s, <br>
<br>
Bạn của bạn, %2$s, đã chuyển tiếp một phiên đấu giá, đăng trên %3$s để bạn có thể xem. <br>
<br>
[ <a href="%4$s">Bấm vào đây</a> ] để xem phiên đấu giá. <br>
<br>
Các bình luận thêm: %5$s <br>
<br>
Trân trọng, <br>
Ban quản trị %6$s';


  $auction_link = process_link('auction_details', array('name' => $item_details['name'], 'auction_id' => $item_details['auction_id']));

  $text_message = sprintf($text_message, $friend_name, $sender_name, $this->setts['sitename'], $auction_link, $comments, $this->setts['sitename']);
  $html_message = sprintf($html_message, $friend_name, $sender_name, $this->setts['sitename'], $auction_link, $comments, $this->setts['sitename']);

  send_mail($friend_email, 'Hãy xem phiên đấu giá', $text_message, $sender_email, $html_message, $sender_name, $send);
?>