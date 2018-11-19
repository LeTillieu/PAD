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
            if(is_uploaded_file($_FILES["picture"]['tmp_name'])){
                if($_FILES['picture']['type'] == 'image/jpg' || $_FILES['picture']['type'] == 'image/jpeg' || $_FILES['picture']['type'] == 'image/png'){
                    $type = explode('/', $_FILES['picture']['type']);
                    $lienImage = 'profilePicture/'.$_SESSION["sessionId"].'.'.$type[1];
                    move_uploaded_file($_FILES['picture']['tmp_name'], $lienImage);
                    $queryImage = "UPDATE users SET image = :link WHERE id = :id";
                    $statementImage = $bdd->prepare($queryImage);
                    $statementImage->execute([
                        ":link" => $_SESSION["sessionId"].".".$type[1],
                        ":id" => $_SESSION["sessionId"]
                    ]);
                }
            }

            redirect();

        }else{
            $error = 3;
        }
    }else{
        $error = 2;
    }
}else{
    $error = 1;
}

