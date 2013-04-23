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
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
  <form action="custom_fields.php" method="post">
    <input type="hidden" name="page" value="<?php echo $page_handle; ?>" />
    <input type="hidden" name="do" value="<?php echo $do; ?>"  />
    <input type="hidden" name="field_id" value="<?php echo $field_details['field_id']; ?>"  />
    <input type="hidden" name="operation" value="submit" />
    <tr>
      <td colspan="2" class="c4"><b><?php echo $manage_field_title; ?></b></td>
    </tr>
    <tr class="c2">
      <td nowrap><?php echo AMSG_FIELD_NAME; ?></td>
      <td width="100%"><input type="text" name="field_name" value="<?php echo $field_details['field_name']; ?>" size="50" /></td>
    </tr>
    <tr class="c2">
      <td nowrap><?php echo AMSG_FIELD_DESC; ?></td>
      <td width="100%"><input type="text" name="field_description" value="<?php echo $field_details['field_description']; ?>" size="75" /></td>
    </tr>
    <?php if ($page_handle == 'auction') { ?>
        <tr class="c2">
          <td nowrap><?php echo AMSG_CATEGORY; ?></td>
          <td width="100%"><input type="hidden" name="category_id" value="0" /><?php echo categories_list($field_details['category_id'], 0, false); ?></td>
        </tr>
      <?php } ?>
    <tr class="c2">
      <td nowrap><?php echo AMSG_SECTION; ?></td>
      <td width="100%"><?php echo $sections_list_menu; ?></td>
    </tr>
    <tr class="c2">
      <td nowrap colspan="2" class="c3"><img src="admin/images/pixel.gif" width="1" height="1"></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="form_save_settings" value="<?php echo AMSG_SAVE_CHANGES; ?>">
      </td>
    </tr>
  </form>
</table>