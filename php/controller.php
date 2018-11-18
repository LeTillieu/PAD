<?php
session_start();

//redirect
function redirect($link = NULL){
    if(!isset($link)){
        header("Location: ../index.php");
    }else{
        header("Location: ").$link;
    }
    exit;
}

//connect to DataBase
function connectDb(){
    try {
        $opts = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        $bdd = new PDO("mysql:host=localhost;dbname=pad;charset=utf8","root", "isencir", $opts);
        return $bdd;
    } catch (Exception $e) {
        exit('Impossible to connect to database.');
    }

}

//check if user exist in db with this name/mail
function userExistRegister($testedMail, $testedPseudo){
    $bdd = connectDb();
    $query = "SELECT * FROM users WHERE mail = :mail OR pseudo = :pseudo";
    $statement = $bdd->prepare($query);
    $statement->execute([
        ":mail" => $testedMail,
        ":pseudo" => $testedPseudo
    ]);

    if($statement->rowCount() === 0){
        //registration validated
        return 0;
    }
    //registration refused
    return 1;
}

//check if user exist in db with mail/pseudo and password
function userExistConnect($testedMailOrPseudo, $testedPassword){
    $bdd = connectDb();
    $query = "SELECT * FROM users WHERE (mail = :mailOrPseudo OR pseudo = :mailOrPseudo) AND password = :pw";
    $statement = $bdd->prepare($query);
    $statement->execute([
        ":mailOrPseudo" => $testedMailOrPseudo,
        ":pw" => $testedPassword
    ]);

    if($statement->rowCount() === 1){
        //connection validated
        return 0;
    }
    //connection refused
    return 1;
}

//get $lim articles in database
function getArticles($lim = NULL){
    $bdd = connectDb();
    if(!isset($lim)){
        $query = "SELECT * FROM articles ORDER BY id DESC";
        $statement = $bdd->prepare($query);
        $statement->execute();
    }else{
        $query = "SELECT * FROM articles ORDER BY id DESC LIMIT ".$lim;
        $statement = $bdd->prepare($query);
        $statement->execute();
    }

    $res = $statement->fetchAll();
    return $res;
}

//get articles creation's date format "1 Jan 2018"
function getCreationDate($ts){
    return date("d M Y", $ts);
}

//check ban's words
function banWord($article){
    $article = htmlspecialchars(strtolower($article));
    error_log($article,4);
    $file = fopen("../banWords","r");
    while($cur = fgets($file)){
        $cur2 = strtolower($cur);
        //check if string are equals
        if(strpos($article,$cur2) !== false){
            return false;
        }
        //check if string are separated by ' '
        $cur2 = chunk_split("test",1," ");
        if(strpos($article,$cur2) !== false){
            return false;
        }

        //check if string are separated by '.'
        $cur2 = strtolower($cur);
        $cur2 = rtrim(chunk_split($cur2,1,"."),".");
        if(strpos($article,$cur2) !== false){
            return false;
        }

        //check if string are separated by '-'
        $cur2 = strtolower($cur);
        $cur2 = rtrim(chunk_split($cur2,1,"-"),"-");
        if(strpos($article,$cur2) !== false){
            return false;
        }

        //check if string are separated by '_'
        $cur2 = strtolower($cur);
        $cur2 = rtrim(chunk_split($cur2,1,"_"),"_");
        if(strpos($article,$cur2) !== false){
            return false;
        }
    }
    return true;
}

//Registering
if(isset($_POST["submitRegister"])){
    include("register.php");
}

//connection by cookies
if(isset($_COOKIE["mailOrPseudo"],$_COOKIE["pw"])){
    if(userExistConnect($_COOKIE["mailOrPseudo"],$_COOKIE["pw"]) === 0){
        $bdd = connectDb();
        $query = "SELECT * FROM users WHERE mail = :mailOrPseudo OR pseudo = :mailOrPseudo";
        $statement = $bdd->prepare($query);
        $statement->execute([
            ":mailOrPseudo" => $_COOKIE["mailOrPseudo"]
        ]);
        $_SESSION["sessionId"] = $statement->fetchAll()[0][0];
    }
}

//connection by form
if(isset($_POST["submitConnect"])){
    include("connect.php");
}

//add article
if(isset($_POST["title"], $_POST["content"])){
    $forbidden = ["<p>Votre texte ici...</p>",""]; //add ban words
    $title = filter_input(INPUT_POST,"title",FILTER_SANITIZE_SPECIAL_CHARS);
    $content = $_POST["content"];
    $date  = new DateTime();
    //first checks
    if(strcmp($title,"") !==0 && strcmp($content,"") !==0 && strcmp($content,"<p>Votre texte ici...</p>")!==0){
        //ban words check
        if(banWord($content) && banWord($title) && $title != ""){
            $bdd = connectDb();
            $query = "INSERT INTO articles (title, content, publishedDate, authorId) VALUES(:title, :content, :ts, :id)";
            $statement = $bdd->prepare($query);
            $statement->execute([
                ":title" => $title,
                ":content" => $content,
                ":ts" => $date->getTimestamp(),
                ":id" => $_SESSION["sessionId"]
            ]);
        }
    }



}



