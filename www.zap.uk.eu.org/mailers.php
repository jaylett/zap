<?php
  // $Id: mailers.php,v 1.1 2002/01/23 20:27:02 ds Exp $
  include ".php/zap-std.inc";
  setroot ('mailers');
  zap_header ("Configuring your mailreader", 'up:/', 'previous:lists:lists');
  zap_body_start ();
?>

<h1>Configuring your mailreader</h1>

<p><strong>The Zap mailing lists have now been moved to a different mailing list manager (GNU mailman). Different filters are required, and the list addresses have changed (though the old addresses will still work when posting).</strong></p>

<p>This page describes the configuration details which will be required after the move has taken place. For now, though, you should retain your old filters and create the new ones; once the changeover is completed, you will be able to dispose of the old filters; this is invariably done by selecting the filter then clicking on <em>Delete</em>.</p>

<p></p>
<table>
 <tr>
  <td align=right><h6>Mailreaders:</h6>
  <td>
   <a href="#messenger">Messenger</a>,
   <a href="#messenger">Messenger Pro</a>,
   <a href="#pluto">Pluto</a>,
   <a href="#ttfn">TTFN</a>,
   <!--a href="#marcel"-->Marcel<!--/a-->
 </tr>
 <tr>
  <td align=right><h6>Mail database managers:</h6>
  <td>
   <a href="#newsbase">Newsbase</a>,
   <a href="#msgserve">MsgServe</a>
 </tr>
</table>
<p></p>

<hr width="25%">

<h2><a name=newsbase>Configuring Newsbase</a></h2>

<p><font size="-2"><em>Darren Salt</em></font></p>

<p>Newsbase can easily be configured to automatically filter articles received from the Zap mailing lists into different folders. In order to perform this configuration, you'll need to do the following...</p>

<p><strong>If your copy of Newsbase is older than 0.59g, you will need to <a href="http://www.hep.umn.edu/~allan/newsbase/">download</a> and install a newer version.</strong></p>

<p>First, create or load <em>!Newsbase.Support.startup.c99nonstd</em>, and ensure that it contains:</p>

<pre>    add header list-id
</pre>

<p><em>Problem: Newsbase appears to accept no more than six user-defined headers. Five are already defined in startup.c05misc, as supplied with v0.61b.</em></p>

<p>Because of this problem, during the changeover period, you should comment out an <samp>add header</samp> line which names a header which is not used in any of your filters. Once the changeover is complete, you may delete the line <samp>add header mailing-list</samp> (or <samp>delivered-to</samp>, if you chose to filter on that) unless you require it for filtering other, non-Zap, mailing lists.</p>

<p>Now run Newsbase. When it has finished its initialisation, click Adjust on its icon then on the <strong>News/mail filters</strong> icon.</p>

<p>For each mailing list to which you (intend to) subscribe...</p>

