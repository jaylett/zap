<?php
  // $Id: zap-changes.inc,v 1.1 2002/01/23 20:45:55 ds Exp $

  function zap_changelog_link (&$who, $id, $name)
  {
    if ($who == $id)
      echo '<li>', $name, '</li>';
    else
      echo '<li><a href="', $id, '-changes">', $name, '</a></li>';
  }

  function zap_changelog_links ($who)
  {
    echo '<ul><li><a href="index">[Up]</a></li>';
    zap_changelog_link ($who, 'tmt', 'Tim Tyler');
    zap_changelog_link ($who, 'ds', 'Darren Salt');
    zap_changelog_link ($who, 'sja', 'James Aylett');
    zap_changelog_link ($who, 'mje', 'Martin Ebourne');
    zap_changelog_link ($who, 'jrf', 'Justin Fletcher');
    zap_changelog_link ($who, 'dw', 'Daniel Wagenaar');
    echo "</ul>\n";
  }
?>
