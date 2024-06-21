<?php
session_start();
include ("../LogInPage/connection.php");
include ("../LogInPage/functions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="startpage_styles.css" />
  <title>MoX</title>
</head>

<body>
  <div class="top">
    <div class="content">
      <div class="top-bar">
        <div class="logo">
          <img src="../materials/logo2.png" alt="no image found">
        </div>
        <div class="sign-in">
          <a href="../LogInPage/login.php"><button class="sign-in-button">Log In</button></a>
        </div>
      </div>
      <div class="middle">
        <div class="middle-content">
          <h1>
            The best place to come when
            you don't know what to watch!
          </h1>
          <form class="email" method="post">
            <input type="text" name="username" class="email-box" placeholder="Username" />
            <input type="password" name="password" class="email-box" placeholder="Password" />
            <input type="password" name="confirm_password" class="email-box" placeholder="Confirm Password" />

            <input type="submit" class="register-button" value="Register">
          </form>
          <?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if (!empty($username) && !empty($password) && !is_numeric($username)) {
      if($confirm_password !== $password){
        echo "<h2>Passwords do not match</h2>";
      }
      else{
        $sql = "select * from users where username = '$username'";
        $result = $conn->query($sql);
      if (mysqli_num_rows($result) > 0) {
        echo "<h2>Username already exists!</h2>";
      } 
      else {
        $user_id = random_num(20);
        $sql = "insert into users (user_id, username, password) values ('$user_id', '$username', '$password')";
        //$conn->query($sql);
        mysqli_query($conn, $sql);

        header("Location: ../LogInPage/login.php");
      }
    }
      

    } else {
      echo "<h2>Please enter valid information</h2>";
    }
  }
}
?>
        </div>
      </div>
    </div>
  </div>
  <div class="first-pannel">
    <h1>Supporting both <br>Disney + and Netflix!</h1>
    <img src="../materials/1stpannel.png" alt="no image found">
  </div>
  <div class="second-pannel">
    <img src="../materials/colaj.jpg" alt="no image found">
    <div class="second-pannel-text">
      <h1>Huge library of classics!</h1>
      <h3>Never run out of things to watch!</h3>
    </div>


  </div>
  <div class="third-pannel">
    <img src="../materials/recommendations.png" alt="no image found">
    <div class="third-pannel-text">
      <h1>Recommendations and<br>reviews, all in one place!</h1>
      <h3>Easily choose what's best for you!</h3>
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
</body>

</html>