<?php
  // $Id: 404.php,v 1.3 2002/02/04 19:22:36 ds Exp $

  include ".php/zap-std.inc";

  $req = &$GLOBALS['REQUEST_URI'];
  if ($GLOBALS['REDIRECT_STATUS'] == 404 && substr ($req, -5) == '.html') {
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

  $errs = array (
    ''  => array ('Hello world', 'I\'m your friendly error script.'),
    400 => array ('Bad request', 'Your request was malformed or invalid.'),
    401 => array ('Unauthorised', 'You don\'t have authorisation to access %s.'),
    403 => array ('Forbidden', 'You don\'t have permission to access %s.'),
    404 => array ('Not found', 'The requested URL %s was not found on this server.')
  );

  $status = $GLOBALS['REDIRECT_STATUS'];

  if (isset ($errs[$status]))
    list ($reason, $text) = $errs[$status];
  else
  {
    $reason = 'Unknown!';
    $text = 'Unknown error!';
  }
  $i = strpos ($text, '%s');
  if ($i != FALSE)
    $text = substr_replace ($text, '<tt>'.htmlspecialchars ($req).'</tt>',
			    $i, 2);

  header ('HTTP/1.0 '.$status.' '.$reason); // make sure...
  $file = ereg_replace ('^.* ', '', $GLOBALS['REDIRECT_ERROR_NOTES']);
  $script = $GLOBALS['SCRIPT_FILENAME'];
  $i = 1;
  while (substr ($file, 0, $i) == substr ($script, 0, $i))
    $i++;
  $GLOBALS['SCRIPT_NAME'] = substr ($file, $i - 2);
  setroot (substr ($file, $i - 1));
  zap_header ($status.' '.$reason);
  zap_body_start_common ();
  echo '<h1>', $reason, "</h1>\n<p>", $text, "</p>\n";
  zap_body_end ();
?>
