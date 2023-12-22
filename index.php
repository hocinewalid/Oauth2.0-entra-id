<?php
// Microsoft OAuth URL and your application's redirect URI
$tenantID = '';
$clientID = '';
$redirectURI = urlencode('http://localhost/entraid/redirect.php');

$oauthUrl = "https://login.microsoftonline.com/$tenantID/oauth2/v2.0/authorize?" .
    "client_id=$clientID&" .
    "response_type=code&" .
    "redirect_uri=$redirectURI&" .
    "scope=user.read&" .
    "response_mode=query";

// Redirect to Microsoft OAuth URL
header("Location: $oauthUrl");
exit;
?>
