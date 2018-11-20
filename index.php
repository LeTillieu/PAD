<?php
    include "php/controller.php";
    include "includes/head.php";
?>

    <body class="text-center">
    <?php include 'includes/nav.php'; ?>

        <div class="container mt-3">
            <div class="row">

                <?php
                $bdd = connectDb();

                $queryNbArticle = "SELECT * FROM articles";
                $statementNbArticle = $bdd->prepare($queryNbArticle);
                $statementNbArticle->execute();
                $nbPage = ceil($statementNbArticle->rowCount()/5);

                if(isset($_GET["curPage"]) && ($_GET["curPage"] <= 0 || $_GET["curPage"] > $nbPage)){
                    redirect();
                }

                if(!isset($_GET["curPage"])){
                    $res = getArticles(5,0);
                }else{
                    $res = getArticles(5,$_GET["curPage"]*5-5);
                }
                $nbElement = count($res)-1;
                $i = 0;
                foreach ($res as $cur){
                    $authorQuery = "SELECT * FROM users INNER JOIN articles ON users.id = articles.authorId";
                    $authorStatement = $bdd->prepare($authorQuery);
                    $authorStatement->execute();
                    $authorRes = $authorStatement->fetchAll()[0];
                    if($i % 2 === 0){
                        ?>
                        <div class="col-9 pt-2 mt-3">
                            <h2 class="text-center mb-3"><a href="article.php?article=<?php echo $cur[0]?>" class="text-dark"><?= $cur[1];?></a></h2>
                            <?= $cur[2];?>
                            <p class="mb-0 text-right">
                                De <cite class="author"><?= $authorRes[2]; ?></cite> - le <time class="mr-3" datetime=""><?= getCreationDate($cur[3]);?></time>
                                <button type="button" class="btn btn-outline-primary pt-1 align-baseline"><img width="17.5px" height="17.5px" src="img/comment.svg" alt="Commentaires"></button>
                                <button type="button" class="btn btn-outline-success pt-1 align-baseline"><img width="17.5px" height="17.5px" src="img/share.svg" alt="Partager"></button>
                                <button type="button" class="btn btn-outline-danger pt-1 align-baseline"><img width="17.5px" height="17.5px" src="img/warning.svg" alt="Report"></button>
                            </p>
                        </div>
                        <div class="col-3"></div>

                        <?php
                        if($i !== $nbElement){
                        ?>
                            <div class="col-9">
                                <hr>
                            </div>
                            <div class="col-3"></div>
                        <?php
                        }
                    }else{

                        ?>
                        <div class="col-3"></div>
                        <div class="col-9 pt-2 mt-3">
                            <h2 class="text-center mb-3"><a href="article.php?article=<?php echo $cur[0]?>" class="text-dark"><?= $cur[1];?></a></h2>
                            <?= $cur[2];?>
                            <p class="mb-0 text-right">
                                De <cite class="author"><?= $authorRes[2]; ?></cite> - le <time datetime="" class="mr-3"><?= getCreationDate($cur[3]);?></time>
                                <button type="button" class="btn btn-outline-primary pt-1 align-baseline"><img width="17.5px" height="17.5px" src="img/comment.svg" alt="Commentaires"></button>
                                <button type="button" class="btn btn-outline-success pt-1 align-baseline"><img width="17.5px" height="17.5px" src="img/share.svg" alt="Partager"></button>
                                <button type="button" class="btn btn-outline-danger pt-1 align-baseline"><img width="17.5px" height="17.5px" src="img/warning.svg" alt="Report"></button>
                            </p>
                        </div>
                        <?php
                        if($i !== $nbElement){
                            ?>
                            <div class="col-3"></div>
                            <div class="col-9">
                                <hr>
                            </div>
                            <?php
                        }
                    }
                    $i++;
                }
                ?>
            </div>

            <?php
            include "includes/pagination.php";
            ?>
        </div>

        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>