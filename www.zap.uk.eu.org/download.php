<?php
  // $Id: download.php,v 1.1 2002/01/23 20:27:02 ds Exp $
  include ".php/zap-std.inc";
  setroot ('download');
  zap_header ("Zap download page", 'up:/', 'next:mirrors:mirrors');
  zap_body_start ();
?>

<h1>Download area</h1>

<p>The current stable release is <a href="#140">v1.40</a>. An older stable release which might still be useful for some people is <a href="#135">v1.35</a>. The current beta release is <a href="#144">v1.44</a>.</p>

<p>Zap distribution sets are made as 'zipchives' - Zip-format archives, compatible with the free <a href="http://www.cdrom.com/pub/infozip/">InfoZip</a> program (which is available for most operating systems, including RISC OS) and David Pilling's SparkFS. If you don't have either of these, download <a href="http://zap.tartarus.org/ftp/pub/sparkplug.basic.bin">sparkplug.basic.bin</a>, set its type to BASIC and run it - it self-extracts into a copy of SparkPlug into the current directory, which will also read zip archives.</p>

<p>Please use the ftp site if you can; ftp transfer is in general faster than http. In addition, the http-based downloads may not be up to date.</p>

<p>If you need to report a bug, or want to suggest a new feature, please check the <a href="contact">contacts page</a> for the appropriate email address. You should also try to make sure that the bug/feature hasn't already been reported/proposed (the buglist is currently available via the <a href="cvs/">CVS repository</a>, and in recent beta releases).</p>

<p>The official Zap distribution site is <a href="/ftp/pub/">http://zap.tartarus.org/ftp/pub/</a> (also available as <a href="ftp://zap.tartarus.org/pub/">ftp://zap.tartarus.org/pub/</a>). There are currently no mirrors (anyone interested, please <a href="mailto:webmaster@zap.tartarus.org">get in touch</a>).</p>

<ul>
 <li><a href="#144">v1.44</a> - beta phase prior to v1.45
 <li><a href="#140">v1.40</a> - released 26th October, 1998
 <li><a href="#135">v1.35</a> - released 6th November, 1996
 <li><a href="#130">v1.30</a> - released 20th June, 1995
 <li><a href="#old">v1.20</a> - released 25th October, 1994
 <li><a href="#old">v1.10</a> - released 24th March, 1994
 <li>v1.00 - released 22nd October, 1993
 <li>v0.90 - released 25th May, 1993
 <li>v0.80 - released 17th January, 1993
 <li><a href="#old">v0.70</a> - released 29th September, 1992
</ul>

<ul>
 <li><a href="#useful">Useful utils</a> - various things by other people that nestle nicely with Zap
 <li><a class="dir" href="/ftp/pub/configs/">Alternate configs</a>
</ul>

Development release sites
<uL>
 <li><a href="/ftp/pub/ds/">Darren Salt</a>
 <li><a href="/ftp/pub/james/">James Aylett</a>
</ul>

<hr>

<h2><a name="144">v1.44</a></H2>

<p>Version 1.44 of Zap is a public beta phase. We believe it to be fairly stable, and are currently working on getting remaining important bugs fixed prior to a stable release. The current release is beta 7. Grab one of the core archives, plus extensions as required. A minimal ZapFonts is supplied in the core archives; the full one contains many more fonts.</p>

<p>To decide what you need to download, please consult the <a href="/ftp/pub/1.44/test7/.message">list of which extensions are in which group</a>. Alternatively, you can download them <a class="dir" href="/ftp/pub/1.44/test7/individual_modes/">individually</a>.</p>

