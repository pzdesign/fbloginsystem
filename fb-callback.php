<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

# fb-callback.php

$fb = new Facebook\Facebook([
  'app_id' => '***',
  'app_secret' => '***',
  'default_graph_version' => 'v2.5',
]);


$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (isset($accessToken)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;

  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
  ?>
  <meta http-equiv="refresh" content="1;url=user.php">
  <?php
  //echo $_SESSION['facebook_access_token'];

}