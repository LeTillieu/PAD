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
             <div class="col-6">
                 <button type="button" class="btn btn-link modify" name="<?php echo $cur[0];?>">Modifier</button>
                <button type="button" class="btn btn-outline-danger" class="delete">Supprimer</button>
             </div>
    <?php

}
?>
        </div>
    </div>
</div>
<script src="js/jquery-3.3.1.min.js"></script>
<script>
    var modify = $(".modify");
    modify.click(function (e) {
        window.location.replace("modifyArticle.php?modifyArticle="+e.currentTarget.name);
    });
</script>
