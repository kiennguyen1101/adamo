<?php
#################################################################
## MyPHPAuction v6.04															##
##-------------------------------------------------------------##
## Copyright ©2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

if ( !defined('INCLUDED') ) { die("Access Denied"); }
?>

<br>
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="shared_table">
   <tr>
      <td class="c3" colspan="2"><?php echo MSG_LEAVE_COMMENTS;?>
         <?php echo strtolower(GMSG_TO);?>
         <b>
         <?php echo $reputation_details['username'];?>
         </b>
         <?php echo strtolower(GMSG_FOR);?>
         <b>
         <?php echo $reputation_details['auction_name'];?>
         </b></td>
   </tr>

            <form action="members_area.php?page=reputation&section=post" method="post">
               <input type="hidden" name="reputation_id" value="<?php echo $reputation_details['reputation_id'];?>">
               <tr class="membmenu">
                  <td align="center"><?php echo MSG_RATE;?></td>
                  <td><?php echo MSG_COMMENTS;?></td>
               </tr>
               <tr class="c5">
                  <td><img src="themes/<?php echo $setts['default_theme'];?>/img/pixel.gif" width="250" height="1"></td>
                  <td width="100%"><img src="themes/<?php echo $setts['default_theme'];?>/img/pixel.gif" width="100%" height="1"></td>
               </tr>
               <tr class="c1">
                  <td align="left">
				   <table>
				    <tr>
					<td><input name="reputation_rate" type="radio" value="5" checked="checked" />
                     <?php echo MSG_DANHGIA1 ?>
					</td>
					<td>
					<img src="themes/<?php echo $setts['default_theme'];?>/img/system/5stars.gif" />
					</td>
					</tr>
					<tr>
					<td>
                     <input type="radio" name="reputation_rate" value="4" <?php echo ($post_details['reputation_rate']==4) ? "checked" : ""; ?> />
                     <?php echo MSG_DANHGIA2 ?>
					</td>
					<td><img src="themes/<?php echo $setts['default_theme'];?>/img/system/4stars.gif" /></td>
					</tr>
					<tr>
					<td>
                     <input type="radio" name="reputation_rate" value="3" <?php echo ($post_details['reputation_rate']==3) ? "checked" : ""; ?> />
                     <?php echo MSG_DANHGIA3 ?></td>
					 <td><img src="themes/<?php echo $setts['default_theme'];?>/img/system/3stars.gif" /></td>
					</tr>
					<tr>
                    <td><input type="radio" name="reputation_rate" value="2" <?php echo ($post_details['reputation_rate']==2) ? "checked" : ""; ?> />
                     <?php echo MSG_DANHGIA4 ?></td>
					<td><img src="themes/<?php echo $setts['default_theme'];?>/img/system/2stars.gif" /></td>
					</tr>
					<tr>
					<td>
                     <input type="radio" name="reputation_rate" value="1" <?php echo ($post_details['reputation_rate']==1) ? "checked" : ""; ?> />
                     <?php echo MSG_DANHGIA5 ?></td>
					 <td>
					 <img src="themes/<?php echo $setts['default_theme'];?>/img/system/1stars.gif" /></td>
					</tr>
			    	</table>
					<script language="javascript" type="text/javascript">
                     function imposeMaxLength(Object, MaxLen)
                         {
                           return (Object.value.length <= MaxLen);
                         }
                   </script> 
                  <td><textarea name="reputation_content" style="resize:none;width:98%" rows="5" onkeypress="return imposeMaxLength(this, 160)" id="reputation_content"><?php echo $post_details['reputation_content'];?></textarea></td>
               </tr>
               <?php echo $custom_sections_table;?>
               <tr>
                  <td colspan="2" class="c4"></td>
               </tr>
               <tr>
                  <td colspan="2" class="contentfont" align="center"><input type="submit" class="buttons" value="<?php echo MSG_LEAVE_COMMENTS;?>" name="form_leave_comments">
                  </td>
               </tr>
            </form>

   <?php echo $display_formcheck_errors;?>
</table>
