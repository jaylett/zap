<?php
  // $Id: recent.php,v 1.1 2002/01/23 20:27:04 ds Exp $
  include "../.php/zap-std.inc";
  setroot ('documentation/recent');
  zap_header ("Zap - Changes", 'up:changes', 'previous:patches:patches');
  zap_body_start ();
?>

<h1>Recent changes</h1>

<h3>Changes between beta twelve and Zap 1.40.</h3>
<ol>
<li>The <em>!Help</em> file completely revamped by James.  Many changes were also made to the FAQ and other technical documentation.
<li>Support for coloured printing added by Darren.
<li>Keyboard Extend, which curbs problems associated with modifier keys being 'lost', added by Darren.
<li>Static expression Types implemented.
<li>Line Editor 2.73 included, thanks to Olly Betts.
<li>Debugger Plus updated.
<li>Lots of minor changes to a number of extension modules.
<li>A number of bugs in beta twelve fixed:
<ul>
 <li>Most betas had suffered from a bug in the undo buffer - this should now have finally been fixed.
 <li>Behaviour of the caret in the 'save box' fixed.
</ul>
</ol>

<h3>Changes between beta eleven and beta twelve.</h3>
<ol>
<li>A number of additions by Darren:
<ul>
 <li>Named keymaps implemented.  These are tickable on the (new) menu which lists them.  Their names are defined in a new section in the '<em>Keys</em>' file (included).
 <li>Adjust-click fixed for the case where the input focus is in a different <em>Zap</em> editing window.
 <li>New Zap call, <code>Zap_ClaimMessage</code>. Necessary for protocols where a <em>SWI</em> may be replied to with a <em>WIMP message</em>; Acorn's <em>URI dispatch protocol</em> is one such.
</ul>
<li>New versions of large numbers of extension modes.
<li>New 'Debugger', new 'Taskwindow' loader, new 'Eval' filter provided, etc.
<li>Simple 'Total' command adds up any integers in the selected region.

<li>A number of bugs in beta eleven fixed:
<ul>
 <li>'Persistent save box' bug rectified.
 <li><em>Global clipboard</em> support now works better with some clients.
 <li>The 'file modified' hash function should now work more rapidly.
 <li>*<code>ZapCommand</code> rewritten to use pollwords.  It should now work correctly.
 <li>Cursor now flashes properly during intensive taskwindow output.
 <li>Rewrite of code which identifies FP/co-processor opcodes in <em>Code</em> mode.
</ul>
</ol>

<h3>Changes between beta ten and beta eleven.</h3>
<ol>
<li>The &quot;File modified&quot; flag now works in a more intelligent manner.
<li><em>Zap</em> now really saves files which it believes are unmodified when it is asked to.

<li>A number of additions by Darren:
<ul>
 <li>Option to make the horizontal scroll bar disappear when not needed.
 <li>Extensive changes to Zap's type checking which is now stronger.
 <li>The <code>HELP</code> commands now tell you if no help text has been found.
 <li>Parentheses may be used around numeric arguments in commands.
</ul>
<li>New versions of large numbers of extension modes.

<li>A number of bugs in beta ten fixed:
<ul>
 <li>  * Horizontal scroll bar not working properly.
 <li>'~' backup delay still wasn't working correctly.
</ul>
</ol>

<h3>Changes between beta nine and beta ten.</h3>
<ol>
<li>A number of additions by Darren:
<ul>
 <li><code>CASE...WHEN...DEFAULT...ENDCASE</code> implemented.
 <li><code>CWHEN</code> implemented; functionally like 'case' in C/C++/Java.
 <li><code>BREAK</code> and <code>CONTINUE</code> implemented for looping constructs.
 <li>String expression evaluation now available (<code>Zap_EvaluateExpression</code>).
</ul>
<li>New versions of <em>ZapEmail, ZapDS, ZapText, ZapNewMail</em> and <em>ZapSpell</em>.

