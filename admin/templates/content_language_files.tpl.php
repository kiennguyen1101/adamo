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

<div class="mainhead"><img src="images/content.gif" align="absmiddle">
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
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
  <tr class="c3">
    <td colspan="2"><img src="images/subt.gif" align="absmiddle" hspace="4" vspace="2"> <b>
        <?php echo strtoupper($subpage_title); ?>
      </b></td>
  </tr>
</table>
<?php echo $msg_changes_saved; ?>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
  <form action="content_language_files.php" method="post" name="form_content_pages">
    <tr class="c3">
      <td align="right" width="100%"><?php echo $languages_dropdown; ?></td>
      <td><input name="form_choose_lang" type="submit" id="form_choose_lang" value="<?php echo GMSG_PROCEED; ?>"></td>
    </tr>
  </form>
</table>
<?php if ($selected_lang) { ?>
    <table width="100%" border="0" cellpadding="3" cellspacing="3" class="fside">
      <form action="content_language_files.php" method="post" name="form_edit_lang">
        <input type="hidden" name="language" value="<?php echo $selected_lang; ?>">
        <tr>
          <td class="c1"><textarea name="file_content" style="width: 100%; height: 250px;"><?php echo $file_content; ?></textarea>
          </td>
        </tr>
        <tr>
          <td><?php echo AMSG_LANGUAGE_FILES_EDIT_NOTE; ?></td>
        </tr>
        <tr>
          <td class="c4"></td>
        </tr>
        <tr>
          <td align="center"><input name="form_save_settings" type="submit" id="form_save_settings" value="<?php echo AMSG_SAVE_CHANGES; ?>"></td>
        </tr>
      </form>
    </table>
  <?php } ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="4"><img src="images/c3.gif" width="4" height="4"></td>
    <td width="100%" class="fbottom"><img src="images/pixel.gif" width="1" height="1"></td>
    <td width="4"><img src="images/c4.gif" width="4" height="4"></td>
  </tr>
</table>
