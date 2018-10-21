<?php
  session_start();

  if (!isset($_SESSION['uid']))
  {
    header( 'Location: ./vlogin.html');
    exit;
  }
?>

<!doctype html>
<html lang="en" class="not-home">
  <head>
    <title>Create Event</title>
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
    <div class="container find-box">
      <div class="main">
        <h3>Enter event information:</h3>
          <form class="form" action="./submitEvent.php" method="POST">
            <div class="fields">
              <div>
                <label>Event Name:</label>
                <input type="text" name="event-name" placeholder="Enter event name">
              </div>
              <div>
                <label>Event Location:</label>
                <input type="text" name="location" placeholder="Enter location">
              </div>
              <div>
                <label>Start Time:</label>
                <input type="time" name="start-time">
              </div>
              <div>
                <label>Date:</label>
                <input type="date" name="date">
              </div>
              <label>Category:</label>
              <select name="category">
                <option value="Educational">Educational</option>
                <option value="Community">Community</option>
                <option value="Large Events">Large Events</option>
              </select> 
              <div>
                <label>Description:</label>
                <textarea name="description"></textarea> 
              </div>
            </div>
            <br>
            <input type="submit" name="search" 
            value="Create Event" id="submit" class="submit">
          </form>


      </div>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>