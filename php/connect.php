<?php


$mail = filter_input(INPUT_POST,"mail",FILTER_SANITIZE_SPECIAL_CHARS);
$pw = filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);
$pw = hash("sha256",$pw);
if(!empty($mail) && !empty($pw)){
    $bdd = connectDb();
    if(userExistConnect($mail,$pw) === 0){
        if(isset($_POST["rememberMe"])){
            $_SESSION["mail"] = $mail;
            $_SESSION["pw"] = $pw;

        }
        $query = "SELECT * FROM users WHERE mail = :mail";
        $statement = $bdd->prepare($query);
        $statement->execute([
            ":mail" => $mail
        ]);
        $_SESSION["sessionId"] = $statement->fetchAll()[0][0];
    }else{
        $error = 4;
    }
}else{
    $_SESSION["state"] = 0;
    $error = 1;
}

redirect();