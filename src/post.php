<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBlog</title>
    <link rel="stylesheet" href="../res/styles/styles.css">
</head>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<body>
    <?php include("./components/header.php"); ?>

    <div class="container">
        <div class="post_container">
            <?php
            if (isset($_GET["id"])) {

                require_once("./backend/connection.php");

                $query = "SELECT posts.id, title, description, content, username, created FROM posts JOIN users ON users.id=posts.user_id WHERE posts.id=?";

                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_GET["id"]);
                if (!$stmt->execute()) {
                    die($conn->error);
                }

                $post_id = 0;
                $title = "";
                $description = "";
                $content = "";
                $created = "";
                $username = "";

                $stmt->bind_result($post_id, $title, $description, $content, $username, $created);
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    if ($stmt->fetch()) {
                        echo '<div class="post_header">';
                        echo '<div>';
                        echo '<h1>' . $title . '</h1>';
                        echo '<p>Posted by: ' . $username . ' | <small>' . $created . '</small></p>';
                        echo '</div>';
                        echo '<div>';
                        if (isset($_SESSION["username"])) {
                            if ($_SESSION["username"] === $username) {
                                echo "<a href='delete.php?id=" . $post_id . "'><button>Delete</button></a>";
                            }
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '<hr>';
                        echo '<div class="post_content"><p>' . $content . '</p></div>';
                    }
                } else {
                    echo '
                    <p class="error">
                        Error: Post with this id does not exist!
                    </p>';
                }
            } else {
                echo "<h1>Post with this id does not exist!</h1>";
            }

            ?>
        </div>
    </div>
    <?php include("./components/footer.php") ?>
</body>

</html>