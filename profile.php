<?php
include "php/controller.php";
include "includes/head.php";
?>

    <body class="text-center">
        <?php
        include 'includes/nav.php';
        if(!isset($_SESSION["sessionId"])){
            redirect();
        }
        ?>
        <div class="container">

        </div>

        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
