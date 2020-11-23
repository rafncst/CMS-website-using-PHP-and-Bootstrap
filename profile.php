<?php
require_once("include/db.php");
require_once("include/functions.php");
require_once("include/sessions.php");
$username = $_GET["username"];
//Fetching admin info
$connect;
$sql = "SELECT * FROM admin WHERE name='$username'";
$stmt = $connect->query($sql);
while ($dataRows = $stmt->fetch()) {
    $id = $dataRows["id"];
    $name = $dataRows["name"];
    $headline = $dataRows["headline"];
    $image = $dataRows["image"];
    $bio = $dataRows["bio"];
}
//Fetching admin info end
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS</title>
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
    <?php
    if (empty($id)) {
        $_SESSION["error"] = "This admin does not exist anymore";
    ?>
        <header class="bg-dark text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <?php
                        echo errorMessage();
                        echo successMessage();
                        ?>
                    </div>
                </div>
            </div>
        </header>
    <?php
    } else {
    ?>
        <header class="bg-dark text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1><i class="fas fa-user"></i> <?php echo $name ?></h1>
                        <h3><?php echo $headline ?></h3>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header end -->
        <!-- Main area -->
        <section class="container py-2 mb-4">
            <div class="row">
                <div class="col-md-3">
                    <?php
                    if ($image == "avatar.png") {
                        $fileDir = "images/";
                    } else {
                        $fileDir = "uploads/";
                    }
                    ?>
                    <img src="<?php echo $fileDir ?><?php echo $image ?>" class="d-block img-fluid mb-3 rounded-circle">
                </div>
                <div class="col-md-9" style="min-height: 400px;">
                    <div class="card">
                        <div class="card-body">
                            <p class="lead">
                                <?php echo $bio ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Main area end -->
    <?php
    }
    ?>
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