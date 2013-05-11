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

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <form action="bid.php" method="post">
    <input type="hidden" name="action" value="<?php echo $action; ?>">
    <input type="hidden" name="auction_id" value="<?php echo $item_details['auction_id']; ?>">
    <tr>
      <td class="contentfont">

        <div id="bid_confirm"><!-------------- bid info ----------->

          <table width="100%" border="0" cellpadding="3" cellspacing="2">
            <tr>
              <td class="c3 fees_header" colspan="2">
                <strong>Thông tin xác nhận sản phẩm</strong> 
              </td>
            </tr>
            <tr>
              <td align="center" class="bid_confirm_column"><strong>
                  <?php echo MSG_ITEM_TITLE; ?>
                </strong></td>
              <td class="bid_confirm_column"><strong>
                  <?php echo $item_details['name']; ?>
                </strong></td>
            </tr>

            <tr >
              <td width="150" align="center" class="bid_confirm_column"><strong>
                  <?php echo MSG_YOUR_BID; ?></strong></td>
              <td class="bid_confirm_column"><?php echo $item_details['currency']; ?>
                <input name="max_bid" type="text" id="max_bid" value="<?php echo $max_bid; ?>" size="15" onkeypress="return noenter()"></td>
            </tr>
            <?php if ($item_details['auction_type'] == 'dutch') { ?>
                <tr >
                  <td align="center" class="bid_confirm_column"><strong>
                      <?php echo GMSG_QUANTITY; ?>
                    </strong></td>
                  <td class="bid_confirm_column"><input name="quantity" type="text" id="quantity" value="<?php echo $quantity; ?>" size="8"></td>
                </tr>
              <?php } ?>
            <tr>
              <td align="center" class="bid_confirm_column"><strong>
                  <?php echo MSG_MINIMUM_BID; ?>
                </strong></td>
              <td class="bid_confirm_column"><?php echo $fees->display_amount($minimum_bid, $item_details['currency']); ?></td>
            </tr>

            <tr >
              <td width="150" align="center" class="bid_confirm_column"><strong><?php echo MSG_SHIPPING_CONDITIONS; ?></strong></td>
              <td class="bid_confirm_column"><?php echo ($item_details['shipping_method'] == 1) ? MSG_BUYER_PAYS_SHIPPING : MSG_SELLER_PAYS_SHIPPING; ?></td>
            </tr>
            <?php if ($item_details['shipping_int'] == 1) { ?>
                <tr>
                  <td class="bid_confirm_column">&nbsp;</td>
                  <td class="bid_confirm_column"><?php echo MSG_SELLER_SHIPS_INT; ?></td>
                </tr>
              <?php } ?>
            <?php if ($setts['enable_shipping_costs']) { ?>
                <tr>
                  <td width="150" align="center" class="bid_confirm_column"><strong><?php echo MSG_POSTAGE; ?></strong></td>
                  <td class="bid_confirm_column"><?php echo $fees->display_amount($item_details['postage_amount'], $item_details['currency']); ?></td>
                </tr>
                <tr >
                  <td width="150" align="center" class="bid_confirm_column"><strong><?php echo MSG_INSURANCE; ?></strong></td>
                  <td class="bid_confirm_column"><?php echo $fees->display_amount($item_details['insurance_amount'], $item_details['currency']); ?></td>
                </tr>
                <tr >
                  <td width="150" align="center" class="bid_confirm_column"><strong><?php echo MSG_SHIP_METHOD; ?></strong></td>
                  <td class="bid_confirm_column"><?php echo $item_details['type_service']; ?></td>
                </tr>
              <?php } ?>

            <?php if ($item_details['direct_payment']) { ?>
                <tr >
                  <td width="150" align="center" class="bid_confirm_column"><strong><?php echo MSG_DIRECT_PAYMENT; ?></strong></td>
                  <td class="bid_confirm_column"><?php echo $direct_payment_methods_display; ?></td>
                </tr>

              <?php } ?>
            <?php if ($item_details['payment_methods']) { ?>
                <tr >
                  <td width="150" align="center" class="bid_confirm_column"><strong><?php echo MSG_OFFLINE_PAYMENT; ?></strong></td>
                  <td class="bid_confirm_column"><?php echo $offline_payment_methods_display; ?></td>
                </tr>

              <?php } ?>
            <?php if ($auction_tax['apply']) { ?>
                <tr >
                  <td align="center" class="bid_confirm_column"><b>
                      <?php echo $auction_tax['tax_name'] ?></b></td>
                  <td class="bid_confirm_column"><?php echo $auction_tax['display_buyer_purchase']; ?></td>
                </tr>

              <?php } ?>
            <?php if ($item_details['hidden_bidding']) { ?>
                <tr>
                  <td colspan="2" class="redfont" class="bid_confirm_column"><?php echo MSG_HIDDEN_BIDDING_WARNING; ?></td>
                </tr>

              <?php } ?>

          </table>
        </div>
        <div id="confirm_bid_place">
          <table width="100%" border="0" cellpadding="4" cellspacing="2" class="errormessage">
            <tr>
              <td width="150" align="center"><input name="form_place_bid" type="submit" id="bid_confirm_button" value="<?php echo MSG_PLACE_BID; ?>">
              </td>
              <td class="bid_confirm_warning"><?php echo MSG_CONFIRM_BID_TERMS; ?></td>
            </tr>
          </table>
        </div>
        <div><b><?php echo MSG_CONFIRM_BID_AGREEMENT; ?></b></div>
      </td>
   	</tr>
  </form>
</table>
