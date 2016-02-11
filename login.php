<?php
require_once __DIR__ . '/vendor/autoload.php';

# login.php
session_start();
	//check if users wants to logout
	 if(isset($_REQUEST['logout'])){
	 	unset($_SESSION['facebook_access_token']);
	 	header('Location: http://***/fblogin2/login.php');
	 }


$fb = new Facebook\Facebook([
  'app_id' => '***',
  'app_secret' => '***',
  'default_graph_version' => 'v2.5',
]);


$logout = 'http://***/fblogin2/login.php?logout=true';

	
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes']; // optional
$loginUrl = $helper->getLoginUrl('http://***/fblogin2/fb-callback.php', $permissions);


if(isset($_SESSION['facebook_access_token']))
{

$loggedin = true;

}
else
{
$loggedin = false;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Facebook Login</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<style>
	body{
		background:#f8f8f8;
	}
	.main-container{
		width:400px;
		margin:30px auto 0px;
		background:white;
		padding:30px;
	}
	.footer{
		background:#ecf0f1;
		padding:30px;
		color:#7f8c8d;
		width:400px;
		margin: 0px auto;
	}
	</style>
  </head>
  <body>
  	<div class="main-container text-center">
  	<?php if(!$loggedin){ ?>
	    <h1 >Facebook Login</h1>
	    	    <hr>

	    <a href="<?php echo $loginUrl; ?>"><button class="btn btn-lg btn-block btn-primary">Login with facebook</button></a>
    <?php }else { ?>
	
	    	<a href="<?php echo $logout; ?>">
	    		<button class="btn btn-primary">Logout</button>
	    	</a>	
		
    <?php } ?>
	</div>
	<div class="footer text-center"><a href="http://patrik-zizka.cz">&copy; Patrik Žizka</div> 

  </body>
</html>
