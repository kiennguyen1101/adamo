<?php


  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>
<?php echo $auction_print_header; ?>
<SCRIPT LANGUAGE="JavaScript"><!--
myPopup = '';

  function openPopup(url) {
    myPopup = window.open(url, 'popupWindow', 'width=640,height=150,status=yes');
    if (!myPopup.opener)
      myPopup.opener = self;
  }
//-->
</SCRIPT>
<SCRIPT LANGUAGE = "JavaScript">
  function converter_open(url) {
    output = window.open(url, "popDialog", "height=220,width=700,toolbar=no,resizable=yes,scrollbars=yes,left=10,top=10");
  }
</SCRIPT>
<?php if ($ad_display == 'live') { ?>

    <form name="hidden_form" action="auction_details.php" method="get" style="margin:0px;">
      <input type="hidden" name="option" />
      <input type="hidden" name="auction_id" />
      <input type="hidden" name="message_content" />
      <input type="hidden" name="question_id" />
    </form>
  <?php } ?>

<?php if ($print_button == 'show') { ?>


    <a href="#" onclick="javascript:window.print(this);"><?php echo GMSG_PRINT_THIS_PAGE; ?></a>

  <?php } ?>



<?php if ($ad_display == 'live') { ?>
                  <!--<img src="themes/<?php echo $setts['default_theme']; ?>/img/system/home.gif" align="absmiddle" border="0" hspace="5"> <a href="<?php echo process_link('index'); ?>">
    <?php echo MSG_BACK_TO_HP; ?>-->

  <?php } ?>


<p><?php echo $main_category_display; ?></P>



