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
<div class= "site_fees_box">
  <?php echo $site_fees_header_message; ?>



  <form action="site_fees.php" method="post" class="fees_form">
    <?php echo MSG_CHOOSE_CATEGORY; ?> : <?php echo $fees_categories_box; ?>
    <input type="submit" name="form_choose_category" value="<?php echo GMSG_SELECT; ?>">
  </form>
  <div class="fee_content">
    <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border fees_table">
      <tr>
        <td class="c3 fees_header" colspan="2">
          <strong>Phụ phí người bán trả</strong> 
        </td>
      </tr>
      <?php if ($is_setup_fee) { ?>
          <tr>
            <td colspan="2" class="c3 fees_header"><strong>
                <?php echo MSG_LISTING_FEES; ?>
              </strong></td>
          </tr>
          <tr class="c5">
            <td colspan="2"><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
          </tr>
          <tr>
            <td colspan="2"><table width="100%"  border="0" cellspacing="2" cellpadding="2" class="border">
                <?php echo $listing_fees_table; ?>
              </table></td>
          </tr>
          <tr class="c5">
            <td colspan="2"><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
          </tr>
        <?php } ?>
      <tr class="c2">
        <td align="center" class="fees_column" width="50%"><strong>
            Loại phí
          </strong></td>
        <td align="center" class="fees_column">Phí</td>
      </tr>
      <?php if ($fee_row['second_cat_fee'] > 0) { ?>
          <tr class="c2">
            <td align="left" class="fees_column" width="50%"><strong>
                <?php echo GMSG_ADDLCAT_FEE; ?>
              </strong></td>
            <td align="center" class="fees_column"><?php echo $fees->display_amount($fee_row['second_cat_fee']); ?>/sản phẩm</td>
          </tr>
        <?php } ?>
      <?php if ($fee_row['picture_fee'] > 0) { ?>
          <tr class="c2">
            <td align="left" class="fees_column" width="50%"><strong>
                <?php echo GMSG_IMG_UPL_FEE; ?>
              </strong></td>
            <td align="center" class="fees_column"><?php echo $fees->display_amount($fee_row['picture_fee']); ?>/sản phẩm</td>
          </tr>
        <?php } ?>
      <?php if ($fee_row['hlitem_fee'] > 0) { ?>
          <tr class="c2">
            <td align="left" class="fees_column" width="50%"><strong>
                <?php echo GMSG_HL_FEE; ?>
              </strong></td>
            <td align="center" class="fees_column"><?php echo $fees->display_amount($fee_row['hlitem_fee']); ?>/sản phẩm</td>
          </tr>
        <?php } ?>
      <?php if ($fee_row['bolditem_fee'] > 0) { ?>
          <tr class="c2">
            <td align="left" class="fees_column" width="50%"><strong>
                <?php echo GMSG_BOLD_FEE; ?>
              </strong></td>
            <td align="center" class="fees_column"><?php echo $fees->display_amount($fee_row['bolditem_fee']); ?>/sản phẩm</td>
          </tr>
        <?php } ?>
      <?php if ($fee_row['catfeat_fee'] > 0) { ?>
          <tr class="c2">
            <td align="left" class="fees_column" width="50%"><strong>
                <?php echo GMSG_CATFEAT_FEE; ?>
              </strong></td>
            <td align="center" class="fees_column"><?php echo $fees->display_amount($fee_row['catfeat_fee']); ?>/sản phẩm</td>
          </tr>
        <?php } ?>
      <?php if ($fee_row['hpfeat_fee'] > 0) { ?>
          <tr class="c2">
            <td align="left" class="fees_column" width="50%"><strong>
                <?php echo GMSG_HPFEAT_FEE; ?>
              </strong></td>
            <td align="center" class="fees_column"><?php echo $fees->display_amount($fee_row['hpfeat_fee']); ?>/sản phẩm</td>
          </tr>
        <?php } ?>
      <?php if ($fee_row['rp_fee'] > 0) { ?>
          <tr class="c2">
            <td align="left" class="fees_column" width="50%"><strong>
                <?php echo GMSG_RP_FEE; ?>
              </strong></td>
            <td align="center" class="fees_column"><?php echo $fees->display_amount($fee_row['rp_fee']); ?>/sản phẩm</td>
          </tr>
        <?php } ?>
      <?php if ($fee_row['swap_fee'] > 0) { ?>
          <tr class="c2">
            <td align="left" class="fees_column" width="50%"><strong>
                <?php echo GMSG_SWAP_FEE; ?>
              </strong></td>
            <td align="center" class="fees_column"><?php echo $fees->display_amount($fee_row['swap_fee']); ?>/sản phẩm</td>
          </tr>
        <?php } ?>
      <?php if ($fee_row['buyout_fee'] > 0) { ?>
          <tr class="c2">
            <td align="left" class="fees_column" width="50%"><strong>
                <?php echo GMSG_BUYOUT_FEE; ?>
              </strong></td>
            <td align="center" class="fees_column"><?php echo $fees->display_amount($fee_row['buyout_fee']); ?>/sản phẩm</td>
          </tr>
        <?php } ?>
      <?php if ($fee_row['makeoffer_fee'] > 0) { ?>
          <tr class="c2">
            <td align="left" class="fees_column" width="50%"><strong>
                <?php echo GMSG_MAKEOFFER_FEE; ?>
              </strong></td>
            <td align="center" class="fees_column"><?php echo $fees->display_amount($fee_row['makeoffer_fee']); ?>/sản phẩm</td>
          </tr>
        <?php } ?>
      <?php if ($fee_row['custom_start_fee'] > 0) { ?>
          <tr class="c2">
            <td align="left" class="fees_column" width="50%"><strong>
                <?php echo GMSG_CUSTOM_START_FEE; ?>
              </strong></td>
            <td align="center" class="fees_column"><?php echo $fees->display_amount($fee_row['custom_start_fee']); ?>/sản phẩm</td>
          </tr>
        <?php } ?>
      <?php if ($fee_row['video_fee'] > 0) { ?>
          <tr class="c2">
            <td align="left" class="fees_column" width="50%"><strong>
                <?php echo GMSG_MEDIA_UPL_FEE; ?>
              </strong></td>
            <td align="center" class="fees_column"><?php echo $fees->display_amount($fee_row['video_fee']); ?>/sản phẩm</td>
          </tr>
        <?php } ?>
      <?php if ($fee_row['wanted_ad_fee'] > 0) { ?>
          <tr class="c2">
            <td align="left" class="fees_column" width="50%"><strong>
                <?php echo GMSG_WA_SETUP_FEE; ?>
              </strong></td>
            <td align="center" class="fees_column"><?php echo $fees->display_amount($fee_row['wanted_ad_fee']); ?>/sản phẩm</td>
          </tr>
        <?php } ?>
    </table>
  </div>
  <?php if ($is_stores) { ?>
      <strong>
        <?php echo MSG_STORE_ACCOUNT_TYPES; ?>
      </strong>

      <?php echo $store_subscriptions_table; ?>

    <?php } ?>
  <div class="fee_content">
    <table width="100%" border="0" cellpadding="3" cellspacing="2" class="border fees_table">
      <?php if ($is_sale_fee) { ?>
          <tr>
            <td class="c3 fees_header" colspan="2" ><strong>
                <?php echo GMSG_ENDAUCTION_FEE; ?>
                - <?php echo (eregi('s', $fee_row['endauction_fee_applies'])) ? MSG_PAID_BY_SELLER : MSG_PAID_BY_BUYER; ?></strong> </td>
          </tr>

          <tr class="c5">
            <td colspan="2"><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="1"></td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <table width="100%" border="1px" cellspacing="2" cellpadding="2" class="border">
                <?php echo $sale_fees_table; ?>
              </table>
            </td>
          </tr>
        <?php } ?>
  </div>
  <?php if ($setts['enable_tax']) { ?>

      <?php echo $tax_message; ?>

    <?php } ?>
</table>
</div>
