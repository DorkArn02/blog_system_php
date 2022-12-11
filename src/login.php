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

if (isset($_SESSION["user_id"])) {
    header("location: index.php");
}

?>

<body>
    <?php include("./components/header.php"); ?>

    <div class="container">
        <?php
        if (isset($_POST["username"]) && isset($_POST["password"])) {

            require_once("./backend/connection.php");

            $query = "SELECT id, username, email FROM users WHERE username=? AND password=?";

            $stmt = $conn->prepare($query);

            $username = $conn->escape_string(trim($_POST["username"]));
            $password = md5($conn->escape_string(trim($_POST["password"])));
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();

            $user_id = 0;
            $username = "";
            $email = "";

            $stmt->bind_result($user_id, $username, $email);
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                if ($stmt->fetch()) {
                    $_SESSION["user_id"] = $user_id;
                    $_SESSION["username"] = $username;
                    $_SESSION["email"] = $email;
                    echo '
                    <p class="success">
                        You logged in successfully, redirecting...
                    </p>';
                    header("refresh: 0.6; URL=index.php");
                }
            } else {
                echo '
                    <p class="error">
                        Error: Wrong username or password!
                    </p>';
            }
        }

        ?>
        <form method="POST" action="">
            <div class="login">
                <h3>Login page</h3>
                <input required name="username" type="text" placeholder="Username" />
                <input required name="password" type="password" placeholder="Password" />
                <button name="submit" type="submit">Login</button>
                <p>Forgot your password? <a href="#">Click here.</a></p>
            </div>
        </form>
    </div>
    <?php include("./components/footer.php") ?>
</body>

</html>