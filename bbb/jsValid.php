<?php
    session_start();
   setcookie("js",password_hash(date(wd).$_SERVER['REMOTE_ADDR']."Agora Was Here", PASSWORD_DEFAULT)) ;
?>
<html>
   
   <head>
      <title>meh</title>
   </head>

   
</html>