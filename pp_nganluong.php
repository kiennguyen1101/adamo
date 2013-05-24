<?php
#################################################################
## MyPHPAuction 2009															##
##-------------------------------------------------------------##
## Copyright �2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

define ('IN_SITE', 1);

include_once('includes/global.php');
include_once('includes/class_fees.php');
require_once(INCLUDE_DIR . "gateways/nganluong.php");

(string)$active_pg = 'nganluong';
(string)$error_output = null;

$pg_enabled = $db->get_sql_field("SELECT checked FROM " . DB_PREFIX . "payment_gateways WHERE
	name='" . $active_pg . "' LIMIT 0,1", "checked");

if (!$pg_enabled) {
    die(GMSG_NOT_AUTHORIZED);
}

//Lấy thông tin giao dịch
$transaction_info = $_GET["transaction_info"];
//Lấy mã đơn hàng
$order_code = $_GET["order_code"];
//Lấy tổng số tiền thanh toán tại ngân lượng
$price = $_GET["price"];
//Lấy mã giao dịch thanh toán tại ngân lượng
$payment_id = $_GET["payment_id"];
//Lấy loại giao dịch tại ngân lượng (1=thanh toán ngay ,2=thanh toán tạm giữ)
$payment_type = $_GET["payment_type"];
//Lấy thông tin chi tiết về lỗi trong quá trình giao dịch
$error_text = $_GET["error_text"];
//Lấy mã kiểm tra tính hợp lệ của đầu vào
$secure_code = $_GET["secure_code"];

$nganluong = new nganluong();

$redirect_url = SITE_PATH . 'payment_failed.php';

if ($nganluong->verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code)) {

    if (!$error_text) {
        $process_fee = new fees();
        $process_fee->setts = & $setts;
        try {
            $db->beginTransaction();

            list($custom, $fee_table) = explode('TBL',$_GET['order_code']);
            list($item_name, $payment_currency) = explode('TBL',$_GET['transaction_info']);

            $process_fee->callback_process($custom, $fee_table, $active_pg, $price, $payment_id, $payment_currency);

            $redirect_url = SITE_PATH . 'payment_completed.php';

            $db->commit();
        } catch (error $e) {
            $db->rollBack();
            error::dump_exception($e);
        }

    } else {
        $error_output = $error_text;
    }

}
//die();
header_redirect($redirect_url);

?>