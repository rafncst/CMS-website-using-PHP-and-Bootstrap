<?php
require_once("include/db.php");
require_once("include/functions.php");
require_once("include/sessions.php");
$_SESSION["trackUrl"] = $_SERVER["PHP_SELF"];
confirmLogin();
if (isset($_GET["id"])) {
    $searchQueryParameter = $_GET["id"];
    $admin = $_SESSION["aName"];
    $connect;
    $sql = "DELETE FROM admin WHERE id=$searchQueryParameter";
    $execute = $connect->query($sql);
    if ($execute) {
        $_SESSION["success"] = "Admin deleted successfully";
        redirectTo("manageAdmins.php");
    } else {
        $_SESSION["error"] = "Something went wrong";
        redirectTo("manageAdmins.php");
    }
}