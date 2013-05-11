<?php


  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>
<br>
<table width="100%" class="shared_table separate_line ">
  <tr>
    <td colspan="8" class="c3"><b><?php echo ($page == 'summary') ? MSG_UNREAD_MESSAGES : MSG_MM_RECEIVED_MESSAGES; ?></b> (<?php echo $nb_messages; ?> <?php echo MSG_MESSAGES; ?><?php echo ($nb_unread_messages && $page != 'summary') ? ' - ' . $nb_unread_messages . ' ' . MSG_UNREAD : ''; ?>)
    </td>
  </tr>
  <tr>
    <td class="membmenu" nowrap><?php echo MSG_FROM; ?> <?php echo $page_order_sender_username; ?></td>
    <td class="membmenu"><?php echo MSG_SUBJECT; ?></td>
    <td class="membmenu" align="center" nowrap><?php echo GMSG_DATE; ?> <?php echo $page_order_reg_date; ?></td>
    <td class="membmenu" align="center" nowrap><?php echo GMSG_OPTIONS; ?></td>
  </tr>
  <?php echo $received_messages_content; ?>
  <?php if ($nb_messages > 0) { ?>
      <tr>
        <td colspan="8" align="center" class="contentfont"><?php echo $pagination; ?></td>
      </tr>
    <?php } ?>
</table>

