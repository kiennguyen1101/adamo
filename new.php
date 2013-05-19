<?php

define('IN_SITE', 1);

include_once('includes/global.php');

$db->beginTransaction();
$db->query("INSERT INTO `myphpauction_invoice_statuses` (`invoice_status_id`, `title`, `state`, `weight`, `locked`) VALUES ('nnana', 'abcxyz', 'adddd', '0', '0')");

$db->rollBack();