<ul>
<?php
  function zapfile ($url, $label, $contact, $size, $sig)
  {
    $li = (substr ($label, 0, 1) != '~');
    if (!$li)
      $label = substr ($label, 1);
    echo '<li><a class="file" href="/ftp/pub/', $url, '">', $label, '</a> ';
    if ($contact > '')
      echo '(<a href="contact#', $contact, '">', $contact, '</a>) ';
    if ($size > 4095)
      echo '[', round ($size / 1024, 1), ' Kbytes] ';
    else
      echo '[', $size, ' bytes] ';
    if ($sig > '')
      echo '(<a href="/ftp/pub/', ereg_replace ('\.[^\./]+$', '.asc', $url), '">detached ', $sig, ' signature</a>) ';
    print func_num_args () > 5 ? func_get_arg (5) : "</li>\n";
  }

  function zapdir ($url, $label)
  {
    echo '<li><a class="dir" href="/ftp/pub/', $url, '">', $label, "</a></li>\n";
  }

  zapfile ('1.44/test7/zap.zip', 'Core', 'sja', 668348, '');
  zapfile ('1.44/test7/intl.zip', 'Core - international edition', 'sja', 770729, '');
  zapfile ('1.44/test7/devel.zip', 'Core - developers\' edition', 'sja', 790236, '');
  zapfile ('1.44/test7/mainmods.zip', 'Main modules group', 'sja', 389882, '');
  zapfile ('1.44/test7/develmods.zip', 'Devel modules group', 'sja', 144648, '');
  zapfile ('1.44/test7/devel+mods.zip', 'Second devel modules group', 'sja', 99375, '');
  zapfile ('1.44/test7/riscosmods.zip', 'RISC OS modules group', 'sja', 76837, '');
  zapfile ('1.44/test7/webmods.zip', 'Web modules group', 'sja', 67543, '');
  zapfile ('1.44/test7/descmods.zip', 'Desc modules group', 'sja', 48978, '');
  zapfile ('1.44/test7/zapfonts.zip', 'ZapFonts', 'sja', 944580, '');
  zapdir ('1.44/test7/updates/', 'Updates from previous beta releases');
  zapdir ('1.44/test7/', 'Directory');
?>
</ul>

<hr>

<h2><a name="140">v1.40</a></h2>

<p>Where the extension or distribution set is being maintained by one of the Zap developers, their initials are given in brackets, with a link to contact  details. Otherwise, the name of the extension's author is given, with a link to contact details (if known). There is a <a href="documentation/faq">list of frequently asked questions</a>, and their answers.</p>

<p>Version 1.40 is currently at patch 9; this contains several minor bugfixes and performance improvements. A <a href="documentation/patches">list of changes</a> for the patches is available.</p>

<h3>Core distribution (required)</h3>

<ul>
<?php
  zapfile ('1.40/zap.zip', 'Core (patch 9)', 'ds', 655267, '');
  zapfile ('1.40/core.zip', 'Update from v1.40 initial release to patch-9', '', 214562, '');
  zapfile ('1.40/core.zip', 'Update from v1.40 initial release to patch-9', '', 214562, '');
  zapdir ('1.40/', 'Directory');
?>
</ul>

<h3>Central extensions (suggested)</h3>

<ul>
<?php
  zapfile ('1.40/zfonts.zip', 'ZapFonts', 'sja', 668567, '');
  zapfile ('1.40/zmods1.zip', '~Extension modules group 1', 'ds', 573719, '', "<br>This archive contains:\n");
?>
  <ul>
   <li>Programming modes: C, C++, Java, Assembler, Pascal, BASIC, Obey, MessageTrans, FrontEnd Desc, SAsm, Perl, StrongHelp, BasAsm</li>
   <li>TaskWindow mode</li>
   <li>Email and mailbox modes</li>
   <li>Two HTML modes</li>
   <li>Editing mode for Zap's configuration files</li>
   <li>TeX and LaTeX editing mode</li>
  </ul>
  <ul>
   <li>Zap's spelling system</li>
   <li>Support for toolbars</li>
   <li>Several command extensions</li>
  </ul>
 </li>
</ul>

<h3>Additional extensions</h3>

<ul>
<?php
  zapfile ('1.40/zmods2.zip', '~Extension modules group 2', 'tmt', 172628, '', "<br>This archive contains:\n");
?>
  <ul>
   <li>Programming modes: Makefile, Ada, Asm, PostScript, Inform
   <li>CSV file mode
   <li>SQL and Scheme document modes
   <li>Primitive manpage viewer
  </ul>
 </li>
