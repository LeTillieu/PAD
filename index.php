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
                $res = getArticles(5);
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
                            <h2 class="text-center"><a href="article.php" class="text-dark"><?= $cur[1];?></a></h2>
                            <?= $cur[2];?>
                            <p><cite class="author"><?= $authorRes[2]; ?></cite> - <time datetime=""><?= getCreationDate($cur[3]);?></time></p>
                        </div>
                        <div class="col-3"></div>

                        <?php
                        if($i !== $nbElement){
                            echo "<hr>";
                        }
                    }else{

                        ?>
                        <div class="col-3"></div>
                        <div class="col-9 pt-2 mt-3">
                            <h2 class="text-center"><a href="article.php" class="text-dark"><?= $cur[1];?></a></h2>
                            <?= $cur[2];?>
                            <p><cite class="author"><?= $authorRes[2]; ?></cite> - <time datetime=""><?= getCreationDate($cur[3]);?></time></p>
                        </div>


                        <?php
                        if($i !== $nbElement){
                            echo "<hr>";
                        }
                    }
                    $i++;

                }
                ?>
            </div>
        </div>

        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>