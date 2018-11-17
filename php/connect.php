<?php
//validation and initialization  of variables
$mailOrPseudo = filter_input(INPUT_POST,"mailOrPseudo",FILTER_SANITIZE_SPECIAL_CHARS);
$pw = filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);
$pw = hash("sha256",$pw);

//connection
if(!empty($mailOrPseudo) && !empty($pw)){
    $bdd = connectDb();
    if(userExistConnect($mailOrPseudo,$pw) === 0){
        if(isset($_POST["rememberMe"])){
            $_SESSION["mailOrPseudo"] = $mailOrPseudo;
            $_SESSION["pw"] = $pw;
            setcookie("mailOrPseudo",$_SESSION["mailOrPseudo"],time()+365*24*3600,"/",null,false,true);
            setcookie("pw",$_SESSION["pw"],time()+365*24*3600,"/",null,false,true);

        }
        $query = "SELECT * FROM users WHERE mail = :mailOrPseudo OR pseudo = :mailOrPseudo";
        $statement = $bdd->prepare($query);
        $statement->execute([
            ":mailOrPseudo" => $mailOrPseudo
        ]);

        $_SESSION["sessionId"] = $statement->fetchAll()[0][0];
    }else{
        $error = 4;
    }
}else{
    $error = 1;
}

redirect();