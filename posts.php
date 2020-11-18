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
    <title>Blog Posts</title>
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
                    <h1><i class="fas fa-blog"></i> Blog posts</h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="addNewPost.php" class="btn btn-primary btn-block"><i class="fas fa-edit"></i> Add new post</a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="categories.php" class="btn btn-info btn-block"><i class="fas fa-folder-plus"></i> Add new category</a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="admins.php" class="btn btn-warning btn-block"><i class="fas fa-user-plus"></i> Add new admin</a>
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
            <div class="col-lg-12">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date&Time</th>
                            <th>Author</th>
                            <th>Banner</th>
                            <th>Comments</th>
                            <th>Action</th>
                            <th>Live Preview</th>
                        </tr>
                    </thead>
                    <?php
                    $connect;
                    $sql = "SELECT * FROM post";
                    $stmt = $connect->query($sql);
                    $sr = 0;
                    while ($dataRows = $stmt->fetch()) {
                        $id = $dataRows["id"];
                        $dateTime = $dataRows["dateTime"];
                        $postTitle = $dataRows["title"];
                        $category = $dataRows["category"];
                        $admin = $dataRows["author"];
                        $image = $dataRows["image"];
                        $postText = $dataRows["post"];
                        $sr++;


                    ?>
                        <tbody class="tbody-dark">
                            <tr>
                                <td><?php echo $sr ?></td>
                                <td>
                                    <?php
                                    if (strlen($postTitle) > 20) {
                                        $postTitle = substr($postTitle, 0, 7) . "...";
                                    }
                                    ?>
                                    <?php echo $postTitle ?>
                                </td>
                                <td>
                                <?php
                                    if (strlen($category) > 6) {
                                        $category = substr($category, 0, 6) . "...";
                                    }
                                    ?>
                                    <?php echo $category ?>
                                </td>
                                <td>
                                <?php
                                    if (strlen($dateTime) > 11) {
                                        $dateTime = substr($dateTime, 0, 11) . "...";
                                    }
                                    ?>
                                    <?php echo $dateTime ?>
                                </td>
                                <td>
                                <?php
                                    if (strlen($admin) > 6) {
                                        $admin = substr($admin, 0, 6) . "...";
                                    }
                                    ?>
                                    <?php echo $admin ?>
                                </td>
                                <td><img src="uploads/<?php echo $image ?>" width="170px" height="50px"></td>
                                <td>Comments</td>
                                <td>
                                    <a href="editPost.php?id=<?php echo $id ?>"><span class="btn btn-warning mb-2">Edit</span></a>
                                    <a href="#"><span class="btn btn-danger mb-2">Delete</span></a>
                                </td>
                                <td><a href="#"><span class="btn btn-primary">Live preview</span></a></td>
                            </tr>
                        </tbody>
                    <?php
                    }
                    ?>
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