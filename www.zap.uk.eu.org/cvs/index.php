<?php
  // $Id: index.php,v 1.1 2002/01/23 20:27:03 ds Exp $
  include "../.php/zap-std.inc";
  setroot ('cvs/index');
  zap_header ("Zap - CVS access", 'up:../', 'previous:../mirrors:mirrors');
  zap_body_start ();
?>

<h1>Zap CVS Tree</h1>

<p>Zap's source tree is maintained under <a href="http://www.cyclic.com/">CVS</a>, a version/revision control system which lets multiple developers work on one source tree fairly easily. Access to the CVS tree is available through two methods: firstly, via a <a href="http://cvs.tartarus.org/zap/">web gateway</a> which lets you browse the tree, and secondly through CVS <a href="#pserver">pserver</a>. Write access is only available to main Zap developers at present; if you want to contribute material, send it to one of us (if you start sending lots of useful stuff you'll be a main developer by default, and we'll give you write access).</p>

<p>The files in the CVS tree are stored using Acorn's method for storing filetypes under NFS, namely as <samp>&lt;filename&gt;,&lt;filetype&gt;</samp> where the filetype is a three digit hex number with lower case letters. The <a href="http://gallery.uunet.be/John.Tytgat/cvs">RISC OS CVS port</a> will handle this translation automatically, as will RISC OS NFS clients (allowing the files to reside on a UNIX machine).</p>

<p>Alternatively, <a href="/ftp/pub/unstable/snapshots/">daily snapshots</a> of development work are generated automatically, both in source and binary form.</p>

<h2><a name="pserver">pserver</a></h2>

<p>People with the ability to run CVS can access the Zap tree through CVS's remote access system, called 'pserver'. The details are:</p>