<li>A number of bugs in beta nine fixed:
<ul><li>Bug stopping minibuffer commands in learnt sequences operating.
 <li>Interactive help on menu entries sorted out.
 <li>'~' backup delay wasn't working correctly.
</ul>
</ol>

<h3>Changes between beta eight and beta nine.</h3>
<ol>
<li><em>James</em> has provided a new <em>ZapText</em>. This contains lots of new work including much improved support for <em>StrongHelp</em>, and commands to allow <em>Zap</em> to interface better with othe text manipulation programs. See <em>!ZapText.HelpData</em> for details of the new commands.</li>

<li><em>Darren</em>'s support for dynamic and static command arguments implemented. This allows things like: <code>INSERT $(Sys$Time)</code> to be used.</li>

<li><em>Justin</em>'s extended his support for decoding a variety of objects in Code mode. This now includes names of C library function calls.</li>

<li>A number of bugs in beta eight fixed:
<ul>
<li>Bug preventing the outline font being changed fixed.</li>
<li>Problem with the '<em>IfThere</em>' utility was not fixed properly in beta 5.</li>
</ul>
</ol><P>

<h3>Changes between beta seven and beta eight.</h3>
<ol>
<li><em>Darren</em>'s <code>REPEAT...UNTIL</code> and <code>WHILE...ENDWHILE</code> implemented.</li>
<li>Some small cosmetic improvements to <em>Code</em> mode.</li>
<li>A number of bugs in beta seven fixed:
<ul>
<li>Search as you type would often fail to draw the cursor.</li>
<li>Windows onto new views no longer brought to the top when text inserted.</li>
</ul>

<li><em>Darren</em>'s '<em>Block editing</em>' code activated. This enables actions taken on individual lined to be duplicated on all the lines in the selected region with no additional effort on the part of the user.</li>
<li><em>Justin</em>'s AIF header detection, and recognition of string pointers and indirected string pointers in <em>Code</em> mode included.</li>
<li>Bitmap fonts load faster, and the delay when checking for them when they are already used in another document has been much reduced.</li>
<li>The first of the icon bar file handling improvements has been made.</li>
<li>A number of bugs in beta six fixed:
<ul>
<li>TaskWindow clicks weren't working properly.</li>
<li>Opening various icon bar options submenus no longer cause exceptions.</li>
</ul></ol><P>

<h3>Changes between beta six and beta seven.</h3>
<ol>
<li><em>Darren</em>'s '<em>Block editing</em>' code activated. This enables actions taken on individual lined to be duplicated on all the lines in the selected region with no additional effort on the part of the user.</li>
<li><em>Justin</em>'s AIF header detection, and recognition of string pointers and indirected string pointers in <em>Code</em> mode included.</li>
<li>Bitmap fonts load faster, and the delay when checking for them when they are already used in another document has been much reduced.</li>
<li>The first of the icon bar file handling improvements has been made.</li>
<li>A number of bugs in beta six fixed:
<ul>
<li>TaskWindow clicks weren't working properly.</li>
<li>Opening various icon bar options submenus no longer cause exceptions.</li>
</ul></ol><P>

<h3>Changes between beta five and beta six.</h3>
<ol>
<li>A number of bugs in beta five fixed:
<ul>
<li>Errors were <em>still</em> not being reported properly when saving files.</li>
<li>Selecting regions in learned sequences didn't always work properly.</li>
<li>Window stack order could be disturbed by changing mode.</li>
<li>Code to add spaces in <code>COPYSEL</code> and <code>MOVESEL</code> was disabled by mistake.</li>
<li><em>IfThere</em> command ungracefully gave an error if it was asked to check for files on non-existent paths.</li>
<li>Save/Discard/Cancel window could <em>still</em> get broken sometimes.</li>
</ul>
<li>Darren's <em>'ClickSend'</em> protocol put in place. This describes how Zap responds to alt-double-clicks - currently URLs are broadcast and a <em>StrongHelp</em> lookup is performed.</li>
<li>Some minor improvements to <em>Taskwindow</em> mode.</li>
</ol><P>

