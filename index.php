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
                        <h2 class="text-center"><?php echo $cur[1];?></h2>
                        <p><?php echo $cur[2];?></p>
                        <div><?php echo $authorRes[1]." - ".getCreationDate($cur[3]);?></div>
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
                        <h2 class="text-center"><?php echo $cur[1];?></h2>
                        <p><?php echo $cur[2];?></p>
                        <div><?php echo $authorRes[1]." - ".getCreationDate($cur[3]);?></div>
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
    </div>
    </div>
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>