<?php
#################################################################
## myphpauction															##
##-------------------------------------------------------------##
## Copyright ©2008 myphpauction SoftwareLTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>
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

<form name="hidden_form" action="wanted_details.php" method="get">
  <input type="hidden" name="option" />
  <input type="hidden" name="wanted_ad_id" />
  <input type="hidden" name="message_content" />
  <input type="hidden" name="question_id" />
</form>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="contentfont" nowrap style="padding-right: 10px;"><img src="themes/<?php echo $setts['default_theme']; ?>/images/system/home.gif" align="absmiddle" border="0" hspace="5">
      <a href="<?php echo process_link('index'); ?>"><?php echo MSG_BACK_TO_HP; ?></a></td>
    <td width="100%">
      <table width="100%" border="0" cellpadding="3" cellspacing="3" class="errormessage">
        <tr>
          <td width="150" align="right"><b><?php echo MSG_MAIN_CATEGORY; ?>:</b></td>
          <td class="contentfont"><?php echo $main_category_display; ?></td>
        </tr>
        <?php if ($item_details['addl_category_id']) { ?>
            <tr>
              <td width="150" align="right"><b><?php echo MSG_ADDL_CATEGORY; ?>:</b></td>
              <td class="contentfont"><?php echo $addl_category_display; ?></td>
            </tr>
          <?php } ?>
      </table>
    </td>
  </tr>
</table>


<table width='100%' border='0' cellspacing='0' cellpadding='0' height='21' style='border-bottom: 2px solid #a6a6a6;'>
  <tr>
    <td width='30'><img src='themes/<?php echo $setts['default_theme']; ?>/images/det_start.gif' width='35' height='30' align='absmiddle'></td>
    <td width='100%' background='themes/<?php echo $setts['default_theme']; ?>/images/det_bg.gif' valign='bottom' class='cathead' style='padding-left: 5px; padding-bottom: 3px;'>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="itemid">&nbsp;&nbsp;<?php echo $item_details['name']; ?></td>
          <td align="right" class="itemidend"><?php echo MSG_WANTED_AD_ID; ?>: <b><?php echo $item_details['wanted_ad_id']; ?></b>&nbsp;&nbsp;</td>
        </tr>
      </table>
    </td>
    <td width='5'><img src='themes/<?php echo $setts['default_theme']; ?>/images/det_end.gif' width='5' height='30' align='absmiddle'></td>
  </tr>
