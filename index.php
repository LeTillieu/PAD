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

                $variables = parse_ini_file("infos.ini",true);
                $info = $variables["variable"];

                $queryNbArticle = "SELECT * FROM articles";
                $statementNbArticle = $bdd->prepare($queryNbArticle);
                $statementNbArticle->execute();
                $nbPage = ceil($statementNbArticle->rowCount()/$info["articleByPage"]);
                if(isset($_GET["curPage"]) && ($_GET["curPage"] <= 0 || $_GET["curPage"] > $nbPage)){
                    redirect();
                }

                if(!isset($_GET["curPage"])){
                    $res = getArticles($info["articleByPage"],0);
                }else{
                    $res = getArticles($info["articleByPage"],$_GET["curPage"]*$info["articleByPage"]-$info["articleByPage"]);
                }
                $nbElement = count($res)-1;
                $i = 0;
                foreach ($res as $cur){
                    $cur[2] = substr($cur[2], 0, -4);
                    $cur[2] = substr($cur[2], 3, strlen($cur[2]));

                    $authorQuery = "SELECT * FROM users INNER JOIN articles ON users.id = articles.authorId";
                    $authorStatement = $bdd->prepare($authorQuery);
                    $authorStatement->execute();
                    $authorRes = $authorStatement->fetchAll()[0];
                    if($i % 2 === 0){
                        ?>
                        <div class="col-9 pt-2 mt-3">
                            <h2 class="text-center mb-3">
                                <a href="article.php?article=<?php echo $cur[0]?>" class="text-dark"><?= $cur[1];?></a>
                            </h2>
                            <p style="word-wrap: break-word"><?= $cur[2];?></p>
                            <p class="mb-0 text-right">
                                De <cite class="author"><?= $authorRes[2]; ?></cite>
                                - le <time datetime=""><?= getCreationDate($cur[3]);?></time>

                                <button type="button" class="btn btn-outline-primary pt-1 align-baseline button" name="comment" id="<?php echo $cur[0];?>">
                                    <img width="17.5px" height="17.5px" src="img/comment.svg" alt="Commentaires">
                                </button>
                                <button type="button" class="btn btn-outline-success pt-1 align-baseline button" name="share" id="<?php echo $cur[0];?>">
                                    <img width="17.5px" height="17.5px" src="img/share.svg" alt="Partager">
                                </button>
                                <button type="button" class="btn btn-outline-danger pt-1 align-baseline button" name="report" id="<?php echo $cur[0];?>">
                                    <img width="17.5px" height="17.5px" src="img/warning.svg" alt="Report">
                                </button>
                            </p>
                            <?php
                            if($i !== $nbElement){
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
                            <h2 class="text-center mb-3"><a href="article.php?article=<?php echo $cur[0]?>" class="text-dark"><?= $cur[1];?></a></h2>
                            <p style="word-wrap: break-word"><?= $cur[2];?></p>
                            <p class="mb-0 text-right">
                                De <cite class="author"><?= $authorRes[2]; ?></cite> - le <time datetime="" class="mr-3"><?= getCreationDate($cur[3]);?></time>
                                <button type="button" class="btn btn-outline-primary pt-1 align-baseline button"><img width="17.5px" height="17.5px" src="img/comment.svg" alt="Commentaires"></button>
                                <button type="button" class="btn btn-outline-success pt-1 align-baseline button"><img width="17.5px" height="17.5px" src="img/share.svg" alt="Partager"></button>
                                <button type="button" class="btn btn-outline-danger pt-1 align-baseline button"><img width="17.5px" height="17.5px" src="img/warning.svg" alt="Report"></button>
                            </p>
                            <?php
                            if($i !== $nbElement){
                            ?>
                            <hr>
                            <?php
                            }?>
                        </div>
                        <?php
                    }
                    $i++;
                }
                ?>
            </div>

            <?php
            include "includes/pagination.php";
            ?>
    <script src="js/jquery-3.3.1.min.js"></script>
    <?php
    include "js/articleButtons.php";
    ?>
    <script src="js/bootstrap.bundle.min.js"></script>

    </body>
</html>