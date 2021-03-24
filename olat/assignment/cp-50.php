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
	$side=$abp[3];;
	$pcp[0]=$F*$side;
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td> Force </td><td>'.$F.' </td></tr>';
		echo '<tr><td>Moment about B</td><td>'.$pcp[0].' N.mm</td></tr>';
		echo '</table>';
	}
?>