<?php


class fees extends tax
{

    var $fee = array();
    var $return_url = null;
    var $failure_url = null;
    var $process_url = null;
    var $edit_auction_id = 0; ## if we have a positive value, then the setup fees will be calculated accordingly.
    var $edit_user_id = 0; ## same as above, added for additional security
    var $setup_edit_calc = false;
    var $min_charged_image = 0; ## if there are more images uploaded than this, apply the picture upload fee
    var $min_charged_video = 0; ## if there are more videos uploaded than this, apply the video upload fee
    var $user_id = 0; ## required for protx and google checkout (its actually the id of the buyer)
    var $seller_id = 0; ## required for GC (0 = admin payment, >0 = direct payment to $seller_id)
    var $paypal_user_id = 0; ## used for paypal address override
    var $live_setup_fee = false; ## this will be used by fee_payment.php to charge image and video fees correctly.
    var $rollback_auction_id = 0;

    function fees()
    {
        $this->return_url = SITE_PATH . 'payment_completed.php';
        $this->failure_url = SITE_PATH . 'payment_failed.php';
    }

    ## assign variables that will be used in the class.

    function form_paypal($transaction_id, $paypal_email, $payment_amount, $currency, $payment_description = null, $direct_payment = false, $post_url = 'https://www.paypal.com/cgi-bin/webscr')
    {

        (string)$display_output = null;

        $payment_description = (!$payment_description) ? GMSG_SERVICE_ACTIVATION_FEE : $payment_description;

        $display_output = '<table width="100%" border="0" cellspacing="2" cellpadding="3" class="paymenttable"> ' .
            '<tr>' .
            '	<td width="160" class="paytable1"><img src="img/paypal_logo.gif"></td> ' .
            '		<form action="' . $post_url . '" method="post" id="form_paypal"> ' .
            '	<td class="paytable2" width="100%">' . GMSG_PAYPAL_DESCRIPTION . '</td> ' .
            '	<td class="paytable3"> ' .
            '		<input type="hidden" name="cmd" value="_xclick"> ' .
            '		<input type="hidden" name="bn" value="wa_dw_2.0.4"> ' .
            '		<input type="hidden" name="business" value="' . $paypal_email . '"> ' .
            '		<input type="hidden" name="receiver_email" value="' . $paypal_email . '"> ' .
            '		<input type="hidden" name="amount" value="' . $payment_amount . '"> ' .
            '		<input type="hidden" name="currency_code" value="' . $currency . '"> ' .
            '		<input type="hidden" name="return" value="' . $this->return_url . '"> ' .
            '		<input type="hidden" name="cancel_return" value="' . $this->failure_url . '"> ' .
            '		<input type="hidden" name="item_name" value="' . $payment_description . '"> ' .
            '		<input type="hidden" name="undefined_quantity" value="0"> ' .
            '		<input type="hidden" name="no_shipping" value="1"> ' .
            '		<input type="hidden" name="no_note" value="1"> ' .
            '		<input type="hidden" name="custom" value="' . $transaction_id . '"> ' .
            '		<input type="hidden" name="notify_url" value="' . $this->process_url . '"> ';

        $this->paypal_user_id = session::value('user_id');

        if ($this->paypal_user_id) {
            $user_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE
				user_id='" . $this->paypal_user_id . "'");

            if ($user_details['paypal_address_override']) {
                $display_output .= '<input type="hidden" name="address_override" value="' . $user_details['paypal_address_override'] . '"> ' .
                    '<input type="hidden" name="first_name" value="' . $user_details['paypal_first_name'] . '"> ' .
                    '<input type="hidden" name="last_name" value="' . $user_details['paypal_last_name'] . '"> ' .
                    '<input type="hidden" name="address1" value="' . $user_details['paypal_address1'] . '"> ' .
                    '<input type="hidden" name="address2" value="' . $user_details['paypal_address2'] . '"> ' .
                    '<input type="hidden" name="city" value="' . $user_details['paypal_city'] . '"> ' .
                    '<input type="hidden" name="state" value="' . $user_details['paypal_state'] . '"> ' .
                    '<input type="hidden" name="zip" value="' . $user_details['paypal_zip'] . '"> ' .
                    '<input type="hidden" name="country" value="' . $user_details['paypal_country'] . '"> ' .
                    '<input type="hidden" name="email" value="' . $user_details['email'] . '"> ' .
                    '<input type="hidden" name="night_phone_a" value="' . $user_details['paypal_night_phone_a'] . '"> ' .
                    '<input type="hidden" name="night_phone_b" value="' . $user_details['paypal_night_phone_b'] . '"> ' .
                    '<input type="hidden" name="night_phone_c" value="' . $user_details['paypal_night_phone_c'] . '"> ';
            }
        }

        $display_output .= '		<input name="submit" type="image" src="themes/' . $this->setts['default_theme'] . '/img/system/but_pay.gif" border="0"> ' .
            '	</td></form> ' .
            '</tr></table>';

        return $display_output;
    }

    ### moneybookers form

    function form_moneybookers($transaction_id, $mb_email, $payment_amount, $currency, $direct_payment = false, $payment_description = null, $post_url = 'https://www.moneybookers.com/app/payment.pl')
    {
        (string)$display_output = null;

        $mb_trans_id = md5(uniqid(rand()));
        ### this will be the new payment form design
        $display_output = '<table width="100%" border="0" cellspacing="2" cellpadding="3" class="paymenttable"> ' .
            '<tr>' .
            '	<td width="160" class="paytable1"><img src="img/mb_logo.gif"></td> ' .
            '		<form action="' . $post_url . '" method="post" id="form_mb"> ' .
            '	<td class="paytable2" width="100%">' . GMSG_MB_DESCRIPTION . '</td> ' .
            '	<td class="paytable3"> ' .
            '		<input type="hidden" name="pay_to_email" value="' . $mb_email . '"> 	' .
            //'		<input type="hidden" name="transaction_id" value="' . $mb_trans_id . '"> '.
            '		<input type="hidden" name="return_url" value="' . $this->return_url . '"> ' .
            '		<input type="hidden" name="cancel_url" value="' . $this->failure_url . '">	' .
            '		<input type="hidden" name="status_url" value="' . $this->process_url . '">	' .
            '		<input type="hidden" name="language" value="EN"> ' .
            '		<input type="hidden" name="merchant_fields" value="trans_id"> ' .
            '		<input type="hidden" name="amount" value="' . $payment_amount . '"> ' .
            '		<input type="hidden" name="currency" value="' . $currency . '"> ' .
            '		<input type="hidden" name="trans_id" value="' . $transaction_id . '"> ' .
            '		<input name="submit" type="image" src="themes/' . $this->setts['default_theme'] . '/img/system/but_pay.gif" border="0"> ' .
            '	</td></form>' .
            '</tr></table>';

        return $display_output;
    }

    ## nochex - localized for GBP payments only

    function form_nochex($transaction_id, $nochex_email, $payment_amount, $direct_payment = FALSE, $post_url = 'https://www.nochex.com/nochex.dll/checkout')
    {
        (string)$display_output = null;

        $transaction_code = md5(uniqid(mt_rand(), true));

        $display_output = '<table width="100%" border="0" cellspacing="2" cellpadding="3" class="paymenttable"> ' .
            '<tr>' .
            '	<td width="160" class="paytable1"><img src="img/nochex_logo.gif"></td> ' .
            '		<form action="' . $post_url . '" method="post" id="form_nochex"> ' .
            '	<td class="paytable2" width="100%">' . GMSG_NOCHEX_DESCRIPTION . '</td> ' .
            '	<td class="paytable3"> ' .
            '		<input type="hidden" name="returnurl" value="' . $this->return_url . '"> ' .
            '		<input type="hidden" name="cancelurl" value="' . $this->failure_url . '"> ' .
            '		<input type="hidden" name="email" value="' . $nochex_email . '"> ' .
            '		<input type="hidden" name="amount" value="' . $payment_amount . '"> ' .
            '		<input type="hidden" name="responderurl" value="' . $this->process_url . '"> ' .
            '		<input type="hidden" name="ordernumber" value="' . $transaction_id . 'TBL' . $transaction_code . '"> ' .
            '		<input name="submit" type="image" src="themes/' . $this->setts['default_theme'] . '/img/system/but_pay.gif" border="0"> ' .
            '	</td></form> ' .
            '</tr></table> ';

        return $display_output;
    }

    ## 2checkout - localized for USD payments only

    function form_checkout($transaction_id, $checkout_id, $payment_amount, $direct_payment = FALSE, $post_url = 'https://www2.2checkout.com/2co/buyer/purchase')
    {

        (string)$display_output = null;

        ## v1 LINK
        $co_link_v1 = 'https://www.2checkout.com/cgi-bin/sbuyers/cartpurchase.2c';
        ## v2 LINK
        $co_link_v2 = 'https://www2.2checkout.com/2co/buyer/purchase';

        $display_output = '<table width="100%" border="0" cellspacing="2" cellpadding="3" class="paymenttable"> ' .
            '<tr> ' .
            '	<td width="160" class="paytable1"><img src="img/checkout_logo.gif"></td> ' .
            '		<form action="' . $post_url . '" method="get" id="form_checkout"> ' .
            '	<td class="paytable2" width="100%">' . GMSG_CHECKOUT_DESCRIPTION . '</td>' .
            '	<td class="paytable3"> ' .
            '		<input type="hidden" name="sid" value="' . $checkout_id . '">	' .
            '		<input type="hidden" name="total" value="' . $payment_amount . '"> ' .
            '		<input type="hidden" name="cart_order_id" value="' . $transaction_id . '"> ' .
            '		<input type="hidden" name="c_prod" value="CO_' . $transaction_id . '"> ' .
            '		<input type="hidden" name="id_type" value="1"> ' .
            '		<input type="hidden" name="sh_cost" value="0"> ' .
            '		<input type="hidden" name="c_name" value="' . GMSG_SERVICE_ACTIVATION_FEE . '"> ' .
            '		<input type="hidden" name="c_description" value="' . GMSG_SERVICE_ACTIVATION_FEE . '"> ' .
            '		<input type="hidden" name="c_price" value="' . $payment_amount . '"> ' .
            '		<input type="hidden" name="c_tangible" value="N"> ' .
            '		<input name="submit" type="image" src="themes/' . $this->setts['default_theme'] . '/img/system/but_pay.gif" border="0"> ' .
            '	</td></form> ' .
            '</tr></table>';

        return $display_output;
    }

    function form_worldpay($transaction_id, $worldpay_id, $payment_amount, $currency, $direct_payment = FALSE, $post_url = 'https://select.worldpay.com/wcc/purchase')
    {

        (string)$display_output = null;

        $display_output = '<table width="100%" border="0" cellspacing="2" cellpadding="3" class="paymenttable"> ' .
            '<tr> ' .
            '	<td width="160" class="paytable1"><img src="img/worldpay_logo.gif"></td> ' .
            '		<form action="' . $post_url . '" method=POST id="form_worldpay"> ' .
            '	<td class="paytable2" width="100%">' . GMSG_WORLDPAY_DESCRIPTION . '</td>' .
            '	<td class="paytable3"> ' .
            '		<input type=hidden name="instId" value="' . $worldpay_id . '">	' .
            '		<input type=hidden name="cartId" value="' . $transaction_id . '"> ' .
            '		<input type=hidden name="amount" value="' . $payment_amount . '"> ' .
            '		<input type=hidden name="currency" value="' . $currency . '"> ' .
            '		<input type=hidden name="desc" value="' . GMSG_SERVICE_ACTIVATION_FEE . '"> ' .
            '		<input type=hidden name=MC_callback value="' . $this->process_url . '"> ' .
            '		<input name="submit" type="image" src="themes/' . $this->setts['default_theme'] . '/img/system/but_pay.gif" border="0"> ' .
            '	</td></form> ' .
            '</tr></table>';

        return $display_output;
    }

    ## ikobo - localized for USD payments only

