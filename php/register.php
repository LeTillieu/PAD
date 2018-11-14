<?php


$mail = filter_input(INPUT_POST,"mail",FILTER_SANITIZE_SPECIAL_CHARS);
$pseudo = filter_input(INPUT_POST,"pseudo",FILTER_SANITIZE_SPECIAL_CHARS);
$pw = filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);
$pw = crypt($pw, CRYPT_BLOWFISH);
$error = 0;

if(!empty($mail) && !empty($pseudo) && !empty($pw)){
    if(strpos($mail,"@") >= 0){
        if(userExist($mail, null) === 0){
            $bdd = connectDb();
            $query = "INSERT INTO users (mail, pseudo, password) VALUE(:mail, :pseudo, :password)";
            $statement = $bdd->prepare($query);
            $statement->execute([
                ":mail" => $mail,
                ":pseudo" => $pseudo,
                ":password" => $pw
            ]);
        }else{
            $error = 3;
        }
    }else{
        $error = 2;
    }
}else{
    $error = 1;
}
$_SESSION["state"] = "1";
//redirect();





