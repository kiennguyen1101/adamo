<?php


  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="shared_table">
  <tr>
    <td colspan="5" class="c3"><b><?php echo MSG_MM_LEAVE_COMMENTS; ?></b> (<?php echo $nb_items; ?> <?php echo MSG_ITEMS; ?>)
    </td>
  </tr>
  <tr>
    <td class="membmenu" align="center"><?php echo MSG_USERNAME; ?></td>
    <td class="membmenu" align="center"><?php echo MSG_AUCTION_ID; ?></td>
    <td class="membmenu"><?php echo MSG_ITEM_TITLE; ?></td>
    <td class="membmenu" align="center" class="contentfont"><?php echo MSG_TYPE; ?></td>
    <td class="membmenu" align="center"><?php echo GMSG_OPTIONS; ?></td>
  </tr>
  <?php echo $reputation_sent_content; ?>
  <?php if ($nb_items > 0) { ?>
      <tr>
        <td colspan="5" align="center" class="contentfont"><?php echo $pagination; ?></td>
      </tr>
    <?php } ?>
  <tr class="c5 no_border">
    <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="130" height="1"></td>
    <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="80" height="1"></td>
    <td width="100%"><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="100%" height="1"></td>
    <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="80" height="1"></td>
    <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="100" height="1"></td>
  </tr>
</table>

