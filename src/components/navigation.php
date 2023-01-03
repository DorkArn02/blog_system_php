<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<nav>
    <h1><a href="index.php"><span style="color: #ffd68a">My</span>Blog</a></h1>
    <ul>
        <form action="index.php" method="GET">
            <li id="search">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg>
                <input name="title" placeholder="Search posts by title..." type="text" />
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


</nav>