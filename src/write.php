<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBlog</title>
    <link rel="stylesheet" href="../res/styles/styles.css">

    <script src="https://cdn.tiny.cloud/1/adnsso6g17in5iv9sfg1smj0xha8nu0nwg0euskp3hh0g6vt/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content'
        });
    </script>

</head>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
}

?>

<body>
    <?php include("./components/header.php"); ?>

    <div class="container">
        <?php

        if (isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["content"])) {
            require_once("./backend/connection.php");

            $query = "INSERT INTO posts (title, description, content, user_id, created) VALUES (?, ?, ?, ?, NOW())";

            $stmt = $conn->prepare($query);

            $title = $conn->escape_string(trim($_POST["title"]));
            $description = trim($_POST["description"]);
            $content = trim($_POST["content"]);

            $stmt->bind_param("sssi", $title, $description, $content, $_SESSION["user_id"]);

            if ($stmt->execute()) {
                echo '
                <p class="success">
                    You have create a new post successfully!
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
            <div class="login">
                <h3>Write a blog post</h3>
                <input required name="title" type="text" placeholder="Post title" />
                <input required name="description" type="text" placeholder="Post description" />
                <textarea id="content" name="content" placeholder="Post content"></textarea>
                <button name="submit" type="submit">Create</button>
            </div>
        </form>
    </div>
    <?php include("./components/footer.php") ?>
</body>

</html>