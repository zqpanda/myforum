<?php
	$page_title='Welcome to My Forum'; 
	require_once 'header.php';
	require_once 'connectvars.php';
	require_once 'startsession.php';
	require_once 'navmenu.php';

	$dbc=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
	$show=false;
	if(isset($_SESSION['username'])){
		$show=true;
		$author=$_SESSION['username'];
		if(isset($_POST['submit'])){
			$title=$_POST['title'];
			$content=$_POST['content'];
			$user_pass_phrase=md5($_POST['verify']);
		
			if(empty($title) || empty($content)){
				echo '<p class="error">You forgot input title(or content), please try again</p>';
			}
		
		
			if($user_pass_phrase==$_SESSION['pass_phrase']){
				if(!empty($title) && !empty($content)){
					$show=true;
					$query="INSERT INTO Message_board (Title,Content,Author,Time) VALUES ('$title','$content','$author',NOW())";
					mysqli_query($dbc,$query);
					echo '<p class="msg">Submit Successfully!</p>';
				}
			}else{
				$show=true;
				echo '<p class="error">Wrong Verificaion Chars</p>';
			}
		}
	}
	
	function generate_links($cur_page,$num_pages){
		//Return Pages Links
		$page_links='';
		if($cur_page > 1){
			$page_links .= '<a href="'.$_SERVER['PHP_SELF'].'?page='.($cur_page-1).'"><--</a> ';
		}else{
			$page_links .='<--';
		}
		for($i=1;$i<=$num_pages;$i++){
			if($cur_page == $i){
				$page_links .= ' '.$i.' ';
			}else{
				$page_links .= ' <a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.'</a> ';
			}
		}
		if($cur_page < $num_pages){
			$page_links .= '<a href="'.$_SERVER['PHP_SELF'].'?page='.($cur_page+1).'">--></a>';
		}else{
			$page_links .= '-->';
		}
		return $page_links;
	}
?>
<?php if($show){?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<fieldset>
<legend>Submit Your Comment</legend>
<label>Title:</label><br />
<input type="text" id="title" name="title" size="30" value="<?php echo $title;?>"/><br />
<label>Content:</label><br />
<textarea id="content" name="content" cols="40"></textarea><br />
<p><input type="text" id="verify" name="verify" value="Enter the pass-phrase"/>
<img src="captcha.php" alt="Velidation Pic"/></p>
<input type="submit" value="Submit" name="submit" value="<?php echo $content;?>"/><br />
</fieldset>
</form>
<?php 
	}
	$select_query="SELECT * FROM Message_board";
	$result=mysqli_query($dbc,$select_query)
	or die("Query Error!");
	$results_per_page=5;
	$cur_page=isset($_GET['page'])?$_GET['page']:1;
	$skip=($cur_page-1)*$results_per_page;
	$total=mysqli_num_rows($result);
	$num_pages=ceil($total/$results_per_page);
	$quick_query="SELECT * FROM Message_board LIMIT $skip, $results_per_page";
	$tmp_result=mysqli_query($dbc,$quick_query);
	echo '<div id="comment"><table><tr><th>NO</th><th>Title</th><th>Message</th><th>Author</th><th>Time</th></tr>';
	while($row=mysqli_fetch_array($tmp_result)){
		echo '<tr><td>'.$row['No'].'</td>';
		echo '<td>'.$row['Title'].'</td>';
		echo '<td>'.$row['Content'].'</td>';
		echo '<td>'.$row['Author'].'</td>';
		echo '<td>'.$row['Time'].'</td></tr>';
	}
	echo '</table>';
	if($num_pages>1){
		echo generate_links($cur_page, $num_pages);
	}
	echo '</div>';
	mysqli_close($dbc); 
	require_once 'footer.php';
?>
