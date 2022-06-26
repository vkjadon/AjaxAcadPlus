<?php
/*
	$abp[0] for parameter-1
	$abp[1] for parameter-2
	...... and so on ....
  $pcp[0] for first check point answer
  $pcp[1] for second check point answer
  ..... and so on ....
*/
	// $abp[0] represents present age
	$pcp[0]=$abp[0]+12;
	
// Solution [This is an optional block]
	if($solution=='Y')
	{
		echo '<h6>Answer</h6>';
		echo 'Age after 12 yearrs ='.$pcp[0].' years';		// Change this as per question
	}
