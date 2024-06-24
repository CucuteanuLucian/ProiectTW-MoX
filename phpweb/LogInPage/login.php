<?php
          session_start();
          include ("../LogInPage/connection.php");
          include ("../LogInPage/functions.php");?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="login.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
          <a href="../StartPage/startpage.php"><button class="sign-in-button">Sign In</button></a>
        </div>
      </div>
      <div class="middle">
        <div class="middle-content">
          <h1>Log into your account!</h1>
          <form class="login" method="post">
            <input type="text" name="username" class="email-box" placeholder="Username" autocomplete="off"/>
            <input type="password" name="password" class="password-box" placeholder="Password" />
            <input class="register-button" type="submit" value="Login">
          </form>
        <?php
          if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['username']) && isset($_POST['password'])) {
              $username = $_POST['username'];
              $password = $_POST['password'];
              if (!empty($username) && !empty($password) && !is_numeric($username)) {
                $sql = "select * from users where username = '$username' limit 1";
                $result = $conn->query($sql);
                if ($result) {
                  if ($result && mysqli_num_rows($result) > 0) {
                    $user_data = $result->fetch_assoc();
                    if ($user_data['password'] === $password) {
                      $_SESSION['user_id'] = $user_data['user_id'];
                      header("Location: ../HomePage/HomePage.php");
                    } else {
                      echo "<h2>Wrong username or password!</h2>";
                    }
                  }else {
                  echo "<h2>Wrong username or password!</h2>";
                } 
                }
              }
            }
          }
          ?>
        </div>
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
</body>

</html>