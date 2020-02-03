<?php
session_start();

//Include Google client library
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '518287848645-r4ttvucumk2vpimkvdfrsm46aqbge1i6.apps.googleusercontent.com'; //Google client ID
$clientSecret = 'Yk2XuyDWgt2yoUp0rCOk8jWZ'; //Google client secret
$redirectURL = 'http://localhost:8080/employee_login/google_login_api_HRWNdR/'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to CodexWorld.com');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>
