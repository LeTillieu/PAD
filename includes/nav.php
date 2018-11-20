<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark text-center">
    <a class="navbar-brand" href="index.php">Place Aux Débats</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <form class="form-inline mr-auto my-2 my-md-0" action="../php/controller.php" method="POST">
            <input class="form-control mr-2" name="searchedText" type="text" placeholder="Rechercher">
            <button class="btn btn-outline-success mr-auto ml-auto" name="search" type="submit" id="btn-search">Search</button>
        </form>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white" href="index.php">Accueil</a>
            </li>
            <?php
            if(!isset($_SESSION["sessionId"])) {
            ?>
                <li class="nav-item">
                    <a class="nav-link text-white" href="registration.php">S'inscrire</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="connection.php">Se connecter</a>
                </li>
            <?php
            }else {
            ?>
                <li class="nav-item">
                    <a class="nav-link text-white" href="administration.php">Administration</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="php/disconnect.php">Se déconnecter</a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>