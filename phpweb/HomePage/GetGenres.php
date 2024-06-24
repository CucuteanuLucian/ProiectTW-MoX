<?php
include ("../LogInPage/connection.php");
$query = "SELECT listed_in FROM netflix_shows";
$result = mysqli_query($conn, $query);
$genre_counts = array();
while ($row = mysqli_fetch_assoc($result)) {
    $genres = explode(',', $row['listed_in']);
    foreach ($genres as $genre) {
        $genre = trim($genre);
        if (array_key_exists($genre, $genre_counts)) {
            $genre_counts[$genre]++;
        } else {
            $genre_counts[$genre] = 1;
        }
    }
}
$final_genre_counts = array();
$final_genre_counts['Other'] = 0;
foreach ($genre_counts as $genre => $count) {
    if ($count < 500) {
        $final_genre_counts['Other'] += $count;
    } else {
        $final_genre_counts[$genre] = $count;
    }
}


echo json_encode($final_genre_counts);
?>