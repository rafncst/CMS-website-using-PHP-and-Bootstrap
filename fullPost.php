<?php
require_once("include/db.php");
require_once("include/functions.php");
require_once("include/sessions.php");
$idFromUrl = $_GET["id"];
$connect;
if (isset($_POST["submit"])) {
    date_default_timezone_set("America/Vancouver");
    $currentTime = time();
    $dateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);
    $name = $_POST["userName"];
    $email = $_POST["email"];
    $comment = $_POST["comment"];
    if (empty($name) || empty($email) || empty($comment)) {
        $_SESSION["error"] = "All fields must be filled out";
    } else if (strlen($comment) > 500) {
        $_SESSION["error"] = "Comment can only have up to 500 characters";
    } else {
        $sql = "INSERT INTO comment (dateTime, name, email, comment, approvedBy, status, postId)
    VALUES (:datetimE, :namE, :emaiL, :commenT, 'Pending', 'OFF', $idFromUrl)";
        $stmt = $connect->prepare($sql);
        $stmt->bindValue(":datetimE", $dateTime);
        $stmt->bindValue(":namE", $name);
        $stmt->bindValue(":emaiL", $email);
        $stmt->bindValue(":commenT", $comment);
        $execute = $stmt->execute();
        if ($execute) {
            $_SESSION["success"] = "Comment added successfully";
        } else {
            $_SESSION["error"] = "Something went wrong, try again";
        }
    }
}
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
                <?php
                echo errorMessage();
                echo successMessage();
                ?>
                <h1>The complete CMS blog</h1>
                <h1 class="lead">Complete responsive CMS website using PHP by Rafael Costa</h1>
                <?php
                $connect;
                // If search is set
                if (isset($_GET["searchButton"])) {
                    $searchQuery = $_GET["search"];
                    $sql = "SELECT * FROM post WHERE dateTime LIKE :searcH OR title LIKE :searcH OR category LIKE :searcH OR author LIKE :searcH OR post LIKE :searcH ORDER BY id DESC";
                    $stmt = $connect->prepare($sql);
                    $stmt->bindValue(":searcH", "%" . $searchQuery . "%");
                    $stmt->execute();
                } else {
                    // Default sql query
                    $idFromUrl = $_GET["id"];
                    if (!isset($idFromUrl)) {
                        $_SESSION["error"] = "Bad request!";
                        redirectTo("blog.php");
                    }
                    $sql = "SELECT * FROM post WHERE id=$idFromUrl";
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
                            <small class="text-muted">Category: <?php echo $category ?> & Written by <?php echo htmlentities($admin) ?> on <?php echo htmlentities($dateTime) ?></small>
                            <span class="badge badge-dark text-light" style="float:right">Comments: <?php echo countComment($id) ?></span>
                            <hr>
                            <p><?php echo htmlentities($postText) ?></p>
                        </div>
                    </div>
                <?php
                }
                ?>
                <!-- Comments -->
                <!-- Fetching comments -->
                <br>
                <span class="fieldInfo">Comments</span>
                <hr>
                <?php
                $connect;
                $sql = "SELECT dateTime, name, comment FROM comment WHERE postId=$idFromUrl AND status='ON'";
                $stmt = $connect->query($sql);
                while ($dataRows = $stmt->fetch()) {
                    $dateTime = $dataRows["dateTime"];
                    $name = $dataRows["name"];
                    $comment = $dataRows["comment"];
                ?>
                    <div class="mt-2">
                        <div class="media commentBlock">
                            <div class="media-body ml-2">
                                <h6 class="lead"><?php echo $name ?></h6>
                                <p class="small"><?php echo $dateTime ?></p>
                                <p><?php echo $comment ?></p>
                            </div>
                        </div>
                        <hr>
                    </div>
                <?php
                }
                ?>
                <!--Fetching comments end -->
                <div class="">
                    <form class="" action="fullPost.php?id=<?php echo $idFromUrl ?>" method="POST">
                        <div class="card mb-2 mt-2">
                            <div class="card-header">
                                <h5 class="fieldInfo">Share your thoughts</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input class="form-control" type="text" name="userName" placeholder="Name" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input class="form-control" type="email" name="email" placeholder="E-mail" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="comment" rows="8" cols="80" placeholder="Comment"></textarea>
                                </div>
                                <div class="">
                                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                </div>
                            </div>
                    </form>
                </div>
                <!-- Comments end -->
            </div>
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