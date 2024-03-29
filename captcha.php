<?php
	session_start();
	//Define important CAPTCHA constants
	define('CAPTCHA_WIDTH',80);
	define('CAPTCHA_HEIGHT',20);
	define('CAPTCHA_NUMCHARS',4);
	$pass_phrase='';
	for($i=0;$i<CAPTCHA_NUMCHARS;$i++){
		$pass_phrase .= chr(rand(97,122));
	}
	$_SESSION['pass_phrase']=md5($pass_phrase);
	$img=imagecreatetruecolor(CAPTCHA_WIDTH, CAPTCHA_HEIGHT);
	$bg_color=imagecolorallocate($img, 255, 255, 255);
	$text_color=imagecolorallocate($img, 0, 0, 0);
	$graphic_color=imagecolorallocate($img,64,64,64);

	imagefilledrectangle($img, 0, 0, CAPTCHA_WIDTH, CAPTCHA_HEIGHT, $bg_color);
	for($i=0;$i<5;$i++){
		imageline($img,0,rand()%CAPTCHA_HEIGHT,CAPTCHA_WIDTH,rand()%CAPTCHA_HEIGHT,$graphic_color);
	}
	for($i=0;$i<50;$i++){
		imagesetpixel($img, rand()%CAPTCHA_WIDTH, rand()%CAPTCHA_HEIGHT, $graphic_color);
	}
	imagettftext($img, 18, 0, 5, CAPTCHA_HEIGHT-5, $text_color,'Courier New Bold.ttf', $pass_phrase);
	header("Content-type: image/png");
	imagepng($img);
	//Clean up
	imagedestroy($img);
?>
