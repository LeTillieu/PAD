<div class="container mt-3">
    <div class="container">
        <div class="row">
<?php
//initialization of variables
$bdd = connectDb();
$res = getArticles();
$balises = array('<p>', '</p>','<br/>','<br>');

foreach ($res as $cur){
    //get author info
    $authorQuery = "SELECT * FROM users INNER JOIN articles ON users.id = articles.authorId";
    $authorStatement = $bdd->prepare($authorQuery);
    $authorStatement->execute();
    $authorRes = $authorStatement->fetchAll()[0];

    ?>
             <div class="col-6"><p><?php echo $authorRes[2].' - '.str_replace($balises, "",$cur[1].' - '.getCreationDate($cur[3])); ?></p></div>
             <div class="col-6"><button type="button" class="btn btn-link">Modifier</button><button type="button" class="btn btn-outline-danger">Supprimer</button></div>
    <?php

}
?>
        </div>
    </div>
</div>