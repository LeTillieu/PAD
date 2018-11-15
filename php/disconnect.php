<?php
session_start();
setcookie("mail",$_SESSION["mail"],time(),"/",null,false,true);
setcookie("pw",$_SESSION["pw"],time(),"/",null,false,true);
session_destroy();
header("Location: ../index.php");