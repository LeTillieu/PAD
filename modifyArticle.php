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
<div class="container">
    <div class="addArticle allMenus">
        <form action="modifyArticle.php" method="POST">
            <h1 class="h2 mt-3 mb-3 font-weight-normal">Modifier un article</h1>
            <label for="inputTitle" class="sr-only">Titre</label>
            <input type="text" id="inputTitle" name="articleTitle" class="form-control mt-4 mb-2" placeholder="Titre" required autofocus>
            <div id="editor" class="text-left pell mt-3"></div>
            <input type="hidden" value="<?php echo $_GET['modifyArticle']; ?>" id="modifyArticle">
            <button class="btn btn-lg btn-primary btn-block mt-4 mb-4" type="submit" name="submitArticle">Modifier un article</button>
        </form>
    </div>
</div>



<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/editor.js" type="module"></script>

<script type="text/javascript">
    $(document).ready(function () {
        <?php
        if(isset($_GET["modifyArticle"])){
        $bdd = connectDb();
        $query = "SELECT * FROM articles WHERE id = :id";
        $statement = $bdd->prepare($query);
        $statement->execute([
            ":id" => htmlspecialchars($_GET["modifyArticle"])
        ]);
        $res = $statement->fetchAll()[0];
        $res[1] = str_replace("'","\'",$res[1]);
        $res[2] = str_replace("'","\'",$res[2]);
        $res[2] = str_replace("\n","<br>",$res[2]);
        ?>
        $("#inputTitle").attr("value", '<?php echo $res[1]; ?>');
        $(".pell-content").html('<?php echo $res[2]; ?>');
        <?php
        }
        ?>
    });
</script>
<script src="https://unpkg.com/pell"></script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
