<!DOCTYPE html>
<head>
    <title>MoX</title>
    <link rel="stylesheet" href="HomePage.css">
</head>
<body>
    <?=date('h:i:s A');
    ?>
    <b?php
    $api_key = '8ca6c40d2f4e3a85543f56e8c7b0fc2f';
    $servername = "localhost";
    $username = "luci";
    $password = "luci";
    $database = "mox";
?>
    <div class="top">
        <div class="btn-container">
            <button class="btn"><img src="../materials/HomePage/logo2.png" alt="no image found"></button>
            <button class="btn"><a href="HomePage.php">Home</a></button>
            <button class="btn">TV Shows</button>
            <button class="btn"><a href="../MoviePage/MoviePage.php">Movies</a></button>
            <button class="btn">New & Popular</button>
        </div>
        <div class="search-container">
            <input class="search-bar" type="text" placeholder="What are you watching today?">
            <button class="search-btn" type="submit"><img src="../materials/HomePage/lupa2.png" alt="no image found"></button>
        </div>         
    </div>
    <div class="ForYou">
        <h2 class="CategoryTitle">For You:</h2>
        <div class="ForYouBar">
            <img src="../materials/HomePage/BrBad.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/GOT.jpg" alt="no image found">
        </div>
        <button class="prev" onclick="moveSlider1(-1)"><b>&#10094;</b></button>
        <button class="next" onclick="moveSlider1(1)"><b>&#10095;</b></button>
    </div>
    <div class="TVShows">
        <h2 class="CategoryTitle">TV Shows:</h2>
        <div class="TVShowsBar">
            <img src="../materials/HomePage/BrBad.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/GOT.jpg" alt="no image found">
        </div>
        <button class="prev" onclick="moveSlider2(-1)"><b>&#10094;</b></button>
        <button class="next" onclick="moveSlider2(1)"><b>&#10095;</b></button>
    </div>
    <div class="Movies">
        <h2 class="CategoryTitle">Movies:</h2>
        <div class="MoviesBar">
            <img src="../materials/HomePage/BrBad.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/BCS.jpg" alt="no image found">
            <img src="../materials/HomePage/GOT.jpg" alt="no image found">
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