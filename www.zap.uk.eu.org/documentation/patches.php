<?php
  // $Id: patches.php,v 1.1 2002/01/23 20:27:04 ds Exp $
  include "../.php/zap-std.inc";
  setroot ('documentation/patches');
  zap_header ("Zap - patch changes to 1.40", 'up:changes', 'next:recent:recent');
  zap_body_start ();
?>

<h1>Patch changes</h1>

<ul>
<li>Patch 1 (09/11/98)
 <ul>
  <li>DS: two scrolling bugs fixed</li>
 </ul></li>
<li>Patch 2 (10/11/98)
 <ul>
  <li>DS: block editing when not in the selection fixed</li>
  <li>DS: search and replace bug fixed</li>
 </ul></li>
<li>Patch 3 (20/11/98)
 <ul>
  <li>SJA: checksum calculation on loading file moved to look nicer</li>
  <li>DS: shift-drag of files fixed wrt name/file insertion</li>
 </ul></li>
<li>Patch 4 (23/11/98)
 <ul>
  <li>DS: checksumming long op fixed</li>
  <li>DS: default config no longer initialised from</li>
  <li>SJA: Patch levels now noted in code</li>
 </ul></li>
<li>Patch 5 (24/11/98)
 <ul>
  <li>SJA: Throwback adjust-and-hold bug fixed</li>
 </ul></li>
<li>Patch 6 (27/11/98)
 <ul>
  <li>SJA: Iconbar menu alignment, and KeyboardExtend back in the main archive</li>
 </ul></li>
<li>Patch 7 (21/12/98)
 <ul>
  <li>SJA: Updated manual, buffer overrun fix for WC and related commands</li>
  <li>Dan Ellis: Cursor movement bugfix</li>
  <li>SJA: (Source change only) Start of alterations to allow Unix-hosted builds</li>
 </ul></li>
<li>Patch 8 (29/01/99)
 <ul>
  <li>DS: DDE current directory in various commands</li>
  <li>DS: universal argument sets hourglass</li>
  <li>DS: Selection autoclr works with block edit, INDENT/OUTDENT</li>
  <li>DS: UNIVERSALARG can take numbers from keypad</li>
  <li>DS: Fixes to FINDFILE and OPENPARENT wrt taskwindows</li>
  <li>DS: now tries hard to find writeable area for on-the-fly files</li>
 </ul></li>
<li>Patch 9 (14/02/99)
 <ul>
  <li>DS: Obey$Dir preserved when loading an extension mode</li>
  <li>DS: Distribution now fixed</li>
 </ul></li>
</ul>

<?php
  zap_body_end ('$Date: 2002/01/23 20:27:04 $');
?>