<div id="product_detail">  
  <!-- phan danh cho anh san pham ------------->
  <?php if (item::count_contents($item_details['ad_image'])) { ?>
      <div id="product_images">
        <div class="main_image">
          <img name="main_ad_image" src="<?php echo SITE_PATH; ?>thumbnail.php?pic=<?php echo $item_details['ad_image'][0]; ?>&w=500&sq=Y&b=Y" border="0" alt="<?php echo $item_details['name']; ?>">
        </div>
        <?php echo $ad_image_thumbnails; ?>
      </div>
    <?php } ?>

  <!-- phan danh cho thong tin san pham ------------->
  <div id="product_info">
    <div class="product_column">
      <!--print out name and id of product -->
      <div class="product_name_id">
        <h2><?php echo $item_details['name']; ?></h2>

        <div class="social">
          <span class='st_facebook_hcount' displayText=''></span>
          <span class='st_twitter_hcount' displayText=''></span>
          <span class='st_fblike_hcount' displayText=''></span>
          <a id="watch" href="<?php echo process_link('auction_details', array('auction_id' => $item_details['auction_id'], 'option' => 'item_watch')); ?>">
            <img style="width:60px;height:22px;"src="themes/<?php echo $setts['default_theme']; ?>/img/system/watchthis.png" align="absmiddle" border="0" hspace="5">	
          </a>
        </div>

      </div>
      <!--show buy out -->
      <div class="product_info_detail">
        <h3><?php echo MSG_AUCTION_ID; ?>: <b><?php echo $item_details['auction_id']; ?></b></h3> 
        <!-- show box bid if have aution -->
        <?php if ($item_can_bid['show_box']) { ?>

            <?php if ($item_can_bid['result']) { ?>

            <?php } ?>

          <?php } ?>
        <!-- show information-->
        <!-- show bid -->
        <?php if ($ad_display == 'live' && !$buyout_only) { ?>
            <p><?php echo MSG_CURRENT_BID; ?> :
              <?php echo $fees->display_amount($item_details['max_bid'], $item_details['currency']); ?></p>
          <?php } ?>
        <?php if (!$buyout_only) { ?>
            <!-- form aution bid-->
            <p><?php echo MSG_START_BID; ?> :
              <?php echo $fees->display_amount($item_details['start_price'], $item_details['currency']); ?></p>
            <?php if ($item_can_bid['result']) { ?>
              <form action="bid.php" method="post">
                <input type="hidden" name="auction_id" value="<?php echo $item_details['auction_id']; ?>">
                <input type="hidden" name="action" value="bid_confirm">
              <?php } ?>
              <?php if ($item_details['auction_type'] == 'dutch') { ?>
                <p><?php echo GMSG_QUANTITY; ?>
                  :
                  <input name="quantity" type="text" id="quantity" value="1" size="3"></p>

              <?php } ?>

              <?php if ($item_details['auction_type'] != 'dutch') { ?>

              <?php } ?>

              <input name="max_bid" type="text" id="max_bid" size="20" />
              <input name="form_place_bid" type="submit" id="form_place_bid" value="<?php echo MSG_PLACE_BID; ?>" <?php echo (!$item_can_bid['result'] || $blocked_user) ? 'disabled' : ''; ?>>

              <?php if ($item_can_bid['result']) { ?>
              </form>
              <!-- end form -->

            <?php } ?>




            <?php if ($your_bid > 0) { ?>
              <p><?php echo MSG_YOUR_BID; ?> :
                <?php echo $fees->display_amount($your_bid, $item_details['currency']); ?></p>
            <?php } ?>
          <?php } ?>
        <!----------------- end aution ------------------>

        <?php if ($ad_display == 'preview' && $item_details['is_reserve'] && !$buyout_only) { ?>
            <p><?php echo MSG_RES_PRICE; ?></p>

            <p><?php echo $fees->display_amount($item_details['reserve_price'], $item_details['currency']); ?></p>

          <?php } ?>
        <!------------ display quantity of product ---------------->
        <?php if ($item_details['quantity']) { ?>

            <p><?php echo GMSG_QUANTITY; ?> : <?php echo $item_details['quantity']; ?></p>

          <?php } ?>

        <?php if ($ad_display == 'live' && !$buyout_only) { ?>

            <p><a href="<?php echo process_link('bid_history', array('auction_id' => $item_details['auction_id'])); ?>"><?php echo MSG_NR_BIDS; ?></a> : <?php echo $item_details['nb_bids']; ?></p>

          <?php } ?>

        <!-------------- display location --------------->
        <p><?php echo MSG_LOCATION; ?> : <?php echo $auction_location; ?></p>

        <!------------------------- display time ------------------------------>			
        <?php if ($ad_display == 'live' && $item_details['start_time'] <= CURRENT_TIME) { // dont show if the auction is not started  ?>

            <p><?php echo MSG_TIME_LEFT; ?> : <span id="countdown1"><?php echo date("Y-m-d H:i:s", $item_details['end_time']) . " GMT-03:00"; ?></span></p>

          <?php } ?>           

        <?php if ($ad_display == 'live' || $item_details['end_time_type'] == 'custom') { ?>

            <p><?php echo GMSG_END_TIME; ?> : <?php echo show_date($item_details['end_time']); ?></p>

          <?php
          }
          else {
            ?>

            <p><?php echo GMSG_DURATION; ?><?php echo $item_details['duration'] . ' ' . GMSG_DAYS; ?></p>

          <?php } ?>

<?php if ($item_details['is_offer'] && $setts['makeoffer_process'] == 1) { ?>
            <!---------------- make offer ---------------------->
            <p><?php echo GMSG_MAKE_OFFER; ?></p>
            <?php
            if ($ad_display == 'preview' || $session->value('user_id') == $item_details['owner_id'] || $blocked_user) {
              echo '<img src="themes/' . $setts['default_theme'] . '/img/system/makeoffer25.gif" border="0">';
            }
            else {
              echo '<a href="make_offer.php?auction_id=' . $item_details['auction_id'] . '"><img src="themes/' . $setts['default_theme'] . '/img/system/makeoffer25.gif" border="0"></a>';
            }
            ?>

    <?php if ($ad_display != 'live' || $setts['makeoffer_private']) { ?>
              <p><?php echo MSG_OFFER_RANGE; ?>: <?php echo $item->offer_range($item_details); ?></p>

            <?php } ?>
  <?php } ?>
        <!----------------- end make offer -------------------->

