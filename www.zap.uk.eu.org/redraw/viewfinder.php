<?php
  // $Id: viewfinder.php,v 1.1 2002/01/23 20:27:05 ds Exp $
  include "../.php/zap-std.inc";
  setroot ('redraw/viewfinder');
  zap_header ("ZapRedraw - ViewFinder", "ZR", 'up:index');
  zapredraw_body_start ();
?>

<p>These are installation instructions to update your existing version of
ZapRedraw to one which supports the ViewFinder.</p>

<p>
To install ZapRedraw, you will need the following:
</p>
<ul>
 <li>An existing copy of !ZapFonts, available from <a href="/ftp/pub/stable/zfonts.zip">Zap's FTP site</a>.</li>
 <li>ViewFinder firmware revision 1.29 or later. This is available as a free download from the <a href="http://web.inter.nl.net/users/J.Kortink/windfall/support.htm">ViewFinder support pages</a>.</li>
</ul>

<ul>

 <li>Download and unzip the <a href="/ftp/pub/zr-0.40/zapredraw-0.40-vf7.zip">ZapRedraw update archive</a>.</li>

 <li>Copy the !ZapFonts application in the update archive <b>over</b> your
existing copy of !ZapFonts, which will update the necessary files. There are
three places where your existing copy of !ZapFonts can be found:

 <ol>
  <li>Inside !Boot.Resources (this is the preferred location)</li>
  <li>Inside !Zap</li>
  <li>Anywhere else you may have put it when installing Zap.</li>
 </ol>
 </li>

 <li>Double click on the updated archive. If it wasn't in !Boot.Resources and
you have a new style boot structure, you should move it there first.</li>

 <li>(easy option) Restart your computer, <b>or</b>:</li>

 <li>(harder) Open !ZapFonts by shift-double-clicking on it, then double
click on the ZapRedraw module inside it.</li>

 <li>That's it! You now have a ViewFinder-aware copy of ZapRedraw.</li>

</ul>

<p>If you have any problems, try the instructions above with the Filer's
'Force' option <b>off</b>, if it still doesn't work, try it again with the
Force option <b>on</b>. If you <i>still</i> have problems, <a
href="../contact">get in touch</a>.</p>

<?php
  zap_body_end ('$Date: 2002/01/23 20:27:05 $');
?>
