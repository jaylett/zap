<?php
  // $Id: contact.php,v 1.4 2004/10/27 11:41:03 james Exp $
  include ".php/zap-std.inc";
  setroot ('contact');
  zap_header ("Zap contact details", 'up:/');
  zap_body_start ();
?>

<h1>Zap contact details</h1>

<p>We prefer to be contacted via email; if you really need to write to us, write to James at the address given below.</p>

<h2>General email addresses</h2>

<p>Note that the following are mailing lists. For information on how to subscribe to the lists, see the <a href="lists">Zap mailing lists page</a>. Before reporting a bug or suggesting a feature, try to make sure it hasn't already been reported/proposed (this is difficult until we collate the lists of each).</p>

<dl>
 <dt><a href="mailto:zap-users@zap.tartarus.org">zap-users@zap.tartarus.org</a></dt>
  <dd>All bugs reports, non-technical queries or suggestions should be sent here</dd>
 <dt><a href="mailto:zap-technical@zap.tartarus.org">zap-technical@zap.tartarus.org</a></dt>
  <dd>For technical queries and discussions.</dd>
</dl>

<p>In addition, the usual 'master' addresses exist for the Zap domain: <a href="mailto:webmaster@zap.tartarus.org">webmaster@zap.tartarus.org</a>, <a href="mailto:hostmaster@zap.tartarus.org">hostmaster@zap.tartarus.org</a> and <a href="mailto:postmaster@zap.tartarus.org.">postmaster@zap.tartarus.org.</a> In addition, <a href="mailto:listmaster@zap.tartarus.org">listmaster@zap.tartarus.org</a> runs the <a href="lists">mailing lists</a>.</p>

<h2>Maintainers</h2>

<h3>Principal maintainers</h3>
<ul>
 <li><a href="#ds">Darren Salt</a>
 <li><a href="#sja">James Aylett</a>
 <li><a href="#christian">Christian Ludlam</a>
</ul>

<h3>'Emeritus' :-)</h3>
<ul>
 <li><a href="#tmt">Tim Tyler</a>
 <li><a href="#jrf">Justin Fletcher</a>
 <li><a href="#dhs">Dominic Symes</a>
 <li><a href="#mje">Martin Ebourne</a>
</ul>

<hr>

<h3><a name="ds">Darren Salt</a></h3>

<p>Darren maintains ZapEmail, ZapDS and sometimes ZapBASIC. In the core, he is responsible (amongst other things) for the command language, ClickSend, menus, internationalisation, and mode handling (including clone modes). He's also responsible for ZapRedraw's Viewfinder support.</p>

<address><a href="mailto:ds@zap.tartarus.org">ds@zap.tartarus.org</a></address>

<h3><a name="sja">James Aylett</a></h3>

<p>James maintains ZapFonts, the combined command extensions (although, to some extent, this is a shared responsibility), the 'glue' (documentation, web and ftp sites, domain, mailing lists), and an air of omniscience. He is also responsible (amongst other things) for c-vars and the general shape of the distribution. He currently works at Digital Advertising and Marketing ltd; please note that Zap has nothing to do with Digital Advertising and Marketing.</p>

<address><a href="mailto:dj@zap.tartarus.org">dj@zap.tartarus.org</a></address>
<address>James Aylett<br>Digital Advertising and Marketing Ltd<br>Eldon House<br>1 Dorset Street<br>LONDON<br>W1U 4BB<br>UK</address>

<h3><a name="christian">Christian Ludlam</a></h3>

<p>Christian maintains ZapRedraw and is responsible for driving that in the direction it's going. In Zap proper he fritters his time away fixing bugs, dreaming up wonderful ideas for the future, and correcting James' mistakes.</p>

<address><a href="mailto:christian@zap.tartarus.org">christian@zap.tartarus.org</a></address>

<hr>

<h3><a name="tmt">Tim Tyler</a></h3>

<p>Tim did lots of the work on v1.40, including coordinating its release. He also wrote vast numbers of syntax colouring modes, and maintained Martin's programming modes. Since v1.40 Tim has decided to try to use his time more wisely (:-), and avoid getting dragged into Zap too much.</p>
<!-- tt@cryogen.com -->

<h3><a name="jrf">Justin Fletcher</a></h3>

<p>Justin is responsible for enhancing Code mode beyond common sense, and a few other things. He's currently suffering from lack of time to devote to Zap (if 'suffering' is really the right word).</p>
<!-- gerph@innocent.com -->

<h3><a name="dhs">Dominic Symes</a></h3>

<p>Dominic was the initial developer of Zap, and its sole maintainer until the end of 1996.<!-- Dominic now works at ARM Ltd (and doesn't have much time for Zap things - in general you should not direct queries to him); please note that Zap has nothing to do with ARM.--></p>
<!-- Dominic.Symes@armltd.co.uk; Dominic Symes, Advanced RISC Machines Ltd, Fulbourn Road, Cherry Hinton, Cambridge CB1 4JN, UK -->

<h3><a name="mje">Martin Ebourne</a></h3>

<p>Martin wrote the C, C++, Java, Assembler and Pascal modes which form much of the use of Zap (at least by its current developers). He also wrote the plug and play auto-configuration system we've been using since v1.40.</p>
<!-- martin@galaxy.tcp.co.uk -->

<?php
  zap_body_end ('$Date: 2004/10/27 11:41:03 $');
?>
