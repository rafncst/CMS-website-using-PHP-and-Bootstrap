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
                <?php
                echo errorMessage();
                echo successMessage();
                ?>
                <h1>The complete CMS blog</h1>
                <h1 class="lead">Complete responsive CMS website using PHP by Rafael Costa</h1>
                <!-- Comments -->
                <!-- Fetching comments -->
                <br>
                <span class="fieldInfo">Comment</span>
                <hr>
                <?php
                $id = $_GET["id"];
                $connect;
                $sql = "SELECT dateTime, name, comment FROM comment WHERE id=$id";
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
                <!-- Comments end -->
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