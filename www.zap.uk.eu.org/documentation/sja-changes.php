<?php
  // $Id: sja-changes.php,v 1.1 2002/01/23 20:27:04 ds Exp $
  include "../.php/zap-std.inc";
  setroot ('documentation/sja-changes');
  include "../.php/zap-changes.inc";
  zap_header ("Zap - James Aylett's changes", 'up:changes', 'previous:ds-changes', 'next:mje-changes');
  zap_body_start ();
?>

<h1>Changes by James Aylett:</h1>
<ol>
<li>Global clipboard support added. The <code>PASTEGC</code> command pastes the clipborad contents in and <code>CUT</code> and <code>KEEPREGION</code> now affect the global clipboard.  There is also the <code>CLEARGC</code> command which may  be used to determine whether Zap is currently maintaining the clipboard.  As Zap will often own the clipboard's contents while in use, this is not queried when Zap quits.</li>

<li><strong>OLE</strong> support internally to Zap.  This uses code from <em>!ZapOLE</em> - which is no longer required as an extension mode.  Note that this requires an alteration to Zap's <em>!Run</em> and <em>!Boot </em>files to work properly.</li>

<li><code>Newfile</code> command takes mode name and filetype as parameters. From the iconbar it defaults to &amp;FFF and the mode associated with the specified filetype; from a window it defaults to the window's current filetype and mode. This is expected to replace <code>Createfile</code>. (It doesn't set the caret correctly in cases such as &quot;Byte &amp;FFF&quot;. This is being looked into.)</li>

<li><em>Settings</em> variables &amp;30E and &amp;30F modified to execute arbitrary commands. The main advantage is that you can set the adjust type to (eg) NEWFILE&quot;C &amp;FFF&quot;, and create a <em>C</em> file ready to go on an adjust click.</li>

<li>Byte and word mode alterations: number and ascii dumps may be optionally grouped;  number dumps optionally displayed in binary (hex input mode inputs in binary in this case); optionally suppress control characters; tidied colouring.</li>

<li>Fixed bug in <em>Zap-&gt;Remove</em> menu when dealing with modified files.</li>

<li>The <code>FINDFILE</code> command now brings the found window to the front of the window stack if it is already loaded.</li>

<li>More flexible support for context-sensitive help designed and incorporated into most Zap modes (except BASIC, so far). This relies on the <code>ZapText</code> module to provide the actual commands and functions used to interface this with <code>StrongHelp</code>; other interfaces should be possible.</li>

<li><code>ZapText</code> and <code>ZapUtil</code> central command extensions provide replacements for lots of commands in other extensions. In some cases these are identical (sometimes with more useful names); some have been improved. In addition, ZapUtil contains a large number of new functions.</li>

</ol>

<hr>

<?php
  zap_changelog_links ('sja');
  zap_body_end ('$Date: 2002/01/23 20:27:04 $');
?>
