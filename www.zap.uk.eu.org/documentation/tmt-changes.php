<?php
  // $Id: tmt-changes.php,v 1.1 2002/01/23 20:27:04 ds Exp $
  include "../.php/zap-std.inc";
  setroot ('documentation/tmt-changes');
  include "../.php/zap-changes.inc";
  zap_header ("Zap - Tim Tyler's changes", 'up:changes:changes', 'previous:dw-changes', 'next:ds-changes');
  zap_body_start ();
?>

<h1>Changes by Tim Tyler:</h1>

<ol>

<li><em>Font sub-styles</em> are now available.  These supplement the exisiting syntax colouring, and allow combinations of <strong>bold</strong>, <em>italic</em> and <U>underlined</U> variants of the main font to be used.  This allows syntax information from the selected area to remain visible, and can help to provide additional visual clues about a document's meaning to readers.</li>

<li>There is a soft-link protocol to allow fonts to be linked to other places in the font directory.  Links are text files with a self-explanatory format. The idea is largely to prevent the need to store multiple copies of a font when it is to be used as a main font, and also as a sub-style.</li>

<li>Support within <em>ZapRedraw</em> for altering the aspect ratio of displays using outline fonts.  <em>DSA</em> and <em>VDU</em> modes both benefit.  The top 16 bits of the font size now contain the aspect ratio (as 100xY/X).</li>

<li><code>FONTASPECT</code> command provided within <em>Zap</em>to allow the aspect ratio of outline fonts to be altered.</li>

<li>Coloured throwback. The colouring is still quite simple with no highlighting of matched words implemented.</li>

<li>There are now an additional fifteen colours in the <strong>Code</strong> mode. You can probably guess that it is felt that the only disadvantage of large numbers of colours is the hassle of configuring them. The old colours are still there, but ar now confined to the mnemonics. Perhaps most interesting is the condition colouring. This can take some getting used to when reading the code, but it is genuinely useful. It has been tested fairly extensively with <em>Darren Salt</em>'s excellent disassembler and should work on RPCs.</li>

<li>Added <code>BITMAPFONT</code> &lt;string&gt; command. This simply sets the bitmap font in the relevant window to be &quot;ZapFont:&lt;string&gt;&quot; e.g. to force a font change, use: <code>BITMAPFONT &quot;08x15.Teletext&quot; : FONTTYPE 1</code><br>The main uses of this command are:

<UL>

<li>Using the useful feature of being able to execute arbitrary strings of <strong>Zap</strong> commands whenever a new file is loaded (these commands go in the filetype or path sections of the keys file) to put different types of files into windows with different fonts.</li>

<li>Putting frequently used fonts at the bottom of the font menu to avoid unnecessarily wading into the main font menu.</li>

</UL></li>

<li>Added the <code>OUTLINEFONT</code> &lt;string&gt; command. This acts much like the <code>BITMAPFONT</code> command. &lt;string&gt; is a font name, optionally preceded by a '#' character. If present, the hash prevents the font from being installed and cached - useful to stop the font from being cached twice when used in conjunction with the <code>FONTSIZE</code> command. '<code>OUTLINEFONT &quot;#Corpus.Bold&quot; : FONTSIZE 12 : FONTTYPE 3</code>' is an example of its use.</li>

<li>A fix for truncated descenders when using anti-aliased outline font displays has been implemented.</li>

<li>Anti-aliasing is now applied to all text colours in modes with 256, 32K and 16M colours. The technique involves no memory overhead, and incurrs no speed penalty, but it can produce imperfect displays. The innaccuracies are best seen with a magnifier on characters which have a low contrast between themselves and the background. With a black backdrop dark grey characters are displayed poorly. It may be possible to filter out these low- contrast cases and feed them to the non-anti-aliased routines for a slightly better display. It may also be possible to use the technique to some extent in &lt; 256 colour modes in the future. If the effect is disliked then it can be disabled by setting the keys file variable &amp;31F to a non-zero value.</li>

<li>Added code to filter out the very worst cases in the anti-aliased DSA redraw code. Unfortunately, at the moment this only filters out <em>very</em> low contrast combinations that are unlikely to be being used in the first place.</li>

<li>Interactive help messages for third-party windows are now passed on correctly, allowing <em>ZapButtons</em> to provide interactive help properly. There have also been a number of other modifications to allow applications which open their own windows to behave in a more responsive manner.</li>

