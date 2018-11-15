<?php
/**
 *state:
 *  0: unconnected
 *  1: connected
 *error:
 *  0: no error
 *  1: field/s is/are empty
 *  2: mail is not good
 *  3: account already exist with this mail
 **/

session_start();

function redirect(){
    header("Location: ../index.php");
    exit;
}

function connectDb(){
    try {
        $opts = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        $bdd = new PDO("mysql:host=localhost;dbname=pad;charset=utf8","root", "", $opts);
        return $bdd;
    } catch (Exception $e) {
        exit('Impossible to connect to database.');
    }

}

function userExistRegister($testedMail){
    $bdd = connectDb();
    $query = "SELECT * FROM users WHERE mail = :mail";
    $statement = $bdd->prepare($query);
    $statement->execute([
        ":mail" => $testedMail,
    ]);

    if($statement->rowCount() === 0){
        //registration validated
        return 0;
    }
    //registration refused
    return 1;
}

function userExistConnect($testedMail, $testedPassword){
    $bdd = connectDb();
    $query = "SELECT * FROM users WHERE mail = :mail AND password = :pw";
    $statement = $bdd->prepare($query);
    $statement->execute([
        ":mail" => $testedMail,
        ":pw" => $testedPassword
    ]);

    if($statement->rowCount() === 1){
        //connection validated
        return 0;
    }
    //connection refused
    return 1;
}


if(isset($_COOKIE["mail"],$_COOKIE["pw"])){
    if(userExistConnect($_COOKIE["mail"],$_COOKIE["pw"]) === 0){
        $bdd = connectDb();
        $query = "SELECT * FROM users WHERE mail = :mail";
        $statement = $bdd->prepare($query);
        $statement->execute([
            ":mail" => $_COOKIE["mail"]
        ]);
        $_SESSION["sessionId"] = $statement->fetchAll()[0][0];
    }
}



if(isset($_POST["submitRegister"])){
    include("register.php");
}
if(isset($_POST["submitConnect"])){
    include("connect.php");
}




