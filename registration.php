<?php
include "php/controller.php";
include "includes/head.php";
?>

    <body class="text-center">
        <?php include 'includes/nav.php'; 
        if(isset($_SESSION['sessionId'])){
            redirect();
        }
        ?>
        <div class="container">
            <form class="form-signin" method="POST" action="registration.php" enctype="multipart/form-data">
                <h1 class="h2 mb-3 font-weight-normal">S'inscrire</h1>
                <label for="inputEmail" class="sr-only">Adresse e-mail</label>
                <input type="email" id="inputEmail" name="mail" class="form-control mt-4 mb-2" placeholder="Adresse e-mail" required autofocus>
                <label for="inputUsername" class="sr-only">Prénom ou Pseudo</label>
                <input type="text" id="inputUsername" name="pseudo" class="form-control mb-2" placeholder="Prénom ou pseudo" required>
                <label for="inputPassword" class="sr-only">Mot de passe</label>
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Mot de passe" required>
                <input type="file" name="picture"/>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="submitRegister">S'inscrire</button>
                <p class="mt-4 mb-3 text-muted">&copy; FiftyTwo Company - 2018</p>
            </form>
        </div>
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>