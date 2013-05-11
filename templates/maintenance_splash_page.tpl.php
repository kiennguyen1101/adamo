<?php


  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head> 
    <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 

    <title>Giới thiệu - Adamo.vn</title>
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />

    <!-- To change the color scheme, change blue.css with green.css, orange.css, red.css, purple.css and pink.css -->
    <link rel="stylesheet" href="colors/blue.css" type="text/css" media="screen" />

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.easing.min.js"></script>
    <script type="text/javascript" src="js/supersized.3.2.7.js"></script>
    <script type="text/javascript" src="js/supersized.shutter.js"></script>
    <script type="text/javascript" src="js/jquery.countdown.js"></script>
    <script type="text/javascript" src="js/jquery.contact.js"></script>
    <script type="text/javascript" src="js/jquery.subscribe.js"></script>

    <script type="text/javascript" src="js/jquery.ui.core.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.widget.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.mouse.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.draggable.min.js"></script>		

    <script type="text/javascript" src="js/custom.js"></script>

  </head>
  <body>

    <div id="wrapper">
      <div id="container">

        <div id="progress"></div>					

        <ul class="top-buttons"> <!-- drag and toggle buttons-->
          <li><a class="trigger">toggle me</a></li>
          <li><a class="drag">kéo chuột</a></li>
        </ul><!--end top-buttons-->

        <div id="totoggle">
          <div id="infopage">
            <div class="content">
              <p><span>Adamo.vn </span> là sàn giao dịch điện tử C2C ứng dụng những công nghệ mới nhất trên thế giới nhằm tạo ra trải nghiệm mua sắm tốt nhất cho người tiêu dùng Việt. </p>
              <p>	Chính sách hoạt động của Adamo Việt Nam được xây dựng nhằm tạo ra một môi trường giao dịch trực tuyến an toàn và thân thiện với người dùng, gồm các phương pháp chủ chốt là: </p>
              <ul>
                <li>-	Cổng thanh toán có độ bảo mật cao,</li>
                <li>-	Hình thức thanh toán tạm giữ,</li>
                <li>-	Chính sách giải quyết khiếu nại chặt chẽ và công bằng,</li>
                <li>-	Mua chung.</li>
              </ul>
              <span>Trải nghiệm mua sắm của Adamo phong phú với nhiều hình thức:</span>
              <ul>
                <li>-	Đấu giá,</li>
                <li>-	Mua ngay,</li>
                <li>-	Mặc cả với người bán,</li>
                <li>-	Hệ thống đánh giá người bán,</li>
                <li>-	Chính sách bảo vệ người mua.</li>
              </ul>
              <p>Mục tiêu của Adamo là thúc đẩy lưu thông hàng hóa trên thị trường, tạo điều kiện cho ngày càng nhiều người có thể tiếp cận và làm giàu từ thương mại điện tử, đồng thời mang lại lợi ích tốt nhất cho người tiêu dùng thông qua những sản phẩm chất lượng cao với giá cả phải chăng và phương thức thanh toán giao nhận thuận tiện nhất.</p>
              <p>Adamo Việt Nam sẽ liên tục được phát triển để ngày càng hoàn thiện phương pháp hoạt động và đa dạng về chức năng. Với mong muốn đó, mọi liên hệ  góp ý từ người dùng sẽ luôn được chúng tôi trân trọng và cân nhắc nghiêm túc. </p>
              <p>Xin chân thành cảm ơn.</p>
              <span>Adamo Việt Nam</span>
            </div><!--end content-->

            <ul class="buttons">
              <li><a class="info">I show some info</a></li>
              <li><a class="infocontact">I reveal the contact form</a></li>
            </ul><!--end buttons-->	
          </div><!--end infopage-->

          <div id="contactpage">
            <div class="content">
              <div class="one-half">
                <h2>Liên hệ với Adamo.vn </h2>
                <p>Hãy liên hệ trực tiếp với Adamo.vn để có được thông tin mà bạn cần trong thời gian sớm nhất.</p>
              </div><!--end one-half-->

              <div class="one-half last cf">
                <div id="contactform">
                  <div id="message"></div>
                  <form method="post" action="php/contact.php" name="cform" id="cform">
                    <input type="text" name="name" placeholder="Tên" id="name" />
                    <input type="text" name="email" placeholder="Email" id="email" />
                    <textarea name="comments" placeholder="Nội dung gửi" id="comments"></textarea>					
                    <input type="submit" name="send" value="Gửi" id="submit" /> 
                  </form>
                </div><!--end contactform-->
              </div><!--end one-half-->
            </div><!--end content-->

            <div class="clear"></div>

            <ul class="buttons">
              <li><a class="contactinfo">I show some info</a></li>
              <li><a class="contact">I reveal the contact form</a></li>
            </ul><!--end buttons-->						
          </div><!--end contactpage-->			

          <div id="homepage">
            <a class="logo" href="#"><img src="images/logo.png" alt="logo" /></a>
            <h1><span style="font-size:20px;">Sẽ xuất hiện trên thị trường sau...</span></h1>

            <div id="countdown"></div>	

            <div id="subscribe">
              <div id="mesaj"></div>
              <form method="post" action="php/subscribe.php" name="subscribeform" id="subscribeform">
                <input type="text" name="email" placeholder="Điền email của bạn để nhận thông báo" id="subemail" />
                <input type="submit" name="send" value="Đăng kí" id="subsubmit" />
              </form>
            </div>

            <ul class="buttons">
              <li><a class="info">I show some info</a></li>
              <li><a class="contact">I reveal the contact form</a></li>
            </ul><!--end buttons-->				
          </div><!--end homepage-->
        </div><!--end totoggle-->
      </div><!--end container-->

      <!--Thumbnail Navigation-->
      <div id="prevthumb"></div>
      <div id="nextthumb"></div>

      <!--Arrow Navigation-->
      <div id="thumb-tray" class="load-item">
        <div id="thumb-back"></div>
        <div id="thumb-forward"></div>
      </div>

      <!--Time Bar-->
      <div id="progress-back" class="load-item">
        <div id="progress-bar"></div>
      </div>

      <!--Control Bar-->
      <div id="controls-wrapper" class="load-item">
        <div id="controls">
          <div id="social">
            <h4>We are social:</h4>
            <ul>
              <li><a class="rss" href="#"><img src="images/social/rss.png" alt="" /></a></li>
              <li><a class="twitter" href="#"><img src="images/social/twitter.png" alt="" /></a></li>
              <li><a class="facebook" href="https://www.facebook.com/pages/Adamovn/117075068488687"><img src="images/social/facebook.png" alt="" /></a></li>
              <li><a class="flickr" href="#"><img src="images/social/flickr.png" alt="" /></a></li>
              <li><a class="google" href="#"><img src="images/social/google.png" alt="" /></a></li>

              <!-- you can add more social buttons from below for skype, stumbleupon, vimeo, dribbble, forrst -->

