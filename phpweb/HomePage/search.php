<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['show_name'])){;
        $show_name = htmlspecialchars($_POST['show_name']);
        $_SESSION['show_name'] = $show_name;
        header("Location: ../MoviePage/moviepage.php");
        exit();
    }
}
?>