<ul>
 <LI>host: <kbd>cvs.zap.uk.eu.org</kbd></li>
 <LI>user: <kbd>cvsuser</kbd></li>
 <LI>CVS path: <kbd>/home/cvs</kbd></li>
 <LI>password: <kbd>anonymous</kbd></li>
 <li>Entire CVS root (suitable for passing to cvs's -d option): <kbd>:pserver:cvsuser@cvs.zap.uk.eu.org:/home/cvs</kbd></li>
</ul>

<p>Quick guide to using CVS and pserver:</p>

<dl>
 <dt><kbd>cvs -d :pserver:cvsuser@cvs.zap.uk.eu.org:/home/cvs login</kbd></dt>
  <dd><p>Prompts you for the password (<kbd>anonymous</kbd>). You only need to do this once on most systems, because CVS will remember your password.</p></dd>
 <dt><kbd>cvs -z6 -d :pserver:cvsuser@cvs.zap.uk.eu.org:/home/cvs checkout zap</kbd></dt>
  <dd>
   <p>Checks out a complete copy of Zap. From then on, within the directory structure that it creates, you don't need to specify the -d option - it will remember the CVS root you are using. Note that the entire tree is quite big - it includes various extensions as well as Zap itself. If you just want part of it, a <a href="#modules">list of modules</a> is available below.</p>
   <p>Note that this will always give you the <em>unstable</em> (development) release of Zap.</p>
  </dd>
 <dt><kbd>cvs -z6 -d :pserver:cvsuser@cvs.zap.uk.eu.org:/home/cvs checkout -r
<em>TAG</em> zap/!ZapSource</kbd></dt>
  <dd><p>As above, but checks out a copy of Zap with tag TAG. See below for more information - a tag will be created for each stable release, for bugfixes.</p></dd>
  <dt><kbd>cvs -z6 update</kbd></dt>
   <dd><p>Brings your copy of the source in line with the latest version on the server. This will use whatever tag you specified when checking out the source.</p></dd>
</dl>

<h2><a name="modules">Modules</a></h2>

<p>The HEAD (what you get when you check out without a tag) is the development version. This hasn't always been the case, so there is some muddling in some modules (particularly the Zap core source).</p>

<p>There are a whole bunch of other useful modules, as well. In general, individual parts of Zap will live within <em>sources</em>, <em>dists</em> or <em>docs</em>, depending on their purpose. Anything else at the top level of the Zap module is probably not used to build the distribution - individual maintainers' notes on progress, and so on.</p>

<dl>
 <dt><tt>zap/sources/!ZapSource</tt></dt>
  <dd>The main Zap source code.</dd>
 <dt><tt>zap/sources/!ZapRedraw</tt></dt>
  <dd>ZapRedraw source.</dd>
 <dt><tt>zap/sources/modes/!ZapBASIC</tt></dt>
  <dd>ZapBASIC source code.</dd>
 <dt><tt>zap/sources/extensions/!ZapExtSrc</tt></dt>
  <dd>Zap command extensions source code.</dd>
 <dt><tt>zap/sources/extensions/!ZapConfig</tt></dt>
  <dd>ZapConfig source code. (Currently not up to date with Zap.)</dd>
 <dt><tt>zap/docs</tt></dt>
  <dd>Zap's documentation.</dd>
 <dt><tt>zap/sja-notes</tt></dt>
  <dd>James Aylett's notes on current progress / future ideas. This includes the known bug and wish lists</dd>
</dl>

<h2><a name="build">Building Zap</a></h2>

<p>Makefiles are provided to build Zap using either <a href="#build-acorn">amu/objasm/link</a> or <a href="#build-free">make/AS/drlink</a> under RISC OS. In addition, tools for building the main Zap code under <a href="#build-unix">Unix</a> (using make/AS under unix/drlink under unix) are available.</p>

<h3><a name="build-acorn">Building using Acorn tools</a></h3>

<p>There are two ways of building Zap using the Acorn tools. The first is more automated, but the second is the prefered system. You will need objasm v3.06, link v5.06 and amu v5.02 (earlier versions may work as well).</p>

<ol>
 <li>Double click on !Zap.!Makefile. This runs two separate Makefiles to build Zap.</li>
 <li>
  <p>From a taskwindow, while in the !Zap directory, run <tt>amu</tt>. This will build Zap with the standard build name (to get another build name, use <kbd>amu BUILD=foo</kbd> or <kbd>amu BUILD=foo-42</kbd>).</p>
  <p>The amu Makefile actually has a number of different targets. The following are available:</p>
  <ul>
   <li><kbd>amu Zap</kbd> - build Zap itself
   <li><kbd>amu ZapHdrs</kbd> - rebuild Zap's headers; you'll probably need to do this the first time you get the source. You'll also need to do this if the inter-file exports change; basically, if things aren't building right, try running this.</li>
   <li><kbd>amu clean</kbd> - clean out all temporary files (but not the generated header files)</li>
   <li><kbd>amu rebuild</kbd> - wipe o.ModuleBits and rebuild (ensures the the build name is correct)</li>
   <li><kbd>amu Revision</kbd> - stamps h.Version (to make sure that a version number change ensures a consistent rebuild)</li>
  </ul>
 </li>
</ol>

<h3><a name="build-free">Building using free RISC OS tools</a></h3>

<p>Again, there are two ways of building Zap using the free RISC OS tools. You will need AS v1.30, drlink v0.30 and make v1.02 (earlier versions of AS almost certainly won't work; get the latest version from <a href="http://www.youmustbejoking.demon.co.uk/progs.apps#as">Darren's website</A>). The others are available from <a href="http://www.mirror.ac.uk/collections/hensa-micros/local/riscos/">UK Mirror's HENSA archive</a>.</p>

<ol>
 <li>Double click on !Zap.!MakeAS. This doesn't always work, and the second method is better anyway.</li>
 <li>
  <p>From a taskwindow, while in the !Zap directory, run <kbd>make -r -f MakefileAS</kbd>. This will build Zap with the standard build name (to get another build name, use <kbd>make -r -f MakefileAS BUILD=foo</kbd> or <kbd>make -r -f MakefileAS BUILD=foo-42</kbd>).</p>
  <p>The AS Makefile actually has a number of different targets. The following are available:</p>
  <ul>
   <li><kbd>make -r -f MakefileAS Zap</kbd> - build Zap itself</li>
   <LI><kbd>make -r -f MakefileAS ZapHdrs</kbd> - rebuild Zap's headers; you'll probably need to do this the first time you get the source. You'll also need to do this if the inter-file exports change; basically, if things aren't building right, try running this.</li>
   <li><kbd>make -r -f MakefileAS clean</kbd> - clean out all temporary files (but not the generated header files)</li>
   <li><kbd>make -r -f rebuild</kbd> - wipe o.ModuleBits and rebuild (ensures the the build name is correct)</li>
   <li><kbd>make -r -f MakefileAS Revision</kbd> - stamps h.Version (to make sure that a version number change ensures a consistent rebuild)</li>
  </ul>
 </li>
</ol>

<h3><a name="build-unix">Building under Unix</a></h3>

<p>There is only one method for building under Unix. You will need AS v1.30, built for your Unix, available in your path as <tt>as_ro</tt>, drlink v0.3.4, built for your Unix, available in your path as <tt>link_ro</tt>, perl v5, sed v2.05 and make v3.76.1. Perl is available from <a href="http://www.perl.com/">www.perl.com</a>; sed and make are available from <a href="http://www.fsf.org/">The FSF</a> (though try the sources for your districution first). as_ro can be built from the source, or we can supply it pre-built for ELF i386 linux; link_ro can probably be supplied pre-built for ELF i386 linux on request, but we do not have permission to distribute the source code. (Alternatively, if you have access to ARM's development kit, you can hack data/unix/Makefile to use that instead; you'll need to change the <tt>asm</tt>, <tt>link</tt>,
<tt>asmflags</tt> and <tt>linkflags</tt> variables in the makefile, near the
bottom of the [System] section.)</p>

<p>The command to run, from within the !Zap directory, is <kbd>make -f data/unix/Makefile</kbd>. This gives the default build name; you can use <kbd>make -f data/unix/Makefile BUILD=foo</kbd> and <kbd>make -f data/unix/Makefile BUILD=foo-42</kbd> as above.</p>

<?php
  zap_body_end ('$Date: 2002/01/23 20:27:03 $');
?>
