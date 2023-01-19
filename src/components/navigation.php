<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<nav class="navigation">
    <h1><a href="index.php"><span style="color: #ffd68a">My</span>Blog</a></h1>
    <ul>
        <form action="index.php" method="GET">
            <li id="search">
                <input id="searchfield" name="title" placeholder="Search posts by title..." type="text" />
                <label for="searchfield" class="fa fa-search"></label>
            </li>
        </form>

        <li><a href="index.php">Homepage</a></li>
        <?php
        if (!isset($_SESSION["username"])) {
            echo '
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>';
        }
        ?>
        <?php if (isset($_SESSION["username"])) {
            echo '<li><a href="write.php">Write post</a></li>';
            echo '
            <p class="profile">' . $_SESSION["username"] . '</p>';
            echo '<li><a href="logout.php">Logout</a></li>';
        }
        ?>
    </ul>
    <button class="menubtn"><i class="fa fa-bars"></i></button>
</nav>