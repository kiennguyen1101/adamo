<?php
#################################################################
## MyPHPAuction 2009															##
##-------------------------------------------------------------##
## Copyright ©2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

  session_start();

  define('IN_SITE', 1);

  include_once ('includes/global.php');

  require ('global_header.php');

  $template->set('header_message', header5(MSG_RSS_FEEDS));

  $template_output .= $template->process('rss_feed.tpl.php');

  include_once ('global_footer.php');

  echo $template_output;
?>
