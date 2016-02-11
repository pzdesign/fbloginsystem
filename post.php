<?php
require_once __DIR__ . '/vendor/autoload.php';

# login.php
session_start();

$appid = '***';
$app_secret = '***';
$accesstoken = '***';
$pageid = '***';
$fb = new Facebook\Facebook([
  'app_id' => $appid,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.5',
]);

// Send the request to Graph
try {

$response = $fb->get('/me/feed', $accesstoken);

} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$graphEdge = $response->getGraphEdge();



// Iterate over all the GraphNode's returned from the edge
foreach ($graphEdge as $key => $graphNode) {
	$story = $graphNode['story'];
	$message = $graphNode['message'];
	if($story == null)
	{echo $message.'<br>';}
	else{echo $story.'<br>';}

}
