<?php
  // $Id: index.php,v 1.7 2002/03/13 22:27:54 ds Exp $
  include "../.php/zap-std.inc";
  setroot ('redraw/index');
  zap_header ("ZapRedraw", "ZR", 'up:../', 'first:viewfinder');
  zapredraw_body_start ();
?>

<p><b>ZapRedraw</b> is a relocatable module providing fast text redraw
services for client applications. It is used by Zap to plot lines of text
onto the screen. The current stable release is 0.39, this is
the version supplied with current releases of
<a href="../">Zap</a>. Both versions are available from Zap's ftp
site:

<ul>
 <li>Stable <strong><a href="/ftp/pub/stable/zfonts.zip">(0.39)</a></strong></li>
<?php
  include ".php/zr-versions.inc";
  show_zr_versions (0);
?>
 <li><a href="/ftp/pub/zapredraw.RELEASE.NOTES">Release notes</a></li>
</ul>

<p>Note that the beta downloads are update archives; in order to install one, you must have the stable version already installed.</p>

<p><strong>ZapRedraw 0.42 requires <a href="/ftp/pub/1.44/">Zap 1.44</a> test-8 or later. A patched Zap binary is included; this is required only for test-8.</strong></p>

<p>New features in version 0.40 include a new Font Handle concept which
allows ZapRedraw to manage bitmap font data block which makes it much simpler
for programmers to use. It also allows font data to be shared between
programs reducing system memory usage.</p>

<br>

<h3>Which version are you using?</h3>

<form method=post action="../cgi-bin/zr-count">
 <p>
  Using
  <select name="Version">
   <option value=0>Old</option>
   <option value=1 selected>0.39</option>
<?php
  $opt = 2;
  foreach ($dirs as $dir)
    echo '   <option value=', $opt++, '>', substr ($dir, 3), "</option>\n";
?>
  </select>
  &nbsp;
  <input type=checkbox name="Viewfinder" value="y">&nbsp;with Viewfinder
  &nbsp;
  <input type=submit value="Submit">
 </p>
</form>

<?php
  $votestxt = @file ("../.count/zapredraw.count");
  $vers = count ($dirs) + 2;
//  $votes = range (1, $vers);
//  $votes_vf = range (3, $vers);
//  sscanf ($votestxt[0], substr (str_repeat ("%i ", $vers), 0, -1),
//	  &$votes[0], &$votes[1], &$votes[2], &$votes[3]);
//  sscanf ($votestxt[1], str_repeat (" %i", $vers), &$votes[4], &$votes[5]);
  $votes = explode (' ', $votestxt[0]);
  $votes_vf = explode (' ', substr ($votestxt[1], 1));
  for ($i = 0; $i < count ($votes); $i++)
    $votes[$i] = intval ($votes[$i]);
  for ($i = 0; $i < count ($votes_vf); $i++)
    $votes_vf[$i] = intval ($votes_vf[$i]);

  function pv ($index, $ver)
  {
    global $votes, $votes_vf;
    if ($votes[$index] == 0)
      return;
    echo '<li>', $votes[$index], ' using ', $ver;
    $vf = $index - 2;
    if ($vf >= 0 && $votes_vf[$vf])
    {
      if ($votes[$index] == $votes_vf[$vf])
        echo ' with ViewFinder';
      else
	echo ', of whom ', $votes_vf[$vf],
	     $votes_vf[$vf] == 1 ? ' is' : ' are', ' using ViewFinder';
    }
    echo "</li>\n";
  }

  echo '<p>Currently, we know of:</p><ul compact>';
  $i = $vers;
  foreach ($rdirs as $dir)
    pv (--$i, substr ($dir, 3));
  pv (1, '0.39');
  pv (0, 'some older version');
  $sum = 0;
  foreach ($votes as $i)
    $sum += $i;
  if ($sum == 0)
    echo '<li>nobody!</li>';
  echo '</ul>';
?>

<br>

<h3>Using ZapRedraw with a ViewFinder</h3>

<p>
As of version 0.40, ZapRedraw has support for computers fitted with a
ViewFinder card. This allows significant speed increases, particularly in
high colour modes. Everything you need to use ZapRedraw in with a ViewFinder
card can be found on the <a href="viewfinder">ViewFinder</a> page.
</p>

<br>

<h3>ZapRedraw documentation</h3>

<p>The documentation detailing the programmer's interface to ZapRedraw comes
in two formats: a plain text manual and a StrongHelp conversion which is
slightly more detailed.
</p>

 <ul>
  <li><a href="redraw.txt">Plain text version</a> (<a href="t2h.php/redraw.txt">as HTML</a>)</li>
  <li>
   <a href="http://sudden.recoil.org/stronghelp/manuals/zapredraw42.zip">StrongHelp version</a>
  </li>
 </ul>

<br>

<h3>Contact</h3>
<p>If you have any questions about ZapRedraw, you can join one of the
<a href="../lists">Zap mailing lists</a>, or you can mail one of the Zap
developers directly. For more details, see <a href="../contact">Zap's
contacts page</a>.</p>

<?php
  zap_body_end ('$Date: 2002/03/13 22:27:54 $');
?>
