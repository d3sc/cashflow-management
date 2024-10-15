<?php

session_start();
if (!$_SESSION['is_login']) {
    header("location: ../auth/login.php");
}

session_destroy();
session_unset();

header("location: login.php");