<li>A second Zap-handled mode word for storing options in has been created. This modifies the format of the <em>!Config</em> file in an appropriate manner. This enables:

<ul>

<li>Universal soft-wrap;</li>

<li>Universal window-wrap;</li>

<li>Smart shift-cursor keys option;</li>

<li>Confined action of cursor-right;</li>

<li>...and a number of other new options.</li>

</ul></li>

<li>Added a new variable to the Keys file. &quot;Dialogue box offsets&quot; is variable &amp;31D and crudely controls where dialogue boxes which are associated with windows are brought up. The format is: &lt;xoffs&gt;,&lt;yoffs&gt; with default values of &amp;80,&amp;80 if no offsets are given. The format is currently subject to change.</li>

<li>The number of permitted command tables has been increased from 16 to 32.</li>

<li>Emulation of a cursor movement pattern of some other editors is now available. The &quot;Confine V&quot; cursor option acts to give the cursor a 'current column'. The cursor is then moved to the nearest available position when cursor up and down are executed.</li>

<li><em>Zap</em> now uses the <code>&lt;Zap$HelpData&gt;</code> variable when looking for its HelpData.</li>

<li>'Last', 'To eof' and 'Exit' buttons now close window when adjust-clicked.</li>

<li>Q (quit) abbreviation added as a synonym for E (exit) in the replace buttons d-box and the load d-box.</li>

<li>'To Front' (T or F) option added in Edit/Overwrite/Cancel d-box [icon 6]. Also all buttons now close this window when adjust-clicked on.</li>

<li>New option not to use hourglass in search routines added.</li>

<li>Pressing 'tab' repeatedly now repositions caret properly in search/replace d-boxes (instead of painting carets all over the place and not rubbing them out).</li>

<li>For the benefit of '!Clipboard' users who use ctrl-Z, ctrl-X, ctrl-C and ctrl-V to provide a 'writable icon clipboard', Zap's search and replace dialogues now pass these keys on to the WIMP so clipboard programs can use them. Note that as ctrl-C is used for toggling the 'Case sensitive' flag this may be generated by pressing ctrl-D instead.</li>

