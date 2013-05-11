﻿<?php
#################################################################
## MyPHPAuction 2009															##
##-------------------------------------------------------------##
## Copyright ©2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

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
    <input type="hidden" name="do" value="closed_wa_proceed">
    <tr>
      <td colspan="8" class="c3"><b><?php echo MSG_MM_CLOSED_WANTED_ADS; ?></b> (<?php echo $nb_items; ?> <?php echo MSG_ITEMS; ?>)
      </td>
    </tr>
    <tr valign="top">
      <td class="membmenu"><?php echo MSG_WANTED_AD_ID; ?><br><?php echo $page_order_wanted_ad_id; ?></td>
      <td class="membmenu"><?php echo MSG_ITEM_TITLE; ?><br><?php echo $page_order_itemname; ?></td>
      <td class="membmenu" align="center"><?php echo GMSG_START_TIME; ?><br><?php echo $page_order_start_time; ?></td>
      <td class="membmenu" align="center"><?php echo GMSG_END_TIME; ?><br><?php echo $page_order_end_time; ?></td>
      <td class="membmenu" align="center"><?php echo GMSG_OFFERS; ?><br><?php echo $page_order_nb_bids; ?></td>
      <td class="membmenu" align="center" class="contentfont"><?php echo MSG_RELIST; ?></td>
      <td class="membmenu" align="center" class="contentfont"><?php echo GMSG_DELETE; ?></td>
    </tr>

    <?php echo $closed_wanted_ads_content; ?>
    <tr class="c5 no_border">
      <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="80" height="1"></td>
      <td width="100%"><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
      <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="80" height="1"></td>
      <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="80" height="1"></td>
      <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="80" height="1"></td>
      <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="120" height="1"></td>
      <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="100" height="1"></td>
    </tr>
    <?php if ($nb_items > 0) { ?>
        <tr class="membmenu">
          <td colspan="8" align="center"><input type="submit" class="buttons" name="form_closed_proceed" value="<?php echo GMSG_PROCEED; ?>" <?php echo $disabled_button; ?> /></td>
        </tr>
        <tr>
          <td colspan="8" align="center" class="contentfont"><?php echo $pagination; ?></td>
        </tr>
      <?php } ?>
  </form>
</table>

