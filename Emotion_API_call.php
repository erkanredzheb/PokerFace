<?php

$BLUFF_MEAN_FEAR = 0.000093081;	//0.2469496680909317;
$BLUFF_MEAN_SAD = 0.13462548543;//0.0756548189266667;
$BLUFF_MEAN_NEUTRAL = 0.86334506666;//0.8749552065;

$NORMAL_MEAN_FEAR = 0.00000330861;//2.791452335132883;
$NORMAL_MEAN_SAD = 0.00451451772;//0.005987708977;
$NORMAL_MEAN_NEUTRAL = 0.9869037;//0.6841451302848;

$image_url = $_POST['path'];

$authToken = 'randomaccesstoken';
$postData = array('url' => $image_url);

// Create the context for the request
$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header' => "Authorization: {$authToken}\r\n".
        			"Ocp-Apim-Subscription-Key: 27b7b98eea7a46d3af34335563e34d05\r\n".
                    "Content-Type: application/json\r\n",
        'content' => json_encode($postData)
    )
));

$response = file_get_contents('https://api.projectoxford.ai/emotion/v1.0/recognize', FALSE, $context);

if($response === FALSE){
    die('Error');
}

$responseData = json_decode($response, TRUE);
$first_face = $responseData[0];
$scores = $first_face['scores'];

$averages = array();
array_push($averages, $scores['fear'], $scores['sadness'], $scores['neutral']);

echo "FEAR: ".$averages[0]."<br>";
echo "SADNESS: ".$averages[1]."<br>";
echo "NEUTRAL: ".$averages[2]."<br>";


$diff_bluff_fear = abs($BLUFF_MEAN_FEAR - $averages[0]);
$diff_normal_fear = abs($NORMAL_MEAN_FEAR - $averages[0]);
$bluffing_by_fear = ($diff_bluff_fear < $diff_normal_fear) ? true : false;

if ($bluffing_by_fear){
	echo "FEAR: TRUE<br>";
}
else{
	echo "FEAR: FALSE<br>";
}

$diff_bluff_sad = abs($BLUFF_MEAN_SAD - $averages[1]);
$diff_normal_sad = abs($NORMAL_MEAN_SAD - $averages[1]);
$bluffing_by_sad = ($diff_bluff_sad < $diff_normal_sad) ? true : false;

if ($bluffing_by_sad){
	echo "SAD: TRUE<br>";
}
else{
	echo "SAD: FALSE<br>";
}

$diff_bluff_neutral = abs($BLUFF_MEAN_NEUTRAL - $averages[2]);
$diff_normal_neutral = abs($NORMAL_MEAN_NEUTRAL - $averages[2]);
$bluffing_by_neutral = ($diff_bluff_neutral < $diff_normal_neutral) ? true : false;

if ($bluffing_by_neutral){
	echo "NEUTRAL: TRUE<br>";
}
else{
	echo "NEUTRAL: FALSE<br>";
}

if ($bluffing_by_fear && !$bluffing_by_sad && !$bluffing_by_neutral){
	$random_2 = $diff_normal_sad;
	$random_3 = $diff_normal_neutral;

	$random_combined = $random_2 + $random_3;

	$bluffing = ($diff_bluff_fear < $random_combined) ? true : false;

	echo "HERE 1<br>";
}
else if (!$bluffing_by_fear && $bluffing_by_sad && $bluffing_by_neutral){
	$random_2 = $diff_bluff_sad;
	$random_3 = $diff_bluff_neutral;

	$random_combined = $random_2 + $random_3;

	$bluffing = ($diff_normal_fear < $random_combined) ? false : true;

	echo "HERE 2<br>";
}
else{
	$bluffing = ($bluffing_by_fear && ($bluffing_by_sad || $bluffing_by_neutral)) ? true : false;

	echo "HERE 3<br>";
}

if ($bluffing){
	echo "BLUFF";
}
else{
	echo "NORMAL";
}