<li>Select-clicking on the title of a file in a throwback window (or on the blank lines surrounding it now simply loads the relevant file.</li>

<li>Added routines designed to make window update much smoother when using window wrap with a selected region.</li>

<li>Added support for a new system variable: <code>Zap$DummyOSVsn</code>. If this exists then it overrides <code>Zap$OSVsn</code> when <em>Wimp_Initialise</em> is called.</li>

<li>Integrated support for <em>Darren Salt's</em> replacement <strong>Debugger</strong> in <strong>Code</strong> mode.</li>

<li>There are new options in the <strong>Code</strong> mode to control the colouring as the default options may not always be appropriate.</li>

<li>Code mode now handles instructions whose disassembly depends on the last two instructions being disassembled immediately beforehand (as implemented in the disassembler to provide LDRL, etc). LDRL and LDRX also now work properly when left-arrow is pressed over them.</li>

<li>Code mode is now aware of offset &amp;2C (Messages file offset RO&gt;3.5).</li>

<li>Code mode is now aware of bit 31 of addresses acting as a flag bit. In particular in module finalisation offset where this acts as a flag preventing the module from being killed on RMClear. (Thanks to <em>Darren Salt</em> for information relating to these issues.)</li>

<li>Added a new option in 'Code' mode to allow stripping of comments.</li>

<li><em>ZapRedraw</em> has been modified to cope with <em>small</em> negative horizontal window offsets.</li>

<li><em>Zap</em> has been changed to take advantage of this.  The selection is intended to extend into the margin.  <em>Zap</em>variable &amp;30C (which should now be titled &quot;<em>Window left margin (os)</em>&quot;) now works.  It would be appreciated if those with an interest in making sure <em>Zap</em>works properly could set this to some <em>small</em> positive value (4, say) for a while so any lurking difficulties may be uncovered.</li>

<li>Drag-and-drop of the current selection implemented.  To activate this, shift-select-drag while the pointer is over the selected region. If the drag is to a <em>Zap</em>window, the cursor is positioned appropriately before the text is copied.  The leafname used for exported selections will be that present in the <code>Save selection</code> box. Drags may be aborted by pressing <em>ESCAPE</em>.</li>

<li>Variable width line numbers implemented.  The interface is via the <code>SETMARGINWIDTH</code> and <code>COLONSEPARATOR</code> commands.  These will come set up higgle-de-piggledy for those who have been following the progress here; upgraders straight from 1.35 should not experience this.  Hopefully there will eventually be a way of setting things up so that <em>BASIC</em> mode gets a width of 5 and no colons by default. If the margin width is set to 1 and the colons are turned off then then a '*' (or, if the 'Hex' option is selected, a '&gt;') will be displayed where the last visible digit of the line number would normally go.  This can sometimes be useful to provide feedback about which lines are logical and which are physical, especially in soft-wrapped modes where  the distinction between these is being deliberately blurred.</li>

<li>The <em>LineEditor</em> now helps to provide a history in the '<em>Search</em>' '<em>Search and Replace</em>' and '<em>Goto</em>' dialogue boxes.  It may be navigated by using <em>Page Up/Page Down</em>.  Everywhere, except in the <em>Search and Replace</em> dialogue, the cursor keys also perform this function. <em>Tab</em> restores the original setting as before. <em>Ctrl-K</em> clears the history of the current icon.  <em>Ctrl-T</em> copes text between the icons. There is a WIMP front-end available by calling up menus containing the history.  <em>Adjust</em> performs a different action from <em>Select</em> in many places.</li>

<li>There is a bug in the <em>WIMP</em> which means that the ends of drags are not always reported properly. Until now when these circumstances occurred, <em>Zap</em>got confused and could crash. This problem has been fixed by always checking to see that a mouse button is being pressed while a drag is occurring and faking a drag close event for the benefit of any dragging clients if this is not the case. The bug affects most <em>RISC-OS</em> programs that use the <em>WIMP</em> dragging routines. It can usually be provoked by not calling <code>Wimp_Poll</code> for a while. One very common cause for this is using the <em>!MoveWindo</em> application. To observe the bug in programs, the easiest method is to start the drag and press F12. In <em>Zap</em>doing this while dragging a selection caused severe problems if that window was subsequently closed.</li>

<li>With the cursor in one window and a selection in another <em>ctrl-ADJUST</em> to extend the selection, and watch the cursor redraw and move around in the other window. This bug has now been fixed.</li>

<li>Extending the selection with <em>ctrl-ADJUST</em> would, under some circumstances, cause the selected area to flicker when the drag kicked in. This has been rectified.</li>

<li>The &quot;Load mode&quot; menu now only contains the modes not already loaded. If there is any possible use for reloading a previously-loaded mode, then now would be a good time to point this out to me. The shorter menu should make it easier to find things though there is no longer an exhaustive alphabetical list available when choosing modes.</li>

<li>The cursor no longer wraps incorrectly when cursor-right is pressed and held down at the end of files.</li>

<li>&quot;Copy ops&quot; i.e. the <code>MAKEDEFAULT</code> command, when issued from a read-only window no longer makes all subsequently opened windows read-only.</li>

<li>Handling of the Save box's type picker modified to allow prettier templates. Clicking with select now brings up the type menu.</li>

<li>The command <code>TMT_UPDATEWINDOW</code> has been rewritten, renamed and moved into the kernel.  This improves window-wrap redraw massively.</li>

<li>The horizontal scroll bar and scroll icons are no longer active when window-wrap is engaged.</li>

<li>Soft-wrap now also wraps on the characters which may be defined by indivadual modes, allowing more intelligent soft-wrap in HTML modes for example.</li>

<li><code>SOFTWRAP</code> and <code>WINDOWWRAP</code> commands added. These <em>must</em> be used in place of their flag-toggling equivalents.</li>

<li>Soft-wrap now permits characters to extend into the last column, on the proviso that they are followed immediately by a CR.  Soft-wrap and line-wrap are now mutually exclusive - using one will deselect the use of the other.  Soft-wrap is now indicated by a capital 'W' in the title bar.</li>

<li>'Infinite' window wrap implemented. It defaults to being off. One point to note about it is that the old width is not stored, and so deselecting window wrap sets the current width as the new window width. This may be of some use when using &quot;<code>WINDOWWRAP:WINDOWWRAP</code>&quot; to set the current window's width as the permanent width.</li>

<li>&quot;<em>Copy ops</em>&quot; i.e. the <code>MAKEDEFAULT</code> command now also copies the data for the mode of the window it was issued from (i.e. the options usually accessible through that mode's menu) into the default options.  This is useful as it can save some wading around in the icon-bar menu.However, there seem to be some imperfections in the original command which have not been tracked down yet.</li>

<li>Added absolute cursor positioning on a mouse click as an option. This option is is sometimes useful when performing activities like creating ASCII art.</li>

<li>Added the <code>AUTOSOFTWRAP</code> command. When the option is turned on, auto soft-wrap detection routines fire whenever a mode change takes place.</li>

<li>Auto-width now does not operate if the mode is currently being soft-wrapped.  The auto-width option will remain ticked, though. When autowidth is on and soft-wrap is off there are still some circumstances which will cause autowidth to 'kick' in unexpectedly. To observe this load a file with autowidth and softwrap on. Then toggle softwrap, and then window-wrap.  When window-wrap is toggled, the autowidth will suddenly wake up.  I'm aware of this issue.</li>

<li>Soft-wrap modified so different modes can choose which characters are soft-wrapped on.  Text mode (i.e. most modes) now wrap by default on spaces, tabs and &quot;-&quot;.  HTML modes (for example) should also wrap on &quot;&gt;&quot; for the best display.</li>

<li>Selections can now be made by pressing and holding down <em>ESCAPE</em> and then using the cursor keys.  Shift- and control- cursor combinations work with this, as do <em>Page Up</em> and <em>Page Down</em>.</li>

<li>Selections made using <code>SELREGION</code> are now <em>always</em> confined in such a manner that the cursor follows the text exactly.  This should eliminate long standing redraw 'issues' associated with selecting regions that start or end in empty space.</li>

<li>A number of <em>Zap</em>commands currently being proposed for being in Zap's kernel have been placed there.  Hopefully the ones picked are fairly uncontroversial, and they are all very short. &quot;<code>DELETEFILE</code>&quot;, &quot;<code>DISCARDFILE</code>&quot;, &quot;<code><code>DISCARDWINDOW</code></code>&quot;, &quot;<code>DROPMARK</code>&quot;, &quot;<code>INSERTBLOCK</code>&quot;, <code>INSERTBLOCKGS</code>&quot;, &quot;<code>OPENPARENT</code>&quot;, &quot;&quot;<code>STARTOP</code>&quot; and &quot;<code>STOPOP</code>&quot; have been done so far.</li>

<li>A fairly radical change has been made to the passing of parameters to <em>Zap</em>commands.  Commands which take string parameters may now have them passed enclosed in brackets, instead of inside quotes. <strong>WARNING!:</strong> this change <em>may</em> require changes to your Keys file. For details see the &quot;WARNING!&quot; section in the installation notes.</li>

<li>The <em>Save selection</em> box has been modified to be more like the <em>Save</em> box.  Note that filetype information, and load and execution addresses can <strong>not</strong> yet be modified independently of those of the main file.</li>

<li>Made dialogue box buttons press themselves in when the relevant shortcut key is pressed to provide visual feedback.</li>

<li><code>STILLUP</code> and <code>STILLDOWN</code> commands have been implemented.  These are roughly equivalent to <code>UP:SCUP</code> and <code>DOWN:SCDOWN</code>.  The latter are fairly useless, however as those combinations would fail to repeat in an intelligent manner when bound to cursor up and cursor down in the keys file.  <code>STILLLEFT</code> and <code>STILLRIGHT</code> would be easy to implement, but also not particularly useful.</li>

<li><code>SCUP, SCDOWN, SCLEFT</code> and <code>SCRIGHT</code> have had their 'auto-repeat' bit set.  This will probably only normally make a difference for those with rapid keyboard auto-repeat rates and slow machines.  To get the effect of the original commands, it is possible to use commands like SCUP:NULL to stop multiple <code>SCUP</code>s being combined.  However, this should /not/ be the default setting IMO.</li>

<li>The <em>Save/Discard/Cancel</em> box now offers the same options as the <em>Save</em> box, in addition to the normal functions.  The main advantage of this is it is easier to save from a window's close icon. <em>Discard</em> and <em>Cancel</em> are still supported.  There is a <em>To Save</em> icon (to be deleted) which brings up the normal save box as before for those who prefer the old style for some reason.<BR>

Because the new box has writable icons in it, 'S', 'D', and 'C' keyboard shortcuts will not function with the default set-up.  These (in my experience) were infrequently used because frequently the user had just clicked on the close icon of the window, and so using the mouse was natural. However, the shortcuts are present internally, and if <strong>all</strong> the writable icons are all made non-writable, then they will start to work <em>exactly</em> as before.  This way the new system offers all the functionality of the original templates for those who preferred the old system.</li>

<li><em>Zap</em> now uses the <em>Zap$Keys</em>, <em>Zap$Settings</em> and <em>Zap$Types</em> variables when looking for its resources, and loads them separately.  This means that changes to the keys file (for instance) no longer cause CreateConf to perform a complete rescan of the Modules directory when <em>Zap</em>loads.</li>

<li>A new template has been added.  This is used for a save-&gt;CSD query when saving the selection.  There has not been such a dialogue box up until this point.</li>

<li>Inserting and deleting regions which are not currently visible on the screen has, until now, failed completely to update the screen. These circumstances are very commonly produced while undoing or redoing insertions or deletions.  Now the integrity of the display is always maintained.  This is currently done by catching the cases which would cause redraw problems and then updating the whole window, rather than just the sections which need doing.</li>

<li>Auto soft-wrap now no longer selects soft-wrap if it finds any control characters in the file.  This will usually occur when binary files which are being viewed in Text mode.</li>

<li>Inserting text by dragging it into a <em>Zap</em>window now inserts by placing the cursor at the dropped position if <em>SHIFT</em> is pressed. This applies to both imported texts, and selections which are <em>SHIFT</em>-dragged from <em>Zap</em>itself.  If <em>SHIFT</em> is not pressed then the text is inserted at the position of the cursor (or the 'point' marker).  The way the <em>SHIFT</em> operation works could easily be reversed - it is set the way it is mainly for the sake of backwards compatibility.</li>

<li>Modes can now specify whether the various cursor options are relevant to them.  The corresponding menu entries are greyed out if the options are not applicable.</li>

<li><em>Zap</em> no longer causes address exceptions when the desktop is shut down and restarted.  This problem seems to have been introduced with <em>Zap</em>1.35.  The fix is a crude one and has the consequence that <em>Zap</em>does not reinitialise itself and place an icon on the icon bar  upon restart any more.  For the technically minded, <em>Zap</em>now traps, <em>Service_WimpCloseDown</em>, looks for itself dying, and issues a <em>OS_ExitAndDie</em> on itself if this happens.</li>

<li>New commands <code>CONFINEHORIZONTALLY,</code> <code>CONFINEVERTICALLY</code> and <code>FREECLICK</code> added.  This means that the occasional conflict between <code>CONFINEHORIZONTALLY</code> and <code>FREECLICK</code> has been eliminated, and that these menu entries will now have sensible interactive help on them.</li>

<li>Modified the behaviour of <code>COPYSEL, MOVESEL</code> and <code>YANK</code> so that they insert the text at the cursor position, rather than at the nearest offset.  The old behaviour was poor and so is not even available now as an option.</li>

<li><code>MOVESEL</code> now leaves the region <code>MOVE</code>'d selected.  Probably <code>YANK</code> should do this too.  The old behaviour was questionable; it is not available as an option. Note that these changes make using the 'Non-standard' option in BASIC mode <em>much</em> more viable.  This strips spaces from the ends of lines, including ones which are otherwise blank, as they are typed.</li>

<li>Serious long standing bug in the <code>MAKEDEFAULT</code> command has been located and cured. It was copying most of the options from the current window into the default opinions of whatever mode was currently selected in the icon bar menu.  No wonder it seemed unreliable.  It now correctly copies the options across from the specified window into the options of the relevant mode.</li>

<li>WC and WCSEL commands added to <em>Zap.</em> Having WC in <em>Zap</em>means that it can be properly used as a submenu in the File menu without loading an extra <em>Zap</em>mode by default.  And menu entries using the WCSEL command are now shaded depending on whether there is a current selection, and ADJUST-clicking on the commands in menu entries works correctly.  WCSEL no longer beeps to indicate that there is a current selection and gives a minibuffer warning if it is executed without one.  The commands were originally written by <em>Elliot Hughes</em> as part of his <em>ZapENH</em> module.  Many thanks are due to Elliot for kindly providing his source code.</li>

<li>If a minibuffer warning is given when a command is issued from the minibuffer the warning no longer disappears immediately.  The input focus is retained by the minibuffer's owning window, even while the warning is being displayed.  I think the psychology of doing this is questionable, but it does mean that <em>Zap</em>behaves more responsively, and in particular, that long minibuffer warnings can be cancelled by pressing <em>ESCAPE</em>.</li>

<li>The undo buffer now stores a flag to indicate the position of the cursor when text is inserted or deleted.  This is then used to reposition the cursor when <code>UNDO</code> is executed.  When deletions are undone, the cursor now moves to the start of the inserted region if it was there when the deletion occurred.  This mainly affects <code>CUTSEL, DELETENEXT</code> and <code>DELETETOEND</code>.  Storing the position of the cursor (if it is inside the deleted region) would be a superior strategy, but it would also be a more expensive one.

 <ul>
  <li>Note: <code>DELETENEXT</code> in <em>ZapBASIC</em> currently works 'the old way'. I can't <em>neatly</em> fix this without making <em>ZapBASIC</em> non-backwards compatible with <em>Zap</em>1.35. I'm now not sure when this will get fixed.</li>
 </ul>

<li>A 'count the number of matches' option added to the <em>Zap_Search</em> call.</li>

<li>A front end integrated into the <em>Zap</em>search and replace dialogues based on the above call.  This counts the number of matches of a specified search string in one or all of the loaded files. There are in fact two possible methods used to display the search information.  One (currently being used in the search box) involves a popup window (which saves on template real estate).  The other (currently in service in the search and replace dialogue box) uses a simple display icon to show the number of matches.  Whether you get the pop-up box is controlled in the templates file; set a non-zero ESG for icon 3 to stop it from appearing.</li>

<li>More changes to <code>MAKEDEFAULT</code> (and thus copy ops).  It should be saving its settings more reliably (again).  Also it no longer affects options in any modes apart from the mode of the file it was issued from.  It was (for example) saving the colours in all the modes whenever it was issued.  I don't think this was good behaviour.</li>

<li>Text mode now uses &quot;-------I&quot; to display tabs.  It was using &quot;]]]]]]I&quot; because both &quot;]&quot; and &quot;I&quot; are control characters, so this was easier and faster as the foreground colour buffer didn't have to be used.  The soft-wrap code has also been changed, so this change also applies to any modes which have soft-wrap turned on.  I have minimised any performance loss by recoding the (already pretty well optimised) redraw routines.  In text mode, an unused register was found and half the branch instructions were eliminated.  In principle this change could affect modes which use the text mode's code to help perform their redraw.  <em>AFAIK</em> there aren't any modes which do this.</li>