<h3>Changes between beta four and beta five.</h3>
<ol>
<li>A number of bugs in beta four fixed:
<ul>
<li><code>DS_EVAL</code> and a number of other commands which use a minibufer prompt didn't work if the module they were in wasn't loaded.</li>
<li>Due to a problem with Zap, <code>EMAIL_SPLITFORINSERT</code> and other similar commands didn't work at all.</li>
<li>Errors were not being reported properly when saving files.</li>
<li><em>NewMail</em> mode was completely broken.</li>
<li><em>ZapBASIC</em> <code>FINDFILE</code> in an empty buffer caused aborts.</li>
<li>There was a <em>ZapRedraw</em> bug which sometimes caused all text to invert.</li>
</ul>
<li>There have been a number of changes to <em>ZapMJE</em>. These improve it's speed slightly, add very primitive support for <code>FINDFUNCTION</code>, make its word-selection behaviour appear more object oriented, and make it's indenting work more consistently.</li>
</ol><P>

<h3>Changes between beta three and beta four.</h3>
<ol>
<li>A number of bugs in beta three fixed:
<ul>
<li><em>ZapSpell</em> tried to autoload a missing dictionary when it started.</li>
<li><em>ZapEmail</em> needed recompiling for word wrap and <em>'FORMATTEXT'</em> to work.</li>
<li><em>Save/Discard/Cancel</em> window could break if <em>Save to CSD</em> window was used.</li>
<li><em>ZapMJE</em> would only operate very slowly sometimes.</li>
<li>Pretty display of font sub-styles in menus wasn't firing.</li>
</ul>
<li>Inverse video sub style implemented.</li>
<li>Darren's conditional commands included.</li>
</ol><P>

<h3>Changes between beta two and beta three.</h3>
<ol>
<li>Large number of bugs in beta two fixed:
<ul>
<li>External Edits didn't work.</li>
<li>Dragging files into existing windows positioned the text incorrectly.</li>
<li>Fixed problem with displaying/selecting fonts three deep in the menus.</li>
<li>Bug stopping close icon from working on modified 'MZap'ped files fixed.</li>
</ul>
<li>Goto box now clears with the auto-clear search box flag.</li>
<li>Shift-dragging can now be aborted when the drag started when Zap didn't start out with the input focus.</li>
<li>The search box didn't work well when used with 'TextCopy'.</li>
<li>Changing modes could lead to poorly redrawn windows.</li>
<li>ZapSpell windows come to the front when they are in use.</li>
<li>A crude mechanism for loading user dictionaries on start up added.</li>
<li>Minor bug in HoTMeaL mode's unix path translation fixed.</li>
</ol><P>

<h3>Changes between beta one and beta two.</h3>
<ol>
<li>Sixteen font sub-styles are now available.</li>
<li>Dynamic sub-style loading implemented.</li>
<li>Byte &amp; Word modes: clicking on a character in the character dump now positions the cursor over the appropriate byte or word.</li>
<li>Better support for 'big' discs in the 'DZap' dialogue. 'Big' disks (&gt;=512MB) use a sector address instead of a disk address. The disk size will be given as a 16-digit number, and the file title will contain the disk address (again, 16 digits). Small disks (&lt;512MB) are unaffected by these changes.</li>
<li>Shift dragging files into Zap now causes Zap to gain the input focus.</li>
<li>ZapObey didn't work as the !Zap.Modules.!Setup file was missing.</li>
<li>The 'StrongZap' mode didn't work properly.</li>
<li>Redraw of the area after the end of the file in VDU redraw mode fixed.</li>
<li>New versions of several extension modes (see their own !Help files).</li>
<li>A large number of minor bug fixes, tweaks, and incremental improvements.</li>
</ol>

<?php
  zap_body_end ('$Date: 2002/01/23 20:27:04 $');
?>
