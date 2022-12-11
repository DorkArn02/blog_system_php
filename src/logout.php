<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["username"])) {
    echo "Successfully logged out, redirecting...";
    session_destroy();
    header("refresh: 2; URL=index.php");
} else {
    header("location: index.php");
}
