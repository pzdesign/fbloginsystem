<?php
require_once __DIR__ . '/vendor/autoload.php';

# login.php
session_start();
if(isset($_SESSION['facebook_access_token']))
{


$appid = '***';
$app_secret = '***';
$token = '***';

$fields = '/***/posts?fields=story,message,comments,created_time';
$fields2 = '/***';

$expires = time() + 60 * 60 * 2;
$accessToken = new Facebook\Authentication\AccessToken($token, $expires);

$fb = new Facebook\Facebook([
  'app_id' => $appid,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.5',
]);



// Send the request to Graph
try {

$response = $fb->get($fields , $accessToken);

$response2 = $fb->get($fields2 , $accessToken);

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

$object = $response2->getGraphObject();

$id = $object['id'];
$name = $object['name'];
$image2 = 'https://graph.facebook.com/'.$id.'/picture?width=64';



$count = 1;
// Iterate over all the GraphNode's returned from the edge
foreach ($graphEdge as $key => $post) {
	$story    = $post['story'];
	$message  = $post['message'];
	$comments = $post['comments'];
	$created_time = $post['created_time'];


?>
<div class="media">
<div class="media-left"> 

<img class="media-object" alt="64x64" src="<?= $image2;?>" data-holder-rendered="true"> 

</div> 
<div class="media-body"> 
<h4 class="media-heading"><?= $name; ?></h4> 
<?php
	if($story == null)
	{echo $message.'<br>';}
	else{echo $story.'<br>';}
		if(!empty($comments)){
			foreach ($comments as $key2 => $comment) {
				$image_com = 'https://graph.facebook.com/'.$comment['from']['id'].'/picture?width=32';
?>

<!-- comments !-->
<div class="media">
<div class="media-left"> 

<img class="media-object" alt="64x64" src="<?= $image_com;?>" data-holder-rendered="true"> 

</div> 
<div class="media-body"> 
<h4 class="media-heading"><?= $comment['from']['name']; ?></h4> 
<?= $comment['message']; ?>
</div> 
</div>
<?php
}
}
?>
<!--end!-->
</div> 
</div>
<?php

}

}
else
{
	?>
  <meta http-equiv="refresh" content="1;url=login.php">
<?php
}
?>


