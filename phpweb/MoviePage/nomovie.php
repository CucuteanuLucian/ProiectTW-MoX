<?php
session_start();
include ("../LogInPage/connection.php");
include ("../LogInPage/functions.php");
include ("../HomePage/search.php");
$user_data = check_login($conn);
$api_key="8ca6c40d2f4e3a85543f56e8c7b0fc2f";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MoX</title>
  <link rel="stylesheet" href="../MoviePage/moviepage_styles.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <div class="top">
    <div class="btn-container">
      <button class="btn">
        <a href="../HomePage/HomePage.php"><img src="../materials/HomePage/logo2.png" alt="no image found"></a>
      </button>
      <button class="btn"><a href="../HomePage/HomePage.php">Home</a></button>
      <button class="btn">TV Shows</button>
      <button class="btn">Movies</button>
      <button class="btn">New & Popular</button>
    </div>
    <div class="search-container">
                <form method="POST" class ="search">
                <div class="searchanddrop">
                <input id="show_name" name="show_name"class="search-bar" type="text" placeholder="What are you watching today?" autocomplete="off">
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
  <div class ="notitle">
    <h1>No movie with this name found...</h1>
    <p>Maybe try another title?</p>
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
  <?php
  $conn->close();
  ?>
  <script src="../HomePage/HomePageScript.js"></script>
</body>

</html> 