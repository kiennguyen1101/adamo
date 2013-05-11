<?php


  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 

    <title>Gi?i thi?u - Adamo.vn</title>
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
          <li><a class="drag">kéo chu?t</a></li>
        </ul><!--end top-buttons-->

        <div id="totoggle">
          <div id="infopage">
            <div class="content">
              <p><span>Adamo.vn </span> là sàn giao d?ch di?n t? C2C ?ng d?ng nh?ng công ngh? m?i nh?t trên th? gi?i nh?m t?o ra tr?i nghi?m mua s?m t?t nh?t cho ngu?i tiêu dùng Vi?t. </p>
              <p>	Chính sách ho?t d?ng c?a Adamo Vi?t Nam du?c xây d?ng nh?m t?o ra m?t môi tru?ng giao d?ch tr?c tuy?n an toàn và thân thi?n v?i ngu?i dùng, g?m các phuong pháp ch? ch?t là: </p>
              <ul>
                <li>-	C?ng thanh toán có d? b?o m?t cao,</li>
                <li>-	Hình th?c thanh toán t?m gi?,</li>
                <li>-	Chính sách gi?i quy?t khi?u n?i ch?t ch? và công b?ng,</li>
                <li>-	Mua chung.</li>
              </ul>
              <span>Tr?i nghi?m mua s?m c?a Adamo phong phú v?i nhi?u hình th?c:</span>
              <ul>
                <li>-	Ð?u giá,</li>
                <li>-	Mua ngay,</li>
                <li>-	M?c c? v?i ngu?i bán,</li>
                <li>-	H? th?ng dánh giá ngu?i bán,</li>
                <li>-	Chính sách b?o v? ngu?i mua.</li>
              </ul>
              <p>M?c tiêu c?a Adamo là thúc d?y luu thông hàng hóa trên th? tru?ng, t?o di?u ki?n cho ngày càng nhi?u ngu?i có th? ti?p c?n và làm giàu t? thuong m?i di?n t?, d?ng th?i mang l?i l?i ích t?t nh?t cho ngu?i tiêu dùng thông qua nh?ng s?n ph?m ch?t lu?ng cao v?i giá c? ph?i chang và phuong th?c thanh toán giao nh?n thu?n ti?n nh?t.</p>
              <p>Adamo Vi?t Nam s? liên t?c du?c phát tri?n d? ngày càng hoàn thi?n phuong pháp ho?t d?ng và da d?ng v? ch?c nang. V?i mong mu?n dó, m?i liên h?  góp ý t? ngu?i dùng s? luôn du?c chúng tôi trân tr?ng và cân nh?c nghiêm túc. </p>
              <p>Xin chân thành c?m on.</p>
              <span>Adamo Vi?t Nam</span>
            </div><!--end content-->

            <ul class="buttons">
              <li><a class="info">I show some info</a></li>
              <li><a class="infocontact">I reveal the contact form</a></li>
            </ul><!--end buttons-->	
          </div><!--end infopage-->

          <div id="contactpage">
            <div class="content">
              <div class="one-half">
                <h2>Liên h? v?i Adamo.vn </h2>
                <p>Hãy liên h? tr?c ti?p v?i Adamo.vn d? có du?c thông tin mà b?n c?n trong th?i gian s?m nh?t.</p>
              </div><!--end one-half-->

              <div class="one-half last cf">
                <div id="contactform">
                  <div id="message"></div>
                  <form method="post" action="php/contact.php" name="cform" id="cform">
                    <input type="text" name="name" placeholder="Tên" id="name" />
                    <input type="text" name="email" placeholder="Email" id="email" />
                    <textarea name="comments" placeholder="N?i dung g?i" id="comments"></textarea>					
                    <input type="submit" name="send" value="G?i" id="submit" /> 
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
            <h1><span style="font-size:20px;">S? xu?t hi?n trên th? tru?ng sau...</span></h1>

            <div id="countdown"></div>	

            <div id="subscribe">
              <div id="mesaj"></div>
              <form method="post" action="php/subscribe.php" name="subscribeform" id="subscribeform">
                <input type="text" name="email" placeholder="Ði?n email c?a b?n d? nh?n thông báo" id="subemail" />
                <input type="submit" name="send" value="Ðang kí" id="subsubmit" />
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
