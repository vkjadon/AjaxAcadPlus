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
	$F_A=$abp[0];
	$F_C=$abp[1];
	$AB=$abp[2];
	$AC=$abp[3];
	$theta=acos(($AC/$AB));
	$d_A=0.5*$AB*sin($theta);
	$d_C=0.5*$AB*cos($theta);
	$pcp[0]=round($F_A*$d_A,2);
	$pcp[1]=round($F_C*$d_C,2);	
	$pcp[2]=round(($F_A*$d_A+$F_C*$d_C),2);
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td> AB </td><td>'.$AB.' </td></tr>';
		echo '<tr><td> AC </td><td>'.$AC.' </td></tr>';
		echo '<tr><td> Theta </td><td>'.$theta.' </td></tr>';
		echo '<tr><td> dA</td><td>'.$d_A.' </td></tr>';
		echo '<tr><td> dC </td><td>'.$d_C.' </td></tr>';
		echo '<tr><td>Moment of Force at A </td><td>'.$pcp[0].' kN.mm</td></tr>';
		echo '<tr><td>Moment of Force at C</td><td>'.$pcp[1].' kN.mm</td></tr>';
		echo '<tr><td>Moment</td><td>'.$pcp[2].' kN.mm</td></tr>';
		echo '</table>';
	}
?>