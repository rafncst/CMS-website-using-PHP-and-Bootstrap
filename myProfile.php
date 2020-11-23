<?php
require_once("include/db.php");
require_once("include/functions.php");
require_once("include/sessions.php");
$_SESSION["trackUrl"] = $_SERVER["PHP_SELF"];
confirmLogin();
//Fetching admin data
$userId = $_SESSION["userId"];
$connect;
$sql = "SELECT * FROM admin WHERE id=$userId";
$stmt = $connect->query($sql);
while ($dataRows = $stmt->fetch()) {
    $existingName = $dataRows["name"];
    $imageToBeUpdated = $dataRows["image"];
    $id = $dataRows["id"];
}
//Fecthing admin data end
if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $headline = $_POST["headline"];
    $bio = $_POST["bio"];
    $image = $_FILES["image"]["name"];
    $target = "Uploads/" . basename($_FILES["image"]["name"]);
    if (!empty($image)) {
        $sql = "UPDATE admin SET name='$name', headline='$headline', bio='$bio', image='$image' WHERE id='$id'";
        if ($imageToBeUpdated != "avatar.png") {
            unlink("uploads/$imageToBeUpdated");
        }
        move_uploaded_file($_FILES["image"]["tmp_name"], $target);
    } else {
        $sql = "UPDATE admin SET name='$name', headline='$headline', bio='$bio', image='avatar.png' WHERE id='$id'";
        if ($imageToBeUpdated != "avatar.png") {
            unlink("uploads/$imageToBeUpdated");
        }
    }
    $execute = $connect->query($sql);
    if ($execute) {
        $_SESSION["success"] = "Admin edited successfully";
    } else {
        $_SESSION["error"] = "Something went wrong, try again";
        redirectTo("myProfile.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My profile</title>
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
                        <a href="myProfile.php" class="nav-link text-success"><i class="fas fa-user"></i> My profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="posts.php" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="categories.php" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="manageAdmins.php" class="nav-link">Manage Admins</a>
                    </li>
                    <li class="nav-item">
                        <a href="comments.php" class="nav-link">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="blog.php?page=1" class="nav-link">Live blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar end -->
    <!-- Header -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1><i class="fas fa-user"></i> My profile</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- Header end -->
    <!-- Main area -->
    <section class="container py-2 mb-4">
        <div class="row">
            <!-- Left aerea -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h3><?php echo $existingName ?></h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($imageToBeUpdated == "avatar.png") {
                            $fileDir = "images/";
                        } else {
                            $fileDir = "uploads/";
                        }
                        ?>
                        <img class="block img-fluid mb-2" src="<?php echo $fileDir ?><?php echo $imageToBeUpdated ?>">
                    </div>
                    <div class="m-2">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras et tempor velit, et efficitur enim. Nam semper, tellus eu ultrices porta, diam diam maximus metus, a feugiat turpis orci a turpis. Maecenas dictum rutrum neque, vitae consequat massa imperdiet finibus. Nullam porttitor condimentum velit, et feugiat magna congue vitae. Pellentesque pellentesque augue id congue auctor. Quisque condimentum, nisl quis accumsan porta, elit purus consectetur tellus, ac posuere libero magna eu nibh. Mauris egestas pulvinar ante id sodales.
                    </div>
                </div>
            </div>
            <!-- Left area end -->
            <!-- Right area -->
            <div class="col-md-9">
                <?php
                echo errorMessage();
                echo successMessage();
                ?>
                <form class="" action="myProfile.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-dark text-light">
                        <div class="card-header bg-secondary text-light">
                            <h4>Edit profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input class="form-control" type="text" name="name" placeholder="Your name here">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="headline" placeholder="Your headline here">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" type="text" name="bio" placeholder="Your bio here" rows="8" cols="80"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="" for="image"><span class="fieldInfo"> Upload image: </span></label>
                                <div class="custom-file">
                                    <input class="custom-file-input" type="file" name="image">
                                    <label for="image" class="custom-file-label"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Right area end -->
    <!-- Main area end -->
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