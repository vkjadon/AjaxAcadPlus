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
	$T=$abp[0];
	$W=$abp[1];
	$pcp[0]=round(-$abp[0]*0.7071*20,2);	
	$pcp[1]=round($abp[1]*16,2);	
	$pcp[2]=$pcp[1]+$pcp[0];	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>M about B due to T</td><td>'.$pcp[0].' kN.m</td></tr>';
		echo '<tr><td>M about B due to W</td><td>'.$pcp[1].' kN.m</td></tr>';
		echo '<tr><td>M about B </td><td>'.$pcp[2].' kN.m</td></tr>';
		echo '</table>';
	}
?>