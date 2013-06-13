<?php
	echo '<ul>';
	if(isset($_SESSION['user_id'])){
		echo '<li><a href="profile_view.php">View Profile</a></li>';
		echo '<li><a href="edit_profile.php">Edit Profile</a></li>';
		echo '<li><a href="index.php">Home</a></li>';
		echo '<li><a href="logout.php">Log Out ('.$_SESSION['username'].')</a></li>';
	}else{
		echo '<li><a href="login.php">Log In</a></li>';
		echo '<li><a href="sign_up.php">Sign Up</a></li>';
	}
?>