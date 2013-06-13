<?php
	require_once 'connectvars.php';
	$page_title='My Forum--Log In';
	require 'header.php';
	require_once 'startsession.php';
	$error_msg='';
	if(!isset($_SESSION['user_id'])){
		if(isset($_POST['submit'])){
			//Connect to Database
			$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
			$user_username=addslashes(trim($_POST['username']));
			$user_password=addslashes(trim($_POST['password']));
			
			if(!empty($user_username) && !empty($user_password)){
				$query="SELECT * FROM User_list WHERE Username='$user_username'"
						."and Password='".md5($user_password)."'";
				$data=mysqli_query($dbc,$query);
				if(mysqli_num_rows($data)==1){
					//Login Successfully
					$row=mysqli_fetch_array($data);
					//Cookie expires after a week
					setcookie('user_id',$row['No'],time()+3600*24*7);
					setcookie('username',$row['Username'],time()+3600*24*7);
					$_SESSION['user_id']=$row['No'];
					$_SESSION['username']=$row['Username'];
					$home_url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
					header('Location: '.$home_url);
				}else{
					//username or password is incorrect
					$error_msg='Sorry, you must enter a valid username and password to log in';
				}
			}else{
				$error_msg='Sorry, you must enter your username and password to log in';
			}
		}
	}
?>

<?php 
	if(empty($_SESSION['user_id'])){
		echo '<p class="error">'.$error_msg.'</p>';
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<fieldset>
<legend>Log In</legend>
<label>Username:</label><input type="text" name="username" value="<?php if(!empty($user_username)) echo $user_username;?>" /><br/>
<label>Password:</label><input type="password" name="password" value="" /><br/>
</fieldset>
<input type="submit" name="submit" value="Log in" />
</form>
<?php 
	}else{
		echo '<p class="login">You are logged in as '.$_COOKIE['username'].'.</p>';
	}
	require_once 'footer.php';
?>