<?php
include ("../LogInPage/connection.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['show_name'])){
        $show_name = htmlspecialchars($_POST['show_name']);
        $_SESSION['show_name'] = $show_name;
        header("Location: ../MoviePage/moviepage.php");
        exit();
    }else if(isset($_POST['query'])){
    $query =$_POST["query"] . "%";
    $sql = "SELECT title FROM netflix_shows WHERE title LIKE ? UNION SELECT title FROM disneyplus_shows where title LIKE ? LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result-> num_rows > 0){
        while ($row = $result->fetch_assoc()){
            echo "<div class='suggestion-item'>" . htmlspecialchars($row['title']) . "</div>";
        }
    } else {
        echo "<div class='suggestion-item'>No suggestions found</div>";
    }
    $stmt->close();

}
}
?>