    function form_ikobo($transaction_id, $ikobo_member_id, $ikobo_password, $payment_amount, $direct_payment = FALSE, $post_url = 'https://www.ikobo.com/store/index.php')
    {
        (string)$display_output = null;

        $transaction_id = $transaction_id . 'TBL' . md5(rand());

        $display_output = '<table width="100%" border="0" cellspacing="2" cellpadding="3" class="paymenttable"> ' .
            '<tr>' .
            '	<td width="160" class="paytable1"><img src="img/ikobo_logo.gif"></td>' .
            '		<form method="post" action="' . $post_url . '" id="form_ikobo"> ' .
            '	<td class="paytable2" width="100%">' . GMSG_IKOBO_DESCRIPTION . '</td> ' .
            '	<td class="paytable3"> ' .
            '		<input type="hidden" name="cmd" value="cart"> ' .
            '		<input type="hidden" name="item_id" value="' . $transaction_id . '"> ' .
            '		<input type="hidden" name="item" value="' . GMSG_SERVICE_ACTIVATION_FEE . '"> ' .
            '		<input type="hidden" name="price" value="' . $payment_amount . '"> ' .
            '		<input type="hidden" name="poid" value="' . $ikobo_member_id . '"> ' .
            '		<input name="submit" type="image" src="themes/' . $this->setts['default_theme'] . '/img/system/but_pay.gif" border="0"> ' .
            '	</td></form> ' .
            '</tr></table>';

        return $display_output;
    }

