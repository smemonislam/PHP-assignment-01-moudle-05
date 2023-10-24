<?php

session_start();
session_unset();
session_destroy();

header("location:http://localhost:3000/public/login/index.php");
