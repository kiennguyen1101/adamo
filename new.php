<?php

  define('IN_SITE', 1);

  include_once ('includes/global.php');

  $invoice = new invoice();
  $invoice_date = CURRENT_TIME;
  $status = $invoice->getInvoiceStatus('auction_setup');
  var_dump($status);