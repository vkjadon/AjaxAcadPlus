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
	$M_A=$abp[0];
	$M_B=$abp[1];
	$x=(0.858*$abp[0]-1.286*$abp[1])/0.45;
	$y=(3*$abp[0]-$abp[1])/3.642;
	$F=round(sqrt(pow($x,2)+pow($y,2)),2);
	$theta=atan($x/$y);
	$angle=(180/pi())*$theta;
	$pcp[0]=round($F,2);	
	$pcp[1]=round($angle,2);
// Solution
	if($solution=='Y')
	{
		echo '<table class="table list-table-xs">';
		echo '<tr><td> x </td><td>'.$x.' </td></tr>';
		echo '<tr><td> y </td><td>'.$y.' </td></tr>';
		echo '<tr><td>Force</td><td>'.$pcp[0].' N</td></tr>';
		echo '<tr><td>Angle </td><td>'.$pcp[1].' degree</td></tr>';
		echo '</table>';
	}
?>