<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBlog</title>
    <link rel="stylesheet" href="../res/styles/styles.css">
</head>

<body>
    <?php include("./components/header.php"); ?>

    <div class="container">
        <?php

        require_once("./backend/connection.php");

        if (isset($_GET["title"]) && !empty($_GET["title"])) {
            $query = "SELECT posts.id, title, description, username, created FROM posts JOIN users ON users.id=posts.user_id WHERE title LIKE CONCAT('%', ?, '%')";

            $stmt = $conn->prepare($query);

            $stmt->bind_param('s', $_GET["title"]);
            $stmt->execute();
            $result = $stmt->get_result();


            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo ' 
                    <div class="post">
                            <a href="post.php?id=' . $row["id"] . '">
                                <h3>' . $row["title"] . '</h3>
                                <p class="subtext">' . $row["description"] . '</p>
                            </a>
                            <small>
                                Posted by: <i>' . $row["username"] . '</i> | ' . $row["created"] . '
                            </small>
                            <hr>
                        </div>
                    ';
                }
            } else {
                echo "<div class='error'><p>No results found.</p> <p><a href='index.php'>Click here to go back.</a></p></div>";
            }
        } else {
            $query = "SELECT posts.id, title, description, username, created FROM posts JOIN users ON users.id=posts.user_id";

            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo ' 
                    <div class="post">
                            <a href="post.php?id=' . $row["id"] . '">
                                <h3>' . $row["title"] . '</h3>
                                <p class="subtext">' . $row["description"] . '</p>
                            </a>
                            <small>
                                Posted by: <i>' . $row["username"] . '</i> | ' . $row["created"] . '
                            </small>
                            <hr>
                        </div>
                    ';
                }
            }
        }
        ?>
    </div>
    <?php include("./components/footer.php") ?>
</body>

</html>