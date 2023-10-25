<?php
session_start();
session_unset();
session_destroy();

// Set the redirect URL
$redirectURL = "http://localhost:3000/public/login/index.php";

// Perform a temporary redirect (HTTP status code 302 Found)
header("HTTP/1.1 302 Found");
header("Location: $redirectURL");
