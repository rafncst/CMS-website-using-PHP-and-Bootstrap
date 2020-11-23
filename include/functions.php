<?php
require_once("db.php");
require_once("include/sessions.php");
function redirectTo($newLocation)
{
    header("Location: " . $newLocation);
    exit;
}
function checkUsername($username)
{
    global $connect;
    $sql = "SELECT username FROM admin WHERE username=:usernamE";
    $stmt = $connect->prepare($sql);
    $stmt->bindValue(":usernamE", $username);
    $execute = $stmt->execute();
    $result = $stmt->rowCount();
    if ($result == 1) {
        return true;
    } else {
        return false;
    }
}
function loginAttempt($username, $password)
{
    global $connect;
    $sql = "SELECT * FROM admin WHERE username=:usernamE AND password=:passworD LIMIT 1";
    $stmt = $connect->prepare($sql);
    $stmt->bindValue(":usernamE", $username);
    $stmt->bindValue(":passworD", $password);
    $stmt->execute();
    $result = $stmt->rowCount();
    if ($result == 1) {
        return $foundAccount = $stmt->fetch();
    } else {
        return null;
    }
}
function countComment($id) {
    global $connect;
    $sql = "SELECT * from comment WHERE postId=$id AND status='ON'";
    $stmt = $connect->query($sql);
    $result = $stmt->rowCount();
    return $result;
}
function countCommentOFF($id) {
    global $connect;
    $sql = "SELECT * from comment WHERE postId=$id AND status='OFF'";
    $stmt = $connect->query($sql);
    $result = $stmt->rowCount();
    return $result;
}
function confirmLogin() {
    if (isset($_SESSION["userId"])) {
        return true;
    } else {
        $_SESSION["error"] = "Login required";
        redirectTo("login.php");
    }
}