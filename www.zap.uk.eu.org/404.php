<?php
  $req = htmlentities (&$GLOBALS['REQUEST_URI']); // no REQUEST_FILENAME :-(
  if (substr ($req, -5) == '.html') {
    $ref = apache_lookup_uri (substr ($req, 0, -5));
    if ($ref->status == 200 && file_exists ($ref->filename))
    {
      $req2 = dirname ($req);
      $ref2 = apache_lookup_uri ($req2 == '' ? '/' : $req2);
      if ($ref2->status != 200 || $ref->filename != $ref2->filename)
      {
	chdir (dirname ($ref->filename));
	$GLOBALS['SCRIPT_NAME'] = substr ($ref->filename, 0, -5);
	include $ref->filename;
	exit;
      }
    }
  }
  header ('HTTP/1.0 404 Not Found'); // make sure...
  echo <<<EOF
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<HTML><HEAD>
<TITLE>404 Not Found</TITLE>
</HEAD><BODY>
<H1>Not Found</H1>
The requested URL $req was not found on this server.<P>
</BODY></HTML>
EOF;
?>
