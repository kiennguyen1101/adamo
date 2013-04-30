<?php

  define('IN_SITE', 1);

  include_once ('includes/global.php');

  $invoice = new invoice();
  $invoice_date = CURRENT_TIME;
  $status = $invoice->getInvoiceStatus('auction_setup');
  

  function xxx() {
    throw new error('adsfasf');
  }
  
  try {
    xxx();
  } catch (error $e) {
    echo $e;
  }

  var_dump($status);