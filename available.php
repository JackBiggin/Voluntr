<?php 
  session_start();
?>

<!doctype html>
<html lang="en" class="not-home">
  <head>
    <title>Find Volunteers</title>
    <link href="https://fonts.googleapis.com/css?family=K2D" rel="stylesheet">
    <link rel="icon" href="img/icon.png">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body class="not-home"> 

    <nav class="navbar navbar-expand-sm navbar-light bg-light" sticky-top>
      <a href="#" class="navbar-brand"><img class="nav-img" src="img/icon.png"></a>
      <div >
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="home.html">Home</a></li>
          <li class="nav-item login-button"><a class="nav-link" href="user_profile.php">My Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="profile.html">Enter Information</a></li>
          <li class="nav-item"><a class="nav-link" href="find.php">Create Event</a></li>
          <li class="nav-item login-button"><a class="nav-link" href="findEvents.php">Find Events</a></li>
          <li class="nav-item login-button"><a class="nav-link" href="vlogin.html">Login</a></li>
        </ul> 
      </div>   
    </nav>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
      
    

    <?php
      $host = 'localhost';
      $db   = 'voluntr';
      $dbuser = 'username';
      $pass = 'password';
      $charset = 'utf8mb4';

      $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
      $options = [
          PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES   => false,
      ];
      try {
          $pdo = new PDO($dsn, $dbuser, $pass, $options);
      } catch (\PDOException $e) {
          throw new \PDOException($e->getMessage(), (int)$e->getCode());
      }

      $stmt = $pdo->prepare("SELECT * FROM events WHERE eid = ? LIMIT 1");
      $stmt->execute([htmlspecialchars($_GET['eid'])]);

      $category = "";

      foreach ($stmt as $row)
      {
        $category = $row['category'];
      }

      $stmt = $pdo->prepare("SELECT * FROM user_interests WHERE interest = ?");
      $stmt->execute([$category]);

      $uids = "(";

      foreach ($stmt as $row)
      {
        $uids .= $row['uid'] . ", ";
      }

      $uids = substr($uids, 0, -2);

      $uids .= ")";

      $stmt = $pdo->prepare("SELECT * FROM users WHERE uid IN $uids");
      $stmt->execute();

      foreach ($stmt as $row) {
        $stmt2 = $pdo->prepare("SELECT * FROM user_times WHERE uid = ?");
        $stmt2->execute([$row['uid']]);

        $times = "";

        foreach ($stmt2 as $row2) {
          $times .= $row2['time'] . ", ";
        }

        $times = substr($times, 0, -2);

        echo '
        <div class="card">
            <h5 class="card-header"><img class="profile-pic" src="' . $row['profile_picture'] . '"/> ' . $row['fname'] . " " . $row['sname'] . '</h5>
            <div class="card-body">
              <p class="card-text">' . $row['location'] . '</p>
              <p class="card-text">' . $times . '</p>
              <a class="submit" href="./user_profile.php?uid=' . $row['uid'] . '">View Profile</a>
              <a class="submit" href="mailto:' . $row['email'] . '">Send Email</a>
            </div>
          </div><br />';
      }

    ?>

    </div>
    <br/ > <br />

    </div>
  </div>

    <div class="footer navbar-light foot">
      <div class="container" id="foot">
        <span>
          <p>Voluntr 2018</p>
        </span>
      </div>
        
    </div>

    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>