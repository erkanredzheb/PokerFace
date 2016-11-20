<?php

echo "<!DOCTYPE html>";
echo "<html>";
	echo "<head>";
		echo "<title>CTMS PRs</title>";
		echo "<link rel='stylesheet' type='text/css' href='./style.css'>";
		echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>";
		echo "<script src='http://code.jquery.com/ui/1.9.2/jquery-ui.js'></script>";
		echo "<script type='text/javascript' src='./scripts.js'></script>";
	echo "</head>";
	echo "<body>";
		//echo "<input id='upload_img_button' type='file' onchange='process_image(this)'></input>";
		echo "<input id='upload_img_url' placeholder='URL to image...'></input>";
		echo "<div id='upload_img' onclick='get_averages()'>SUBMIT</div>";

		echo "<img id='uploaded_image' src='./images/transparent.png'></img>";

		echo "<div id='averages_returned'></div>";

	echo "</body>";
echo "</html>";