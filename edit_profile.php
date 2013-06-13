<?php
	require_once 'const_vars.php';
	require_once 'connectvars.php';
	$page_title='My Forum--Edit Profile';
	require_once 'header.php';
	require_once 'startsession.php';
	require_once 'navmenu.php';
	$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
	$user_id=$_SESSION['user_id'];
	$test_query="SELECT * FROM User_profile WHERE User_ID='$user_id'";
	$data=mysqli_query($dbc,$test_query);
	$row=mysqli_fetch_array($data);
	$firstname=$row['Firstname'];
	$lastname=$row['Lastname'];
	$gender=$row['Gender'];
	$birthday=$row['Birthday'];
	$email=$row['Email'];
	$mobile=$row['Mobile'];
	$school=$row['School'];
	$thumb_pic=$row['Pic'];
	if(mysqli_num_rows($data)==1){
		if(isset($_POST['submit'])){
			$new_firstname=addslashes(trim($_POST['firstname']));
			$new_lastname=addslashes(trim($_POST['lastname']));
			$new_gender=addslashes(trim($_POST['gender']));
			$new_birthday=addslashes(trim($_POST['birthday']));
			$new_email=addslashes(trim($_POST['email']));
			$new_mobile=addslashes(trim($_POST['mobile']));
			$new_school=addslashes(trim($_POST['school']));
			$new_thumb_pic=$_FILES['thumb']['name'];
			if(empty($new_thumb_pic)){
				$update_query="UPDATE User_profile SET Firstname='$new_firstname',".
						"Lastname='$new_lastname',Gender='$new_gender',Birthday='$new_birthday',".
						"Email='$new_email',Mobile='$new_mobile',School='$new_school' WHERE User_ID='$user_id'";
			}else{
				$target=IMAGE_PATH.$new_thumb_pic;
				move_uploaded_file($_FILES['thumb']['tmp_name'], $target);
				$update_query="UPDATE User_profile SET Firstname='$new_firstname',".
						"Lastname='$new_lastname',Gender='$new_gender',Birthday='$new_birthday',".
						"Email='$new_email',Mobile='$new_mobile',School='$new_school',Pic='$new_thumb_pic' WHERE User_ID='$user_id'";
			}
			echo $update_query;
			mysqli_query($dbc,$update_query);
			echo '<p class="msg">Update Successfully!</p><a href="profile_view.php">View Profile</a>';
			mysqli_close($dbc);
			exit();
		}
	}else{
		echo '<p class="error">Error!</p><a href="index.php">Go Back</a>';
		mysqli_close($dbc);
		exit();
	}
?>
<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<fieldset>
	<legend>Update Your Info.</legend>
	<label>Firstname: </label><input type="text" name="firstname" value="<?php if(!empty($firstname)) echo $firstname;?>" /><br />
	<label>Lastname: </label><input type="text" name="lastname" value="<?php if(!empty($lastname)) echo $lastname;?>" /><br />
	<label>Gender: </label><input type="radio" name="gender" value="0"/>Female&nbsp;&nbsp;<input type="radio" name="gender" value="1"/>Male<br />
	<label>Email: </label><input type="text" name="email" value="<?php if(!empty($email)) echo $email;?>" /><br />
	<label>Mobile: </label><input type="text" name="mobile" value="<?php if(!empty($mobile)) echo $mobile;?>" /><br />
	<label>Birthday: </label><input type="text" name="birthday" value="<?php if(!empty($birthday)) echo $birthday;?>" /><br />
	<label>School: </label><input type="text" name="school" value="<?php if(!empty($school)) echo $school;?>" /><br />
	<label>Thumb Pic: </label><input type="file" name="thumb" id="thumb"/><br />
</fieldset>
<input type="submit" name="submit" value="Save Profile" /><br />
</form>
<?php 
	require_once 'footer.php';
?>
