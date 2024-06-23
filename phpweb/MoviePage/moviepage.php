<?php
session_start();
include ("../LogInPage/connection.php");
include ("../LogInPage/functions.php");
include ("../HomePage/search.php");
$user_data = check_login($conn);
$api_key = "8ca6c40d2f4e3a85543f56e8c7b0fc2f";

if (isset($_SESSION['show_name'])) {
  $show_name = $_SESSION['show_name'];
}

$sql = "SELECT * FROM netflix_shows where title LIKE ? UNION SELECT * FROM disneyplus_shows where title LIKE ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $show_name, $show_name);
$stmt->execute();
$result = $stmt->get_result();
if ($result) {
  $row = $result->fetch_assoc();
  if (isset($row["show_id"])) {
    $s_id = $row["show_id"];
  }
  $description = $row['description'];
  $show_title = $row["title"];
  $type = $row["type"];
  $release_year = $row["release_year"];
  $duration = $row["duration"];
  $listed_in = $row["listed_in"];
  $cast = $row["cast"];
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$genres = explode(",", $listed_in);
$actors = explode(",", $cast);

$genres = eliminate_space($genres);
$actors = eliminate_space($actors);

if ($type == 'TV Show') {
  $linktype = 'tv';
} else {
  $linktype = 'movie';
}

$show_id = get_show_id($api_key, $show_title, $linktype);
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
  <div class="movie">
    <h1><?php echo $show_title; ?></h1>
    <div class="details">
      <p><?php echo $type; ?></p>
      <p><?php echo $release_year; ?></p>
      <p><?php echo $duration; ?></p>
    </div>

    <div class="poster_and_trailer">
      <?php get_poster($api_key, $show_id, $linktype); ?>
      <?php get_trailer($api_key, $show_id, $linktype); ?>
      <div class="description">
        <h3>Description</h3>
        <p>
          <?php echo $description; ?>
        </p>
        <div class="genre-container">
          <?php foreach ($genres as $genre) {
            echo "<button>" . $genre . "</button>";
          } ?>
        </div>
        <h1><?php get_rating($api_key, $show_id, $linktype); ?></h1>
      </div>
    </div>
  </div>
  <div class="bottom-half">
    <div class="actors-grid">
      <?php get_characters_and_photo($api_key, $show_id, $actors, $linktype); ?>
    </div>
    <div class="recommendations">
      <h2>You might also like...</h2>
      <div class="poster">
        <?php get_recommendation($genres[0], $s_id, $conn, $api_key); ?>
      </div>
    </div>
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