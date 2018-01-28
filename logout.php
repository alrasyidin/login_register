<?php  

require_once "core/init.php";

session_destroy();
unset($_SESSION["user_id"]);

header("Location: index.php");