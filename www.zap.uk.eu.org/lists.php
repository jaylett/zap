<?php
  // $Id: lists.php,v 1.3 2004/10/27 11:35:28 james Exp $
  include ".php/zap-std.inc";
  setroot ('lists');
  zap_header ("Zap mailing lists", 'up:/', 'next:mailers:mailers');
  zap_body_start ();
?>

<h1>Zap mailing lists</h1>

<p>There are a range of mailing lists pertaining to Zap, which are listed below. They are run using <a href="http://www.lists.org/">GNU Mailman</a>; you can subscribe via the <a href="http://lists.tartarus.org/mailman/listinfo">web interface</a>, or by sending an email to <samp>&lt;listname&gt;-request@zap.tartarus.org</samp> with the text <kbd>subscribe</kbd> in either the subject line or body. The list server will send back a confirmation email which contains instructions on how to finalise your subscription.</p>

<p>The web interface also allows you to configure some aspects of your subscription, such as whether you receive the list as posts are sent to it, or as a regular digest. You can also access the list archives in this way.</p>

<p>All Zap lists, except for <em>zap-announce,</em> are 'open'; that is, you don't have to be subscribed to the lists to post to them (this is particularly important for things like the bug list). <em>zap-announce</em> is moderated; each message sent to it is checked first by one of the Zap development team. Please try to ensure that you send your message to the correct list (especially in the case of bugs, because they should get fixed faster if they get sent to the right place :-).</p>

<dl>
 <dt><a href="mailto:zap-users@zap.tartarus.org">zap-users</a></dt>
  <dd>
   <p>This is the list for most questions about Zap, suggestions for new features, and so on. It is largely non-technical. (There were previously three distinct lists, <em>zap-buglist</em>, <em>zap-beta</em> and <em>zap-technical</em>; as a result, archives don't currently extend back very far.)</p>
   <p><a href="http://lists.tartarus.org/mailman/listinfo/zap-users">Subscribe to zap-users</a></p>
  </dd>
 </dt>

 <dt><a href="mailto:zap-technical@zap.tartarus.org">zap-technical</a></dt>
  <dd>
   <p>A largely technical list for discussion of alterations and additions to Zap or its extensions. (There were previously two distinct lists, <em>zap-technical</em> and <em>zap-devel</em>; as a result, archives don't currently extend back very far, as much development discussion happened in the <em>zap-devel</em>.)</p>
   <p><a href="http://lists.tartarus.org/mailman/listinfo/zap-technical">Subscribe to zap-technical</a></p>
  </dd>

 <dt>zap-announce (moderated)</dt>
  <dd>
   <p>A list to which announcements of important changes is made. In general these announcements will also be posted to comp.sys.acorn.announce.</p>
   <p><a href="http://lists.tartarus.org/mailman/listinfo/zap-announce">Subscribe to zap-announce</a></p>
  </dd>

</dl>

<p>If you need to filter mail from these lists, the best way to do it is to filter on the List-Id header. This will appear something like below. (If you need it, we have information specific to <a href="mailers">using the Zap mailing lists with Acorn mail software</a>.)</p>

<pre>List-Id: General discussion and queries about Zap &lt;zap-users.zap.tartarus.org&gt;
</pre>

<?php
  zap_body_end ('$Date: 2004/10/27 11:35:28 $');
?>
