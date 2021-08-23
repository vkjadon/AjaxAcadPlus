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
	$F=$abp[0];		// kN
	$pcp[0]=$F;
	$pcp[1]=$F/sin(pi()/4);
	$pcp[2]=0;	
// Solution
?>