<?php


  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>

<div class="mainhead"><img src="images/fees.gif" align="absmiddle">
  <?php echo $header_section; ?>
</div>
<?php echo $msg_changes_saved; ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="4"><img src="images/c1.gif" width="4" height="4"></td>
    <td width="100%" class="ftop"><img src="images/pixel.gif" width="1" height="1"></td>
    <td width="4"><img src="images/c2.gif" width="4" height="4"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="3" cellpadding="3" class="fside">
  <form name="form" action="fees_payment_gateways.php" method="post">
    <tr>
      <td class="c3"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
          <?php echo $subpage_title; ?>
        </b></td>
    </tr>
    <tr class="c4">
      <td><b><?php echo AMSG_ACTIVE; ?>: <?php echo $active_pg_message; ?></b></td>
    </tr>
    <?php echo $pg_box_table_rows; ?>
    <tr>
      <td align="center"><input type="submit" name="form_save_settings" value="<?php echo AMSG_SAVE_CHANGES; ?>"></td>
    </tr>
  </form>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
    <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
    <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
  </tr>
</table>
