<?php
  // $Id: viewfinder.php,v 1.3 2003/03/13 17:30:21 christian Exp $
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
 <li>An existing copy of !ZapFonts, available from <a href="/ftp/pub/stable/latest/zfonts.zip">Zap's FTP site</a>.</li>
 <li>ViewFinder firmware revision 1.29 or later. This is available as a free download from the <a href="http://web.inter.nl.net/users/J.Kortink/windfall/support.htm">ViewFinder support pages</a>.</li>
</ul>

<ul>

 <li>Download and unzip a ViewFinder-aware ZapRedraw. The latest release is <?php include ".php/zr-versions.inc"; show_zr_versions (1); ?>; you may also need to read the <a href="/ftp/pub/zapredraw.RELEASE.NOTES">release notes</a>.</li>

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
  zap_body_end ('$Date: 2003/03/13 17:30:21 $');
?>
