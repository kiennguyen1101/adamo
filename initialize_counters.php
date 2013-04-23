<?php
#################################################################
## MyPHPAuction 2009															##
##-------------------------------------------------------------##
## Copyright ©2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

  include_once ('includes/global.php'); ## MyPHPAuction 2009# reset all counters
  $db->query("UPDATE " . DB_PREFIX . "categories SET items_counter=0, wanted_counter=0");

  $sql_select_auctions = $db->query("SELECT auction_id,category_id,addl_category_id FROM 
	" . DB_PREFIX . "auctions WHERE active=1 AND approved=1 AND closed=0 AND deleted=0 AND list_in!='store'");

  while ($item_details = $db->fetch_array($sql_select_auctions)) {
    auction_counter($item_details['category_id'], 'add', $item_details['auction_id']);
    auction_counter($item_details['addl_category_id'], 'add', $item_details['auction_id']);
  }

  $sql_select_wanted_ads = $db->query("SELECT category_id,addl_category_id FROM 
	" . DB_PREFIX . "wanted_ads WHERE active=1 AND closed=0 AND deleted=0");

  while ($item_details = mysql_fetch_array($sql_select_wanted_ads)) {
    wanted_counter($item_details['category_id'], 'add');
    wanted_counter($item_details['addl_category_id'], 'add');
  }

  echo "Operation Successful. Auctions and Wanted Ads Counters Refreshed.";
?>