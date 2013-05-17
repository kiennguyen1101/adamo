<?php
#################################################################
## MyPHPAuction v6.04															##
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
    <td colspan="8" class="c3"><?php echo ($page == 'summary') ? '<b>' . MSG_LAST_FIVE_BIDS . '</b>' : '<b>' . MSG_MM_CURRENT_BIDS . '</b> (' . $nb_bids . ' ' . MSG_BIDS . ')'; ?></td>
  </tr>
  <tr>
    <td class="membmenu" align="center"><?php echo MSG_PICTURE; ?></td>
    <td class="membmenu"><?php echo MSG_AUCTION_ID; ?>
      <br>
      <?php echo $page_order_auction_id; ?></td>
    <td class="membmenu"><?php echo MSG_ITEM_TITLE; ?>
      <br>
      <?php echo $page_order_itemname; ?></td>
    <td class="membmenu" align="center"><?php echo MSG_BID_AMOUNT; ?>
      <br>
      <?php echo $page_order_bid_amount; ?></td>
    <td class="membmenu" align="center"><?php echo MSG_PROXY_BID; ?>
      <br>
      <?php echo $page_order_bid_proxy; ?></td>
    <td class="membmenu" align="center"><?php echo GMSG_DATE; ?>
      <br>
      <?php echo $page_order_bid_date; ?></td>
    <td class="membmenu" align="center"><?php echo GMSG_STATUS; ?></td>
    <td class="membmenu" align="center"><?php echo GMSG_OPTIONS; ?></td>
  </tr>

  <?php echo $current_bids_content; ?>
  <?php if ($nb_bids > 5) { ?>
      <tr>
        <td colspan="8" align="center" class="contentfont"><?php echo $pagination; ?></td>
      </tr>
    <?php } ?>
</table>