    function form_protx($transaction_id, $protx_username, $protx_password, $payment_amount, $currency, $direct_payment = false, $post_url = 'https://ukvps.protx.com/vps2form/submit.asp')
    {
        (string)$display_output = null;

        $transaction_code = substr(md5(uniqid(mt_rand(), true)), -8);

        $user_details = $this->get_sql_row("SELECT email, address, zip_code FROM " . DB_PREFIX . "users WHERE
			user_id='" . $this->user_id . "'"); ## user_id is provided from the payment functions
        ## the user details we will get later.
        $string = 'VendorTxCode=' . $transaction_id . 'TBL' . $transaction_code . '&' .
            'Amount=' . $payment_amount . '&' .
            'Currency=' . $currency . '&' .
            'Description=' . GMSG_SERVICE_ACTIVATION_FEE . '&' .
            'CustomerEmail=' . $user_details['email'] . '&' .
            'SuccessURL=' . $this->process_url . '&' .
            'FailureURL=' . $this->failure_url . '&' .
            'BillingAddress=' . $user_details['address'] . '&';
        $string .= 'BillingPostCode=' . $user_details['zip_code'] . '';

        $key_values = array();

        $password_length = strlen($protx_password);
        $string_length = strlen($string);

        for ($i = 0; $i < $password_length; $i++) {
            $key_values[$i] = ord(substr($protx_password, $i, 1));
        }

        (string)$secret_string = '';

        for ($i = 0; $i < $string_length; $i++) {
            $secret_string .= chr(ord(substr($string, $i, 1)) ^ ($key_values[$i % $password_length]));
        }

        $secret_string = base64_encode($secret_string);

        $display_output = '<table width="100%" border="0" cellspacing="2" cellpadding="3" class="paymenttable"> ' .
            '<tr>' .
            '	<td width="160" class="paytable1"><img src="img/protx_logo.gif"></td>' .
            '		<form method="post" action="' . $post_url . '" id="form_protx"> ' .
            '	<td class="paytable2" width="100%">' . GMSG_PROTX_DESCRIPTION . '</td>' .
            '	<td class="paytable3"> ' .
            '		<input type="hidden" name="cmd" value="cart"> ' .
            '		 <input type="hidden" name="VPSProtocol" value="2.22">			' .
            '		 <input type="hidden" name="TxType" value="PAYMENT">				' .
            '		 <input type="hidden" name="Vendor" value="' . $protx_username . '">' .
            '		 <input type="hidden" name="Crypt" value="' . $secret_string . '">	' .
            '		<input name="submit" type="image" src="themes/' . $this->setts['default_theme'] . '/img/system/but_pay.gif" border="0"> ' .
            '	</td></form> ' .
            '</tr></table>';

        return $display_output;
    }

    function form_testmode($transaction_id, $payment_amount)
    {
        (string)$display_output = null;

        $display_output .= '<table width="100%" border="0" cellspacing="2" cellpadding="3" class="paymenttable"> ' .
            '<tr> ' .
            '	<td width="160" class="paytable1"><img src="img/phpprosim_logo.gif"></td> ' .
            '		<form action="pp_testmode.php" method="post">	' .
            '	<td class="paytable2" width="100%">' . GMSG_TESTMODE_DESCRIPTION . '</td> ' .
            '	<td class="paytable3"> ' .
            '		<input type="hidden" name="amount" value="' . $payment_amount . '"> ' .
            '		<input type="hidden" name="custom" value="' . $transaction_id . '"> ' .
            '		<input name="submit" type="image" src="themes/' . $this->setts['default_theme'] . '/img/system/but_pay.gif" border="0"> ' .
            '	</td></form> ' .
            '</tr></table>';

        return $display_output;
    }

    ## BEGIN of Authorize.Net related functions

    function hmac($key, $data)
    {
        // RFC 2104 HMAC implementation for php.
        // Creates an md5 HMAC.
        // Eliminates the need to install mhash to compute a HMAC
        // Hacked by Lance Rushing

        $b = 64; // byte length for md5
        if (strlen($key) > $b) {
            $key = pack("H*", md5($key));
        }
        $key = str_pad($key, $b, chr(0x00));
        $ipad = str_pad('', $b, chr(0x36));
        $opad = str_pad('', $b, chr(0x5c));
        $k_ipad = $key ^ $ipad;
        $k_opad = $key ^ $opad;

        return md5($k_opad . pack("H*", md5($k_ipad . $data)));
    }

    // Calculate and return fingerprint
    // Use when you need control on the HTML output
    function CalculateFP($loginid, $x_tran_key, $amount, $sequence, $tstamp, $currency = "")
    {
        return ($this->hmac($x_tran_key, $loginid . "^" . $sequence . "^" . $tstamp . "^" . $amount . "^" . $currency));
    }

    // Inserts the hidden variables in the HTML FORM required for SIM
    // Invokes hmac function to calculate fingerprint.

    function InsertFP($loginid, $x_tran_key, $amount, $sequence, $currency = "")
    {

        $tstamp = time();

        $fingerprint = $this->hmac($x_tran_key, $loginid . "^" . $sequence . "^" . $tstamp . "^" . $amount . "^" . $currency);

        $output = '<input type="hidden" name="x_fp_sequence" value="' . $sequence . '"> ' .
            '<input type="hidden" name="x_fp_timestamp" value="' . $tstamp . '"> ' .
            '<input type="hidden" name="x_fp_hash" value="' . $fingerprint . '">';

        return $output;
    }

    /*

      // Inserts the hidden variables in the HTML FORM required for SIM
      // Invokes hmac function to calculate fingerprint.
      function InsertFP ($loginid, $x_tran_key, $amount, $sequence, $currency = "")
      {
      $tstamp = time();
      $fingerprint = $this->hmac ($x_tran_key, $loginid . "^" . $sequence . "^" . $tstamp . "^" . $amount . "^" . $currency);
      echo ('<input type="hidden" name="x_fp_sequence" value="' . $sequence . '">');
      echo ('<input type="hidden" name="x_fp_timestamp" value="' . $tstamp . '">');
      echo ('<input type="hidden" name="x_fp_hash" value="' . $fingerprint . '">');
      return (0);
      }
     */

    ## authorize.net -> localized for USD payments only.

    function form_authnet($transaction_id, $authnet_username, $authnet_password, $payment_amount, $direct_payment = false, $payment_description = null, $post_url = 'https://secure.authorize.net/gateway/transact.dll')
    {
        (string)$display_output = null;

        $TESTMODE = 0;
        ## UnComment this line out to enter Testing Mode!
        ## $TESTMODE = 1;

        $display_output = '<table width="100%" border="0" cellspacing="2" cellpadding="3" class="paymenttable"> ' .
            '<tr>' .
            '	<td width="160" class="paytable1"><img src="img/authorize_logo.gif"></td>';

        if ($TESTMODE) {
            $display_output .= '<form action="https://test.authorize.net/gateway/transact.dll" method="POST">';
        } else {
            $display_output .= '<form action="' . $post_url . '" method="post" id="form_authnet">';
        }
        $display_output .= '	<td class="paytable2" width="100%">' . GMSG_AUTHNET_DESCRIPTION;

        srand(time());
        $sequence = rand(1, 1000);
        $ret = $this->InsertFP($authnet_username, $authnet_password, $payment_amount, $sequence);

        $display_output .= '	</td>' .
            '	<td class="paytable3"> ' .
            '		<input type="hidden" name="x_description" value="' . $payment_description . '">' .
            '		<input type="hidden" name="x_login" value="' . $authnet_username . '">' .
            '		<input type="hidden" name="x_amount" value="' . $payment_amount . '">' .
            '		<input type="hidden" name="x_currency" value="' . $this->setts['currency'] . '">' .
            '		<input type="hidden" name="x_method" value="CC">' .
            '		<input type="hidden" name="x_type" value="AUTH_CAPTURE">' .
            '		<input type="hidden" name="x_show_form" value="PAYMENT_FORM">' .
            '		<input type="hidden" name="x_relay_response" value="TRUE">' .
            $ret .
            '		<input type="hidden" name="myphpauction_id" value="' . $transaction_id . '">';

        if ($TESTMODE) {
            $display_output .= '<input type="hidden" name="x_test_request" value="TRUE">';
        }

        $display_output .= '<input name="submit" type="image" src="themes/' . $this->setts['default_theme'] . '/img/system/but_pay.gif" border="0"> ' .
            '	</td></form> ' .
            '</tr></table>';

        return $display_output;
    }

    ## END of Authorize.Net related functions

    function form_paymate($transaction_id, $paymate_merchant_id, $payment_amount, $currency, $payment_description = null, $direct_payment = false, $post_url = 'https://www.paymate.com/PayMate/ExpressPayment')
    {

        (string)$display_output = null;

        $payment_description = (!$payment_description) ? GMSG_SERVICE_ACTIVATION_FEE : $payment_description;

        $display_output = '<table width="100%" border="0" cellspacing="2" cellpadding="3" class="paymenttable"> ' .
            '<tr>' .
            '	<td width="160" class="paytable1"><img src="img/paymate_logo.gif"></td> ' .
            '		<form action="' . $post_url . '" method="post" id="form_paymate"> ' .
            '	<td class="paytable2" width="100%">' . GMSG_PAYMATE_DESCRIPTION . '</td> ' .
            '	<td class="paytable3"> ' .
            '		<input type="hidden" name="mid" value="' . $paymate_merchant_id . '"> ' .
            '		<input type="hidden" name="amt" value="' . $payment_amount . '"> ' .
            '		<input type="hidden" name="amt_editable" value="N"> ' .
            '		<input type="hidden" name="currency" value="' . $currency . '"> ' .
            '		<input type="hidden" name="return" value="' . $this->process_url . '"> ' .
            '		<input type="hidden" name="ref" value="' . $transaction_id . '"> ' .
            '		<input type="hidden" name="popup" value="false"> ' .
            '		<input name="submit" type="image" src="themes/' . $this->setts['default_theme'] . '/img/system/but_pay.gif" border="0"> ' .
            '	</td></form> ' .
            '</tr></table>';

        return $display_output;
    }

    function form_google_checkout($transaction_id, $gc_merchant_id, $gc_merchant_key, $payment_amount, $currency, $payment_description = null, $direct_payment = false, $post_url = null)
    {
        (string)$display_output = null;

        $post_url = 'https://sandbox.google.com/checkout/api/checkout/v2/checkoutForm/Merchant/' . $gc_merchant_id; ## testing mode
        //$post_url = 'https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/' . $gc_merchant_id; ## live mode

        $payment_description = (!$payment_description) ? GMSG_SERVICE_ACTIVATION_FEE : $payment_description;

        $transaction_id .= 'TBL' . $this->user_id . 'TBL' . $this->seller_id;

        $display_output = '<table width="100%" border="0" cellspacing="2" cellpadding="3" class="paymenttable"> ' .
            '<tr>' .
            '	<td width="160" class="paytable1"><img src="img/google_checkout_logo.gif"></td> ' .
            '		<form action="' . $post_url . '" method="post" id="form_gc" accept-charset="utf-8"> ' .
            '	<td class="paytable2" width="100%">' . GMSG_GC_DESCRIPTION . '</td> ' .
            '	<td class="paytable3"> ' .
            '		<input type="hidden" name="item_name_1" value="' . $payment_description . '"> ' .
            '		<input type="hidden" name="item_description_1" value="' . $payment_description . ' - ' . $this->setts['sitename'] . '"> ' .
            '		<input type="hidden" name="item_price_1" value="' . $payment_amount . '"> ' .
            '		<input type="hidden" name="item_currency_1" value="' . $currency . '"> ' .
            '		<input type="hidden" name="item_quantity_1" value="1"> ' .
            '		<input type="hidden" name="item_merchant_id_1" value="' . $transaction_id . '"> ' .
            '		<input type="hidden" name="_charset_"> ' .
            '		<input name="submit" type="image" src="themes/' . $this->setts['default_theme'] . '/img/system/but_pay.gif" border="0"> ' .
            '	</td></form> ' .
            '</tr></table>';

        return $display_output;
    }

    ### this is the function that shows the text with the payment processors and the amount owed.

    function payment_message($payment_amount, $direct_payment = 0, $message = null, $tax_message = null)
    {
        (string)$display_output = null;

        if (!$message)
            $message = MSG_CLICK_ONE_PG_TO_ACTIVATE_YOUR_ACCOUNT;

        $display_output = '<table width=100% cellpadding=3 cellspacing=3 class="errormessage"> ' .
            '<tr> ' .
            '	<td align=center>' . MSG_SUPPORTED_GATEWAYS . '<br>';

        $dp_query = ($direct_payment) ? ' WHERE dp_enabled = 1 ' : ' WHERE checked = 1';

        $sql_select_payment_gateways = $this->query("SELECT name FROM " . DB_PREFIX . "payment_gateways " . $dp_query);

        while ($payment_gateway_details = $this->fetch_array($sql_select_payment_gateways)) {
            $display_output .= ' [ <font class="payactive">' . $payment_gateway_details['name'] . '</font> ] ';
        }

        $display_output .= '<br>' . $message . '<br><br><b> ' .
            MSG_PAY_A_FEE_OF . ' ' . $this->display_amount($payment_amount) . '</b>';

        if ($tax_message) {
            $display_output .= '<br>' . $tax_message;
        }

        if ($this->edit_auction_id) {
            $display_output .= '<tr><td align="center">' . MSG_LIVE_PM_EDIT_AUCTION_NOTE . '</td></tr>';
        }
        $display_output .= '</td></tr></table><br>';

        return $display_output;
    }

    function set_fees($user_id, $category_id = 0)
    {
        ## user id is needed in order to apply any fees reduction that might apply.
        $preferred_seller = $this->get_sql_field("SELECT preferred_seller FROM " . DB_PREFIX . "users WHERE
			user_id='" . $user_id . "'", 'preferred_seller');

        $category_id = ($category_id) ? $this->main_category($category_id) : 0;
        $custom_fee = $this->count_rows('categories', "WHERE category_id='" . $category_id . "' AND custom_fees='1'");
        $category_id = ($custom_fee > 0) ? $category_id : 0;

        $this->fee = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "fees WHERE category_id=" . $category_id);

        $this->min_charged_image = $this->fee['free_images'];
        $this->min_charged_video = $this->fee['free_media'];

        if ($preferred_seller && $this->setts['enable_pref_sellers']) {
            foreach ($this->fee as $key => $value) {
                if ($key == 'relist_fee_reduction') {
                    $this->fee[$key] = $this->round_number($value + ($value * ($this->setts['pref_sellers_reduction'] / 100)));
                } else {
                    $this->fee[$key] = $this->round_number($value - ($value * ($this->setts['pref_sellers_reduction'] / 100)));
                }
            }
        }

        ## we will also need to set the fees tiers but only when we will create the auction setup process
    }

    function show_gateways($transaction_id, $payment_amount, $currency, $user_id, $payment_description = null, $dp_gateways = null)
    {
        ## here, depending if there is a fee to be paid or a direct payment, we will show the necessary gateways in a table.
        ## if user_id is submitted, it means that there is a direct payment request.
        (string)$display_output = null;
        (string)$gateways_query = null;
        (array)$pg_details = null;

        $gateways_query = "SELECT * FROM " . DB_PREFIX . "payment_gateways";

        $transaction_id = ppb_mcrypt_encode($transaction_id);

        if (!$user_id) {
            $direct_payment = false;
            $gateways_query .= " WHERE checked=1";
        } else {
            $direct_payment = true;
            $pg_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE user_id=" . $user_id);
//        $gateways_query .= " WHERE dp_enabled=1";
            $gateways_query .= " WHERE checked=1";

            if (!empty($dp_gateways)) {
                $gateways_query .= " AND pg_id IN (" . $dp_gateways . ")";
            }
        }

        $sql_select_gateways = $this->query($gateways_query);

        $payment_description = substr(str_replace("&#039;", '', $payment_description), 0, 120);
        while ($gateway_details = $this->fetch_array($sql_select_gateways)) {
            if ($gateway_details['name'] == 'PayPal' /*&& (!$user_id || $pg_details['pg_paypal_email'])*/) {
                $paypal_email = ($user_id) ? $pg_details['pg_paypal_email'] : $this->setts['pg_paypal_email'];
                $this->process_url = SITE_PATH . 'pp_paypal.php';

                $display_output .= $this->form_paypal($transaction_id, $paypal_email, $payment_amount, $currency, $payment_description);

            }
            if ($gateway_details['name'] == 'Worldpay' && (!$user_id || $pg_details['pg_worldpay_id'])) {
                $worldpay_id = ($user_id) ? $pg_details['pg_worldpay_id'] : $this->setts['pg_worldpay_id'];
                $this->process_url = SITE_PATH . 'pp_worldpay.php';

                $display_output .= $this->form_worldpay($transaction_id, $worldpay_id, $payment_amount, $currency);
            }
            if ($gateway_details['name'] == '2Checkout' && (!$user_id || $pg_details['pg_checkout_id'])) {
                $checkout_id = ($user_id) ? $pg_details['pg_checkout_id'] : $this->setts['pg_checkout_id'];
                $this->process_url = SITE_PATH . 'pp_checkout.php';

                $display_output .= $this->form_checkout($transaction_id, $checkout_id, $payment_amount);
            }
            if ($gateway_details['name'] == 'Nochex' && (!$user_id || $pg_details['pg_nochex_email'])) {
                $nochex_email = ($user_id) ? $pg_details['pg_nochex_email'] : $this->setts['pg_nochex_email'];
                $this->process_url = SITE_PATH . 'pp_nochex.php';

                $display_output .= $this->form_nochex($transaction_id, $nochex_email, $payment_amount);
            }
            if ($gateway_details['name'] == 'Ikobo' && (!$user_id || $pg_details['pg_ikobo_username'])) {
                $ikobo_username = ($user_id) ? $pg_details['pg_ikobo_username'] : $this->setts['pg_ikobo_username'];
                $ikobo_password = ($user_id) ? $pg_details['pg_ikobo_password'] : $this->setts['pg_ikobo_password'];
                $this->process_url = SITE_PATH . 'pp_ikobo.php';

                $display_output .= $this->form_ikobo($transaction_id, $ikobo_username, $ikobo_password, $payment_amount);
            }
            if ($gateway_details['name'] == 'Protx' && (!$user_id || $pg_details['pg_protx_username'])) {
                $protx_username = ($user_id) ? $pg_details['pg_protx_username'] : $this->setts['pg_protx_username'];
                $protx_password = ($user_id) ? $pg_details['pg_protx_password'] : $this->setts['pg_protx_password'];
                $this->process_url = SITE_PATH . 'pp_protx.php';

                $display_output .= $this->form_protx($transaction_id, $protx_username, $protx_password, $payment_amount, $currency);
            }
            if ($gateway_details['name'] == 'Authorize.net' && (!$user_id || $pg_details['pg_authnet_username'])) {
                $authnet_username = ($user_id) ? $pg_details['pg_authnet_username'] : $this->setts['pg_authnet_username'];
                $authnet_password = ($user_id) ? $pg_details['pg_authnet_password'] : $this->setts['pg_authnet_password'];
                $this->process_url = SITE_PATH . 'pp_authnet.php';

                $display_output .= $this->form_authnet($transaction_id, $authnet_username, $authnet_password, $payment_amount, false, $payment_description);
            }
            if ($gateway_details['name'] == 'Moneybookers' && (!$user_id || $pg_details['pg_mb_email'])) {
                $mb_email = ($user_id) ? $pg_details['pg_mb_email'] : $this->setts['pg_mb_email'];
                $this->process_url = SITE_PATH . 'pp_moneybookers.php';

                $display_output .= $this->form_moneybookers($transaction_id, $mb_email, $payment_amount, $currency, false, $payment_description);
            }
            if ($gateway_details['name'] == 'Paymate' && (!$user_id || $pg_details['pg_paymate_merchant_id'])) {
                $paymate_merchant_id = ($user_id) ? $pg_details['pg_paymate_merchant_id'] : $this->setts['pg_paymate_merchant_id'];
                $this->process_url = SITE_PATH . 'pp_paymate.php';

                $display_output .= $this->form_paymate($transaction_id, $paymate_merchant_id, $payment_amount, $currency, $payment_description);
            }
            if ($gateway_details['name'] == 'Google Checkout' && (!$user_id || $pg_details['pg_gc_merchant_id'])) {
                $gc_merchant_id = ($user_id) ? $pg_details['pg_gc_merchant_id'] : $this->setts['pg_gc_merchant_id'];
                $gc_merchant_key = ($user_id) ? $pg_details['pg_gc_merchant_key'] : $this->setts['pg_gc_merchant_key'];
                $this->process_url = SITE_PATH . 'pp_gc.php';

                $display_output .= $this->form_google_checkout($transaction_id, $gc_merchant_id, $gc_merchant_key, $payment_amount, $currency, $payment_description);
            }
            if ($gateway_details['name'] == 'Test Mode') {
                $display_output .= $this->form_testmode($transaction_id, $payment_amount);
            }

            if ($gateway_details['name'] == 'nganluong') {
                $pgw = new paymentgateway($gateway_details['name']);
                $pgw->setts = $this->setts;


                $this->process_url = SITE_PATH . 'pp_nganluong.php';

                include(INCLUDE_DIR. 'gateways/nganluong.php');

                $nganluong = new nganluong('', $pgw->setts['pg_nganluong_username'], $pgw->setts['pg_nganluong_password'], '');
                //todo: add sandbox and live environment for nganluong
                $built_url = 'https://www.nganluong.vn/checkout.php';
                $built_url .= $nganluong->buildCheckoutUrl($this->process_url, $pgw->setts['pg_nganluong_email'], '', $transaction_id, $payment_amount);

                $display_output .= $pgw->form_nganluong($built_url);
            }
        }

        return $display_output;
    }

    ## callback function that will be used by all payment gateways

    function callback_process($custom_id, $fee_table, $payment_gateway, $payment_amount, $txn_id = null, $currency = null)
    {
        $custom_id = intval(ppb_mcrypt_decode($custom_id));
        $invoice_time = CURRENT_TIME;

        try {

//            $this->beginTransaction();


            if ($fee_table == 1) { ## signup process - alter 'users' table
                /**
                 * we will use this for user signup
                 * we will add a row on the invoices table no matter the account type
                 *
                 * the 'payment_status' field will be checked for the 'confirmed' status so that the
                 * signup fee is paid only once. this field will also be completed on registration so that if there is no
                 * signup fee at the moment and its added later, the user doesnt have to pay it if he was already registered.
                 */
                $payment_mode = $this->user_payment_mode($custom_id);
                $this->query("UPDATE " . DB_PREFIX . "users SET active=1, approved=1, payment_status='confirmed', mail_activated=1 WHERE user_id=" . $custom_id);

                //kiennguyen1101

                $invoice_name = GMSG_USER_SIGNUP_FEE;

                $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, name, amount, invoice_status, invoice_date, current_balance, live_fee, processor) VALUES ('{$custom_id}', {$invoice_name}, '{$payment_amount}', 'completed', '{$invoice_time}', '0', '1', {$payment_gateway})");

//        $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, name, amount, invoice_date, current_balance, live_fee, processor) VALUES ('" . $custom_id . "', '" . GMSG_USER_SIGNUP_FEE . "', '" . $payment_amount . "', '" . CURRENT_TIME . "', '0', '1', '" . $payment_gateway . "')");
//        
                ## include registration success email - with signup fee included
                $mail_input_id = $custom_id;
                include('language/' . $this->setts['site_lang'] . '/mails/register_success_signup_fee_user_notification.php');
            } else if ($fee_table == 2) { ## clear account balance - alter 'users' table
                $user_details = $this->get_sql_row("SELECT balance, active FROM
				" . DB_PREFIX . "users WHERE user_id=" . intval($custom_id));
                $account_balance = $user_details['balance'];

                if (!$user_details['active']) {
                    user_account_management($custom_id, 1);
                }

                $balance = ($payment_amount > 0) ? ($account_balance + $payment_amount) : 0;

                $invoice_amount = ($payment_amount > 0) ? $payment_amount : 0;

                $this->query("UPDATE " . DB_PREFIX . "users SET active=1, balance=" . $balance . " WHERE user_id=" . intval($custom_id));

                $invoice_name = GMSG_BALANCE_PAYMENT;

                $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, name, amount, invoice_status, invoice_date, current_balance, live_fee, processor) VALUES ('{$custom_id}', '{$invoice_name}', {$invoice_amount}, 'completed', '{$invoice_time}', '0', '1', '{$payment_gateway}')");

//        $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, name, amount, invoice_date, current_balance, live_fee, processor) VALUES ('" . $custom_id . "', '" . GMSG_BALANCE_PAYMENT . "', '" . $invoice_amount . "', '" . CURRENT_TIME . "', '0', '1', '" . $payment_gateway . "')");
            } else if ($fee_table == 3) { ## auction setup - live payment mode
                ## auctions counter - add process - single auction (activate auction - live payment)
                $cnt_details = $this->get_sql_row("SELECT auction_id, active, approved, closed, deleted, list_in, category_id, addl_category_id FROM
				" . DB_PREFIX . "auctions WHERE auction_id='" . $custom_id . "'");

                if ($cnt_details['active'] == 0 && $cnt_details['approved'] == 1 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0 && $cnt_details['list_in'] != 'store') {
                    auction_counter($cnt_details['category_id'], 'add', $cnt_details['auction_id']);
                    auction_counter($cnt_details['addl_category_id'], 'add', $cnt_details['auction_id']);
                }

                $sql_update_auction = $this->query("UPDATE " . DB_PREFIX . "auctions SET
				active=1, payment_status='confirmed', live_pm_amount='" . $payment_amount . "',
				live_pm_date='" . CURRENT_TIME . "', live_pm_processor='" . $payment_gateway . "' WHERE auction_id='" . $custom_id . "'");

                ## now add a live payment auction setup invoice (live_fee = 1)
                $user_id = $this->get_sql_field("SELECT owner_id FROM " . DB_PREFIX . "auctions WHERE auction_id='" . $custom_id . "'", 'owner_id');

                if ($user_id > 0) {
                    $invoice_name = GMSG_AUCTION_SETUP_FEE . ' - ' . MSG_AUCTION_ID . ': ' . $custom_id;

                    $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, item_id, name, amount, invoice_status, invoice_date, current_balance, live_fee, processor) VALUES ('{$user_id}', '{$custom_id}', '{$invoice_name}', '{$payment_amount}', 'auction_setup', '{$invoice_time}', '0', '1', '{$payment_gateway}')");

//          $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices (user_id, item_id, name, amount, invoice_date, current_balance, live_fee, processor) VALUES	('" . $user_id . "', '" . $custom_id . "', '" . $invoice_name . "',	'" . $payment_amount . "', '" . CURRENT_TIME . "', '0', '1', '" . $payment_gateway . "')");
                }
            } else if ($fee_table == 4) { ## sale fee - live payment mode
                $sql_update_winner = $this->query("UPDATE " . DB_PREFIX . "winners SET
				active=1, payment_status='confirmed', live_pm_amount='" . $payment_amount . "',
				live_pm_date='" . CURRENT_TIME . "', live_pm_processor='" . $payment_gateway . "' WHERE winner_id='" . $custom_id . "'");

                ## now add a live payment auction setup invoice (live_fee = 1)
                $winner_details = $this->get_sql_row("SELECT w.*, a.category_id FROM " . DB_PREFIX . "winners w
				LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=w.auction_id WHERE w.winner_id='" . $custom_id . "'");

                if ($winner_details['auction_id'] > 0) {
                    $this->set_fees($winner_details['seller_id'], $winner_details['category_id']);

                    $payer_id = (stristr($this->fee['endauction_fee_applies'], 'b')) ? $winner_details['buyer_id'] : $winner_details['seller_id'];

                    $invoice_name = GMSG_ENDAUCTION_FEE . ' - ' . MSG_AUCTION_ID . ': ' . $winner_details['auction_id'];

                    $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, item_id, name, amount, invoice_status, invoice_date, current_balance, live_fee, processor) VALUES ('{$payer_id}', '{$winner_details['auction_id']}', '{$invoice_name}', '{$payment_amount}', 'auction_end', '{$invoice_time}', '0', '1', '{$payment_gateway}')");

//          $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, item_id, name, amount, invoice_date, current_balance, live_fee, processor) VALUES ('" . $payer_id . "', '" . $winner_details['auction_id'] . "', '" . $invoice_name . "',	'" . $payment_amount . "', '" . CURRENT_TIME . "', '0', '1', '" . $payment_gateway . "')");
                }
            } else if ($fee_table == 5) { ## wanted ad setup fee - live payment mode
                ## wanted counter - add process
                $cnt_details = $this->get_sql_row("SELECT wanted_ad_id, active, closed, deleted, category_id, addl_category_id FROM
				" . DB_PREFIX . "wanted_ads WHERE wanted_ad_id='" . $custom_id . "'");

                if ($cnt_details['active'] == 0 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0) {
                    wanted_counter($cnt_details['category_id'], 'add');
                    wanted_counter($cnt_details['addl_category_id'], 'add');
                }

                $sql_update_wanted_ad = $this->query("UPDATE " . DB_PREFIX . "wanted_ads SET
				active=1, payment_status='confirmed', live_pm_amount='" . $payment_amount . "',
				live_pm_date='" . CURRENT_TIME . "', live_pm_processor='" . $payment_gateway . "' WHERE wanted_ad_id='" . $custom_id . "'");

                ## now add a live payment auction setup invoice (live_fee = 1)
                $user_id = $this->get_sql_field("SELECT owner_id FROM " . DB_PREFIX . "wanted_ads WHERE wanted_ad_id='" . $custom_id . "'", 'owner_id');

                if ($user_id > 0) {
                    $invoice_name = GMSG_WA_SETUP_FEE . ' - ' . MSG_WANTED_AD_ID . ': ' . $custom_id;

                    $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, wanted_ad_id, name, amount, invoice_status, invoice_date, current_balance, live_fee, processor) VALUES ('{$user_id}', '{$custom_id}', '{$invoice_name}', '{$payment_amount}', 'completed', '{$invoice_time}', '0', '1', '$payment_gateway')");

//          $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, wanted_ad_id, name, amount, invoice_date, current_balance, live_fee, processor) VALUES ('" . $user_id . "', '" . $custom_id . "', '" . $invoice_name . "', '" . $payment_amount . "', '" . CURRENT_TIME . "', '0', '1', '" . $payment_gateway . "')");
                }
            } else if ($fee_table == 6) { ## seller verification fee - alter 'users' table
                $user_details = $this->get_sql_row("SELECT f.*, u.seller_verif_next_payment FROM " . DB_PREFIX . "fees f, " . DB_PREFIX . "users u WHERE
				u.user_id='" . $custom_id . "' AND f.category_id=0");

                $seller_verif_last_payment = ($user_details['seller_verif_next_payment'] < CURRENT_TIME) ? CURRENT_TIME : $user_details['seller_verif_next_payment'];
                $seller_verif_next_payment = ($user_details['verification_recurring'] > 0) ? ($seller_verif_last_payment + ($user_details['verification_recurring'] * 24 * 60 * 60)) : 0;
                $invoice_name = GMSG_SELLER_VERIFICATION_PAYMENT;

                $this->query("UPDATE " . DB_PREFIX . "users SET seller_verified=1, seller_verif_last_payment='" . CURRENT_TIME . "',
				seller_verif_next_payment='" . $seller_verif_next_payment . "' WHERE user_id=" . $custom_id);

                $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, name, amount, invoice_status, invoice_date, current_balance, live_fee, processor) VALUES ('{$custom_id}', '{$invoice_name}', '{$payment_amount}', 'completed', '{$invoice_time}', '0', '1', '$payment_gateway')");

//        $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, name, amount, invoice_date, current_balance, live_fee, processor) VALUES ('" . $custom_id . "', '" . $invoice_name . "', '" . $payment_amount . "',	'" . CURRENT_TIME . "', '0', '1', '" . $payment_gateway . "')");
            } else if ($fee_table == 10) { ## store subscription process - alter 'users' table
                $shop_details = $this->get_sql_row("SELECT f.*, u.shop_next_payment FROM " . DB_PREFIX . "fees_tiers f, " . DB_PREFIX . "users u WHERE
				u.user_id='" . $custom_id . "' AND u.shop_account_id=f.tier_id");

                $shop_last_payment = ($shop_details['shop_next_payment'] < CURRENT_TIME) ? CURRENT_TIME : $shop_details['shop_next_payment'];
                $shop_next_payment = ($shop_details['store_recurring'] > 0) ? ($shop_last_payment + ($shop_details['store_recurring'] * 24 * 60 * 60)) : 0;
                $invoice_name = GMSG_STORE_SUBSCRIPTION_PAYMENT . ' - ' . $shop_details['store_name'];

                $this->query("UPDATE " . DB_PREFIX . "users SET shop_active=1, shop_last_payment='" . CURRENT_TIME . "',
				shop_next_payment='" . $shop_next_payment . "' WHERE user_id=" . $custom_id);

                $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, name, amount, invoice_status, invoice_date, current_balance, live_fee, processor) VALUES ('{$custom_id}', '{$invoice_name}', '{$payment_amount}', 'completed', '{$invoice_time}', '0', '1', '$payment_gateway')");

//        $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices (user_id, name, amount, invoice_date, current_balance, live_fee, processor) VALUES ('" . $custom_id . "', '" . $invoice_name . "', '" . $payment_amount . "',	'" . CURRENT_TIME . "', '0', '1', '" . $payment_gateway . "')");
            } /* Payment: Auction sold single item */
            else if ($fee_table == 50) {

                //we deal with all the fees the seller is pending
                //get winner details from winners table
                $winner_details = $this->get_sql_row("SELECT w.*, a.category_id FROM " . DB_PREFIX . "winners w LEFT JOIN " . DB_PREFIX . "auctions a ON a.auction_id=w.auction_id WHERE w.winner_id='" . $custom_id . "'");

                if ($winner_details['auction_id'] > 0) {
                    $this->set_fees($winner_details['seller_id'], $winner_details['category_id']);

                    $payer_id = (stristr($this->fee['endauction_fee_applies'], 'b')) ? $winner_details['buyer_id'] : $winner_details['seller_id'];

                    $invoice_name = GMSG_ENDAUCTION_FEE . ' - ' . MSG_AUCTION_ID . ': ' . $winner_details['auction_id'];

                    $invoices = new invoice();

                    //get unpaid invoices
                    $unpaid_invoices = $invoices->getItemInvoicesByState('pending', $winner_details['auction_id']);

                    $amount = 0;

                    //loop and update invoices since the payment has been confirmed
                    if (is_array($unpaid_invoices)) {
                        foreach ($unpaid_invoices as $data) {
                            $invoice = new invoice();
                            $invoice->data = $data;
                            $amount += $data['amount'];
                            $invoice->data['invoice_status'] = 'completed';
                            $invoice->update();
                        }
                    }

                    $user_details = $this->get_sql_row("SELECT balance, active FROM	" . DB_PREFIX . "users WHERE user_id=" . intval($winner_details['seller_id']));

                    //origin balance
                    $account_balance = (float)$user_details['balance'];
                    //minus unpaid invoices
                    $account_balance -= $amount;
                    //add payment by buyer
                    $account_balance += $payment_amount;

                    $this->query("UPDATE " . DB_PREFIX . "users SET active=1, balance={$account_balance} WHERE user_id=" . intval($winner_details['seller_id']));
                    //add the final invoice: end of auction
                    $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, item_id, name, amount, invoice_status, invoice_date, current_balance, live_fee, processor) VALUES ('{$payer_id}', '{$winner_details['auction_id']}', '{$invoice_name}', '{$payment_amount}', 'completed', '{$invoice_time}', '{$account_balance}', '1', '{$payment_gateway}')");

                    //update the winner: confirm the payment, flag_paid, flag_status
                    //note: payment_status: 'confirmed' or ''. If empty, the winner hasn't paid for the item and must undergo the payment process
                    //flag_paid: if 0: no payment has been registered for the item.
                    //flag_status: 0: in process. 1: done.
                    $sql_update_winner = $this->query("UPDATE " . DB_PREFIX . "winners SET flag_paid=1, payment_status='confirmed', flag_status=1 WHERE winner_id='{$custom_id}'");
                    //or maybe, we just have to substract the amount from buyer's account instead of going through another process.


                }
            } else if ($fee_table == 100) { ## direct payment - multiple items
                $sql_update_winner = $this->query("UPDATE " . DB_PREFIX . "winners SET flag_paid=1, direct_payment_paid=1 WHERE winner_id IN (" . $custom_id . ")");
            }

//            $this->commit();
            return true;
        } catch (error $e) {
            //$this->rollBack();
            error::dump_exception($e);
            return false;
        }
    }

    function validate_transaction()
    {
        ## this function will check whether the callback has been done from the same document root to avoid fraudulent payments.
    }

    function display_fee($fee_name, $user_details, $category_id, $list_in, $voucher_details = null, $apply_tax = true)
    { // <- this function needs complete redesign
        $output = array('amount' => 0, 'display' => null);

        $category_id = ($category_id) ? $this->main_category($category_id) : 0;
        $custom_fee = $this->count_rows('categories', "WHERE category_id='" . $category_id . "' AND custom_fees='1'");
        $category_id = ($custom_fee > 0) ? $category_id : 0;

        if ($list_in != 'store') /* if item isnt listed in store then apply the fee */ {
            $reduction_applied = false;
            $fee_value = $this->get_sql_field("SELECT " . $fee_name . " FROM " . DB_PREFIX . "fees WHERE category_id=" . $category_id, $fee_name);

            if ($user_details['preferred_seller'] && $this->setts['enable_pref_sellers']) {
                $reduction_applied = true;
                $fee_value = $this->round_number($fee_value - ($fee_value * $this->setts['pref_sellers_reduction'] / 100));
                $fee_display[] = $this->setts['pref_sellers_reduction'] . '% ' . GMSG_PREF_SELLERS_REDUCTION;
            }

            if ($voucher_details['reduction'] > 0) {
                $assigned_fees = explode(',', $voucher_details['assigned_fees']);
                if (in_array('all', $assigned_fees) || in_array($fee_name, $assigned_fees) || $voucher_details['voucher_type'] == 'signup') {
                    $reduction_applied = true;
                    $fee_value = $this->round_number($fee_value - ($fee_value * $voucher_details['reduction'] / 100));
                    $fee_display[] = $voucher_details['reduction'] . '% ' . GMSG_VOUCHER_REDUCTION;
                }
            }

            /* now apply tax to the value */
            if ($apply_tax) {
                $fee_output = $this->apply_tax($fee_value, $this->setts['currency'], $user_details['user_id'], $this->setts['enable_tax']);
            } else {
                $fee_output['amount'] = $fee_value;
            }
        }

        /**
         * now for the edit auction part.
         * basically if we had the feature as checked already and the fee for old cat >= fee for new cat, we wont charge anything.
         * otherwise we will charge normally.
         */
        $output['amount'] = $fee_output['amount'];
        $output['display'] = $this->display_amount($output['amount'], $this->setts['currency'], 0);

        if ($reduction_applied) {
            $output['display'] .= ' [ ' . $this->implode_array($fee_display, ' ' . GMSG_AND . ' ') . ' ]';
        }

        return $output;
    }

    function display_fee_tiers($fee_name, $user_details, $category_id, $list_in, $amount = null, $voucher_details = null, $apply_tax = true, $currency = null)
    { // <- this function needs complete redesign
        (array)$fee_output = null;
        (int)$counter = 0;

        $category_id = ($category_id) ? $this->main_category($category_id) : 0;
        $custom_fee = $this->count_rows('categories', "WHERE category_id='" . $category_id . "' AND custom_fees='1'");
        $category_id = ($custom_fee > 0) ? $category_id : 0;

        if ($amount && $currency) {
            if ($currency != $this->setts['currency']) {
                $exchange_rate = $this->get_sql_field("SELECT convert_rate FROM " . DB_PREFIX . "currencies WHERE
					symbol='" . $currency . "'", 'convert_rate');

                $exchange_rate = ($exchange_rate > 0) ? $exchange_rate : 1;
                $amount = $amount / $exchange_rate;
            }
        }

        if ($list_in != 'store') /* if item isnt listed in store then apply the fee */ {
            $addl_query = ($amount) ? " AND fee_from<'" . $amount . "' AND fee_to>='" . $amount . "' " : '';

            $sql_select_fees = $this->query("SELECT * FROM " . DB_PREFIX . "fees_tiers WHERE
				category_id=" . $category_id . " AND fee_type='" . $fee_name . "' " . $addl_query);

            $nb_fees = $this->num_rows($sql_select_fees);

            while ($fee_tier = $this->fetch_array($sql_select_fees)) { // <- this will be used in case we wish to display a table with all fees.
                $reduction_applied = false;
                $fee_display = array();
                $fee_value = $fee_tier['fee_amount'];

                if ($user_details['preferred_seller'] && $this->setts['enable_pref_sellers']) {
                    $reduction_applied = true;
                    $fee_value = $this->round_number($fee_value - ($fee_value * $this->setts['pref_sellers_reduction'] / 100));
                    $fee_display[] = $this->setts['pref_sellers_reduction'] . '% ' . GMSG_PREF_SELLERS_REDUCTION;
                }

                if ($voucher_details['reduction'] > 0) {
                    $assigned_fees = explode(',', $voucher_details['assigned_fees']);
                    if (in_array('all', $assigned_fees) || in_array($fee_name, $assigned_fees) || $voucher_details['voucher_type'] == 'signup') {
                        $reduction_applied = true;
                        $fee_value = $this->round_number($fee_value - ($fee_value * $voucher_details['reduction'] / 100));
                        $fee_display[] = $voucher_details['reduction'] . '% ' . GMSG_VOUCHER_REDUCTION;
                    }
                }

                if ($apply_tax) {
                    $tax_fee = $this->apply_tax($fee_value, $this->setts['currency'], $user_details['user_id'], $this->setts['enable_tax']);
                } else {
                    $tax_fee['amount'] = $fee_value;
                }

                $fee_output[$counter]['calc_type'] = $fee_tier['calc_type'];
                $fee_output[$counter]['amount'] = $tax_fee['amount'];

                if ($reduction_applied && $nb_fees == 1) {
                    $fee_output[$counter]['display'] .= ' [ ' . $this->implode_array($fee_display, ' ' . GMSG_AND . ' ') . ' ]';
                }

                $counter++;
            }

            // if we have an amount then we give the calculation directly. <- this is the one used when calculating an item fee!!
            if ($counter == 1 && $fee_output[0]['calc_type'] == 'percent') {
                $fee_output[0]['calc_type'] = 'flat';
                $fee_output[0]['amount'] = $this->round_number($amount * $fee_output[0]['amount'] / 100);
            }

            /**
             * now in case we have an auction edit, charge a difference of fees (if > 0)
             * (v6.05) also, if we have a payment fee for an edited item in live mode, only calculate the difference of fees.
             */
            if (($this->rollback_auction_id || ($this->edit_auction_id && $this->edit_user_id)) && !$this->setup_edit_calc) {
                if ($this->rollback_auction_id) {
                    $old_item = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "auction_rollbacks WHERE
		   			auction_id='" . $this->rollback_auction_id . "'");
                    $old_item['list_in'] = 'auction';
                } else {
                    $old_item = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "auctions WHERE
		   			auction_id='" . $this->edit_auction_id . "' AND owner_id='" . $this->edit_user_id . "'");
                }

                if ($old_item['auction_id'] > 0) {
                    $this->setup_edit_calc = true;
                    $old_fee = $this->display_fee_tiers('setup', $user_details, $old_item['category_id'], $old_item['list_in'], $old_item['start_price'], null, $apply_tax);
                    $this->setup_edit_calc = false;

                    $fee_difference = $fee_output[0]['amount'] - $old_fee[0]['amount'];
                    $fee_output[0]['amount'] = ($fee_difference > 0) ? $fee_difference : 0;
                }
            }
        }

        return $fee_output;
    }

    function fees_no_tier_array($item_details)
    {
        (array)$output = null;

        /**
         * if $this->edit_auction_id > 0 then the fees will be applied based on the old item_details row as well.
         */
        $this->set_fees(null, $item_details['category_id']);

        if ($this->edit_auction_id && $this->edit_user_id) {
            $old_item = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "auctions WHERE
   			auction_id='" . $this->edit_auction_id . "' AND owner_id='" . $this->edit_user_id . "'");

            $nb_images = $this->count_rows('auction_media', "WHERE auction_id='" . $this->edit_auction_id . "' AND media_type=1 AND upload_in_progress=0");
            $nb_videos = $this->count_rows('auction_media', "WHERE auction_id='" . $this->edit_auction_id . "' AND media_type=2 AND upload_in_progress=0");

            /**
             * 6.03 modification - if the main category is changed, and they have different custom fees, charge the fees again
             */
            $new_category = false;
            if ($old_item['category_id'] != $item_details['category_id']) {
                $old_main_category = $this->main_category($old_item['category_id']);
                $new_main_category = $this->main_category($item_details['category_id']);

                if ($old_main_category != $new_main_category) {
                    $old_cat_custom_fee = $this->get_sql_field("SELECT custom_fees FROM " . DB_PREFIX . "categories WHERE
   					category_id='" . $old_main_category . "'", 'custom_fees');

                    $new_cat_custom_fee = $this->get_sql_field("SELECT custom_fees FROM " . DB_PREFIX . "categories WHERE
   					category_id='" . $new_main_category . "'", 'custom_fees');

                    if ($old_cat_custom_fee || $new_cat_custom_fee) {
                        $new_category = true;
                    }
                }
            }

            $new_images_counter = item::count_contents($item_details['ad_image']);
            $new_videos_counter = item::count_contents($item_details['ad_video']);

            //$picture_fee = ($this->min_charged_image >= $nb_images && $nb_images <  || $new_category) ? item::count_contents($item_details['ad_image']) : 0;
            $picture_fee = (($this->min_charged_image < $new_images_counter && $new_images_counter > $nb_images && $nb_images <= $this->min_charged_image) || $new_category) ? item::count_contents($item_details['ad_image']) : 0;
            $hlitem_fee = (!$old_item['hl'] && $item_details['hl'] || $new_category) ? 1 : 0;
            $bolditem_fee = (!$old_item['bold'] && $item_details['bold'] || $new_category) ? 1 : 0;
            $hpfeat_fee = (!$old_item['hpfeat'] && $item_details['hpfeat'] || $new_category) ? 1 : 0;
            $catfeat_fee = (!$old_item['catfeat'] && $item_details['catfeat'] || $new_category) ? 1 : 0;
            $rp_fee = ($old_item['reserve_price'] == 0 && $item_details['reserve_price'] > 0 || $new_category) ? 1 : 0;
            $second_cat_fee = (!$old_item['addl_category_id'] && $item_details['addl_category_id'] || $new_category) ? 1 : 0;
            $buyout_fee = ($old_item['buyout_price'] == 0 && $item_details['buyout_price'] > 0 || $new_category) ? 1 : 0;
            $custom_start_fee = ($item_details['start_time_type'] == 'custom' && $new_category) ? 1 : 0; ## this is always 0 since if u can choose a custom start time on edit then it means it was already paid for
            $video_fee = (($this->min_charged_video < $new_videos_counter && $new_videos_counter > $nb_videos && $nb_videos <= $this->min_charged_video) || $new_category) ? item::count_contents($item_details['ad_video']) : 0;
            $makeoffer_fee = (!$old_item['is_offer'] && $item_details['is_offer'] || $new_category) ? 1 : 0;
        } else {
            $old_item = array('auction_id' => 0, 'start_price' => 0, 'reserve_price' => 0,
                'buyout_price' => 0, 'category_id' => 0, 'active' => 0, 'payment_status' => null,
                'hpfeat' => 0, 'catfeat' => 0, 'bold' => 0, 'hl' => 0, 'addl_category_id' => 0,
                'balance' => 0, 'nb_images' => 0, 'nb_videos' => 0);

            if ($this->live_setup_fee) {
                $old_item = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "auction_rollbacks WHERE auction_id='" . $item_details['auction_id'] . "'");


                if ($old_item['auction_id']) {
                    $nb_images = $old_item['nb_images'];
                    $nb_videos = $old_item['nb_videos'];

                    $new_images_counter = $this->count_rows('auction_media', "WHERE auction_id='" . $item_details['auction_id'] . "' AND media_type=1 AND upload_in_progress=0");
                    $new_videos_counter = $this->count_rows('auction_media', "WHERE auction_id='" . $item_details['auction_id'] . "' AND media_type=2 AND upload_in_progress=0");
                }
            } else {
                $nb_images = item::count_contents($item_details['ad_image']);
                $nb_videos = item::count_contents($item_details['ad_video']);
            }

            /**
             * 6.03 modification - if the main category is changed, and they have different custom fees, charge the fees again
             */
            $new_category = false;
            if ($old_item['category_id'] != $item_details['category_id']) {
                $old_main_category = $this->main_category($old_item['category_id']);
                $new_main_category = $this->main_category($item_details['category_id']);

                if ($old_main_category != $new_main_category) {
                    $old_cat_custom_fee = $this->get_sql_field("SELECT custom_fees FROM " . DB_PREFIX . "categories WHERE
   					category_id='" . $old_main_category . "'", 'custom_fees');

                    $new_cat_custom_fee = $this->get_sql_field("SELECT custom_fees FROM " . DB_PREFIX . "categories WHERE
   					category_id='" . $new_main_category . "'", 'custom_fees');

                    if ($old_cat_custom_fee || $new_cat_custom_fee) {
                        $new_category = true;
                    }
                }
            }

            /*
              $picture_fee = ($this->min_charged_image >= $nb_images) ? 0 : $nb_images;
              $hlitem_fee = $item_details['hl'];
              $bolditem_fee = $item_details['bold'];
              $hpfeat_fee = $item_details['hpfeat'];
              $catfeat_fee = $item_details['catfeat'];
              $rp_fee = ($item_details['reserve_price'] > 0) ? 1 : 0;
              $second_cat_fee = ($item_details['addl_category_id']) ? 1 : 0;
              $buyout_fee = ($item_details['buyout_price'] > 0) ? 1 : 0;
              $custom_start_fee = ($item_details['start_time_type'] != 'now') ? 1 : 0;
              $video_fee = ($this->min_charged_video >= $nb_videos) ? 0 : $nb_videos;
              $makeoffer_fee = $item_details['is_offer'];
             */
            if ($old_item['auction_id']) {
                echo $new_images_counter . ' ' . $nb_images;
                $picture_fee = (($this->min_charged_image < $new_images_counter && $new_images_counter > $nb_images && $nb_images <= $this->min_charged_image) || $new_category) ? $new_images_counter : 0;
                $video_fee = (($this->min_charged_video < $new_videos_counter && $new_videos_counter > $nb_videos && $nb_videos <= $this->min_charged_video) || $new_category) ? $new_videos_counter : 0;
            } else {
                $picture_fee = ($this->min_charged_image >= $nb_images) ? 0 : $nb_images;
                $video_fee = ($this->min_charged_video >= $nb_videos) ? 0 : $nb_videos;
            }

            $hlitem_fee = (!$old_item['hl'] && $item_details['hl'] || $new_category) ? 1 : 0;
            $bolditem_fee = (!$old_item['bold'] && $item_details['bold'] || $new_category) ? 1 : 0;
            $hpfeat_fee = (!$old_item['hpfeat'] && $item_details['hpfeat'] || $new_category) ? 1 : 0;
            $catfeat_fee = (!$old_item['catfeat'] && $item_details['catfeat'] || $new_category) ? 1 : 0;
            $rp_fee = ($old_item['reserve_price'] == 0 && $item_details['reserve_price'] > 0 || $new_category) ? 1 : 0;
            $second_cat_fee = (!$old_item['addl_category_id'] && $item_details['addl_category_id'] || $new_category) ? 1 : 0;
            $buyout_fee = ($old_item['buyout_price'] == 0 && $item_details['buyout_price'] > 0 || $new_category) ? 1 : 0;
            $custom_start_fee = ($item_details['start_time_type'] == 'custom' && $new_category) ? 1 : 0; ## this is always 0 since if u can choose a custom start time on edit then it means it was already paid for
            $makeoffer_fee = (!$old_item['is_offer'] && $item_details['is_offer'] || $new_category) ? 1 : 0;
        }
        $output = array(
            'picture_fee' => array(GMSG_IMG_UPL_FEE, $picture_fee),
            'hlitem_fee' => array(GMSG_HL_FEE, $hlitem_fee),
            'bolditem_fee' => array(GMSG_BOLD_FEE, $bolditem_fee),
            'hpfeat_fee' => array(GMSG_HPFEAT_FEE, $hpfeat_fee),
            'catfeat_fee' => array(GMSG_CATFEAT_FEE, $catfeat_fee),
            'rp_fee' => array(GMSG_RP_FEE, $rp_fee),
            'second_cat_fee' => array(GMSG_ADDLCAT_FEE, $second_cat_fee),
            'buyout_fee' => array(GMSG_BUYOUT_FEE, $buyout_fee),
            'custom_start_fee' => array(GMSG_CUSTOM_START_FEE, $custom_start_fee),
            'video_fee' => array(GMSG_MEDIA_UPL_FEE, $video_fee),
            'makeoffer_fee' => array(GMSG_MAKEOFFER_FEE, $makeoffer_fee)
        );
        return $output;
    }

    function auction_setup_fees($item_details, $user_details, $voucher_details = null, $apply_tax = true, $add_invoices = false, $item_relist = false)
    {
        $user_payment_mode = $this->user_payment_mode($user_details['user_id']);
        $account_balance = $user_details['balance'];
        $can_rollback = ($this->edit_auction_id) ? 1 : 0;

        $output = array('display' => null, 'amount' => 0);

        $fees_no_tier = $this->fees_no_tier_array($item_details);

        // we start with the setup fee
        $setup_fee = $this->display_fee_tiers('setup', $user_details, $item_details['category_id'], $item_details['list_in'], $item_details['start_price'], $voucher_details, $apply_tax, $item_details['currency']);

        if ($item_relist) {
            $this->set_fees($user_details['user_id'], $item_details['category_id']);
        }

        $charged_fee_tier = array();

        $invoice = new invoice();
        $invoice_date = CURRENT_TIME;
        $status = $invoice->getInvoiceStatus('auction_setup');

        try {

//            $this->beginTransaction();

            if (is_array($setup_fee)) {

                foreach ($setup_fee as $key => $value) {
                    if (!$value['amount']) {
                        continue;
                    }
                    if ($value['calc_type'] == 'flat') {
                        $output['amount'] += $value['amount'];
                        $fee_display = $this->display_amount($value['amount'], $this->setts['currency']);
                    } elseif ($value['calc_type'] == 'percent') {
                        $output['amount'] += $this->round_number($item_details['start_price'] * $value['amount'] / 100);
                        $fee_display = $value['amount'] . '%';
                    }

                    if ($item_relist) {
                        $output['amount'] = $this->round_number($output['amount'] - $output['amount'] * $this->fee['relist_fee_reduction'] / 100);
                    }

                    $charged_fee_tier[$key] = array(
                        'value' => $fee_display,
                        'display' => $value['display'],
                    );

                    ## now add the row on the invoices table
                    if ($user_payment_mode == 2 && $add_invoices) {

//            $account_balance += $output['amount'];
                        //kiennguyen1101
                        $invoice_name = GMSG_SETUP_FEE;

                        $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, item_id, name, amount, invoice_status, invoice_date, current_balance, can_rollback) VALUES ('{$user_details['user_id']}', '{$item_details['auction_id']}', '{$invoice_name}', '{$output['amount']}', '{$status['invoice_status_id']}', '{$invoice_date}', '{$account_balance}', '{$can_rollback}')");

//            $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices (user_id, item_id, name, amount, invoice_date, current_balance, can_rollback) VALUES ('" . $user_details['user_id'] . "', '" . $item_details['auction_id'] . "', '" . GMSG_SETUP_FEE . "', '" . $output['amount'] . "', '" . CURRENT_TIME . "', '" . $account_balance . "', " . $can_rollback . ")");
//            $sql_update_user_balance = $this->query("UPDATE " . DB_PREFIX . "users SET balance='" . $account_balance . "' WHERE user_id='" . $user_details['user_id'] . "'");
                    }
                }
            }

            $charged_fee_no_tier = array();

            foreach ($fees_no_tier as $key => $value) {
                if ($value[1]) {
                    $fee_details = $this->display_fee($key, $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details, $apply_tax);

                    if ($item_relist) {
                        $fee_details['amount'] = $this->round_number($fee_details['amount'] - $fee_details['amount'] * $this->fee['relist_fee_reduction'] / 100);
                    }

                    $output['amount'] += $fee_details['amount'];

                    if ($fee_details['amount']) { ## only do this if there is a fee
                        $charged_fee_no_tier[$key] = array(
                            'value' => $value[0],
                            'display' => $fee_details['display'],
                        );

                        ## now add the row on the invoices table
                        if ($user_payment_mode == 2 && $add_invoices) {

//              $account_balance += $fee_details['amount'];

                            $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, item_id, name, amount, invoice_status, invoice_date, current_balance, can_rollback) VALUES ('{$user_details['user_id']}', '{$item_details['auction_id']}', '{$value[0]}', '{$fee_details['amount']}', '{$status['invoice_status_id']}', '{$invoice_date}', '$account_balance', '$can_rollback')");

//              $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices (user_id, item_id, name, amount, invoice_date, current_balance, can_rollback) VALUES ('" . $user_details['user_id'] . "', '" . $item_details['auction_id'] . "', '" . $value[0] . "', '" . $fee_details['amount'] . "', '" . CURRENT_TIME . "', '" . $account_balance . "', " . $can_rollback . ")");
                            //kiennguyen1101
//              $sql_update_user_balance = $this->query("UPDATE " . DB_PREFIX . "users SET balance='" . $account_balance . "' WHERE user_id='" . $user_details['user_id'] . "'");
                        }
                    }
                }
            }

//            $this->commit();
        } catch (error $e) {
//            $this->rollBack();
            error::dump_exception($e);
        }

        $display_amount = $this->display_amount($output['amount'], $this->setts['currency']);

        $output['display'] = array(
            'charged_fee_tier' => $charged_fee_tier,
            'charged_fee_no_tier' => $charged_fee_no_tier,
            'display_amount' => $display_amount,
        );

        return $output;
    }

    function prepare_rollback($auction_id, $user_id)
    {
        /**
         * first reset any previous rollbacks on this auction
         * then create a new rollback start point.
         */
        $delete_rollback = $this->query("DELETE FROM " . DB_PREFIX . "auction_rollbacks WHERE
			auction_id='" . $auction_id . "'");

        $reset_invoices = $this->query("UPDATE " . DB_PREFIX . "invoices SET can_rollback=0 WHERE
			item_id='" . $auction_id . "'");

        $sql_add_rollback = $this->query("INSERT INTO " . DB_PREFIX . "auction_rollbacks
			(auction_id, start_price, reserve_price, buyout_price, category_id,
			active, payment_status, hpfeat, catfeat, bold, hl, addl_category_id, is_offer) SELECT
			auction_id, start_price, reserve_price, buyout_price, category_id,
			active, payment_status, hpfeat, catfeat, bold, hl, addl_category_id, is_offer FROM
			" . DB_PREFIX . "auctions WHERE auction_id='" . $auction_id . "' AND owner_id='" . $user_id . "'");

        $rollback_id = $this->insert_id();

        $user_balance = $this->get_sql_field("SELECT balance FROM " . DB_PREFIX . "users WHERE user_id='" . $user_id . "'", 'balance');

        $nb_images = $this->count_rows('auction_media', "WHERE auction_id='" . $auction_id . "' AND media_type=1 AND upload_in_progress=1");
        $nb_videos = $this->count_rows('auction_media', "WHERE auction_id='" . $auction_id . "' AND media_type=2 AND upload_in_progress=1");


        $sql_update_rollback = $this->query("UPDATE " . DB_PREFIX . "auction_rollbacks SET
			balance='" . $user_balance . "', nb_images='" . $nb_images . "', nb_videos='" . $nb_videos . "' WHERE
			rollback_id='" . $rollback_id . "'");
    }

    function setup($user_details, $item_details, $voucher_details = null, $item_relist = false, $charge_relist = false)
    {
        (array)$output = null;
        (int)$fee_table = 3; // auction setup - table = 3 (DB_PREFIX->auctions)

        $this->user_id = $user_details['user_id']; ## required for the protx gateway

        /**
         * mark can_rollback = 0 to all previous transactions on this item so only current fees can be
         * rolled back.
         */
        try {

//            $this->beginTransaction();

            $this->query("UPDATE " . DB_PREFIX . "invoices SET can_rollback=0 WHERE
			user_id='" . $user_details['user_id'] . "' AND item_id='" . $item_details['auction_id'] . "'");

            $setup_fees = $this->auction_setup_fees($item_details, $user_details, $voucher_details, true, true, $item_relist);

            $user_payment_mode = $this->user_payment_mode($user_details['user_id']);

            if ($setup_fees['amount'] && $item_details['list_in'] != 'store') { ## make sure no fees are charged if the item is listed in store
                $output['amount'] = $setup_fees['amount'];

                ## if we edit an auction, suspend the auction first. -> needed for live payment mode especially.
                if ($output['amount'] && $this->edit_auction_id && $this->edit_user_id) {
                    ## auctions counter - remove process - single auction (suspend if auction edit)
                    $cnt_details = $this->get_sql_row("SELECT auction_id, active, approved, closed, deleted, list_in, category_id, addl_category_id FROM
					" . DB_PREFIX . "auctions WHERE auction_id='" . $this->edit_auction_id . "'");

                    if ($cnt_details['active'] == 1 && $cnt_details['approved'] == 1 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0 && $cnt_details['list_in'] != 'store') {
                        auction_counter($cnt_details['category_id'], 'remove', $cnt_details['auction_id']);
                        auction_counter($cnt_details['addl_category_id'], 'remove', $cnt_details['auction_id']);
                    }

                    $sql_update_auction = $this->query("UPDATE " . DB_PREFIX . "auctions SET
					active=0, payment_status='' WHERE auction_id='" . $this->edit_auction_id . "' AND owner_id='" . $this->edit_user_id . "'");
                }

                if ($user_payment_mode == 1) { // live payment
                    if ($item_relist && !$charge_relist) { ## if the auction is relisted, dont display the payment dialogue but only a message instead
                        $output['display'] = '<table class="errormessage" align="center"><tr><td align="center"> ' .
                            '<p class="contentfont" align="center">' . MSG_YOUR_AUCTION . ' #' . $item_details['auction_id'] . ' ' . MSG_HAS_BEEN_LISTED . '</p>' .
                            '<p class="contentfont" align="center">' . MSG_YOU_WILL_NEED_TO_PAY . ' ' . $this->display_amount($output['amount'], $this->setts['currency'], 0) .
                            ' ' . MSG_TO_ACTIVATE_THE_AUCTION . '</p></td></tr></table>';
                    } else {
                        $output['display'] = $this->payment_message($output['amount'], 0, MSG_TO_ACTIVATE_YOUR_AUCT);

                        $transaction_id = $item_details['auction_id'] . 'TBL' . $fee_table;

                        $payment_description = $this->setts['sitename'] . ' - ' . GMSG_AUCTION_SETUP_FEE;

                        $output['display'] .= $this->show_gateways($transaction_id, $output['amount'], $this->setts['currency'], 0, $payment_description);
                    }
                } else if ($user_payment_mode == 2) { // account payment - subtract balance and add invoices.
                    ## auctions counter - add process - single auction (activate on account mode)
                    $cnt_details = $this->get_sql_row("SELECT auction_id, active, approved, closed, deleted, list_in, category_id, addl_category_id FROM
					" . DB_PREFIX . "auctions WHERE auction_id='" . $item_details['auction_id'] . "'");

                    if ($cnt_details['active'] == 0 && $cnt_details['approved'] == 1 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0 && $cnt_details['list_in'] != 'store') {
                        auction_counter($cnt_details['category_id'], 'add', $cnt_details['auction_id']);
                        auction_counter($cnt_details['addl_category_id'], 'add', $cnt_details['auction_id']);
                    }

                    ## all we need to actually do is activate the auction
                    $sql_update_auction = $this->query("UPDATE " . DB_PREFIX . "auctions SET
					active=1, payment_status='confirmed' WHERE auction_id='" . $item_details['auction_id'] . "'");

                    $output['display'] = '<table class="errormessage" align="center"><tr><td align="center"> ' .
                        '<p class="contentfont" align="center">' . MSG_YOUR_AUCTION . ' #' . $item_details['auction_id'] . ' ' . MSG_HAS_BEEN_ACTIVATED . '</p>' .
                        '<p class="contentfont" align="center">' . MSG_THE_AMOUNT_OF . ' ' . $this->display_amount($output['amount'], $this->setts['currency'], 0) .
                        ' ' . MSG_HAS_BEEN_ADDED_TO_YOUR_BALANCE . '</p>';

                    if ($output['tax_details']) {
                        $output['display'] .= '<p class="contentfont" align="center">' . $output['tax_details'] . '</p>';
                    }
                    $output['display'] .= '</td></tr></table>';
                }

                if ($this->edit_auction_id) {
                    $output['display'] .= '<p align="center">[ <a href="members_area.php?page=selling&section=rollback&auction_id=' . $item_details['auction_id'] . '">' . MSG_ROLLBACK_TRANSACTION . '</a> ]</p>';
                }
            } else {
                ## auctions counter - add process - single auction (activate if no fees or if list in store)
                $cnt_details = $this->get_sql_row("SELECT auction_id, active, approved, closed, deleted, list_in, category_id, addl_category_id FROM
				" . DB_PREFIX . "auctions WHERE auction_id='" . $item_details['auction_id'] . "'");

                if ($cnt_details['active'] == 0 && $cnt_details['approved'] == 1 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0 && $cnt_details['list_in'] != 'store') {
                    auction_counter($cnt_details['category_id'], 'add', $cnt_details['auction_id']);
                    auction_counter($cnt_details['addl_category_id'], 'add', $cnt_details['auction_id']);
                }

                ## all we need to actually do is activate the auction
                $sql_update_auction = $this->query("UPDATE " . DB_PREFIX . "auctions SET
				active=1, payment_status='confirmed' WHERE auction_id='" . $item_details['auction_id'] . "'");

                $output['display'] = '<table class="errormessage" align="center"><tr><td align="center"> ' .
                    '<p class=contentfont align=center>' . MSG_YOUR_AUCTION . ' #' . $item_details['auction_id'] . ' ' . (($this->edit_auction_id) ? MSG_HAS_BEEN_UPDATED : MSG_HAS_BEEN_ACTIVATED) . '</p>' .
                    '</td></tr></table>';
            }
//            $this->commit();
        } catch (error $e) {
//            $this->rollBack();
            error::dump_exception($e);
        }

        return $output;
    }

    function sale($winning_bid_details, $item_details)
    {
        (array)$output = null;
        (int)$fee_table = 4; // sale fee - table = 4 (DB_PREFIX->winners)

        $this->set_fees($item_details['owner_id'], $item_details['category_id']); ## by default the seller will pay

        if (stristr($this->fee['endauction_fee_applies'], 'b')) {
            $payer_id = $winning_bid_details['buyer_id'];
            $this->set_fees($winning_bid_details['buyer_id']); ## if buyer will pay, reset fees
        } else {
            $payer_id = $item_details['owner_id'];
        }

        $this->user_id = $payer_id; ## required for the protx gateway
        $user_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "users WHERE user_id=" . $payer_id);

        if ($winning_bid_details['bid_amount'] < 0) { ## we have an item swap
            $output['amount'] = $this->fee['swap_fee'];
            $endauction_fee_desc = GMSG_SWAP_FEE;
        } else {
            $sale_fee = $this->display_fee_tiers('endauction', $user_details, $item_details['category_id'], $item_details['list_in'], $winning_bid_details['bid_amount']);

            $output['amount'] = $sale_fee[0]['amount'];
            $endauction_fee_desc = GMSG_ENDAUCTION_FEE;
        }

        $user_payment_mode = $this->user_payment_mode($user_details['user_id']);

        if ($output['amount'] > 0 && $item_details['list_in'] != 'store') {
            if ($user_payment_mode == 1) { // live payment
                $output['display'] = $this->payment_message($output['amount'], 0, MSG_TO_PAY_FOR_SALE_FEE);

                $transaction_id = $winning_bid_details['winner_id'] . 'TBL' . $fee_table;

                $payment_description = $this->setts['sitename'] . ' - ' . $endauction_fee_desc;

                $output['display'] .= $this->show_gateways($transaction_id, $output['amount'], $this->setts['currency'], 0, $payment_description);
            } else if ($user_payment_mode == 2) { // account payment - subtract balance and add invoices.
                ## all we need to actually do is activate the winner row
                try {

//                    $this->beginTransaction();

                    $sql_update_winner = $this->query("UPDATE " . DB_PREFIX . "winners SET
					active=1, payment_status='confirmed' WHERE winner_id='" . $winning_bid_details['winner_id'] . "'");

                    $account_balance = $user_details['balance'] + $output['amount'];
                    $invoice_time = CURRENT_TIME;

                    $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, item_id, name, amount, invoice_status, invoice_date, current_balance) VALUES ('{$user_details['user_id']}', '{$item_details['auction_id']}', '{$endauction_fee_desc}', '{$output['amount']}', 'auction_end', '{$invoice_time}', '$account_balance')");

//          $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices (user_id, item_id, name, amount, invoice_date, current_balance) VALUES ('" . $user_details['user_id'] . "', '" . $item_details['auction_id'] . "', '" . $endauction_fee_desc . "', '" . $output['amount'] . "', '" . CURRENT_TIME . "', '" . $account_balance . "')");

                    $sql_update_user_balance = $this->query("UPDATE " . DB_PREFIX . "users SET
					balance='" . $account_balance . "' WHERE user_id='" . $user_details['user_id'] . "'");
//                    $this->commit();
                } catch (error $e) {
//                    $this->rollBack();
                    error::dump_exception($e);;
                }

                $output['display'] = '<table class="errormessage" align="center"><tr><td align="center"> ' .
                    '<p class="contentfont" align="center">' . MSG_THE_SALE . ' #' . $winning_bid_details['winner_id'] . ' ' . MSG_HAS_BEEN_ACTIVATED . '</p>' .
                    '<p class="contentfont" align="center">' . MSG_THE_AMOUNT_OF . ' ' . $this->display_amount($output['amount'], $this->setts['currency'], 0) .
                    ' ' . MSG_HAS_BEEN_ADDED_TO_YOUR_BALANCE . '</p>';

                $output['display'] .= '</td></tr></table>';
            }
        } else {
            ## all we need to actually do is activate the winner row
            $sql_update_winner = $this->query("UPDATE " . DB_PREFIX . "winners SET
				active=1, payment_status='confirmed' WHERE winner_id='" . $winning_bid_details['winner_id'] . "'");

            $output['display'] = '<table class="errormessage" align="center"><tr><td align="center"> ' .
                '<p class=contentfont align=center>' . MSG_THE_SALE . ' #' . $item_details['auction_id'] . ' ' . MSG_HAS_BEEN_ACTIVATED . '</p>' .
                '</td></tr></table>';
        }

        return $output;
    }

    function signup($user_id)
    {
        (array)$output = null;
        (int)$fee_table = 1; // user signup - table = 1 (DB_PREFIX->users)
        ## first we check what account id the user has.
        $this->set_fees($user_id);
        $this->user_id = $user_id; ## required for the protx gateway

        if ($this->fee['signup_fee'] > 0) {
            $output = $this->apply_tax($this->fee['signup_fee'], $this->setts['currency'], $user_id, $this->setts['enable_tax']);

            $output['display'] = $this->payment_message($output['amount'], 0, $signup_message, $output['tax_details']);

            $transaction_id = $user_id . 'TBL' . $fee_table;

            $payment_description = $this->setts['sitename'] . ' - ' . GMSG_USER_SIGNUP_FEE;

            $output['display'] .= $this->show_gateways($transaction_id, $output['amount'], $this->setts['currency'], 0, $payment_description);
        }

        return $output;
    }

    function clear_balance($user_id, $amount, $payment_description = null)
    {
        (array)$display_output = null; /* we dont need an array here since we always display this functions output */
        (int)$fee_table = 2; // clear account balance - table = 2 (DB_PREFIX->users)

        $this->user_id = $user_id; ## required for the protx gateway

        /**
         * Very Important: tax is applied when items are added and so on,
         * meaning that the account balance already has tax applied!
         */
        $display_output = $this->payment_message($amount, 0, MSG_CLEAR_ACC_BALANCE_EXPL);

        $transaction_id = $user_id . 'TBL' . $fee_table;

        $payment_description = (!$payment_description) ? $this->setts['sitename'] . ' - ' . MSG_CLEAR_ACC_BALANCE : $payment_description;

        $display_output .= $this->show_gateways($transaction_id, $amount, $this->setts['currency'], 0, $payment_description);

        return $display_output;
    }

    function wanted_ad_setup($user_details, $item_details, $edit = false)
    {
        (array)$output = null;
        (int)$fee_table = 5; // auction setup - table = 5 (DB_PREFIX->wanted_ads)

        $this->user_id = $user_details['user_id']; ## required for the protx gateway

        $this->set_fees($user_details['user_id'], $item_details['category_id']);
        $user_payment_mode = $this->user_payment_mode($user_details['user_id']);

        if ($this->fee['wanted_ad_fee'] > 0 && !$edit) {
            $output['amount'] = $this->fee['wanted_ad_fee'];

            if ($user_payment_mode == 1) { // live payment
                $output['display'] = $this->payment_message($output['amount'], 0, MSG_TO_ACTIVATE_YOUR_WANTED_AD);

                $transaction_id = $item_details['wanted_ad_id'] . 'TBL' . $fee_table;

                $payment_description = $this->setts['sitename'] . ' - ' . GMSG_WA_SETUP_FEE;

                $output['display'] .= $this->show_gateways($transaction_id, $output['amount'], $this->setts['currency'], 0, $payment_description);
            } else if ($user_payment_mode == 2) { // account payment - subtract balance and add invoices.
                ## wanted counter - add process
                $cnt_details = $this->get_sql_row("SELECT wanted_ad_id, active, closed, deleted, category_id, addl_category_id FROM
					" . DB_PREFIX . "wanted_ads WHERE wanted_ad_id='" . $item_details['wanted_ad_id'] . "'");

                if ($cnt_details['active'] == 0 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0) {
                    wanted_counter($cnt_details['category_id'], 'add');
                    wanted_counter($cnt_details['addl_category_id'], 'add');
                }

                ## all we need to actually do is activate the wanted ad
                $sql_update_wanted_ad = $this->query("UPDATE " . DB_PREFIX . "wanted_ads SET
					active=1, payment_status='confirmed' WHERE wanted_ad_id='" . $item_details['wanted_ad_id'] . "'");

                $account_balance = $user_details['balance'] + $output['amount'];

                //kiennguyen1101

                $invoice_name = GMSG_WA_SETUP_FEE;
                $invoice_time = CURRENT_TIME;

                $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices	(user_id, wanted_ad_id, name, amount, invoice_status, invoice_date, current_balance) VALUES ('{$user_details['user_id']}', '{$item_details['wanted_ad_id']}', '$invoice_name', '{$payment_amount}', 'completed', '{$invoice_time}', {$account_balance}')");

//          $sql_insert_invoice = $this->query("INSERT INTO " . DB_PREFIX . "invoices (user_id, wanted_ad_id, name, amount, invoice_date, current_balance) VALUES ('" . $user_details['user_id'] . "', '" . $item_details['wanted_ad_id'] . "', '" . GMSG_WA_SETUP_FEE . "', '" . $output['amount'] . "', '" . CURRENT_TIME . "', '" . $account_balance . "')");

                $sql_update_user_balance = $this->query("UPDATE " . DB_PREFIX . "users SET
					balance='" . $account_balance . "' WHERE user_id='" . $user_details['user_id'] . "'");

                $output['display'] = '<table class="errormessage" align="center"><tr><td align="center"> ' .
                    '<p class="contentfont" align="center">' . MSG_YOUR_WANTED_AD . ' #' . $item_details['wanted_ad_id'] . ' ' . MSG_HAS_BEEN_ACTIVATED . '</p>' .
                    '<p class="contentfont" align="center">' . MSG_THE_AMOUNT_OF . ' ' . $this->display_amount($output['amount'], $this->setts['currency'], 0) .
                    ' ' . MSG_HAS_BEEN_ADDED_TO_YOUR_BALANCE . '</p>';

                if ($output['tax_details']) {
                    $output['display'] .= '<p class="contentfont" align="center">' . $output['tax_details'] . '</p>';
                }
                $output['display'] .= '</td></tr></table>';
            }
        } else {
            ## wanted counter - add process
            $cnt_details = $this->get_sql_row("SELECT wanted_ad_id, active, closed, deleted, category_id, addl_category_id FROM
				" . DB_PREFIX . "wanted_ads WHERE wanted_ad_id='" . $item_details['wanted_ad_id'] . "'");

            if ($cnt_details['active'] == 0 && $cnt_details['closed'] == 0 && $cnt_details['deleted'] == 0) {
                wanted_counter($cnt_details['category_id'], 'add');
                wanted_counter($cnt_details['addl_category_id'], 'add');
            }

            ## all we need to actually do is activate the auction
            $sql_update_wanted_ad = $this->query("UPDATE " . DB_PREFIX . "wanted_ads SET
				active=1, payment_status='confirmed' WHERE wanted_ad_id='" . $item_details['wanted_ad_id'] . "'");

            $output['display'] = '<table class="errormessage" align="center"><tr><td align="center"> ' .
                '<p class=contentfont align=center>' . MSG_YOUR_WANTED_AD . ' #' . $item_details['wanted_ad_id'] . ' ' . (($this->edit_auction_id) ? MSG_HAS_BEEN_UPDATED : MSG_HAS_BEEN_ACTIVATED) . '</p>' .
                '</td></tr></table>';
        }

        return $output;
    }

    function store_subscription($shop_account_id, $user_id)
    {
        (array)$output = null;
        (int)$fee_table = 10; // store subscription - table = 10 (DB_PREFIX->users)

        $this->user_id = $user_id; ## required for the protx gateway
        ## first we check if the user is a preferred seller
        $preferred_seller = $this->get_sql_field("SELECT preferred_seller FROM " . DB_PREFIX . "users WHERE
			user_id='" . $user_id . "'", 'preferred_seller');

        ## now we get the subscription amount
        $subscription_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "fees_tiers WHERE tier_id='" . $shop_account_id . "'");

        if ($preferred_seller && $this->setts['enable_pref_sellers']) {
            $subscription_details['fee_amount'] = $this->round_number($subscription_details['fee_amount'] - ($subscription_details['fee_amount'] * ($this->setts['pref_sellers_reduction'] / 100)));
        }

        if ($subscription_details['fee_amount'] > 0) {
            $output = $this->apply_tax($subscription_details['fee_amount'], $this->setts['currency'], $user_id, $this->setts['enable_tax']);

            $output['display'] = $this->payment_message($output['amount'], 0, $store_subscription_message, $output['tax_details']);

            $transaction_id = $user_id . 'TBL' . $fee_table;

            $payment_description = $this->setts['sitename'] . ' - ' . GMSG_STORE_SUBSCRIPTION_PAYMENT;

            $output['display'] .= $this->show_gateways($transaction_id, $output['amount'], $this->setts['currency'], 0, $payment_description);
        } else {
            $shop_last_payment = 0;
            $shop_next_payment = 0;

            $this->query("UPDATE " . DB_PREFIX . "users SET shop_active=1, shop_last_payment='" . $shop_last_payment . "',
				shop_next_payment='" . $shop_next_payment . "' WHERE user_id=" . $user_id);

            ## if there is no fee we will activate the store
            $sql_update_store = $this->query("UPDATE " . DB_PREFIX . "users SET
				shop_active=1 WHERE user_id='" . $user_id . "'");

            $output['display'] = '<table class="errormessage" align="center"><tr><td align="center"> ' .
                '<p class=contentfont align=center>' . MSG_STORE_ACTIVATED . '</p>' .
                '</td></tr></table>';
        }

        return $output;
    }

    function seller_verification($user_id)
    {
        (array)$output = null;
        (int)$fee_table = 6; // seller_verification - table = 6 (DB_PREFIX->users)

        $this->user_id = $user_id; ## required for the protx gateway
        ## first we check if the user is a preferred seller
        $preferred_seller = $this->get_sql_field("SELECT preferred_seller FROM " . DB_PREFIX . "users WHERE
			user_id='" . $user_id . "'", 'preferred_seller');

        ## now we get the subscription amount
        $this->set_fees($user_id);

        if ($this->fee['verification_fee'] > 0) {
            $output = $this->apply_tax($this->fee['verification_fee'], $this->setts['currency'], $user_id, $this->setts['enable_tax']);

            $output['display'] = $this->payment_message($output['amount'], 0, MSG_TO_VERIFY_YOUR_ACCOUNT, $output['tax_details']);

            $transaction_id = $user_id . 'TBL' . $fee_table;

            $payment_description = $this->setts['sitename'] . ' - ' . GMSG_SELLER_VERIFICATION_FEE;

            $output['display'] .= $this->show_gateways($transaction_id, $output['amount'], $this->setts['currency'], 0, $payment_description);
        } else {
            ## if there is no fee we will activate the store
            $sql_update_store = $this->query("UPDATE " . DB_PREFIX . "users SET
				seller_verified=1 WHERE user_id='" . $user_id . "'");

            $output['display'] = '<table class="errormessage" align="center"><tr><td align="center"> ' .
                '<p class=contentfont align=center>' . MSG_SELLER_VERIFIED . '</p>' .
                '</td></tr></table>';
        }

        return $output;
    }

}

?>