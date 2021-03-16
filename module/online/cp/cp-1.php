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
	$presentAge=$abp[0];;
	$pcp[0]=$presentAge+10;
	
// Solution
	if($solution=='Y')
	{
		echo '<h6>Answer</h6>';
		echo 'Age after 10 years='.$pcp[0].' years';		
	}
?>