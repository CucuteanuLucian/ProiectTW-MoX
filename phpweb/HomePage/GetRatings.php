<?php
include("../LogInPage/connection.php");
$query = "SELECT rating FROM netflix_shows"; 
$result = mysqli_query($conn, $query);
$rating_counts = array();
while ($row = mysqli_fetch_assoc($result)) {
    $ratings = explode(',', $row['rating']);
    foreach ($ratings as $rating) {
        $rating = trim($rating);
        if (array_key_exists($rating, $rating_counts)) {
            $rating_counts[$rating]++;
        } else {
            $rating_counts[$rating] = 1;
        }
    }
}


$final_rating_counts = array();
$final_rating_counts['Other']=0;
foreach ($rating_counts as $rating => $count) {
    if($count<400) {
        $final_rating_counts['Other']+=$count;
    }
    else
    {
        $final_rating_counts[$rating]=$count;
    }
}
echo json_encode($final_rating_counts);
?>