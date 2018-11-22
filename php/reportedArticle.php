<div class="container mt-3">
    <div class="container">
        <div class="row">
            <?php
            //initialization of variables
            $bdd = connectDb();
            $variables = parse_ini_file("infos.ini",true);
            $variables = $variables["variable"];

            $query = "SELECT * FROM articles WHERE reported >= ".$variables["nbReport"];
            $statement = $bdd->prepare($query);
            $statement->execute();
            $res = $statement->fetchAll();
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
                    <button type="button" class="btn btn-outline-danger delete" name="<?php echo $cur[0];?>">Supprimer</button>
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
    var remove = $(".delete");
    modify.click(function (e) {
        window.location.replace("modifyArticle.php?modifyArticle="+e.currentTarget.name);
    });
    remove.click(function (e) {
        var id = e.currentTarget.name;
        $.ajax({
            type: "POST",
            url: "administration.php",
            data: {deleteArticle: id},
            success: function () {
                //redirection
                window.location.replace("administration.php");
            },
            error: function(e){
                console.log("Impossible d'ajouter cet article");
                console.log(e);
            },
            dataType: "html"
        });
    })
</script>
