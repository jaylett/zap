<?php
  // $Id: zap-std.inc,v 1.1 2002/01/23 20:45:55 ds Exp $

  // setroot: find the document's root URL and put it in $root.
  //	      Must be called from the includer immediately after inclusion.
  //	      It outputs part of the document header and allows
  //	      relocatability within a site for testing purposes etc.
  // $me == pathname relative to the document root.
  function setroot ($me)
  {
    global $root;
    $root = $GLOBALS['SCRIPT_NAME'];
    if (substr ($root, -4) == '.php')
      $root = substr ($root, 0, -4);
    $path = strlen (ereg_replace ('[^/]+', '', $GLOBALS['PATH_INFO']));
    while ($path)
    {
      $root = ereg_replace ('/[^/]*$', '', $root);
      $path--;
    }
    if (substr ($root, -strlen ($me)) == $me)
      $root = substr ($root, 0, -strlen ($me));
    $path = $GLOBALS['PATH_TRANSLATED'];
    if (substr ($root, -strlen ($path)) == $path)
      $root = substr ($root, 0, -strlen ($path));

    $args = func_get_args ();
    array_shift ($args);
    if (func_num_args () == 1)
      array_push ($args, '');
    if (!in_array ($GLOBALS['PATH_INFO'], $args, FALSE))
    {
      include str_repeat ('../', strlen (ereg_replace ('[^/]+', '', $me))).'404.php';
      exit;
    }

    global $expire;
    // Document is valid for $expire seconds from now (default null)
    if ($expire != '')
      header ('Expires: '.gmdate ('D, d M Y H:i:s', time() + $expire).' +0000');

    // DTD declaration, HTML preamble.
    // $subdtd defines which HTML 4.01 DTD is used (default Transitional)
    echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 ', ($subdtd == '' ? 'Transitional' : $subdtd), "//EN\">\n<html>\n";
  }

