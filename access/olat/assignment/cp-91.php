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
	$h=$abp[0];		// depth mm
	$L=$abp[1]*1000;		// Length mm
	$sigmaMax=$abp[2];		// MPa
	$I=100000000;		// about NA in mm4
	$ymax=$h/2;
	$Z=($I/$ymax);
	$pcp[0]=round($Z,2);
	$udl=8*$sigmaMax*$Z/($L*$L);
	$pcp[1]=round($udl,2);
	$maxBM=($udl*$L*$L)/8;
	$pcp[2]=round($maxBM,2);
	
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Section Modulus</td><td>'.$pcp[0].' mm<sup>3</sup></td></tr>';
		echo '<tr><td>udl</td><td>'.$pcp[1].' kN/m</td></tr>';
		echo '<tr><td>Max Bending Moment</td><td>'.$pcp[2].' N.mm</td></tr>';
		echo '</table>';
	}
?>