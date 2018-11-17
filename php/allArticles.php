<div class="container mt-3">
    <div class="row">

<?php



function getCreationDate($ts){
    return date("d M Y", $ts);
}

$bdd = connectDb();
$query = "SELECT * FROM articles";
$statement = $bdd->prepare($query);
$statement->execute();

$res = $statement->fetchAll();

$i = 0;

foreach ($res as $cur){
    $authorQuery = "SELECT * FROM users INNER JOIN articles ON users.id = articles.authorId";
    $authorStatement = $bdd->prepare($authorQuery);
    $authorStatement->execute();
    $authorRes = $authorStatement->fetchAll();

    if($i % 2 === 0){
         ?>
            <div class="col-9 pt-2 mt-3">
                <h2 class="text-center">'<?php echo $cur[1];?>'</h2>
                <p>'.<?php echo $cur[2];?>.'</p>
            </div>
            <div class="col-3"></div>
        
        <?php;
    }else{

        ?>
            <div class="col-3"></div>
            <div class="col-9 pt-2 mt-3">
                <h2 class="text-center">'<?php echo $cur[1];?>'</h2>
                <p>'.<?php echo $cur[2];?>.'</p>
            </div>
        
        <?php
    }
    echo "<hr>";
    $i++;
}
?>
    </div>
</div>