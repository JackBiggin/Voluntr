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
          <li class="nav-item"><a class="nav-link" href="profile.html">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="find.html">Find Volunteers</a></li>
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
          <select class="form-control">
            <option value="educational">Educational</option>
            <option value="community">Community</option>
            <option value="large">Large Events</option>
          </select> 
          <br>
          <br> 
          <a href="#" class="submit" id="submit">Search</a>
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


        foreach($stmt as $row) {
            echo '<div class="card">
            <h5 class="card-header">' . $row['name'] . '</h5>
            <div class="card-body">
              <h5 class="card-title">Special title treatment</h5>
              <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
          </div><br />';
        }

      ?>
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