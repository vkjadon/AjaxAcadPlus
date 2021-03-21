<?php
//	echo "Start ";
/*
	use $abp[0] for parameter-1
	use $abp[1] for parameter-2
	...... and so on....

For Design Type Problems

	use $abap[0] for Assumed parameter-1
	use $abap[1] for Assumed parameter-2
	...... and so on....

To inclue standard file
	require("../standard/shaft-diameters.php");
*/
	$pcp[0]=$abp[0]*$abp[1];
	
// Solution
	if($solution=='Y')
	{
		echo '<h6>Answer</h6>';
		echo 'Distance Travelled in km='.$pcp[0].' km';		
	}
