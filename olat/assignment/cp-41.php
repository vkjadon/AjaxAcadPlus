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
	$span=$abp[0];
	$power=$abp[1]*1000;		//Watt
	$rpm=1000;
	$W=$abp[2]*1000;		//Newton
	$TauD=40;
	$cm=1.5; 
	$ct=1.0;
	$MaxTM=(1000*60*$power)/(2*pi()*$rpm); //N.mm
	$MaxBM=($W*$span/4);
	$EqTM=sqrt(pow($cm*$MaxBM,2)+pow($ct*$MaxTM,2));
	$var=(16*$EqTM)/(pi()*$TauD);
	$shaft_diameter=pow($var,(1/3));
	require("../standard/shaft-diameters.php");
	$pcp[0]=round($MaxBM,2);
	$pcp[1]=round($MaxTM,2);
	$pcp[2]=$shaft_diameter;

	$val=(64*$W*pow($span,3))/(pi()*48*0.025*210000);
	$shaft_diameter=pow($val,(1/4));
	require("../standard/shaft-diameters.php");
	$pcp[3]=$shaft_diameter;

	$val=(32*$MaxTM*15*180)/(80000*pi()*pi());
	$shaft_diameter=pow($val,(1/3));
	require("../standard/shaft-diameters.php");
	$pcp[4]=$shaft_diameter;
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Twisting Moment</td><td>'.$pcp[0].' N.mm</td></tr>';
		echo '<tr><td>Bending Moment</td><td>'.$pcp[1].' N.mm</td></tr>';
		echo '<tr><td>Shaft Diameter, MSST</td><td>'.$pcp[2].' mm</td></tr>';
		echo '<tr><td>Shaft Diameter, Lateral Deflection</td><td>'.$pcp[3].' mm</td></tr>';
		echo '<tr><td>Shaft Diameter, Angular Twist</td><td>'.$pcp[4].' mm</td></tr>';
		echo '</table>';
	}

?>