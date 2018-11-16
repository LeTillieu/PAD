<?php

function getCreationDate($ts){
    return date("d M Y", $ts);
}

$bdd = connectDb();
$query = "SELECT * FROM articles";
$statement = $bdd->prepare($query);
$statement->execute();

$res = $statement->fetchAll();


foreach ($res as $cur){
    $authorQuery = "SELECT * FROM users INNER JOIN articles ON users.id = articles.authorId";
    $authorStatement = $bdd->prepare($authorQuery);
    $authorStatement->execute();
    $authorRes = $authorStatement->fetchAll();

    echo "titre: ".$cur[1];
    echo "<br/>";
    echo "<br/>";
    echo "contenu: ".$cur[2];
    echo "créé le: ".getCreationDate($cur[3]);
    echo " par: ". $authorRes[0][1];
    echo "<br/>";
    echo "<br/>";
    echo "<br/>";
    echo "<br/>";
    echo "<br/>";
}