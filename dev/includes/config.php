<?php
/* Database Host Name */
$db_host = 'localhost';
/* Database Username */
$db_username = 'adamo_dev';
/* Database Login Password */
$db_password = 'adamo';
/* Database Name */
$db_name = 'adamo_dev';

  /* Database and Session prefixes */
  define('DB_PREFIX', 'myphpauction_'); ## Do not edit !
  define('SESSION_PREFIX', 'myphpauction_');
  define('DEBUG', true);

  define('BASE_PATH', $setts['site_path']);
  define('INCLUDE_PATH', BASE_PATH . 'include/');
  define('ADMIN_PATH', BASE_PATH . "admin/");
  define('THEME_PATH', BASE_PATH . "themes/");

  define('INCLUDE_DIR', dirname(__FILE__).'/');
  define('BASE_DIR', dirname(INCLUDE_DIR));
  define('ADMIN_DIR', BASE_DIR . "/admin/");
  define('THEME_DIR', BASE_DIR . "/themes/");

?>