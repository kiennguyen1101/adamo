<?php
#################################################################
## MyPHPAuction v6.05															##
##-------------------------------------------------------------##
## Copyright ©2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>
<?php echo $display_formcheck_errors;?>
<SCRIPT LANGUAGE="JavaScript">
function submit_form(form_name) {
	form_name.submit();
}
</script>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="shared_table">
  <tr>
    <td colspan="8" class="c3"><b><?php echo MSG_ACCOUNT_DETAILS;?></b></td>
  </tr>
   <tr class="c5">
      <td width="20%"><img src="themes/<?php echo $setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="30%"><img src="themes/<?php echo $setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="20%"><img src="themes/<?php echo $setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
      <td width="30%"><img src="themes/<?php echo $setts['default_theme'];?>/img/pixel.gif" width="1" height="1"></td>
   </tr>
   <tr class="c1">
      <td align="right"><b><?php echo GMSG_STATUS;?></b></td>
      <td><?php echo $display_account_status;?></td>
      <td align="right"><b><?php echo GMSG_REG_DATE;?></b></td>
      <td><?php echo show_date($user_details['reg_date'], false);?></td>
   </tr>
   <tr class="c1">
      <td align="right"><b><?php echo GMSG_PAYMENT_MODE;?></b></td>
      <td><?php echo $display_payment_mode;?></td>
      <?php if ($user_payment_mode == 2) { ?>
      <td align="right"><b><?php echo GMSG_BALANCE;?></b></td>
      <td class="contentfont"><?php echo $display_balance_details;?></td>
      <?php } ?>
   </tr>
   <?php if ($user_payment_mode == 2) { ?>
   <tr>
      <td></td>
      <td></td>
      <td align="right" class="c1"><b><?php echo GMSG_MAX_DEBIT;?></b></td>
      <td class="c1"><?php echo $fees->display_amount($user_details['max_credit'], $setts['currency'], true);?></td>
   </tr>
   <?php } ?>
   <?php if ($user_details['balance'] <= 0 && $user_payment_mode == 2 && $session->value('membersarea') == 'Active') { ?>
   <!-- credit account snippet -->
   <form action="fee_payment.php" method="GET">
      <input type="hidden" name="do" value="credit_account">
      <tr valign="top">
         <td></td>
         <td></td>
         <td colspan="2"><table class="border" width="100%" cellpadding="3" cellspacing="2">
               <tr>
                  <td class="c3"><?php echo MSG_CREDIT_ACCOUNT;?></td>
               </tr>
               <tr>
                  <td class="c2" valign="middle" nowrap><?php echo $setts['currency'];?>
                     <input type="text" name="credit_amount" value="" size="8">
                     <input type="submit" name="form_credit_acc_proceed" value="<?php echo GMSG_PROCEED;?>" >
                     <img src="themes/<?php echo $setts['default_theme'];?>/img/system/cards.gif" align="absmiddle" hspace="2" vspace="2"> 
                     <?php echo $payment_gateways_logos;?></td>
               </tr>
            </table></td>
      </tr>
   </form>
   <?php } ?>
</table>
<?php if ($is_pending_gc > 0) { ?>
<br>
<table width="100%" cellpadding="3" cellspacing="1" class="errormessage">
	<tr class="contentfont">
		<td class="c3" align="center" colspan="5"><strong><?php echo MSG_PENDING_GC_PAYMENTS;?></strong></td>
	</tr>
	<tr class="contentfont">
		<td width="100%"><b><?php echo GMSG_DESCRIPTION;?></b></td>
		<td nowrap align="center"><b><?php echo MSG_PAYMENT_TO;?></b></td>
		<td nowrap align="center"><strong><?php echo GMSG_AMOUNT;?></strong></td>
		<td nowrap align="center"><strong><?php echo MSG_PAYMENT_DATE;?></strong></td>
		<td nowrap align="center"><strong><?php echo MSG_PAYMENT_TYPE;?></strong></td>
	</tr>
	<?php echo $pending_gc_transactions_content;?>
</table>
<?php } ?>
<?php if ($page != 'summary') { ?>
<br />
<?php } ?>
