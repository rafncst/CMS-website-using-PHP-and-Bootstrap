<?php
require_once("include/db.php");
require_once("include/functions.php");
require_once("include/sessions.php");
if (isset($_SESSION["userId"])) {
    redirectTo("dashboard.php");
}
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if (empty($username) || empty($password)) {
        $_SESSION["error"] = "Enter username and password";
        redirectTo("login.php");
    } else {
        $foundAccount = loginAttempt($username, $password);
        if ($foundAccount) {
            $_SESSION["userId"] = $foundAccount["id"];
            $_SESSION["username"] = $foundAccount["username"];
            $_SESSION["aName"] = $foundAccount["name"];
            $_SESSION["success"] = "Welcome " . $_SESSION["aName"];
            if (isset($_SESSION["trackUrl"])) {
                redirectTo($_SESSION["trackUrl"]);
            } else {
                redirectTo("dashboard.php");
            }
        } else {
            $_SESSION["error"] = "Incorrect username or password";
            redirectTo("login.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://kit.fontawesome.com/aa21f35e2c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <!-- Nav bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="blog.php?page=1" class="navbar-brand">RAFAELCOSTA.COM</a>
        </div>
    </nav>
    <!-- Navbar end -->
    <!-- Header -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col">

                </div>
            </div>
        </div>
    </header>
    <!-- Header end -->
    <!-- Main area -->
    <section class="container py-2 mb-4">
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="row">
            <div class="offset-sm-3 col-sm-6" id="min">
                <div class="card bg-secondary text-light">
                    <div class="card-header">
                        <h4>Welcome back!</h4>
                        <?php
                        echo errorMessage();
                        echo successMessage();
                        ?>
                    </div>
                    <div class="card-body bg-dark">
                        <form class="" action="login.php" method="post">
                            <div class="form-group">
                                <label for="username"><span class="fieldInfo">Username: </span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input class="form-control" type="text" name="username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username"><span class="fieldInfo">Password: </span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input class="form-control" type="password" name="password">
                                </div>
                            </div>
                            <input class="btn btn-info btn-block" type="submit" name="submit" value="Login"></input>
                        </form>
                    </div>
                </div>
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