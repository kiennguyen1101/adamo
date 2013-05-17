<?php
#################################################################
## MyPHPAuction v6.05															##
##-------------------------------------------------------------##
## Copyright ©2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?php echo $header_search_page;?>
<?php echo (!empty($no_results_message)) ? $no_results_message : '<br>';?>

<?php if (!empty($search_options_menu)) { ?>

<?php echo MSG_CHOOSE_SEARCH_METHOD;?> <?php echo $search_options_menu;?>
  
<?php } ?>



   
   
   
   <?php
	$post_url = ($option == 'store_search') ? 'stores.php' : 'auction_search.php';
	$post_url = ($option == 'category_search') ? 'categories.php' : $post_url;
	?>
	
   <form action="<?php echo $post_url;?>" method="POST" name="form_advanced_search">
      <input type="hidden" name="option" value="<?php echo $option;?>">
      <?php if ($option == 'auction_search') { ?>
     
         <?php echo MSG_SEARCH_AUCTION_ID;?>
         <input name="src_auction_id" type="text" id="src_auction_id" size="15" value="<?php echo $item_details['src_auction_id'];?>">
		<?php echo MSG_SEARCH_KEYWORDS;?>
         <input name="keywords_search" type="text" id="keywords_search" size="50" value="<?php echo $item_details['keywords_search'];?>">
      
        <input type="checkbox" name="search_description" value="1" <?php echo ($item_details['search_description'] == 1) ? 'checked' : '';?>>
        <?php echo MSG_SEARCH_DESCRIPTION;?>
     
         <?php echo MSG_SEARCH_KEYWORDS_EXPL;?>
    
		<?php if ($layout['enable_buyout'] && $setts['buyout_process'] == 1) { ?>
		<input type="checkbox" name="buyout_price" value="1" <?php echo ($item_details['buyout_price'] == 1) ? 'checked' : '';?>>
        <?php echo MSG_SEARCH_BUYOUT_ITEMS;?>
     
      <?php } ?>
     
         <input type="checkbox" name="reserve_price" value="1" <?php echo ($item_details['reserve_price'] == 1) ? 'checked' : '';?>>
        <?php echo MSG_SEARCH_RESERVE_PRICE_ITEMS;?>
      
         <input type="checkbox" name="quantity" value="1" <?php echo ($item_details['quantity'] == 1) ? 'checked' : '';?>>
         <?php echo MSG_SEARCH_QUANTITY_DUTCH;?>
     
      <?php if ($setts['enable_swaps']) { ?>
      <input type="checkbox" name="enable_swap" value="1" <?php echo ($item_details['enable_swap'] == 1) ? 'checked' : '';?>>
        <?php echo MSG_SEARCH_SWAP_ENABLED;?>
     
      <?php } ?>
      <?php if ($setts['enable_stores']) { ?>
     <?php echo MSG_LISTED_IN;?>
         <select name="list_in">
               <option value="auction" selected>
               <?php echo GMSG_SITE;?>
               </option>
               <option value="store" <?php echo ($item_details['list_in'] == 'store') ? 'selected' : '';?>>
               <?php echo GMSG_SHOP;?>
               </option>
               <option value="both" <?php echo ($item_details['list_in'] == 'both') ? 'selected' : '';?>>
               <?php echo GMSG_BOTH;?>
               </option>
            </select>
      <?php } ?>
     <?php echo MSG_VIEW_RESULTS;?>
        <select name="results_view">
               <option value="all" <?php echo ($item_details['results_view'] == 'all') ? 'selected' : '';?>>
               <?php echo GMSG_ALL;?>
               </option>
               <option value="open" selected>
               <?php echo GMSG_OPEN_AUCTIONS_ONLY;?>
               </option>
               <option value="closed" <?php echo ($item_details['results_view'] == 'closed') ? 'selected' : '';?>>
               <?php echo GMSG_CLOSED_AUCTIONS_ONLY;?>
               </option>
            </select>
       <?php echo MSG_ORDER_BY;?>
        <select name="ordering">
               <option value="end_time_asc" selected>
               <?php echo MSG_ITEMS_ENDING_FIRST;?>
               </option>
               <option value="end_time_desc" <?php echo ($item_details['ordering'] == 'end_time_desc') ? 'selected' : '';?>>
               <?php echo MSG_NEWEST_ITEMS_FIRST;?>
               </option>
               <option value="start_price_asc" <?php echo ($item_details['ordering'] == 'start_price_asc') ? 'selected' : '';?>>
               <?php echo MSG_LOWEST_PRICES_FIRST;?>
               </option>
            </select>
      <?php echo $custom_sections_table;?>
     <?php echo MSG_LOCATION;?>
      
        
       <?php echo MSG_COUNTRY;?> 
        <?php echo $country_dropdown;?>
    <?php echo MSG_ZIP_CODE;?> 
        <input type="text" name="zip_code" value="<?php echo $item_details['zip_code'];?>" size="25" />
    
      <?php } else if ($option == 'seller_search') { ?>
      <?php echo MSG_USERNAME;?>
       <input name="username" type="text" id="username" size="50" value="<?php echo $item_details['username'];?>">
      
     <?php echo MSG_VIEW_RESULTS;?>
         <select name="results_view">
               <option value="all" <?php echo ($item_details['results_view'] == 'all') ? 'selected' : '';?>>
               <?php echo GMSG_ALL;?>
               </option>
               <option value="open" selected>
               <?php echo GMSG_OPEN_AUCTIONS_ONLY;?>
               </option>
               <option value="closed" <?php echo ($item_details['results_view'] == 'closed') ? 'selected' : '';?>>
               <?php echo GMSG_CLOSED_AUCTIONS_ONLY;?>
               </option>
            </select>
        <?php echo MSG_ORDER_BY;?>
         <select name="ordering">
               <option value="end_time_asc" selected>
               <?php echo MSG_ITEMS_ENDING_FIRST;?>
               </option>
               <option value="end_time_desc" <?php echo ($item_details['ordering'] == 'end_time_desc') ? 'selected' : '';?>>
               <?php echo MSG_NEWEST_ITEMS_FIRST;?>
               </option>
               <option value="start_price_asc" <?php echo ($item_details['ordering'] == 'start_price_asc') ? 'selected' : '';?>>
               <?php echo MSG_LOWEST_PRICES_FIRST;?>
               </option>
            </select>
     
      <?php } else if ($option == 'buyer_search') { ?>
      <?php echo MSG_USERNAME;?>
         <input name="username" type="text" id="username" size="50" value="<?php echo $item_details['username'];?>">
     <?php echo MSG_VIEW_RESULTS;?>
        <select name="results_view">
               <option value="all" <?php echo ($item_details['results_view'] == 'all') ? 'selected' : '';?>>
               <?php echo GMSG_ALL;?>
               </option>
               <option value="open" selected>
               <?php echo GMSG_OPEN_AUCTIONS_ONLY;?>
               </option>
               <option value="closed" <?php echo ($item_details['results_view'] == 'closed') ? 'selected' : '';?>>
               <?php echo GMSG_CLOSED_AUCTIONS_ONLY;?>
               </option>
            </select>
     <?php echo MSG_ORDER_BY;?>
         <select name="ordering">
               <option value="end_time_asc" selected>
               <?php echo MSG_ITEMS_ENDING_FIRST;?>
               </option>
               <option value="end_time_desc" <?php echo ($item_details['ordering'] == 'end_time_desc') ? 'selected' : '';?>>
               <?php echo MSG_NEWEST_ITEMS_FIRST;?>
               </option>
               <option value="start_price_asc" <?php echo ($item_details['ordering'] == 'start_price_asc') ? 'selected' : '';?>>
               <?php echo MSG_LOWEST_PRICES_FIRST;?>
               </option>
            </select>
      <?php } else if ($option == 'store_search') { ?>
      <?php echo MSG_STORE_NAME;?>
         <input name="shop_name" type="text" id="shop_name" size="50" value="<?php echo $item_details['shop_name'];?>">
     
      <?php } else if ($option == 'category_search') { ?>
      <input type="hidden" name="advanced_search" value="<?php echo $advanced_search;?>" >
     
      <?php if ($advanced_search) { ?>
	   <ul>
	   <li>
			<?php if ($layout['enable_buyout'] && $setts['buyout_process'] == 1) { ?>
			<input type="checkbox" name="buyout_price" value="1" <?php echo ($item_details['buyout_price'] == 1) ? 'checked' : '';?>>
			<?php echo MSG_SEARCH_BUYOUT_ITEMS_ONLY;?>
			<?php } ?>
		</li>
		<li>
			<input type="checkbox" name="reserve_price" value="1" <?php echo ($item_details['reserve_price'] == 1) ? 'checked' : '';?>>
			 <?php echo MSG_SEARCH_RESERVE_PRICE_ITEMS_ONLY;?>
		</li>
		<li>
			 <input type="checkbox" name="photos_only" value="1" <?php echo ($item_details['photos_only'] == 1) ? 'checked' : '';?>>
			 <?php echo MSG_SEARCH_PHOTOS_ONLY;?>
		</li>
		<li>
			<input type="checkbox" name="quantity_standard" value="1" <?php echo ($item_details['quantity_standard'] == 1) ? 'checked' : '';?>>
			<?php echo MSG_SEARCH_QUANTITY_STANDARD_ONLY;?>
		</li>
		<li>
			 <input type="checkbox" name="quantity" value="1" <?php echo ($item_details['quantity'] == 1) ? 'checked' : '';?>>
			 <?php echo MSG_SEARCH_QUANTITY_DUTCH_ONLY;?>
		</li>
		<!--
		<li>
			<input type="checkbox" name="direct_payment_only" value="1" <?php echo ($item_details['direct_payment_only'] == 1) ? 'checked' : '';?>>
			<?php echo MSG_SEARCH_DIRECT_PM_ONLY;?>
		</li>
		<li>
			<input type="checkbox" name="regular_payment_only" value="1" <?php echo ($item_details['regular_payment_only'] == 1) ? 'checked' : '';?>>
			<?php echo MSG_SEARCH_REGULAR_PM_ONLY;?>
		</li>
		-->
		<li>
			<?php if ($setts['enable_swaps']) { ?>
			<input type="checkbox" name="enable_swap" value="1" <?php echo ($item_details['enable_swap'] == 1) ? 'checked' : '';?>>
			<?php echo MSG_SEARCH_SWAP_ENABLED;?>
			<?php } ?>
		</li>
		<li>
			<input type="submit" name="form_search_proceed" value="<?php echo GMSG_SEARCH;?>">
		</li>
		<ul>
      <?php } ?>
      <?php } ?>
  
   </form>