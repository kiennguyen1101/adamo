<?php


  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="shared_table">
  <tr>
    <td colspan="5" class="c3"><b><?php echo MSG_MM_INVOICES_RECEIVED; ?></b> (<?php echo $nb_items; ?> <?php echo MSG_INVOICES; ?>)</td>
  </tr>
  <?php echo $invoices_received_content; ?>
  <?php if ($nb_items > 0) { ?>
      <tr>
        <td colspan="5" align="center" class="contentfont"><?php echo $pagination; ?></td>
      </tr>
    <?php } ?>
</table>

