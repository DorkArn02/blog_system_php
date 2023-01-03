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
            <div>
                <h2>Comments</h2>
                <?php
                if (isset($_SESSION["user_id"])) {
                    if (isset($_POST["content"]) && isset($_GET["id"])) {
                        require_once("./backend/connection.php");

                        $query = "INSERT INTO comments (post_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())";

                        $stmt = $conn->prepare($query);
                        $post_id = $_GET["id"];
                        $content = trim($_POST["content"]);

                        $stmt->bind_param("iis", $post_id, $_SESSION["user_id"], $content);

                        if ($stmt->execute()) {
                            echo '
                                <p class="success">
                                    You have create a new comment successfully!
                                </p>';
                        } else {
                            echo '
                                <p class="error">
                                    Error: Something went wrong!
                                </p>';
                        }
                    }
                ?>
                    <form method="POST" action="">
                        <div class="comment_box">
                            <h3>Write a comment</h3>
                            <textarea id="content" name="content" placeholder="Post content"></textarea>
                            <button name="submit" type="submit">Create a new comment</button>
                        </div>
                    </form>
                <?php } else {
                    echo "<p class='information'>Only logged in users can write comments!</p>";
                }

                ?>
                <div class="comment_list">
                    <?php
                    if (isset($_GET["id"])) {

                        require_once("./backend/connection.php");

                        $query = "SELECT comments.content, created_at, users.username FROM comments JOIN posts ON comments.post_id=posts.id 
                    JOIN users ON comments.user_id=users.id
                    WHERE posts.id=" . $_GET["id"];

                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                echo "<div class='comment'>";
                                echo "<b>" . $row["username"] . "</b>";
                                echo "<small>" . $row["created_at"] . "</small>";
                                echo "<p>" . $row["content"] . "</p>";
                                echo "</div>";
                            }
                        } else {
                            echo '
                    <p >
                         No comments posted for this post!
                    </p>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php include("./components/footer.php") ?>
</body>

</html>