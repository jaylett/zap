<?php
  // $Id: mje-changes.php,v 1.1 2002/01/23 20:27:04 ds Exp $
  include "../.php/zap-std.inc";
  setroot ('documentation/mje-changes');
  include "../.php/zap-changes.inc";
  zap_header ("Zap - Martin Ebourne's changes", 'up:changes', 'prev:sja-changes', 'next:jrf-changes');
  zap_body_start ();
?>

<h1>Changes by Martin Ebourne:</h1>

<ol>
 <li>CreateConf written and used to provide plug-and-play configuration for Zap extension modules.  More details are in the documentation which accompanies CreateConf (in !Zap.Code.Config).</li>
 <li>The 'Smart shift-cursor keys' originally used in C code has been added centrally to Zap.</li>
 <li>The 'ALTERSEL' command is now present centrally in Zap's core.</li>
</ol>

<hr>

<?php
  zap_changelog_links ('mje');
  zap_body_end ('$Date: 2002/01/23 20:27:04 $');
?>
