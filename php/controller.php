<?php
session_start();

//redirect
function redirect($link = NULL){
    if(!isset($link)){
        header("Location: index.php");
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
function getArticles($lim = NULL, $offset = NULL){
    $bdd = connectDb();
    if(!isset($lim, $offset)){
        $query = "SELECT * FROM articles ORDER BY id DESC";
        $statement = $bdd->prepare($query);
        $statement->execute();
    }else{
        error_log("set",4);
        $query = "SELECT * FROM articles ORDER BY id DESC LIMIT ".$lim." OFFSET ".$offset;
        $statement = $bdd->prepare($query);
        $statement->execute();
    }

    $res = $statement->fetchAll();
    return $res;
}

//get articles creation's date format "1 Jan 2018"
function getCreationDate($ts){
    setlocale(LC_TIME, "fr_FR.utf8");
    return strftime("%d %b %Y", $ts);
}

//check ban's words
function banWord($article){
    $article = htmlspecialchars(strtolower($article));
    $file = fopen("banWords","r");
    while($cur = fgets($file)){
        $cur2 = strtolower($cur);
        //check if string are equals
        if(strpos($article,$cur2) !== false){
            return false;
        }
        //check if string are separated by ' '
        $cur2 = chunk_split($cur2,1," ");
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
if(isset($_POST["title"], $_POST["content"]) && $_POST["articleId"] === "NULL"){
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

//modify article
if(isset($_POST["title"], $_POST["content"]) && $_POST["articleId"] !== "NULL"){
    error_log("Article modified",4);
    $title = filter_input(INPUT_POST,"title",FILTER_SANITIZE_SPECIAL_CHARS);
    $content = $_POST["content"];
    $date  = new DateTime();
    //first checks
    if(strcmp($title,"") !==0 && strcmp($content,"") !==0 && strcmp($content,"<p>Votre texte ici...</p>")!==0){
        //ban words check
        if(banWord($content) && banWord($title) && $title != ""){
            $bdd = connectDb();
            $query = "UPDATE articles SET title = :title, content = :content, lastModification = :lm WHERE id = :articleId";
            $statement = $bdd->prepare($query);
            $statement->execute([
                ":title" => $title,
                ":content" => $content,
                ":lm" => $date->getTimestamp(),
                ":articleId" => htmlspecialchars($_POST["articleId"])
            ]);
        }
    }
}

//add comment
if(isset($_POST["comment"], $_POST["articleId"])){
    $color = ["155/0/0","0/155/0","0/155/0","155/0/155","155/155/0","0/155/155","0/0/0","100/100/100"];
    $color2 = ["255/0/0","0/255/0","0/255/0","255/0/255","255/255/0","0/255/255","0/0/0","200/200/200"];
    $bdd = connectDb();
    $date  = new DateTime();
    $commentColor = NULL;

    //add color
    $queryColor = "SELECT * FROM comments_article WHERE idUser = :iu AND idArticle = :ia";
    $statementColor = $bdd->prepare($queryColor);
    $statementColor->execute([
        ":iu" => $_SESSION["sessionId"],
        ":ia" => $_POST["articleId"]
    ]);

    if($statementColor->rowCount() === 0){
        $queryMembers = "SELECT * FROM comments_article WHERE idArticle = :ia";
        $statementMembers = $bdd->prepare($queryMembers);
        $statementMembers->execute([
            ":ia" => $_POST["articleId"]
        ]);

        if($statementMembers->rowCount() < 8){
            $commentColor = $color[$statementMembers->rowCount()];
        }else if($statementMembers->rowCount() < 16){
            $commentColor = $color2[$statementMembers->rowCount()-8];
        }else{
            $commentColor = rand(0,255)."/".rand(0,255)."/".rand(0,255);
        }
    }else{
        $commentColor = $statementColor->fetchAll()[0][4];
    }

    //add comment
    $queryComment = "INSERT INTO comments_article (idUser, idArticle, comment, color, commentDate) VALUE(:iu,:ia,:comment,:color, :cd)";
    $statementComment = $bdd->prepare($queryComment);
    $statementComment->execute([
        ":iu" => $_SESSION["sessionId"],
        ":ia" => $_POST["articleId"],
        ":comment" => $_POST["comment"],
        ":color" => $commentColor,
        ":cd" => $date->getTimestamp()
    ]);

}

