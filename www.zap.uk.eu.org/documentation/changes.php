<?php
  // $Id: changes.php,v 1.5 2002/11/07 11:35:53 james Exp $

  include "../.php/zap-std.inc";
  setroot ('documentation/changes');
  include "../.php/zap-changes.inc";
  include "../.php/content.inc";

  zap_header ("Zap - Changes", 'up:index', 'first:tmt-changes', 'last:dw-changes');
  zap_body_start ();

  // sort out all our variables
  if (empty($HTTP_GET_VARS['since']))
  {
     // FIXME: we really want to determine what the latest version is, but this will do for now
     $since = "140";
  }
  else
  {
     $since = $HTTP_GET_VARS['since'];
  }

  if (empty($HTTP_GET_VARS['release']))
    $release = "";
  else
    $release = $HTTP_GET_VARS['release'];

  if (empty($HTTP_GET_VARS['sortby']))
    $sortby = 'module';
  else
    $sortby = $HTTP_GET_VARS['sortby'];

  $me = $docroot . "changes.php";


  // output a link to ourselves with a different search order
  function output_sort_link($link, $description)
  {
    global $me, $since, $release;

    echo "<th><a href=\"".$me."?since=".$since;
    echo "&release=".$release;
    echo "&sortby=".$link."\">".$description."</a></th>\n";
  }

  // output a link to ourselves with a different release name
  function output_release_link($release)
  {
    global $me, $since, $sortby;

    echo "<a href=\"".$me."?since=".$since;
    echo "&release=".$release;
    echo "&sortby=".$sortby."\">".$release."</a>\n";
  }
    
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

  
  // function to count and name all the releases names in an info file
  function count_releases($content, &$releases)
  {
     reset($content);

     $count = 0;

     while (list(,$info) = each($content))
     {
        if (!empty($info['release']))
        {
           for ($i = 0; $i < $count; $i++)
           {
              if (strcasecmp($info['release'], $releases[$i]) == 0)
                break;
           }

           if ($i == $count)
             $releases[$count++] = $info['release'];
        }
     }

     return $count;
  }


    // read the changelog from the content file
    $changes = read_content("changes" . $since, "en");
    reset($changes);

    // find the releases
    $releases      = array();
    $release_count = count_releases($changes, $releases);

    // print the links to other releases
    if ($release_count > 0)
    {
      echo "<p>See also changes since</p>\n  <ul>\n";
      for ($i = 0; $i < $release_count; $i++)
      {
         echo "    <li>";
         output_release_link($releases[$i]);
         echo "</li>\n";
      }
    }

    // sort the changes
    usort($changes, "cmp_" . $sortby);

    // now do the actual changes
    echo "<center>\n";

    printf("<h1>Changes since Zap v%1.2f %s</h1>\n", $since / 100, $release);

    // output the table header.
    echo "<table cellspacing=\"1\" cellpadding=\"4\" bgcolor=\"#202080\" width=\"80%\" border=\"1\">\n";
    echo "<tr valign=\"top\" bgcolor=\"#e0e0ff\">\n";
    output_sort_link("module", "Module");
    output_sort_link("change", "Description");
    output_sort_link("by",     "By");
    echo "</tr>\n";


    reset($changes);

    // output each change
    while (list(,$info) = each($changes))
    {
      if ((empty($info['release']) && $release == "") || (!empty($info['release']) && !strcasecmp($info['release'], $release)))
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
    }

    // close the table
    echo "</table>\n";
    
    echo "</center>\n";

  zap_body_end ('$Date: 2002/11/07 11:35:53 $');
?>
