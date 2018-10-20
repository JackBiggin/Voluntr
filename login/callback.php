<?php
session_start();

require '../vendor/autoload.php';

$provider = new League\OAuth2\Client\Provider\LinkedIn([
    'clientId'          => '86e5b0th5ny7ya',
    'clientSecret'      => '11YUPalMcW1QIsta',
    'redirectUri'       => 'http://localhost/Voluntr/Voluntr/login/callback.php',
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $user = $provider->getResourceOwner($token);

        // Use these details to create a new profile
        echo $user->getFirstname() . "<br />";



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

        $userData = [
            'fname' => $user->getFirstname(),
            'sname' => $user->getLastName(),
            'auth_token' => $token->getToken(),
            'auth_token_expiry' => $token->getExpires(),
            'refresh_token' => $token->getRefreshToken(),
            'profile_picture' => $user->getImageUrl(),
            'linkedin_id' => $user->getId(),
            'location' => $user->getLocation(),
            'headline' => $user->getDescription(),
            'email' => $user->getEmail()
        ];

        // Get user for that linkedin user id
        $stmt = $pdo->prepare('SELECT * FROM users WHERE linkedin_id = ?');
        $stmt->execute([$userData['linkedin_id']]);

        foreach($stmt as $row) {
            $user_exists = true;
        }
    
        if(!$user_exists) {
            $insstmt = $pdo->prepare('INSERT INTO users (fname, sname, auth_token, auth_token_expiry, refresh_token, profile_picture, location, linkedin_id, linkedin_headline, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $insstmt->execute([$userData['fname'], $userData['sname'], $userData['auth_token'], $userData['auth_token_expiry'], 'todo', $userData['profile_picture'], $userData['location'], $userData['linkedin_id'], $userData['headline'], $userData['email']]);
    
        }

        $stmt = $pdo->prepare('SELECT `uid` from users WHERE linkedin_id = ?');
        $stmt->execute([$userData['linkedin_id']]);

        foreach($stmt as $row) {
            $userData['uid'] = $row['uid'];
        }

        $_SESSION = $userData;

    } catch (Exception $e) {

        // Failed to get user details
        exit('Oh dear...' . $e);
    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();
}
