<?php
  // $Id: users.php,v 1.1 2002/01/23 20:27:05 ds Exp $
  include "../.php/zap-std.inc";
  setroot ('redraw/users');
  zap_header ("ZapRedraw - which version are you using?", "ZR", 'up:../');
  zapredraw_body_start ();
?>

<h1>Which version of <strong>ZapRedraw</strong> are you using?</h1>

<form method=post action="/cgi-bin/zr-count">
 <p>
  Using
  <select name="Version">
   <option value=0>Old</option>
   <option value=1 selected>0.39</option>
   <option value=2>0.40</option>
   <option value=3>0.41</option>
  </select>
  &nbsp;
  <input type=checkbox name="Viewfinder" value="y" valign=middle>&nbsp;with Viewfinder
  &nbsp;
  <input type=submit value="Submit">
 </p>
</form>

<?php
  $votestxt = file ("/home/ds/src/zap/www.zap.uk.eu.org/.count/zapredraw.count");
  $votes = array (0, 0, 0, 0);
  sscanf ($votestxt[0], '%i %i %i %i',
	  &$votes[0], &$votes[1], &$votes[2], &$votes[3]);

  function pv ($num)
  {
    global $votes;
    return '<strong>'.($votes[$num] ? $votes[$num] : 'none').'</strong>';
  }

  echo '<p>Currently, we know of ', pv(3), ' using 0.41. We also know of ',
       pv(2), ' using 0.40, ', pv(1), ' using 0.39 and ', pv(0),
       ' using an ancient version, but some of them may have upgraded.</p>';
?>

<?php
  zap_body_end ('$Date: 2002/01/23 20:27:05 $');
?>
