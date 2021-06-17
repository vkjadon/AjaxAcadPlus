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
	$k=$abp[0];
	$d=$abp[1];
	$AB=round(sqrt(pow($d,2)+9),3);
	$F_AB=$k*($AB-3.0);
	$theta=asin(3/$AB);			//	rad
	$angle=(180/pi())*$theta;	// degree
	$pcp[0]=round((2*$F_AB*cos($theta)),2);	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>AB</td><td>'.$AB.' m</td></tr>';
		echo '<tr><td>F_AB</td><td>'.$F_AB.' N</td></tr>';
		echo '<tr><td>Angle of AB with Horizontal</td><td>'.$angle.' deg</td></tr>';
		echo '<tr><td>F</td><td>'.$pcp[0].' N</td></tr>';
		echo '</table>';
	}
?>