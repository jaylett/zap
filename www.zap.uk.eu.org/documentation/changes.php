<?php
  // $Id: changes.php,v 1.1 2002/01/23 20:27:04 ds Exp $
  include "../.php/zap-std.inc";
  setroot ('documentation/changes');
  include "../.php/zap-changes.inc";
  zap_header ("Zap - Changes", 'up:index', 'first:tmt-changes', 'last:dw-changes');
  zap_body_start ();
?>

<h1>Changes</H1>

<p>The complete Zap changelog is not currently available. You can get the wish/bug/change list for post-v1.40 from the <a href="/cvs/">CVS repository</a>.
</p>

<?php
  zap_changelog_links ('');
  zap_body_end ('$Date: 2002/01/23 20:27:04 $');
?>
