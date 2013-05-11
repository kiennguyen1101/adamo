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
<script language="javascript">
  function enableBtn(theform) {
    if (theform.message.value != '')
      theform.add_message.disabled = false;
    else
      theform.add_message.disabled = true;
  }
</script>

<table width="100%" border="0" cellpadding="3" cellspacing="2" class="shared_table separate_line">
  <?php echo $members_area_header; ?>
<?php echo ($msg_changes_saved) ? $msg_changes_saved : '<br>'; ?>
  <tr>
    <td colspan="2"><b><?php echo $message_title; ?></b></td>
  </tr>
  <?php if (!empty($direct_payment_box)) { ?>
      <tr height="21">
        <td colspan="2" class="c4"><strong><?php echo MSG_DIRECT_PAYMENT; ?></strong></td>
      </tr>
      <tr>
        <td colspan="2" class="c5"><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr>
        <td colspan="2" class="border"><?php echo $direct_payment_box; ?></td>
      </tr>
    <?php } ?>
  <?php if (!empty($swap_description)) { ?>
      <tr height="21">
        <td colspan="2" class="c4"><strong><?php echo MSG_SWAP_DETAILS; ?></strong></td>
      </tr>
      <tr>
        <td colspan="2" class="c5"><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr>
        <td colspan="2" class="c1"><?php echo $swap_description; ?></td>
      </tr>
    <?php } ?>
  <?php echo $contact_details; ?>
  <?php echo $message_board_content; ?>

  <?php if ($admin_message) { ?>
      <tr class="c2">
        <td></td>
        <td class="contentfont"><a href="content_pages.php?page=contact_us&topic_id=<?php echo $topic_id; ?>"><?php echo MSG_RESPOND_BY_EMAIL; ?></a></td>
      </tr>   
    <?php }
    else if ($session->value('adminarea') != 'Active') {
      ?>
      <tr class="c4">
        <td colspan="2"><b><?php echo MSG_ADD_MESSAGE; ?></b></td>
      </tr>
      <form action="" method="post" name="message_board_form">
        <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
        <tr class="c2">
		<script language="javascript" type="text/javascript">
		function imposeMaxLength(Object, MaxLen)
		{
		  return (Object.value.length <= MaxLen);
		}
		</script> 
          <td colspan="2" class="no_border"><textarea id="message" style="width:950px;resize: none;" name="message" rows="5" onkeyup="enableBtn(message_board_form);" onkeypress="return imposeMaxLength(this, 500);"></textarea></td>
        </tr>
        <tr class="c1">
          <td colspan="2" align="center" class="no_border"><input type="submit" value="<?php echo MSG_ADD_MESSAGE; ?>" name="add_message" id="add_message" disabled></td>
        </tr>
      </form>
    <?php }
    else {
      ?>
      <tr>
        <td align="center" colspan="2"><?php echo MSG_MSGBOARD_LOGGED_AS_ADMIN; ?></td>
      </tr>
  <?php } ?>   
</table>

