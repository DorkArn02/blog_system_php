<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
}


if (isset($_GET["id"])) {
    require_once("./backend/connection.php");

    $query = "SELECT user_id FROM posts WHERE id=?";

    $prep = $conn->prepare($query);

    $prep->bind_param('i', $_GET["id"]);
    $prep->execute();

    $user_id = "";

    $prep->bind_result($user_id);
    $prep->store_result();

    if ($prep->num_rows == 1) {
        if ($prep->fetch()) {
            if (isset($_SESSION["user_id"])) {
                if ($_SESSION["user_id"] === $user_id) {
                    $deleteQuery = "DELETE FROM posts WHERE id=" . $_GET["id"] . "";

                    if ($conn->query($deleteQuery)) {
                        echo "Deleted successfully redirecting to home page...";
                        header("refresh: 2; URL=index.php");
                    } else {
                        echo "Error deleting record";
                        header("refresh: 2; URL=index.php");
                    }
                } else {
                    header("HTTP/1.1 401 Unauthorized");
                }
            }
        }
    } else {
        header("location: index.php");
    }
} else {
    header("location: index.php");
}
