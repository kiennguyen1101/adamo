<?php


  if (!defined('INCLUDED')) {
    die("Access Denied");
  }
?>
<?php $path = "themes/" . $setts['default_theme'] . "/brands"; ?>
<script>
  (function(i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function() {
      (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
  })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

  ga('create', 'UA-40770579-1', 'adamo.vn');
  ga('send', 'pageview');

</script>
<div class="jcarousel">
  <ul>
    <li><a href="http://www.htc.com"><img src="<?php echo $path ?>/brand-1.jpg"></img></a></li>
    <li><a href="http://www.samsung.com"><img src="<?php echo $path ?>/brand-2.jpg"></img></a></li>
    <li><a href="http://www.sony.com"><img src="<?php echo $path ?>/brand-3.jpg"></img></a></li>
    <li><a href="http://www.lg.com"><img src="<?php echo $path ?>/brand-4.jpg"></img></a></li>
    <li style="padding-right:0"><a href="http://www.apple.com"><img src="<?php echo $path ?>/brand-5.jpg"></img></a></li>
  </ul>
</div>
