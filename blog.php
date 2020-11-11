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
            <a href="index.html" class="navbar-brand">RAFAELCOSTA.COM</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapseCms">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapseCms">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="blog.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">About us</a>
                    </li>
                    <li class="nav-item">
                        <a href="blog.php" class="nav-link">Blog</a>
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
                $connect;
                $sql = "SELECT * FROM post ORDER BY id desc";
                $stmt = $connect->query($sql);
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
                            <small class="text-muted">Written by <?php echo htmlentities($admin) ?> on <?php echo htmlentities($dateTime) ?></small>
                            <span class="badge badge-dark text-light" style="float:right">Comments: 20</span>
                            <hr>
                            <?php
                            if (strlen($postText) > 150) {
                                $postText = substr($postText, 0, 150) . "...";
                            }
                            ?>
                            <p><?php htmlentities($postText) ?></p>
                            <a href="fullPost.php" style="float:right">
                                <span class="btn btn-info mr-4">
                                    Read more >>
                                </span>
                            </a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <!-- Main area end-->
            <!-- Side area -->
            <div class="col-sm-4">

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