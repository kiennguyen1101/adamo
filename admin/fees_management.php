<?php
#################################################################
## MyPHPAuction v6.05															##
##-------------------------------------------------------------##
## Copyright �2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_ADMIN', 1);

include_once ('../includes/global.php');

if ($session->value('adminarea')!='Active')
{
	header_redirect('login.php');
}
else
{
	include_once ('header.php');

	(string) $management_box = NULL;

	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	if ($_REQUEST['operation'] == 'submit')
	{
		$template->set('msg_changes_saved', $msg_changes_saved);

      try {
        if ($_REQUEST['tiers'] == 1) {
          if (count($_POST['tier_id'])) {
            global $db;
            foreach ($_POST['tier_id'] as $key => $value) {
              $sql_update_tiers = $db->query("UPDATE " . DB_PREFIX . "fees_tiers SET
						fee_from='" . $_POST['fee_from'][$key] . "', fee_to='" . $_POST['fee_to'][$key] . "',
						fee_amount='" . $_POST['fee_amount'][$key] . "', calc_type='" . $_POST['calc_type'][$key] . "' WHERE
						tier_id=" . $value);
					}
				}
			}

			if (!empty($_POST['new_fee_amount']))
			{
				$sql_insert_tier = $db->query("INSERT INTO " . DB_PREFIX . "fees_tiers
					(fee_from, fee_to, fee_amount, calc_type, category_id, fee_type) VALUES
					('" . $_POST['new_fee_from'] . "', '" . $_POST['new_fee_to'] . "', '" . $_POST['new_fee_amount'] . "',
					'" . $_POST['new_calc_type'] . "', " . $_POST['category_id'] . ", '" . $_POST['fee_column'] . "')");
			}

			if (count($_POST['delete'])>0)
			{
				$delete_array = $db->implode_array($_POST['delete']);

				$sql_delete_tiers = $db->query("DELETE FROM " . DB_PREFIX . "fees_tiers WHERE tier_id IN (" . $delete_array . ")");
			}
		

		if ($_REQUEST['tiers'] !=1 || $_REQUEST['fee_column'] == 'endauction')
		{
			$is_fee_row = $db->count_rows('fees', "WHERE category_id=" . $_REQUEST['category_id']);

			if (!$is_fee_row)
			{
				$sql_insert_fee = $db->query("INSERT INTO " . DB_PREFIX . "fees
					(category_id) VALUES (" . $_REQUEST['category_id'] . ")");
			}

			$fee_column = ($_REQUEST['fee_column'] == 'endauction') ? 'endauction_fee_applies' : $_REQUEST['fee_column'];

			$sql_update_fee = $db->query("UPDATE " . DB_PREFIX . "fees SET
				" . $fee_column . "='" . $_REQUEST['value'] . "' 
				" . (($fee_column == 'picture_fee') ? ", free_images=" . intval($_REQUEST['free_images']) : '') . " 
				" . (($fee_column == 'video_fee') ? ", free_media=" . intval($_REQUEST['free_media']) : '') . " 
				WHERE category_id=" . $_REQUEST['category_id']);
				}

				$db->beginTransaction();
				$db->commit();
			  } catch (error $e) {
				$db->rollBack();
				echo $e;

		}

	}

	$template->set('header_section', AMSG_FEES);
	$template->set('subpage_title', AMSG_FEES_MANAGEMENT);

	(string) $categories_list_menu = null;

	$categories_list_menu = categories_list ($_REQUEST['category_id']);

	$template->set('categories_list_menu', $categories_list_menu);

	if (isset($_REQUEST['category_id']))
	{
		$template->set('category_id', $_REQUEST['category_id']);

		$fees_table = $template->process('fees_management_fees_table.tpl.php');

		$template->set('fees_table', $fees_table);
	}

	if (isset($_REQUEST['fee_column']))
	{
		$fee_row = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "fees WHERE category_id=" . $_REQUEST['category_id']);
		$template->set('fee', $fee_row);

		$template->set('fee_column', $_REQUEST['fee_column']);

		if ($_REQUEST['tiers'] == 1)
		{

			$sql_select_tiers = $db->query("SELECT tier_id, fee_from, fee_to, fee_amount, calc_type, category_id FROM
				" . DB_PREFIX ."fees_tiers WHERE fee_type='".$_REQUEST['fee_column']."' AND category_id=" . $_REQUEST['category_id']. " ORDER BY fee_from ASC");

			switch ($_REQUEST['fee_column'])
			{
				case 'setup':
					$fee_box_title =  GMSG_SETUP_FEE;
					break;
				case 'endauction':
					$fee_box_title = GMSG_ENDAUCTION_FEE;
					break;
			}

			$template->set('fee_box_title', $fee_box_title);

			(string) $fees_tiers_content = null;

			while ($tier_details = $db->fetch_array($sql_select_tiers))
			{
				$background = ($counter++%2) ? 'c1' : 'c2';

				$fees_tiers_content .= '<input type="hidden" name="tier_id[]" value="' . $tier_details['tier_id'] . '"> '.
      			'<tr class="' . $background . '"> '.
         		'	<td><input name="fee_from[]" type="text" id="fee_from[]" value="' . $tier_details['fee_from'] . '" size="9"></td> '.
         		'	<td><input name="fee_to[]" type="text" id="fee_to[]" value="' . $tier_details['fee_to'] . '" size="9"></td> '.
         		'	<td><input name="fee_amount[]" type="text" id="fee_amount[]" value="' . $tier_details['fee_amount'] . '" size="9"></td> '.
					'	<td><select name="calc_type[]" id="calc_type[]"> '.
               '			<option value="flat" selected>' . GMSG_FLAT . '</option> '.
               '			<option value="percent" ' . (($tier_details['calc_type']== 'percent') ? 'selected' : '') . '>' . GMSG_PERCENT . '</option> '.
					'		</select></td> '.
         		'	<td align="center"><input type="checkbox" name="delete[]" value="' . $tier_details['tier_id'] . '"></td> '.
      			'</tr>';
			}

			$template->set('fees_tiers_content', $fees_tiers_content);

			$fees_box = $template->process('fees_management_fee_box_tiers.tpl.php');

			$template->set('fees_box', $fees_box);
		}
		else
		{
			switch ($_REQUEST['fee_column'])
			{
				case 'signup_fee':
					$fee_box_title = GMSG_USER_SIGNUP_FEE;
					$fee_description = AMSG_USER_SIGNUP_FEE_DESC;
					break;
				case 'hpfeat_fee':
					$fee_box_title = GMSG_HPFEAT_FEE;
					$fee_description = AMSG_HPFEAT_FEE_DESC;
					break;
				case 'catfeat_fee':
					$fee_box_title = GMSG_CATFEAT_FEE;
					$fee_description = AMSG_CATFEAT_FEE_DESC;
					break;
				case 'hlitem_fee':
					$fee_box_title = GMSG_HL_FEE;
					$fee_description = AMSG_HL_FEE_DESC;
					break;
				case 'bolitem_fee':
					$fee_box_title = GMSG_BOLD_FEE;
					$fee_description = AMSG_BOLD_FEE_DESC;
					break;
				case 'picture_fee':
					$fee_box_title = GMSG_IMG_UPL_FEE;
					$fee_description = AMSG_IMG_UPL_FEE_DESC;
					break;
				case 'video_fee':
					$fee_box_title = GMSG_MEDIA_UPL_FEE;
					$fee_description = AMSG_MEDIA_UPL_FEE_DESC;
					break;
				case 'second_cat_fee':
					$fee_box_title = GMSG_ADDLCAT_FEE;
					$fee_description = AMSG_ADDLCAT_FEE_DESC;
					break;
				case 'custom_start_fee':
					$fee_box_title = GMSG_CUSTOM_START_FEE;
					$fee_description = AMSG_CUSTOM_START_FEE_DESC;
					break;
				case 'buyout_fee':
					$fee_box_title = GMSG_BUYOUT_FEE;
					$fee_description = AMSG_BUYOUT_FEE_DESC;
					break;
				case 'rp_fee':
					$fee_box_title = GMSG_RP_FEE;
					$fee_description = AMSG_RP_FEE_DESC;
					break;
				case 'relist_fee_reduction':
					$fee_box_title = GMSG_REL_FEES_RED_FEE;
					$fee_description = AMSG_REL_FEES_RED_FEE_DESC;
					break;
				case 'wanted_ad_fee':
					$fee_box_title = GMSG_WA_SETUP_FEE;
					$fee_description = AMSG_WA_SETUP_FEE_DESC;
					break;
				case 'endauction':
					$fee_description = AMSG_ENDAUCTION_FEE_APPLIES;
					break;
				case 'makeoffer_fee':
					$fee_box_title = GMSG_MAKEOFFER_FEE;
					$fee_description = AMSG_MAKEOFFER_FEE_DESC;
					break;
				case 'swap_fee':
					$fee_box_title = GMSG_SWAP_FEE;
					$fee_description = AMSG_SWAP_FEE_DESC;
			}

			$template->set('fee_box_title', $fee_box_title);
			$template->set('fee_description', $fee_description);

			$fees_box .= $template->process('fees_management_fee_box_no_tiers.tpl.php');

			$template->set('fees_box', $fees_box);
		}
	}

	$template_output .= $template->process('fees_management.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>