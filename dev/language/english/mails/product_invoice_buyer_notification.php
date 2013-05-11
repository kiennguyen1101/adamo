<?php
## File Version -> v6.05
## Email File -> notify a buyer when a seller has created a new product invoice for him
## called only from the $item->send_invoice() function

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $row_details = $this->get_sql_row("SELECT u.name, u.email, w.invoice_id FROM " . DB_PREFIX . "winners w 
	LEFT JOIN " . DB_PREFIX . "users u on u.user_id=w.buyer_id WHERE 
	w.invoice_id='" . $mail_input_id . "'");
  $send = true; ## always send
## text message - editable
  $text_message = 'KÃ­nh gá»­i %1$s,
	
Má»™t hÃ³a Ä‘Æ¡n tá»« ngÆ°á»i bÃ¡n Ä‘Ã£ Ä‘Æ°á»£c gá»­i cho báº¡n.
	
Äá»ƒ xem hÃ³a Ä‘Æ¡n, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:
	
%2$s
		
TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %3$s';

## html message - editable
  $html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Má»™t hÃ³a Ä‘Æ¡n tá»« ngÆ°á»i bÃ¡n Ä‘Ã£ Ä‘Æ°á»£c gá»­i cho báº¡n. <br>
<br>
Vui lÃ²ng [ <a href="%2$s">báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem hÃ³a Ä‘Æ¡n. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %3$s';


  $invoice_link = SITE_PATH . 'login.php?redirect=' . process_link('invoice_print', array('invoice_type' => 'product_invoice', 'invoice_id' => $mail_input_id), true);

  $text_message = sprintf($text_message, $row_details['name'], $invoice_link, $this->setts['sitename']);
  $html_message = sprintf($html_message, $row_details['name'], $invoice_link, $this->setts['sitename']);

  send_mail($row_details['email'], 'HÃ³a Ä‘Æ¡n sáº£n pháº©m - MÃ£ hÃ³a Ä‘Æ¡n: ' . $row_details['invoice_id'], $text_message, $this->setts['admin_email'], $html_message, null, $send);
?>