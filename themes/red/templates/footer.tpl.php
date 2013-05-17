﻿<?php
  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>
<?php if (substr(strrchr($_SERVER['PHP_SELF'], '/'), 1) != "index.php") { ?>
    </div>
	</div>
  <?php } ?>
<div align="center">
  <?php echo $banner_header_content; ?>
</div>
<div><img src="themes/<?php echo $setts['default_theme']; ?>/img/pixel.gif" width="1" height="5"></div>
<div style="padding: 5px; border-top:1px solid #cccccc; color:#9999FF;overflow: hidden;margin-bottom: 20px;" class="footerfont">
	<div class="footer_column">
		<h2>Adamo e-com</h2>
		<ul> 	
			<li><a href="<?php echo $register_link; ?>"><?php echo $register_btn_msg; ?></a></li>
			<li><a href="<?php echo $login_link; ?>"><?php echo $login_btn_msg; ?></a></li>
			<li> <?php if ($layout['is_about']) { ?><a href="<?php echo process_link('content_pages', array('page' => 'about_us')); ?>"><?php echo MSG_BTN_ABOUT_US; ?></a><?php } ?></li>
			<li><a href="<?php echo process_link('site_fees'); ?>"><?php echo MSG_BTN_SITE_FEES; ?></a></li>
			<li><a href="http://adamo.vn/content_pages.php?page=custom_page&topic_id=56">Thanh toán tạm giữ</a></li>
		</ul>
	</div>
  
	<div class="footer_column">
		<h2>Đối với người dùng</h2>
		<ul>
			<li><?php if ($layout['is_terms']) { ?> <a href="<?php echo process_link('content_pages', array('page' => 'terms')); ?>"><?php echo MSG_BTN_TERMS; ?></a><?php } ?></li>
			<li><?php if (!$setts['enable_private_site'] || $is_seller) { ?><a href="<?php echo $place_ad_link; ?>"><?php echo $place_ad_btn_msg; ?></a> <?php } ?></li>
			<li><a href="<?php echo process_link('content_pages', array('page' => 'help')); ?>"><?php echo MSG_BTN_HELP; ?></a></li>
			<li><a href="<?php echo process_link('content_pages', array('page' => 'faq')); ?>"><?php echo MSG_BTN_FAQ; ?></a></li>
			<li><a href="http://adamo.vn/content_pages.php?page=custom_page&topic_id=58">Chính sách bảo vệ người dùng</a></li>
			<li><?php if ($layout['is_pp']) { ?> <a href="<?php echo process_link('content_pages', array('page' => 'privacy')); ?>"><?php echo MSG_BTN_PRIVACY; ?></a><?php } ?> </li>
			
		</ul>
	</div>
   
  
	<div class="footer_column">
		<h2>Liên hệ</h2>
		<ul>
			<li class="contact_us"><?php if ($layout['is_contact']) { ?><a href="<?php echo process_link('content_pages', array('page' => 'contact_us')); ?>"><?php echo MSG_BTN_CONTACT_US; ?></a><?php } ?></li>
			<li class="facebook"><a href="https://www.facebook.com/adamovietnam">Facebook</a></li>
			<li class="twitter"><a href="https://twitter.com/adamovietnam">Twitter</a></li>
		</ul>
  
  <?php /**echo $custom_pages_links; **/?> 
  </div>
  <div class="footer_column">
	<h2>Đối tác</h2>
		<script src="https://www.nganluong.vn/tooltip_nbdb/nldb_tootip.js"></script>
		<script type="text/javascript">
		var merchantID=	0; // 22287 là Mã merchant site( hay mã website dăng ky trên Ngân Lượng)
		var uesrID=245009; //  là Mã tài khoản NgânLượng.vn của bạn
		var imageType=180; // 230 là kích thước logo rộng 230px
		ngaluongloadframe(merchantID,uesrID,imageType);	
		</script>
		
	<span id="siteseal" style="margin: 20px auto;display: block;width: 132px;"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=vmbtHwia7LTvKE4mkL60e1YMfy4JN2PwaoOds3EvThNWcwOTZ5"></script></span>

  </div>
</div>       
</body>
</html>