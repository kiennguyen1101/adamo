<?php
## File version -> v6.05
## Email File -> notify seller if multiple items have been relisted (manually or automatically)
## called only from the main_cron.php page

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }

  $sql_select_auctions = $db->query("SELECT u.name, u.username, u.email, u.mail_confirm_to_seller FROM " . DB_PREFIX . "auctions a 
	LEFT JOIN " . DB_PREFIX . "users u ON a.owner_id=u.user_id WHERE 
	a.is_relisted_item=1 AND a.notif_item_relisted=0 GROUP BY a.owner_id");

  while ($row_details = $db->fetch_array($sql_select_auctions)) {
    $send = ($row_details['mail_confirm_to_seller']) ? true : false;

    ## text message - editable
    $text_message = 'KÃ­nh gá»­i %1$s,

Má»™t trong cÃ¡c phiÃªn Ä‘áº¥u do báº¡n khá»Ÿi táº¡o trÃª %2$s Ä‘Ã£ Ä‘Æ°á»£c Ä‘Äƒng láº¡i.

Äá»ƒ xem chi tiáº¿t phiÃªn Ä‘áº¥u giÃ¡ Ä‘Æ°á»£c Ä‘Äƒng láº¡i, vui lÃ²ng báº¥m vÃ o Ä‘Æ°á»ng dáº«n bÃªn dÆ°á»›i:

%3$s

TrÃ¢n trá»ng,
Ban quáº£n trá»‹ %2$s';

## html message - editable
    $html_message = 'KÃ­nh gá»­i %1$s, <br>
<br>
Má»™t trong cÃ¡c phiÃªn Ä‘áº¥u do báº¡n khá»Ÿi táº¡o trÃª %2$s Ä‘Ã£ Ä‘Æ°á»£c Ä‘Äƒng láº¡i. <br>
<br>
[ <a href="%3$s">Báº¥m vÃ o Ä‘Ã¢y</a> ] Ä‘á»ƒ xem chi tiáº¿t phiÃªn Ä‘áº¥u giÃ¡ Ä‘Æ°á»£c Ä‘Äƒng láº¡i. <br>
<br>
TrÃ¢n trá»ng, <br>
Ban quáº£n trá»‹ %2$s';


    $items_open_link = SITE_PATH . 'login.php?redirect=' . process_link('members_area', array('page' => 'selling', 'section' => 'open'), true);

    $text_message = sprintf($text_message, $row_details['name'], $setts['sitename'], $items_open_link);
    $html_message = sprintf($html_message, $row_details['name'], $setts['sitename'], $items_open_link);

    send_mail($row_details['email'], 'Äáº¥u giÃ¡ Ä‘Æ°á»£c Ä‘Äƒng láº¡i', $text_message, $setts['admin_email'], $html_message, null, $send);
  }
?>