<?php

function getpercent($cid,$pid){
	include 'includes/dbb.php';
	$votes = mysqli_num_rows(mysqli_query($connect,"select * from votes where candidate_id='$cid' and position_id='$pid'"));
	$tvotes = mysqli_num_rows(mysqli_query($connect,"select * from votes where position_id='$pid'"));
	
	if($tvotes<=0){
		$answer =0;
	}
	else{
	$answer = $votes/$tvotes * 100;
	}
	return number_format($answer,2);
}