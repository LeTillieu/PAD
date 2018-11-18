<?php
session_start();
setcookie("mailOrPseudo",$_SESSION["mailOrPseudo"],time(),"/",null,false,true);
setcookie("pw",$_SESSION["pw"],time(),"/",null,false,true);
session_destroy();
header("Location: ../index.php");