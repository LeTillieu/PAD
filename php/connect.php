<?php


$mail = filter_input(INPUT_POST,"mail",FILTER_SANITIZE_SPECIAL_CHARS);
$pw = filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);

if(!empty($mail) && !empty($pw)){
    $bdd = connectDb();
    if(userExist($mail,$pw) === 0){
        if(isset($_POST["rememberMe"])){
            $_SESSION["mail"] = $mail;
            $_SESSION["pw"] = crypt($pw,CRYPT_BLOWFISH);
        }
        $_SESSION["state"] = 1;
    }else{
        $error = 4;
    }
}else{
    $_SESSION["state"] = 0;
    $error = 1;
}

redirect();