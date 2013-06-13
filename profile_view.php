<?php
	require_once 'const_vars.php';
	require_once 'connectvars.php';
	$page_title='My Forum--Profile View';
	require_once 'header.php';
	require_once 'startsession.php';
	require_once 'navmenu.php';
	$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
	$user_id=$_SESSION['user_id'];
	$query="SELECT * FROM User_profile WHERE User_ID='$user_id'";
	$data=mysqli_query($dbc,$query);
	if(mysqli_num_rows($data) == 1){
		$row=mysqli_fetch_array($data);
		$firstname=$row['Firstname'];
		$lastname=$row['Lastname'];
		$gender=$row['Gender']?'Male':'Female';
		$email=$row['Email'];
		$mobile=$row['Mobile'];
		$school=$row['School'];
		$birthday=$row['Birthday'];
		$thumb_pic=$row['Pic'];
		mysqli_close($dbc);
	}else{
		echo '<p class="error">Error!</p><a href="index.php">Go Back</a>';
		mysqli_close($dbc);
		exit();		
	}
?>
<div id="info">
	<div id="profile">
	<p>
	<label>Firstname:</label><?php echo $firstname;?><br />
	<label>Lastname:</label><?php echo $lastname;?><br />
	<label>Gender:</label><?php echo $gender;?><br />
	<label>Birthday:</label><?php echo $birthday;?><br />
	<label>E-mail:</label><?php echo $email;?><br />
	<label>Mobile:</label><?php echo $mobile;?><br />
	<label>School:</label><?php echo $school?><br />
	</p>
	</div>
	<div id="thumb">
	<p>
	<img alt="thumb pic" width="60" height="80" src="
	<?php 
		if(is_file(IMAGE_PATH.$thumb_pic) && filesize(IMAGE_PATH.$thumb_pic)){
			echo IMAGE_PATH.$thumb_pic;		
		}else{
			echo IMAGE_PATH.'undefined.jpg';
		}	
	?>
	"/>
	</p>
	</div>
</div>

<?php 
	require_once 'footer.php';
?>
