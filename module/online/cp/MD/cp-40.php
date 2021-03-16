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
	$MaxBM=$abp[0]*1000*1000;		// N.mm
	$MaxTM=$abp[1]*1000*1000;		// N.mm
	$TauD=$abp[2];
	$SigmaD=$abp[3];
	$cm=1.5; 
	$ct=1.0;
	$EqTM=sqrt(pow($cm*$MaxBM,2)+0.75*pow($ct*$MaxTM,2));

//	echo "Max BM $MaxBM Max TM $MaxTM";
	$ke=1.0;
	$var=(32*16*$EqTM)/(pi()*$ke*$SigmaD*15);
	$shaft_diameter=pow($var,(1/3));
	require("../standard/shaft-diameters.php");
	
	$pcp[1]=$shaft_diameter;
	$pcp[0]=0.5*$shaft_diameter;
	$val=(32*16*$EqTM)/(15*pi()*pow($shaft_diameter,3));
	$pcp[2]=round($val,2);
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Shaft Inner Diameter</td><td>'.$pcp[0].' mm</td></tr>';
		echo '<tr><td>Shaft Outer Diameter</td><td>'.$pcp[1].' mm</td></tr>';
		echo '<tr><td>Maximum Shear Stress</td><td>'.$pcp[2].' MPa</td></tr>';
		echo '</table>';
	}

?>