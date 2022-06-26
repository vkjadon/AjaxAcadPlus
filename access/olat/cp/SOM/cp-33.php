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
	$F=$abp[0];
	$theta=$abp[1];
	$angle=(pi()/180)*$theta;
	$OD=(8/cos($angle));
	$BDdash=(1/tan(0.5*pi()-$angle));
	$pcp[0]=round(($OD+$BDdash),2);	
	$pcp[1]=$F*8;	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>OD</td><td>'.$OD.' mm</td></tr>';
		echo '<tr><td>BDdash</td><td>'.$BDdash.' mm</td></tr>';
		echo '<tr><td>x</td><td>'.$pcp[0].' mm</td></tr>';
		echo '<tr><td>Maximum Moment about O due to F</td><td>'.$pcp[1].' kN.m</td></tr>';
		echo '</table>';
	}
?>