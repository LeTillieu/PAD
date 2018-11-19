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

    ?>

        <div class="container text-left mt-3">
            <div class="mx-6 mb-5">
                <div class="article px-5">
                    <h1 class="text-center mb-4"><?php echo $resArticle[1]; ?></h1>
                    <?php echo $resArticle[2]; ?>
                </div>

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
                        if($resAuthor[0] === $_SESSION["sessionId"]){

                        ?>
                        <div class="col-6">
                        </div>
                        <div class="col-6 com-left mt-4" style="border-left: 2px <?php echo $color; ?> solid">
                            <h4><img src="profilePicture/<?php echo $resAuthor[5]; ?>" alt="Photo de profil de <?php echo $resAuthor[2]; ?>" width="40px" height="40px" class="mr-3"><?php echo $resAuthor[2]; ?></h4>
                            <p><?php echo $cur[3]; ?></p>
                        </div>
                            
                        <?php
                        }else{
                        ?>

                        <div class="col-6 com-left mt-4" style="border-left: 2px <?php echo $color; ?> solid">
                            <h4><img src="profilePicture/<?php echo $resAuthor[5]; ?>" alt="Photo de profil de <?php echo $resAuthor[2]; ?>" width="40px" height="40px" class="mr-3"><?php echo $resAuthor[2]; ?></h4>
                            <p><?php echo $cur[3]; ?></p>
                        </div>
                        <div class="col-6">
                        </div>


                        <?php
                        }
                    }
                    ?>

            </div>
            <hr class="mx-6 px-5">
            <form action="article.php" class="mb-6 px-5 mx-6">
                <h3 class="text-center">Participer au débat</h3>
                <div id="editor" class="pell mt-3"></div>
                <input type="hidden" value="<?php echo $_GET['article']; ?>" id="article">

                <button class="btn btn-lg btn-primary btn-block my-4" type="submit" name="submitComment">Participer au débat</button>
            </form>
        </div>

        <script src="js/editorComments.js" type="module"></script>
        <script src="https://unpkg.com/pell"></script>
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>