<?php
session_start(); // Start the PHP session

if (isset($_GET['code'])) {
    $tenantID = '';
    $clientID = '';
    $clientSecret = '';
    $redirectURI = 'http://localhost/entraid/redirect.php';
    $code = $_GET['code'];

    $tokenUrl = "https://login.microsoftonline.com/$tenantID/oauth2/v2.0/token";
    $tokenData = array(
        'client_id' => $clientID,
        'scope' => 'user.read',
        'code' => $code,
        'redirect_uri' => $redirectURI,
        'grant_type' => 'authorization_code',
        'client_secret' => $clientSecret
    );

    $options = array(
        'http' => array(
            'header' => "Content-Type: application/x-www-form-urlencoded",
            'method' => 'POST',
            'content' => http_build_query($tokenData)
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($tokenUrl, false, $context);

    if ($result === FALSE) {
        // Handle error
        exit('Token retrieval failed.');
    }

    $json = json_decode($result);

    if (isset($json->access_token)) {
        // Store the access token in the session
        $_SESSION['access_token'] = $json->access_token;

        // Redirect to the welcome page
        header("Location: welcome.php");
        exit;
    } else {
        // Handle error
        exit('Error retrieving access token.');
    }
} else {
    // Handle error
    exit('Authorization code not received.');
}
?>
