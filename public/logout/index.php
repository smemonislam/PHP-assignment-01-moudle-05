<?php

session_start();
$_SESSION["loggedin"] = false;
session_destroy();

header("location:http://localhost:3000/public/login/index.php");
