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
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="shared_table separate_line">
  <tr>
    <td colspan="5" class="c3"><b><?php echo MSG_MM_OPEN_WANTED_ADS; ?></b> (<?php echo $nb_items; ?> <?php echo MSG_ITEMS; ?>)
    </td>
  </tr>
  <tr valign="top">
    <td class="membmenu"><?php echo MSG_WANTED_AD_ID; ?><br><?php echo $page_order_wanted_ad_id; ?></td>
    <td class="membmenu"><?php echo MSG_ITEM_TITLE; ?><br><?php echo $page_order_itemname; ?></td>
    <td class="membmenu" align="center"><?php echo GMSG_START_TIME; ?><br><?php echo $page_order_start_time; ?></td>
    <td class="membmenu" align="center"><?php echo GMSG_END_TIME; ?><br><?php echo $page_order_end_time; ?></td>
    <td class="membmenu" align="center"><?php echo GMSG_OPTIONS; ?></td>
  </tr>

  <?php echo $open_wanted_ads_content; ?>
  <tr class="c5 no_border">
    <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="80" height="1"></td>
    <td width="100%"><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
    <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="140" height="1"></td>
    <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="140" height="1"></td>
    <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="100" height="1"></td>
  </tr>
  <?php if ($nb_items > 0) { ?>
      <tr>
        <td colspan="5" align="center" class="contentfont"><?php echo $pagination; ?></td>
      </tr>
    <?php } ?>
</table>

