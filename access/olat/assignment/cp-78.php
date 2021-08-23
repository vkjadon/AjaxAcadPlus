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
	$w=$abp[0];		// kN/m
	$W=$abp[1];		// kN
	
	$V=$w*1.5;

	$Mx=$w*4*2+$W*1;
	
	$pcp[0]=round($V,2);
	$pcp[1]=round($Mx,2);
	
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>SF at x= 1.5 m</td><td>'.$pcp[0].' kN</td></tr>';
		echo '<tr><td>BM at x=2 m</td><td>'.$pcp[1].' kNm</td></tr>';
		echo '</table>';
	}
?>