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
    $text_message = 'Kính gửi %1$s,
	
Người khởi tạo phiên đấu giá %2$s, mà bạn đã chiến thắng, vừa cập nhật thông tin tài khoản ngân hàng.
	
Thông tin tài khoản của người bán như sau:
	
%3$s
	
Để xem chi tiết, vui lòng truy cập trang Các phiên đã thắng, bằng cách bấm vào đường dẫn URL dưới đây:  
	
%4$s
	
Sau khi truy cập vào trang bên trên, vui lòng bấm vào đường dẫn "Xem thông tin tài khoản ngân hàng" bên cạnh sản phẩm bạn chiến thắng.
	
Trân trọng,
Ban quản trị %5$s';

    ## html message - editable
    $html_message = 'Kính gửi %1$s, <br>
<br>
Người khởi tạo phiên đấu giá <b>%2$s</b>, mà bạn đã chiến thắng, vừa cập nhật thông tin tài khoản ngân hàng. <br>
<br>
Thông tin tài khoản của người bán như sau: <br>
<ul>
	<li>%3$s </li>
</ul>
<br>
Để xem chi tiết quá trình mua hàng, vui lòng truy cập trang[ <a href="%4$s">Các phiên đã thắng</a> ]. <br>
<br>
Sau khi truy cập vào trang bên trên, vui lòng bấm vào đường dẫn "Xem thông tin tài khoản ngân hàng" bên cạnh sản phẩm bạn chiến thắng. <br>
<br>
Trân trọng, <br>
Ban quản trị %5$s';


    $items_won_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'bidding', 'section' => 'won_items'), true);
    //$auction_link = process_link('auction_details', array('name' => $bank_details['item_name'], 'auction_id' => $bank_details['auction_id']));

    $text_message = sprintf($text_message, $bank_details['buyer_name'], $bank_details['item_name'], $bank_details['bank_details'], $items_won_link, $setts['sitename']);
    $html_message = sprintf($html_message, $bank_details['buyer_name'], $bank_details['item_name'], $bank_details['bank_details'], $items_won_link, $setts['sitename']);

    send_mail($bank_details['email'], 'Mã đấu giá: ' . $bank_details['auction_id'] . ' - Thông tin tài khoản ngân hàng', $text_message, $setts['admin_email'], $html_message, null, $send);
  }
?>