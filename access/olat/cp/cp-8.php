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
	$F=$abp[0];;
	$a=$abp[1];;
	$b=$abp[2];;
	$pcp[0]=$F*$b;
	$pcp[1]="100";
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td> F </td><td>'.$F.' </td></tr>';
		echo '<tr><td> a </td><td>'.$a.' </td></tr>';
		echo '<tr><td> b </td><td>'.$b.' </td></tr>';
		echo '<tr><td>Moment about B</td><td>'.$pcp[0].' N.mm</td></tr>';
		echo '<tr><td>Distance </td><td>'.$pcp[1].' km</td></tr>';
		echo '</table>';
	}
?>