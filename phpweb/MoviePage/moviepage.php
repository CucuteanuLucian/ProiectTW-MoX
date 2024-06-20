<?php
$api_key = '8ca6c40d2f4e3a85543f56e8c7b0fc2f';
$servername = "localhost";
$username = "luci";
$password = "luci";
$database = "mox";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$name = "Better call saul";
$sql = "SELECT * FROM netflix_shows where title LIKE '$name' UNION SELECT * FROM disneyplus_shows where title LIKE '$name'";
$result = $conn->query($sql);
if ($result) {
  $row = $result->fetch_assoc();
  $s_id = $row["show_id"];
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

function get_recommendation($genre, $id, $conn, $api_key)
{
  $genre = $genre . '%';
  $sql = "SELECt * from 
  ((SELECT * FROM netflix_shows where listed_in LIKE '$genre' and show_id not like '$id') 
  union 
  (SELECT * FROM disneyplus_shows where listed_in LIKE '$genre' and show_id not like '$id')) 
  as combined_tables order by rand() Limit 3;";
  $result = $conn->query($sql);
  if ($result) {
    while ($row = $result->fetch_assoc()) {
      $recommendedTitle = $row["title"];
      $recommendedTitleType = $row["type"];
      if ($recommendedTitleType == 'TV Show') {
        $recommendedLinkType = 'tv';
      } else {
        $recommendedLinkType = 'movie';
      }
      $recommendedTitleId = get_show_id($api_key, $recommendedTitle, $recommendedLinkType);
      get_poster($api_key, $recommendedTitleId, $recommendedLinkType);
    }
  }
}

function eliminate_space($array)
{
  for ($i = 0; $i < count($array); $i++) {
    if (strpos($array[$i], ' ') === 0) {
      $array[$i] = ltrim($array[$i], ' ');
    }

  }
  return $array;
}
$genres = eliminate_space($genres);
$actors = eliminate_space($actors);

if ($type == 'TV Show') {
  $linktype = 'tv';
} else {
  $linktype = 'movie';
}
function get_show_id($api_key, $show_title, $linktype)
{
  $url = "https://api.themoviedb.org/3/search/$linktype?api_key=$api_key&query=" . urlencode($show_title);
  $response = file_get_contents($url);
  $data = json_decode($response, true);
  return $data['results'][0]['id'] ?? null;
}
function get_character_name($api_key, $show_id, $actor_name, $linktype)
{
  $url = "https://api.themoviedb.org/3/$linktype/$show_id/credits?api_key=$api_key";
  $response = file_get_contents($url);
  $data = json_decode($response, true);
  foreach ($data['cast'] as $cast_member) {
    if (strtolower($cast_member['name']) == strtolower($actor_name)) {
      return $cast_member['character'];
    }
  }
}

function get_actor_photo($api_key, $show_id, $actor_name, $linktype)
{
  if($show_id == null)
  {
    return 0;
  }
  $url = "https://api.themoviedb.org/3/$linktype/$show_id/credits?api_key=$api_key";
  $response = file_get_contents($url);
  $data = json_decode($response, true);
  foreach ($data['cast'] as $cast_member) {
    if (strtolower($cast_member['name']) == strtolower($actor_name)) {
      $profile_photo = $cast_member['profile_path'];
    }
  }
  echo "<img src='https://image.tmdb.org/t/p/w500$profile_photo' alt='no image found'>";
}

function get_poster($api_key, $show_id, $linktype)
{
  if($show_id==null)
  {
    echo "<img src='../materials/npf.png' alt='Movie Poster'>";
  }
  $url = "https://api.themoviedb.org/3/$linktype/$show_id/images?api_key=$api_key";
  $response = file_get_contents($url);
  if ($response !== false) {
    $data = json_decode($response, true);
    if (isset($data["posters"][0]["file_path"])) {
      $poster_path = $data["posters"][0]["file_path"];
      $poster_url = "https://image.tmdb.org/t/p/w500$poster_path";
      echo "<img src='$poster_url' alt='Movie Poster'>";
    } else {
      echo "<img src='../materials/npf.png' alt='Movie Poster'>";
      //echo "Poster not found for this movie.";
    }
  } else {
    echo "Failed to fetch data";
  }
}

function get_rating($api_key, $show_id, $linktype)
{
  if($show_id == null) {
    echo "Rating Not Found";
  }
  $url = "https://api.themoviedb.org/3/$linktype/$show_id?api_key=$api_key";
  $response = file_get_contents($url);
  if ($response !== false) {
    $data = json_decode($response, true);
    if (isset($data["vote_average"])) {
      $rating = substr($data["vote_average"], 0, 3);
      echo "Rating: "."$rating" . "/10";
    } else {
      echo "Rating not found for this movie.";
    }
  } else {
    echo "Failed to fetch rating data.";
  }
}



function get_trailer($api_key, $show_id, $linktype)
{
  $url = "https://api.themoviedb.org/3/$linktype/$show_id/videos?api_key=$api_key";
  $response = file_get_contents($url);
  if ($response !== false) {
    $data = json_decode($response, true);
    if (isset($data["results"][0]["key"])) {
      $video_key = $data["results"][0]["key"];
      $video_url = "<iframe width='855' height='704' src='https://www.youtube.com/embed/$video_key' title='Trailer' frameborder='0' allow='accelerometer; clipboard-write; encrypted-media; gyroscope; web-share' referrerpolicy='strict-origin-when-cross-origin' allowfullscreen></iframe>";
      echo $video_url;
    } else {
      echo "Poster not found for this movie.";
    }
  } else {
    echo "Failed to fetch data";
  }



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
</head>

<body>
  <?php echo $show_id;
  ?>
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
      <input class="search-bar" type="text" placeholder="What are you watching today?" />
      <button class="search-btn" type="submit">
        <img src="../materials/HomePage/lupa2.png" alt="no image found">
      </button>
    </div>
  </div>


  <!--<h1>Breaking Bad</h1> -->
  <div class="movie">
    <h1><?php echo $show_title; ?></h1>
    <div class="details">
      <p><?php echo $type; ?></p>
      <p><?php echo $release_year; ?></p>
      <p><?php echo $duration; ?></p>
    </div>

    <div class="poster_and_trailer">
      <!--<img src="../materials/HomePage/BrBad.jpg" alt="no image found"> -->
      <?php get_poster($api_key, $show_id, $linktype); ?>
      <!--<img src="../materials/trailerplaceholder.jpg" alt="no image found"> -->
      <?php get_trailer($api_key, $show_id, $linktype); ?>
      <div class="description">
        <h3>Description</h3>
        <p>
          <?php echo $description; ?>
        </p>
        <div class="genre-container">
          <!--<button>Crime</button>
            <button>Thriller</button>
            <button>Drama</button> -->
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
      <?php
      foreach ($actors as $actor) {
        if (get_character_name($api_key, $show_id, $actor, $linktype) !== null) {
          echo "<div class='grid-element'>";
          get_actor_photo($api_key, $show_id, $actor, $linktype);
          echo "<div class='actor-name'>";
          echo "<h5>" . $actor . "</h5>";
          echo "<p>" . get_character_name($api_key, $show_id, $actor, $linktype) . "</p>";
          echo "</div>";
          echo "</div>";
        }

      }
      ?>
      <!--<div class="grid-element">
        <img src="../materials/bryan.jpg" alt="no image found">
        <div class="actor-name">
          <h5>Bryan Cranston</h5>
          <p>Walter White</p>
        </div>
      </div>
      <div class="grid-element">
        <img src="../materials/aaron.jpg" alt="no image found">
        <div class="actor-name">
          <h5>Aaron Paul</h5>
          <p>Jesse Pinkman</p>
        </div>
      </div>
      <div class="grid-element">
        <img src="../materials/giancarlo.jpg" alt="no image found">
        <div class="actor-name">
          <h5>Giancarlo Esposito</h5>
          <p>Gustavo Fring</p>
        </div>
      </div>
      <div class="grid-element">
        <img src="../materials/anna.jpg" alt="no image found">
        <div class="actor-name">
          <h5>Anna Gunn</h5>
          <p>Skyler White</p>
        </div>
      </div>
      <div class="grid-element">
        <img src="../materials/bob.jpg" alt="no image found">
        <div class="actor-name">
          <h5>Bob Odenkirk</h5>
          <p>Saul Goodman</p>
        </div>
      </div>
      <div class="grid-element">
        <img src="../materials/dean.jpg" alt="no image found">
        <div class="actor-name">
          <h5>Dean Norris</h5>
          <p>Hank Shrader</p>
        </div>
      </div> -->
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
</body>

</html>