<?php if ($ad_display == 'live' && $item_details['reserve_price'] > 0) { ?>

            <p><?php echo ($item_details['reserve_price'] > $item_details['max_bid']) ? '<span class="redfont">' . MSG_RESERVE_NOT_MET . '</span>' : '<span class="greenfont">' . MSG_RESERVE_MET . '</span>'; ?></p>

          <?php } ?>
        <?php if ($item_details['enable_swap'] && !$item_details['closed']) { ?>
            <p><?php echo MSG_SWAP_OFFERS_ACCEPTED; ?><?php echo ($ad_display == 'live' && !$blocked_user) ? $swap_offer_link : ''; ?></p>
          <?php } ?>

<?php if ($ad_display == 'live' && !empty($winners_content)) { ?>

            <p> <?php echo MSG_WINNER_S; ?><?php echo $winners_content; ?></p>

          <?php } ?>
<?php if ($item_details['apply_tax']) { ?>
            <p><?php echo $auction_tax['display']; ?></p>

            <?php if ($auction_tax['display_buyer']) { ?>
              <p><?php echo $auction_tax['display_buyer']; ?></p>
            <?php } ?>
  <?php } ?>
        <p><?php echo $winners_message_board; ?></P>
        <div class="product_buy_now">
          <?php if ($show_buyout) { ?>
              <?php
              echo '<h2>' . $fees->display_amount($item_details['buyout_price'], $item_details['currency']) . '</h2>' .
              '';
              if ($ad_display == 'preview' || $session->value('user_id') == $item_details['owner_id'] || $blocked_user) {
                echo '<img src="themes/' . $setts['default_theme'] . '/img/system/buyitnow25.png" border="0">';
              }
              else {
                echo '<a href="buy_out.php?auction_id=' . $item_details['auction_id'] . '"><img src="themes/' . $setts['default_theme'] . '/img/system/buyitnow25.png" border="0"></a>';
              }
              ?>
  <?php } ?>
        </div>
      </div> 
      <!-- phan danh cho seller ------------->
      <div id="seller_info">

        <h2><?php echo $user_details['username']; ?></h2>

        <p>Ðánh giá : <?php echo user_pics($user_details['user_id']); ?></p>

<?php if ($ad_display == 'live') { ?>

            <a href="<?php echo process_link('other_items', array('owner_id' => $item_details['owner_id'])); ?>">
    <?php echo MSG_OTHER_ITEMS_FROM_SELLER; ?>
            </a>

    <?php if ($user_details['shop_active']) { ?>

              <a id="shop_active" href="<?php echo process_link('shop', array('user_id' => $item_details['owner_id'])); ?>">
      <?php echo MSG_VIEW_STORE; ?>

              </a>

            <?php } ?>
  <?php } ?>

      </div>
    </div>
  </div>


  <?php echo $auction_friend_form; ?>
  <?php echo $msg_changes_saved; ?>
<?php echo $block_reason_msg; ?>

