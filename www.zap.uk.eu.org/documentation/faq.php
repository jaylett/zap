<?php
  // $Id: faq.php,v 1.5 2002/11/07 11:08:38 james Exp $
  include "../.php/zap-std.inc";
  setroot ('documentation/faq');
  zap_header ("Zap FAQs", 'up:index');
  zap_body_start ();
?>

<h1 align=center>Zap 1.45 FAQ</h1>

<p>
<em>This FAQ covers common issues raised by the current version of Zap only - it is not intended to be a general Zap FAQ.</em> Answers to many of the frequently asked questions about Zap are addressed in the relevant !Help files. This document does not attempt to address questions such as &quot;Can I get a program like Zap for other operating-systems?&quot; either.
</p>

<p>
If you don't understand any answer we've given in this FAQ, please ask. If you think that we've missed out some important question, tell us. Your feedback is needed to help us to further improve this FAQ.
</p>

<?php
  $qa = array ('');
  array_shift ($qa);

  function addSection (&$qa, $k, $s)
  {
    $qa[] = array ('KEY'=>$k, 'TITLE'=>$s);
  }

  function addQa (&$qa, $k, $q, $a)
  {
    $qa[count ($qa) - 1]['CONTENT'][] = array ($k, $q, $a);
  }

  function listQs (&$qa)
  {
    echo '<ul>';
    foreach ($qa as $qs)
    {
      echo '<li><p><big><a href="#', $qs['KEY'], '">', $qs['TITLE'], "</a></big></p><ul>";
      foreach ($qs['CONTENT'] as $q)
      {
	echo '<li><a href="#', $qs['KEY'], '.', $q[0], '">', $q[1], '</a>';
      }
      echo "</ul></li>\n";
    }
    echo '</ul>';
  }

  function listQAs (&$qa)
  {
    foreach ($qa as $qs)
    {
      echo '<h3><a name="', $qs['KEY'], '">', $qs['TITLE'], "</a></h3><dl>";
      foreach ($qs['CONTENT'] as $q)
      {
	echo '<dt class="question"><a name="', $qs['KEY'], '.', $q[0], '">', $q[1], '</a></dt><dd>', $q[2], '</dd>';
      }
      echo "</dl>\n";
    }
  }

  addSection ($qa, 'where', 'Where can...?');
  addQa ($qa, 'faq', 'Where can this FAQ be obtained?',
	'<p>It normally resides at <a href="http://zap.tartarus.org/faq">http://www.zap.tartarus.org/faq</a> and it is included in the main distribution as <code>!Zap.Docs.FAQ</code>.</p>');
  addQa ($qa, 'zap', 'Where can Zap be downloaded?',
	'<p><a href="http://zap.tartarus.org/">http://www.zap.tartarus.org/</a> is the main Zap web site. <a href="http://zap.tartarus.org/ftp/pub/">http://zap.tartarus.org/ftp/pub/</a> is the web interface to the main Zap ftp site, <a href="ftp://zap.tartarus.org/">ftp://zap.tartarus.org</a>.');

  addSection ($qa, 'inter', 'Zap\'s interaction with other applications');
  addQa ($qa, 'fresco', 'Why doesn\'t OLE from Fresco work?',
	'<p>If you tick <code>Options.Misc.Be Tolerant</code> in <em>Zap\'s</em> icon bar menu then it will work. This is necessary because <em>Fresco</em> supports a slightly unorthodox variant of the OLE protocol.</p>');
  addQa ($qa, 'ole', 'OLE now works, but why does it give error messages?',
	'<p>They\'re as unobtrusive warnings as is possible. It is felt that some kind of warning is necessary otherwise programmers might not notice that their programs have problems which will cause them to fail to work properly with some existing OLE clients.</p>');
  addQa ($qa, 'arcweb', 'Why doesn\'t OLE from ArcWeb work?',
	'<p>It <em>should</em> do, but you have to make sure that you save files in the same spot that <em>ArcWeb</em> told <em>Zap</em> to load them from. If you save them elsewhere, <em>Zap</em> dutifully informs <em>ArcWeb</em> of this, but it doesn\'t appear to become aware that the file has moved.</p>');
  addQa ($qa, 'edit', 'Why does Edit gets loaded these days and not Zap?',
	'<p>When <em>Zap</em> gets booted by the filer it no longer claims shift-double-clicks on files, text files, task windows, OLE, or \'external edits\', if these have been claimed by another application.</p>'.
	'<p>The simplest solution to the problem of <em>Edit</em> loading is simply not to boot <em>Edit</em> in the first place. Unfortunately, on machines with <em>Edit</em> in ROM, this may not be a simple process.</p>'.
	'<p>As a consequence of this difficulty in uninstalling <em>Edit</em>, an \'<em>Obey</em>\' file is provided which \'unboots\' any other editors which the filer has seen.</p>'.
	'<p>There is a call to this file at the top of <code>ZapUser:Config.!ZapBoot</code>. It is commented out by default.</p>'.
	'<p>Some applications have been known to start up the resident text editor manually and the method used does not always work with this version of Zap.  Sometimes contacting the author of the application can resolve such matters.</p>');

  addSection ($qa, 'zr', 'ZapRedraw');
  addQa ($qa, 'other', 'Will other programs which use <em>ZapRedraw</em> work OK?',
	'<p>There are no known problems with ZapRedraw; however, since v1.40 of Zap, bitmap fonts have lived in the <code>!ZapFonts</code> resource application rather than within the <code>!Zap</code> application itself, and older programs may not recognise this change. It has been in place for a while now, so recent programs should be fine.</p>'.
	'<p>There appear to have been some problems with people using multiple copies of ZapFonts on their system - sometimes the one which gets booted first does not contain all the expected fonts.  ZapFonts is intended to be a central resource and it is best to ensure that you maintain a central copy of it; <code>$.!Boot.Resources</code> is a good place to put it.</p>');

  addSection ($qa, 'config', 'Configuring Zap');
  addQa ($qa, 'where', 'Where do configuration files live these days?',
	'<p>In the <code>ZapUser:Config</code> directory. All files which might need to be edited are now stored there. The idea is that you keep your copy of <code>!ZapUser</code>, and upgrade Zap simply by using in the new <code>!Zap</code> application instead of the old one (and probably upgrading <code>!ZapFonts</code> at the same time).</p>');
  addQa ($qa, 'fontgrey', 'Why are the font menus on the iconbar greyed out?',
	'<p>Currently, it is not possible to configure the fonts that Zap uses from the iconbar menu. If you wish to configure the fonts, you should change the relevant variables in <code>ZapUser:Config.Settings</code>. For more information, please see the relevant section in <a href="manual/Contents">the manual</a>.</p>');
  addQa ($qa, 'old', 'Can I use my old configuration with the new version?',
	'<p>If you were previously using v1.40 of Zap, you can keep on using your <code>!ZapUser</code> configuration. Note, however, that you won\'t get all the benefit of the latest version unless you upgrade your configuration at the same time as Zap; see <a href="#config.from140">here</a></p>'.
	'<p>If you are upgrading from version v1.35 or earlier, you will need to use the copy of <code>!ZapUser</code> supplied with the new version of Zap, and merge your old configuration with it. See <a href="#config.from135">here</a> for more information on how to do this. Note also that information about extensions does not need to be added by hand any more; and also, that extensions from v1.35 almost certainly won\'t work with v1.45. (However there are no extensions we know of that do not have recent versions that <em>will</em> work with v1.45.)</p>');
  addQa ($qa, 'from140', 'Upgrading configuration from v1.40 to v1.45',
	'<p>From v1.40 onwards, all configuration lives in <code>ZapUser:Config</code>. In general, most of these files do not change from version to version, and so you don\'t need to worry about updating them. For v1.40 to v1.45, the following changes need to be made:</p>'.
	'<ul>'.
	' <li><p><code>!ZapBoot</code> has changed substantially; it is suggested that you copy the new version over and make any changed you need. In practice, you are unlikely to have changed anything, except perhaps the file type claims (lines such as <code>ZapRunType FFF</code>).</p></li>'.
	' <li><p><code>!ZapRun</code> has changed substantially to support internationalisation; it is suggested that you copy the new version over and make any changes you need. In practice, the only parts you are likely to have changed are the templates set, and perhaps the file type claims. Note that some template sets haven\'t been updated for v1.45, and so aren\'t supplied any more (and see <a href="#bug.a7000+">here</a>). In addition, note that the old system variables <code>Zap$HelpPath_&lt;mode&gt;</code> are no longer required.</p></li>'.
        ' <li><p><code>!ZapBooted</code> has been added to complete the Zap boot sequence.</p></li>'.
	' <li><p><code>Country</code> has been added to support internationalisation; it can be used to override your system country. You should copy this file over, and edit it if you need to set your country explicitly.</p></li>'.
	' <li><p><code>Settings</code> has had two variables added. &amp;322 can be used to specify a command to execute on startup, and &amp;323 specifies the default mode. See the manual for more information.</p></li>'.
	' <li><p>A directory <code>TMFs</code> has been added. You should copy this across. TMFs are files that set per-mode variables, used to make some commands and operations more configurable. See the manual for more information.</p></li>'.
	' <li><p>The <code>Keys</code> file has changed significantly; firstly, the method of specifying alternate keymaps has changed from using &amp;400 variables in a block, to using &amp;800 variables immediately before the keymap in question, to declare them. Secondly, support for country-specific <code>Keys</code> files has been added; instead of a single file, you should have a directory, <code>ZapUser:Config.Keys</code>, containing a file for each country (eg: <code>ZapUser:Config.Keys.UK</code>, <code>ZapUser:Config.Keys.France</code>).</p>'.
	'  <p>Unless you made significant alterations to your keys file, we suggest that you copy in the new keys directory and make any changes you need. Alternatively, move your current <code>ZapUser:Config.Keys</code> to <code>ZapUser:Config.Keys.UK</code> (or another country name, as appropriate), and edit it to use the new file format.</p>'.
	'  <p>See the manual for more information about internationalisation, and about the new <code>Keys</code> file format.</p></li>'.
        ' <li><p>Two files, <code>FileIdHigh</code> and <code>FileIdLow</code>, have been added to support auto-detection of file types based on theirs contents.</p></li>'.
	' <li><p>The <code>Menus</code> file has also become internationalised, in the same way. In addition, we now generate menus files from a source format which allows you to name menus instead of referring to them by number. Further, areas of the source file can be made optional - the idea is that more or less everyone can use the same source file, while still being able to configure things a fair amount. We strongly suggest that, if you don\'t like the new default menus, you copy the new menus directory, look at, and possibly edit, the appropriate source file (they are supplied in the directory <code>ZapUser:Config.Menus.Source</code>), and generate your menus file from that.</p>'.
	'  <p>See the manual for more information about internationalisation, and about the new <code>Menus</code> source format, and the method for generating the final file from source.</p></li>'.
	'</ul>');
  addQa ($qa, 'from135', 'Upgrading configuration from v1.35 or earlier to v1.45',
	'<p>Up to version 1.35, configuration of Zap lived in three files: <code>!Zap.!Config</code>, <code>!Zap.Menus</code>, and <code>!Zap.Keys</code>. Since then, all configuration has lived inside a new application directory, <code>!ZapUser</code>. We strongly advise that you try the new configuration as it stands, simply copying <code>!Zap.!Config</code> to <code>ZapUser:Config.!Config</code>, to preserve editing and display configuration.</p>'.
	'<p>(Note that if you do this, however, many of Zap\'s newer features will not be enabled - you would be advised to spend some time looking through the menus and playing with the new options, or to browse either the Changes file, supplied as <code>ZapResources:Docs.Changes</code>, or the entire manual, to get an idea of what Zap is now capable of.)</p>'.
	'<p>If you choose to copy your configuration across, you will need to install the <code>!ZapUser</code> application directory that comes with the new version of Zap, and then copy individual files. Note, however, that the old <code>Keys</code> file has been split into several different files: <code>Keys</code>, <code>Settings</code>, <code>TypesHigh</code> and <code>TypesLow</code>; and that many things have changed - in particular, many path checks (&amp;500 variables) and filetype checks (&amp;1xxx variables) no longer live in the user configuration, but are stored with the extension that they use.</p>'.
	'<p>Upgrading configuration by hand from v1.35 or earlier to v1.45 is a long and difficult process. It is far easier to take a fresh v1.45 configuration and adapt that to your needs.</p>'.
	'<p>Note also that brackets in key definitions are treated slightly differently from <em>Zap 1.35</em> - they no longer act as comments.</p>');
  addQa ($qa, 'hideptr', 'Why isn\'t \'HidePtr\' loaded with Zap these days?',
	'<p>Because it\'s not universally popular. Loading it automatically is an <em>option</em> available from the <code>Options.Misc.Autoload</code> menu.</p>');

  addSection ($qa, 'mode', 'Modes and extensions');
  addQa ($qa, 'softwrap', 'SoftWrap mode is missing! What have you done with it?',
	'<p>There\'s no <em>SoftWrap</em> mode any more because soft-wrap is now a <em>wrap option</em> for most modes. As <em>Text</em> mode can now perform soft-wrap, there\'s no longer any need for a separate <em>SoftWrap</em> mode.</p>');
  addQa ($qa, 'extx', 'Zap extension <em>Wibble</em> isn\'t included - can I plug it in?',
	'<p>If it is a extension from v1.40, then it should be available in a version for v1.45 (although most v1.40 extensions will work with v1.45 anyway). Older extensions probably won\'t work.</p>');

  addSection ($qa, 'control', 'Controlling Zap');
  addQa ($qa, 'keymod', 'Why does Zap sometimes fail to take notice of <em>Shift</em> and <em>Ctrl</em>?',
	'<p>Zap must wait until it is told about the keypress before it can attempt to distinguish between various different key combinations which produce the same character codes, eg. Ctrl-A and Shift-Ctrl-A, Return and Shift-Return, Ctrl-H and Backspace.</p>'.
	'<p>If an application decides that it needs to single-task for even a few seconds, it may happen that you release the keys fractionally too early (Zap thinks that they\'re not being pressed) or that you press another key before Zap has processed the previous one.</p>'.
	'<p>(It\'s worth mentioning that Zap doesn\'t check for ambiguities where there can be none, eg. when it\'s told that you\'ve pressed a function key.)</p>'.
	'<p>The problems can be fixed, for Zap at least, by using the <em>DeepKeys</em> module, which logs Shift, Ctrl and Alt keypresses and also the key to which they apply. If you have problems with this module, we\'d like to hear about them :-)</p>'.
	'<p>Before Zap started using <em>DeepKeys</em>, it used another module named <em>KeyboardExtend</em>; this provided much the same functionality but would suffer from synchronisation problems (applications which do not correctly process the key up/down event, upon which <em>KeyboardExtend</em> relies, do not help here...). To fix any such problems, simply issue <kbd>*RMReinit KeyboardExtend</kbd>. (The problem apps need to have a more recent claim on EventV in order to be able to cause this problem, which is why that *command fixes the problem; it forces KeyboardExtend to have the more recent claim.)</p>'.
	'<p>Known problem applications and modules:</p>'.
	'<table border=0>'.
	' <tr><td valign=top><em>Module:</em></td><td><samp>386Support 1.90 (14 Sep 1995)</samp></td></tr>'.
	' <tr><td valign=top><em>Location:</em></td><td><tt>!PC.DivaRM</tt></td></tr>'.
	' <tr><td valign=top><em>Fix:</em></td><td>Load into Zap, goto address &amp;3E4 (<code>LDMFD R13!,{R0-R4,R14,PC}^</code>), press <em>Return</em>, delete the <code>,R14</code>, press <em>Return</em>, then save.<br>Other versions may be similarly affected.</td></tr>'.
	'</table>');
  addQa ($qa, 'menukey', 'I\'ve assigned some commands to the Menu and Window keys, but using some other key combinations executes those commands.',
	'<p>For some reason, the UniversalKey module is active. Disable it with <kbd>*UKeyboard_Off</kbd>. (This module is only meant to be active when an application which uses it has the input focus.)</p>');
  addQa ($qa, 'mmkey', 'How do I assign commands to the multimedia keys on my horrendously expensive and over-featured multimedia keyboard?',
	'<p>You can\'t. Perhaps one day...</p>');

  addSection ($qa, 'changes', 'Changes to Zap');
  addQa ($qa, 'recent', 'What are the recent changes?',
	'<p>The changes since the version 1.40 release are covered in the <a href="changes"><code>ZapResources:Docs.Changes</code></a> file.</p>'.
	'<p>Zap\'s history prior to version 1.35 will hopefully be made available on <a href="http://www.zap.tartarus.org/">the Zap web site</a> at some point.</p>');
  $buglist = '<p>James Aylett is maintaining a combined bug and wishlist. You can access it through the <a href="http://cvs.tartarus.org/zap/sja-notes/Buglist,fff">CVS gateway</a>. (Simply select the revision with the highest number, which will be at the top.)</p>';
  addQa ($qa, 'planned', 'What is planned for future versions?',
	$buglist);

  addSection ($qa, 'discuss', 'Talking about Zap');
  addQa ($qa, 'lists', 'Are there mailing lists where people discuss Zap?',
	'<p>Yes; see the <a href="http://www.zap.tartarus.org/lists">page about the lists</a> on the web site.</p>');

  addSection ($qa, 'bug', 'Bugs and misfeatures in Zap');
  addQa ($qa, 'list', 'Is there a list of known bugs somewhere?',
	$buglist);
  addQa ($qa, 'a7000+', 'I hear Zap has a problems when run on the A7000+.',
	'<p>A7000+s (and <em>possibly</em> some other computers), appear to have corrupt versions of some of the ROM fonts, notably <em>Homerton.Medium.Oblique</em>. Viewing this can cause the desktop font to be reset to the system font.</p>'.
	'<p>The template set \'OldStyle\' uses some of these, and previously was the default template set for Zap. The default set does not have these problems.</p>');
  addQa ($qa, 'found', 'I\'ve found a bug! What should I do?',
	'<p>Tell us about it. Please send bug reports to <a href="mailto:bugs@zap.tartarus.org">bugs@zap.tartarus.org</a>, and <strong>not</strong> to any of the mailing lists.</p>');

  echo "<h2>Questions</h2>\n";

  listQs ($qa);

  echo "<hr>\n<h2>Answers</h2>\n";

  listQAs ($qa);

  zap_body_end ('$Date: 2002/11/07 11:08:38 $');
?>
