<?php
session_start();

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

$uid = $_SESSION['uid'];
$stmt = $pdo->prepare("DELETE FROM user_times WHERE uid = $uid");
$stmt->execute();

foreach ($_POST['show-availability'] as $item)
{
	$stmt = $pdo->prepare("INSERT INTO user_times (uid, time) VALUES (?, ?)");
	$stmt->execute([$_SESSION['uid'], $item]);
}

foreach ($_POST['category'] as $item)
{
	$stmt = $pdo->prepare("INSERT INTO user_interests (uid, interest) VALUES (?, ?)");
	$stmt->execute([$_SESSION['uid'], $item]);
}

header( 'Location: ./user_profile.php');