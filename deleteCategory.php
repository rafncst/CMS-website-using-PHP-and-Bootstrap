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
    $sql = "DELETE FROM category WHERE id=$searchQueryParameter";
    $execute = $connect->query($sql);
    if ($execute) {
        $_SESSION["success"] = "Category deleted successfully";
        redirectTo("categories.php");
    } else {
        $_SESSION["error"] = "Something went wrong";
        redirectTo("categories.php");
    }
}