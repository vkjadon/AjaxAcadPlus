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
	$power=$abp[1];		//Watt
	$rpm=120;
	$W=$abp[3];			//Newton
	$TauD=$abap[0];
	$cm=$abap[1]; 
	$ct=$abap[2];
	if($cm=='' )$cm=1.0;
	if($ct=='' )$ct=1.0;
	$ke=1;
	$MaxTM=(1000*60*$power)/(2*pi()*$rpm); //N.mm
	$pcp[0]=round($MaxTM,2);
	$F2=2*$MaxTM/(1.566*$abp[2]);
	$pcp[2]=round($F2,2);
	$F1=2.566*$F2;
	$pcp[1]=round($F1,2);
	$F=sqrt(pow($W,2)+pow(($F1+$F2),2));
	$MaxBM=$F*$span;
	$pcp[3]=round($MaxBM,2);
	$EqTM=sqrt($MaxBM*$MaxBM+$MaxTM*$MaxTM);
	$var=(16*$EqTM)/(pi()*$ke*$TauD);
	$shaft_diameter=pow($var,(1/3));
	require("../standard/shaft-diameters.php");
	$pcp[4]=$shaft_diameter;
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Twisting Moment</td><td>'.$pcp[0].' N.mm</td></tr>';
		echo '<tr><td>Tension in Tight Side </td><td>'.$pcp[1].' N.mm</td></tr>';
		echo '<tr><td>Tension in Slack Side </td><td>'.$pcp[2].' N.mm</td></tr>';
		echo '<tr><td>Bending Moment</td><td>'.$pcp[3].' N.mm</td></tr>';
		echo '<tr><td>Shaft Diameter, MSST</td><td>'.$pcp[4].' mm</td></tr>';
		echo '</table>';
	}

?>