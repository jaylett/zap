<?php
  // $Id: jrf-changes.php,v 1.1 2002/01/23 20:27:04 ds Exp $
  include "../.php/zap-std.inc";
  setroot ('documentation/jrf-changes');
  include "../.php/zap-changes.inc";
  zap_header ("Zap - Justin Fletcher's changes", 'up:changes', 'previous:mje-changes', 'next:dw-changes');
  zap_body_start ();
?>

<h1>Changes by Justin Fletcher:</h1>

<ol>
 <li>Code mode now uses embedded debugging information to provide the names of functions in branches and when they are defined, in compiled and linked code.</li>
 <li>Code mode also now displays information on <em>AIF headers</em>, and information relating to embedded (and possibly indirected) strings.
 <li>Zap_Command command added centrally to Zap from ZapJRF.  This allows other applications to execute Zap commands conveniently.</li>
</ol>

<hr>

<?php
  zap_changelog_links ('jrf');
  zap_body_end ('$Date: 2002/01/23 20:27:04 $');
?>
