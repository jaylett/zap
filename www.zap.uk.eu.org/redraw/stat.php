<?php
  // $Id: stat.php,v 1.1 2002/01/23 20:27:05 ds Exp $
  $path = $GLOBALS['PATH_INFO'];
  include "../.php/zap-std.inc";
  setroot ('redraw/stat', '/y', '/n');
  zap_header ($path == '/y' ? "ZapRedraw - we know which version you're using" : "ZapRedraw - er, which version...?", "ZR", 'up:../../');
  zapredraw_body_start ();

  if ($path == '/y')
  {
    echo <<<EOF
<h1>We know which version you're using!</h1>

<p>Well, we don't, actually; you're just one more statistic <tt>:-)</tt></p>
EOF;
  }
  else
    echo '<h1>Sorry, I didn\'t quite catch that...</h1><p>Which version?</p>';
?>

<p><a href="../index.html">Click here to return</a> to the previous page.</p>

<?php
  zap_body_end ('$Date: 2002/01/23 20:27:05 $');
?>
