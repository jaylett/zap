<?php
  // $Id: mirrors.php,v 1.1 2002/01/23 20:27:02 ds Exp $
  include ".php/zap-std.inc";
  setroot ('mirrors');
  zap_header ("Zap download mirrors", 'up:/', 'previous:download:download', 'next:cvs/:cvs');
  zap_body_start ();
?>

<h1>Download mirrors</h1>

<p>If you can provide mirror space somewhere with a decent amount of bandwidth, please get in touch with <a href="mailto:webmaster@zap.tartarus.org">webmaster@zap.tartarus.org</a>.</p>

<p>Currently there are no mirrors.</p>

<?php
  zap_body_end ('$Date: 2002/01/23 20:27:02 $');
?>
