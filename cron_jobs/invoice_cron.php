<?php


  session_start();

  define('IN_ADMIN', 1);

  include_once ('../includes/global.php');

  include('../language/' . $setts['site_lang'] . '/mails/invoice_cron_email.php')
?>