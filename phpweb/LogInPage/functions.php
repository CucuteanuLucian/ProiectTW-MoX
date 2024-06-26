<?php
function check_login($conn)
{
  if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    $sql = "select * from users where user_id = $id limit 1";

    $result = $conn->query($sql);
    if ($result && mysqli_num_rows($result) > 0) {
      $user_data = $result->fetch_assoc();
      return $user_data;

    }
  }
  header("Location: ../LogInPage/login.php");
  die;
}

function random_num($val)
{
  $text = "";
  if ($val < 5) {
    $val = 5;
  }
  $value = rand(4, $val);
  for ($i = 0; $i < $value; $i++) {
    $text .= rand(0, 9);
  }
  return $text;
}

function get_recommendation($genre, $id, $conn, $api_key)
{
  $genre = $genre . '%';
  $sql = "SELECt * from 
  ((SELECT * FROM netflix_shows where listed_in LIKE ? and show_id not like ?) 
  union 
  (SELECT * FROM disneyplus_shows where listed_in LIKE ? and show_id not like ?)) 
  as combined_tables order by rand() Limit 3;";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssss", $genre, $id, $genre, $id);
  $stmt->execute();
  $result = $stmt->get_result();
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

      echo '<form method="POST">
      <input type="hidden" name="show_name" value="' . $recommendedTitle . '">
      <button type="submit" class="RECbutton">';
      get_poster($api_key, $recommendedTitleId, $recommendedLinkType);
      echo '</button></form>';
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

function get_show_id($api_key, $show_title, $linktype)
{
  $url = "https://api.themoviedb.org/3/search/$linktype?api_key=$api_key&query=" . urlencode($show_title);
  $response = file_get_contents($url);
  $data = json_decode($response, true);
  return $data['results'][0]['id'] ?? null;
}

function get_poster($api_key, $show_id, $linktype)
{
  if ($show_id == null || $show_id == '') {
    echo "<img src='../materials/npf.png' alt='Movie Poster'>";
  } else {
    $url = "https://api.themoviedb.org/3/$linktype/$show_id/images?api_key=$api_key";
    $response = file_get_contents($url);
    if ($response !== false) {
      $data = json_decode($response, true);
      if (isset($data["posters"][0]["file_path"])) {
        $poster_path = $data["posters"][0]["file_path"];
        $poster_url = "https://image.tmdb.org/t/p/w500$poster_path";
        echo "<img src='$poster_url' class='poster' alt='Movie Poster'>";
      } else {
        echo "<img src='../materials/npf.png' alt='Movie Poster'>";
      }
    } else {
      echo "Failed to fetch data";
    }
  }
}

function get_rating($api_key, $show_id, $linktype)
{
  if ($show_id == null) {
    echo "Rating Not Found";
  } else {
    $url = "https://api.themoviedb.org/3/$linktype/$show_id?api_key=$api_key";
    $response = file_get_contents($url);
    if ($response !== false) {
      $data = json_decode($response, true);
      if (isset($data["vote_average"])) {
        $rating = substr($data["vote_average"], 0, 3);
        echo "Rating: " . "$rating" . "/10";
      } else {
        echo "Rating not found for this movie.";
      }
    } else {
      echo "Failed to fetch rating data.";
    }
  }
}

function get_trailer($api_key, $show_id, $linktype)
{
  if ($show_id == null || $show_id == '') {
    echo "<img src='../materials/npf.png' alt='Movie Poster'>";
  } else {
    $url = "https://api.themoviedb.org/3/$linktype/$show_id/videos?api_key=$api_key";
    $response = file_get_contents($url);
    if ($response !== false) {
      $data = json_decode($response, true);
      if (isset($data["results"][0]["key"])) {
        $video_key = $data["results"][0]["key"];
        $video_url = "<iframe class='trailer' width='855' height='704' src='https://www.youtube.com/embed/$video_key' title='Trailer' frameborder='0' allow='accelerometer; clipboard-write; encrypted-media; gyroscope; web-share' referrerpolicy='strict-origin-when-cross-origin' allowfullscreen></iframe>";
        echo $video_url;
      } else {
        echo "<img src='../materials/notrailer.png'>";
      }
    } else {
      echo "Failed to fetch data";
    }
  }
}

function get_credits($api_key, $show_id, $linktype)
{
  if ($show_id == null || $show_id == '') {
    echo "<h1>Cast Not Found</h1>";
  } else {
    $url = "https://api.themoviedb.org/3/$linktype/$show_id/credits?api_key=$api_key";
    $response = file_get_contents($url);
    return json_decode($response, true);
  }
}

