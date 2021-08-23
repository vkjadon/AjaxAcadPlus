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
	$t=$abp[0];		// thickness mm
	$b=$abp[1];		// witdth mm
	$R=$abp[2]/2;		// radius, mm
	$E=200000;		// GPa to MPa
	$sigmaT=($E/$R)*($t/2);

	$pcp[0]=round($sigmaT,2);
	
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Max Tensile Stress</td><td>'.$pcp[0].' MPa</td></tr>';
		echo '</table>';
	}
?>