<?php
  // $Id: t2h.php,v 1.2 2002/01/29 21:37:34 ds Exp $

  include "../.php/zap-std.inc";

  function do_zap_header ()
  {
    zap_header ('Zap documentation', 'up:/documentation/');
    zap_body_start ();
  }

  function do_zap_footer ()
  {
    zap_body_end ();
  }

  $root = 'documentation/t2h.php';
  include "../.php/t2h.inc";
?>
