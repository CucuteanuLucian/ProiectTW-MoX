<?php
session_start();
include ("../LogInPage/connection.php");
include ("../LogInPage/functions.php");
include ("search.php");
$user_data = check_login($conn);
?>
<!DOCTYPE html>

<head>
    <title>MoX</title>
    <link rel="stylesheet" href="../HomePage/HomePage.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            console.log("jQuery is loaded and ready.");
        });
    </script>
</head>

<body>
    <?php $api_key = '8ca6c40d2f4e3a85543f56e8c7b0fc2f';
    $servername = "localhost";
    $username = "luci";
    $password = "luci";
    $database = "mox"; ?>
    <div class="top">
        <div class="btn-container">
            <button class="btn"><img src="../materials/HomePage/logo2.png" alt="no image found"></button>
            <button class="btn"><a href="HomePage.php">Home</a></button>
            <button class="btn">TV Shows</button>
            <button class="btn"><a href="../MoviePage/MoviePage.php">Movies</a></button>
            <button class="btn">New & Popular</button>
        </div>
        <div class="search-container">
            <form method="POST" class="search">
                <div class="searchanddrop">
                    <input id="show_name" name="show_name" class="search-bar" type="text"
                        placeholder="What are you watching today?" autocomplete="off">
                    <div id="suggestions" class="suggestions" style="display: none;"></div>
                </div>
                <button class="search-btn" type="submit">
                    <img src="../materials/HomePage/lupa2.png">
                </button>
            </form>

            <div>
                <button id="dropdownButton"><?php echo $user_data['username'] ?></button>
                <div id="dropdownMenu" class="dropdownContent">
                    <a href="">Acount Details</a>
                    <a href="../LogInPage/logout.php">Log Out</a>
                </div>
            </div>
        </div>

    </div>
    <div class="ForYou">
        <h2 class="CategoryTitle">For You:</h2>
        <div class="ForYouBar">
            <?php
            get_home_page_details($api_key, $conn, 2);
            ?>
        </div>
        <button class="prev" onclick="moveSlider1(-1)"><b>&#10094;</b></button>
        <button class="next" onclick="moveSlider1(1)"><b>&#10095;</b></button>
    </div>
    <div class="TVShows">
        <h2 class="CategoryTitle">Netflix Shows:</h2>
        <div class="TVShowsBar">
            <?php
            get_home_page_details($api_key, $conn, 0);
            ?>
        </div>
        <button class="prev" onclick="moveSlider2(-1)"><b>&#10094;</b></button>
        <button class="next" onclick="moveSlider2(1)"><b>&#10095;</b></button>
    </div>
    <div class="Movies">
        <h2 class="CategoryTitle">Disney+ Shows:</h2>
        <div class="MoviesBar">
            <?php
            get_home_page_details($api_key, $conn, 1);
            ?>
        </div>
        <button class="prev" onclick="moveSlider3(-1)"><b>&#10094;</b></button>
        <button class="next" onclick="moveSlider3(1)"><b>&#10095;</b></button>
    </div>
    <div class="footer">
        <div class="contacts">
            <h2>Contacts</h2>
            <h3>E-mail</h3>
            <ul>
                <li>palici.roberto@gmail.com</li>
                <li>lucian.andrei68@gmail.com</li>
            </ul>
            <h3>Phone number</h3>
            <ul>
                <li>+40 753 470 904</li>
                <li>+40 754 279 778</li>
            </ul>

        </div>
        <div class="info">
            <h2>Info</h2>
            <ul>
                <li>About</li>
                <li>Privacy</li>
                <li>Terms</li>
            </ul>
        </div>
    </div>
    <script src="HomePageScript.js"></script>
</body>