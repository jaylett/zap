<?php
  // $Id: dw-changes.php,v 1.1 2002/01/23 20:27:04 ds Exp $
  include "../.php/zap-std.inc";
  setroot ('documentation/dw-changes');
  include "../.php/zap-changes.inc";
  zap_header ("Zap - Daniel Wagenaar's changes", 'up:changes', 'prev:jrf-changes', 'next:tmt-changes');
  zap_body_start ();
?>

<h1>Changes by Daniel Wagenaar:</h1>
<ol>
 <li>Softwrap mode has now been added centrally to Zap.  It has been etended so that soft-wrap may be an aspect of most modes, and modes may choose which characters may be soft-wrapped on.</li>
</ol>

<hr>

<?php
  zap_changelog_links ('dw');
  zap_body_end ('$Date: 2002/01/23 20:27:04 $');
?>
