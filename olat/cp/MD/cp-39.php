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
	$SigmaD=$abap[0];

	$EqBM=sqrt($MaxBM*$MaxBM+0.75*$MaxTM*$MaxTM);

//	echo "Max BM $MaxBM Max TM $MaxTM";
	$var=(32*$EqBM)/(pi()*$SigmaD);
	$shaft_diameter=pow($var,(1/3));
	require("../standard/shaft-diameters.php");
		
	$pcp[0]=$shaft_diameter;
	$pcp[1]=round((16*$MaxTM/(pi()*pow($shaft_diameter,3))),2);
	$pcp[2]=round((32*$MaxBM/(pi()*pow($shaft_diameter,3))),2);
	$pcp[3]=round($EqBM/1000,2);
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Shaft Diameter</td><td>'.$pcp[0].' mm</td></tr>';
		echo '<tr><td>Maximum Shear Stress</td><td>'.$pcp[1].' MPa</td></tr>';
		echo '<tr><td>Maximum Normal Stress</td><td>'.$pcp[2].' N.m</td></tr>';
		echo '<tr><td>Equivalent Bending Moment</td><td>'.$pcp[3].' N.m</td></tr>';
		echo '</table>';
	}

?>