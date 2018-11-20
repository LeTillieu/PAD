<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php
        if(isset($_GET["curPage"]) && $_GET["curPage"] >= 2){
            $link = explode("?",$_SERVER['REQUEST_URI']);
            $link = $link[0];
            $link = "http://".$_SERVER["HTTP_HOST"].$link."?curPage=".($_GET["curPage"]-1);
            ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $link; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <?php
        }
        if(!isset($_GET["curPage"]) || $_GET["curPage"] == 1){
            $_GET["curPage"] = 1;
            ?>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <?php
            if($_GET["curPage"]+1<=$nbPage) {
                $link = explode("?",$_SERVER['REQUEST_URI']);
                $link = $link[0];
                $link = "http://".$_SERVER["HTTP_HOST"].$link."?curPage=2";
                ?>
                <li class="page-item"><a class="page-link" href="<?php echo $link; ?>">2</a></li>
                <?php
            }
            if($_GET["curPage"]+2<=$nbPage) {
                $link = explode("?",$_SERVER['REQUEST_URI']);
                $link = $link[0];
                $link = "http://".$_SERVER["HTTP_HOST"].$link."?curPage=3";
                ?>
                <li class="page-item"><a class="page-link" href="<?php echo $link; ?>">3</a></li>
                <?php
            }

        }else if($_GET["curPage"] == $nbPage){
            if($_GET["curPage"]-2 > 0) {
                $link = explode("?",$_SERVER['REQUEST_URI']);
                $link = $link[0];
                $link = "http://".$_SERVER["HTTP_HOST"].$link."?curPage=".($_GET["curPage"]-2);
                ?>
                <li class="page-item"><a class="page-link" href="<?php echo $link; ?>"><?php echo $_GET["curPage"]-2; ?></a></li>
                <?php
            }
            if($_GET["curPage"]-1 > 0) {
                $link = explode("?",$_SERVER['REQUEST_URI']);
                $link = $link[0];
                $link = "http://".$_SERVER["HTTP_HOST"].$link."?curPage=".($_GET["curPage"]-1);
                ?>
                <li class="page-item"><a class="page-link" href="<?php echo $link; ?>"><?php echo $_GET["curPage"]-1; ?></a></li>
                <?php
            }
            ?>
            <li class="page-item active"><a class="page-link" href="#"><?php echo $_GET["curPage"]; ?></a></li>
            <?php
        }else{
            if($_GET["curPage"]-1 > 0) {
                $link = explode("?",$_SERVER['REQUEST_URI']);
                $link = $link[0];
                $link = "http://".$_SERVER["HTTP_HOST"].$link."?curPage=".($_GET["curPage"]-1);
                ?>
                <li class="page-item"><a class="page-link" href="<?php echo $link; ?>"><?php echo $_GET["curPage"]-1; ?></a></li>
                <?php
            }
            ?>
            <li class="page-item active"><a class="page-link" href="#"><?php echo $_GET["curPage"]; ?></a></li>
            <?php
            if($_GET["curPage"]+1 <= $nbPage){
                $link = explode("?",$_SERVER['REQUEST_URI']);
                $link = $link[0];
                $link = "http://".$_SERVER["HTTP_HOST"].$link."?curPage=".($_GET["curPage"]+1);
                ?>
                <li class="page-item"><a class="page-link" href="<?php echo $link; ?>"><?php echo $_GET["curPage"]+1; ?></a></li>
                <?php
            }

        }


        if(!isset($_GET["curPage"]) || $_GET["curPage"] <= $nbPage) {
            $link = explode("?",$_SERVER['REQUEST_URI']);
            $link = $link[0];
            $link = "http://".$_SERVER["HTTP_HOST"].$link."?curPage=".($_GET["curPage"]+1);
            ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $link; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>