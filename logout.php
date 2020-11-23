<?php
require_once("include/functions.php");
require_once("include/sessions.php");
$_SESSION["userId"] = null;
$_SESSION["username"] = null;
$_SESSION["aName"] = null;
session_destroy();
redirectTo("login.php");