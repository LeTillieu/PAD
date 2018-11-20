<?php
include "php/controller.php";
include "includes/head.php";
?>

<body class="text-center">
<?php include 'includes/nav.php';

if(!isset($_SESSION['sessionId'])){
    redirect();
}
?>
<div class="container mt-3">
    <div class="row">
        <?php
        $bdd = connectDb();
        $queryNbArticle = "SELECT * FROM articles";
        $statementNbArticle = $bdd->prepare($queryNbArticle);
        $statementNbArticle->execute();
        $resArticle = $statementNbArticle->fetchAll();
        $nbPage = ceil($statementNbArticle->rowCount()/5);
        if(!isset($_GET["nb"])){
            redirect();
        }else if($_GET["nb"] == 0){
            ?>
            <div>Impossible de trouver un article</div>
            <?php
        }else{
            $articleId = [];
            $curElement = 0;
            for($i = 0; $i < $_GET["nb"]; $i++){
                array_push($articleId,$_GET["article".$i]);
            }
            $nbElement = count($articleId) -1;
            foreach ($articleId as $curId){
                foreach ($resArticle as $curArt){
                    if($curId == $curArt[0]){
                        $authorQuery = "SELECT * FROM users INNER JOIN articles ON users.id = articles.authorId";
                        $authorStatement = $bdd->prepare($authorQuery);
                        $authorStatement->execute();
                        $authorRes = $authorStatement->fetchAll()[0];
                        if($curElement % 2 === 0){
                            ?>
                            <div class="col-9 pt-2 mt-3">
                                <h2 class="text-center mb-3"><a href="article.php?article=<?php echo $curArt[0]?>" class="text-dark"><?= $curArt[1];?></a></h2>
                                <?= $curArt[2];?>
                                <p class="mb-0 text-right">
                                    De <cite class="author"><?= $authorRes[2]; ?></cite> - le <time datetime=""><?= getCreationDate($curArt[3]);?></time>
                                    <button type="button" class="btn btn-outline-primary pt-1 align-baseline"><img width="17.5px" height="17.5px" src="img/comment.svg" alt="Commentaires"></button>
                                    <button type="button" class="btn btn-outline-success pt-1 align-baseline"><img width="17.5px" height="17.5px" src="img/share.svg" alt="Partager"></button>
                                    <button type="button" class="btn btn-outline-danger pt-1 align-baseline"><img width="17.5px" height="17.5px" src="img/warning.svg" alt="Report"></button>
                                </p>
                                <?php
                                if($curElement !== $nbElement){
                                    ?>
                                    <hr>
                                    <?php
                                }?>
                            </div>
                            <div class="col-3"></div>
                            <?php
                        }else{
                            ?>
                            <div class="col-3"></div>
                            <div class="col-9 pt-2 mt-3">
                                <h2 class="text-center mb-3"><a href="article.php?article=<?php echo $curArt[0]?>" class="text-dark"><?= $curArt[1];?></a></h2>
                                <?= $curArt[2];?>
                                <p class="mb-0 text-right">
                                    De <cite class="author"><?= $authorRes[2]; ?></cite> - le <time datetime="" class="mr-3"><?= getCreationDate($curArt[3]);?></time>
                                    <button type="button" class="btn btn-outline-primary pt-1 align-baseline"><img width="17.5px" height="17.5px" src="img/comment.svg" alt="Commentaires"></button>
                                    <button type="button" class="btn btn-outline-success pt-1 align-baseline"><img width="17.5px" height="17.5px" src="img/share.svg" alt="Partager"></button>
                                    <button type="button" class="btn btn-outline-danger pt-1 align-baseline"><img width="17.5px" height="17.5px" src="img/warning.svg" alt="Report"></button>
                                </p>
                                <?php
                                if($curElement !== $nbElement){
                                    ?>
                                    <hr>
                                    <?php
                                }?>
                            </div>
                            <?php
                        }
                        $curElement++;
                    }
                }
            }
        }
        ?>
    </div>

    <?php
    include "includes/pagination.php";
    ?>
</div>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/pell"></script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
