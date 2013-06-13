<?php
	require_once 'connectvars.php';
	$page_title='My Forum--Sign Up'; 
	require_once 'header.php';
	if(isset($_POST['submit'])){
		$username=addslashes(trim($_POST['username']));
		$password=addslashes(trim($_POST['password']));
		$retype=addslashes(trim($_POST['retype']));
		if(!empty($username) && !empty($password) && $password==$retype){
			$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
			$md_pwd=md5($password);
			$test_query="SELECT * FROM User_list WHERE Username=$username";
			$data=mysqli_query($dbc,$test_query);
			if(mysqli_num_rows($data)==0){
				$sign_query="INSERT INTO User_list(Username,Password,Date) VALUES ('$username','$md_pwd',NOW())";
				mysqli_query($dbc,$sign_query);
				echo '<p>Sign up Successfully!</p><a href="index.php">Welcome to My Space!</a>';
				mysqli_close($dbc);
				exit();
			}else{
				echo '<p class="error">An account already exists for this username. Please use a different username</p>';
				$username="";
			}
		}else{
			echo '<p class="error">You must enter all of the sign-up data, including the desired password twice.</p>';
		}
	}
	mysqli_close($dbc);
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<fieldset>
<legend>Registration Info.</legend>
<label>Username: </label>
<input type="text" name="username" id="username" value="<?php if(!empty($username)) echo $username;?>" /><br />
<label>Password: </label>
<input type="password" name="password" id="password" /><br />
<label>Retype: </label>
<input type="password" name="retype" id="password" /><br />
</fieldset>
<input type="submit" value="Sign_up" name="submit" /><br />
</form>
<?php 
	require_once 'footer.php';
?>