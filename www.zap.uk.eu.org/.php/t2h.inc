<?php
  // $Id: t2h.inc,v 1.2 2002/01/29 21:37:34 ds Exp $

  function Error ($errno, $errmsg, $filename, $linenum, $vars)
  {
    header ('HTTP/1.0 500 Internal Server Error');
    echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<HTML><HEAD>
<TITLE>500 Internal Server Error</TITLE>
</HEAD><BODY>
<H1>Internal Server Error</H1>
The server encountered an internal error or
misconfiguration and was unable to complete
your request.<P>
Please contact the server administrator,
webmaster@zap.tartarus.org, and inform them of the time the error occurred,
and anything you might have done that may have
caused the error.<P>
More information about this error may be available
in the server error log.<P>
</BODY></HTML>
', "<!-- $errno - $errmsg - $filename - $linenum - $vars -->";
    exit;
  }


  function do_replace ($ptn, $rep, $text)
  {
    // expects HTML encoding (not correct, but at least parseable)
    $text = ereg_replace ('&lt;'.$ptn.'&gt;', '&lt;'.$rep.'&gt;', $text);
    return ereg_replace ($ptn, $rep, $text);
  }

  function parturlencode (&$url)
  {
    return ereg_replace ('"', '%22', ereg_replace ('\'', '%27', ereg_replace (' ', '%20', $url)));
  }


  set_error_handler ('Error');

  $me = $REQUEST_URI;
  $file = strstr ($me, ".php/");
  if ($file != '')
    $file = substr ($file, 5);
  $orig = substr ($me, 0, strlen ($me) - strlen ($file) - 1);
  $orig = dirname ($orig) . '/' . $file;

  $root = substr ($GLOBALS['SCRIPT_NAME'], 0, -strlen ($root));

  if (substr ($file, -1) == '/')
  {
    header ('Location: '.$orig);
  }
  elseif ($file != '' && substr ($file, -4) == '.txt' && file_exists ($file))
  {
    // We have a valid request...
    $text = file ($file);
    $date = stat ($file);
    $bullet = 0;

    // Do a little processing...

    foreach ($text as $lineno => $line)
    {
      // expand TABs
      while (($length = strcspn ($line, '	')) < strlen ($line))
      {
	$line = substr ($line, 0, $length) . substr ('        ', $length & 7) . substr ($line, $length + 1);
      }
      $line = strtr ($line, array ("\n"=>''));
      $line = ereg_replace (' +$', '', $line);

      $line = htmlentities ($line);

      if ($bullet > 0)
      {
	if ($line == '' || ereg ('^(\*| ) ', $line))
	{
	  $line = ereg_replace ('^ +', '', $line);
	}
	else
	{
	  $text[$lineno - 1] .= '</ul>';
	  $bullet = 0;
	}
      }

      if (ereg ('^ *\*.+\* *$', $line))
      { // "*****", "*foo*"
	$text[$lineno] = ereg_replace ('^( *)(\*.+\*)( *)$', '\1<strong><em>\2</em></strong>\3', $line);
      }
      elseif (ereg ('^ *={2,} *$', $line))
      { // double underline
	if ($lineno > 0)
	  $text[$lineno] = '<!-- -->';
	$text[$lineno - 1] = ereg_replace ('^( *)(.+)( *)$', '\1<strong><em style="font-style: normal"><u style="underline: double">\2</u></em></strong>\3', $text[$lineno - 1]);
      }
      elseif (ereg ('^ *[-~]{2,} *$', $line))
      { // single underline
	if ($lineno > 0)
	  $text[$lineno] = '<!-- -->';
	$text[$lineno - 1] = ereg_replace ('^( *)(.+)( *)$', '\1<strong><u>\2</u></strong>\3', $text[$lineno - 1]);
      }
      elseif (substr ($line, 0, 2) == '* ')
      { // bulleted list
	$text[$lineno] = ereg_replace ('^\* +', '<li>', $line);
	if ($bullet == 0)
	  $text[$lineno] = '<ul>'.$text[$lineno];
	$bullet = 1;
      }
      else
      {
	// section number, ordered list (dotted)
	$line = ereg_replace ('^( *([0-9]+\.)+)([^0-9])', '<em>\1</em>\3', $line);
	// RISC OS bullet character
	$line = ereg_replace ("^\x8F", '<li>', $line);
	$line = str_replace ("\x8F", '&bull;', $line);
	// Bold, italic, underline
	$line = preg_replace ('%\b(\*[^ \*](\W*[^ \*])?\*)\b%', '<b>\1</b>', $line);
	$line = preg_replace ('%\b(/[^ /](\W*[^ /])?/)\b%', '<i>\1</i>', $line);
	$line = preg_replace ('%\b(_[^ _](\W*[^ _])?_)\b%', '<u>\1</u>', $line);
	// Done
	$text[$lineno] = $line;
      }
    }

    $text = ereg_replace ("\n<!-- -->([^\n]*)", '\1', join ("\n", $text));
    $text = strtr ($text, array ("\n<ul>" => '<ul>', "</ul>\n" => '</ul>'));

    // Handle some types of URL
    $text = do_replace ('([!-~]+@[-A-Za-z0-9]+(\.[-A-Za-z0-9]+)+)', '<a href="mailto:\1">\1</a>', $text);
    $text = do_replace ('(ftp|http)(://[-A-Za-z0-9]+(\.[-A-Za-z0-9]+)+/[^ \t\n]*)', '<a href="\1\2">\1\2</a>', $text);

    // Output...

    echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<!-- $Id: t2h.inc,v 1.2 2002/01/29 21:37:34 ds Exp $ -->';
    do_zap_header ();
    $orig = parturlencode ($orig);
    echo '<hr><!-- Here be plain text --><pre>', $text, '</pre>
<p align=right><em><small>This document was converted from plain text by
t2h. &copy; 2001 Zap Developers. <a href="'.$orig.'">Plain text</a></small></em></p>';
    echo '</pre>';
    zap_body_end ('$'.'Date: '.gmdate ('Y/m/d H:i:s', $date[9]).' $');
    echo '</HTML>';
  }
  else
  {
    // Not found, or a malformed request
    $me = htmlentities ($me);
    header ('HTTP/1.0 404 Not Found');
    echo <<<EOF
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<HTML><HEAD>
<TITLE>404 Not Found</TITLE>
</HEAD><BODY>
<H1>Not Found</H1>
The requested URL $me was not found on this server.<P>
</BODY></HTML>
EOF;
  }

?>
