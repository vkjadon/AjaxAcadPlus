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
	$L=$abp[0];		// m
	$w=$abp[1];		// kN/m
	
	$V=($w*$L)/32;

	$Mx=($w*$L*$L)/48;
	
	$pcp[0]=round($V,4);
	$pcp[1]=round($Mx,4);
	
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>SF at x= '.($L/4).' m</td><td>'.$pcp[0].' kN</td></tr>';
		echo '<tr><td>BM at x='.($L/2).' m</td><td>'.$pcp[1].' kNm</td></tr>';
		echo '</table>';
	}
?>