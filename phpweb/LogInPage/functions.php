<?php
function check_login($conn){
    if(isset($_SESSION['user_id']))
    {
        $id = $_SESSION['user_id'];
        $sql = "select * from users where user_id = $id limit 1";

        $result = $conn->query($sql);
        if($result && mysqli_num_rows($result) > 0){
            $user_data = $result->fetch_assoc();
            return $user_data;

        }
    }
    //redirect login
    header("Location: ../LogInPage/login.php");
    die;
}

function random_num($val){
    $text="";
    if($val < 5)
    {
        $val = 5;
    }
    $value = rand(4, $val);
    for($i = 0; $i < $value; $i++){
        $text .= rand(0,9);
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

function get_show_id($api_key, $show_title, $linktype)
{
  $url = "https://api.themoviedb.org/3/search/$linktype?api_key=$api_key&query=" . urlencode($show_title);
  $response = file_get_contents($url);
  $data = json_decode($response, true);
  return $data['results'][0]['id'] ?? null;
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

function get_credits($api_key, $show_id, $linktype){
    $url = "https://api.themoviedb.org/3/$linktype/$show_id/credits?api_key=$api_key";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function get_characters_and_photo($api_key, $show_id, $actors, $linktype){
    $credits = get_credits($api_key, $show_id, $linktype);
    if(!$credits || !isset($credits['cast'])){
        return;
    }

    foreach($credits['cast'] as $member){
        $actor_name = strtolower($member['name']);
        if(in_array($actor_name, array_map('strtolower', $actors))){
            echo "<div class='grid-element'>";
            echo "<img src='https://image.tmdb.org/t/p/w500{$member['profile_path']}' alt='no image found'>";
            echo "<div class='actor-name'>";
            echo "<h5>{$member['name']}</h5>";
            echo "<p>{$member['character']}</p>";
            echo "</div>";
            echo "</div>";
        }

    }
}