﻿<?php
#################################################################
## MyPHPAuction v6.05															##
##-------------------------------------------------------------##
## Copyright ©2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="shared_table separate_line">
  <tr>
    <td colspan="10" class="c3"><?php echo ($page == 'summary') ? '<b>' . MSG_LAST_FIVE_LISTED_ITEMS . '</b>' : '<b>' . MSG_MM_OPEN_AUCTIONS . '</b> (' . $nb_items . ' ' . MSG_ITEMS . ')'; ?></td>
  </tr>
  <tr>
    <td class="membmenu" align="center" valign="top"><?php echo MSG_PICTURE; ?></td>
    <td class="membmenu" align="center" valign="top"><?php echo MSG_AUCTION_ID; ?><br><?php echo $page_order_auction_id; ?></td>
    <td class="membmenu" align="center" valign="top"><?php echo MSG_ITEM_TITLE; ?><br><?php echo $page_order_itemname; ?></td>
    <td class="membmenu" align="center" valign="top"><?php echo GMSG_START_TIME; ?><br><?php echo $page_order_start_time; ?></td>
    <td class="membmenu" align="center" valign="top"><?php echo GMSG_END_TIME; ?><br><?php echo $page_order_end_time; ?></td>
    <td class="membmenu" align="center" valign="top"><?php echo MSG_NR_BIDS; ?><br><?php echo $page_order_nb_bids; ?></td>
    <td class="membmenu" align="center" valign="top"><?php echo MSG_AUTO_RELIST; ?></td>
    <td class="membmenu" align="center" valign="top"><?php echo MSG_START_BID; ?><br><?php echo $page_order_start_bid; ?></td>
    <td class="membmenu" align="center" valign="top"><?php echo MSG_MAX_BID; ?><br><?php echo $page_order_max_bid; ?></td>
    <td class="membmenu" align="center" valign="top"><?php echo GMSG_OPTIONS; ?></td>
  </tr>

  <?php echo $open_auctions_content; ?>
  <?php if ($nb_items > 5) { ?>
      <tr class="no_border">
        <td colspan="10" align="center" class="contentfont"><?php echo $pagination; ?></td>
      </tr>
    <?php } ?>
</table>

