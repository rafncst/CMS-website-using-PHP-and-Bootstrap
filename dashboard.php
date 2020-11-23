<?php
require_once("include/db.php");
require_once("include/functions.php");
require_once("include/sessions.php");
$_SESSION["trackUrl"] = $_SERVER["PHP_SELF"];
confirmLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                <div class="col-md-12 mb-2">
                    <h1><i class="fas fa-cog"></i> Dashboard</h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="addNewPost.php" class="btn btn-primary btn-block"><i class="fas fa-edit"></i> Add new post</a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="categories.php" class="btn btn-info btn-block"><i class="fas fa-folder-plus"></i> Add new category</a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="manageAdmins.php" class="btn btn-warning btn-block"><i class="fas fa-user-plus"></i> Add new admin</a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="comments.php" class="btn btn-success btn-block"><i class="fas fa-check"></i> Aprove comments</a>
                </div>
            </div>
        </div>
    </header>
    <!-- Header end -->
    <!-- Main area -->
    <section class="container py-2 mb-4">
        <div class="row">
            <?php
            echo errorMessage();
            echo successMessage();
            ?>
            <!-- Side area -->
            <div class="col-lg-2 d-none d-md-block">
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Posts</h1>
                        <h4 class="display-5">
                            <i class="fab fa-readme"></i>
                            <?php 
                            $connect;
                            $sql = "SELECT * from post";
                            $stmt = $connect->query($sql);
                            $result = $stmt->rowCount();
                            echo $result;
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Categories</h1>
                        <h4 class="display-5">
                            <i class="fas fa-folder"></i>
                            <?php 
                            $connect;
                            $sql = "SELECT * from category";
                            $stmt = $connect->query($sql);
                            $result = $stmt->rowCount();
                            echo $result;
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Admins</h1>
                        <h4 class="display-5">
                            <i class="fas fa-users"></i>
                            <?php 
                            $connect;
                            $sql = "SELECT * from admin";
                            $stmt = $connect->query($sql);
                            $result = $stmt->rowCount();
                            echo $result;
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Comments</h1>
                        <h4 class="display-5">
                            <i class="fas fa-comment"></i>
                            <?php 
                            $connect;
                            $sql = "SELECT * from comment";
                            $stmt = $connect->query($sql);
                            $result = $stmt->rowCount();
                            echo $result;
                            ?>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- Side area end -->
            <!-- Main area -->
            <div class="col-lg-10">
                <h1 class="">Top posts</h1>
                <table class="table table-striped table-hover my-4">
                    <thead class="thead-dark">
                        <tr>
                            <th>Number</th>
                            <th>Date & Time</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Comments</th>
                            <th>Details</th>
                        </tr>

                    </thead>
                    <?php
                    $connect;
                    $sql = "SELECT * FROM post ORDER BY id desc LIMIT 0,5";
                    $execute = $connect->query($sql);
                    $srNo = 0;
                    while ($dataRows = $execute->fetch()) {
                        $id = $dataRows["id"];
                        $dateTime = $dataRows["dateTime"];
                        $title = $dataRows["title"];
                        $author = $dataRows["author"];
                        $srNo++;
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($srNo) ?></td>
                                <td><?php echo htmlentities($dateTime) ?></td>
                                <td><?php echo htmlentities($title) ?></td>
                                <td><?php echo htmlentities($author) ?></td>
                                <td>
                                    <span class="badge badge-success"><?php echo countComment($id) ?></span>
                                    <span class="badge badge-danger"><?php echo countCommentOFF($id) ?></span>
                                </td>
                                <td><a class="btn btn-primary" href="fullPost.php?id=<?php echo $id ?>">Live Preview</a></td>
                            </tr>
                        <?php
                    }
                        ?>
                        </tbody>
                </table>
            </div>
            <!-- Main area end -->
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