<?php
  zapfile ('1.40/zapres.zip', 'Additional resources', 'tmt', 118608, '');
?>
</ul>

<h3>Extension updates</h3>

<ul>
<?php
  zapfile ('1.40/zmods1_update.zip', 'Update from initial release to current extension modules group 1', '', 138784, '');
  zapfile ('1.40/zapconfig.zip', 'ZapConfig', 'sja', 64615, '');
  zapfile ('1.40/ZapEmail023.zip', 'ZapEmail', 'ds', 63578, 'PGP');
?>
</ul>

<h3>Source</h3>

<ul>
<?php
  zapfile ('1.40/src/zapsrc.zip', 'Core', 'sja', 476755, '');
  zapfile ('1.40/src/zrdsrc.zip', 'ZapRedraw', 'ds', 50630, '');
  zapfile ('1.40/src/zbsrc.zip', 'ZapBASIC', 'tmt', 107351, '');
  zapfile ('1.40/src/tmtsrc.zip', 'Tim\'s modes', 'tmt', 650449, '');
  zapfile ('1.40/src/mjesrc.zip', 'ZapMJE', 'tmt', 234557, '');
  zapfile ('1.40/src/ZEmailSrc.zip', 'ZapEmail', 'ds', 62072, 'PGP');
  zapfile ('1.40/src/extssrc.zip', 'Combined command extensions', 'sja', 96253, '');
  zapdir ('1.40/src/', 'Directory');
?>
</ul>

<hr>

<h2><a name="useful">Useful utils</a></h2>

<p>Note that these are written and maintained by other people; we can't guarantee they'll work properly, and please don't send us bug reports! Let us know if any of the links are out of date, though...</p>

<ul>
 <li><a href="http://sudden.recoil.org/stronghelp/">StrongHelp</a> - a hypertext help system by Guttorm Vik; invaluable if you're programming under RISC OS</li>
 <li><a href="http://www.muscat.com/~olly/software/">Line Editor</a> by Olly Betts - makes the command line and taskwindows much nicer to use (this is also bundled with Zap) (see also <a href="http://www.youmustbejoking.demon.co.uk/progs.utils#lineeditor">here</a>)</li>
</ul>

<hr>

<h2><a name="135">v1.35</a></h2>

<p>v1.35 is believed to be the last version of Zap to support RISC OS 2.</p>

<h3>Core distribution (required)</h3>

<ul>
<?php
  zapfile ('1.35/zap.zip', 'Core', '', 961305, '');
  zapdir ('1.35/', 'Directory');
?>
</ul>

<h3>Updates to versions in the core distribution</h3>

<ul>
<?php
  zapfile ('1.35/zapconfig.zip', 'ZapConfig', '', 71240, '');
  zapfile ('1.35/zapds.zip', 'ZapDS', '', 36175, '');
  zapfile ('1.35/zapemail.zip', 'zapemail.zip', '', 104986, '');
  zapfile ('1.35/zapenh.zip', 'zapenh.zip', '', 7306, '');
  zapfile ('1.35/zapextern.zip', 'zapextern.zip', '', 6027, '');
  zapfile ('1.35/zapole.zip', 'zapole.zip', '', 3534, '');
?>
</ul>

<hr>

<h2><a name="old">Ancient versions</a></h2>

<ul>
<?php
  zapfile ('1.30/zap.zip', 'v1.30 core', '', 647581, '');
  zapfile ('1.30/wagenaar.zip', 'SoftWrap and DWExt updates for v1.30', '', 48085, '');
?>
</ul>

<ul>
<?php
  zapfile ('1.20/zap.arc', 'v1.20', '', 489531, '');
  zapfile ('1.10/zap.zip', 'v1.10', '', 296200, '');
  zapfile ('0.70/zap.zip', 'v0.70', '', 48847, '');
?>
</ul>

<?php
  zap_body_end ('$Date: 2002/01/23 20:27:02 $');
?>
