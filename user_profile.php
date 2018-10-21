<?php
  session_start();

  if (isset($_GET['uid']))
  {
    $uid = htmlspecialchars($_GET['uid']);
  }
  else
  {
    if (isset($_SESSION['uid']))
    {
      $uid = $_SESSION['uid'];
    }
    else
    {
      header( 'Location: ./vlogin.html');
    }
  }

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

  $stmt = $pdo->prepare("SELECT * FROM users WHERE uid = ? LIMIT 1");
  $stmt->execute([$uid]);
  
  $userData = [];

  foreach($stmt as $row) {
    $userData['uid'] = $row['uid'];
    $userData['fname'] = $row['fname'];
    $userData['sname'] = $row['sname'];
    $userData['profile_picture'] = $row['profile_picture'];
    $userData['location'] = $row['location'];
    $userData['headline'] = $row['linkedin_headline'];
  }

  $stmt = $pdo->prepare("SELECT * FROM user_times WHERE uid = ?");
  $stmt->execute([$uid]);

  $times = "";

  foreach($stmt as $row) {
    $times .= $row['time'] . ", ";
  }

  $times = substr($times, 0, -2);

  $stmt = $pdo->prepare("SELECT * FROM user_interests WHERE uid = ?");
  $stmt->execute([$uid]);

  $interests = "";

  foreach($stmt as $row) {
    $interests .= $row['interest'] . ", ";
  }

  $interests = substr($interests, 0, -2);
?>

<!doctype html>
<html lang="en">
  <head>
    <title>User Profile</title>
    <link href="https://fonts.googleapis.com/css?family=K2D" rel="stylesheet">
    <link rel="icon" href="img/icon.png">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body> 


    <nav class="navbar navbar-expand-sm navbar-light bg-light" sticky-top>
      <a href="#" class="navbar-brand"><img class="nav-img" src="img/icon.png"></a>
      <div >
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="home.html">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="profile.html">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="find.php">Find Volunteers</a></li>
          <li class="nav-item login-button"><a class="nav-link" href="findEvents.php">Find Events</a></li>
          <li class="nav-item login-button"><a class="nav-link" href="vlogin.html">Login</a></li>

        </ul> 
      </div>   
    </nav>
    
    <div class="container">
      <h1>My Profile</h1>
      <img src="<?php echo $userData['profile_picture'] ?>">
      <h2>Name: <?php echo $userData['fname'] . " " . $userData['sname'] ?></h2>
      <h2>Location: <?php echo $userData['location'] ?></h2>
      <div class="row">
        <div class="col-12 col-md-6">
          <h2>Times Available: <?php echo $times ?></h2>
        </div>
        <div class="col-12 col-md-6">
          <h2>Interests: <?php echo $interests ?></h2>
        </div>
      </div>
    </div>

    <div class="footer navbar-light">
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