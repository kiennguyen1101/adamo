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
<?php echo $category_logo; ?>
<div id="advantage_search">
	<?php echo headercat($categories_header_menu); ?>
	<?php echo $categories_search_box; ?>
	<div id="sub-category-products">
	<?php if ($is_subcategories || $is_shop_stores) { ?>
        <!-- add stores as well -->
        <?php if ($is_shop_stores) { ?>
            
            <h2><?php echo MSG_SHOP_IN_STORES; ?></h2>
             
            <?php echo $shop_stores_content; ?>
           
			<?php } ?>
			<?php if ($is_subcategories) { ?>
           
            <h2><?php echo MSG_SUBCATEGORIES; ?></h2>
              
            <?php echo $subcategories_content; ?>
            
        <?php } ?>
       
  <?php } ?>
  </div>
</div>


<?php if ($layout['catfeat_nb']) { ?>
    <div id="feature-products"> 
      <?php
      $counter = 0;
      for ($i = 0; $i < $featured_columns; $i++) {
        ?>
        
          <?php
          for ($j = 0; $j < $layout['catfeat_nb']; $j++) {
            $width = 100 / $layout['catfeat_nb'] . '%';
            ?>
            <?php
              if (!empty($item_details[$counter]['name'])) {
                $main_image = $db->get_sql_field("SELECT media_url FROM " . DB_PREFIX . "auction_media WHERE
      			auction_id='" . $item_details[$counter]['auction_id'] . "' AND media_type=1 AND upload_in_progress=0 ORDER BY media_id ASC LIMIT 0,1", 'media_url');

                $auction_link = process_link('auction_details', array('name' => $item_details[$counter]['name'], 'auction_id' => $item_details[$counter]['auction_id']));
                ?>
                <div class="item-feature-product">
					<div class="feature-product-image">
						<a href="<?php echo $auction_link; ?>"><img src="<?php echo ((!empty($main_image)) ? 'thumbnail.php?pic=' . $main_image . '&w=233px&sq=Y' : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif'); ?>" border="0" alt="<?php echo $item_details[$counter]['name']; ?>"></a>
					</div>
					<div class="feature-product-info">
						
						<h2><a href="<?php echo $auction_link; ?>"><?php echo $item_details[$counter]['name']; ?></a></h2>
						<ul>
							<li><?php echo MSG_START_BID; ?>: <?php echo $fees->display_amount($item_details[$counter]['start_price'], $item_details[$counter]['currency']); ?> </li>
						 
							<li><?php echo MSG_CURRENT_BID; ?>: <?php echo $fees->display_amount($item_details[$counter]['max_bid'], $item_details[$counter]['currency']); ?> </li>
						  
							<li><?php echo MSG_ENDS; ?>: <?php echo show_date($item_details[$counter]['end_time']); ?> </li>
						</ul>
					</div>
                </div>
                <?php
                $counter++;
              }
              ?></td>
        <?php } ?>
        </tr>
    <?php } ?>
    </div>
  <?php } ?>