<!--	<li><a class="skype" href="#"><img src="images/social/skype.png" alt="" /></a></li>
    <li><a class="stumbleupon" href="#"><img src="images/social/stumbleupon.png" alt="" /></a></li>
    <li><a class="vimeo" href="#"><img src="images/social/vimeo.png" alt="" /></a></li>
    <li><a class="dribbble" href="#"><img src="images/social/dribbble.png" alt="" /></a></li>
    <li><a class="forrst" href="#"><img src="images/social/forrst.png" alt="" /></a></li>
              -->
            </ul>
          </div><!--end social-->

          <div class="centered-controls">
            <a id="prevslide" class="load-item"><img src="images/back.png" alt="" /></a>
            <a id="play-button"><img id="pauseplay" src="images/pause.png" alt="" /></a>
            <a id="nextslide" class="load-item"><img src="images/forward.png" alt="" /></a>
          </div><!--end centered-controls-->			

          <!--Thumb Tray button(the button from the bottom-right area)-->
          <a id="tray-button"><img id="tray-arrow" src="images/button-tray-up.png" alt="" /></a>

        </div><!--end controls-->
      </div><!--end controls-wrapper-->
    </div><!--end wrapper-->

    <script type="text/javascript" src="js/jquery.placeholder.js"></script>	<!-- placeholder html5 tag support for IE and Old Browsers -->

  </body>
</html>