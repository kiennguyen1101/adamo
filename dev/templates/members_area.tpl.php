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

<SCRIPT LANGUAGE="JavaScript"><!--
myPopup = '';

  function openPopup(url) {
    myPopup = window.open(url, 'popupWindow', 'width=350,height=250,status=yes');
    if (!myPopup.opener)
      myPopup.opener = self;
  }
//-->
</SCRIPT>
<?php echo $members_area_header; ?>
<?php echo $members_area_header_menu; ?>

<?php echo $msg_store_cats_modified; ?>
<?php echo $msg_pending_gc_transactions; ?>
<?php echo $msg_unpaid_endauction_fees; ?>
<?php echo $msg_changes_saved; ?>
<?php echo $msg_seller_error; ?>
<?php echo $members_area_page_content; ?>
