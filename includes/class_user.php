<?php

#################################################################
## MyPHPAuction v6.04															##
##-------------------------------------------------------------##
## Copyright ©2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

  class user extends custom_field {

    var $item;

    function create_salt() {
      $rand = md5(rand(2, 99999999));
      $output = substr($rand, 0, 3);

      return $output;
    }

    function insert($user_details, $page_handle = 'register') {
      $salt = $this->create_salt();
      $password_hashed = password_hash($user_details['password'], $salt);

      $payment_mode = ($this->setts['account_mode_personal'] == 1) ? $this->setts['init_acc_type'] : $this->setts['account_mode'];
      $balance = ($payment_mode == 2) ? ((-1) * $this->setts['init_credit']) : 0;
      $max_credit = ($payment_mode == 2) ? $this->setts['max_credit'] : 0;

      $user_details = $this->rem_special_chars_array($user_details);

      $phone = '(' . $user_details['phone_a'] . ') ' . $user_details['phone_b'];

      if ($this->setts['birthdate_type'] == 1) {
        $birthdate = $user_details['birthdate_year'] . '-01-01'; // defaulted to jan 1st of the birthdate year.
        $birthdate_year = $user_details['birthdate_year'];
      }
      else {
        $birthdate = $user_details['dob_year'] . '-' . $user_details['dob_month'] . '-' . $user_details['dob_day'];
        $birthdate_year = $user_details['dob_year'];
      }

      $tax_apply_exempt = (!empty($user_details['tax_reg_number'])) ? 1 : 0;

      $sql_insert_user = $this->query("INSERT INTO " . DB_PREFIX . "users
			(username, password, email, reg_date, payment_mode, balance, max_credit,
			salt,	tax_account_type, tax_company_name, tax_reg_number, tax_apply_exempt, 
			name, address, city, country, state, zip_code, phone, birthdate, birthdate_year, newsletter,
			pg_paypal_email, pg_worldpay_id, pg_checkout_id, pg_nochex_email, 
			pg_ikobo_username, pg_ikobo_password, pg_protx_username, pg_protx_password, 
			pg_authnet_username, pg_authnet_password, pg_mb_email, pg_paymate_merchant_id, 
			pg_gc_merchant_id, pg_gc_merchant_key) VALUES
			('" . $user_details['username'] . "', '" . $password_hashed . "',	'" . $user_details['email'] . "',
			" . CURRENT_TIME . ", " . $payment_mode . ",	'" . $balance . "', '" . $max_credit . "',
			'" . $salt . "', '" . $user_details['tax_account_type'] . "', '" . $user_details['tax_company_name'] . "',
			'" . $user_details['tax_reg_number'] . "', '" . $tax_apply_exempt . "', '" . $user_details['name'] . "',
			'" . $user_details['address'] . "', '" . $user_details['city'] . "',
			'" . $user_details['country'] . "', '" . $user_details['state'] . "', '" . $user_details['zip_code'] . "',
			'" . $phone . "', '" . $birthdate . "', '" . $birthdate_year . "', '" . $user_details['newsletter'] . "', 
			'" . $user_details['pg_paypal_email'] . "', '" . $user_details['pg_worldpay_id'] . "', '" . $user_details['pg_checkout_id'] . "',
			'" . $user_details['pg_nochex_email'] . "', '" . $user_details['pg_ikobo_username'] . "',
			'" . $user_details['pg_ikobo_password'] . "', '" . $user_details['pg_protx_username'] . "',
			'" . $user_details['pg_protx_password'] . "', '" . $user_details['pg_authnet_username'] . "',
			'" . $user_details['pg_authnet_password'] . "', '" . $user_details['pg_mb_email'] . "', 
			'" . $user_details['pg_paymate_merchant_id'] . "', '" . $user_details['pg_gc_merchant_id'] . "', 
			'" . $user_details['pg_gc_merchant_key'] . "')");

      $user_id = $this->insert_id();

      if ($tax_apply_exempt && IN_ADMIN != 1) { ## if not in admin, notify admin of a tax exempt request.
        $mail_input_id = $user_id;
        include('language/' . $this->setts['site_lang'] . '/mails/tax_apply_exempt_notification.php');
      }

      $this->insert_page_data($user_id, $page_handle, $user_details);

      return $user_id;
    }

    function update($user_id, $user_details, $new_password = null, $page_handle = 'register', $admin_edit = false) {

      try {


        $user_details = $this->rem_special_chars_array($user_details);

        $sql_update_query = "UPDATE " . DB_PREFIX . "users SET
			name='" . $user_details['name'] . "', address='" . $user_details['address'] . "',
			city='" . $user_details['city'] . "', country='" . $user_details['country'] . "',
			state='" . $user_details['state'] . "', zip_code='" . $user_details['zip_code'] . "',
			phone='" . $user_details['phone'] . "', email='" . $user_details['email'] . "',
			tax_account_type='" . $user_details['tax_account_type'] . "',
			tax_company_name='" . $user_details['tax_company_name'] . "',
			tax_reg_number='" . $user_details['tax_reg_number'] . "', 
			newsletter='" . $user_details['newsletter'] . "',
			pg_paypal_email = '" . $user_details['pg_paypal_email'] . "',
			pg_worldpay_id = '" . $user_details['pg_worldpay_id'] . "',
			pg_checkout_id = '" . $user_details['pg_checkout_id'] . "',
			pg_nochex_email = '" . $user_details['pg_nochex_email'] . "',
			pg_ikobo_username = '" . $user_details['pg_ikobo_username'] . "',
			pg_ikobo_password = '" . $user_details['pg_ikobo_password'] . "',
			pg_protx_username = '" . $user_details['pg_protx_username'] . "',
			pg_protx_password = '" . $user_details['pg_protx_password'] . "',
			pg_authnet_username = '" . $user_details['pg_authnet_username'] . "',
			pg_authnet_password = '" . $user_details['pg_authnet_password'] . "', 
			pg_mb_email = '" . $user_details['pg_mb_email'] . "',
			pg_paymate_merchant_id = '" . $user_details['pg_paymate_merchant_id'] . "', 
			pg_gc_merchant_id = '" . $user_details['pg_gc_merchant_id'] . "', 
			pg_gc_merchant_key = '" . $user_details['pg_gc_merchant_key'] . "'";

        $user_old = $this->get_sql_row("SELECT balance, payment_mode, tax_apply_exempt FROM
			" . DB_PREFIX . "users WHERE user_id=" . $user_id);

        if (!$user_old['tax_apply_exempt'] && !empty($user_details['tax_reg_number'])) {
          $sql_update_query .= ", tax_apply_exempt=1";
        }

        if ($admin_edit) {
          $sql_update_query .= ", payment_mode='" . $user_details['payment_mode'] . "'";

          if ($user_old['payment_mode'] == 2) {
            $sql_update_query .= ", max_credit='" . $user_details['max_credit'] . "'";
            // We can change here the balance and max_credit values. If the balance is changed, we will also create a line in the invoices table
            $new_balance = $user_details['balance_type'] * $user_details['balance'];

            if ($user_old['balance'] != $new_balance) {
              $sql_update_query .= ", balance='" . $new_balance . "'";

              // now we create the invoice row
              $invoice_amount = $new_balance - $user_old['balance'];

              $fee_name = GMSG_ADMIN_CREDIT_ADJUSTMENT . ' [ ' . (($invoice_amount >= 0) ? GMSG_DEBIT : GMSG_CREDIT) . ' ]';

              $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices
						(user_id, name, amount, invoice_date, current_balance, live_fee, credit_adjustment) VALUES
						('" . $user_id . "', '" . $fee_name . "', '" . $invoice_amount . "',
						'" . CURRENT_TIME . "', '" . $new_balance . "', '1', '1')");
            }
          }
        }

        if ($new_password) {
          $salt = $this->create_salt();
          $password_hashed = password_hash($new_password, $salt);
          $sql_update_query .= ", password='" . $password_hashed . "', salt='" . $salt . "'";
        }

        $sql_update_query .= " WHERE user_id=" . $user_id;

        $sql_update_user = $this->query($sql_update_query);

        if (!$user_old['tax_apply_exempt'] && !empty($user_details['tax_reg_number']) && IN_ADMIN != 1) {
          $mail_input_id = $user_id;
          include('language/' . $this->setts['site_lang'] . '/mails/tax_apply_exempt_notification.php');
        }

        $this->update_page_data($user_id, $page_handle, $user_details);

        $this->beginTransaction();
        $this->commit();
      } catch (error $e) {
        $this->rollBack();
        echo $e;
      }
    }

    function delete($user_id, $page_handle = 'register') {
      ## delete user and all the related fields including custom fields
      $this->delete_data($user_id, $page_handle);

      $this->item = new item();
      $this->item->setts = $this->setts;

      ## now select all auctions that the user has listed
      $sql_select_auctions = $this->query("SELECT auction_id FROM " . DB_PREFIX . "auctions WHERE owner_id=" . $user_id);

      $delete_ids = null;

      while ($deleted_details = $this->fetch_array($sql_select_auctions)) {
        $delete_ids[] = $deleted_details['auction_id'];
      }

      $delete_array = $this->implode_array($delete_ids);

      ## delete all auctions the user has listed
      $this->item->delete($delete_array, 0, true, true);

      ## now select all wanted ads that the user has listed
      $sql_select_wanted_ads = $this->query("SELECT wanted_ad_id FROM " . DB_PREFIX . "wanted_ads WHERE owner_id=" . $user_id);

      $delete_ids = null;

      while ($deleted_details = $this->fetch_array($sql_select_wanted_ads)) {
        $delete_ids[] = $deleted_details['wanted_ad_id'];
      }

      $delete_array = $this->implode_array($delete_ids);

      ## delete all wanted ads the user has listed
      $this->item->delete_wanted_ad($delete_array, 0, true);

      ## delete the rest of the data
      $this->query("DELETE u, fs, i, ip, r  FROM " . DB_PREFIX . "users u 
			LEFT JOIN " . DB_PREFIX . "favourite_stores fs ON fs.user_id=u.user_id
			LEFT JOIN " . DB_PREFIX . "invoices i ON i.user_id=u.user_id
			LEFT JOIN " . DB_PREFIX . "iphistory ip ON ip.memberid=u.user_id
			LEFT JOIN " . DB_PREFIX . "reputation r ON r.user_id=u.user_id
		 	WHERE u.user_id=" . $user_id);
    }

    function account_status($active, $approved) {
      (string) $display_output = null;

      $display_output = ($approved) ? (($active) ? GMSG_ACTIVE : GMSG_SUSPENDED) : GMSG_NOT_APPROVED;

      return $display_output;
    }

    function payment_mode_desc($payment_mode) {
      (string) $display_output = null;

      $payment_mode = ($this->setts['account_mode_personal'] == 1) ? (($payment_mode) ? $payment_mode : 1) : $this->setts['account_mode'];

      switch ($payment_mode) {
        case 1:
          $display_output = GMSG_LIVE;
          break;
        case 2:
          $display_output = GMSG_ACCOUNT;
          break;
        default:
          $display_output = GMSG_NA;
      }

      return $display_output;
    }

    function show_balance($balance, $currency) {
      (string) $display_output = null;

      //format with currency
      $display_output = fees_main::display_amount(abs($balance), $currency, true) . ' ';
      
      $display_output .= ($balance > 0) ? GMSG_CREDIT : GMSG_DEBIT;
      
      return $display_output;
    }

    function user_manage_direct_payment_methods($user_details) {
      
    }

    function direct_payment_methods_edit($user_details) {
      (string) $display_output = null;

      $sql_select_pg = $this->query("SELECT pg_id, name, logo_url FROM
			" . DB_PREFIX . "payment_gateways WHERE dp_enabled=1");

      $background = 'c1';
      while ($pg_details = $this->fetch_array($sql_select_pg)) {
        switch ($pg_details['name']) {
          case 'PayPal':
            $display_output .= '<tr class="' . $background . '"> ' .
              '	<td>' . GMSG_PAYPAL_EMAIL . '</td> ' .
              '	<td><input name="pg_paypal_email" type="text" value="' . $user_details['pg_paypal_email'] . '" size="50"></td> ' .
              '</tr> ';
            $display_output .= '<tr> ' .
              '	<td></td> ' .
              '	<td class="' . $background . '">' . GMSG_PAYPAL_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_paypal.php</b></td> ' .
              '</tr> ';
            break;
          case 'Worldpay':
            $display_output .= '<tr class="' . $background . '"> ' .
              '	<td>' . GMSG_WORLDPAY_ID . '</td> ' .
              '	<td><input name="pg_worldpay_id" type="text" value="' . $user_details['pg_worldpay_id'] . '" size="50"></td> ' .
              '</tr> ';
            $display_output .= '<tr> ' .
              '	<td></td> ' .
              '	<td class="' . $background . '">' . GMSG_WORLDPAY_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_worldpay.php</b></td> ' .
              '</tr> ';
            break;
          case '2Checkout':
            $display_output .= '<tr class="' . $background . '"> ' .
              '	<td>' . GMSG_CHECKOUT_ID . '</td> ' .
              '	<td><input name="pg_checkout_id" type="text" value="' . $user_details['pg_checkout_id'] . '" size="50"></td> ' .
              '</tr> ';
            $display_output .= '<tr> ' .
              '	<td></td> ' .
              '	<td class="' . $background . '">' . GMSG_CHECKOUT_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_checkout.php</b></td> ' .
              '</tr> ';
            break;
          case 'Nochex':
            $display_output .= '<tr class="' . $background . '"> ' .
              '	<td>' . GMSG_NOCHEX_EMAIL . '</td> ' .
              '	<td><input name="pg_nochex_email" type="text" value="' . $user_details['pg_nochex_email'] . '" size="50"></td> ' .
              '</tr> ';
            $display_output .= '<tr> ' .
              '	<td></td> ' .
              '	<td class="' . $background . '">' . GMSG_NOCHEX_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_nochex.php</b></td> ' .
              '</tr> ';
            break;
          case 'Ikobo':
            $display_output .= '<tr class="' . $background . '"> ' .
              '	<td>' . GMSG_IKOBO_USERNAME . '</td> ' .
              '	<td><input name="pg_ikobo_username" type="text" value="' . $user_details['pg_ikobo_username'] . '" size="50"></td> ' .
              '</tr> ';
            $display_output .= '<tr class="' . $background . '"> ' .
              '	<td>' . GMSG_IKOBO_PASSWORD . '</td> ' .
              '	<td><input name="pg_ikobo_password" type="text" value="' . $user_details['pg_ikobo_password'] . '" size="50"></td> ' .
              '</tr> ';
            $display_output .= '<tr> ' .
              '	<td></td> ' .
              '	<td class="' . $background . '">' . GMSG_IKOBO_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_ikobo.php</b></td> ' .
              '</tr> ';
            break;
          case 'Protx':
            $display_output .= '<tr class="' . $background . '"> ' .
              '	<td>' . GMSG_PROTX_USERNAME . '</td> ' .
              '	<td><input name="pg_protx_username" type="text" value="' . $user_details['pg_protx_username'] . '" size="50"></td> ' .
              '</tr> ';
            $display_output .= '<tr class="' . $background . '"> ' .
              '	<td>' . GMSG_PROTX_PASSWORD . '</td> ' .
              '	<td><input name="pg_protx_password" type="text" value="' . $user_details['pg_protx_password'] . '" size="50"></td> ' .
              '</tr> ';
            $display_output .= '<tr> ' .
              '	<td></td> ' .
              '	<td class="' . $background . '">' . GMSG_PROTX_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_protx.php</b></td> ' .
              '</tr> ';
            break;
          case 'Authorize.net':
            $display_output .= '<tr class="' . $background . '"> ' .
              '	<td>' . GMSG_AUTHNET_USERNAME . '</td> ' .
              '	<td><input name="pg_authnet_username" type="text" value="' . $user_details['pg_authnet_username'] . '" size="50"></td> ' .
              '</tr> ';
            $display_output .= '<tr class="' . $background . '"> ' .
              '	<td>' . GMSG_AUTHNET_PASSWORD . '</td> ' .
              '	<td><input name="pg_authnet_password" type="text" value="' . $user_details['pg_authnet_password'] . '" size="50"></td> ' .
              '</tr> ';
            $display_output .= '<tr> ' .
              '	<td></td> ' .
              '	<td class="' . $background . '">' . GMSG_AUTHNET_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_authnet.php</b></td> ' .
              '</tr> ';
            break;
          case 'Moneybookers':
            $display_output .= '<tr class="' . $background . '"> ' .
              '	<td width="250">' . GMSG_MB_EMAIL . '</td> ' .
              '	<td><input name="pg_mb_email" type="text" value="' . $user_details['pg_mb_email'] . '" size="50"></td> ' .
              '</tr> ';
            $display_output .= '<tr> ' .
              '	<td></td> ' .
              '	<td class="' . $background . '">' . GMSG_MB_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_moneybookers.php</b></td> ' .
              '</tr> ';
            break;
          case 'Paymate':
            $display_output .= '<tr class="' . $background . '"> ' .
              '	<td width="250">' . GMSG_PAYMATE_MERCHANT_ID . '</td> ' .
              '	<td><input name="pg_paymate_merchant_id" type="text" value="' . $user_details['pg_paymate_merchant_id'] . '" size="50"></td> ' .
              '</tr> ';
            $display_output .= '<tr> ' .
              '	<td></td> ' .
              '	<td class="' . $background . '">' . GMSG_PAYMATE_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_paymate.php</b></td> ' .
              '</tr> ';
            break;
          case 'Google Checkout':
            $display_output .= '<tr class="' . $background . '"> ' .
              '	<td width="250">' . GMSG_GC_MERCHANT_ID . '</td> ' .
              '	<td><input name="pg_gc_merchant_id" type="text" value="' . $user_details['pg_gc_merchant_id'] . '" size="50"></td> ' .
              '</tr> ';
            $display_output .= '<tr class="' . $background . '"> ' .
              '	<td width="250">' . GMSG_GC_MERCHANT_KEY . '</td> ' .
              '	<td><input name="pg_gc_merchant_key" type="text" value="' . $user_details['pg_gc_merchant_key'] . '" size="50"></td> ' .
              '</tr> ';
            if ($user_details['user_id'] > 0) {
              $display_output .= '<tr> ' .
                '	<td></td> ' .
                '	<td class="' . $background . '">' . GMSG_GC_CALLBACK . ':<br><br><b>' . SITE_PATH . 'pp_gc.php?user_id=' . $user_details['user_id'] . '</b></td> ' .
                '</tr> ';
            }
            break;
        }
      }

      return $display_output;
    }

    function birthdate_box($variables_array) {
      (string) $display_output = null;

      $months_array = array('01' => GMSG_MTH_JANUARY, '02' => GMSG_MTH_FEBRUARY, '03' => GMSG_MTH_MARCH, '04' => GMSG_MTH_APRIL,
        '05' => GMSG_MTH_MAY, '06' => GMSG_MTH_JUNE, '07' => GMSG_MTH_JULY, '08' => GMSG_MTH_AUGUST,
        '09' => GMSG_MTH_SEPTEMBER, '10' => GMSG_MTH_OCTOBER, '11' => GMSG_MTH_NOVEMBER, '12' => GMSG_MTH_DECEMBER);

      $days_array = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12',
        '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24',
        '25', '26', '27', '28', '29', '30', '31');

      if ($this->setts['birthdate_type'] == 1) {
        $dob_text = MSG_YEAR_OF_BIRTH;
        $dob_expl = MSG_YEAR_OF_BIRTH_EXPL;

        $birthdate_box = '<input name="birthdate_year" type="text" id="birthdate_year" value="' . $variables_array['birthdate_year'] . '" size="8" maxlength="4" /> ';
      }
      else {
        $dob_text = MSG_DATE_OF_BIRTH;
        $dob_expl = MSG_DATE_OF_BIRTH_EXPL;

        $birthdate_box .= '<select name="dob_month" id="dob_month" class="contentfont"> ' .
          '<option> </option> ';
        foreach ($months_array as $key => $value) {
          $birthdate_box .= '<option value="' . $key . '" ' . (($key == $variables_array['dob_month']) ? 'selected' : '') . '>' . $value . '</option> ';
        }
        $birthdate_box .= '</select> ';

        $birthdate_box .= '<select name="dob_day" id="dob_day" class="contentfont"> ' .
          '<option> </option> ';
        foreach ($days_array as $value) {
          $birthdate_box .= '<option value="' . $value . '" ' . (($value == $variables_array['dob_day']) ? 'selected' : '') . '>' . $value . '</option> ';
        }
        $birthdate_box .= '</select> ';

        $birthdate_box .= '<input name="dob_year" type="text" id="dob_year" value="' . $variables_array['dob_year'] . '" size="8" maxlength="4" /> ';
      }

      $display_output = '<br /> ' .
        '<table width="100%" border="0" cellpadding="3" cellspacing="2" class="border"> ' .
        '	<tr class="c5"> ' .
        '		<td><img src="themes/' . $this->setts['default_theme'] . '/img/pixel.gif" width="1" height="1" /></td> ' .
        '		<td><img src="themes/' . $this->setts['default_theme'] . '/img/pixel.gif" width="1" height="1" /></td> ' .
        '	</tr> ' .
        '	<tr class="c1"> ' .
        '		<td width="150" align="right" class="contentfont">' . $dob_text . '</td> ' .
        '		<td class="contentfont">' . $birthdate_box . '</td> ' .
        '	</tr> ' .
        '	<tr class="reguser"> ' .
        '		<td>&nbsp;</td> ' .
        '		<td>' . $dob_expl . '</td> ' .
        '	</tr> ' .
        '</table> ';

      return $display_output;
    }

    function can_sell($is_seller) {
      $output = ($is_seller || $this->setts['enable_private_site'] == 0) ? true : false;

      return $output;
    }

    function full_address($user_details) {
      (string) $display_output = null;

      $state = ($user_details['state_name']) ? $user_details['state_name'] : $user_details['state'];
      // state_name and country_name are presumed to be taken from the countries table from the initial query.
      $display_output = $user_details['address'] . '<br>' .
        $user_details['zip_code'] . ', ' . $user_details['city'] . '<br>' .
        $state . ', ' . $user_details['country_name'];

      return $display_output;
    }

    function show_birthdate($user_details) {
      (string) $display_output = null;

      if ($this->setts['birthdate_type'] == 1) {
        $display_output = $user_details['birthdate_year'] . ' ' . GMSG_DOB_YEAR;
      }
      else {
        $display_output = $user_details['birthdate'] . ' ' . GMSG_DOB_FULL;
      }

      return $display_output;
    }

  }

?>