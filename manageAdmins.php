<?php
require_once("include/db.php");
require_once("include/functions.php");
require_once("include/sessions.php");
$_SESSION["trackUrl"] = $_SERVER["PHP_SELF"];
confirmLogin();
if (isset($_POST["submit"])) {
    date_default_timezone_set("America/Vancouver");
    $currentTime = time();
    $dateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $name = $_POST["name"];
    $addedBy = $_SESSION["username"];
    if (empty($username) || empty($password) || empty($confirmPassword)) {
        $_SESSION["error"] = "All fields must be filled out";
        redirectTo("manageAdmins.php");
    } else if ($password != $confirmPassword) {
        $_SESSION["error"] = "Passwords should match";
        redirectTo("manageAdmins.php");
    } else if (checkUsername($username)) {
        $_SESSION["error"] = "Username already exists";
        redirectTo("manageAdmins.php");
    } else {
        $sql = "INSERT INTO admin (dateTime, username, password, name, addedBy)";
        $sql .= "VALUES(:datetimE,:usernamE, :passworD, :namE, :addedbY)";
        $stmt = $connect->prepare($sql);
        $stmt->bindValue(":datetimE", $dateTime);
        $stmt->bindValue(":usernamE", $username);
        $stmt->bindValue(":passworD", $password);
        $stmt->bindValue(":namE", $name);
        $stmt->bindValue(":addedbY", $addedBy);
        $execute = $stmt->execute();
        if ($execute) {
            $_SESSION["success"] = "Admin added successfully";
        } else {
            $_SESSION["error"] = "Something went wrong, try again";
            redirectTo("manageAdmins.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage admins</title>
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
                    <h1><i class="fas fa-user"></i> Manage admins</h1>
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
                <form class="" action="manageAdmins.php" method="post">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add new admin</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label class="" for="username"><span class="fieldInfo"> Username: </span></label>
                                <input class="form-control" type="text" name="username">
                            </div>
                            <div class="form-group">
                                <label class="" for="name"><span class="fieldInfo"> Name: </span></label>
                                <input class="form-control" type="text" name="name">
                                <small class="text-warning text-muted">Optional</small>
                            </div>
                            <div class="form-group">
                                <label class="" for="password"><span class="fieldInfo"> Password: </span></label>
                                <input class="form-control" type="password" name="password">
                            </div>
                            <div class="form-group">
                                <label class="" for="confirmPassword"><span class="fieldInfo"> Confirm Password: </span></label>
                                <input class="form-control" type="password" name="confirmPassword">
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Add new admin</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="table table-striped table-hover my-4">
                    <thead class="thead-dark">
                        <h2>Existing admins</h2>
                        <tr>
                            <th>Number</th>
                            <th>Date & Time</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Added by</th>
                            <th>Delete admin</th>
                        </tr>

                    </thead>
                    <?php
                    $connect;
                    $sql = "SELECT * FROM admin";
                    $execute = $connect->query($sql);
                    $srNo = 0;
                    while ($dataRows = $execute->fetch()) {
                        $id = $dataRows["id"];
                        $dateTime = $dataRows["dateTime"];
                        $username = $dataRows["username"];
                        $name = $dataRows["name"];
                        $addedBy = $dataRows["addedBy"];
                        $srNo++;
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($srNo) ?></td>
                                <td><?php echo htmlentities($dateTime) ?></td>
                                <td><?php echo htmlentities($username) ?></td>
                                <td><?php echo htmlentities($name) ?></td>
                                <td><?php echo htmlentities($addedBy) ?></td>
                                <td><a class="btn btn-danger" href="deleteAdmin.php?id=<?php echo $id ?>">Delete admin</a></td>
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