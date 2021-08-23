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
	$d=$abp[0];		// diameter of pipe mm
	$t=$abp[1];		// Thickness of pipe mm
	$L=$abp[2];		// Length of the pipe m
	$rogCI=70;		// weight density of CI kN/m3 
	$rogW=9.81;		// weight density of water kN/m3 
	
	$od=$d+2*$t;
	
//	echo "t=$t";

	$volCI=(pi()/4)*($od*$od-$d*$d)*$L*1000;		// mm3
	$wCI=($rogCI*$volCI)/($L*1000000000);			// N/mm

	$volW=(pi()/4)*($d*$d)*$L*1000;					// mm3
	$wW=($rogW*$volW)/($L*1000000000);				// N/mm 10^6 used to convert kN/m3 into N/mm3

	$ymax=$od/2;
	
//	echo "ymax=$ymax";
	
	$I=(pi()/64)*(pow($od,4)-pow($d,4));
	
//	echo "I=$I";
	
	$Z=($I/$ymax);
	
	$udl=$wCI+$wW;

	$pcp[0]=round($udl,3);
	$pcp[1]=round($Z,2);

	$maxBM=($udl*$L*$L*1000000)/8;
	$pcp[2]=round($maxBM,2);
	
	$sigmaMax=$maxBM/$Z;
	$pcp[3]=round($sigmaMax,2);
	

// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>udl</td><td>'.$pcp[0].' kN/m</td></tr>';
		echo '<tr><td>Section Modulus</td><td>'.$pcp[1].' mm<sup>3</sup></td></tr>';
		echo '<tr><td>Max Bending Moment</td><td>'.$pcp[2].' N.mm</td></tr>';
		echo '<tr><td>Max Bending Stress in Tension</td><td>'.$pcp[3].' MPa</td></tr>';
		echo '</table>';
	}
?>