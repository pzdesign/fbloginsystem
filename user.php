<?php
require_once __DIR__ . '/vendor/autoload.php';

# login.php
session_start();
if(isset($_SESSION['facebook_access_token']))
{
	//check if users wants to logout
	 if(isset($_REQUEST['logout'])){
	 	unset($_SESSION['facebook_access_token']);
	 	header('Location: http://***/fblogin2/login.php');
	 }
$logout = 'http://***/fblogin2/login.php?logout=true';


	 $sess = $_SESSION['facebook_access_token'];
	 //check if facebook session exists
$fb = new Facebook\Facebook([
  'app_id' => '***',
  'app_secret' => '***',
  'default_graph_version' => 'v2.5',
]);

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,name,email', $sess);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}



$loggedin = true;
$user = $response->getGraphUser();

$id = $user['id'];
$name = $user['name'];
$email = $user['email'];

$image = 'https://graph.facebook.com/'.$id.'/picture?width=300';



// OR
// echo 'Name: ' . $user->getName();
	?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Facebook Login Demo</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<style>
	body{
		background:#f8f8f8;
	}
	.main-container{
		width:600px;
		margin:30px auto 0px;
		background:white;
		padding:30px;
	}
	.footer{
		background:#ecf0f1;
		padding:30px;
		color:#7f8c8d;
		width:600px;
		margin: 0px auto;
	}
	.img-thumbnail{
		display: block;
		position: relative;
		border: none;
		margin: 0 auto;
		width: 164px;
		border-radius: 100%;
		object-fit: cover;
	}
.media-body {
    display: table-cell;
    vertical-align: top;
    padding-left: 0px;
}

.media-left, .media-right {
    display: table-cell;
    vertical-align: top;
    padding-right: 10px;
}

	</style>
  </head>
  <body>
  	<div class="main-container">
  	<?php if(!$loggedin){ ?>
	    <h1>Demo Login!</h1>
	    <p>This is a demo login page used for the packetcode video tutorial. It pulls user's Id, Name and Profile Image.</p>
	    <a href="<?php echo $loginUrl; ?>"><button class="btn btn-block btn-success">Login with facebook</button></a>
    <?php }else { ?>

	    <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>" class="img-thumbnail">

	    	<h1 class="text-center"><b><?php echo $name; ?></b></h1>
	    	<p class="text-center">you have successfully logged in via facebook :) and your email is 
	    		<code><?php echo $email ; ?></code></p>
		
	    	<a href="<?php echo $logout; ?>">
	    		<button class="btn btn-block btn-primary">Logout</button>
	    	</a>	
		<?php include('read.php'); ?>
    <?php } ?>
	</div>
	<div class="footer text-center"><a href="http://patrik-zizka.cz">&copy; Patrik Žizka</a></div>
 

  </body>
</html>

<?php

}
else
{
	?>
  <meta http-equiv="refresh" content="1;url=login.php">
<?php

}
?>