</table>
<br>
<?php echo $msg_changes_saved; ?>
<?php echo $block_reason_msg; ?>
<table width="100%" border="0" cellpadding="0" cellspacing="3">
  <tr valign="top">
    <td width="20%" align="center" class="border">
      <?php if (!empty($item_details['ad_image'][0])) { ?>
          <table width="100%" border="0" cellspacing="3" cellpadding="3">
            <tr>
              <td align="center"><img src="<?php echo SITE_PATH; ?>thumbnail.php?pic=<?php echo $item_details['ad_image'][0]; ?>&w=150&sq=Y&b=Y" border="0" alt="<?php echo $item_details['name']; ?>"></td>
            </tr>
          </table>
        <?php } ?>
    </td>
    <td width="50%" class="border"><!-- Start Table for item details -->
      <table width="100%" border="0" cellspacing="3" cellpadding="3">
        <tr class="c5">
          <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="120" height="1"></td>
          <td width="100%"><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="1" height="1"></td>
        </tr>
        <tr class="c1">
          <td><b><?php echo MSG_OFFERS; ?></b></td>
          <td class="contentfont"><?php echo $item_details['nb_bids']; ?></td>
        </tr>
        <tr class="c1">
          <td><b><?php echo MSG_LOCATION; ?></b></td>
          <td><?php echo $auction_location; ?></td>
        </tr>
        <tr class="c1">
          <td><b><?php echo MSG_COUNTRY; ?></b></td>
          <td><?php echo $auction_country; ?></td>
        </tr>
        <tr class="c1">
          <td><b><?php echo MSG_TIME_LEFT; ?></b></td>
          <td><?php echo time_left($item_details['end_time']); ?></td>
        </tr>
        <tr class="c1">
          <td><b><?php echo GMSG_START_TIME; ?></b></td>
          <td><?php echo show_date($item_details['start_time']); ?></td>
        </tr>
        <tr class="c1">
          <td><b><?php echo GMSG_END_TIME; ?></b></td>
          <td><?php echo show_date($item_details['end_time']); ?></td>
        </tr>
        <tr class="c1">
          <td><b><?php echo MSG_STATUS; ?></b></td>
          <td><?php echo item::item_status($item_details['closed']); ?></td>
        </tr>
        <tr class="c5">
          <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="1" height="1"></td>
          <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="1" height="1"></td>
        </tr>
      </table>
    </td>
    <td width="30%" class="border"><table width="100%" border="0" cellspacing="3" cellpadding="3">
        <tr>
          <td class="c3"><?php echo MSG_POSTER_INFORMATION; ?> </td>
        </tr>
        <tr class="c5">
          <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="1" height="1"></td>
        </tr>
        <tr>
          <td><b><?php echo $user_details['username']; ?></b> <?php echo user_pics($user_details['user_id']); ?></td>
        </tr>
        <tr class="c1">
          <td><?php echo MSG_REGISTERED_SINCE; ?> <b><?php echo show_date($user_details['reg_date'], false); ?></b><br>
            <?php echo GMSG_IN . ' <b>' . $seller_country . '</b>'; ?></td>
        </tr>
        <tr class="c5">
          <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="1" height="1"></td>
        </tr>
      </table>
      <?php echo $reputation_table_small; ?>
    </td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="3" cellpadding="3" class="border">
  <tr>
    <td class="c3" colspan="2"><strong><?php echo GMSG_DESCRIPTION; ?></strong></td>
  </tr>
  <tr class="c5">
    <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="150" height="1"></td>
    <td width="100%"><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td colspan="2"><?php echo database::add_special_chars($item_details['description']); ?></td>
  </tr>
  <?php echo $custom_sections_table; ?>
  <?php if (item::count_contents($item_details['ad_image'])) { ?>
      <tr>
        <td class="c3" colspan="2"><strong><?php echo MSG_WANTED_AD_IMAGES; ?></strong> </td>
      </tr>
      <tr class="c5">
        <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="1" height="1"></td>
        <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr>
        <td class="border" colspan="2"><table width="100%" cellpadding="3" cellspacing="0" border="0">
            <tr align="center">
              <td valign="top" class="picselect"><table cellpadding="3" cellspacing="1" border="0">
                  <tr align="center">
                    <td><b> <?php echo MSG_SELECT_PICTURE; ?> </b></td>
                  </tr>
                  <tr align="center">
                    <td><?php echo $ad_image_thumbnails; ?></td>
                  </tr>
                </table></td>
              <td width="100%" class="picselectmain" align="center"><img name="main_ad_image" src="<?php echo SITE_PATH; ?>thumbnail.php?pic=<?php echo $item_details['ad_image'][0]; ?>&w=500&sq=Y&b=Y" border="0" alt="<?php echo $item_details['name']; ?>"></td>
            </tr>
          </table></td>
      </tr>
    <?php } ?>
  <?php if (item::count_contents($item_details['ad_video'])) { ?>
      <tr>
        <td class="c3" colspan="2"><strong><?php echo MSG_WANTED_AD_MEDIA; ?></strong> </td>
      </tr>
      <tr class="c5">
        <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="1" height="1"></td>
        <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="1" height="1"></td>
      </tr>
      <tr>
        <td class="border" colspan="2"><table width="100%" cellpadding="3" cellspacing="0" border="0">
            <tr align="center">
              <td valign="top" class="picselect"><table cellpadding="3" cellspacing="1" border="0">
                  <tr align="center">
                    <td><b> <?php echo MSG_SELECT_VIDEO; ?> </b></td>
                  </tr>
                  <tr align="center">
                    <td><?php echo $ad_video_thumbnails; ?></td>
                  </tr>
                </table></td>
              <td width="100%" class="picselectmain"align="center"><?php echo $ad_video_main_box; ?></td>
            </tr>
          </table></td>
      </tr>
    <?php } ?>
  <tr>
    <td align="center" colspan="2"><table cellpadding="3" cellspacing="1" border="0" class="counter">
        <tr>
          <td nowrap><?php echo MSG_ITEM_VIEWED; ?> <?php echo ($item_details['nb_clicks'] + 1); ?> <?php echo GMSG_TIMES; ?></td>
        </tr>
      </table></td>
  </tr>
  <?php if ($setts['enable_asq']) { ?>
      <tr>
        <td class="c4" colspan="2"><b><?php echo MSG_ASK_SELLER_QUESTION; ?></b> </td>
      </tr>
      <tr class="c5">
        <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="1" height="1"></td>
        <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="1" height="1"></td>
      </tr>
      <?php echo $public_questions_content; ?>
      <?php if ($session->value('adminarea') == 'Active') { ?>
        <tr>
          <td align="center" colspan="2"><?php echo MSG_QUESTIONS_LOGGED_AS_ADMIN; ?></td>
        </tr>
        <?php
      }
      else if (!$session->value('user_id')) {
        ?>
        <tr>
          <td align="center" colspan="2"><?php echo MSG_LOGIN_TO_ASK_QUESTIONS; ?></td>
        </tr>
        <?php
      }
      else if ($session->value('user_id') == $item_details['owner_id']) {
        ?>
        <tr>
          <td align="center" colspan="2"><?php echo MSG_CANT_POST_QUESTION_OWNER; ?></td>
        </tr>
        <?php
      }
      else {
        ?>
        <tr>
          <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="1" height="1"></td>
          <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="1" height="1"></td>
        </tr>
        <form action="wanted_details.php" method="POST">
          <input type="hidden" name="wanted_ad_id" value="<?php echo $item_details['wanted_ad_id']; ?>">
          <input type="hidden" name="option" value="post_question">
          <tr class="c1">
            <td><table width="100%">
                <tr>
                  <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/system/i_faq.gif" align="absmiddle"/></td>
                  <td width="100%" align="right"><strong><?php echo MSG_POST_QUESTION; ?></strong></td>
                </tr>
              </table></td>
            <td><table>
                <tr>
                  <td><textarea name="message_content" cols="40" rows="3" class="contentfont"></textarea></td>
                  <td><div style="padding: 2px;">
                      <select name="message_handle">
                        <?php if ($user_details['default_public_questions']) { ?>
                          <option value="4" selected><?php echo MSG_POST_QUESTION_PUBLICLY; ?></option>
                        <?php } ?>
                        <option value="5"><?php echo MSG_POST_QUESTION_PRIVATELY; ?></option>
                      </select>
                    </div>
                    <div style="padding: 2px;">
                      <input name="form_post_question" type="submit" id="form_post_question" value="<?php echo GMSG_SUBMIT; ?>" />
                    </div></td>
                </tr>
              </table></td>
          </tr>
        </form>
      <?php } ?>
    <?php } ?>
