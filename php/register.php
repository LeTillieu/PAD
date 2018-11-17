<?php
//validation and initialization  of variables
$mail = filter_input(INPUT_POST,"mail",FILTER_SANITIZE_SPECIAL_CHARS);
$pseudo = filter_input(INPUT_POST,"pseudo",FILTER_SANITIZE_SPECIAL_CHARS);
$pw = filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);
$pw = hash("sha256",$pw);
$error = 0;

//registration
if(!empty($mail) && !empty($pseudo) && !empty($pw)){
    if(strpos($mail,"@") >= 0){
        if(userExistRegister($mail, $pseudo) === 0){
            $bdd = connectDb();
            $query = "INSERT INTO users (mail, pseudo, password) VALUE(:mail, :pseudo, :password)";
            $statement = $bdd->prepare($query);
            $statement->execute([
                ":mail" => $mail,
                ":pseudo" => $pseudo,
                ":password" => $pw
            ]);

            $query = "SELECT * FROM users WHERE mail = :mail";
            $statement = $bdd->prepare($query);
            $statement->execute([
                ":mail" => $mail
            ]);
            $_SESSION["sessionId"] = $statement->fetchAll()[0][0];
        }else{
            $error = 3;
        }
    }else{
        $error = 2;
    }
}else{
    $error = 1;
}
$_SESSION["sessionId"] = NULL;
redirect();