<li>It is no longer possible to open the minibuffer from the icon bar menu. Commands which use the minibuffer in this context now abort themselves if they are supplied without any string.  The minibuffer would have been opened at the position dictated in the template file. The functionality has been removed largely for aesthetic reasons; Most of the time when the minibuffer is opened in this manner, it was in error.</li>

<li>Added <code>ALLMODES</code> and <code>ALLWINDOWS</code> commands.  These execute a given string of <em>Zap</em>commands once in each <em>Zap</em>window, and once for each loaded mode respectively.</li>

<li><em>Byte, Word, ASCII</em> and <em>Code</em> modes are now using their background colours for the first time.</li>

<li><em>Zap</em> now tries to reset <em>Alias$Taskwindow</em> if it thinks it needs to do so if it exits ungracefully.  This should prevent the symptom of ctrl-F12 from not working until <em>Zap</em>is reloaded.</li>

<li>An old throwback bug cured.  If entries were deleted from the end of a throwback buffer so that all the entries for the last file were deleted, and then more entries added, these subsequent entries failed to operate.</li>

<li>Support for inserting selected regions.  Currently the clients for this are the <code>CUT, PASTE, YANK</code> and <code>MOVESEL</code> commands which use it to mark the cut text as being in need of reselection when they are undone.</li>

