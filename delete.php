<?php
	require_once 'connectvars.php';
	$page_title='My Forum--Remove Comments';
	require_once 'header.php';
	require_once 'startsession.php'; 
	$error_msg='';
	if(isset($_SESSION['user_id'])){
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php
	$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);	
	if(isset($_POST['remove'])){
		$delete_list=$_POST['delete'];
		foreach($delete_list as $id){
			$tmp_query="DELETE FROM Message_board WHERE No=$id";
			mysqli_query($dbc,$tmp_query)
			or die('Remove Error!');
		}
		echo '<p>Message(s) has been removed!</p>';
	}
	$delete_query="SELECT * FROM Message_board";
	$result=mysqli_query($dbc,$delete_query);
	while($row=mysqli_fetch_array($result)){
		echo '<input type="checkbox" name="delete[]" value="'.$row['No'].'"/>';
		echo $row['No'].'&nbsp'.$row['Title'].'&nbsp'.$row['Time'].'<br />';
	}
?>
<input type="Submit" name="remove" value="Remove"/><br />
</form>
<?php 
	mysqli_close($dbc);
	}else{
		$error_msg='You don\'t have rights';
		$home_url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
		header('Location: '.$home_url);
		echo '<p class="error">'.$error_msg.'</p>';
	}
?>
<?php 
	require_once 'footer.php';
?>
