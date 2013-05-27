<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kien
 * Date: 5/21/13
 * Time: 7:36 PM
 * To change this template use File | Settings | File Templates.
 */

class paymentgateway extends fees
{

    const GW_DISABLED = 0;

    public function __construct($gateway_name = '')
    {
        if ($gateway_name) {
            $query = $this->query("SELECT * FROM " . DB_PREFIX . "payment_gateways WHERE name='{$gateway_name}'");
            $result = $this->fetch_array($query, true);

            if ($result) {
                foreach ($result as $key => $value)
                    $this->$key = $value;
            }
        }

    }

    public function form_nganluong($url)
    {

        (string)$display_output = null;

        $display_output = '<table width="100%" border="0" cellspacing="2" cellpadding="3" class="paymenttable"> ' .
            '<tr>' .
            '	<td width="160" class="paytable1"><img src="' . SITE_PATH . 'img/logo_nganluong.jpg"></td>' .
            '		<form method="post" action="' . $url . '" id="form_nganluong"> ' .
            '	<td class="paytable2" width="100%">' . GMSG_NGANLUONG_DESCRIPTION . '</td> ' .
            '	<td class="paytable3"> ' .
            '		<input name="submit" type="image" src="themes/' . $this->setts['default_theme'] . '/img/system/but_pay.gif" border="0"> ' .
            '	</td></form> ' .
            '</tr></table>';

        return $display_output;
    }

    /* @params: $params['error'], $params['transaction_id'],
     *          $params['amount'], $params['currency'],
     *          $params['order_id'] */
    public function process($params)
    {
        //what we do with payments:
        //check returned message for errors
        //add invoices
        //add information about transaction
        //change user balance
        //notify user
        //show messages accordingly

        //parameters needed: error message & code, gateway's transaction id, amount, currency, submitted order id (auction id)
        //other parameters should be handled by subclasses

        //BEGIN
        if ($params['error']) {
            //should we log the error for administration?

            //thow out an error
            throw new error(printf(MSG_PAYMENT_ERROR, $params['error']));
        }




    }


}