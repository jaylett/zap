<?php
  // $Id: t2h.php,v 1.1 2002/01/23 20:27:05 ds Exp $

  include "../.php/zap-std.inc";

  function do_zap_header ()
  {
    zap_header ('ZapRedraw documentation', 'up:/redraw/');
    zapredraw_body_start ();
  }

  function do_zap_footer ()
  {
    zapredraw_body_end ();
  }

  include "../.php/t2h.inc";
?>
