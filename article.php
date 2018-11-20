<?php
include "php/controller.php";
include "includes/head.php";
?>

    <body class="text-center">
    <?php include 'includes/nav.php'; ?>
    <?php
    $bdd = connectDb();
    $queryArticle = "SELECT * FROM articles WHERE id = :id";
    $statementArticle = $bdd->prepare($queryArticle);
    $statementArticle->execute([
            ":id" => htmlspecialchars($_GET["article"])
    ]);
    $resArticle = $statementArticle->fetchAll()[0];

    $queryAuthor = "SELECT pseudo FROM users WHERE id = :id";
    $statementAuthor = $bdd->prepare($queryAuthor);
    $statementAuthor->execute([
        ":id" => $resArticle[4]
    ]);
    $resAuthor = $statementAuthor->fetchAll()[0];

    ?>

        <div class="container text-left mt-3">
            <div class="row">
                <div class="col-lg-2 col-0"></div>
                <div class="col-lg-8 col-12 article">
                    <h1 class="text-center mb-4"><?php echo $resArticle[1]; ?></h1>
                    <?php echo $resArticle[2]; ?>
                    <p class="mb-0 text-right">
                        De <cite class="author"><?= $resAuthor[0] ?></cite> - le <time class="mr-3" datetime=""><?= getCreationDate($resArticle[3]);?></time>
                        <button type="button" class="btn btn-outline-success pt-1 align-baseline"><img width="17.5px" height="17.5px" src="img/share.svg" alt="Partager"></button>
                        <button type="button" class="btn btn-outline-danger pt-1 align-baseline"><img width="17.5px" height="17.5px" src="img/warning.svg" alt="Report"></button>
                    </p>
                    <hr>
                    <div class="row mx-0">
                        <?php
                        $queryComment = "SELECT * FROM comments_article WHERE idArticle = :ia";
                        $statementComment = $bdd->prepare($queryComment);
                        $statementComment->execute([
                                ":ia" => htmlspecialchars($_GET["article"])
                        ]);
                        foreach ($statementComment as $cur){
                            $queryAuthor = "SELECT * FROM users WHERE id = :id";
                            $statementAuthor = $bdd->prepare($queryAuthor);
                            $statementAuthor->execute([
                                    ":id" => $cur[1]
                            ]);
                            $resAuthor = $statementAuthor->fetchAll()[0];
                            $color = $cur[4];
                            $color = explode("/",$color);
                            $color = "rgb(".$color[0].",".$color[1].",".$color[2].")";

                            if($resAuthor[0] === $resArticle[4]) {
                                $displayPseudo = "<img src='img/author.svg' width='20px' height='20px' alt='Auteur'/> ". $resAuthor[2];
                            } else {
                                $displayPseudo = $resAuthor[2];
                            }

                            if($resAuthor[0] === $_SESSION["sessionId"]){

                            ?>
                            <div class="col-md-6 col-sm-5 col-4">
                            </div>
                            <div class="col-md-6 col-sm-7 col-8 com-left mt-4" style="border-left: 2px <?php echo $color; ?> solid">
                                <h4><img src="profilePicture/<?= $resAuthor[5]; ?>" alt="Photo de profil de <?= $resAuthor[2]; ?>" width="40px" height="40px" class="mr-3"><?= $displayPseudo; ?></h4>
                                <?= $cur[3]; ?>
                            </div>

                            <?php
                            }else{
                            ?>

                            <div class="col-md-6 col-sm-7 col-8 com-left mt-4" style="border-left: 2px <?php echo $color; ?> solid">
                                <h4><img src="profilePicture/<?= $resAuthor[5]; ?>" alt="Photo de profil de <?= $resAuthor[2]; ?>" width="40px" height="40px" class="mr-3"><?= $displayPseudo ?></h4>
                                <p><?= $cur[3]; ?></p>
                            </div>
                            <div class="col-md-6 col-sm-5 col-4">
                            </div>


                            <?php
                            }
                        }
                        ?>
                    </div>
                    <form action="article.php" class="mb-6 mt-4">
                        <h3 class="text-center">Participer au débat</h3>
                        <div id="editor" class="pell mt-3"></div>
                        <input type="hidden" value="<?php echo $_GET['article']; ?>" id="article">

                        <button class="btn btn-lg btn-primary btn-block my-4" type="submit" name="submitComment">Participer au débat</button>
                    </form>
                </div>
                <div class="col-lg-2 col-0"></div>
            </div>
        </div>

        <script src="js/editorComments.js" type="module"></script>
        <script src="https://unpkg.com/pell"></script>
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>