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
}

function connectDb(){
    try {
        $opts = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        $bdd = new PDO("mysql:host=localhost;dbname=PAD;charset=utf8","root", "isencir", $opts);
        return $bdd;
    } catch (Exception $e) {
        exit('Impossible to connect to database.');
    }

}

function userExist($testedMail, $testedPassword){
    $bdd = connectDb();
    $query = "SELECT * FROM users WHERE mail = :value";
    $statement = $bdd->prepare($query);
    $statement->execute([
        ":value" => $testedMail,
    ]);
    if ($testedPassword === null) {
        if($statement->rowCount() === 0){
            return 0;
        }
    }else{
        if($statement->rowCount() > 0){
            $result = $statement->fetchAll()[0];
            $result = $result[3];
            if(crypt($testedPassword,CRYPT_BLOWFISH) === $result){
                return 0;
            }
        }
    }

    return 1;
}

if(isset($_SESSION["state"])){
    echo $_SESSION["state"];
}else{
    echo "test";
}

if(isset($_SESSION["mail"], $_SESSION["pw"])){
    setcookie("mail",$_SESSION["mail"],time()+365*24*3600,null,null,false,true);
    setcookie("pw",$_SESSION["pw"],time()+365*24*3600,null,null,false,true);
}

if(isset($_COOKIE["mail"],$_COOKIE["pw"])){
    if(userExist($_COOKIE["mail"],$_COOKIE["pw"]) === 0){
        echo "yolo";
        $_SESSION["state"] = 1;
    }
}



if(isset($_POST["submitRegister"])){
    include("register.php");
}
if(isset($_POST["submitConnect"])){
    include("connect.php");
}