<li>The 'mode_0' template has been deleted from templates file. The <code>Main</code> template has been added - this is used as a template for all <em>Zap</em>file windows.  This has been done mainly to allow different coloured borders to be used. The supplied default template uses a dark grey/colour 6 background. The idea is to allow users to colour their border differently from their most commonly used background colour, to help with situations where one <em>Zap</em>window lies on top of another one.  Regrettably, the colour controlling window borders also controls the title bar text foreground colour :(</li>

<li>Executing <code>BINDTOKEY</code> now terminates any learned key sequence.  This prevents <code>LEARN:RETURN:BINDTOKEY:TAB:TAB:TAB...TAB:TAB:TAB</code> from crashing <em>Zap</em>.</li>

<li>A '<code>COREDUMP</code>' is now produced when an exception occurs if there is a file called 'Debug' in <em>Zap</em>'s root.</li>

<li>An old bug which caused the undo buffer to become corrupted cured. This bug could be consistently reproduced by using <code>FULLUNDO</code> in conjunction with attempts to undo beyond the first undo in files whose undo data contained concatenated sections of insertions and deletions at critical points.</li>

<li>Some changes to the definition of what <em>Zap</em>takes to be a 'word' (in the context of double clicking in 'Text' mode).</li>

<li>'<em>As above</em>' tab mode (previously '!Edit tab' mode) now searches backwards through the file to find a line long enough to provide it with a guide if the previous line is inadequate for this purpose.  If no such line is found the default tab setting of 8 columns is used.</li>

<li>An old bug in <em>ZapRedraw</em> cured.  This only affected VDU redraw mode. It meant that areas were often redrawn using an incorrect background colour in the anti-aliasing - it was most noticeable on partly selected lines and could usually be reproduced simply by dragging a selection.  The area under the cursor is now also redrawn correctly.</li>

<li>Configuration of the <em>Disassembler</em> in <em>Code</em> mode is now better integrated into <em>Zap.</em> Use of the <code>CODE_DISASMTOGGLE</code> command should soon be discontinued as the command will be dropped from <em>Zap.</em>The <em>Disassembler</em> options may now be set up on a per-window basis and preferred options may be saved in the !Config file. Any existing <em>Code</em> mode options will be scrambled - sorry. Changing the <em>Disassembler</em> options from within <em>Zap</em>no longer affects the behaviour of the <em>Disassembler</em> with other <em>RISC-OS</em> applications, as <em>Zap</em>now preserves its flags.</li>

<li><code>WORD_EDIT</code> command added.  This acts like the <code>ASSEMBLE</code> command, only it always disassembles the word at the cursor into a <code>DCD</code> instruction.  If the file has a binary display option turned on then it uses a binary <code>DCD</code>, otherwise a Hex one is used. It is used in Word mode when <code>RETURN</code> is executed, and in Code mode if <code>RETURNNOINDENT</code> is.</li>

<li><code>BYTE_EDIT</code> command added.  This acts like the <code>WORD_EDIT</code> command It is used in Byte mode when <code>RETURN</code> is executed.</li>

<li>A change has been made to the default routines which select words of text when these are double-clicked on. Such selections now terminate at brackets, quotes and various other symbols.</li>

<li><em>Zap</em> now <em>WimpTask</em>s a number of items on the <em>ZapExtensions</em> path when it feels it needs the resources they provide.  <em>BootDisasm, BootExtAsm, BootHide, BootIClear, BootLineEd</em> and <em>BootRedraw</em> are supplied. If your main use for any of these is from within <em>Zap</em>then it may be preferable to load them with this interface, to avoid them being loaded unnecessarily.</li>

<li><code>INSERTTIME</code> and <code>INSERTDATE</code> can now take strings as parameters. These specify the format used in the same way as they are specified in the default settings.</li>

<li>Adjust-click on throwback windows now pays attention to the file's read-only status.</li>

<li>Trying to execute 'To EOF' the the 'Replace?' dialogue on a read-only file no longer generates a WIMP error box with a message full of top-bit-set characters.</li>

<li>Long-standing bug in Zap's selection routines fixed.  The problem involved starting a drag, pressing a button and then continuing the drag.</li>

<li>Cured a bug involving auto-clear selections not working with multiple views of a single file.  The code that stopped this from working looked like it was intended to only clear the selection if it was in the document being edited, but it wasn't working properly, so it's been commented out.</li>

<li><code>UNDO</code>ing an operation performed using <em>Zap_ReplaceArea</em> now higlights the result (if this was selected when the operation was performed).</li>

<li>The <code>INDENT</code> command can now indent by a supplied string.</li>

<li>'<em>Binary OP codes</em>' option added to <em>Code</em> mode.</li>

<li>Fixed an old bug which caused <code>DELTOEND</code> and <code>DELLINE</code> at the end of files to add regions to the yank buffer repeatedly.</li>

<li>Function keys are now active on a file when some dialogue boxes associated with the file have the input focus.  This can take some getting used to, but is very useful.</li>

<li>The <em>LineEditor</em> module now helps to provide a history to the search icons.  <em>Shift-Tab</em> takes over the role of the cursor keys in providing a way of moving the caret in the <em>replace</em> dialogue box. Ctrl-K clears the history of the current icon.</li>

<li>Option to set the global disassembler options in <em>Code</em> mode menu provided.</li>

<li>'Ghost' images of the cursor are now no longer left lying around if performing a concatenated sequence of insertion/deletions.</li>

<li>'Last' button in the 'Replace?' dialogue box, 'Undo' and 'Redo' buttons added.</li>

<li>Added 'Silent operation' (<code>MISCOPS 14</code>) option which causes <em>Zap</em>never to beep. Third-party extensions may still make noise, but it is recommeneded that they use Zap's <code>BEEP</code> command to do this (or read this flag before making their noise).</li>

<li>Added <code>DELTOSOF</code> and <code>DELTOEOF</code> commands.  These delete to the start of the file and to the end of the file respectively, maintaining the current selection.</li>

<li>Goto box revamped, so that the displayed co-ordinates of the cursor are continuously updated while it is open.</li>

<li><code>FINDFUNCTION</code> command added.  This also currently appears in <em>ZapBASIC</em>, a location from which it will shortly be deleted.</li>

<li>A line based selection model is now available as an <em>option</em> in all text-like modes. The selection model is closely related to the one used by <em>ZapBASIC</em>.</li>

<li><code>SENDSEL</code> command added.  This sends the selected text into the keyboard buffer, a character at a time.  It may be aborted by pressing <em>ESCAPE</em>.</li>

<li>The fonts used in the font sub-styles should now be placed in a directory with the name of the main font.  The fonts should be files within this directory, called 'B', 'I' and 'U' for the <em>Bold</em>, <em>Italic</em> and <em>Underlined</em> sub-styles, and '0' for the main font. Fonts which have no substyles should <em>not</em> be directories with a single '0' file, but simple font files as normal. A '0' file (which should usually be a link) may be placed inside the main directories to provide a short-cut to a commonly used font of that size/type.<BR>Note: These changes may cause incompatabilities with other <em>ZapRedraw</em> clients which expect the existing font structure (which has now also changed in some other respects).</li>

<li><em>Zap</em> provides an interface to allow <em>ZapSpell</em> to spell-as-you-type.</li>

<li>Better integration with <em>ZapSpell</em>. Double/triple clicking on a throwback entry generated by <em>ZapSpell</em> now looks up the relevant word in the dictionary.</li>

<li>Added the <em>'-noicon'</em> command line switch and the <code>INSTALLICON</code> command. This latter installs an icon bar icon if one is not already present.</li>

<li>Use of directories starting with '~' for backup files now has a minimum time (specified in seconds) which may be used to control when backups are made.  If the file in the first backup directory is newer than the specified time, then no backups are made.  This stops the backup directory from being flodded with recent files when rapid multiple saves are made.</li>

<li>A number of options which were global (namely '<em>Wordwrap</em>', '<em>Linewrap</em>', and the '<em>Insert tabs as spaces</em>' option are now stored on a per mode/per window basis.</li>

<li><em>Zap</em> now no-longer trusts throwback tasks to feed it filenames in the correct case (as some of them failed to do this).  It now double-checks the case of the letters in the leaf with the filing system if it is asked to load the file.</li>

<li>'<em>Strong soft wrap</em>' option added.</li>

<li>...and a large number of other changes and bugfixes...</li>
</OL>

Tim would like to thank Reuben Thomas for innumerable helpful comments,
Rich Walker and Alexander Thoukydides for help in tight corners, all the
other developers, and all who contributed to the zap-devel mailing list.

<hr>

<?php
  zap_changelig_links ('tmt');
  zap_body_end ('$Date: 2002/01/23 20:27:04 $');
?>
