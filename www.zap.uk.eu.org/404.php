<?php
  $req = &$GLOBALS['REQUEST_URI'];
  if (substr ($req, -5) == '.html') {
    $ref = apache_lookup_uri (substr ($req, 0, -5));
    if ($ref->status == 200 && file_exists ($ref->filename))
    {
#      $req2 = dirname ($req);
#      $ref2 = apache_lookup_uri ($req2 == '' ? '/' : $req2);
#      if ($ref2->status != 200 || $ref->filename != $ref2->filename)
#      {
	chdir (dirname ($ref->filename));
	$script = $ref->uri;
	if (substr ($script, -4) == '.php')
	  $script = substr ($script, 0, -4);
	$GLOBALS['SCRIPT_NAME'] = $script;
#	$GLOBALS['PATH_INFO'] = substr ($req, 0, -5).'.php';
	include $ref->filename;
	exit;
#      }
    }
  }
  header ('HTTP/1.0 404 Not Found'); // make sure...
  $req = htmlentities ($req);
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
