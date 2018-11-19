<div class="container mt-3">
    <div class="container">

<?php
//initialization of variables
$bdd = connectDb();
$res = getArticles();
$balises = array('<p>', '</p>');

foreach ($res as $cur){
    //get author info
    $authorQuery = "SELECT * FROM users INNER JOIN articles ON users.id = articles.authorId";
    $authorStatement = $bdd->prepare($authorQuery);
    $authorStatement->execute();
    $authorRes = $authorStatement->fetchAll()[0];

    ?>
        <a href="#"><?php echo $authorRes[2].' - '.str_replace($balises, "",$cur[2].' - '.getCreationDate($cur[3]));?></a>
        <br/>
    <?php

}
?>
    </div>
</div>