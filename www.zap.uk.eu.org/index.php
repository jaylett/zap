<?php
  // $Id: index.php,v 1.4 2002/04/24 23:21:43 ds Exp $
  include ".php/zap-std.inc";
  setroot ('index');
  zap_header ("Zap - a programmers' editor", 'top:');
  zap_body_start ();
?>
<h1>Zap - a programmers' editor</h1>

<p>The latest release version of Zap is 1.40. More options, and Zap extensions, are available from the <a href="download">download page</a>. You can also access the source tree via <a href="cvs/">CVS</a>.</p>

<ul>
<?php
  function plink ($leaf)
  {
    global $ftproot;
    $link = readlink ($ftproot.$leaf);
    echo '<li>', ucfirst ($leaf), '</a> distribution (v', $link,
	 '): <a href="/ftp/pub/', $leaf,
	 '/">directory,</a> <a href="download#',
	 ereg_replace ('\.', '', $link), "\">downloads page</a>\n";
  }
  plink ('stable');
  plink ('beta');
?>
 <li><a href="screenshots">Screenshots</a>
</ul>

<hr>

<p>Zap is a programmer's editor for RISC OS on Acorn and compatible computers. It has a large number of features designed to facilitate programming (particularly source code), as well as full text editing facilities. It is also highly configurable and extensible. There is a <a href="documentation/faq">list of frequently asked questions</a>, and their answers.</p>

<p>If you wish to get in touch with the Zap development team then please use the appropriate email address from the <a href="contact">contact page</a>. If you wish to get involved in the development effort, you will probably want to subscribe to one or more of the <a href="lists">mailing lists</a>. Before reporting a bug or making a suggestion, we advise checking the Changes file in the current Zap distribution to see if it has already been dealt with.</p>

<p>We hope that you find Zap to be a useful program.</p>

<hr>

<p>The zap.uk.eu.org domain is supplied by <a href="http://www.eu.org/">eu.org</a>, a source of free domain registration. Primary DNS is supplied by <a href="http://tartarus.org/">Tartarus.Org</a>, and secondary DNS arranged by <a href="http://www.metahusky.net/gavin/">Gavin Kelman</a>. It is, however, being phased out due to technical problems.</p>

<?php
  zap_body_end ('$Date: 2002/04/24 23:21:43 $');
?>