</div>
<!-- phan danh cho show orther items ------------->
<?php if ($setts['enable_other_items_adp'] && $item->count_contents($other_items)) { ?>
    <h2 id="orther_items_mes"><?php echo MSG_OTHER_ITEMS_FROM_SELLER; ?><h2>

        <ul class="bxslider">
          <?php for ($counter = 0; $counter < $layout['hpfeat_nb']; $counter++) { ?>

            <?php
            if (!empty($other_items[$counter]['name'])) {
              $main_image = $db->get_sql_field("SELECT media_url FROM " . DB_PREFIX . "auction_media WHERE
      			auction_id='" . $other_items[$counter]['auction_id'] . "' AND media_type=1 AND upload_in_progress=0 ORDER BY media_id ASC LIMIT 0,1", 'media_url');

              $auction_link = process_link('auction_details', array('name' => $other_items[$counter]['name'], 'auction_id' => $other_items[$counter]['auction_id']));
              ?>
              <li>
                <div class="other_product_image">
                  <a href="<?php echo $auction_link; ?>"><img src="<?php echo ((!empty($main_image)) ? 'thumbnail.php?pic=' . $main_image . '&w=' . $layout['hpfeat_width'] . '&sq=Y' : 'themes/' . $setts['default_theme'] . '/img/system/noimg.gif'); ?>" border="0" alt="<?php echo $other_items[$counter]['name']; ?>"></a>
                </div>
                <div class="other_product_info">
                  <h2><a href="<?php echo $auction_link; ?>"><?php echo title_resize($other_items[$counter]['name']); ?></a></h2>  

                  <h3><?php echo $fees->display_amount($other_items[$counter]['buyout_price'], $other_items[$counter]['currency']); ?></h3>
                  <?php
                  if ($setts['enable_shipping_costs']) {
                    if ($fees->display_amount($item_details['postage_amount']) > 0) {
                      echo '<em>V?n chuy?n : ' . $fees->display_amount($item_details['postage_amount'], $item_details['currency']) . '</em>';
                    }
                    else {
                      echo '<em>V?n chuy?n : Mi?n phí</em>';
                    }
                  }
                  ?>
                </div>
              </li>

            <?php } ?>

    <?php } ?>
        </ul>





      <?php } ?>
    <!-- description tab ----->
    <?php
      if ($item_details['listing_template_id'] > 0) {
        include ("themedesigner/template-" . $item_details['listing_template_id'] . ".php");
        ?>

      <?php
      }
      else {
        ?>
        <div id="tab_product">
          <div id="tabContaier">
            <ul>
              <li><a class="active" href="#tab1"><?php echo GMSG_DESCRIPTION; ?></a></li>
              <li><a href="#tab2"><?php echo MSG_SHIPPING; ?></a></li>
              <li><a href="#tab3"><?php echo MSG_ASK_SELLER_QUESTION; ?></a></li>
            </ul>
          </div>
          <div class="tabDetails">
            <div id="tab1" class="tabContents">
    <?php echo database::add_special_chars($item_details['description']); ?>
            </div>
            <div id="tab2" class="tabContents">
              <p><?php echo MSG_SHIPPING_CONDITIONS; ?> :
              <?php echo ($item_details['shipping_method'] == 1) ? MSG_BUYER_PAYS_SHIPPING : MSG_SELLER_PAYS_SHIPPING; ?></p>

              <?php if ($item_details['shipping_int'] == 1) { ?>

                <?php echo MSG_SELLER_SHIPS_INT; ?>

                <?php } ?>
                <?php if ($setts['enable_shipping_costs']) { ?>
                <p><?php echo MSG_POSTAGE; ?> :
                  <?php echo $fees->display_amount($item_details['postage_amount'], $item_details['currency']); ?></p>

                <p><?php echo MSG_SHIP_METHOD; ?> :
                <?php echo $item_details['type_service']; ?></p>

                  <?php if ($item_details['shipping_details']) { ?>
                  <p><?php echo MSG_SHIPPING_DETAILS; ?> :
                  <?php echo $item_details['shipping_details']; ?></p>

      <?php } ?>
              <?php } ?>
            </div>
            <div id="tab3" class="tabContents">
              <?php if ($ad_display == 'live') { ?>

                <?php if ($setts['enable_asq']) { ?>

                  <?php echo $public_questions_content; ?>
                  <?php if ($session->value('adminarea') == 'Active') { ?>
                    <?php echo MSG_QUESTIONS_LOGGED_AS_ADMIN; ?>
                  <?php
                  }
                  else if (!$session->value('user_id')) {
                    ?>
                    <?php echo MSG_LOGIN_TO_ASK_QUESTIONS; ?>
                  <?php
                  }
                  else if ($session->value('user_id') == $item_details['owner_id']) {
                    ?>
          <?php echo MSG_CANT_POST_QUESTION_OWNER; ?>
        <?php
        }
        else {
          ?>

                    <form action="auction_details.php" method="POST">
                      <input type="hidden" name="auction_id" value="<?php echo $item_details['auction_id']; ?>">
                      <input type="hidden" name="option" value="post_question">
                      <img src="themes/<?php echo $setts['default_theme']; ?>/img/system/i_faq.gif" align="absmiddle"/>
                      <strong>
                          <?php echo MSG_POST_QUESTION; ?>
                      </strong>
                      <textarea name="message_content" cols="40" rows="3" class="contentfont"></textarea>
                      <div style="padding: 2px;">
                        <select name="message_handle">
                            <?php if ($user_details['default_public_questions']) { ?>
                            <option value="1" selected>
            <?php echo MSG_POST_QUESTION_PUBLICLY; ?>
                            </option>
          <?php } ?>
                          <option value="2">
          <?php echo MSG_POST_QUESTION_PRIVATELY; ?>
                          </option>
                        </select>
                      </div>
                      <div style="padding: 2px;">
                        <input name="form_post_question" type="submit" id="form_post_question" value="<?php echo GMSG_SUBMIT; ?>" />
                      </div>

                    </form>
        <?php } ?>
          <?php } ?>
        <?php } ?>
            </div>
          </div>
        </div>

      <?php } ?>



    <?php if ($ad_display == 'live') { ?>

        <?php if ($session->value('user_id')) { ?>
          <img src="themes/<?php echo $setts['default_theme']; ?>/img/system/status1.gif" vspace="5" align="absmiddle">
            <?php echo MSG_WELCOME; ?>
          ,
          <?php echo $session->value('username'); ?>

          <?php if ($item_details['owner_id'] == $session->value('user_id')) { ?>
            [ <a href="<?php echo process_link('sell_item', array('option' => 'sell_similar', 'auction_id' => $item_details['auction_id'])); ?>">
              <?php echo MSG_SELL_SIMILAR; ?>
            </a> ]
              <?php if (!$item->under_time($item_details)) { ?>
                <?php if ($item_details['nb_bids'] == 0 && $item_details['active'] == 1) { ?>
                [ <a href="edit_item.php?auction_id=<?php echo $item_details['auction_id']; ?>&edit_option=new">
                <?php echo MSG_EDIT_AUCTION; ?>
                </a> ]
                [ <a href="members_area.php?do=delete_auction&auction_id=<?php echo $item_details['auction_id']; ?>&page=selling&section=open" onclick="return confirm('<?php echo MSG_DELETE_CONFIRM; ?>');">
                  <?php echo MSG_DELETE; ?>
                </a> ]
              <?php
              }
              else if ($item_details['nb_bids'] > 0 && $item_details['active'] == 1) {
                ?>
                [ <a href="edit_description.php?auction_id=<?php echo $item_details['auction_id']; ?>">
                <?php echo MSG_EDIT_DESCRIPTION; ?>
                </a> ]
              <?php } ?>
            <?php } ?>
          <?php } ?>

          <?php
          }
          else {
            ?>
          <img src="themes/<?php echo $setts['default_theme']; ?>/img/system/status.gif" vspace="5" align="absmiddle">
            <?php echo MSG_STATUS_BIDDER_SELLER_A; ?>

          <a href="<?php echo process_link('login'); ?>">
          <?php echo MSG_STATUS_BIDDER_SELLER_B; ?>
          </a>
      <?php echo MSG_STATUS_BIDDER_SELLER_C; ?>
          <?php } ?>
        <a href="javascript:popUp('<?php echo process_link('auction_print', array('auction_id' => $item_details['auction_id'])); ?>');"><img src="themes/<?php echo $setts['default_theme']; ?>/img/system/print.gif" align="absmiddle" border="0" hspace="5">
    <?php echo MSG_PRINT_VIEW; ?>
        </a>

        <?php if (!empty($direct_payment_box)) { ?>

          <strong>
          <?php echo MSG_DIRECT_PAYMENT; ?>
          </strong>

          <?php foreach ($direct_payment_box as $dp_box) { ?>
            <img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1">
        <?php echo $dp_box; ?>

      <?php } ?>
        <?php } ?>


        <?php } ?>



    <br/>
    <?php if ($ad_display == 'live') { ?>
        <b><?php echo MSG_THE_POSTER; ?>
        <?php echo $user_details['username']; ?>

    <?php echo MSG_ASSUMES_RESP_EXPL; ?></b>


  <?php } ?>
<?php echo $auction_print_footer; ?>
