<?php
## File version -> v6.05
## Email File -> notify seller if multiple items have been relisted (manually or automatically)
## called only from the main_cron.php page

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$sql_select_auctions = $db->query("SELECT u.name, u.username, u.email, u.mail_confirm_to_seller FROM " . DB_PREFIX . "auctions a 
	LEFT JOIN " . DB_PREFIX . "users u ON a.owner_id=u.user_id WHERE 
	a.is_relisted_item=1 AND a.notif_item_relisted=0 GROUP BY a.owner_id");

while ($row_details = $db->fetch_array($sql_select_auctions))
{
	$send = ($row_details['mail_confirm_to_seller']) ? true : false;

	## text message - editable
	$text_message = 'Kính gửi %1$s,

Một trong các phiên đấu do bạn khởi tạo trê %2$s đã được đăng lại.

Để xem chi tiết phiên đấu giá được đăng lại, vui lòng bấm vào đường dẫn bên dưới:

%3$s

Trân trọng,
Ban quản trị %2$s';

## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Một trong các phiên đấu do bạn khởi tạo trê %2$s đã được đăng lại. <br>
<br>
[ <a href="%3$s">Bấm vào đây</a> ] để xem chi tiết phiên đấu giá được đăng lại. <br>
<br>
Trân trọng, <br>
Ban quản trị %2$s';


	$items_open_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'selling', 'section' => 'open'), true);
	
	$text_message = sprintf($text_message, $row_details['name'], $setts['sitename'], $items_open_link);
	$html_message = sprintf($html_message, $row_details['name'], $setts['sitename'], $items_open_link);
	
	send_mail($row_details['email'], 'Đấu giá được đăng lại', $text_message, 
		$setts['admin_email'], $html_message, null, $send);
}
?>