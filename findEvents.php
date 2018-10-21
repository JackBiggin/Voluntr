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
      <div class="find-box find-events"></div>
      <div class="main">
          <h3>Enter event information:</h3>
          <form action="./findEvents.php" method="get">
            <select class="form-control" name="category">
              <option value="educational">Educational</option>
              <option value="community">Community</option>
              <option value="Large Events">Large Events</option>
            </select> 
            <br>
            <br> 
            <input class="submit" id="submit" type="submit" value="Search"></input>
          </form>
        </div>
      <br/ > <br />

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

        if(!isset($_GET['category'])) {
          $stmt = $pdo->prepare("SELECT * FROM events");
          $stmt->execute();
        } else {
          $stmt = $pdo->prepare("SELECT * FROM events WHERE category = ?");
          $stmt->execute([htmlspecialchars($_GET['category'])]);
        }

        $results = [];

        foreach($stmt as $row) {
            $time = $row['time']; 
            $dt = new DateTime("@$time");

            $dt->setTimezone(new DateTimeZone('America/New_York'));

            $user_location = urlencode($_SESSION['location']);

            $api2 = file_get_contents("https://geocoder.api.here.com/6.2/geocode.json?searchtext=" . $user_location . "&app_id=e0sebt0gq7D5QJQsDtSv&app_code=1fqtmWy8S7eV9qPtA3sGzw");

            $api2 = json_decode($api2, true);

            $lat = $api2["Response"]["View"][0]["Result"][0]["Location"]["DisplayPosition"]["Latitude"];

            $long = $api2["Response"]["View"][0]["Result"][0]["Location"]["DisplayPosition"]["Longitude"];
            
            $waypoint0 = "geo!" . $lat . "," . $long;

            $api2 = file_get_contents("https://geocoder.api.here.com/6.2/geocode.json?searchtext=" . urlencode($row['location']) . "&app_id=e0sebt0gq7D5QJQsDtSv&app_code=1fqtmWy8S7eV9qPtA3sGzw");

            $api2 = json_decode($api2, true);

            $lat = $api2["Response"]["View"][0]["Result"][0]["Location"]["DisplayPosition"]["Latitude"];

            $long = $api2["Response"]["View"][0]["Result"][0]["Location"]["DisplayPosition"]["Longitude"];
            
            $waypoint1 = "geo!" . $lat . "," . $long;

            $api = file_get_contents("https://route.api.here.com/routing/7.2/calculateroute.json?waypoint0=" . urlencode($waypoint0) . "&waypoint1=" . urlencode($waypoint1) . "&mode=fastest%3Bcar%3Btraffic%3Aenabled&app_id=devportal-demo-20180625&app_code=9v2BkviRwi9Ot26kp2IysQ&departure=now");

            $api = json_decode($api, true);

            $distance = $api["response"]["route"][0]["summary"]["distance"];
            $distext = $api["response"]["route"][0]["summary"]["text"];
            $eid = $row['eid'];
            $card = '<div class="card">
            <h5 class="card-header">' . $row['name'] . '</h5>
            <div class="card-body">
              <p class="card-text">' . $dt->format('Y-m-d H:i:s') . '</p>
              <p class="card-text">' . $distext . '</p>
              <p class="card-test">'. $row['location'] .'</p>
              <p class="card-text">' . $row['description'] . "</p>
              <a href='available.php?eid=$eid' class='btn btn-primary'>Available Volunteers</a>
            </div>
          </div><br />";

          $results[$distance] = $card;
        }

        ksort($results);
        foreach($results as $result) {
          echo $result;
        }
        
      ?>
    </div>
  </div>

    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>