<?php
  // $Id: t2h.php,v 1.1 2002/01/23 20:27:04 ds Exp $

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

  include "../.php/t2h.inc";
?>
