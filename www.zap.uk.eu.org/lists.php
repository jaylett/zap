<?php
  // $Id: lists.php,v 1.2 2002/04/24 23:21:43 ds Exp $
  include ".php/zap-std.inc";
  setroot ('lists');
  zap_header ("Zap mailing lists", 'up:/', 'next:mailers:mailers');
  zap_body_start ();
?>

<h1>Zap mailing lists</h1>

<p>There are a range of mailing lists pertaining to Zap, which are listed below. They are run using <a href="http://www.lists.org/">GNU Mailman</a>; you can subscribe via the <a href="http://lists.tartarus.org/mailman/listinfo">web interface</a>, or by sending an email to <samp>&lt;listname&gt;-request@zap.tartarus.org</samp> with the text <kbd>subscribe</kbd> in either the subject line or body. The list server will send back a confirmation email which contains instructions on how to finalise your subscription.</p>

<p>The web interface also allows you to configure some aspects of your subscription, such as whether you receive the list as posts are sent to it, or as a regular digest. You can also access the list archives in this way.</p>

<p>Some time ago now, we changed the names of the lists. Where previously they would have been of the form <tt>beta@zap.tartarus.org</tt>, they are now <tt>zap-beta@zap.tartarus.org</tt>.</p>

<p>All Zap lists, except for <em>zap-announce,</em> are 'open'; that is, you don't have to be subscribed to the lists to post to them (this is particularly important for things like the bug list). <em>zap-announce</em> is moderated; each message sent to it is checked first by one of the Zap development team. Please try to ensure that you send your message to the correct list (especially in the case of bugs, because they should get fixed faster if they get sent to the right place :-).</p>

<dl>
 <dt><a href="mailto:zap-buglist@zap.tartarus.org">zap-buglist</a></dt>
  <dd>
   <p>This is the list where bug reports are discussed. Please do <em>not</em> send bug reports to this address; use <tt><a href="mailto:bugs@zap.tartarus.org">bugs@zap.tartarus.org</a></tt> instead.</p>
   <p>Note that email to this list will have its <em>Reply-To</em> header set to the list. This is evil, and I shouldn't do it, but I discovered I more or less had to, because so many people were replying to the bug submission email address instead of the list. See <a href="http://www.unicom.com/pw/reply-to-harmful.html">Reply-To Munging Considered Harmful</a> for an overview of why this makes me shiver uncontrollably. Ideally I'll write a small filter which will add <em>Reply-To</em> to emails coming in from the submission address <em>only</em>, so I can remove this.</p>
   <p><a href="http://lists.tartarus.org/mailman/listinfo/zap-buglist">Subscribe to zap-buglist</a></p>
  </dd>

 <dt><a href="mailto:zap-beta@zap.tartarus.org">zap-beta</a></dt>
  <dd>
   <p>This is the discussion list for people participating in beta testing of Zap. (You can 'become' a beta tester simply by <a href="download">downloading</a> the latest beta version and starting to use it.) Please do <em>not</em> send beta bug reports to this address; use <tt><a href="mailto:betabugs@zap.tartarus.org">betabugs@zap.tartarus.org</a></tt> instead.</p>
   <p><a href="http://lists.tartarus.org/mailman/listinfo/zap-beta">Subscribe to zap-beta</a></p>
  </dd>

 <dt><a href="mailto:zap-features@zap.tartarus.org">zap-features</a></dt>
  <dd>
   <p>A largely non-technical list for discussion of proposed new features.</p>
   <p><a href="http://lists.tartarus.org/mailman/listinfo/zap-features">Subscribe to zap-features</a></p>
  </dd>

 <dt><a href="mailto:zap-devel@zap.tartarus.org">zap-devel</a></dt>
  <dd>
   <p>A largely technical list for discussion of alterations and additions to the core of Zap.</p>
   <p><a href="http://lists.tartarus.org/mailman/listinfo/zap-devel">Subscribe to zap-devel</a></p>
  </dd>

 <dt><a href="mailto:zap-technical@zap.tartarus.org">zap-technical</a></dt>
  <dd>
   <p>Other technical issues: this is where to ask questions such as &quot;How do I write a mode/command to do ...&quot;</p>
   <p><a href="http://lists.tartarus.org/mailman/listinfo/zap-technical">Subscribe to zap-technical</a></p>
  </dd>

 <dt>zap-announce (moderated)</dt>
  <dd>
   <p>A list to which announcements of important changes is made. In general these announcements will also be posted to comp.sys.acorn.announce.</p>
   <p><a href="http://lists.tartarus.org/mailman/listinfo/zap-announce">Subscribe to zap-announce</a></p>
  </dd>

</dl>

<p>If you need to filter mail from these lists, the best way to do it is to filter on the List-Id header. This will appear something like below. (If you need it, we have information specific to <a href="mailers">using the Zap mailing lists with Acorn mail software</a>.)</p>

<pre>List-Id: Technical discussion of Zap development. &lt;zap-devel.zap.tartarus.org&gt;
</pre>

<?php
  zap_body_end ('$Date: 2002/04/24 23:21:43 $');
?>
