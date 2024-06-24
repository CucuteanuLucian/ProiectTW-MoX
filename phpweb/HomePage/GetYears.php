<?php
include("../LogInPage/connection.php");
$query = "SELECT release_year FROM netflix_shows"; 
$result = mysqli_query($conn, $query);
$year_counts = array();
while ($row = mysqli_fetch_assoc($result)) {
    $years = explode(',', $row['release_year']);
    foreach ($years as $year) {
        $year = trim($year);
        if (array_key_exists($year, $year_counts)) {
            $year_counts[$year]++;
        } else {
            $year_counts[$year] = 1;
        }
    }
}

echo json_encode($year_counts);
?>