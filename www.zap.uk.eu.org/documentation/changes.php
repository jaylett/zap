<?php
  // $Id: changes.php,v 1.2 2002/06/29 11:28:23 christian Exp $
  error_reporting(E_ALL);
  include "../.php/zap-std.inc";
  setroot ('documentation/changes');
  include "../.php/zap-changes.inc";
  include "../.php/content.inc";

  zap_header ("Zap - Changes", 'up:index', 'first:tmt-changes', 'last:dw-changes');
  zap_body_start ();

  // sort by author
  function cmp_by ($a, $b)
  {
    if ($a['by'] == $b['by'])
      return 0;
    return ($a['by'] < $b['by']) ? -1 : 1;
  }

  // sort by Module
  function cmp_module ($a, $b)
  {
    if ($a['module'] == $b['module'])
      return 0;
    return ($a['module'] < $b['module']) ? -1 : 1;
  }
 
  // may as well have this for consistency
  function cmp_change ($a, $b)
  {
    if ($a['change'] == $b['change'])
      return 0;
    return ($a['change'] < $b['change']) ? -1 : 1;
  }

  if (empty($HTTP_GET_VARS['since']))
  {
?>

<h1>Changes</H1>

<p>The complete Zap changelog is not currently available. You can get the wish/bug/change list for post-v1.40 from the <a href="/cvs/">CVS repository</a>.
</p>

<?php
  zap_changelog_links ('');

  }
  else
  {
    // read the changelog from the content file
    $changes = read_content("changes" . $HTTP_GET_VARS['since'], "en");
    reset($changes);

    // sort the changes
    if (empty($HTTP_GET_VARS['sortby']))
      $sortby = 'module';
    else
      $sortby = $HTTP_GET_VARS['sortby'];

    usort($changes, "cmp_" . $sortby);

    reset($changes);

    printf("<h1>Changes since Zap v%1.2f</h1>\n", $HTTP_GET_VARS['since'] / 100);

    // output the table header. There are better ways of doing this...
    $me = $root . "documentation/changes.php";

    echo "<table cellspacing=\"1\" cellpadding=\"4\" bgcolor=\"#202080\" align=\"center\" width=\"80%\" border=\"1\">\n";
    echo "<tr valign=\"top\" bgcolor=\"#e0e0ff\">\n";
    echo "<th><a href=\"".$me."?since=".$HTTP_GET_VARS['since']."&amp;sortby=module\">Module</a></th>\n";
    echo "<th><a href=\"".$me."?since=".$HTTP_GET_VARS['since']."&amp;sortby=change\">Description</a></th>\n";
    echo "<th><a href=\"".$me."?since=".$HTTP_GET_VARS['since']."&amp;sortby=by\">Change&nbsp;by</a></th>\n";
    echo "</tr>\n";

    // output each change
    while (list(,$info) = each($changes))
    {
?>
<!-- begin change -->
<tr valign="top" bgcolor="#e0e0ff">
<td> <?= $info['module'] ?> </td>
<td> <?= $info['change'] ?> </td>
<td> <?= $info['by']     ?> </td>
</tr>

<?php 
    }

    // close the table
    echo "</table>\n";

  }

  zap_body_end ('$Date: 2002/06/29 11:28:23 $');
?>
