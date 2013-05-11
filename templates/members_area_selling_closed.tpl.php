<?php


  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>
<script language="Javascript">
<!--
  function checkAll(field, array_len, check) {
    if (array_len == 1) {
      field.checked = check;
    } else {
      for (i = 0; i < array_len; i++)
        field[i].checked = check;
    }
  }
  -- ></script>
<?php echo (!empty($msg_auction_relist)) ? $msg_auction_relist : '<br>'; ?>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="shared_table separate_line">
  <form action="" method="post" name="closed_auctions">
    <input type="hidden" name="do" value="closed_proceed">
    <tr>
      <td colspan="8" class="c3"><b><?php echo MSG_MM_CLOSED_AUCTIONS; ?></b> (<?php echo $nb_items; ?> <?php echo MSG_ITEMS; ?>)
      </td>
    </tr>
    <tr class="membmenu">
      <td><?php echo MSG_AUCTION_ID; ?><br><?php echo $page_order_auction_id; ?></td>
      <td><?php echo MSG_ITEM_TITLE; ?><br><?php echo $page_order_itemname; ?></td>
      <td align="center"><?php echo GMSG_START_TIME; ?><br><?php echo $page_order_start_time; ?></td>
      <td align="center"><?php echo GMSG_END_TIME; ?><br><?php echo $page_order_end_time; ?></td>
      <td align="center"><?php echo MSG_NR_BIDS; ?><br><?php echo $page_order_nb_bids; ?></td>
      <td align="center"><?php echo MSG_MAX_BID; ?><br><?php echo $page_order_max_bid; ?></td>
      <td align="center" class="contentfont"><?php echo MSG_RELIST; ?></td>
      <td align="center" class="contentfont"><?php echo GMSG_DELETE; ?></td>
    </tr>

    <?php echo $closed_auctions_content; ?>
    <?php if ($nb_items > 0) { ?>
        <tr class="membmenu">
          <td colspan="8" align="center" class="contentfont"><input type="submit" class="buttons" name="form_closed_proceed" value="<?php echo GMSG_PROCEED; ?>" <?php echo $disabled_button; ?> /></td>
        </tr>

        <tr>
          <td colspan="8" align="center" class="contentfont"><?php echo $pagination; ?></td>
        </tr>
      <?php } ?>
  </form>
</table>

