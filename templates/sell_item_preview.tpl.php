<?php
#################################################################
## MyPHPAuction 2009															##
##-------------------------------------------------------------##
## Copyright ©2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>

<table width="100%" border="0" cellpadding="3" cellspacing="2">
  <tr class="c4">
    <td colspan="3">Auction Preview</td>
  </tr>
  <tr>
    <td colspan="3"><?php echo $auction_details_page; ?></td>
  </tr>
  <?php echo $auction_fees_box; ?>
  <?php echo $auction_terms_box; ?>

  <tr>
    <td></td>
    <td colspan="2"><?php echo nav_btns_position(true, true); ?></td>
  </tr>
</table>
<br>
