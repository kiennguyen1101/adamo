<?php
#################################################################
## MyPHPAuction v6.03															##
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
	$msg_changes_saved = '<p align="center" class="contentfont">' . AMSG_CHANGES_SAVED . '</p>';

	$parent_id = (!$_REQUEST['parent_id']) ? 0 : $_REQUEST['parent_id'];

	if (isset($_POST['form_generate_subcategories']) or $_REQUEST['generate_subcategories'] == 1)
	{
		(array) $subcat_ids_array = NULL;

		$template->set('msg_changes_saved', $msg_changes_saved);

		$sql_reset_subcategories = $db->query("UPDATE " . DB_PREFIX . "categories SET is_subcat=''");

		$sql_select_subcategories = $db->query("SELECT parent_id FROM " . DB_PREFIX . "categories WHERE
			parent_id>0");

		while ($subcat_details = $db->fetch_array($sql_select_subcategories))
		{
			$subcat_ids_array[] = $subcat_details['parent_id'];
		}

		if (count($subcat_ids_array) > 0)
		{
			$subcat_ids = $db->implode_array($subcat_ids_array);

			$sql_update_subcategories = $db->query("UPDATE " . DB_PREFIX . "categories SET
				is_subcat='>' WHERE category_id IN (" . $subcat_ids . ")");
		}## MyPHPAuction 2009 here we delete all subcategories that have no parent anymore		
		$delete_subcats = 1;
		while ($delete_subcats) 
		{
			(array) $subcategory = null;
			
			$sql_select_obsolete_cats = $db->query_silent("SELECT c.category_id FROM " . DB_PREFIX . "categories c WHERE 
				(SELECT count(*) FROM " . DB_PREFIX . "categories cc WHERE cc.category_id=c.parent_id)=0 AND c.parent_id!=0");
			
			$delete_subcats = 0;
			
			if ($sql_select_obsolete_cats)
			{
				while ($subcat_details = $db->fetch_array($sql_select_obsolete_cats)) 
				{
					$delete_subcats = 1;
					$subcategory[] = $subcat_details['category_id'];
				}
				
				if ($delete_subcats)
				{
					$delete_array = $db->implode_array($subcategory);
					$db->query("DELETE FROM " . DB_PREFIX . "categories WHERE category_id IN (" . $delete_array . ")");
				}
			}
			else 
			{
				## delete obsolete cats using the old slower version 
				$sql_select_subcats = $db->query("SELECT * FROM " . DB_PREFIX . "categories WHERE parent_id!=0");
					
				while ($subcat_details = $db->fetch_array($sql_select_subcats)) 
				{
					$is_maincat = $db->count_rows('categories', "WHERE category_id='" . $subcat_details['parent_id'] . "'");
					
					if ($is_maincat == 0) 
					{
						$db->query("DELETE FROM " . DB_PREFIX . "categories WHERE parent_id='" . $subcat_details['parent_id'] . "'");
					}
				}
			}
		}
	}

	if (isset($_POST['form_save_settings']))
	{
		$session->set('category_language', 1);

		$template->set('msg_changes_saved', $msg_changes_saved);

		if (count($_POST['category_id']))
		{
			foreach ($_POST['category_id'] as $key => $value)
			{
				$order_id = ($_POST['order_id'][$key]>0 && $_POST['order_id'][$key]<10000) ? $_POST['order_id'][$key] : 10000;
	
				$sql_update_categories = $db->query("UPDATE " . DB_PREFIX . "categories SET
					name='" . $db->rem_special_chars($_POST['name'][$key]) . "', minimum_age='" . intval($_POST['minimum_age'][$key]) . "', 
					order_id=" . $order_id . ", custom_skin='" . $_POST['default_theme'][$key] . "' WHERE category_id=" . $value);
			}
		}

		$sql_reset_hidden = $db->query("UPDATE " . DB_PREFIX . "categories SET hidden=0 WHERE parent_id=" . $parent_id);
		$hidden_array = $db->implode_array($_POST['hidden']);
		$sql_update_hidden = $db->query("UPDATE " . DB_PREFIX . "categories SET
			hidden=1 WHERE category_id IN (" . $hidden_array . ")");

		$sql_reset_custom_fees = $db->query("UPDATE " . DB_PREFIX . "categories SET custom_fees=0 WHERE parent_id=" . $parent_id);
		$custom_fees_array = $db->implode_array($_POST['custom_fees']);
		$sql_update_custom_fees = $db->query("UPDATE " . DB_PREFIX . "categories SET
			custom_fees=1 WHERE category_id IN (" . $custom_fees_array . ")");

		if (count($_POST['delete'])>0)
		{
			$delete_array = $db->implode_array($_POST['delete']);

			$sql_delete_categories = $db->query("DELETE FROM " . DB_PREFIX . "categories WHERE category_id IN (" . $delete_array . ")");## MyPHPAuction 2009 all the subcategories need to be deleted as well.
		}## MyPHPAuction 2009 IMPORTANT: custom fees is not implemented until we create some fees.

		foreach ($_POST['add_name'] as $value)
		{
			if (!empty($value))
			{
				$sql_insert_category = $db->query("INSERT INTO " . DB_PREFIX . "categories
					(name, parent_id) VALUES ('" . $db->rem_special_chars($value) . "', " . $parent_id . ")");
			}
		}
	}

	$template->set('parent_id', $parent_id);

	$template->set('header_section', AMSG_TABLES_MANAGEMENT);
	$template->set('subpage_title', AMSG_EDIT_CATEGORIES);

	$template->set('category_navigator', category_navigator($parent_id));

	(string) $categories_page_content = NULL;
	(string) $add_category_content = NULL;

	$sql_select_categories = $db->query("SELECT category_id, name, parent_id, order_id, hidden, custom_fees, 
		user_id, is_subcat, minimum_age, custom_skin FROM " . DB_PREFIX . "categories WHERE 
		parent_id=" . $parent_id . " ORDER BY order_id ASC, name ASC");

	while ($category_details = $db->fetch_array($sql_select_categories))
	{
		$background = ($counter++%2) ? 'c1' : 'c2';
		$background_border = (!empty($category_details['is_subcat'])) ? 'grey' : $background;

		$order_value = ($category_details['order_id']>0 && $category_details['order_id']<1000) ? $category_details['order_id'] : '';

		$categories_page_content .= '<tr class="' . $background . '"> '.
			'	<td class="' . $background_border . '"><a href="table_categories.php?parent_id=' . $category_details['category_id'] . '"> '.
			'		<img src="images/catplus.gif" alt="' . AMSG_VIEW_SUBCATEGORIES . '" width="20" height="20" border="0"></a></td> '.
			'	<td><input name="name[]" type="text" id="name[]" value="' . $category_details['name'] . '" style="width:65%"> ' ;

		if ($category_details['user_id']>0)
		{
			$categories_page_content .= ' &nbsp; <strong>' . AMSG_OWNER_ID . ':</strong> '.
				'[ <a href="list_site_users.php?do=user_details&user_id=' . $category_details['user_id'].'"> '.$category_details['user_id'].'</a> ]';
		}

		$categories_page_content .= '<input type="hidden" name="category_id[]" value="' . $category_details['category_id'] . '"> ';

		if ($category_details['parent_id']==0)
		{
			$categories_page_content .= '<br>[ <a href="javascript:popUp(\'table_categories_options.php?category_id=' . $category_details['category_id'] . '\');">' . AMSG_EDIT_CATEGORY_OPTIONS . '</a> ] ';
		}

		$categories_page_content .= '</td> '.
			'<td align="center"> '.
			'	<input name="order_id[]" type="text" id="order_id[]" value="' . $order_value . '" size="8"></td> ';

		if ($category_details['parent_id']==0)
		{
			$categories_page_content .= '<td align="center">' .
				(($category_details['user_id']==0) ? list_skins('admin', true, $category_details['custom_skin'], true, true) : '') . '</td>'.
				'<td align="center">' .
				(($category_details['user_id']==0) ? '<input name="minimum_age[]" type="text" id="minimum_age[]" size="8" value="' . $category_details['minimum_age'] . '">' : '') . '</td>'.
				'	<td align="center">' .
				(($category_details['user_id']==0) ? '<input name="custom_fees[]" type="checkbox" id="custom_fees[]" value="' . $category_details['category_id'] . '" '.
				(($category_details['custom_fees']) ? 'checked' : '') . '>' : '' ) . '</td>';
		}

		$categories_page_content .= '<td align="center"> '.
			'		<input name="hidden[]" type="checkbox" id="hidden[]" value="' . $category_details['category_id'] . '" ' . (($category_details['hidden']==1) ? 'checked' : '') . '></td> '.
			'	<td align="center"><input name="delete[]" type="checkbox" id="delete[]" value="' . $category_details['category_id'] . '"></td> '.
         '</tr> ';

	}

	(int) $add_cats_counter = 5;

	$add_category_content = '<tr class="c1"> '.
		'	<td>&nbsp;</td> '.
		'	<td> ';

	for ($i=0; $i<$add_cats_counter; $i++)
	{
		$add_category_content .= '<input name="add_name[]" type="text" id="add_name[]"><br> ';
	}

	$add_category_content .='</td>' .
		'	<td align="center">&nbsp;</td> ';

	if ($parent_id == 0)
	{
   	$add_category_content .= '<td align="center">&nbsp;</td> '.
   		'<td align="center">&nbsp;</td> ';
	}

	$add_category_content .= '<td align="center">&nbsp;</td> '.
		'	<td align="center">&nbsp;</td> '.
		'</tr> ';

	$template->set('categories_page_content', $categories_page_content);
	$template->set('add_category_content', $add_category_content);

	include_once ('header.php');

	$template_output .= $template->process('table_categories.tpl.php');

	include_once ('footer.php');

	echo $template_output;
}
?>