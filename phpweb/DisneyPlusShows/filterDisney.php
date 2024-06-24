<?php
include('../LogInPage/functions.php');
include('../LogInPage/connection.php');
$api_key="8ca6c40d2f4e3a85543f56e8c7b0fc2f";
$category='';
if(isset($_POST['category'])){
    $category = $_POST['category'];
}
if($category === 'none'){
    $sql = "SELECT title FROM disneyplus_shows where title not like '%:%' limit 36;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
}else{
    $category = '%' . $category . '%';
    $sql = "SELECT title FROM (SELECT title, listed_in FROM disneyplus_shows WHERE title NOT LIKE '%:%' LIMIT 36) AS first_shows WHERE listed_in LIKE ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $category);
    $stmt->execute();
    $result = $stmt->get_result();
}

if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo '<div class="grid-element"><form method="POST">
        <input type="hidden" name="show_name" value="' . $row['title'] . '">
        <button type="submit" class="HPbutton">';
        if (file_exists("../materials/HomePage/{$row['title']}.jpg"))
        {
            echo "<img src='../materials/HomePage/" . $row['title'] . ".jpg'></button></form>
            <p>" . $row['title']. "</p></div>";
        }
        else{
            echo "<img src='../materials/npf.png'></button></form>
            <p>" . $row['title']. "</p></div>";
        }
          
        
    }
} else {
    echo "<h2>No shows found in this category</h2>";
}