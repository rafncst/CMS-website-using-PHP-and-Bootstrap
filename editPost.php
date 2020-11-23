<?php
require_once("include/db.php");
require_once("include/functions.php");
require_once("include/sessions.php");
$_SESSION["trackUrl"] = $_SERVER["PHP_SELF"];
confirmLogin();
//Fetching Data
$idFromUrl = $_GET["id"];
$sql = "SELECT * FROM post WHERE id=$idFromUrl";
$stmt = $connect->query($sql);
while ($dataRows = $stmt->fetch()) {
    $titleToBeUpdated = $dataRows["title"];
    $categoryToBeUpdated = $dataRows["category"];
    $imageToBeUpdated = $dataRows["image"];
    $postToBeUpdated = $dataRows["post"];
}


$searchQueryParameter = $_GET["id"];
if (isset($_POST["submit"])) {
    $connect;
    $title = $_POST["postTitle"];
    $category = $_POST["postCategory"];
    $image = $_FILES["postImage"]["name"];
    $target = "Uploads/" . basename($_FILES["postImage"]["name"]);
    $post = $_POST["postText"];
    if (!empty($image)) {
        $sql = "UPDATE post SET title='$title', category='$category', image='$image', post='$post' WHERE id='$searchQueryParameter'";
        unlink("uploads/$imageToBeUpdated");
        move_uploaded_file($_FILES["postImage"]["tmp_name"], $target);
    } else {
        $sql = "UPDATE post SET title='$title', category='$category', post='$post' WHERE id='$searchQueryParameter'";
    }
    $execute = $connect->query($sql);
    if ($execute) {
        $_SESSION["success"] = "Post edited successfully";
    } else {
        $_SESSION["error"] = "Something went wrong, try again";
        redirectTo("posts.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit post</title>
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
                    <h1><i class="fas fa-edit"></i> Edit post</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- Header end -->
    <!-- Main area -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10">
                <?php
                echo errorMessage();
                echo successMessage();
                ?>
                <form class="" action="editPost.php?id=<?php echo $searchQueryParameter ?>" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Edit post</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label class="" for="title"><span class="fieldInfo"> Post Title: </span></label>
                                <input class="form-control" type="text" name="postTitle" id="title" placeholder="Title here" value="<?php echo $titleToBeUpdated ?>">
                            </div>
                            <div class="form-group">
                                <span class="fieldInfo">Existing category: </span>
                                <?php echo $categoryToBeUpdated ?>
                                <br>
                                <label class="" for="category"><span class="fieldInfo"> Choose category: </span></label>
                                <select class="form-control" type="text" name="postCategory" id="category">
                                    <?php
                                    // Fetching all the categories
                                    $connect;
                                    $sql = "SELECT title FROM category";
                                    $stmt = $connect->query($sql);
                                    while ($dataRows = $stmt->fetch()) {
                                        $categoryName = $dataRows["title"];

                                    ?>
                                        <option>
                                            <?php
                                            echo $categoryName;
                                            ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <span class="fieldInfo">Existing image: </span>
                                <img src="uploads/<?php echo $imageToBeUpdated ?>" width="170px" height="70px">
                                <br>
                                <label class="" for="image"><span class="fieldInfo"> Upload image: </span></label>
                                <div class="custom-file">
                                    <input class="custom-file-input" type="file" name="postImage" id="image" value="<?php echo $imageToBeUpdated ?>">
                                    <label for="image" class="custom-file-label"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="" for="post"><span class="fieldInfo"> Post: </span></label>
                                <textarea class="form-control" type="text" name="postText" id="post" placeholder="Post Here" rows="8" cols="80"><?php echo $postToBeUpdated ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Edit post</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
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