<?php


  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>

<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="shared_table shared_table2">
  <tr>
    <td colspan="6" class="c3"><b>
        <?php echo MSG_MM_WON_ITEMS; ?>
      </b> (
      <?php echo $nb_items; ?>
      <?php echo MSG_ITEMS; ?>
      ) </td>
  </tr>
  <tr valign="top">
    <td class="membmenu"><table border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
          <td><?php echo MSG_AUCTION_ID; ?>
            <br>
            <?php echo $page_order_auction_id; ?></td>
          <td>&nbsp;&nbsp;-&nbsp;&nbsp;</td>
          <td><?php echo MSG_ITEM_TITLE; ?>
            <br>
            <?php echo $page_order_itemname; ?></td>
        </tr>
      </table></td>
    <td class="membmenu" align="center"><?php echo MSG_WINNING_BID; ?>
      <br>
      <?php echo $page_order_bid_amount; ?></td>
    <td class="membmenu" align="center"><?php echo GMSG_QUANTITY; ?>
      <br>
      <?php echo $page_order_quantity; ?></td>
    <td class="membmenu" align="center"><?php echo MSG_CONTACT_INFO; ?></td>
    <td class="membmenu" align="center"><table border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
          <td><?php echo MSG_PURCHASE_DATE; ?>
            <br>
            <?php echo $page_order_purchase_date; ?></td>
          <td> / </td>
          <td><?php echo MSG_STATUS; ?></td>
        </tr>
      </table></td>
    <td class="membmenu" align="center"><?php echo GMSG_OPTIONS; ?></td>
  </tr>

  <?php echo $won_auctions_content; ?>
  <tr class="c5">
    <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
    <td width="10%"><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
    <td width="17%"><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
    <td width="17%"><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
    <td width="17%"><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
    <td width="15%"><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
  </tr>
  <?php if ($nb_items > 0) { ?>
      <tr>
        <td colspan="6" align="center" class="contentfont"><?php echo $pagination; ?></td>
      </tr>
    <?php } ?>
</table>
