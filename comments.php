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
    <title>Comments</title>
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
                    <h1><i class="fas fa-comments"></i> Manage comments</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- Header end -->
    <!-- Main area -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-lg-12">
                <?php
                echo errorMessage();
                echo successMessage();
                ?>
                <table class="table table-striped table-hover my-4">
                    <thead class="thead-dark">
                        <h2>Unapproved comments</h2>
                        <tr>
                            <th>Number</th>
                            <th>Name</th>
                            <th>Date & Time</th>
                            <th>Post</th>
                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>

                    </thead>
                    <?php
                    $connect;
                    $sql = "SELECT * FROM comment WHERE status='OFF'";
                    $execute = $connect->query($sql);
                    $srNo = 0;
                    while ($dataRows = $execute->fetch()) {
                        $id = $dataRows["id"];
                        $dateTime = $dataRows["dateTime"];
                        $name = $dataRows["name"];
                        $comment = $dataRows["comment"];
                        $postId = $dataRows["postId"];
                        $srNo++;
                        if (strlen($name) > 10) {
                            $name = substr($name, 0, 10) . "...";
                        }
                        if (strlen($comment) > 15) {
                            $comment = substr($comment, 0, 15) . "...";
                        }
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($srNo) ?></td>
                                <td><?php echo htmlentities($name) ?></td>
                                <td><?php echo htmlentities($dateTime) ?></td>
                                <td><?php echo htmlentities($postId) ?></td>
                                <td><?php echo htmlentities($comment) ?></td>
                                <td><a class="btn btn-success" href="approveComment.php?id=<?php echo $id ?>">Approve comment</a></td>
                                <td><a class="btn btn-danger" href="deleteComment.php?id=<?php echo $id ?>">Delete comment</a></td>
                                <td><a href="fullComment.php?id=<?php echo $id ?>" class="btn btn-primary">Live Preview</a></td>
                            </tr>
                        <?php
                    }
                        ?>
                        </tbody>
                </table>
                <table class="table table-striped table-hover my-4">
                    <thead class="thead-dark">
                        <h2>Approved comments</h2>
                        <tr>
                            <th>Number</th>
                            <th>Name</th>
                            <th>Date & Time</th>
                            <th>Post</th>
                            <th>Comment</th>
                            <th>Disapprove</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>

                    </thead>
                    <?php
                    $connect;
                    $sql = "SELECT * FROM comment WHERE status='ON'";
                    $execute = $connect->query($sql);
                    $srNo = 0;
                    while ($dataRows = $execute->fetch()) {
                        $id = $dataRows["id"];
                        $dateTime = $dataRows["dateTime"];
                        $name = $dataRows["name"];
                        $comment = $dataRows["comment"];
                        $postId = $dataRows["postId"];
                        $srNo++;
                        if (strlen($name) > 10) {
                            $name = substr($name, 0, 10) . "...";
                        }
                        if (strlen($comment) > 15) {
                            $comment = substr($comment, 0, 15) . "...";
                        }
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($srNo) ?></td>
                                <td><?php echo htmlentities($name) ?></td>
                                <td><?php echo htmlentities($dateTime) ?></td>
                                <td><?php echo htmlentities($postId) ?></td>
                                <td><?php echo htmlentities($comment) ?></td>
                                <td><a class="btn btn-warning" href="disapproveComment.php?id=<?php echo $id ?>">Disapprove comment</a></td>
                                <td><a class="btn btn-danger" href="deleteComment.php?id=<?php echo $id ?>">Delete comment</a></td>
                                <td><a href="fullComment.php?id=<?php echo $id ?>" class="btn btn-primary">Live Preview</a></td>
                            </tr>
                        <?php
                    }
                        ?>
                        </tbody>
                </table>
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