<ol>
 <li>Click on the <em>Add</em> button.</li>
 <li>Click on the <em>Mail</em> option.</li>
 <li>Enter the details as follows (you'll want to change the bits marked as <kbd>keyboard input</kbd> to match the mailing list that you are subscribing to):
  <ul>
   <li>Type = mail; continue = off</li>
   <li>Name: <kbd>Zap devel</kbd></li>
   <li>When...
    <ul>
     <li><em>list-id =</em> <kbd>* &lt;zap-devel.zap.tartarus.org&gt;</kbd></li>
     <li><em>off</em></li>
     <li><em>off</em></li>
    </ul>
   </li>
   <li>Then...
    <ul>
     <li><em>redirect</em> <kbd>Folder.maillist.Zap.devel</kbd></li>
    </ul>
   </li>
   <li>Filter expiry = never</li>
  </ul>
 </li>
 <li>Adjust-click on the <em>OK</em> button.</li>
</ol>

<p>Finally, click on <em>Save</em>.</p>

<p>If you're using Messenger, then you'll also need to look <a href="#messenger">here</a>.</p>

<hr width="25%">

<h2><a name=msgserve>Configuring MsgServe</a></h2>

<p><font size="-2"><em>Darren Salt</em></font></p>

<p>If you want MsgServe to filter the Zap mailing lists automatically for you into different inboxes, you'll need to do the following.</p>

<p>Open Messenger Pro's Choices window, and click on the <strong>Filtering rules</strong> icon.</p>

<p>For each mailing list to which you (intend to) subscribe...</p>

<ol>
 <li>Click on the <em>Add</em> button. This will open a filter editing window.</li>
 <li>Enter the details as follows (you'll want to change the bits marked as <kbd>keyboard input</kbd> to match the mailing list that you are subscribing to):
  <ul>
   <li>Filter name: <kbd>Zap devel</kbd></li>
   <li>If match occurs, <em>store message in</em> <kbd>Folder.maillist.Zap.devel</kbd></li>
   <li><em>Mail</em> ticked, <em>News</em> unticked</li>
   <li>Matching criteria
    <ul>
     <li><em>List-Id =</em> <kbd>* &lt;zap-devel.zap.tartarus.org&gt;</kbd></li>
     <li><em>off</em></li>
     <li><em>off</em></li>
     <li><em>off</em></li>
    </ul>
   </li>
   <li>Expiry: keep filter indefinitely</li>
  </ul>
 </li>
 <li>Click on the <em>Set</em> button, or press Return.</li>
</ol>

<p>Finally, click on <em>Save</em>.</p>

<p>Since you must be using Messenger Pro to be using MsgServe, read on...</p>

<hr width="25%">

<h2><a name=messenger>Configuring Messenger and Messenger Pro</a></h2>

<p><font size="-2"><em>Darren Salt</em></font></p>

<p>You'll need to tell Messenger about the mailing lists: the name, the folder name and the address to which to send articles.</p>

<p>Open Messenger's Choices window, and click on the <strong>Mailing lists</strong> icon.</p>

<p>For each mailing list to which you (intend to) subscribe...</p>

<ol>
 <li>If you have not previously told Messenger about this mailing list, click on the <em>Add</em> button. This will open a mailing list configuration window.</li>
 <li>Otherwise, double click on the list name; again, this will open a configuration window. <em>Note, however, that the list's old address will continue to work. It is recommended that, if you plan to make this change, you wait until the changeover is complete.</em></li>
 <li>Enter (or edit) the details as follows (you'll want to change the bits marked as <kbd>keyboard input</kbd> to match the mailing list that you are subscribing to):
  <ul>
   <li>Name: <kbd>Zap devel</kbd></li>
   <li>Folder: <kbd>Folder.maillist.Zap.devel</kbd></li>
   <li>Address: <kbd>zap-devel@zap.tartarus.org</kbd></li>
  </ul>
 </li>
 <li>Click on the <em>OK</em> button, or press Return.</li>
</ol>

<p>Finally, click on <em>Close</em>.</p>

<p>With the freeware Messenger, it may be a good idea to add the mailing list addresses, with suitable aliases, to your address book. Adding to the public address book is recommended if more than one person will be reading and posting to them.</p>

<hr width="25%">

<h2><a name=ttfn>Configuring TTFN</a></h2>

<p><font size="-2"><em>Darren Salt, with input from Richard Sargeant</em></font></p>

<p><strong>0.42 and earlier</strong> do not have good support for mailing lists, although they do cope where the articles have Reply-To headers pointing to the list submission address.</p>

<p>Because they're handled by GNU mailman, the Zap mailing lists do not use the Reply-To header, so you're going to have to enter the mailing list address yourself for each message you post to any of the mailing lists.</p>

<p><!-- HEADERS ISSUE -->The recognition of <samp>Delivered-To: Mailing list foo@bar.baz</samp> in newer recent versions of TTFN doesn't appear to help here, since mailman isn't including that header.</p>

<!-- HEADERS ISSUE

<p><strong>From version 0.43</strong>, TTFN recognises the Delivered-To header and will use the address given when you follow up or post to, provided that the header content begins with <samp>mailing list</samp>. Replying will use the From or Reply-To address as normal.</p>

<p>It appears that to make a new posting to the list, you'll have to open an existing posting in order for TTFN to get the mailing list address, so it may be a good idea to add the mailing list addresses to your address book.</p>
-->

<hr width="25%">

<h2><a name=pluto>Configuring Pluto</a></h2>

<p><font size="-2"><em>Michael Chappell; updated by Darren Salt</em></font></p>

<p>It is fairly straightforward to configure Pluto to allow you to have separate boxes for each of the Zap mailing lists. This sets the mailing list up to look like a newsgroup.</p>

<p>From the icon bar menu choose <em>Lists</em> and then <em>Newsgroups</em>. This will bring up the list of newsgroups you are currently subscribed to.</p>

<p>For each mailing list to which you subscribe, the method is the same. I'm using the features mailing list as an example:</p>

<ol>
 <li>If you have not previously told Pluto about this mailing list, click on the <em>Add</em> button. This will open a mailing list configuration window.</li>
 <li>Otherwise, select the mailing list from those listed by Pluto. Again, this will open a configuration window.</li>
 <li>Look at the <em>List-Id:</em> address in the emails, and take the name which is before the <em>@</em> symbol. For example, in postings to the Zap features mailing list, this header contains the address <em>zap-features@zap.tartarus.org</em> (this is the same address as in the <em>To:</em> header).</li>
 <li>In the Name box enter <kbd>mail.features</kbd></li>
 <li>Set the Mailing List option. There are other options to allow you to specify a Default User, Signature and Box; these are described in Pluto's manual.</li>
</ol>

<p>Finally, click on <em>OK</em>.</p>

<p><!-- HEADERS ISSUE --><em>Whether Pluto will properly filter the mailing list and whether two filters for the same list can coexist (as will be needed during changeover) is presently unknown.</em></p>

<hr width="25%">

<h2><small><small><a name=marcel>Configuring Marcel</a></small></small></h2><!--remove small when info added-->

<p>Contributions welcome...</p>

<?php
  zap_body_end ('$Date: 2002/01/23 20:27:02 $');
?>
