<?php
#################################################################
## MyPHPAuction v6.05 														##
##-------------------------------------------------------------##
## Copyright �2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

include_once('class_image.php');

class item extends custom_field
{
    var $can_upload = false;
    /**
     * $image_basedir needs to be the same as in class_image
     * The variable can not be altered!
     */
    var $image_basedir = 'uplimg/';
    var $relative_path = '';
    var $min_hours = 12; ## set to 12 hours.
    var $min_hours_close = 12; ## to close auction early
    var $edit_auction = false;
    var $upload_wa_img = false;
    var $add_unique = true;
    var $extension = null;
    var $upload_url = true;
    var $override_min_bid = false; ## used in case we want to place the proxy bid directly (for the dutch auction fix)
    var $min_bid = 0; ## for the dutch auction fix
    var $show_hidden_bid = false;
    var $second_chance = false;

    var $show_free_images = false;

    var $fees;
    var $tax;
    var $shop;

    function create_temporary_item($user_id)
    {
        $this->query("INSERT INTO " . DB_PREFIX . "auctions
			(creation_in_progress, creation_date, owner_id) VALUES
			(1, " . CURRENT_TIME . ", '" . $user_id . "')");

        $auction_id = $this->insert_id();

        return $auction_id;
    }

    function create_temporary_wanted_ad($user_id)
    {
        $this->query("INSERT INTO " . DB_PREFIX . "wanted_ads
			(creation_in_progress, creation_date, owner_id) VALUES
			(1, " . CURRENT_TIME . ", '" . $user_id . "')");

        $wanted_ad_id = $this->insert_id();

        return $wanted_ad_id;
    }

    function prepare_auction_variables($item_details)
    {
        $item_details['auction_type'] = (in_array($item_details['auction_type'], array('standard', 'dutch'))) ? $item_details['auction_type'] : 'standard';
        $item_details['quantity'] = ($item_details['auction_type'] == 'standard' || $item_details['quantity'] < 1) ? 1 : $item_details['quantity'];
        $item_details['reserve_price'] = ($item_details['auction_type'] != 'dutch') ? (($item_details['is_reserve'] == 1) ? $item_details['reserve_price'] : 0) : 0;
        $item_details['buyout_price'] = (($item_details['is_buy_out'] == 1 || $item_details['listing_type'] == 'buy_out') && $this->setts['buyout_process'] == 1 && $this->layout['enable_buyout'] == 1) ? $item_details['buyout_price'] : 0;
        $item_details['bid_increment_amount'] = ($item_details['is_bid_increment'] == 1) ? $item_details['bid_increment_amount'] : 0;
        $item_details['duration'] = ($item_details['end_time_type'] == 'duration') ? $item_details['duration'] : (($item_details['end_time'] - $item_details['start_time']) / 86400);
        $item_details['closed'] = ($item_details['start_time_type'] == 'now' || $item_details['start_time'] < CURRENT_TIME) ? 0 : 1;

        /* addition for store only mode -> list_in = 'both' if enabled */
        $item_details['list_in'] = ($this->setts['enable_store_only_mode']) ? 'both' : $item_details['list_in'];
        $item_details['list_in'] = (in_array($item_details['list_in'], array('auction', 'store', 'both'))) ? $item_details['list_in'] : 'auction';

        /* addition for store only mode -> start_price = buyout_price if enabled */
        $item_details['start_price'] = ($this->setts['enable_store_only_mode'] || $item_details['listing_type'] == 'buy_out') ? $item_details['buyout_price'] : $item_details['start_price'];

        $item_details['auto_relist_nb'] = ($item_details['is_auto_relist']) ? $item_details['auto_relist_nb'] : 0;
        $item_details['creation_in_progress'] = 0;

        return $item_details;
    }

    function auction_approval($item_details, $user_id)
    {
        ## output = 1 => no approval required
        ## output = 0 => admin approval required

        $output = 1;

        if ($this->setts['enable_auctions_approval']) {
            $output = 0;
        } else {
            $categories_array = explode(',', $this->setts['approval_categories']);
            $user_auction_approval = $this->get_sql_field("SELECT auction_approval FROM " . DB_PREFIX . "users WHERE
				user_id='" . $user_id . "'", 'auction_approval');

            $category_id = $this->main_category($item_details['category_id']);
            $addl_category_id = $this->main_category($item_details['addl_category_id']);

            if ($this->setts['approval_categories'] != 0 && (in_array($category_id, $categories_array) || in_array($addl_category_id, $categories_array))) {
                $output = 0;
            } else if ($user_auction_approval == 1) {
                $output = 0;
            }
        }

        ## auctions counter - add process - single auction (activate on account mode)
        $cnt_details = $this->get_sql_row("SELECT auction_id, active, approved, closed, deleted, list_in, category_id, addl_category_id FROM
			" . DB_PREFIX . "auctions WHERE auction_id='" . $item_details['auction_id'] . "'");

        $cnt_operation = ($output == 1) ? 'add' : 'remove';
        $cnt_approve = ($output == 1) ? 0 : 1;

        if ($cnt_details['active'] == 1 && $cnt_details['approved'] == $cnt_approve && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0 && $cnt_details['list_in'] != 'store') {
            auction_counter($cnt_details['category_id'], $cnt_operation, $cnt_details['auction_id']);
            auction_counter($cnt_details['addl_category_id'], $cnt_operation, $cnt_details['auction_id']);
        }

        $sql_update_auction = $this->query("UPDATE " . DB_PREFIX . "auctions SET approved='" . $output . "' WHERE
			auction_id='" . $item_details['auction_id'] . "'");

        if (!$output && IN_ADMIN != 1) {
            include('language/' . $this->setts['site_lang'] . '/mails/auction_approval_admin_notification.php');
        }
    }

    function insert($variables_array, $owner_id, $page_handle = 'auction', $draft = false)
    {
        $item_details = $this->prepare_auction_variables($variables_array);

        $item_details = $this->rem_special_chars_array($item_details);

        $save_start_time = true;
        if ($this->edit_auction) {
            $start_time_type = $this->get_sql_field("SELECT start_time_type FROM " . DB_PREFIX . "auctions WHERE
				auction_id='" . $item_details['auction_id'] . "' AND owner_id='" . $owner_id . "'", 'start_time_type');

            if ($start_time_type == 'now') {
                $save_start_time = false;
            }
        }

        if ($save_start_time) {
            $start_time_query = "start_time='" . $item_details['start_time'] . "', start_time_type='" . $item_details['start_time_type'] . "', ";
        }

        $word_filter = array('name' => $item_details['name'], 'description' => $item_details['description'], 'shipping_details' => $item_details['shipping_details']);
        $word_filter = $this->word_filter($word_filter);

        $is_draft = ($draft) ? 1 : 0;

        // important: the active, approved & payment_status fields cannot be modified through here!
        ## no auction counter is applied on this query - if needed we will add one (for list_in eventually)
        try {
//            $this->beginTransaction();
            $sql_insert_item = $this->query("UPDATE " . DB_PREFIX . "auctions SET

			name='" . $word_filter['name'] . "', description='" . $word_filter['description'] . "',
			quantity='" . $item_details['quantity'] . "', auction_type='" . $item_details['auction_type'] . "',
			start_price='" . $item_details['start_price'] . "', reserve_price='" . $item_details['reserve_price'] . "',
			buyout_price='" . $item_details['buyout_price'] . "',	bid_increment_amount='" . $item_details['bid_increment_amount'] . "',
			duration='" . $item_details['duration'] . "', country='" . $item_details['country'] . "',
			zip_code='" . $item_details['zip_code'] . "', shipping_method='" . $item_details['shipping_method'] . "',
			shipping_int='" . $item_details['shipping_int'] . "', payment_methods='" . $item_details['payment_methods'] . "',
			category_id='" . $item_details['category_id'] . "', closed='" . $item_details['closed'] . "',
			owner_id='" . $owner_id . "', hpfeat='" . $item_details['hpfeat'] . "',
			catfeat='" . $item_details['catfeat'] . "', bold='" . $item_details['bold'] . "', hl='" . $item_details['hl'] . "',
			hidden_bidding='" . $item_details['hidden_bidding'] . "', currency='" . $item_details['currency'] . "',
			postage_amount='" . $item_details['postage_amount'] . "', insurance_amount='" . $item_details['insurance_amount'] . "',
			type_service='" . $item_details['type_service'] . "',	enable_swap='" . $item_details['enable_swap'] . "',
			addl_category_id='" . $item_details['addl_category_id'] . "', shipping_details='" . $word_filter['shipping_details'] . "',
			list_in='" . $item_details['list_in'] . "', direct_payment='" . $item_details['direct_payment'] . "',
			apply_tax='" . $item_details['apply_tax'] . "',	auto_relist_bids='" . $item_details['auto_relist_bids'] . "',
			end_time_type='" . $item_details['end_time_type'] . "', listing_type='" . $item_details['listing_type'] . "',
			is_offer='" . $item_details['is_offer'] . "', offer_min='" . $item_details['offer_min'] . "',
			offer_max='" . $item_details['offer_max'] . "',	auto_relist_nb='" . $item_details['auto_relist_nb'] . "',
			end_time='" . $item_details['end_time'] . "',
			" . $start_time_query . "
			creation_in_progress='" . $item_details['creation_in_progress'] . "', state='" . $item_details['state'] . "', 
			is_draft='" . $is_draft . "'
			WHERE auction_id='" . $item_details['auction_id'] . "' AND owner_id='" . $owner_id . "'");
            //" . (($this->edit_auction) ? "is_relisted_item=0, " : '') . "

            $auction_id = $item_details['auction_id'];

            if ($this->edit_auction) {
                $update_auction_media = $this->query("UPDATE " . DB_PREFIX . "auction_media SET
				upload_in_progress=0 WHERE auction_id='" . $auction_id . "'");
            }

            if (!$draft) {
                $this->auction_approval($variables_array, $owner_id);
            }
            $this->update_page_data($auction_id, $page_handle, $item_details);
//            $this->commit();
        } catch (error $e) {
//            $this->rollBack();
            error::dump_exception($e);

        }


        $this->update_page_data($auction_id, $page_handle, $item_details);

        ##keywords watch feature -> added back in v6.04
        if (!$this->edit_auction) {
            $mail_input_id = $auction_id;
            include('language/' . $this->setts['site_lang'] . '/mails/keywords_watch_notification.php');
        }

        return $auction_id;
    }

    function insert_wanted_ad($variables_array, $owner_id, $page_handle = 'wanted_ad', $edit = false)
    {
        $item_details = $this->rem_special_chars_array($variables_array);

        $word_filter = array('name' => $item_details['name'], 'description' => $item_details['description']);
        $word_filter = $this->word_filter($word_filter);

        $start_time = ($edit) ? $item_details['start_time'] : CURRENT_TIME;
        $end_time = $start_time + $item_details['duration'] * 86400;

        // important: the active, approved & payment_status fields cannot be modified through here!
        $sql_insert_item = $this->query("UPDATE " . DB_PREFIX . "wanted_ads SET
			name='" . $word_filter['name'] . "', description='" . $word_filter['description'] . "',
			duration='" . $item_details['duration'] . "', country='" . $item_details['country'] . "',
			zip_code='" . $item_details['zip_code'] . "', category_id='" . $item_details['category_id'] . "',
			owner_id='" . $owner_id . "', addl_category_id='" . $item_details['addl_category_id'] . "',
			end_time='" . $end_time . "', start_time='" . $start_time . "',
			creation_in_progress='0', state='" . $item_details['state'] . "'
			WHERE wanted_ad_id='" . $item_details['wanted_ad_id'] . "' AND owner_id='" . $owner_id . "'");

        $wanted_ad_id = $item_details['wanted_ad_id'];

        $this->update_page_data($wanted_ad_id, $page_handle, $item_details);

        return $wanted_ad_id;
    }

    function delete_wanted_ad($delete_array, $owner_id, $admin_area = false)
    {
        ## first we remove the auction media.
        $sql_select_media = $this->query("SELECT * FROM " . DB_PREFIX . "auction_media WHERE
			wanted_ad_id IN (" . $delete_array . ")");

        while ($media_details = $this->fetch_array($sql_select_media)) {
            $item_details['wanted_ad_id'] = $media_details['wanted_ad_id'];

            if ($media_details['media_type'] == 1) {
                $item_details['ad_image'][0] = $media_details['media_url'];
            } else {
                $item_details['ad_video'][0] = $media_details['media_url'];
            }

            $this->media_removal($item_details, $media_details['media_type'], 0);
        }

        ## wanted counter - remove process - multiple ads
        $sql_select_wa = $this->query("SELECT wanted_ad_id, active, closed, deleted, category_id, addl_category_id FROM
			" . DB_PREFIX . "wanted_ads WHERE wanted_ad_id IN (" . $delete_array . ") " . ((!$admin_area) ? "AND owner_id='" . $owner_id . "'" : ''));

        while ($cnt_details = $this->fetch_array($sql_select_wa)) {
            if ($cnt_details['active'] == 1 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0) {
                wanted_counter($cnt_details['category_id'], 'remove');
                wanted_counter($cnt_details['addl_category_id'], 'remove');
            }
        }

        ## now we remove all the rows from all the related tables.
        $this->query("DELETE FROM " . DB_PREFIX . "wanted_ads WHERE
			wanted_ad_id IN (" . $delete_array . ") " . ((!$admin_area) ? "AND owner_id='" . $owner_id . "'" : ''));
    }

    function relist_wanted_ad($wanted_ad_id, $user_id, $duration = 0, $charge_fees = true)
    {
        $output = array('display' => null);

        $relist_option = 1; ## relist as a new auction, mark as deleted the old auction
        ##$relist_option = 2; ## relist the same auction

        $file_path = (IN_ADMIN) ? '../' : '';

        $item_details = $this->get_sql_row("SELECT w.* FROM " . DB_PREFIX . "wanted_ads w WHERE
			w.wanted_ad_id=" . $wanted_ad_id . " AND w.owner_id=" . $user_id);

        $auction_duration = $item_details['duration'];

        if ($relist_option == 1) {
            $sql_relist_auction = $this->query("INSERT INTO " . DB_PREFIX . "wanted_ads
				(name, description, country, zip_code, category_id, owner_id, addl_category_id, state)
				SELECT
				name, description, country, zip_code, category_id, owner_id, addl_category_id, state
				FROM " . DB_PREFIX . "wanted_ads WHERE wanted_ad_id=" . $wanted_ad_id . " AND owner_id=" . $user_id);

            $relist_id = $this->insert_id();

            $relist_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "wanted_ads WHERE wanted_ad_id=" . $relist_id);

            $this->save_edit_vars($wanted_ad_id, 'wanted_ad');
            $this->update_page_data($relist_id, 'wanted_ad', $relist_details);

            ## relist media

            $sql_select_media = $this->query("SELECT * FROM " . DB_PREFIX . "auction_media WHERE
				wanted_ad_id=" . $wanted_ad_id . " AND upload_in_progress=0 ORDER BY media_id ASC");

            (array)$pictures_array = null;
            (array)$videos_array = null;

            while ($relist_media = $this->fetch_array($sql_select_media)) {
                $this->query("INSERT INTO " . DB_PREFIX . "auction_media (media_url, wanted_ad_id, media_type) VALUES
					('" . $relist_media['media_url'] . "', '" . $relist_id . "', '" . $relist_media['media_type'] . "')");

                if ($relist_media['media_type'] == 1) {
                    $pictures_array[] = $relist_media['media_url'];
                } else if ($relist_media['media_type'] == 2) {
                    $videos_array[] = $relist_media['media_url'];
                }
            }
        } else if ($relist_option == 2) {
            $relist_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "wanted_ads WHERE wanted_ad_id=" . $wanted_ad_id);
            $relist_id = $auction_id;
        }

        $user_details = $this->get_sql_row("SELECT user_id, username, shop_account_id, shop_categories,
			shop_active, preferred_seller, reg_date, country, state, zip_code, balance,
			default_name, default_description, default_duration, default_hidden_bidding,
			default_enable_swap, default_shipping_method, default_shipping_int, default_postage_amount,
			default_insurance_amount, default_type_service, default_shipping_details, default_payment_methods FROM
			" . DB_PREFIX . "users WHERE user_id=" . $relist_details['owner_id']);

        ## calculate quantity
        $auction_end_time = CURRENT_TIME + $duration * 86400;

        $relist_query = "UPDATE " . DB_PREFIX . "wanted_ads SET ";

        (array)$relist_field = NULL;

        $relist_field[] = "start_time = '" . CURRENT_TIME . "'";
        $relist_field[] = "end_time = '" . $auction_end_time . "'";
        $relist_field[] = "duration = '" . $auction_duration . "'";
        $relist_field[] = "closed = '0'";
        $relist_field[] = "nb_bids = '0'";
        $relist_field[] = "nb_clicks = '0'";

        $relist_query .= implode(', ', $relist_field);

        $relist_query .= " WHERE wanted_ad_id='" . $relist_id . "' AND owner_id='" . $user_id . "' ";

        $this->query($relist_query);

        ## PLACEHOLDER - email listing confirmation

        if ($relist_option == 1) {
            $this->delete_wanted_ad($wanted_ad_id, $user_id); ## delete the original wanted ad.
        }

        if ($charge_fees) {
            $wa_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "wanted_ads WHERE wanted_ad_id=" . $relist_id);

            $this->fees = new fees();
            $this->fees->setts = $this->setts;
            $setup_result = $this->fees->wanted_ad_setup($user_details, $wa_details);

            $output['display'] = $setup_result['display'];
        } else {
            $output['display'] = MSG_WA_LISTED_SUCCESS;
        }

        return $output;
    }

    function delete($delete_array, $owner_id = 0, $db_delete = false, $admin_area = false)
    {
        $addl_query = (!$admin_area) ? " AND owner_id='" . $owner_id . "' AND (end_time>'" . $min_time . "' OR closed=1 OR is_draft=1)" : '';

        ## auctions counter - remove process - multiple auctions (delete auctions)
        $sql_select_auctions = $this->query("SELECT auction_id, active, approved, closed, deleted, list_in, category_id, addl_category_id FROM  " . DB_PREFIX . "auctions WHERE
			auction_id IN (" . $delete_array . ") " . $addl_query);

        while ($cnt_details = $this->fetch_array($sql_select_auctions)) {
            if ($cnt_details['active'] == 1 && $cnt_details['approved'] == 1 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0 && $cnt_details['list_in'] != 'store') {
                auction_counter($cnt_details['category_id'], 'remove', $cnt_details['auction_id']);
                auction_counter($cnt_details['addl_category_id'], 'remove', $cnt_details['auction_id']);
            }
        }

        if ($db_delete && $admin_area) ## deletion from database
        {
            ## first we remove the auction media.
            $sql_select_media = $this->query("SELECT * FROM " . DB_PREFIX . "auction_media WHERE
				auction_id IN (" . $delete_array . ")");

            while ($media_details = $this->fetch_array($sql_select_media)) {
                $item_details['auction_id'] = $media_details['auction_id'];

                if ($media_details['media_type'] == 1) {
                    $item_details['ad_image'][0] = $media_details['media_url'];
                } else {
                    $item_details['ad_video'][0] = $media_details['media_url'];
                }

                $this->media_removal($item_details, $media_details['media_type'], 0);
            }

            ## now we remove all the rows from all the related tables.
            $sql_delete_auction = $this->query_silent("DELETE a, ao, b, aw, cfd, p, m FROM " . DB_PREFIX . "auctions AS a
				LEFT JOIN " . DB_PREFIX . "auction_offers AS ao ON ao.auction_id = a.auction_id
				LEFT JOIN " . DB_PREFIX . "auction_watch AS aw ON aw.auction_id = a.auction_id
				LEFT JOIN " . DB_PREFIX . "auction_rollbacks AS ar ON ar.auction_id = a.auction_id
				LEFT JOIN " . DB_PREFIX . "bids AS b ON b.auction_id = a.auction_id
				LEFT JOIN " . DB_PREFIX . "custom_fields_data AS cfd ON cfd.owner_id = a.auction_id AND cfd.page_handle='auction'
				LEFT JOIN " . DB_PREFIX . "proxybid AS p ON p.auction_id = a.auction_id
				LEFT JOIN " . DB_PREFIX . "messaging AS m ON m.auction_id = a.auction_id WHERE
				a.auction_id IN (" . $delete_array . ")");

            if (!$sql_delete_auction) {
                $this->query("DELETE FROM " . DB_PREFIX . "auctions WHERE auction_id IN (" . $delete_array . ")");
                $this->query("DELETE FROM " . DB_PREFIX . "auction_offers WHERE auction_id IN (" . $delete_array . ")");
                $this->query("DELETE FROM " . DB_PREFIX . "auction_watch WHERE auction_id IN (" . $delete_array . ")");
                $this->query("DELETE FROM " . DB_PREFIX . "auction_rollbacks WHERE auction_id IN (" . $delete_array . ")");
                $this->query("DELETE FROM " . DB_PREFIX . "bids WHERE auction_id IN (" . $delete_array . ")");
                $this->query("DELETE FROM " . DB_PREFIX . "custom_fields_data WHERE owner_id IN (" . $delete_array . ") AND page_handle='auction'");
                $this->query("DELETE FROM " . DB_PREFIX . "proxybid WHERE auction_id IN (" . $delete_array . ")");
                $this->query("DELETE FROM " . DB_PREFIX . "messaging WHERE auction_id IN (" . $delete_array . ")");
            }
        } else ## only mark as deleted
        {
            $min_time = $this->min_hours * 60 * 60;

            $this->query("UPDATE " . DB_PREFIX . "auctions SET deleted=1 WHERE
				auction_id IN (" . $delete_array . ") " . $addl_query);
        }
    }

    function rollback_transaction($auction_id, $user_id)
    {
        /**
         * we will first rollback any media uploaded in between
         * then we will rollback the auction, then the invoices, and then the user balance
         */

        $rollback_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "auction_rollbacks WHERE
			auction_id='" . $auction_id . "'");

        if ($rollback_details['nb_images'] > 0) ## delete auction images
        {
            $sql_select_media = $this->query("SELECT * FROM " . DB_PREFIX . "auction_media WHERE
				auction_id='" . $auction_id . "' AND media_type=1 ORDER BY media_id DESC LIMIT 0," . $rollback_details['nb_images']);

            while ($media_details = $this->fetch_array($sql_select_media)) {
                $item_details['auction_id'] = $media_details['auction_id'];

                $item_details['ad_image'][0] = $media_details['media_url'];

                $this->media_removal($item_details, $media_details['media_type'], 0);
            }
        }

        if ($rollback_details['nb_videos'] > 0) ## delete auction videos
        {
            $sql_select_media = $this->query("SELECT * FROM " . DB_PREFIX . "auction_media WHERE
				auction_id='" . $auction_id . "' AND media_type=2 ORDER BY media_id DESC LIMIT 0," . $rollback_details['nb_images']);

            while ($media_details = $this->fetch_array($sql_select_media)) {
                $item_details['auction_id'] = $media_details['auction_id'];

                $item_details['ad_video'][0] = $media_details['media_url'];

                $this->media_removal($item_details, $media_details['media_type'], 0);
            }
        }

        ## auctions counter - add/remove process - single auction (edit auction rollback process)
        $cnt_details = $this->get_sql_row("SELECT auction_id, active, approved, closed, deleted, list_in, category_id, addl_category_id FROM
			" . DB_PREFIX . "auctions WHERE auction_id='" . $item_details['auction_id'] . "'");

        $cnt_operation = ($rollback_details['active'] == 1) ? 'add' : 'remove';
        $cnt_active = ($rollback_details['active'] == 1) ? 0 : 1;

        if ($cnt_details['active'] == $cnt_active && $cnt_details['approved'] == 1 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0 && $cnt_details['list_in'] != 'store') {
            auction_counter($cnt_details['category_id'], $cnt_operation, $cnt_details['auction_id']);
            auction_counter($cnt_details['addl_category_id'], $cnt_operation, $cnt_details['auction_id']);
        }

        $sql_update_auction = $this->query("UPDATE " . DB_PREFIX . "auctions SET
			start_price='" . $rollback_details['start_price'] . "',
			reserve_price='" . $rollback_details['reserve_price'] . "',
			buyout_price='" . $rollback_details['buyout_price'] . "',
			category_id='" . $rollback_details['category_id'] . "',
			active='" . $rollback_details['active'] . "',
			payment_status='" . $rollback_details['payment_status'] . "',
			hpfeat='" . $rollback_details['hpfeat'] . "',
			catfeat='" . $rollback_details['catfeat'] . "',
			bold='" . $rollback_details['bold'] . "',
			hl='" . $rollback_details['hl'] . "',
			addl_category_id='" . $rollback_details['addl_category_id'] . "' WHERE
			auction_id='" . $auction_id . "' AND owner_id='" . $user_id . "'");

        $sql_remove_invoices = $this->query("DELETE FROM " . DB_PREFIX . "invoices WHERE
			item_id='" . $auction_id . "' AND user_id='" . $user_id . "' AND can_rollback=1");

        $sql_update_balance = $this->query("UPDATE " . DB_PREFIX . "users SET balance='" . $rollback_details['balance'] . "' WHERE
			user_id=" . $user_id);
    }

    function currency_drop_down($box_name = 'currency', $selected = null, $form_refresh = null)
    {
        (string)$display_output = null;

        $sql_select_currencies = $this->query("SELECT symbol, caption FROM
			" . DB_PREFIX . "currencies");

        $display_output = '<select name="' . $box_name . '" ' . (($form_refresh) ? 'onChange = "submit_form(' . $form_refresh . ', \'\')"' : '') . '> ';

        while ($currency_details = $this->fetch_array($sql_select_currencies)) {
            $display_output .= '<option value="' . $currency_details['symbol'] . '" ' . (($currency_details['symbol'] == $selected) ? 'selected' : '') . '>' . $currency_details['caption'] . '</option> ';
        }
        $display_output .= '</select> ';

        return $display_output;
    }

    function durations_drop_down($box_name = 'duration', $selected = null, $form_refresh = null)
    {
        (string)$display_output = null;

        $sql_select_durations = $this->query("SELECT days, description FROM
			" . DB_PREFIX . "auction_durations");

        $display_output = '<select name="' . $box_name . '" ' . (($form_refresh) ? 'onChange = "submit_form(' . $form_refresh . ', \'\')"' : '') . '> ';

        while ($duration_details = $this->fetch_array($sql_select_durations)) {
            $display_output .= '<option value="' . $duration_details['days'] . '" ' . (($duration_details['days'] == $selected) ? 'selected' : '') . '>' . $duration_details['description'] . '</option> ';
        }
        $display_output .= '</select> ';

        return $display_output;
    }

    function shipping_methods_drop_down($box_name = 'type_service', $selected = null, $form_refresh = null)
    {
        (string)$display_output = null;

        $sql_select_shipping = $this->query("SELECT id, name FROM
			" . DB_PREFIX . "shipping_options");

        $display_output = '<select name="' . $box_name . '" ' . (($form_refresh) ? 'onChange = "submit_form(' . $form_refresh . ', \'\')"' : '') . '> ';

        while ($shipping_details = $this->fetch_array($sql_select_shipping)) {
            $display_output .= '<option value="' . $shipping_details['name'] . '" ' . (($shipping_details['name'] == $selected) ? 'selected' : '') . '>' . $shipping_details['name'] . '</option> ';
        }
        $display_output .= '</select> ';

        return $display_output;
    }

    function count_contents($variables_array)
    {
        (int)$result = 0;

        if (count($variables_array) > 0) {
            foreach ($variables_array as $value) {
                if ($value) $result++;
            }
        }

        return $result;
    }

    function upload_manager($variables_array, $media_type = 1, $form_name = null, $manager_display = false, $new_table = false, $box_title = true, $display_fee = null)
    {
        (string)$display_output = null;
        /**
         * Media Types:
         * 1 -> image
         * 2 -> video
         *
         * if $no_display = true, then display only hidden fields. Otherwise display the actual download manager
         */

        if (!$manager_display) {
            for ($i = 0; $i < $this->setts['max_images']; $i++) {
                $display_output .= '<input type="hidden" name="ad_image[]" value="' . $variables_array['ad_image'][$i] . '"> ';
            }

            for ($i = 0; $i < $this->setts['max_media']; $i++) {
                $display_output .= '<input type="hidden" name="ad_video[]" value="' . $variables_array['ad_video'][$i] . '"> ';
            }
        } else {
            if ($this->show_free_images) {
                $this->fees = new fees();
                $this->fees->setts = & $this->setts;

                $this->fees->set_fees(null, $variables_array['category_id']);
            }

            if ($media_type == 1) /* image upload manager */ {
                $nb_uploads = $this->count_contents($variables_array['ad_image']);
                $submit_btn_status = ($nb_uploads < $this->setts['max_images']) ? '' : 'disabled';
                $max_media = $this->setts['max_images'];
                $media_name = 'ad_image';

                $msg_upload_box_title = MSG_AD_IMAGES;
                $msg_media = MSG_IMAGES;
                $msg_uploaded_media = MSG_UPLOADED_IMAGES;
                $msg_uploaded_media_expl = MSG_UPLOADED_IMAGES_EXPL;

                if ($this->show_free_images) {
                    $fee_message = ($this->fees->min_charged_image) ? ('<br>' . MSG_FIRST . ' ' . $this->fees->min_charged_image . ' ' . MSG_IMAGES . ' ' . MSG_WILL_BE_FREE) : '';
                }
            } else if ($media_type == 2) /* video upload manager */ {
                $nb_uploads = $this->count_contents($variables_array['ad_video']);
                $submit_btn_status = ($nb_uploads < $this->setts['max_media']) ? '' : 'disabled';
                $max_media = $this->setts['max_media'];
                $media_name = 'ad_video';

                $msg_upload_box_title = MSG_AD_MEDIA;
                $msg_media = MSG_VIDEOS;
                $msg_uploaded_media = MSG_UPLOADED_VIDEOS;
                $msg_uploaded_media_expl = MSG_UPLOADED_VIDEOS_EXPL;

                if ($this->show_free_images) {
                    $fee_message = ($this->fees->min_charged_video) ? ('<br>' . MSG_FIRST . ' ' . $this->fees->min_charged_video . ' ' . MSG_VIDEOS_SIMPLE . ' ' . MSG_WILL_BE_FREE) : '';
                }
            }

            if ($new_table) {
                $display_output = '<table width="100%" border="0" cellpadding="3" cellspacing="2"> ';
            }

            if ($box_title) {
                $display_output .= '<tr class="c4"> ' .
                    '	<td colspan="3" class="c3">' . $msg_upload_box_title . '</td> ' .
                    '</tr> ' .
                    '<tr class="c5"> ' .
                    '	<td><img src="themes/' . $this->setts['default_theme'] . '/img/pixel.gif" width="150" height="1"></td> ' .
                    '	<td colspan="2"><img src="themes/' . $this->setts['default_theme'] . '/img/pixel.gif" width="1" height="1"></td> ' .
                    '</tr> ';
            }

            $display_output .= '<tr class="c1"> ' .
                '	<td align="right" nowrap>' . MSG_UPLOAD_FILE . '</td> ' .
                '	<td><input type="file" name="item_file_upload_' . $media_type . '" style="width: 250px;" /></td> ' .
                '	<td ' . (($this->upload_url) ? 'rowspan="2"' : '') . ' width="100%"><input type="button" name="btn_upload_file" value="' . GMSG_UPLOAD_IMAGE . '" onclick="submit_form(' . $form_name . ', ' . $media_type . ');" ' . $submit_btn_status . ' /></td> ' .
                '</tr> ';

            if ($this->upload_url) {
                $display_output .= '<tr class="c2"> ' .
                    '	<td align="right" nowrap>' . MSG_ENTER_FILE_URL . '</td> ' .
                    '	<td><input type="text" name="item_file_url_' . $media_type . '" style="width: 180px;" /></td> ' .
                    '</tr> ';
            }

            $display_output .= '<tr> ' .
                '	<td class="contentfont" align="right">' . $display_fee . '</td> ' .
                '	<td colspan="2">' . MSG_YOU_CAN_UPL_UP_TO . ' ' . $max_media . ' ' . $msg_media . '. ' . $fee_message . '</td> ' .
                '</tr> ';

            if ($nb_uploads) {
                $display_output .= '<tr> ' .
                    '	<td align="right">&nbsp;</td> ' .
                    '	<td colspan="2" class="border"><strong>' . $msg_uploaded_media . '</strong></td> ' .
                    '</tr> ' .
                    '<tr> ' .
                    '	<td width="150" align="right">&nbsp;</td> ' .
                    '	<td colspan="2" class="c1"> ' .
                    '		<table border="0" cellspacing="0" cellpadding="0"> ' .
                    '			<tr> ';
                for ($i = 0; $i < $nb_uploads; $i++) {
                    $display_output .= '<td style="padding-right: 4px; padding-bottom: 4px;"><table border="0" cellspacing="1" cellpadding="2" class="border c2"> ' .
                        '	<tr> ' .
                        '		<td align="center"> ';

                    if ($media_type == 1) /* image thumbnail */ {
                        $display_output .= '<img src="' . SITE_PATH . 'thumbnail.php?pic=' . $variables_array[$media_name][$i] . '&w=80&sq=Y&b=Y" border="0" alt="' . $variables_array[$media_name][$i] . '"> ';
                    } else if ($media_type == 2) /* video thumbnail */ {
                        $display_output .= '<img src="' . SITE_PATH . 'thumbnail.php?pic=images/media_icon.gif&w=80&sq=Y&b=Y" border="0" alt="' . $variables_array[$media_name][$i] . '"> ';
                    }

                    $display_output .= '</td> ' .
                        '	</tr> ' .
                        '	<tr> ' .
                        '		<td align="center"><table border="0" cellspacing="1" cellpadding="1"> ' .
                        '			<tr> ' .
                        '				<td>' . GMSG_DELETE . '</td> ' .
                        '				<td><input type="checkbox" name="delete_media[]" value="1" onclick="delete_media(' . $form_name . ', ' . $media_type . ', ' . $i . ');" /></td> ' .
                        '			</tr> ' .
                        '		</table></td> ' .
                        '	</tr> ' .
                        '</table></td> ';
                }

                $display_output .= '	</tr> ' .
                    '		</table>' .
                    '	</td> ' .
                    '</tr> ';

                if ($box_title) {
                    $display_output .= '<tr class="reguser"> ' .
                        '	<td>&nbsp;</td> ' .
                        '	<td colspan="2">' . $msg_uploaded_media_expl . '</td> ' .
                        '</tr> ';
                }

            }

            if ($new_table) {
                $display_output .= '</table>';
            }
        }

        return $display_output;
    }

    function media_file_prefix($file_type)
    {
        (string)$output = 'other';

        switch ($file_type) {
            case 1:
                $output = 'img';
                break;
            case 2:
                $output = 'video';
                break;
        }

        return $output;
    }

    function media_upload($variables_array, $file_type, $post_files = null, $create_row = true)
    {
        /**
         * Ok this is how it works: if there is a file upload, then the upload manager (the hidden one) isnt shown,
         * because the hidden fields will be generated here by this form.
         */
        (string)$display_output = null;
        (string)$file_name = null;

        ## if we have a wanted ad img/video upload, we will treat it accordingly
        if ($variables_array['wanted_ad_id']) {
            $this->upload_wa_img = true;
            $upload_item_id = $variables_array['wanted_ad_id'];
        } else {
            $upload_item_id = $variables_array['auction_id'];
        }

        if (!empty($post_files['item_file_upload_' . $file_type]['name'])) /* the file will be uploaded in the below snippet */ {
            $file_upload_prefix = (($this->add_unique) ? $this->media_file_prefix($file_type) . '_' : '') . $variables_array['auction_id'];

            $file_name = $this->upload_file($upload_item_id, $file_type, $post_files['item_file_upload_' . $file_type], $file_upload_prefix, $create_row);
        } else if (!empty($variables_array['item_file_url_' . $file_type])) {
            $file_name = $variables_array['item_file_url_' . $file_type];

            if ($create_row) {
                $this->upload_create_row($upload_item_id, $file_type, $file_name);
            }
        }

        if ($file_type == 1) /* image */ {
            $nb_uploads = $this->count_contents($variables_array['ad_image']);
            $variables_array['ad_image'][$nb_uploads] = $file_name;
        } else if ($file_type == 2) /* video */ {
            $nb_uploads = $this->count_contents($variables_array['ad_video']);
            $variables_array['ad_video'][$nb_uploads] = $file_name;
        }

        for ($i = 0; $i < $this->setts['max_images']; $i++) {
            $display_output .= '<input type="hidden" name="ad_image[]" value="' . $variables_array['ad_image'][$i] . '"> ';
        }
        for ($i = 0; $i < $this->setts['max_media']; $i++) {
            $display_output .= '<input type="hidden" name="ad_video[]" value="' . $variables_array['ad_video'][$i] . '"> ';
        }

        $output = array('post_details' => $variables_array, 'display_output' => $display_output);

        return $output;
    }

    function media_removal($variables_array, $file_type, $file_id, $remove_row = true)
    {
        /**
         * Ok this is how it works: if there is a file removal, then the upload manager (the hidden one) isnt shown,
         * because the hidden fields will be generated here by this form - similar to the file upload function.
         *
         * VERY IMPORTANT: only delete a file if it only appears once on the auction_media table!
         */
        (string)$display_output = null;
        (string)$file_name = null;

        if ($file_type == 1) /* image */ {
            $nb_uploads = $this->count_contents($variables_array['ad_image']);
            $media_name = 'ad_image';

        } else if ($file_type == 2) /* video */ {
            $nb_uploads = $this->count_contents($variables_array['ad_video']);
            $media_name = 'ad_video';
        }

        if ($remove_row) {
            $this->query("DELETE FROM " . DB_PREFIX . "auction_media WHERE
				media_type=" . $file_type . " AND media_url='" . $variables_array[$media_name][$file_id] . "'
				AND (auction_id=0 OR auction_id='" . $variables_array['auction_id'] . "')");
        }

        /**
         * First we unlink the file if possible, and also delete it from the item_media table
         * We only unlink the file if there is no other auction using the same image!
         */

        $is_media = $this->count_rows('auction_media', "WHERE media_url='" . $variables_array[$media_name][$file_id] . "'");

        if (!$is_media) {
            @unlink($this->relative_path . $variables_array[$media_name][$file_id]);
        }

        for ($i = $file_id; $i < $nb_uploads; $i++) {
            $variables_array[$media_name][$i] = $variables_array[$media_name][$i + 1];
        }

        $variables_array[$media_name][$nb_uploads] = null;

        for ($i = 0; $i < $this->setts['max_images']; $i++) {
            $display_output .= '<input type="hidden" name="ad_image[]" value="' . $variables_array['ad_image'][$i] . '"> ';
        }
        for ($i = 0; $i < $this->setts['max_media']; $i++) {
            $display_output .= '<input type="hidden" name="ad_video[]" value="' . $variables_array['ad_video'][$i] . '"> ';
        }

        $output = array('post_details' => $variables_array, 'display_output' => $display_output);

        return $output;

    }

    function upload_create_row($item_id, $media_type, $media_url)
    {
        $auction_id = ($this->upload_wa_img) ? 0 : $item_id;
        $wanted_ad_id = ($this->upload_wa_img) ? $item_id : 0;
        $upload_in_progress = ($this->edit_auction) ? 1 : 0;

        ## now we also save the media in the table
        $this->query("INSERT INTO " . DB_PREFIX . "auction_media
			(auction_id, media_type, media_url, upload_in_progress, wanted_ad_id) VALUES
			('" . $auction_id . "', " . $media_type . ", '" . $media_url . "', '" . $upload_in_progress . "', '" . $wanted_ad_id . "')");
    }

    function upload_file($item_id, $media_type, $file_details, $file_prefix, $create_row = true)
    {
        (string)$result = null;

        $uniq_id = md5(uniqid(rand(), true));

        $file_extension = $this->file_extension($file_details['name']);

        $file_name = $file_prefix . (($this->add_unique) ? '_' . $uniq_id : '') . '.' . (($this->extension) ? $this->extension : $file_extension);

        $max_size = ($media_type == 1) ? ($this->setts['images_max_size'] * 1024) : ($this->setts['media_max_size'] * 1024);

        if ($file_details['size'] <= $max_size) {
            $is_upload = @copy($file_details['tmp_name'], $this->relative_path . $this->image_basedir . $file_name);
        } else {
            print '<script type="text/javascript">';
            print 'alert("' . GMSG_ERROR_YOUR_FILE_HAS . ': ' . number_format($file_details['size'] / 1024, 2) . GMSG_KB . '. ' . GMSG_MAX_SIZE_ALLOWED . ': ' . ($max_size / 1024) . GMSG_KB . '")';
            print '</script>';

            /* issue: the alert is shown twice! */
        }

        if ($is_upload) {
            $result = $this->image_basedir . $file_name;

            ## Image Resize Mod and Watermarker ##
            if ($media_type == 1 && IN_ADMIN != 1) {
                $resized_image = new image();

                $wtext = $this->setts['watermark_text'];

                $rsize = $this->setts['watermark_size'];
                $rsize = ($rsize < 50) ? 50 : $rsize;

                $wpos = $this->setts['watermark_pos'];

                $resized_image->generate_thumb($result, $rsize, false, false, $result, true, $wtext, $wpos);
            }

            if ($create_row) {
                $this->upload_create_row($item_id, $media_type, $result);
            }
        }

        return $result;
    }

    function file_extension($input_file)
    {
        $file_array = explode('.', $input_file);

        $nb_array = count($file_array);
        $ext_cnt = $nb_array - 1;

        $extension = ($nb_array <= 1) ? '' : $file_array[$ext_cnt];
        $extension = strtolower($extension);

        $extensions_array = array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'avi', 'mpg', 'mpeg', 'mov');
        $extension = (!in_array($extension, $extensions_array)) ? 'img' : $extension;

        return $extension;
    }

    function select_direct_payment($selected_values, $user_id, $show_only = false, $text_only = false)
    {
        (array)$output = null;

        if ($show_only) {
            $additional_query = ' AND pg_id IN (' . $selected_values . ')';
        }

        $sql_select_gateways = $this->query("SELECT pg_id, name, logo_url FROM " . DB_PREFIX . "payment_gateways WHERE checked=1" . $additional_query);

        $selected_value = explode(',', $selected_values);

        while ($payment_gateway = $this->fetch_array($sql_select_gateways)) {
            if ($text_only) {
                $output[] = $payment_gateway['name'];
            } else {
                (string)$field_output = null;
                $logo_url = SITE_PATH . (($payment_gateway['logo_url']) ? $payment_gateway['logo_url'] : 'images/noimg.gif');

                $field_output = "<table cellpadding='0' cellspacing='0' border='0'> " .
                    '	<tr> ';

                $field_output .= '<td><img src="' . $logo_url . '" border="0" alt="' . $payment_gateway['name'] . '"></td> ' .
                    '	</tr> ' .
                    '	<tr> ' .
                    '		<td>';

                if (!$show_only) {
                    //$user_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE user_id=" . intval($user_id));

                    (string)$checkbox_status = null;

                    switch ($payment_gateway['name']) {
                        case 'PayPal':
                            $checkbox_status = ($this->setts['pg_paypal_email']) ? '' : 'disabled';
                            break;
                        case 'Worldpay':
                            $checkbox_status = ($this->setts['pg_worldpay_id']) ? '' : 'disabled';
                            break;
                        case '2Checkout':
                            $checkbox_status = ($this->setts['pg_checkout_id']) ? '' : 'disabled';
                            break;
                        case 'Nochex':
                            $checkbox_status = ($this->setts['pg_nochex_email']) ? '' : 'disabled';
                            break;
                        case 'Ikobo':
                            $checkbox_status = ($this->setts['pg_ikobo_username'] && $user_details['pg_ikobo_password']) ? '' : 'disabled';
                            break;
                        case 'nganluong':
                            $checkbox_status = ($this->setts['pg_nganluong_email'] && $this->setts['pg_nganluong_username'] && $this->setts['pg_nganluong_password']) ? '' : 'disabled';
                            break;
                        case 'Protx':
                            $checkbox_status = ($this->setts['pg_protx_username'] && $user_details['pg_protx_password']) ? '' : 'disabled';
                            break;
                        case 'Authorize.net':
                            $checkbox_status = ($this->setts['pg_authnet_username'] && $user_details['pg_authnet_password']) ? '' : 'disabled';
                            break;
                        case 'Moneybookers':
                            $checkbox_status = ($this->setts['pg_mb_email']) ? '' : 'disabled';
                            break;
                        case 'Paymate':
                            $checkbox_status = ($this->setts['pg_paymate_merchant_id']) ? '' : 'disabled';
                            break;
                        case 'Google Checkout':
                            $checkbox_status = ($this->setts['pg_gc_merchant_id'] && $user_details['pg_gc_merchant_key']) ? '' : 'disabled';
                            break;
                    }

                    $gateway_name = strtolower($payment_gateway['name']);

                    $field_output .= "<input id='{$gateway_name}' type='checkbox' name='payment_gateway[]' value='" . $payment_gateway["pg_id"] . "' " . ((in_array($payment_gateway["pg_id"], $selected_value)) ? "checked" : "") . " " . $checkbox_status . "> ";
                }

                $field_output .= $payment_gateway['name'] . '</td> ' .
                    '	</tr> ' .
                    '</table>';

                $output[] = $field_output;
            }
        }

        return $output;
    }

    function select_offline_payment($selected_values, $show_only = false, $text_only = false)
    {
        (array)$output = null;

        if ($show_only) {
            $additional_query = ' WHERE id IN (' . $selected_values . ')';
        }

        $sql_select_options = $this->query_silent("SELECT id, name, logo_url FROM " . DB_PREFIX . "payment_options " . $additional_query);

        $selected_value = explode(',', $selected_values);

        if ($sql_select_options) {
            while ($payment_option = $this->fetch_array($sql_select_options)) {
                if ($text_only) {
                    $output[] = $payment_option['name'];
                } else {
                    (string)$field_output = null;
                    //$logo_url = SITE_PATH . (($payment_option['logo_url']) ? $payment_option['logo_url'] : 'images/noimg.gif'); - old
                    $logo_url = (($payment_option['logo_url']) ? $payment_option['logo_url'] : 'images/noimg.gif');

                    $field_output = '<table cellpadding="0" cellspacing="0" border="0"> ' .
                        '	<tr> ';

                    $field_output .= '<td><img src="' . SITE_PATH . 'thumbnail.php?pic=' . $logo_url . '&w=80&sq=Y&b=Y" border="0" alt="' . $payment_option['name'] . '"></td> ' .
                        '	</tr> ' .
                        '	<tr> ' .
                        '		<td>';

                    if (!$show_only) {
                        $field_output .= '<input type="checkbox" name="payment_option[]" value="' . $payment_option['id'] . '" ' . ((in_array($payment_option['id'], $selected_value)) ? 'checked' : '') . '> ';
                    }

                    $field_output .= $payment_option['name'] . '</td> ' .
                        '	</tr> ' .
                        '</table>';

                    $output[] = $field_output;
                }
            }
        }

        return $output;
    }

    function set_quantity($value)
    {
        $value = intval($value);
        $value = ($value < 1) ? 1 : $value;

        return $value;
    }

    function item_status($value)
    {
        (string)$display_output = null;

        $display_output = ($value) ? '<font color="red">' . GMSG_CLOSED . '<font>' : '<font color="green"> ' . GMSG_OPEN . '</font>'; // checks for closed=1!!

        return '<strong>' . $display_output . '</strong>';
    }

    function item_media_thumbnails($variables_array, $file_type, $enable_links = true)
    {
        (string)$display_output = null;

        if ($file_type == 1) /* image */ {
            $nb_uploads = $this->count_contents($variables_array['ad_image']);
            $media_name = 'ad_image';
        } else if ($file_type == 2) /* video */ {
            $nb_uploads = $this->count_contents($variables_array['ad_video']);
            $media_name = 'ad_video';
        }


        if ($nb_uploads > 0) {
            $display_output = '<div class="list_product_thumbnails"> ';

            foreach ($variables_array[$media_name] as $value) {
                if (!empty($value)) {
                    if ($file_type == 1) {

                        $display_output .= ($enable_links) ? '<a href="javascript:doPic(\'thumbnail.php?pic=' . $value . '&w=500&sq=Y&b=Y\');"> ' : '';
                        $display_output .= '<img src="thumbnail.php?pic=' . $value . '&w=100&sq=Y&b=Y" border="0">';
                        $display_output .= ($enable_links) ? '</a>' : '';

                    }

                }
            }


            $display_output .= '</div> ';
        }

        return $display_output;
    }

    function full_size_images($variables_array)
    {
        (string)$display_output = null;
        $main_link = false;

        $nb_images = count($variables_array['ad_image']);

        if ($nb_images > 0) {
            foreach ($variables_array['ad_image'] as $value) {
                if (!empty($value)) {
                    $link_text = null;
                    if (!$main_link) {
                        $link_text = GMSG_VIEW_FULL_SIZE_IMAGES;
                        $main_link = true;
                    }

                    $display_output .= '<a href="' . $value . '" rel="lightbox[item_images]">' . $link_text . '</a>';
                }
            }
        }

        return $display_output;
    }

    function video_box($file_name)
    {
        (string)$display_output = null;

        $pattern = '/\.(?i)php/';

        $file_name = (preg_match($pattern, $file_name)) ? 'images/broken.gif' : $file_name;

        $video_name = explode('.', $file_name);
        $video_file_cnt = count($video_name) - 1;
        $video_extension = $video_name[$video_file_cnt];

        if (trim($video_extension) == 'mov') {
            ## run quicktime
            $display_output = '<OBJECT id="QTPlay"	CLASSID="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B"
						CODEBASE="http://www.apple.com/qtactivex/qtplugin.cab" align="baseline" border="0"
						standby="Loading Video Player components..."	type="image/x-quicktime" WIDTH="480" HEIGHT="360" >
		        	<PARAM NAME="src" VALUE="http://movies.apple.com/movies/qt_posters/qtstart5a_480x228.mov">
					<PARAM NAME="controller" VALUE="false">
		        	<PARAM NAME="target" VALUE="myself">
			      <PARAM NAME="href" VALUE="' . $file_name . '">
			      <PARAM NAME="pluginspage" VALUE="http://www.apple.com/quicktime/download/">
				</OBJECT> ';
        } else {
            ## run windows media player
            $display_output = '<object data="' . $file_name . '" type="video/x-ms-wmv" width="320" height="320">
		       	<param name="src" value="' . $file_name . '">
		  			<param name="ShowControls" value="1">
					<param name="ShowPositionControls" value="0">
					<param name="ShowAudioControls" value="1">
					<param name="ShowTracker" value="1">
					<param name="ShowDisplay" value="0">
					<param name="ShowStatusBar" value="1">
					<param name="AutoSize" value="0">
					<param name="ShowGotoBar" value="0">
					<param name="ShowCaptioning" value="0">
					<param name="AutoStart" value="0">
					<param name="AnimationAtStart" value="false">
					<param name="TransparentAtStart" value="false">
					<param name="AllowScan" value="1">
					<param name="EnableContextMenu" value="1">
					<param name="ClickToPlay" value="0">
					<param name="InvokeURLs" value="1">
					<param name="DefaultFrame" value="datawindow">
		      </object>';
        }

        return $display_output;

    }

    function item_location($item_details)
    {
        (string)$display_output = null;

        $state_name = $item_details['state'];

        if ($item_details['state'] > 0) {
            $state_name = $this->get_sql_field("SELECT name FROM " . DB_PREFIX . "countries WHERE
				id='" . $item_details['state'] . "'", 'name', '-');
        }

        $display_output = (!empty($state_name)) ? $item_details['zip_code'] . ', ' . $state_name : $item_details['zip_code'];

        return $display_output;
    }

    function buyout_only($item_details)
    {
        $output = ($item_details['buyout_price'] == $item_details['start_price']) ? true : false;

        return $output;
    }

    function auction_media_fields($auction_id, $relist_id)
    {
        (array)$result = null;

        $sql_select_media = $this->query("SELECT media_url, media_type FROM " . DB_PREFIX . "auction_media WHERE
			auction_id='" . intval($auction_id) . "' ORDER BY media_id ASC");

        $counter_image = 0;
        $counter_video = 0;

        while ($media_details = $this->fetch_array($sql_select_media)) {
            switch ($media_details['media_type']) {
                case 1: ## image
                    $result['ad_image'][$counter_image++] = $media_details['media_url'];
                    break;
                case 2: ## video
                    $result['ad_video'][$counter_image++] = $media_details['media_url'];
                    break;
            }
            ## now add the row in the auction_media table
            $sql_insert_media = $this->query("INSERT INTO " . DB_PREFIX . "auction_media
					(auction_id, media_type, media_url) VALUES
					(" . $relist_id . ", " . $media_details['media_type'] . ", '" . $media_details['media_url'] . "')");
        }

        return $result;
    }

    function edit_set_checkboxes($item_details)
    {
        $item_details['is_reserve'] = ($item_details['reserve_price'] > 0) ? 1 : 0;
        $item_details['is_bid_increment'] = ($item_details['bid_increment_amount'] > 0) ? 1 : 0;
        $item_details['is_buy_out'] = ($item_details['buyout_price'] > 0) ? 1 : 0;
        $item_details['is_auto_relist'] = ($item_details['auto_relist_nb'] > 0) ? 1 : 0;

        return $item_details;
    }

    function get_media_values($auction_id, $wanted_ad = false)
    {
        $output = array('auction_id' => $auction_id, 'ad_image' => null, 'ad_video' => null);
        (int)$counter_image = 0;
        (int)$counter_video = 0;

        $field_type = ($wanted_ad) ? 'wanted_ad_id' : 'auction_id';

        $sql_select_media = $this->query("SELECT media_url, media_type FROM " . DB_PREFIX . "auction_media WHERE
			" . $field_type . "=" . intval($auction_id) . " AND upload_in_progress=0 ORDER BY media_id ASC");

        while ($media_details = $this->fetch_array($sql_select_media)) {
            if ($media_details['media_type'] == 1) // image
            {
                $output['ad_image'][$counter_image++] = $media_details['media_url'];
            } else if ($media_details['media_type'] == 2) // video
            {
                $output['ad_video'][$counter_video++] = $media_details['media_url'];
            }
        }

        return $output;
    }

    function listed_in($item_details)
    {
        (string)$display_output = null;

        if ($item_details['shop_active']) {
            $display_output = '[ ' . MSG_ITEM_LISTED_IN . ' ' . $item_details['list_in'] . ' ]';
        }

        return $display_output;
    }

    function relisted_tick($is_relisted)
    {
        return ($is_relisted) ? '<img src="themes/' . $this->setts['default_theme'] . '/img/system/relisted.gif" border="0" align="absmiddle" alt="' . GMSG_RELISTED_AUCTION . '"> ' : '';
    }

    function new_message_tick($is_message)
    {
        $messaging_link = process_link('members_area', array('page' => 'messaging', 'section' => 'received'));

        return ($is_message) ? '<a href="' . $messaging_link . '"><img src="themes/' . $this->setts['default_theme'] . '/img/system/unread_mess.gif" border="0" align="absmiddle" alt="' . GMSG_UNREAD_MESSAGE . '"></a> ' : '';
    }


    function under_time($item_details)
    {
        $time_left = $item_details['end_time'] - ($this->min_hours * 60 * 60);

        return ($time_left > CURRENT_TIME) ? false : true;
    }

    function can_close_manually($item_details, $user_id)
    {
        $time_left = $item_details['end_time'] - ($this->min_hours_close * 60 * 60);

        return ($time_left > CURRENT_TIME && $item_details['active'] == 1 && $item_details['approved'] == 1 &&
            $item_details['payment_status'] == 'confirmed' && $item_details['closed'] == 0 &&
            $item_details['owner_id'] == $user_id &&
            ($item_details['nb_bids'] <= 0 || $item_details['max_bid'] < $item_details['reserve_price'])) ? true : false;
    }

    function update_prefilled($prefilled_fields, $user_id)
    {
        $prefilled_fields['default_payment_methods'] = $this->implode_array($prefilled_fields['payment_option']);
        $prefilled_fields['default_direct_payment'] = $this->implode_array($prefilled_fields['payment_gateway']);

        $prefilled_fields = $this->rem_special_chars_array($prefilled_fields);

        $sql_update_prefilled = $this->query("UPDATE " . DB_PREFIX . "users SET
			default_name='" . $prefilled_fields['default_name'] . "',
			default_description='" . $prefilled_fields['description_main'] . "',
			default_currency='" . $prefilled_fields['currency'] . "', 
			default_duration='" . $prefilled_fields['duration'] . "',
			default_hidden_bidding='" . $prefilled_fields['default_hidden_bidding'] . "',
			default_payment_methods='" . $prefilled_fields['default_payment_methods'] . "',
			default_direct_payment='" . $prefilled_fields['default_direct_payment'] . "',
			default_enable_swap='" . $prefilled_fields['default_enable_swap'] . "',
			default_shipping_method='" . $prefilled_fields['default_shipping_method'] . "',
			default_shipping_int='" . $prefilled_fields['default_shipping_int'] . "',
			default_postage_amount='" . $prefilled_fields['default_postage_amount'] . "',
			default_insurance_amount='" . $prefilled_fields['default_insurance_amount'] . "',
			default_type_service='" . $prefilled_fields['default_type_service'] . "',
			default_shipping_details='" . $prefilled_fields['default_shipping_details'] . "',
			default_public_questions='" . $prefilled_fields['default_public_questions'] . "',
			default_bid_placed_email='" . $prefilled_fields['default_bid_placed_email'] . "'
			WHERE user_id='" . $user_id . "'");
    }

    function update_mailprefs($mail_prefs, $user_id)
    {
        $mail_prefs = $this->rem_special_chars_array($mail_prefs);

        $sql_update_mailprefs = $this->query("UPDATE " . DB_PREFIX . "users SET
			mail_messaging_sent='" . $mail_prefs['mail_messaging_sent'] . "',
			mail_messaging_received='" . $mail_prefs['mail_messaging_received'] . "',
			mail_item_sold='" . $mail_prefs['mail_item_sold'] . "',
			mail_item_won='" . $mail_prefs['mail_item_won'] . "',
			default_bid_placed_email='" . $mail_prefs['default_bid_placed_email'] . "',
			mail_outbid='" . $mail_prefs['mail_outbid'] . "',
			mail_confirm_to_seller='" . $mail_prefs['mail_confirm_to_seller'] . "',
			mail_item_closed='" . $mail_prefs['mail_item_closed'] . "' 
			WHERE user_id='" . $user_id . "'");
    }

    ## bidding related functions below
    function can_bid($user_id, $item_details, $max_bid = 0, $minimum_bid = 0)
    {
        $output = array('result' => false, 'display' => null, 'show_box' => false);

        if (!$user_id) {
            $output['display'] = '<p align="center" class="contentfont" style="color: red; font-weight: bold;">' . MSG_CANTBID_LOGIN . '</p>' .
                '<div align="center" class="contentfont"><a href="login.php?redirect=auction_details.php?auction_id=' . $item_details['auction_id'] . '">' . MSG_LOGIN_TO_MEMBERS_AREA . '</a></div>';

        } else if ($item_details['start_price'] == $item_details['buyout_price']) {
            $output['display'] = MSG_CANTBID_BUYOUT_ONLY;
        } else if ($item_details['closed'] == 1 || $item_details['end_time'] < CURRENT_TIME) {
            $output['display'] = MSG_CANTBID_BIDDING_CLOSED;
        } else if ($item_details['deleted'] == 1) {
            $output['display'] = MSG_NO_MORE_BIDDING;
        } else if ($minimum_bid > 0 && $max_bid < $minimum_bid) {
            $output['display'] = MSG_MAXBID_SMALLER_THAN_MINBID;
        } else if ($user_id == $item_details['owner_id']) {
            $output['show_box'] = true;
            $output['display'] = MSG_CANTBID_USER_OWNER;
        } else {
            $output['show_box'] = true;
            $output['result'] = true;
        }

        return $output;
    }

    function min_bid_amount($item_details)
    {
        $output = 0;

        if ($item_details['max_bid'] > 0) {
            if ($item_details['bid_increment_amount'] > 0) {
                $output = $item_details['max_bid'] + $item_details['bid_increment_amount'];
            } else {
                $increment_value = $this->get_sql_field("SELECT increment FROM " . DB_PREFIX . "bid_increments WHERE
					value_from<=" . $item_details['max_bid'] . " AND value_to>" . $item_details['max_bid'], 'increment', 0);

                $output = $item_details['max_bid'] + $increment_value;
            }

            if ($item_details['auction_type'] == 'dutch') {
                $bid_quantity = $this->get_sql_field("SELECT SUM(quantity) AS bid_quantity FROM " . DB_PREFIX . "bids WHERE
					bid_amount='" . $item_details['max_bid'] . "' AND auction_id='" . $item_details['auction_id'] . "'", 'bid_quantity');

                $output = ($bid_quantity < $item_details['quantity']) ? $item_details['max_bid'] : $output;
            }
        } else {
            $output = $item_details['start_price'];
        }

        return $output;
    }

    function bid_update_proxy($bid_amount, $item_details, $proxy_details)
    {
        $output = false;

        if ($bid_amount >= $proxy_details['bid_amount']) {
            $sql_update_proxy = $this->query("UPDATE " . DB_PREFIX . "proxybid SET
				bid_amount='" . $bid_amount . "' WHERE proxy_id=" . $proxy_details['proxy_id']);

            $sql_update_bid = $this->query("UPDATE " . DB_PREFIX . "bids SET bid_proxy='" . $bid_amount . "' WHERE
				bid_out=0 AND bid_invalid=0 AND auction_id='" . $item_details['auction_id'] . "' AND
				bidder_id=" . $proxy_details['bidder_id']);

            $output = true;
        }

        if ($item_details['reserve_price'] > 0 && $item_details['max_bid'] < $item_details['reserve_price']) {
            $current_high_bid = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "bids WHERE
				auction_id=" . $item_details['auction_id'] . " AND bid_out=0 AND bid_invalid=0");

            $sql_invalidate_bids = $this->query("UPDATE " . DB_PREFIX . "bids SET bid_out=1, bid_invalid=1 WHERE
				auction_id='" . $item_details['auction_id'] . "' AND bidder_id=" . $proxy_details['bidder_id']);
            $this->place_bid($bid_amount, $current_high_bid['quantity'], $proxy_details['bidder_id'], $item_details, true);
        }

        return $output;
    }

    function place_bid($bid_amount, $quantity, $bidder_id, $item_details, $proxy_bid = false, $outbid = false)
    {
        $output = array('bid_id' => 0, 'display' => null, 'bid_amount' => 0);

        ## calculate the bid that will be placed
        if ($item_details['auction_type'] == 'standard') {
            $min_bid = ($item_details['max_bid'] == 0) ? $item_details['start_price'] : $this->min_bid_amount($item_details);

            if ($proxy_bid) {
                $min_bid = ($min_bid > $bid_amount) ? $bid_amount : $min_bid;
            } else if ($outbid) ## this wont be a high bid so we will always place the maximum bid
            {
                $min_bid = $bid_amount;
            }

            if ($item_details['reserve_price']) {
                if ($bid_amount < $item_details['reserve_price']) {
                    $min_bid = $bid_amount; // basically proxy will be overridden in this case
                    $output['display'] = MSG_BID_UNDER_RESERVE;
                } else {
                    $min_bid = ($min_bid > $item_details['reserve_price']) ? $min_bid : $item_details['reserve_price'];
                }
            }
        } else {
            $bid_quantity = $this->get_sql_field("SELECT SUM(quantity) AS bid_quantity FROM " . DB_PREFIX . "bids WHERE
				bid_amount='" . $item_details['max_bid'] . "' AND auction_id='" . $item_details['auction_id'] . "'", 'bid_quantity');

            if ($item_details['max_bid'] == 0) {
                $min_bid = $item_details['start_price'];
            } else if ($bid_quantity < $item_details['quantity']) {
                $min_bid = $item_details['max_bid'];
            } else {
                $min_bid = $this->min_bid_amount($item_details);
            }
        }

        if ($this->override_min_bid) {
            $min_bid = $bid_amount;
        }

        $output['bid_amount'] = $min_bid;

        $quantity = ($item_details['auction_type'] == 'standard') ? 1 : $quantity;
        $proxy_amount = ($item_details['bid_proxy'] > $bid_amount) ? $item_details['bid_proxy'] : $bid_amount;

        $sql_insert_bid = $this->query("INSERT INTO " . DB_PREFIX . "bids
			(auction_id,bidder_id, bid_amount, bid_date, quantity, bid_proxy) VALUES
			('" . $item_details['auction_id'] . "', '" . $bidder_id . "', '" . $min_bid . "', '" . CURRENT_TIME . "',
			'" . $quantity . "', '" . $proxy_amount . "')");

        $output['bid_id'] = $this->insert_id();

        $high_bid = false;
        ## now insert or update the proxy if the case
        if (!$item_details['nb_bids']) {
            $high_bid = true;

            $sql_insert_proxybid = $this->query("INSERT INTO " . DB_PREFIX . "proxybid
				(auction_id, bidder_id, bid_amount) VALUES
				('" . $item_details['auction_id'] . "', '" . $bidder_id . "', '" . $proxy_amount . "')");
        } else {
            $current_proxybid = $this->get_sql_field("SELECT bid_amount FROM " . DB_PREFIX . "proxybid WHERE
				auction_id=" . $item_details['auction_id'], 'bid_amount');

            if (($proxy_amount > $current_proxybid && $item_details['auction_type'] == 'standard') || ($proxy_amount >= $current_proxybid && $item_details['auction_type'] == 'dutch') || $proxy_bid) {
                $high_bid = true;

                $sql_update_proxybid = $this->query("UPDATE " . DB_PREFIX . "proxybid SET
					bidder_id='" . $bidder_id . "', bid_amount='" . $proxy_amount . "' WHERE auction_id=" . $item_details['auction_id']);
            }
        }

        if ($high_bid) {
            $addl_query = ', max_bid=' . $min_bid;
        }

        (string)$sniping_query = null;
        ## bid sniping code snippet
        if ($this->setts['enable_sniping_feature']) {
            $time_left = $item_details['end_time'] - CURRENT_TIME;

            if (($this->setts['sniping_duration'] * 60) > $time_left) {
                $end_time = $item_details['end_time'] + ($this->setts['sniping_duration'] * 60 - $time_left);
                $sniping_query = ', end_time=' . $end_time;
            }
        }

        $sql_update_auction = $this->query("UPDATE " . DB_PREFIX . "auctions SET
			nb_bids=nb_bids+1" . $addl_query . $sniping_query . " WHERE auction_id='" . $item_details['auction_id'] . "'");

        return $output;
    }

    /**
     * the following conditions need to be met in order for this function to be called:
     * - $bid_amount >= minimum allowed bid
     * - all can_bid conditions are met
     * - this is not a proxy bid update (so the bidder and the proxy user are different)
     */
    function bid($bid_amount, $quantity, $bidder_id, $item_details, $proxy_details)
    {
        $output = array('result' => false, 'display' => null);

        if ($item_details['auction_type'] == 'standard') {
            if (!$item_details['nb_bids']) ## this will be the first bid
            {
                ## first we check if we need to alter the auction's duration (enable_duration_change setting) [ v6.00 addition ]
                if ($this->setts['enable_duration_change'] && $this->setts['duration_change_days']) {
                    $time_left = $item_details['end_time'] - CURRENT_TIME;
                    $duration_change = $this->setts['duration_change_days'] * 24 * 60 * 60;

                    if ($time_left > $duration_change) {
                        $end_time = CURRENT_TIME + $duration_change;
                        $this->query("UPDATE " . DB_PREFIX . "auctions SET end_time='" . $end_time . "' WHERE
							auction_id='" . $item_details['auction_id'] . "'");
                    }
                }

                $bid_output = $this->place_bid($bid_amount, $quantity, $bidder_id, $item_details);

                $output['result'] = true;
                $output['display'] = $bid_output['display'];
            } else {
                $current_high_bid = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "bids WHERE
					auction_id=" . $item_details['auction_id'] . " AND bid_out=0 AND bid_invalid=0");

                if ($proxy_details['bid_amount'] >= $bid_amount) ## place the user's maximum bid and then place the proxy minimum bid
                {
                    ## we invalidate all bids from the current user and the proxy user
                    $sql_invalidate_bids = $this->query("UPDATE " . DB_PREFIX . "bids SET bid_invalid=1 WHERE
						auction_id='" . $item_details['auction_id'] . "' AND
						bidder_id IN (" . $bidder_id . ", " . $proxy_details['bidder_id'] . ")");
                    ## we place the user's bid
                    $bid_result = $this->place_bid($bid_amount, $quantity, $bidder_id, $item_details, false, true);
                    $item_details['max_bid'] = $bid_result['bid_amount'];

                    ## we out all bids
                    $sql_out_bids = $this->query("UPDATE " . DB_PREFIX . "bids SET bid_out=1 WHERE
						auction_id='" . $item_details['auction_id'] . "'");
                    ## we place the proxy bid (which will be the new high bid)
                    $bid_output = $this->place_bid($proxy_details['bid_amount'], $current_high_bid['quantity'], $proxy_details['bidder_id'], $item_details, true);

                    $output['result'] = false;
                    $output['display'] = MSG_BID_UNDER_PROXY;
                } else ## place the proxy maximum bid and then place the user's minimum bid
                {
                    ## invalidate all bids for which the current bid is smaller than the proxy bid.
                    $this->query("UPDATE " . DB_PREFIX . "bids SET bid_invalid=1 WHERE
						auction_id='" . $item_details['auction_id'] . "' AND
						bid_amount<bid_proxy");
                    ## we invalidate all bids from the current user	and the proxy bid except for the current high bid
                    $sql_invalidate_bids = $this->query("UPDATE " . DB_PREFIX . "bids SET bid_invalid=1 WHERE
						auction_id='" . $item_details['auction_id'] . "' AND
						bidder_id IN (" . $bidder_id . ")");

                    ## we place the proxy bid - but only if the proxy amount >= bid placed
                    $last_bid_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "bids WHERE
						auction_id='" . $item_details['auction_id'] . "' AND
						bidder_id=" . $proxy_details['bidder_id'] . " ORDER BY bid_amount DESC LIMIT 1");

                    if ($last_bid_details['bid_amount'] < $proxy_details['bid_amount']) {
                        $bid_result = $this->place_bid($proxy_details['bid_amount'], $current_high_bid['quantity'], $proxy_details['bidder_id'], $item_details, false, true);
                        $item_details['max_bid'] = $bid_result['bid_amount'];
                    }

                    ## we out all bids
                    $sql_out_bids = $this->query("UPDATE " . DB_PREFIX . "bids SET bid_out=1 WHERE
						auction_id='" . $item_details['auction_id'] . "'");
                    ## we place the user's bid (which will be the new high bid)
                    $bid_output = $this->place_bid($bid_amount, $quantity, $bidder_id, $item_details, true);


                    $output['result'] = true;
                    $output['display'] = $bid_output['display'];
                }
            }
        } else if ($item_details['auction_type'] == 'dutch') {
            if ($quantity <= $item_details['quantity']) {
                if (!$item_details['nb_bids']) ## this will be the first bid
                {
                    $bid_output = $this->place_bid($bid_amount, $quantity, $bidder_id, $item_details);

                    $output['result'] = true;
                    $output['display'] = $bid_output['display'];
                } else {
                    (int)$counter = 0;
                    $bid_details = array();

                    $output['result'] = true;

                    $total_quantity = $this->get_sql_field("SELECT SUM(quantity) AS bid_quantity FROM " . DB_PREFIX . "bids WHERE
						bid_out=0 AND bid_invalid=0 AND auction_id='" . $item_details['auction_id'] . "'", 'bid_quantity');

                    $quantity_left = $item_details['quantity'] - $total_quantity;

                    /**
                     * new procedure:
                     * - if there is no quantity left, then place the proxies from all active bids and the new bid in an
                     * ascending order, and then out the smaller bids. Then decrease the bid amounts of the active bids
                     * to be equal with the amount of the highest inactive bid.
                     */

                    if ($quantity > $quantity_left) {
                        ## we select all active bids which dont have the proxy = bid_amount
                        $sql_select_bids = $this->query("SELECT bidder_id, bid_proxy, quantity FROM " . DB_PREFIX . "bids WHERE
							auction_id='" . $item_details['auction_id'] . "' AND bid_out='0' AND bid_invalid='0' AND
							bid_proxy>bid_amount ORDER BY bid_proxy ASC");

                        if ($this->num_rows($sql_select_bids)) {
                            $sql_mark_out = $this->query("UPDATE " . DB_PREFIX . "bids SET bid_out=1 WHERE
								auction_id='" . $item_details['auction_id'] . "' AND bid_out=0 AND bid_invalid=0");
                        }

                        $counter = 0;
                        while ($bid_row = $this->fetch_array($sql_select_bids)) {
                            $bid_details[$counter] = $bid_row;
                            $bid_details[$counter]['active_bid'] = 0;
                            $counter++;
                        }

                        $bid_details[$counter]['bidder_id'] = $bidder_id;
                        $bid_details[$counter]['quantity'] = $quantity;
                        $bid_details[$counter]['bid_proxy'] = $bid_amount;
                        $bid_details[$counter]['active_bid'] = 1;

                        ## now lets order the array by bid_proxy asc
                        $sort['direction'] = 'SORT_ASC';
                        $sort['field'] = 'bid_proxy';

                        $sort_arr = array();

                        foreach ($bid_details AS $uniqid => $row) {
                            foreach ($row AS $key => $value) {
                                $sort_arr[$key][$uniqid] = $value;
                            }
                        }

                        array_multisort($sort_arr[$sort['field']], constant($sort['direction']), $bid_details);
                        ## end of sorting by bid_proxy ASC

                        /*
                        print '<b>After sorting</b>: <br> <pre>';
                        print_r($bid_details);
                        print '</pre>';
                        */

                        ## now we place all these bids, then we out all, and then we validate the highest and equalize the bid
                        $total_high_bids = count($bid_details);
                        $this->override_min_bid = true;

                        for ($i = 0; $i < $total_high_bids; $i++) {
                            $tmp_output = $this->place_bid($bid_details[$i]['bid_proxy'], $bid_details[$i]['quantity'], $bid_details[$i]['bidder_id'], $item_details);

                            if ($bid_details[$i]['active_bid']) {
                                $bid_output = $tmp_output;
                            }
                        }

                        $this->override_min_bid = false;

                        ## and now we will out any bids that are low and we will equalize the bids with the lowest current active bid
                        (array)$bid_details = null;

                        $sql_select_bids = $this->query("SELECT bid_id, quantity, bid_amount FROM " . DB_PREFIX . "bids WHERE
							auction_id='" . $item_details['auction_id'] . "' AND bid_out='0' AND bid_invalid='0'
							ORDER BY bid_amount DESC");

                        $counter = 0;
                        $remaining_quantity = $item_details['quantity'];
                        $lowest_active_bid = 0;

                        while ($bid_row = $this->fetch_array($sql_select_bids)) {
                            $bid_details[$counter] = $bid_row;

                            $bid_details[$counter]['bid_out'] = ($remaining_quantity > 0) ? 0 : 1;

                            $remaining_quantity -= $bid_row['quantity'];

                            if ($remaining_quantity <= 0 && !$lowest_active_bid) {
                                $lowest_active_bid = $bid_row['bid_amount']; ## the new bid that will be set
                            }

                            if ($bid_details[$counter]['bid_out'] && $bid_details[$counter]['bid_id'] == $bid_output['bid_id']) {
                                ## update display message, because the bid is not enough
                                $output['result'] = false;
                                $output['display'] = MSG_BID_PLACED_BUT_OUTBID;
                            }
                            $counter++;
                        }


                        if ($lowest_active_bid > 0) {
                            for ($i = 0; $i < $counter; $i++) ## update bids
                            {
                                $this->query("UPDATE " . DB_PREFIX . "bids SET
									bid_amount=IF(bid_proxy>=$lowest_active_bid, $lowest_active_bid, bid_proxy), 
									bid_out='" . $bid_details[$i]['bid_out'] . "' WHERE bid_id='" . $bid_details[$i]['bid_id'] . "'");
                            }

                            $highest_inactive_proxy = $this->get_sql_field("SELECT bid_proxy FROM " . DB_PREFIX . "bids WHERE
								auction_id='" . $item_details['auction_id'] . "' AND bid_out='1' ORDER BY bid_amount DESC, bid_proxy DESC LIMIT 1", 'bid_proxy');

                            $lowest_active_proxy = $this->get_sql_field("SELECT bid_proxy FROM " . DB_PREFIX . "bids WHERE
								auction_id='" . $item_details['auction_id'] . "' AND bid_out='0' ORDER BY bid_proxy ASC LIMIT 1", 'bid_proxy');

                            ## we set the min bid..
                            $proxy_to_set = ($highest_inactive_proxy > $lowest_active_proxy) ? $lowest_active_proxy : $highest_inactive_proxy;

                            $bid_to_place = ($this->min_bid > $proxy_to_set) ? $this->min_bid : $proxy_to_set;

                            $equalize_active_bids = $this->query("UPDATE " . DB_PREFIX . "bids SET
								bid_amount=IF(bid_proxy>=$bid_to_place, $bid_to_place, bid_proxy) WHERE 
								auction_id='" . $item_details['auction_id'] . "' AND bid_invalid='0' AND bid_out='0'");

                            $update_max_bid = $this->query("UPDATE " . DB_PREFIX . "auctions SET
								max_bid='" . $bid_to_place . "' WHERE auction_id='" . $item_details['auction_id'] . "'");
                        }
                    } else {
                        $bid_output = $this->place_bid($bid_amount, $quantity, $bidder_id, $item_details, $proxy_details);
                    }
                    /* THE PROCEDURE BELOW IS OBSOLETE

                    $bid_output = $this->place_bid($bid_amount, $quantity, $bidder_id, $item_details, $proxy_details);

                    if ($quantity > $quantity_left)
                    {
                        ### we out all bids
                        $sql_mark_out = $this->query("UPDATE " . DB_PREFIX . "bids SET bid_out=1 WHERE
                            auction_id='".$item_details['auction_id']."' AND bid_out=0 AND bid_invalid=0");

                        ### new dutch auction bidding function
                        $sql_select_bids = $this->query("SELECT * FROM " . DB_PREFIX . "bids WHERE
                            auction_id='" . $item_details['auction_id']."' AND bid_out='1' AND bid_invalid='0' AND
                            bid_proxy>='" . $bid_output['bid_amount'] . "' ORDER BY bid_id ASC");

                        $nb_outbid_bids = $this->num_rows($sql_select_bids);

                        while ($bid_row = $this->fetch_array($sql_select_bids))
                        {
                            $bid_details[] = $bid_row;
                        }

                        $loop = ($nb_outbid_bids > 0) ? true : false;

                        $counter = count($bid_details);
                        $first_counter = 0;
                        $last_counter =  $counter - 1;

                        while ($loop)
                        {
                            $min_active_bid = $bid_details[$last_counter]['bid_amount'];

                            for ($i=$first_counter; $i<$counter; $i++)
                            {
                                $min_active_bid = ($min_active_bid > $bid_details[$last_counter]['bid_amount']) ? $bid_details[$last_counter]['bid_amount'] : $min_active_bid;
                            }

                            $new_bid = $this->min_bid_amount($item_details);

                            if ($bid_details[$first_counter]['bid_proxy'] > $min_active_bid && $bid_details[$first_counter]['bid_id'] != $bid_details[$last_counter]['bid_id'])
                            {
                                if ($new_bid > $bid_details[$first_counter]['bid_proxy'])
                                {
                                    $new_bid = $bid_details[$first_counter]['bid_proxy'];
                                }

                                $item_details['bid_proxy'] = $bid_details[$first_counter]['bid_proxy'];
                                $bid_output = $this->place_bid($new_bid, $bid_details[$first_counter]['quantity'], $bid_details[$first_counter]['bidder_id'], $item_details);

                                $new_bids_placed++;

                                $bid_details[$counter] = $bid_details[$first_counter];
                                $bid_details[$counter]['bid_id'] = $bid_output['bid_id'];
                                $bid_details[$counter]['bid_amount'] = $new_bid;
                                $bid_details[$counter]['bid_out'] = 1;
                                $bid_details[$counter]['bid_invalid'] = 0;

                                $bid_details[$first_counter]['bid_invalid'] = 1;

                                $counter++;
                                $first_counter++;
                                $last_counter++;
                            }
                            else
                            {
                                $remaining_quantity = $this->get_sql_field("SELECT SUM(quantity) AS remaining_quantity FROM
                                    " . DB_PREFIX . "bids WHERE bid_invalid=0 AND auction_id='" . $item_details['auction_id'] . "' AND
                                    bid_proxy>" . $new_bid, 'remaining_quantity');

                                $loop = ($remaining_quantity > $item_details['quantity']) ? true : false;
                            }
                        }

                        for ($i=0; $i<$counter; $i++)
                        {
                            $sql_update_bid = $this->query("UPDATE " . DB_PREFIX . "bids SET bid_out='" . $bid_details[$i]['bid_out'] . "',
                                bid_invalid='" . $bid_details[$i]['bid_invalid'] . "' WHERE	bid_id='" . $bid_details[$i]['bid_id'] . "'");
                        }

                        ### activate all bids up to the available quantity
                        $sql_select_outbid = $this->query("SELECT bid_id, quantity FROM " . DB_PREFIX . "bids WHERE
                            auction_id='" . $item_details['auction_id']."' AND bid_invalid='0' AND bid_out='1' ORDER BY bid_id DESC");

                        while ($outbid_row = $this->fetch_array($sql_select_outbid))
                        {
                            $outbid_details[] = $outbid_row;
                        }

                        $outbid_total = count($outbid_details);

                        $rem_qnt = $item_details['quantity'];

                        for ($i=0; $i<$outbid_total; $i++)
                        {
                            if ($rem_qnt>0)
                            {
                                $this->query("UPDATE " . DB_PREFIX . "bids SET bid_out='0' WHERE bid_id='" . $outbid_details[$i]['bid_id'] . "'");
                            }

                            $rem_qnt -= $outbid_details[$i]['quantity'];
                        }

                        ### now equalize all active bids to the lowest active bid.
                        $lowest_active_bid = $this->get_sql_field("SELECT bid_proxy FROM " . DB_PREFIX . "bids WHERE
                            auction_id='" . $item_details['auction_id'] . "' AND bid_invalid='0' AND bid_out='0' ORDER BY bid_proxy ASC LIMIT 0,1","bid_proxy");

                        $equalize_active_bids = $this->query("UPDATE " . DB_PREFIX . "bids SET
                            bid_amount='" . $lowest_active_bid . "' WHERE auction_id='" . $item_details['auction_id'] . "' AND
                            bid_invalid='0' AND bid_out='0'");

                        $update_max_bid = $this->query("UPDATE " . DB_PREFIX . "auctions SET
                            max_bid='" . $lowest_active_bid . "' WHERE auction_id='" . $item_details['auction_id'] ."'");
                    }
                    */
                }
            } else {
                $output['result'] = false;
                $output['display'] = MSG_BID_ERROR_QUANTITY;
            }
        }

        return $output;
    }

    function calculate_high_bid($auction_id)
    {
        $sql_select_bids = $this->query("SELECT * FROM " . DB_PREFIX . "bids WHERE
			auction_id='" . $auction_id . "' ORDER BY bid_amount DESC");

        $nb_bids = $this->num_rows($sql_select_bids);

        if ($nb_bids > 0) {
            $item_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "auctions WHERE auction_id='" . $auction_id . "'");

            $bid_details = array();
            while ($bid_row = mysql_fetch_array($sql_select_bids)) {
                $bid_details[] = $bid_row;
            }

            /*
            $total_bids = count($bid_details);
            $counter = 0;

            ## remove all consecutive bids
            while ($counter < $total_bids)
            {
                if ($bid_details[$counter]['bidder_id'] == $bid_details[$counter+1]['bidder_id'] && $bid_details[$counter]['quantity'] == $bid_details[$counter+1]['quantity'])
                {
                    $this->query("DELETE FROM " . DB_PREFIX . "bids WHERE bid_id='" . $bid_details[$counter]['bid_id'] . "'");
                }

                $counter++;
            }
            */

            ## opt
            $sql_select_bids = $this->query("SELECT * FROM " . DB_PREFIX . "bids WHERE
				auction_id='" . $auction_id . "' AND bid_invalid=0 GROUP BY bidder_id, quantity ORDER BY bid_id ASC");

            $bid_details = array();
            while ($bid_row = $this->fetch_array($sql_select_bids)) {
                $bid_details[] = $bid_row;
            }

            ## now delete all bids and reset the max_bid and nb_bids values;
            $this->query("DELETE FROM " . DB_PREFIX . "bids WHERE auction_id=" . $item_details['auction_id']);
            $this->query("DELETE FROM " . DB_PREFIX . "proxybid WHERE auction_id=" . $item_details['auction_id']);
            $this->query("UPDATE " . DB_PREFIX . "auctions SET max_bid=0, nb_bids=0 WHERE auction_id=" . $item_details['auction_id']);

            ## now place the saved bids back -> WARNING, if the server is shut down or there is a hang when this procedure runs,
            ## the bids may be lost -> a backup might be used, but the probability is remote of this happening

            $total_bids = count($bid_details);
            $bid_counter = 0;

            $mark_in_progress = $this->query("UPDATE " . DB_PREFIX . "auctions SET
				retract_in_progress=1 WHERE auction_id='" . $item_details['auction_id'] . "'");

            while ($bid_counter < $total_bids) {
                $item_details = $this->get_sql_row("SELECT * FROM
					" . DB_PREFIX . "auctions WHERE auction_id='" . $auction_id . "'");

                $proxy_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "proxybid WHERE
					auction_id=" . $item_details['auction_id']);

                $this->bid($bid_details[$bid_counter]['bid_proxy'], $bid_details[$bid_counter]['quantity'], $bid_details[$bid_counter]['bidder_id'], $item_details, $proxy_details);

                $bid_counter++;
            }
            $unmark_in_progress = $this->query("UPDATE " . DB_PREFIX . "auctions SET
				retract_in_progress=0 WHERE auction_id='" . $item_details['auction_id'] . "'");
        } else {
            $this->query("UPDATE " . DB_PREFIX . "auctions SET max_bid='0' WHERE auction_id='" . $auction_id . "'");
        }

        $nb_bids = $this->count_rows('bids', "WHERE auction_id='" . $auction_id . "'");
        $this->query("UPDATE " . DB_PREFIX . "auctions SET nb_bids=" . $nb_bids . " WHERE auction_id='" . $auction_id . "'");

        $this->query("UPDATE " . DB_PREFIX . "bids SET deleted=0 WHERE bid_out=0 AND bid_invalid=0");

    }

    function retract_bid($bidder_id, $auction_id)
    {
        $output = array('result' => false, 'display' => null);

        if ($this->setts['enable_bid_retraction']) {
            ### first we will remove the bid remains from the necessary tables
            $nb_bids = $this->count_rows('bids', "WHERE auction_id='" . $auction_id . "' AND bidder_id='" . $bidder_id . "'");

            $sql_delete_bids = $this->query("DELETE FROM " . DB_PREFIX . "bids WHERE
				auction_id='" . $auction_id . "' AND bidder_id='" . $bidder_id . "'");

            $sql_delete_proxybid = $this->query("DELETE FROM " . DB_PREFIX . "proxybid WHERE
				auction_id='" . $auction_id . "' AND bidder_id='" . $bidder_id . "'");

            $sql_update_auction = $this->query("UPDATE " . DB_PREFIX . "auctions SET
				nb_bids=nb_bids-" . $nb_bids . " WHERE auction_id='" . $auction_id . "'");

            $this->calculate_high_bid($auction_id);

            $output['result'] = true;
            $output['display'] = MSG_RETRACTION_SUCCESSFUL;

            // now notify all other bidders of the bid retraction
            $mail_input_id = $auction_id;
            include('language/' . $this->setts['site_lang'] . '/mails/bid_retraction_bidders_notification.php');
        } else {
            $output['display'] = MSG_ERROR_REMOVAL_IMPOSSIBLE;
        }

        return $output;
    }

    function hide_bid($bid_id, $bidder_id)
    {
        (string)$output = null;

        $bid_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "bids WHERE
			bid_id='" . $bid_id . "'");

        if ($bid_details['bid_out'] && $bid_details['bidder_id'] == $bidder_id) {
            $output = MSG_BID_HIDDEN_SUCCESS;
            $this->query("UPDATE " . DB_PREFIX . "bids SET deleted=1 WHERE bid_id=" . $bid_details['bid_id']);
        } else {
            $output = MSG_BID_HIDDEN_FAILED;
        }
    }

    function keyword_match() ## PLACEHOLDER - keyword watch function - will be called each time we setup/relist and maybe edit an auction
    {

    }

    function relist($auction_id, $user_id, $duration = 0, $charge_fees = true, $auto_relist = false)
    {
        $output = array('display' => null);

        $relist_option = 1; ## relist as a new auction, mark as deleted the old auction
        ##$relist_option = 2; ## relist the same auction

        $file_path = (IN_ADMIN) ? '../' : '';

        $item_details = $this->get_sql_row("SELECT a.*, u.shop_account_id, u.shop_active, u.seller_verified,
			u.user_id, f.store_nb_items FROM " . DB_PREFIX . "auctions a
			LEFT JOIN " . DB_PREFIX . "users u ON a.owner_id=u.user_id
			LEFT JOIN " . DB_PREFIX . "fees_tiers f ON u.shop_account_id=f.tier_id WHERE
			a.auction_id=" . $auction_id . " AND a.owner_id=" . $user_id);

        $list_in = $item_details['list_in'];

        $can_list = true;
        $reset_auto_relists = false;

        if ($item_details['list_in'] != 'auction') {
            /*
            $nb_store_items = $this->count_rows('auctions' , "WHERE owner_id='" . $user_id . "' AND
                active='1' AND closed='0' AND deleted='0' AND list_in!='auction'");

            $can_list = ($item_details['store_nb_items']>$nb_store_items) ? true : false;
            */
            $this->shop = new shop();
            $shop_status = $this->shop->shop_status($item_details, true);

            $can_list = ($item_details['shop_active'] && $shop_status['remaining_items'] > 0) ? true : false;

            if (!$can_list) {
                if ($item_details['list_in'] == 'store') {
                    if (!$auto_relist) {
                        $reset_auto_relists = true;

                        $list_in = 'auction';
                        $can_list = true;
                    }
                } else if ($item_details['list_in'] == 'both') {
                    if (!$this->setts['enable_store_only_mode']) {
                        $list_in = 'auction';
                        $can_list = true;
                    }
                }

                if (!$can_list) {
                    $output['display'] = '[ ' . MSG_AUCTION_ID . ': ' . $auction_id . ' ] - ' . MSG_NO_MORE_STORE_ITEMS_LIST;
                }
            }
        }

        if ($this->setts['enable_seller_verification'] && $this->setts['seller_verification_mandatory'] && !$item_details['seller_verified']) {
            $can_list = false;

            $output['display'] = '<div align="center" class="errormessage contentfont">[ ' . MSG_AUCTION_ID . ': ' . $auction_id . ' ] - ' . MSG_SELLER_VERIFIED_RELIST_MSG . '</div>';
        } else if ($this->setts['enable_store_only_mode'] && !$item_details['shop_active']) {
            $can_list = false;

            $output['display'] = '<div align="center" class="errormessage contentfont">[ ' . MSG_AUCTION_ID . ': ' . $auction_id . ' ] - ' . MSG_STORE_ONLY_MODE_RELIST_MSG . '</div>';
        }

        if ($can_list) {
            if ($item_details['end_time_type'] != 'duration') {
                $auction_duration = ceil(($item_details['end_time'] - $item_details['start_time']) / 86400);
            } else {
                $auction_duration = $item_details['duration'];
            }

            $auction_duration = ($auction_duration > 1) ? intval($auction_duration) : 1;
            $auction_duration = ($duration > 0) ? $duration : $auction_duration; ## if a duration is specified, use it (for closed auction relisting)

            if ($relist_option == 1) {
                $sql_relist_auction = $this->query("INSERT INTO " . DB_PREFIX . "auctions
					(name, description, quantity, auction_type, start_price, reserve_price, buyout_price, bid_increment_amount,
					country, zip_code, shipping_method, shipping_int, payment_methods, category_id, owner_id, hpfeat, catfeat,
					bold, hl, hidden_bidding, currency, postage_amount, insurance_amount, type_service, enable_swap,
					addl_category_id, shipping_details, hpfeat_desc, list_in, direct_payment, apply_tax, auto_relist_bids,
					approved, listing_type, is_offer, offer_min, offer_max, auto_relist_nb, state)
					SELECT
					name, description, quantity, auction_type, start_price, reserve_price, buyout_price, bid_increment_amount,
					country, zip_code, shipping_method, shipping_int, payment_methods, category_id, owner_id, hpfeat, catfeat,
					bold, hl, hidden_bidding, currency, postage_amount, insurance_amount, type_service, enable_swap,
					addl_category_id, shipping_details, hpfeat_desc, list_in, direct_payment, apply_tax, auto_relist_bids,
					approved, listing_type, is_offer, offer_min, offer_max, auto_relist_nb, state
					FROM " . DB_PREFIX . "auctions WHERE auction_id=" . $auction_id . " AND owner_id=" . $user_id);

                $relist_id = $this->insert_id();

                $relist_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "auctions WHERE auction_id=" . $relist_id);

                $this->save_edit_vars($auction_id, 'auction');
                //$this->update_page_data($relist_id, 'auction', $relist_details);
                $this->insert_page_data($relist_id, 'auction', $this->vars);

                $this->auction_approval($relist_details, $user_id);

                ## relist media

                $sql_select_media = $this->query("SELECT * FROM " . DB_PREFIX . "auction_media WHERE
					auction_id=" . $auction_id . " AND upload_in_progress=0 ORDER BY media_id ASC");

                (array)$pictures_array = null;
                (array)$videos_array = null;

                while ($relist_media = $this->fetch_array($sql_select_media)) {
                    $this->query("INSERT INTO " . DB_PREFIX . "auction_media (media_url, auction_id, media_type) VALUES
						('" . $relist_media['media_url'] . "', '" . $relist_id . "', '" . $relist_media['media_type'] . "')");

                    if ($relist_media['media_type'] == 1) {
                        $pictures_array[] = $relist_media['media_url'];
                    } else if ($relist_media['media_type'] == 2) {
                        $videos_array[] = $relist_media['media_url'];
                    }
                }
            } else if ($relist_option == 2) {
                $relist_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "auctions WHERE auction_id=" . $auction_id);
                $relist_id = $auction_id;
            }
            $this->query("DELETE FROM " . DB_PREFIX . "auction_rollbacks WHERE auction_id=" . $auction_id);

            $user_details = $this->get_sql_row("SELECT user_id, username, shop_account_id, shop_categories,
				shop_active, preferred_seller, reg_date, country, state, zip_code, balance,
				default_name, default_description, default_duration, default_hidden_bidding,
				default_enable_swap, default_shipping_method, default_shipping_int, default_postage_amount,
				default_insurance_amount, default_type_service, default_shipping_details, default_payment_methods FROM
				" . DB_PREFIX . "users WHERE user_id=" . $relist_details['owner_id']);

            ## calculate quantity
            $quantity_sold = $this->get_sql_field("SELECT SUM(quantity_offered) AS quantity_sold FROM
				" . DB_PREFIX . "winners WHERE auction_id=" . $auction_id, 'quantity_sold');

            $auction_quantity = ($relist_details['auction_type'] == 'dutch') ? ($relist_details['quantity'] + $quantity_sold) : 1;
            $auction_end_time = CURRENT_TIME + $auction_duration * 86400;

            $relist_query = "UPDATE " . DB_PREFIX . "auctions SET ";

            (array)$relist_field = NULL;

            $relist_field[] = "start_time = '" . CURRENT_TIME . "'";
            $relist_field[] = "start_time_type = 'now'";
            $relist_field[] = "end_time = '" . $auction_end_time . "'";
            $relist_field[] = "duration = '" . $auction_duration . "'";
            $relist_field[] = "closed = '0'";
            $relist_field[] = "nb_bids = '0'";
            $relist_field[] = "max_bid = '0'";
            $relist_field[] = "end_time_type = 'duration'";
            $relist_field[] = "quantity = '" . $auction_quantity . "'";
            $relist_field[] = "nb_clicks = '0'";
            $relist_field[] = "is_relisted_item = '1'";
            $relist_field[] = "list_in = '" . $list_in . "'";

            if ($auto_relist) {
                if (!$reset_auto_relists) {
                    $relist_field[] = "auto_relist_nb=auto_relist_nb-1";
                } else {
                    $relist_field[] = "auto_relist_nb=0";
                }

            }

            $relist_query .= implode(', ', $relist_field);

            $relist_query .= " WHERE auction_id='" . $relist_id . "' AND owner_id='" . $user_id . "' ";

            $this->query($relist_query);

            ## PLACEHOLDER - email listing confirmation
            $this->keyword_match(); ## keyword match function placeholder

            if ($relist_option == 1) {
                $this->delete($auction_id, $user_id); ## mark the original auction as deleted.
            }

            if ($charge_fees) {
                $auction_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "auctions WHERE auction_id=" . $relist_id);
                $auction_details['ad_image'] = $pictures_array;
                $auction_details['ad_video'] = $videos_array;

                $this->fees = new fees();
                $this->fees->setts = $this->setts;

                $setup_result = $this->fees->setup($user_details, $auction_details, null, true);

                $output['display'] = $setup_result['display'];
            } else {
                $output['display'] = MSG_AUCTION_LISTED_SUCCESS;
            }

        }

        return $output;
    }

    function close($item_details, $cron_closed = false, $auto_relist = true)
    {
        ## auctions counter - remove process - single auction (close an auction)
        $cnt_details = $this->get_sql_row("SELECT auction_id, active, approved, closed, deleted, list_in, category_id, addl_category_id FROM
			" . DB_PREFIX . "auctions WHERE auction_id='" . $item_details['auction_id'] . "'");

        if ($cnt_details['active'] == 1 && $cnt_details['approved'] == 1 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0 && $cnt_details['list_in'] != 'store') {
            auction_counter($cnt_details['category_id'], 'remove', $cnt_details['auction_id']);
            auction_counter($cnt_details['addl_category_id'], 'remove', $cnt_details['auction_id']);
        }

        $update_end_time = ($cron_closed) ? '' : ", end_time='" . CURRENT_TIME . "'";

        $this->query("UPDATE " . DB_PREFIX . "auctions SET closed=1 " . $update_end_time . " WHERE
			auction_id=" . $item_details['auction_id']);

        $is_winner = $this->count_rows('winners', "WHERE auction_id='" . $item_details['auction_id'] . "'");

        if ($auto_relist && $this->setts['enable_auto_relist'] && ($item_details['auto_relist_nb'] && ($item_details['auto_relist_bids'] || !$is_winner))) {
            $this->relist($item_details['auction_id'], $item_details['owner_id'], 0, true, true);
        }
    }

    function prepare_reputation($winning_bid_details, $item_details)
    {
        ## first add sale/purchase in the 'users' table
        $this->query("UPDATE " . DB_PREFIX . "users SET items_sold=items_sold+1 WHERE user_id='" . $winning_bid_details['seller_id'] . "'");
        $this->query("UPDATE " . DB_PREFIX . "users SET items_bought=items_bought+1 WHERE user_id='" . $winning_bid_details['buyer_id'] . "'");

        ## now add the reputation placeholders.
        $this->query("INSERT INTO " . DB_PREFIX . "reputation (user_id, from_id, auction_id, reputation_type, winner_id) VALUES
			('" . $winning_bid_details['seller_id'] . "', '" . $winning_bid_details['buyer_id'] . "',
			'" . $item_details['auction_id'] . "', 'sale', '" . $winning_bid_details['winner_id'] . "')");
        $this->query("INSERT INTO " . DB_PREFIX . "reputation (user_id, from_id, auction_id, reputation_type, winner_id) VALUES
			('" . $winning_bid_details['buyer_id'] . "', '" . $winning_bid_details['seller_id'] . "',
			'" . $item_details['auction_id'] . "', 'purchase', '" . $winning_bid_details['winner_id'] . "')");
    }

    function assign_winner($item_details, $sale_type = 'high_bid', $buyer_id = 0, $purchased_quantity = 0, $offer_details = null)
    {
        $output = array('result' => false, 'display' => null, 'auction_close' => false, 'winner_id' => null);
        (array)$winners_ids = null;

        $sale_type = (in_array($sale_type, array('high_bid', 'buy_out', 'auction_offers', 'bids', 'swaps'))) ? $sale_type : 'high_bid';

        switch ($sale_type) {
            case 'high_bid': ## the highest bid on the auction is the winner - wont work with "manually select winner"
                if ($item_details['nb_bids'] > 0 && $item_details['max_bid'] >= $item_details['reserve_price']) {
                    $output['result'] = true;

                    $sql_select_bids = $this->query("SELECT * FROM " . DB_PREFIX . "bids WHERE
						auction_id='" . $item_details['auction_id'] . "' AND bid_out='0' AND bid_invalid='0' ORDER BY bid_amount DESC");

                    $remaining_quantity = $item_details['quantity'];
                    while ($winning_bid = $this->fetch_array($sql_select_bids)) {
                        $quantity_offered = ($winning_bid['quantity'] > $remaining_quantity) ? $remaining_quantity : $winning_bid['quantity'];

                        $remaining_quantity -= $quantity_offered;

                        $sql_insert_winner = $this->query("INSERT INTO " . DB_PREFIX . "winners
							(seller_id, buyer_id, bid_amount, quantity_requested, quantity_offered, auction_id, purchase_date) VALUES
							('" . $item_details['owner_id'] . "', '" . $winning_bid['bidder_id'] . "', '" . $winning_bid['bid_amount'] . "',
							'" . $winning_bid['quantity'] . "', '" . $quantity_offered . "', '" . $item_details['auction_id'] . "',
							'" . CURRENT_TIME . "')");

                        $winners_ids[] = $this->insert_id();
                    }
                } else if ($item_details['nb_bids'] > 0 && $item_details['max_bid'] < $item_details['reserve_price']) {
                    $mail_input_id = $item_details['auction_id'];
                    @include('language/' . $this->setts['site_lang'] . '/mails/no_sale_reserve_buyers_notification.php');
                    @include('language/' . $this->setts['site_lang'] . '/mails/no_sale_reserve_sellers_notification.php');
                }
                break;
            case 'buy_out': ## buyer_id is the winner of the auction - wont work with "manually select winner"
                $output['result'] = true;

                $quantity_offered = ($purchased_quantity > $item_details['quantity']) ? $item_details['quantity'] : $purchased_quantity;

                $sql_insert_winner = $this->query("INSERT INTO " . DB_PREFIX . "winners
					(seller_id, buyer_id, bid_amount, quantity_requested, quantity_offered, auction_id, purchase_date, buyout_purchase) VALUES
					('" . $item_details['owner_id'] . "', '" . $buyer_id . "', '" . $item_details['buyout_price'] . "',
					'" . $purchased_quantity . "', '" . $quantity_offered . "', '" . $item_details['auction_id'] . "',
					'" . CURRENT_TIME . "', '1')");

                $winner_id = $this->insert_id();
                $winners_ids[] = $winner_id;

                ## subtract quantity
                if ($purchased_quantity <= $item_details['quantity']) {
                    $this->query("UPDATE " . DB_PREFIX . "auctions SET quantity=quantity-" . $purchased_quantity . " WHERE
						auction_id='" . $item_details['auction_id'] . "'");
                }

                ## only close the auction if all the quantity is purchased (dutch auctions)
                $output['auction_close'] = ($purchased_quantity >= $item_details['quantity']) ? true : false;
                $output['winner_id'] = $winner_id;

                break;
            case 'auction_offers': ## make offer winner - the winner is in $offer_details
                $output['result'] = true;

                $quantity_offered = ($purchased_quantity > $item_details['quantity']) ? $item_details['quantity'] : $purchased_quantity;
                $quantity_offered = ($quantity_offered > 0) ? $quantity_offered : 1;

                $sql_insert_winner = $this->query("INSERT INTO " . DB_PREFIX . "winners
					(seller_id, buyer_id, bid_amount, quantity_requested, quantity_offered, auction_id, purchase_date) VALUES
					('" . $item_details['owner_id'] . "', '" . $buyer_id . "', '" . $offer_details['amount'] . "',
					'" . $purchased_quantity . "', '" . $quantity_offered . "', '" . $item_details['auction_id'] . "',
					'" . CURRENT_TIME . "')");

                $winner_id = $this->insert_id();
                $winners_ids[] = $winner_id;

                ## subtract quantity
                if ($purchased_quantity <= $item_details['quantity']) {
                    $this->query("UPDATE " . DB_PREFIX . "auctions SET quantity=quantity-" . $purchased_quantity . " WHERE
						auction_id='" . $item_details['auction_id'] . "'");
                }

                $this->query("UPDATE " . DB_PREFIX . "auction_offers SET accepted='1' WHERE
					offer_id='" . $offer_details['offer_id'] . "'");

                ## only close the auction if all the quantity is purchased (dutch auctions)
                $output['auction_close'] = ($purchased_quantity >= $item_details['quantity']) ? true : false;
                $output['winner_id'] = $winner_id;

                break;
            case 'swaps': ## swap offer winner - the winner is in $offer_details
                $output['result'] = true;

                $quantity_offered = ($purchased_quantity > $item_details['quantity']) ? $item_details['quantity'] : $purchased_quantity;
                $quantity_offered = ($quantity_offered > 0) ? $quantity_offered : 1;

                $sql_insert_winner = $this->query("INSERT INTO " . DB_PREFIX . "winners
					(seller_id, buyer_id, bid_amount, quantity_requested, quantity_offered, auction_id, purchase_date) VALUES
					('" . $item_details['owner_id'] . "', '" . $buyer_id . "', '-1',
					'" . $purchased_quantity . "', '" . $quantity_offered . "', '" . $item_details['auction_id'] . "',
					'" . CURRENT_TIME . "')");

                $winner_id = $this->insert_id();
                $winners_ids[] = $winner_id;

                ## subtract quantity
                if ($purchased_quantity <= $item_details['quantity']) {
                    $this->query("UPDATE " . DB_PREFIX . "auctions SET quantity=quantity-" . $purchased_quantity . " WHERE
						auction_id='" . $item_details['auction_id'] . "'");
                }

                $this->query("UPDATE " . DB_PREFIX . "swaps SET accepted='1', winner_id='" . $winner_id . "' WHERE
					swap_id='" . $offer_details['swap_id'] . "'");

                ## only close the auction if all the quantity is purchased (dutch auctions)
                $output['auction_close'] = ($purchased_quantity >= $item_details['quantity']) ? true : false;
                $output['winner_id'] = $winner_id;

                break;
            case 'bids': ## reserve offer winner - the winner is in $offer_details
                $output['result'] = true;

                $quantity_offered = ($purchased_quantity > $item_details['quantity']) ? $item_details['quantity'] : $purchased_quantity;
                $quantity_offered = ($quantity_offered > 0) ? $quantity_offered : 1;

                $sql_insert_winner = $this->query("INSERT INTO " . DB_PREFIX . "winners
					(seller_id, buyer_id, bid_amount, quantity_requested, quantity_offered, auction_id, purchase_date) VALUES
					('" . $item_details['owner_id'] . "', '" . $buyer_id . "', '" . $offer_details['bid_amount'] . "',
					'" . $purchased_quantity . "', '" . $quantity_offered . "', '" . $item_details['auction_id'] . "',
					'" . CURRENT_TIME . "')");

                $winner_id = $this->insert_id();
                $winners_ids[] = $winner_id;

                ## subtract quantity
                if ($purchased_quantity <= $item_details['quantity']) {
                    $this->query("UPDATE " . DB_PREFIX . "auctions SET quantity=quantity-" . $purchased_quantity . " WHERE
						auction_id='" . $item_details['auction_id'] . "'");
                }

                if ($this->second_chance) {
                    $this->query("UPDATE " . DB_PREFIX . "bids SET bid_out='0' WHERE
						bid_id='" . $offer_details['bid_id'] . "'");
                } else {
                    $this->query("UPDATE " . DB_PREFIX . "bids SET rp_winner='1' WHERE
						bid_id='" . $offer_details['bid_id'] . "'");
                }

                ## only close the auction if all the quantity is purchased (dutch auctions)
                $output['auction_close'] = ($purchased_quantity >= $item_details['quantity']) ? true : false;
                $output['winner_id'] = $winner_id;

                break;
        }

        if ($output['result']) {
            $this->fees = new fees();
            $this->fees->setts = $this->setts;

            if (count($winners_ids) > 0) {
                foreach ($winners_ids as $winner_id) {
                    $winning_bid_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "winners WHERE winner_id='" . $winner_id . "'");

                    if (!$this->second_chance) {
                        $sale_result = $this->fees->sale($winning_bid_details, $item_details);
                        $output['display'] = $sale_result['display'];
                    }

                    $this->prepare_reputation($winning_bid_details, $item_details);

                    ## notify the seller and buyer about the sale
                    $mail_input_id = $winner_id;
                    include($this->extension . 'language/' . $this->setts['site_lang'] . '/mails/sale_seller_notification.php');
                    include($this->extension . 'language/' . $this->setts['site_lang'] . '/mails/sale_buyer_notification.php');
                }
            }
        }

        return $output; ## not sure if the output will be actually used but just in case.
    }

    function delete_winner($winner_id, $option, $user_id)
    {
        if ($option == 'seller') {
            $update_field = 's_deleted';
            $where_field = 'seller_id';
        } else if ($option == 'buyer') {
            $update_field = 'b_deleted';
            $where_field = 'buyer_id';
        }

        $this->query("UPDATE " . DB_PREFIX . "winners SET " . $update_field . "=1 WHERE
			" . $where_field . "='" . $user_id . "' AND winner_id='" . $winner_id . "' AND invoice_sent=0");
    }

    function delete_invoice($invoice_id, $option, $user_id)
    {
        if ($option == 'seller') {
            $update_field = 's_deleted';
            $where_field = 'seller_id';
        } else if ($option == 'buyer') {
            $update_field = 'b_deleted';
            $where_field = 'buyer_id';
        }

        $this->query("UPDATE " . DB_PREFIX . "winners SET " . $update_field . "=1 WHERE
			" . $where_field . "='" . $user_id . "' AND invoice_id='" . $invoice_id . "' AND invoice_sent=1");
    }

    function send_invoice($variables_array, $user_id)
    {
        $invoice_id = intval($variables_array['winner_id'][0]);

        if ($invoice_id > 0) {
            $nb_products = count($variables_array['winner_id']);

            for ($i = 0; $i < $nb_products; $i++) {
                $winner_id = $variables_array['winner_id'][$i];

                ## postage_amount and insurance_amount are specific for each invoice (not for each auction)!
                $this->query("UPDATE " . DB_PREFIX . "winners SET invoice_sent='1',
					postage_included='" . intval($variables_array['postage_included'][$winner_id]) . "',
					postage_amount='" . $variables_array['postage_amount'][$winner_id] . "', 				 
					insurance_included='" . intval($variables_array['insurance_included'][$winner_id]) . "', 
					insurance_amount='" . $variables_array['insurance_amount'][$winner_id] . "', 
					invoice_id='" . $invoice_id . "' WHERE winner_id='" . $winner_id . "' AND seller_id='" . $user_id . "'");

                /*$this->query("UPDATE " . DB_PREFIX . "auctions SET postage_amount='" . $variables_array['postage_amount'][$winner_id] . "',
                    insurance_amount='" . $variables_array['insurance_amount'][$winner_id] . "' WHERE
                    auction_id='" . $variables_array['auction_id'][$winner_id] . "' AND owner_id='" . $user_id . "'");*/
            }


            $mail_input_id = $invoice_id;
            include('language/' . $this->setts['site_lang'] . '/mails/product_invoice_buyer_notification.php');
        }
    }

    function resend_invoice($invoice_id)
    {
        $mail_input_id = $invoice_id;
        include('language/' . $this->setts['site_lang'] . '/mails/product_invoice_buyer_notification.php');
    }

    function history_row($invoice_details)
    {
        $output = array('item_id' => null, 'invoice_name' => null, 'date' => null, 'amount' => null, 'balance' => null, 'payment_type' => null);

        $this->fees = new fees();
        $this->fees->setts = $this->setts;

        $output['item_id'] = ($invoice_details['item_id'] > 0) ? '<a href="' . process_link('auction_details', array('auction_id' => $invoice_details['item_id'])) . '" target="_blank">' . $invoice_details['item_id'] . '</a>' : '-';
        ## addition for wanted ads
        $output['item_id'] = ($invoice_details['wanted_ad_id'] > 0) ? '<a href="' . process_link('wanted_details', array('wanted_ad_id' => $invoice_details['wanted_ad_id'])) . '" target="_blank">' . $invoice_details['wanted_ad_id'] . '</a>' : $output['item_id'];
        ## invoice name & balance
        if ($invoice_details['live_fee']) {
            if ($invoice_details['amount'] >= 0) {
                $output['invoice_name'] = '<a href="' . process_link('invoice_print', array('invoice_type' => 'fee_invoice', 'invoice_id' => $invoice_details['invoice_id'])) . '" target="_blank">' . $invoice_details['name'] . '</a>';
                $output['balance'] = MSG_LIVE_FEE;
                $output['payment_type'] = GMSG_RECEIPT;
            } else {
                $output['invoice_name'] = $invoice_details['name'];
                $output['balance'] = $this->fees->display_amount(0, $this->setts['currency'], true);
                $output['payment_type'] = GMSG_CREDIT;
            }
        } else if ($invoice_details['item_id'] > 0) {
            $output['invoice_name'] = '<a href="' . process_link('invoice_print', array('invoice_type' => 'auction_invoice', 'auction_id' => $invoice_details['item_id'])) . '" target="_blank">' . MSG_AUCTION_FEES . ' - ' . MSG_AUCTION_ID . ': ' . $invoice_details['item_id'] . '</a>';

            $balance = $invoice_details['current_balance'] - $invoice_details['amount'] + $invoice_details['invoice_amount'];
            $output['balance'] = $this->fees->display_amount(abs($balance), $this->setts['currency'], true) . ' ' . (($balance > 0) ? GMSG_DEBIT : GMSG_CREDIT);
            $output['payment_type'] = GMSG_DEBIT;
        } else if ($invoice_details['wanted_ad_id'] > 0) {
            $output['invoice_name'] = '<a href="' . process_link('invoice_print', array('invoice_type' => 'auction_invoice', 'wanted_ad_id' => $invoice_details['wanted_ad_id'])) . '" target="_blank">' . MSG_WANTED_AD_FEES . ' - ' . MSG_WANTED_AD_ID . ': ' . $invoice_details['wanted_ad_id'] . '</a>';

            $balance = $invoice_details['current_balance'] - $invoice_details['amount'] + $invoice_details['invoice_amount'];
            $output['balance'] = $this->fees->display_amount(abs($balance), $this->setts['currency'], true) . ' ' . (($balance > 0) ? GMSG_DEBIT : GMSG_CREDIT);
            $output['payment_type'] = GMSG_DEBIT;
        }

        ## invoice date
        $output['date'] = show_date($invoice_details['invoice_date']);

        ## invoice amount
        $output['amount'] = $this->fees->display_amount(abs($invoice_details['invoice_amount']), $this->setts['currency'], true);

        return $output;
    }

    function show_high_bid($item_details, $output_type = 'high_bid')
    {
        (string)$display_output = null;

        $this->fees = new fees();
        $this->fees->setts = $this->setts;

        if ($output_type == 'winner') {
            $sql_select_winners = $this->query("SELECT w.bid_amount, w.quantity_offered, w.buyout_purchase, u.username, u.user_id FROM " . DB_PREFIX . "winners w
				LEFT JOIN " . DB_PREFIX . "users u ON w.buyer_id=u.user_id WHERE
				w.auction_id='" . $item_details['auction_id'] . "'");

            $is_winners = $this->num_rows($sql_select_winners);

            if ($is_winners) {
                $display_output_tmp = null;

                while ($winner_details = $this->fetch_array($sql_select_winners)) {
                    $display_output_tmp[] = (($winner_details['quantity_offered'] > 1) ? $winner_details['quantity_offered'] . ' x ' : '') .
                        '<span class="greenfont"><b>' . $this->fees->display_amount($winner_details['bid_amount'], $item_details['currency']) . '</b></span> - ' .
                        (($item_details['hidden_bidding'] && !$this->show_hidden_bid) ? MSG_BIDDER_ID_HIDDEN : $winner_details['username'] . user_pics($winner_details['user_id'])) .
                        (($winner_details['buyout_purchase']) ? ' [ ' . MSG_PURCHASED_WITH_BUY_OUT . ' ] ' : '');
                }
                $display_output = $this->implode_array($display_output_tmp, '<br>');
            } else if ($item_details['closed']) {
                $display_output = GMSG_NA;
            }
        }

        if ($output_type == 'high_bid') {
            if ($item_details['nb_bids']) {
                $display_output_tmp = null;

                $sql_select_bids = $this->query("SELECT b.bid_amount, u.username, u.user_id FROM " . DB_PREFIX . "bids b
					LEFT JOIN " . DB_PREFIX . "users u ON b.bidder_id=u.user_id WHERE
					b.auction_id='" . $item_details['auction_id'] . "' AND b.bid_out=0 AND b.bid_invalid=0");

                while ($bid_details = $this->fetch_array($sql_select_bids)) {
                    $display_output_tmp[] = '<span class="greenfont"><b>' . $this->fees->display_amount($bid_details['bid_amount'], $item_details['currency']) . '</b></span> - ' .
                        (($item_details['hidden_bidding'] && !$this->show_hidden_bid) ? MSG_BIDDER_ID_HIDDEN : $bid_details['username'] . user_pics($bid_details['user_id']));
                }

                $display_output = $this->implode_array($display_output_tmp, '<br>');
            } else {
                $display_output = GMSG_NO_BIDS;
            }
        }

        return $display_output;
    }

    function winners_message_board_link($item_details, $user_id)
    {
        (string)$display_output = null;

        $seller_logged = ($item_details['owner_id'] == $user_id) ? true : false;

        $addl_query = ($seller_logged) ? '' : " AND w.buyer_id='" . $user_id . "'";

        $is_winner = $this->count_rows('winners w', "WHERE	w.auction_id='" . $item_details['auction_id'] . "' AND
			w.active=1 AND w.payment_status='confirmed' " . $addl_query);

        if ($is_winner) {
            $sql_select_wins = $this->query("SELECT w.*, b.username AS buyer_username, s.username AS seller_username FROM " . DB_PREFIX . "winners w
				LEFT JOIN " . DB_PREFIX . "users b ON w.buyer_id=b.user_id
				LEFT JOIN " . DB_PREFIX . "users s ON w.seller_id=s.user_id	WHERE
				w.auction_id='" . $item_details['auction_id'] . "' AND w.active=1 AND w.payment_status='confirmed' " . $addl_query);

            while ($winning_bid_details = $this->fetch_array($sql_select_wins)) {
                $display_output .= '<tr class="c2 contentfont"><td>' .
                    (($seller_logged) ? MSG_WINNER . ': <b>' . $winning_bid_details['buyer_username'] . '</b>' : MSG_SELLER . ': <b>' . $winning_bid_details['seller_username'] . '</b>') .
                    '	</td><td>' .
                    ' 	[ <a href="' . process_link('message_board', array('message_handle' => '3', 'winner_id' => $winning_bid_details['winner_id'])) . '"><b class="greenfont">' . MSG_GO_TO_MSG_BOARD . '</b></a> ]' .
                    '	</td></tr>';
            }

            if (!empty($display_output)) {
                $display_output .= '<tr class="c5"> ' .
                    '	<td colspan="2"><img src="themes/' . $setts['default_theme'] . '/img/pixel.gif" width="1" height="1"></td> ' .
                    '</tr> ';
            }
        }

        return $display_output;
    }

    function your_bid($auction_id, $user_id)
    {
        $output = null;

        if ($user_id > 0) {
            $user_bid = $this->get_sql_row("SELECT bid_amount FROM " . DB_PREFIX . "bids WHERE
				auction_id='" . $auction_id . "' AND bidder_id='" . $user_id . "' ORDER BY bid_amount DESC LIMIT 1");

            if ($this->count_contents($user_bid)) {
                $output = $user_bid['bid_amount'];
            }
        }

        return $output;
    }

    function edit_description($item_details, $description_edit)
    {
        $description = $item_details['description'] . '<br><hr>' .
            MSG_ON . ' ' . show_date(CURRENT_TIME) . ', ' . MSG_DESC_HAS_BEEN_ADDED . ':<br><br>' . $description_edit;

        $this->query("UPDATE " . DB_PREFIX . "auctions SET
			description='" . $this->rem_special_chars($description) . "' WHERE
			auction_id='" . $item_details['auction_id'] . "'");
    }

    function direct_payment_box($item_details, $user_id, $winner_id = 0)
    {
        (array)$output = null;
        (int)$fee_table = 50; // direct payment

        $addl_query = ($winner_id) ? "AND winner_id='" . $winner_id . "'" : '';

        $sql_select_winners = $this->query("SELECT * FROM " . DB_PREFIX . "winners WHERE
			auction_id='" . $item_details['auction_id'] . "' AND buyer_id='" . $user_id . "' AND
			active=1 AND payment_status='confirmed' " . $addl_query);

        $is_winners = $this->num_rows($sql_select_winners);

        if (!empty($item_details['direct_payment']) && $is_winners) {
            $this->fees = new fees();
            $this->fees->setts = $this->setts;

            while ($winner_details = $this->fetch_array($sql_select_winners)) {
                (string)$display_output = null;

                if (!$winner_details['direct_payment_paid'] && !$winner_details['flag_paid'] && $winner_details['bid_amount'] > 0) {
                    $transaction_id = $winner_details['winner_id'] . 'TBL' . $fee_table;

                    $payment_description = MSG_DIRECT_PAYMENT . ' - ' . $item_details['name'] . ', ' . MSG_AUCTION_ID . ': ' . $item_details['auction_id'];

                    $payment_amount = $winner_details['bid_amount'] * $winner_details['quantity_offered'];

                    $this->tax = new tax();
                    $auction_tax = $this->tax->auction_tax($item_details['owner_id'], $this->setts['enable_tax'], $winner_details['buyer_id']);

                    $tax_details = array(
                        'apply' => $item_details['apply_tax'],
                        'tax_reg_number' => (($item_details['apply_tax']) ? $auction_tax['tax_reg_number'] : ''),
                        'tax_rate' => (($item_details['apply_tax']) ? $auction_tax['amount'] . '%' : ''),
                        'tax_name' => (($item_details['apply_tax']) ? $auction_tax['tax_name'] : '')
                    );

                    if ($winner_details['invoice_sent']) {
                        $payment_amount += ($winner_details['postage_included']) ? ($winner_details['postage_amount'] * $winner_details['quantity_offered']) : 0;
                        $payment_amount += ($winner_details['insurance_included']) ? ($winner_details['insurance_amount'] * $winner_details['quantity_offered']) : 0;
                    } else {
                        $payment_amount += $item_details['postage_amount'] * $winner_details['quantity_offered'];
                        $payment_amount += $item_details['insurance_amount'] * $winner_details['quantity_offered'];
                    }

                    if ($tax_details['apply']) {
                        $payment_amount = $payment_amount + ($payment_amount * $tax_details['tax_rate'] / 100);
                    }

                    $display_output = '<p align="center"><br>' . MSG_CONGRATS_YOU_WON . ' <b>' . $item_details['name'] . '</b> (' . MSG_TRANSACTION_ID . ': ' . $winner_details['winner_id'] . ').</p> ' .
                        '<p align="center">' . MSG_PROCEED_TO_PG_DP_MSG . ' <b>' . $this->fees->display_amount($payment_amount, $item_details['currency']) . '</b>.<br> ';

                    if ($tax_details['apply']) {
                        $display_output .= '(' . $tax_details['tax_rate'] . ' ' . $tax_details['tax_name'] . ' ' . MSG_INCLUDED_IN_PRICE . ')';
                    }

                    $display_output .= '</p>';

                    $this->fees->user_id = $user_id;
                    $this->fees->seller_id = $item_details['owner_id'];

                    $payment_amount = number_format($payment_amount, 2);

                    $display_output .= $this->fees->show_gateways($transaction_id, $payment_amount, $item_details['currency'], $item_details['owner_id'], $payment_description, $item_details['direct_payment']);
                } else if ($winner_details['direct_payment_paid']) {
                    $display_output = '<p align="center">' . MSG_DP_PAID_EXPL . ' (' . MSG_TRANSACTION_ID . ': ' . $winner_details['winner_id'] . ')</p> ';
                }

                if ($display_output) {
                    $output[] = $display_output;
                }
            }

        }

        return $output;
    }

    function direct_payment_multiple($invoice_id, $items_array, $dp_array, $buyer_id)
    {
        $output = false;

        $nb_sub_arrays = count($dp_array);
        if ($nb_sub_arrays) {
            $array_result = $dp_array[0];

            for ($i = 1; $i < $nb_sub_arrays; $i++) {
                $array_result = @array_intersect($array_result, $dp_array[$i]);
            }

            $all_unpaid = true;
            for ($i = 0; $i < $nb_sub_arrays; $i++) {
                $all_unpaid = (!$items_array[$i]['direct_payment_paid'] && !$items_array[$i]['flag_paid'] && $items_array[$i]['bid_amount'] > 0) ? $all_unpaid : false;
            }

            $same_currency = true;
            $currency = $items_array[0]['currency'];
            for ($i = 0; $i < $nb_sub_arrays; $i++) {
                $same_currency = ($currency == $items_array[$i]['currency']) ? $same_currency : false;
            }
        }

        $output = (is_array($array_result) && $all_unpaid) ? true : false;

        return $output;
    }

    function direct_payment_multiple_box($invoice_id, $items_array, $dp_array, $buyer_id)
    {
        (string)$display_output = null;
        $fee_table = 100; ## direct payment - multiple items;

        if ($this->direct_payment_multiple($invoice_id, $items_array, $dp_array, $buyer_id)) {
            $this->fees = new fees();
            $this->fees->setts = $this->setts;

            $this->tax = new tax();

            $payment_amount = 0;

            foreach ($items_array as $item_details) {
                $transaction_ids[] = $item_details['winner_id'];

                $payment_amount += $item_details['bid_amount'] * $item_details['quantity_offered'];

                $auction_tax = $this->tax->auction_tax($item_details['seller_id'], $this->setts['enable_tax'], $item_details['buyer_id']);

                $tax_details = array(
                    'apply' => $item_details['apply_tax'],
                    'tax_reg_number' => (($item_details['apply_tax']) ? $auction_tax['tax_reg_number'] : ''),
                    'tax_rate' => (($item_details['apply_tax']) ? $auction_tax['amount'] . '%' : ''),
                    'tax_name' => (($item_details['apply_tax']) ? $auction_tax['tax_name'] : '')
                );

                $payment_amount += ($item_details['postage_included']) ? $item_details['postage_amount'] : 0;
                $payment_amount += ($item_details['insurance_included']) ? $item_details['insurance_amount'] : 0;

                if ($tax_details['apply']) {
                    $payment_amount = $payment_amount + ($payment_amount * $tax_details['tax_rate'] / 100);
                }

                $invoice_currency = $item_details['currency'];
                $invoice_seller = $item_details['seller_id'];
            }

            $nb_sub_arrays = count($dp_array);
            if ($nb_sub_arrays) {
                $array_result = $dp_array[0];

                for ($i = 1; $i < $nb_sub_arrays; $i++) {
                    $array_result = array_intersect($array_result, $dp_array[$i]);
                }
            }

            $dp_gateways = $this->implode_array($array_result);

            $payment_description = MSG_DIRECT_PAYMENT . ' - ' . MSG_INVOICE_ID . ': ' . $invoice_id;

            $transaction_id = $this->implode_array($transaction_ids) . 'TBL' . $fee_table;

            $display_output = '<p align="center" class="errormessage"><b>' . MSG_INVOICE_PAYMENT . ' [ ' . MSG_INVOICE_ID . ': ' . $invoice_id . ' ]</b><br><br> ' .
                MSG_PROCEED_TO_PG_DP_MSG . ' <b>' . $this->fees->display_amount($payment_amount, $invoice_currency) . '</b>.</p><br>';

            $this->fees->user_id = $buyer_id;
            $this->fees->seller_id = $invoice_seller;
            $display_output .= $this->fees->show_gateways($transaction_id, $payment_amount, $invoice_currency, $invoice_seller, $payment_description, $dp_gateways);
        }

        return $display_output;
    }

    function item_watch_add($auction_id, $user_id, $auction_owner_id = 0)
    {
        (string)$display_output = null;

        if ($user_id != $auction_owner_id) {
            $is_item_watch = $this->count_rows('auction_watch', "WHERE user_id='" . $user_id . "' AND auction_id='" . $auction_id . "'");

            if (!$is_item_watch) {
                $this->query("INSERT INTO " . DB_PREFIX . "auction_watch
					(user_id, auction_id) VALUES
					('" . $user_id . "', '" . $auction_id . "')");

                $display_output = MSG_ITEM_WATCH_ADD_SUCCESS;
            } else {
                $display_output = MSG_ITEM_WATCH_ADD_DOUBLE_POST;
            }
        } else {
            $display_output = MSG_ERROR_ITEM_WATCH_AUCT_OWNER;
        }

        return $display_output;
    }

    function item_watch_delete($auction_ids, $user_id)
    {
        (string)$display_output = null;

        $this->query("DELETE FROM " . DB_PREFIX . "auction_watch	WHERE
			user_id='" . $user_id . "' AND auction_id IN (" . $auction_ids . ")");

        $display_output = MSG_ITEM_WATCH_DELETE_SUCCESS;

        return $display_output;
    }

    function keywords_watch_delete($keyword_ids, $user_id)
    {
        (string)$display_output = null;

        $this->query("DELETE FROM " . DB_PREFIX . "keywords_watch WHERE
			user_id='" . $user_id . "' AND keyword_id IN (" . $keyword_ids . ")");

        $display_output = MSG_KEYWORD_WATCH_DELETE_SUCCESS;

        return $display_output;
    }

    function auction_friend($item_details, $user_id, $friend_name, $friend_email, $comments, $sender_name, $sender_email)
    {
        (string)$display_output = null;

        ## email here
        include('language/' . $this->setts['site_lang'] . '/mails/auction_friend.php');

        $display_output = MSG_AUCTION_FRIEND_SEND_SUCCESS;

        return $display_output;

    }

    function flag_paid($flag_id, $direct_payment)
    {
        (string)$display_output = null;

        if ($flag_id == 0) {
            $display_output = '<span class="redfont">' . MSG_UNPAID . '</span>';
        } else if ($flag_id == 1) {
            $display_output = '<span class="greenfont">' . MSG_PAID . '</span>';
        }

        if ($direct_payment) {
            $display_output .= ' - ' . MSG_DIRECT_PAYMENT;
        }

        return $display_output;
    }

    function flag_status($flag_id)
    {
        (string)$display_output = null;

        if ($flag_id == 0) {
            $display_output = MSG_FLAG_STATUS_A;
        } else if ($flag_id == 1) {
            $display_output = MSG_FLAG_STATUS_B;
        } else if ($flag_id == 2) {
            $display_output = MSG_FLAG_STATUS_C;
        } else if ($flag_id == 3) {
            $display_output = MSG_FLAG_STATUS_D;
        }

        return $display_output;

    }

    function can_place_offer($item_details, $amount)
    {
        $output = false;

        if ($item_details['offer_min'] <= 0 && $item_details['offer_max'] <= 0) {
            $output = true;
        } else if ($item_details['offer_min'] > 0 && $item_details['offer_max'] <= 0) {
            if ($amount >= $item_details['offer_min']) {
                $output = true;
            }
        } else if ($item_details['offer_min'] <= 0 && $item_details['offer_max'] > 0) {
            if ($amount <= $item_details['offer_max']) {
                $output = true;
            }
        } else if ($item_details['offer_min'] > 0 && $item_details['offer_max'] > 0) {
            if ($amount >= $item_details['offer_min'] && $amount <= $item_details['offer_max']) {
                $output = true;
            }
        }

        return $output;
    }

    function place_offer($item_details, $user_id, $offer_field, $quantity, $offer_type = 'make_offer')
    {
        if ($offer_type == 'make_offer') {
            $this->query("INSERT INTO " . DB_PREFIX . "auction_offers
				(auction_id, buyer_id, seller_id, quantity, amount) VALUES
				('" . $item_details['auction_id'] . "', '" . $user_id . "', '" . $item_details['owner_id'] . "',
				'" . $quantity . "', '" . $offer_field . "')");

            $mail_input_id = $this->insert_id();
            include('language/' . $this->setts['site_lang'] . '/mails/make_offer_seller_notification.php');
        } else if ($offer_type == 'swap_offer') {
            $this->query("INSERT INTO " . DB_PREFIX . "swaps
				(auction_id, seller_id, buyer_id, quantity, description) VALUES
				('" . $item_details['auction_id'] . "', '" . $item_details['owner_id'] . "', '" . $user_id . "',
				'" . $quantity . "', '" . $this->rem_special_chars($offer_field) . "')");

            $mail_input_id = $this->insert_id();
            include('language/' . $this->setts['site_lang'] . '/mails/swap_offer_seller_notification.php');
        }

        $this->query("UPDATE " . DB_PREFIX . "auctions SET nb_offers=nb_offers+1 WHERE auction_id='" . $item_details['auction_id'] . "'");
    }

    function is_reserve_offer($item_details)
    {
        $output = false;

        if ($item_details['active'] == 1 && $item_details['deleted'] == 0 && $item_details['closed'] == 1 &&
            $item_details['nb_bids'] > 0 && $item_details['max_bid'] < $item_details['reserve_price']
        ) {
            $output = true;
        }

        return $output;
    }

    function can_make_offer($item_details)
    {
        $output = false;

        $total_quant = $this->get_sql_field("SELECT sum(quantity_offered) AS total_quant FROM " . DB_PREFIX . "winners WHERE
			auction_id='" . $item_details['auction_id'] . "'", 'total_quant');

        if ($item_details['active'] == 1 && $item_details['deleted'] == 0 && $item_details['closed'] == 0 && $total_quant < $item_details['quantity']) {
            $output = true;
        } else if ($this->is_reserve_offer($item_details)) {
            $output = true;
        } else if ($this->apply_second_chance($item_details, $item_details['owner_id'])) {
            $output = true;

            $this->second_chance = true;
        }

        return $output;
    }

    function offer_status($status)
    {
        return ($status) ? '<span class="greenfont">' . GMSG_YES . '</span>' : '<span class="redfont">' . GMSG_NO . '</span>';
    }

    function offer_options($auction_id, $offer_id, $offer_accepted, $can_make_offer, $offer_type = 'auction_offers')
    {
        (string)$display_output = null;

        if ($can_make_offer && !$offer_accepted) {
            $display_output .= '[ <a href="members_area.php?page=selling&section=view_offers&do=accept_offer&offer_id=' . $offer_id .
                '&offer_type=' . $offer_type . '&auction_id=' . $auction_id . '" onclick="return confirm(\'' . MSG_ACCEPT_OFFER_CONFIRM . '\');">' . MSG_ACCEPT_OFFER . '</a> ] ';
        }

        if ($offer_type != 'bids') {
            $display_output .= '[ <a href="members_area.php?page=selling&section=view_offers&do=delete_offer&offer_id=' . $offer_id .
                '&offer_type=' . $offer_type . '&auction_id=' . $auction_id . '" onclick="return confirm(\'' . MSG_DELETE_CONFIRM . '\');">' . GMSG_DELETE . '</a> ] ';
        }

        return $display_output;
    }

    function offer_id_name($offer_table)
    {
        if ($offer_table == 'auction_offers') {
            $offer_id_name = 'offer_id';
        } else if ($offer_table == 'bids') {
            $offer_id_name = 'bid_id';
        } else if ($offer_table == 'swaps') {
            $offer_id_name = 'swap_id';
        }

        return $offer_id_name;
    }

    function delete_offer($offer_table, $offer_id, $user_id)
    {
        $offer_id_name = $this->offer_id_name($offer_table);

        ## in the email we will use $offer_table, $offer_id and $user_id
        ## the email will only be called from this function alone!
        include('language/' . $this->setts['site_lang'] . '/mails/offer_deleted_bidder_notification.php');

        $auction_id = $this->get_sql_field("SELECT auction_id FROM " . DB_PREFIX . $offer_table . " WHERE
			" . $offer_id_name . "='" . intval($offer_id) . "'", 'auction_id');

        $this->query("UPDATE " . DB_PREFIX . "auctions SET nb_offers=nb_offers-1 WHERE auction_id='" . $auction_id . "'");

        $is_delete = $this->query_silent("DELETE o FROM " . DB_PREFIX . $offer_table . " o, " . DB_PREFIX . "auctions a WHERE
			o." . $offer_id_name . "='" . $offer_id . "' AND a.auction_id=o.auction_id AND a.owner_id='" . $user_id . "'");

        if (!$is_delete) {
            $this->query("DELETE FROM " . DB_PREFIX . $offer_table . " WHERE
				" . $offer_id_name . "='" . $offer_id . "' AND auction_id='" . $auction_id . "'");
        }

    }

    function accept_offer($offer_table, $offer_id, $user_id)
    {
        $offer_id_name = $this->offer_id_name($offer_table);

        $offer_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . $offer_table . " WHERE
			" . $offer_id_name . "='" . $offer_id . "'");

        $item_details = $this->get_sql_row("SELECT a.*, w.winner_id, w.seller_id, w.purchase_date,
			w.flag_paid, w.active AS w_active, w.payment_status AS w_payment_status FROM " . DB_PREFIX . "auctions a 
			LEFT JOIN " . DB_PREFIX . "winners w ON w.auction_id=a.auction_id WHERE
			a.owner_id='" . $user_id . "' AND a.auction_id='" . $offer_details['auction_id'] . "'
			GROUP BY a.auction_id");

        if ($offer_table == 'auction_offers' || $offer_table == 'swaps') {
            $buyer_id = $offer_details['buyer_id'];
        } else if ($offer_table == 'bids') {
            $buyer_id = $offer_details['bidder_id'];
        }

        $can_make_offer = $this->can_make_offer($item_details);

        if ($this->second_chance) {
            ## delete winner row
            $this->query("DELETE w, m, i FROM " . DB_PREFIX . "winners w
				LEFT JOIN " . DB_PREFIX . "messaging m ON m.topic_id=w.messaging_topic_id 
				LEFT JOIN " . DB_PREFIX . "invoices i ON i.invoice_id=w.invoice_id WHERE 
				w.winner_id='" . $item_details['winner_id'] . "' AND w.seller_id='" . $item_details['owner_id'] . "'");
        }

        ## we will assign the winner, and then close the auction if the case.
        $purchase_result = $this->assign_winner($item_details, $offer_table, $buyer_id, $offer_details['quantity'], $offer_details);

        if ($this->second_chance) {
            $this->query("UPDATE " . DB_PREFIX . "winners SET active='" . $item_details['w_active'] . "',
				payment_status='" . $item_details['w_payment_status'] . "' WHERE winner_id='" . $purchase_result['winner_id'] . "'");
        }

        if ($purchase_result['auction_close'] && !$item_details['closed']) {
            $this->close($item_details);
        }
    }

    function word_filter($content_array)
    {
        (array)$output = null;
        $sql_select_words = $this->query("SELECT word FROM " . DB_PREFIX . "wordfilter");

        $output = $content_array;
        while ($word_details = $this->fetch_array($sql_select_words)) {
            foreach ($output as $key => $value) {
                $output[$key] = preg_replace("/{$word_details['word']}/i", GMSG_WORD_FILTER_REPLACEMENT, $value);
            }
        }

        return $output;
    }

    function wanted_offers_drop_down($box_name = 'auction_id', $user_id)
    {
        (string)$display_output = null;

        $sql_select_auctions = $this->query("SELECT auction_id, name FROM
			" . DB_PREFIX . "auctions WHERE owner_id='" . $user_id . "' AND active=1 AND closed=0 AND approved=1 AND list_in!='store' AND deleted=0");

        $is_auctions = $this->num_rows($sql_select_auctions);

        if ($is_auctions) {
            $display_output = '<select name="' . $box_name . '"> ';

            while ($item_details = $this->fetch_array($sql_select_auctions)) {
                $display_output .= '<option value="' . $item_details['auction_id'] . '">' . $item_details['name'] . '</option> ';
            }
            $display_output .= '</select> &nbsp; <input type="submit" name="form_offer_proceed" value="' . GMSG_PROCEED . '">';
        } else {
            $display_output = MSG_NO_ACTIVE_AUCTIONS;
        }

        return $display_output;
    }

    function force_index($column, $user = false)
    {
        ## auctions table only!
        switch ($column) {
            case 'a.auction_id':
                $output = ($user) ? 'mb_auctions_id' : 'browse_auctions_id';
                break;
            case 'a.end_time':
                $output = ($user) ? 'mb_auctions_id' : 'auctions_end_time';
                break;
            case 'a.start_time':
                $output = ($user) ? 'mb_auctions_id' : 'auctions_start_time';
                break;
            case 'a.nb_bids':
                $output = ($user) ? 'mb_auctions_id' : 'auctions_nb_bids';
                break;
            case 'a.name':
                $output = ($user) ? 'mb_auctions_id' : 'auctions_name';
                break;
            case 'a.start_price':
                $output = ($user) ? 'mb_auctions_id' : 'auctions_start_price';
                break;
            case 'a.max_bid':
                $output = ($user) ? 'mb_auctions_id' : 'auctions_max_bid';
                break;
        }
        $output = ($output) ? 'FORCE INDEX(' . $output . ')' : '';

        return $output;
    }

    function offer_range($item_details)
    {
        (string)$display_output = null;

        $this->fees = new fees_main();
        $this->fees->setts = $this->setts;

        if ($item_details['offer_min'] <= 0 && $item_details['offer_max'] <= 0) {
            $display_output = '<b>' . GMSG_ALL_OFFERS_ACCEPTED . '</b>';
        } else {
            $display_output = GMSG_FROM . ' <b>' . $this->fees->display_amount($item_details['offer_min'], $item_details['currency'], true) . '</b> ';

            if ($item_details['offer_max'] > 0) {
                $display_output .= GMSG_TO . ' <b>' . $this->fees->display_amount($item_details['offer_max'], $item_details['currency'], true) . '</b>';
            }
        }

        return $display_output;
    }

    function item_watch_text($auction_id)
    {
        $nb_users = $this->count_rows('auction_watch', "WHERE auction_id='" . intval($auction_id) . "'");

        return GMSG_ITEM_IS_WATCHED_BY . ' ' . $nb_users . ' ' . GMSG_USERS;
    }

    function apply_second_chance($win_details, $user_id)
    {
        $result = false;

        $minimum_timeframe = $win_details['purchase_date'] + ($this->setts['second_chance_days'] * 24 * 60 * 60);

        if ($this->setts['enable_second_chance'] && $win_details['auction_type'] == 'standard' &&
            (CURRENT_TIME >= $minimum_timeframe && $win_details['seller_id'] == $user_id && !$win_details['flag_paid'])
        ) {
            $result = true;
        }

        return $result;
    }
}

?>