</table>
<br>
<?php if ($is_wanted_offers) { ?>
    <table width="100%" border="0" cellpadding="3" cellspacing="3" class="border">
      <tr>
        <td class="c3" colspan="6"><?php echo MSG_ACTIVE_OFFERS; ?></td>
      </tr>
      <tr class="membmenu" valign="top">
        <td align="center"><?php echo MSG_PICTURE; ?></td>
        <td><?php echo MSG_ITEM_TITLE; ?></td>
        <td align="center"><?php echo MSG_START_BID; ?></td>
        <td align="center"><?php echo MSG_MAX_BID; ?></td>
        <td align="center"><?php echo MSG_NR_BIDS; ?></td>
        <td align="center"><?php echo MSG_ENDS; ?></td>
      </tr>
      <tr class="c5">
        <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="60" height="1"></td>
        <td width="100%"><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="100%" height="1"></td>
        <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="80" height="1"></td>
        <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="80" height="1"></td>
        <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="50" height="1"></td>
        <td><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="100" height="1"></td>
      </tr>
      <?php echo $active_offers_content; ?>
    </table>
    <br>
  <?php } ?>
<table width=100% border=0 cellspacing=0 cellpadding=0>
  <tr>
    <td align='center' class='topitempage alertfont'><?php echo MSG_THE_POSTER; ?>, <b><?php echo $user_details['username']; ?></b>, <?php echo MSG_ASSUMES_RESP_EXPL; ?> </td>
  </tr>
</table>
<?php if ($item_details['owner_id'] != $session->value('user_id') && !$blocked_user) { ?>
    <br />
    <table width="100%" border="0" cellpadding="3" cellspacing="3" class="border">
      <tr>
        <td class="c3" colspan="2"><?php echo MSG_ENTER_AN_OFFER; ?></td>
      </tr>
      <?php if ($session->value('user_id')) { ?>
        <form action="wanted_details.php" method="get">
          <input type="hidden" name="wanted_ad_id" value="<?php echo $item_details['wanted_ad_id']; ?>">
          <input type="hidden" name="action" value="submit_offer">
          <tr>
            <td class="c2" colspan="2"><b><?php echo $item_details['name']; ?></b></td>
          </tr>
          <tr class="c5">
            <td width="150"><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="150" height="1"></td>
            <td width="100%"><img src="themes/<?php echo $setts['default_theme']; ?>/images/pixel.gif" width="100%" height="1"></td>
          </tr>
          <tr class="c1">
            <td align="right"><?php echo MSG_CHOOSE_AN_ITEM; ?></td>
            <td><?php echo $offer_drop_down; ?></td>
          </tr>
        </form>
        <?php
      }
      else if ($item_details['closed']) {
        ?>
        <tr class="c1">
          <td align="center" class="contentfont"><?php echo MSG_CANTOFFER_CLOSED; ?></td>
        </tr>	
        <?php
      }
      else {
        ?>
        <tr class="c1">
          <td align="center" class="contentfont" style="color: red; font-weight: bold;"><?php echo MSG_CANTOFFER_LOGIN; ?>
            <div align="center" class="contentfont"><a href="login.php?redirect=wanted_details.php?wanted_ad_id=<?php echo $item_details['wanted_ad_id']; ?>"><?php echo MSG_LOGIN_TO_MEMBERS_AREA; ?></a></div>
          </td>
        </tr>
      <?php } ?>
    </table>
  <?php } ?>
