<?php
  # $Id: zr-versions.inc,v 1.3 2002/03/13 22:53:22 ds Exp $

  $dirs = array ();
  $dirh = @opendir ($ftproot);
  if ($dirh !== false)
  {
    while (false !== ($dir = readdir ($dirh)))
    if (strcmp ($dir, $stable) > 0 &&
	strlen ($dir) == 7 && substr ($dir, 0, 3) == 'zr-')
      array_push ($dirs, $dir);
    closedir ($dirh);
  }
  asort ($dirs);
  $rdirs = array_reverse ($dirs);

  function zapscandir ($path)
  {
    global $ftproot;
    $dir = $ftproot.$path;
    $ftpdir = '/ftp/pub/'.$path.'/';
    $dirh = @opendir ($dir);
    if ($dirh !== false)
    {
      $newest = '';
      $newest_date = 0;
      while (false !== ($file = readdir ($dirh)))
      {
	if (substr ($file, 0, 10) == 'zapredraw-')
	{
	  $stat = stat ($dir.'/'.$file);
	  if ($stat[10] > $newest_date)
	  {
	    $newest = $file;
	    $newest_date = $stat[10];
	  }
	}
      }
      closedir ($dirh);
      if ($newest != '')
	echo '<a href="', $ftpdir, $newest, '">', substr ($newest, 10, -4),
	     '</a>';
    }
  }


  function show_zr_versions ($newest_only)
  {
    global $dirs;
    if (count ($dirs))
    {
      global $ftproot;
      global $rdirs;
      if ($newest_only)
	zapscandir ($rdirs[0]);
      else
      {
	// Display the files
	$print = '<li>Beta update <strong>';
	$strong = '</strong>';
	foreach ($rdirs as $dir)
	{
	  echo $print; $print = ', ';
	  zapscandir ($dir);
	  echo $strong; $strong = '';
	}
	if ($print == ', ')
	  echo "</li>\n";
	// Display the directories
	$print = '<li>Beta update directories <strong>';
	$strong = '</strong>';
	foreach ($rdirs as $dir)
	{
	  echo $print, '<a href="/ftp/pub/', htmlspecialchars ($dir), '/">',
	     substr ($dir, 3), '</a>', $strong;
	  $print = ', '; $strong = '';
	}
	if ($print == ', ')
	  echo "</li>\n";
      }
    }
  }
?>
