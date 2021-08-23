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
	$k_AB=$abp[0];		// kN/m
	$k_CD=$abp[1];		// kN/m
	$w=$abp[2];			// N/m
	$Dy=0.5*$w;
	$By=$w;
	$delB=round($By/(1000*$k_AB),3);
	$delD=round($Dy/(1000*$k_CD),3);
	if($delB>$delD)$theta=atan(($delB-$delD)/6);			//	rad
	else $theta=atan(($delD-$delB)/6);			//	rad
	$angle=(180/pi())*$theta;	// degree
	$pcp[0]=round($angle,2);	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>By</td><td>'.$By.' N</td></tr>';
		echo '<tr><td>Dy</td><td>'.$Dy.' N</td></tr>';
		echo '<tr><td>delB</td><td>'.$delB.' m</td></tr>';
		echo '<tr><td>delD</td><td>'.$delD.' m</td></tr>';
		echo '<tr><td>Angle of BD with Horizontal</td><td>'.$pcp[0].' deg</td></tr>';
		echo '</table>';
	}
?>