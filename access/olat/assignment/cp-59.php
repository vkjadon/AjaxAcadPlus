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
	$F=$abp[0];		// N
	$F_B=0.712*$F;
	$F_D=2.083*$F;
	$pcp[0]=round($F_B,2);
	$pcp[1]=round($F_D,2);
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Force at Pin B</td><td>'.$pcp[0].' N</td></tr>';
		echo '<tr><td>Force at Pin D</td><td>'.$pcp[1].' N</td></tr>';
		echo '</table>';
	}
?>