function get_characters_and_photo($api_key, $show_id, $actors, $linktype)
{
  $credits = get_credits($api_key, $show_id, $linktype);
  if (!$credits || !isset($credits['cast'])) {
    return;
  }

  foreach ($credits['cast'] as $member) {
    $actor_name = strtolower($member['name']);
    if (in_array($actor_name, array_map('strtolower', $actors))) {
      $profile_path = isset($member['profile_path']) ? "https://image.tmdb.org/t/p/w500{$member['profile_path']}" : '../materials/noprofile.png';
      echo "<div class='grid-element'>";
      echo "<img src='$profile_path'>";
      echo "<div class='actor-name'>";
      echo "<h5>{$member['name']}</h5>";
      echo "<p>{$member['character']}</p>";
      echo "</div>";
      echo "</div>";
    }

  }
}

function get_home_page_details($api_key, $conn, $NorD, $ifTitle)
{

  if ($NorD === 0) { //netflix
    $sql = "SELECT title FROM netflix_shows where title not like '%:%' limit 36;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
      while ($row = $result->fetch_assoc()) {
        $HPtitle = $row["title"];
        if (file_exists("../materials/HomePage/$HPtitle.jpg")) {
          if ($ifTitle === 0) {
            echo '<form method="POST">
          <input type="hidden" name="show_name" value="' . $HPtitle . '">
          <button type="submit" class="HPbutton">
            <img src="../materials/HomePage/' . $HPtitle . '.jpg">
          </button>
          </form>';
          } else {
            echo '<div class="gridElement"><form method="POST">
          <input type="hidden" name="show_name" value="' . $HPtitle . '">
          <button type="submit" class="HPbutton">
            <img src="../materials/HomePage/' . $HPtitle . '.jpg">
          </button>
          </form>
          <p>' . $HPtitle . '</p>
          </div>';
          }
        } else {
          if ($ifTitle === 0) {
            echo '<button class="HPbutton">
            <img src="../materials/npf.png">
          </button>';
          } else {
            echo '<div class="gridElement"><button class="HPbutton">
            <img src="../materials/npf.png">
          </button>
          <p>' . $HPtitle . '</p>
          </div>';
          }
        }
      }
    }
  } else if ($NorD === 1) { // disney
    $sql = "SELECT title FROM disneyplus_shows where title not like '%:%' limit 36;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
      while ($row = $result->fetch_assoc()) {
        $HPtitle = $row["title"];
        if (file_exists("../materials/HomePage/$HPtitle.jpg")) {
          if ($ifTitle === 0) {
            echo '<form method="POST">
          <input type="hidden" name="show_name" value="' . $HPtitle . '">
          <button type="submit" class="HPbutton">
            <img src="../materials/HomePage/' . $HPtitle . '.jpg">
          </button>
          </form>';
          } else {
            echo '<div class="gridElement"><form method="POST">
          <input type="hidden" name="show_name" value="' . $HPtitle . '">
          <button type="submit" class="HPbutton">
            <img src="../materials/HomePage/' . $HPtitle . '.jpg">
          </button>
          </form>
          <p>' . $HPtitle . '</p>
          </div>';
          }
        } else {
          if ($ifTitle === 0) {
            echo '<button class="HPbutton">
            <img src="../materials/npf.png">
          </button>';
          } else {
            echo '<div class="gridElement"><button class="HPbutton">
            <img src="../materials/npf.png">
          </button>
          <p>' . $HPtitle . '</p>
          </div>';
          }
        }
      }
    }
  } else if ($NorD === 2) { // both
    $sql = "Select * from 
    ((SELECT * FROM netflix_shows where title not like '%:%' and show_id not like 's8795' ORDER BY CAST(SUBSTR(show_id, 2) AS INTEGER) DESC LIMIT 18) 
    UNION (SELECT * FROM disneyplus_shows where title not like '%:%' ORDER BY CAST(SUBSTR(show_id, 2) AS INTEGER) DESC LIMIT 18)) 
    as combined_tables order by rand();";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
      while ($row = $result->fetch_assoc()) {
        $HPtitle = $row["title"];
        if (file_exists("../materials/HomePage/$HPtitle.jpg")) {
          echo '<form method="POST">
          <input type="hidden" name="show_name" value="' . $HPtitle . '">
          <button type="submit" class="HPbutton">
            <img src="../materials/HomePage/' . $HPtitle . '.jpg">
          </button>
        </form>';
        } else {
          echo '<button class="HPbutton">
            <img src="../materials/npf.png">
          </button>';
        }
      }
    }
  }
}


