<?php
  // $Id: index.php,v 1.2 2002/02/01 13:47:50 james Exp $
  include "../.php/zap-std.inc";
  setroot ('documentation/index');
  zap_header ('Zap documentation', 'up:../', 'help:faq:FAQ');
  zap_body_start ();

  function techlink ($url)
  {
    $name = strtr (rawurldecode ($url), array ('.'=>'/', '/'=>'.'));
    if (substr ($name, -4) == '/txt')
      $name = substr ($name, 0, -4);
    echo '<a href="'.$url.'"><code>', $name, '</code></a> [<a href="t2h.php/', $url, '">As HTML</a>]';
  }

  function doclink ($name, $url)
  {
    echo '<a href="'.$url.'">', $name, '</a> [<a href="t2h.php/', $url, '">As HTML</a>]';
  }
?>

<h1>Zap documentation</h1>

<p>Currently not all of Zap's documentation is online. It doesn't all apply to the same version, either...</p>

<table border=0 width="100%">
<tr><td valign=top align=left>
<ul>
 <li><a href="manual/">Zap manual</a> (for Zap version 1.44)</li>
 <li><a href="manual/imp.zip">As Impression document</a> (converted by Chris
Bell; for Zap version 1.40)</li>
 <li><a href="manual/old.txt">Old version</a> (version 1.35 updated for version 1.40 features)</li>
</ul>
<ul>
 <li><a href="faq">Frequently Asked Questions</a></li>
 <li><a href="changes">Changes</a> (version 1.35 to version 1.40)</li>
 <li><a href="recent">Recent changes</a> (version 1.39 beta to version 1.40)</li>
 <li><a href="patches">Patch changes</a> (to the version 1.40 stable distribution)</li>
</ul>
<ul>
 <li><?php doclink ('Dialogue box descriptions', 'Boxes.txt') ?></li>
 <li><?php doclink ('Copyright and licence', 'Copyright.txt') ?></li>
 <li><?php doclink ('Online help data', 'HelpData.txt') ?></li>
</ul>
<ul>
 <li><a href="/cvs/">Guide to Zap under CVS</a>
</ul>
</td><td valign=top align=left>
<ul>
 <li><?php techlink ('Technical/!ReadMe.txt') ?></li>
 <li><?php techlink ('Technical/E-Command.txt') ?></li>
 <li><?php techlink ('Technical/E-Cursors.txt') ?></li>
 <li><?php techlink ('Technical/E-Entry.txt') ?></li>
 <li><?php techlink ('Technical/E-File.txt') ?></li>
 <li><?php techlink ('Technical/E-Flags.txt') ?></li>
 <li><?php techlink ('Technical/E-Keycodes.txt') ?></li>
 <li><?php techlink ('Technical/E-Menu.txt') ?></li>
 <li><?php techlink ('Technical/E-Vars.txt') ?></li>
 <li><?php techlink ('Technical/E-Windows.txt') ?></li>
 <li><?php techlink ('Technical/E-Zapcalls.txt') ?></li>
</ul>

<ul>
 <li><?php techlink ('TechCode/E-Library.txt') ?> [<a href="TechCode/E-Library">As tokenised BASIC</a>]</li>
 <li><?php techlink ('TechCode/E-Template.txt') ?> [<a href="TechCode/E-Template">As tokenised BASIC</a>]</li>
</ul>
</td></tr>
</table>

<?php
  zap_body_end ('$Date: 2002/02/01 13:47:50 $');
?>
