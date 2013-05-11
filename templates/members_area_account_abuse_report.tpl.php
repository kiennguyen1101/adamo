<?php
#################################################################
## MyPHPAuction v6.05															##
##-------------------------------------------------------------##
## Copyright ©2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>

<table width="100%" border="0" cellpadding="3" cellspacing="2" class="shared_table shared_table2">
  <tr>
    <td class="c3" colspan="2"><b>
        <?php echo MSG_REPORT_ABUSE_TO_ADMIN; ?>
      </b></td>
  </tr>
  <tr class="c5">
    <td><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="150" height="1"></td>
    <td width="100%"><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
  </tr>
  <?php echo $display_formcheck_errors; ?>
  <form action="members_area.php?page=account&section=abuse_report" method="post">
   	<input type="hidden" name="auction_id" value="<?php echo $auction_id; ?>">
    <?php if ($auction_id) { ?>
        <tr class="c1">
          <td nowrap="nowrap" align="right"><?php echo MSG_AUCTION_ID; ?> / <?php echo MSG_ITEM_TITLE; ?></td>
          <td width="100%">#<?php echo $auction_id; ?> - <?php echo $item_details['name']; ?></td>
        </tr>
      <?php } ?>   	
    <tr class="c1">
      <td nowrap="nowrap" align="right"><?php echo MSG_USERNAME; ?></td>
      <td width="100%">
        <?php if ($auction_id) { ?>
            <?php echo $item_details['username']; ?>
            <input type="hidden" name="abuser_username" value="<?php echo $item_details['username']; ?>" />         	
            <?php
          }
          else {
            ?>
            <input type="text" name="abuser_username" value="<?php echo $post_details['abuser_username']; ?>" />
          <?php } ?>
      </td>
    </tr>
    <tr class="c1">
      <td nowrap="nowrap" align="right"><?php echo MSG_COMMENTS; ?></td>
    <script language="javascript" type="text/javascript">
      function imposeMaxLength(Object, MaxLen)
      {
        return (Object.value.length <= MaxLen);
      }
    </script> 
    <td ><textarea  style="resize:none;width:98%" rows="5" onkeypress="return imposeMaxLength(this, 500)" name="comment" style="width: 100%; height: 100" id="block_reason"><?php echo $post_details['comment']; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="2" class="c4"></td>
    </tr>
    <tr>
      <td colspan="2" class="contentfont" align="center"><input class="buttons" type="submit" value="<?php echo GMSG_PROCEED; ?>" name="form_add_abuse_report"></td>
    </tr>
  </form>
</table>