/*
  function mklink ($href, $content)
  {
    global $root;
    # maybe generate relative links one day...?
    $ret = '<a href="'.$root.substr ($href, 1);
    if (func_num_args () > 2)
      $ret .= '" '.func_get_arg (2).'>';
    else
      $ret .= '">';
    return $ret.$content.'</a>';
  }
*/

  // zap_header: write out a standardised header with <link> elements etc.
  // $title == the document title
  // following arguments == "TYPE:HREF" => <link rel=TYPE href="HREF">
  function zap_header ($title)
  {
    global $root;
    echo "<head>\n<title>", $title, "</title>\n";
    if (eregi ('^(www\.)?zap\.uk\.eu\.org', $GLOBALS['HTTP_HOST']))
      echo "<base href=\"http://zap.tartarus.org/\">\n";
    echo <<<EOF
 <link rel=stylesheet href="${root}style/main.css" type="text/css">
 <link rel=author href="mailto:webmaster@zap.tartarus.org">
 <link rel=copyright href="${root}copyright">

EOF;
    $desc = "Zap is a configurable programmers' editor for Acorn RISC OS";
    $i = 1;
    $links = array ('author', 'copyright', 'stylesheet');
    while ($i < func_num_args ())
    {
      $arg = func_get_arg ($i);
      switch ($arg) {
	case 'ZR':
	  $desc = "ZapRedraw is a fast text plotter for Acorn RISC OS";
	  break;
	default:
	  $arg = explode (':', $arg, 3);
	  if (!in_array ($arg[0], $links))
	  {
	    array_push ($links, $arg[0]);
	    if (count ($arg) > 1 && $arg[1] > '')
	    {
	      if (substr ($arg[1], 0, 1) == '/')
		$arg[1] = substr ($arg[1], 1);
	      echo '<link rel=', $arg[0], ' href="', $root, $arg[1];
	      if (count ($arg) == 3)
		echo '" title="', $arg[3];
	      echo "\">\n";
	    }
	  }
      }
      $i++;
    }
    if (!in_array ('top', $links))
      echo "<link rel=top href=\"$root\" title=home>\n";
    if (!in_array ('help', $links))
      echo "<link rel=help href=\"${root}documentation/\" title=documentation>\n";
    echo '<meta name=description content="'.$desc."\">\n";
    echo <<<EOF
 <meta name=keywords content="Zap, editor, text editor, Acorn, Risc OS, Tim Tyler, Darren Salt, Martin Ebourne, Dominic Symes, James Aylett">
</head>
EOF;
  }


  // zap_body_start_common: write out the start of the <body> element.
  function zap_body_start_common ()
  {
    global $root;
    echo <<<EOF
<body background="${root}img/background.gif"
      text="#000000"
      bgcolor="#DCDCDC"
      link="#20209F"
      vlink="#008000"
      alink="#FF2020">
EOF;
  }


  // check_host_header: issue a warning if this page is accessed through a
  //			deprecated hostname.
  function check_host_header ()
  {
    global $root;
    if (eregi ('^(www\.)?zap\.uk\.eu\.org', $GLOBALS['HTTP_HOST']))
      echo '
<table align=center width="66%" cellpadding=12>
 <tr>
  <td>
   <table width="100%" cellpadding=4 cellspacing=3 border=2>
    <tr>
     <td bgcolor="#ffff00"><img alt="" src="${root}img/clear.png" width=1 height=1></td>
     <td>
      <p><font color="#770000"><big>You have accessed this site using the deprecated <em>zap.uk.eu.org</em> domain instead of <em>zap.tartarus.org.</em></big></font></p><p><font color="#dd0000">If you used a bookmark, you are advised to update it.</font></p><p><font color="#dd0000">If you accessed it through a link on another web page, you should contact that site\'s webmaster, asking them to update their links.</font></p><p><font color="#dd0000">Click <a href="http://zap.tartarus.org', $GLOBALS['REQUEST_URI'], '">here</a> to access this page through <em>zap.tartarus.org.</em></font></p>
     </td>
     <td bgcolor="#ff8000"><img alt="" src="${root}img/clear.png" width=1 height=1></td>
    </tr>
   </table>
  </td>
 </tr>
</table>';
  }


  // zap_body_start: write out the start of the document body for a Zap page.
  //		     Calls zap_body_start_common.
  function zap_body_start ()
  {
    global $root;
    zap_body_start_common ();
    echo <<<EOF

<div class=wide>
 <table width="100%" cellspacing=0 cellpadding=0 border=0>
  <tr>
   <td width=106 valign=bottom><a href="${root}"><img alt="Zap" src="${root}img/zap.top.png" width=106 height=68 border=0></a></td>
   <td align=right valign=middle style="margin: 0em" nowrap=nowrap>
    <a href="${root}documentation/" class=tbar><big>Documentation</big></a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="/ftp/pub/stable/" class=tbar><big>Latest&nbsp;release</big></a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <br>
    <a href="${root}redraw/" class=tbar><big>ZapRedraw</big></a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="${root}contact" class=tbar><big>Contact</big></a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="${root}download" class=tbar><big>Download</big></a>
    &nbsp;&nbsp;&nbsp;&nbsp;
   </td>
  </tr>
  <tr bgcolor="#0021D0">
   <td width=106><a href=""><img alt="" src="${root}img/zap.bar.png" width=106 height=4 border=0></a></td>
   <td><img alt="" src="${root}img/clear.png" width=4 height=4></td>
  </tr>
  <tr>
   <td width=106><a href="${root}"><img alt="" src="${root}img/zap.tail.png" width=106 height=12 border=0></a></td>
   <td><img alt="" src="${root}img/clear.png" width=4 height=12></td>
  </tr>
 </table>
</div>
EOF;

    check_host_header ();
  }


  // zapredraw_body_start: write out the start of the document body for a
  //			   ZapRedraw page. Calls zap_body_start_common.
  function zapredraw_body_start ()
  {
    global $root;
    zap_body_start_common ();
    echo <<<EOF

<table width="100%">
 <tr>
  <td valign=middle>
   <img alt="ZapRedraw" src="${root}img/redraw.png" width="408" height="96">
  </td>
  <td valign=middle align=right>
   <a href="${root}documentation/">Documentation</a><br>
   <a href="${root}download">Download</a><br>
   <a href="/ftp/pub/stable/">Latest&nbsp;release</a><br>
   <a href="${root}contact">Contact</a><br>
   <a href="${root}">Zap home page</a>
  </td>
 </tr>
</table>

<hr>
EOF;

    check_host_header ();
  }


  // zap_body_end: write out the end of the body element, along with the
  //		   standard footer content.
  // $date == the last-modified date (CVS-format 'date').
  function zap_body_end ($date)
  {
    global $root;
    echo <<<EOF
<hr class=wide size=4>
<table width="100%" cellspacing=0 cellpadding=0 border=0>
<tr>
<td>
<address>
<a href="${root}copyright">&copy; Copyright Zap Developers 2001. All rights reserved.</a>
EOF;
    $date = ereg_replace ('^\$Date: 2002/01/23 20:45:55 $date);
    $date = ereg_replace (' \$$', '', $date);
    print '<br>Updated: '.$date;
    echo <<<EOF
. <a href="mailto:webmaster@zap.tartarus.org">webmaster@zap.tartarus.org</a>
</address>
</td>
<td><a href="http://validator.w3.org/check/referer"><img border=0 src="${root}img/valid-html401.png" alt="Valid HTML 4.01!" height=31 width=89></a></td>
</tr>
</table>

</body>
</html>
EOF;
  }

?>
