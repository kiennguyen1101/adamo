<?php
## File Version -> v6.05
## Email File -> notify a buyer when a seller has created a new product invoice for him
## called only from the $item->send_invoice() function

if ( !defined('INCLUDED') ) { die("Access Denied"); }

$row_details = $this->get_sql_row("SELECT u.name, u.email, w.invoice_id FROM " . DB_PREFIX . "winners w 
	LEFT JOIN " . DB_PREFIX . "users u on u.user_id=w.buyer_id WHERE 
	w.invoice_id='" . $mail_input_id . "'");
$send = true; ## always send

## text message - editable
$text_message = 'Kính gửi %1$s,
	
Một hóa đơn từ người bán đã được gửi cho bạn.
	
Để xem hóa đơn, vui lòng bấm vào đường dẫn bên dưới:
	
%2$s
		
Trân trọng,
Ban quản trị %3$s';
	
## html message - editable
$html_message = 'Kính gửi %1$s, <br>
<br>
Một hóa đơn từ người bán đã được gửi cho bạn. <br>
<br>
Vui lòng [ <a href="%2$s">bấm vào đây</a> ] để xem hóa đơn. <br>
<br>
Trân trọng, <br>
Ban quản trị %3$s';
	
	
$invoice_link = SITE_PATH . 'login.php?redirect=' . process_link('invoice_print', array('invoice_type' => 'product_invoice', 'invoice_id' => $mail_input_id), true);
	
$text_message = sprintf($text_message, $row_details['name'], $invoice_link, $this->setts['sitename']);
$html_message = sprintf($html_message, $row_details['name'], $invoice_link, $this->setts['sitename']);

send_mail($row_details['email'], 'Hóa đơn sản phẩm - Mã hóa đơn: ' . $row_details['invoice_id'], $text_message, 
	$this->setts['admin_email'], $html_message, null, $send);
?>