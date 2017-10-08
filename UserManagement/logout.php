<?php

session_start();
require_once "lib/lib.php";
redirectToLogIn();
require_once "html/logout.html";
logOut();

?>
