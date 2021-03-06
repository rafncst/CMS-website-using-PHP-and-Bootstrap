<?php
require_once("include/db.php");
require_once("include/functions.php");
require_once("include/sessions.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Page</title>
    <script src="https://kit.fontawesome.com/aa21f35e2c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <!-- Nav bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="blog.php?page=1" class="navbar-brand">RAFAELCOSTA.COM</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapseCms">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapseCms">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="blog.php?page=1" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">About us</a>
                    </li>
                    <li class="nav-item">
                        <a href="blog.php?page=1" class="nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contact us</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Features</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <div class="form-group">
                        <form class="form-inline" action="blog.php">
                            <input class="form-control mr-2" type="text" name="search" placeholder="Search">
                            <button class="btn btn-primary" name="searchButton">Go</button>
                        </form>
                    </div>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar end -->
    <!-- Header -->
    <div class="container">
        <div class="row mt-4">
            <!-- Main area -->
            <div class="col-sm-8">
                <h1>The complete CMS blog</h1>
                <h1 class="lead">Complete responsive CMS website using PHP by Rafael Costa</h1>
                <?php
                echo errorMessage();
                echo successMessage();
                ?>
                <?php
                $connect;
                // If search is set
                if (isset($_GET["searchButton"])) {
                    $searchQuery = $_GET["search"];
                    $sql = "SELECT * FROM post WHERE dateTime LIKE :searcH OR title LIKE :searcH OR category LIKE :searcH OR author LIKE :searcH OR post LIKE :searcH ORDER BY id DESC";
                    $stmt = $connect->prepare($sql);
                    $stmt->bindValue(":searcH", "%" . $searchQuery . "%");
                    $stmt->execute();
                } else if (isset($_GET["page"])) {
                    //Pagination
                    $page = $_GET["page"];
                    if ($page == 0 || $page < 0) {
                        $showPostsFrom = 0;
                    } else {
                        $showPostsFrom = ($page * 4) - 4;
                    }
                    $sql = "SELECT * FROM post ORDER BY id desc LIMIT $showPostsFrom,4";
                    $stmt = $connect->query($sql);
                } else if (isset($_GET["category"])) {
                    //Categories search
                    $cat = $_GET["category"];
                    $sql = "SELECT * FROM post WHERE category='$cat' ORDER BY id desc";
                    $stmt = $connect->query($sql);
                } else {
                    // Default sql query
                    $sql = "SELECT * FROM post ORDER BY id desc LIMIT 0,3";
                    $stmt = $connect->query($sql);
                }
                while ($dataRows = $stmt->fetch()) {
                    $id = $dataRows["id"];
                    $dateTime = $dataRows["dateTime"];
                    $postTitle = $dataRows["title"];
                    $category = $dataRows["category"];
                    $admin = $dataRows["author"];
                    $image = $dataRows["image"];
                    $postText = $dataRows["post"];
                ?>
                    <div class="card">
                        <img src="uploads/<?php echo htmlentities($image); ?>" style="max-height: 450px" class="img-fluid card-top">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo htmlentities($postTitle) ?></h4>
                            <small class="text-muted">Category: <?php echo $category ?> & Written by <a href="profile.php?username=<?php echo $admin ?>"><?php echo htmlentities($admin) ?></a> on <?php echo htmlentities($dateTime) ?></small>
                            <span class="badge badge-dark text-light" style="float:right">Comments: <?php echo countComment($id) ?></span>
                            <hr>
                            <?php
                            if (strlen($postText) > 150) {
                                $postText = substr($postText, 0, 150) . "...";
                            }
                            ?>
                            <p><?php echo htmlentities($postText) ?></p>
                            <a href="fullPost.php?id=<?php echo $id ?>" style="float:right">
                                <span class="btn btn-info mr-4">
                                    Read more >>
                                </span>
                            </a>
                        </div>
                    </div>
                <?php
                }
                ?>
                <nav>
                    <ul class="pagination pagination-lg m-2">
                        <?php
                        $connect;
                        $sql = "SELECT COUNT(*) FROM post";
                        $stmt = $connect->query($sql);
                        $rowPagination = $stmt->fetch();
                        $totalPosts = array_shift($rowPagination);
                        $postPagination = $totalPosts / 4;
                        $postPagination = ceil($postPagination);
                        if (isset($_GET["page"])) {
                            $page = $_GET["page"];
                            if (isset($_GET["page"])) {
                        ?>
                                <li class="page-item">
                                    <?php
                                    if ($page <= 1) {
                                    ?>
                                        <a href="blog.php?page=<?php echo $page ?>" class="page-link">&laquo</a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="blog.php?page=<?php echo $page - 1 ?>" class="page-link">&laquo</a>
                                    <?php
                                    }
                                    ?>
                                </li>
                            <?php
                            }
                            ?>
                            <?php
                            for ($i = 1; $i <= $postPagination; $i++) {
                                if ($i == $_GET["page"]) {
                            ?>
                                    <li class="page-item active">
                                    <?php
                                } else {
                                    ?>
                                    <li class="page-item">
                                    <?php
                                }
                                    ?>
                                    <a href="blog.php?page=<?php echo $i ?>" class="page-link"><?php echo $i ?></a>
                                    </li>
                            <?php
                            }
                        }
                            ?>
                            <?php
                            if (isset($_GET["page"])) {
                            ?>
                                <li class="page-item">
                                    <?php
                                    if ($page >= $i - 1) {
                                    ?>
                                        <a href="blog.php?page=<?php echo $page ?>" class="page-link">&raquo</a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="blog.php?page=<?php echo $page + 1 ?>" class="page-link">&raquo</a>
                                    <?php
                                    }
                                    ?>
                                </li>
                            <?php
                            }
                            ?>
                    </ul>

                </nav>
            </div>
            <!-- Main area end-->
            <!-- Side area -->
            <div class="col-sm-4">
                <div class="card mt-4">
                    <div class="card-body">
                        <img class="d-block img-fluid mb-3" src="images/ad.png" alt="Ad">
                    </div>
                    <div class="text-center m-2">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed volutpat scelerisque ante, at commodo nisi aliquam et. Duis varius facilisis diam, quis lobortis eros venenatis sit amet. Aliquam quis arcu urna. Nam pellentesque consectetur iaculis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce laoreet magna non nisl egestas, nec cursus magna dapibus. Nulla dolor erat, pulvinar sit amet blandit et, molestie ut libero.
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h2 class="lead">Sign Up</h2>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-success btn-block text-center text-white" type="button" name="button">Join the Forum</button>
                        <button class="btn btn-danger btn-block text-center text-white mb-3" type="button" name="button">Login</button>
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" name="" placeholder="Enter your Email">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm text-center text-white" type="button" name="button">Subscribe now</button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <h2 class="lead">Categories</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        $connect;
                        $sql = "SELECT title FROM category";
                        $stmt = $connect->query($sql);
                        while ($dataRows = $stmt->fetch()) {
                            $title = $dataRows["title"];
                        ?>
                            <a href="blog.php?category=<?php echo $title ?>"><span class="heading"><?php echo htmlentities($title) ?></span></a>
                            <br>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h2>Recent posts</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        $connect;
                        $sql = "SELECT * FROM post ORDER BY id desc LIMIT 0,5";
                        $stmt = $connect->query($sql);
                        while ($dataRows = $stmt->fetch()) {
                            $id = $dataRows["id"];
                            $title = $dataRows["title"];
                            $dateTime = $dataRows["dateTime"];
                            $image = $dataRows["image"];
                        ?>
                            <div class="media">
                                <img class="d-block img-fluid align-self-start" src="uploads/<?php echo $image ?>" width="90" height="94">
                                <div class="media-body ml-2">
                                    <a class="" target="_blank" href="fullPost.php?id=<?php echo $id ?>"><h6 class="lead"><?php echo htmlentities($title) ?></h6></a>
                                    <p class="small"><?php echo htmlentities($dateTime) ?></p>
                                </div>
                            </div>
                            <hr>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- Side area end -->
        </div>
    </div>
    <!-- Header end -->
    <!-- Footer -->
    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center">Theme by | Rafael Costa | <span id="year"></span> &copy; ----All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer end -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <script>
        $('#year').text(new Date().getFullYear());
    </script>
</body>

</html>