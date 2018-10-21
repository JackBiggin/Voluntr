<?php
session_start();

$date = strtotime($_POST['start-time'] . " " . $_POST['date']);

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

$stmt = $pdo->prepare("INSERT INTO events (name, location, time, category, description, uid) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$_POST['event-name'], $_POST['location'], $date, $_POST['category'], $_POST['description'], $_SESSION['uid']]);

header( 'Location: ./findEvents.php');