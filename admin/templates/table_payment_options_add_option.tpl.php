<?php


  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>
<SCRIPT LANGUAGE="JavaScript">
  function submit_form(form_name, file_type) {
    form_name.box_submit.value = "1";
    form_name.file_upload_type.value = file_type;
    form_name.submit();
  }

  function delete_media(form_name, file_type, file_id) {
    form_name.box_submit.value = "1";
    form_name.file_upload_type.value = file_type;
    form_name.file_upload_id.value = file_id;
    form_name.submit();
  }
</SCRIPT>

<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
  <form action="table_payment_options.php" method="post" name="form_payment_option" enctype="multipart/form-data">
    <input type="hidden" name="do" value="<?php echo $do; ?>" />
    <input type="hidden" name="option_id" value="<?php echo $pm_details['id']; ?>" />
    <input type="hidden" name="operation" value="submit" />
    <!-- media upload related fields -->
    <input type="hidden" name="box_submit" value="0" >
    <input type="hidden" name="file_upload_type" value="" >
    <input type="hidden" name="file_upload_id" value="" >
    <?php echo $media_upload_fields; ?>
    <tr class="c3">
      <td colspan="3"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
          <?php echo strtoupper($manage_box_title); ?>
        </b></td>
    </tr>
    <tr class="c1">
      <td nowrap align="right"><b>
          <?php echo AMSG_NAME; ?>
        </b></td>
      <td colspan="2" width="100%"><input type="text" name="name" value="<?php echo $pm_details['name']; ?>" size="50" /></td>
    </tr>
    <?php echo $image_upload_manager; ?>
    <tr>
      <td colspan="3" align="center"><input type="submit" name="form_payment_option_save" value="<?php echo AMSG_SAVE_CHANGES; ?>">
      </td>
    </tr>
  </form>
</table>
