<?php
include "php/controller.php";
include "includes/head.php";
?>

    <body class="text-center">
        <?php include 'includes/nav.php'; ?>
        <div class="container">
            <nav class="nav navbar-dark bg-dark d-flex justify-content-around mt-4">
                <a class="p-2 text-white" href="#">Ajouter un article</a>
                <a class="p-2 text-white" href="#">Liste des articles</a>
                <a class="p-2 text-white" href="#">Liste des articles report</a>
            </nav>
            <form action="">
                <h1 class="h2 mt-3 mb-3 font-weight-normal">Ajouter un article</h1>
                <label for="inputTitle" class="sr-only">Titre</label>
                <input type="text" id="inputTitle" name="articleTitle" class="form-control mt-4 mb-2" placeholder="Titre" required autofocus>
                <div id="editor" class="text-left pell mt-3"></div>
                <input type="hidden" class="contentText" name="contentTexte">
                <button class="btn btn-lg btn-primary btn-block mt-4" type="submit" name="submitArticle">Ajouter un article</button>
            </form>
        </div>
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/editor.js" type="module"></script>
        <script src="https://unpkg.com/pell"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
