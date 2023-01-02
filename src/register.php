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
        if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"])) {
            require_once("./backend/connection.php");

            $query = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";

            $stmt = $conn->prepare($query);

            $username = $conn->escape_string(trim($_POST["username"]));
            $password = md5($conn->escape_string(trim($_POST["password"])));
            $email = $conn->escape_string(trim($_POST["email"]));

            $stmt->bind_param("sss", $username, $password, $email);


            if ($stmt->execute()) {
                echo '
                <p class="success">
                    You have registered successfully!
                </p>';
            } else {
                echo '
                <p class="error">
                    Error: Account with provided username or email exists!
                </p>';
            }
        }

        ?>
        <form method="POST" action="">
            <div class="login">
                <h3>Register page</h3>
                <input required name="username" type="text" placeholder="Username" />
                <input required name="password" type="password" placeholder="Password" />
                <input required name="email" type="email" placeholder="E-mail" />
                <button name="submit" type="submit">Register</button>
                <p>Already have an account? <a href="login.php">Click here.</a></p>
            </div>
        </form>
    </div>
    <?php include("./components/footer.php") ?>
</body>

</html>