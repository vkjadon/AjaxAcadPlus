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
	$W=$abp[1];		// N
	$M=$abp[2];		// N.m
	
	$Ay=$W;

	$MA=$W*$L-$M;
	$Mx=$MA-2*$W;
	
	if($Ay<0)$Ay=-$Ay;
	if($Mx<0)$Mx=-$Mx;
	$pcp[0]=round($Mx,2);
	$pcp[1]=round($Ay,2);
	
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Reaction Ay (Magnitude)</td><td>'.$Ay.' N</td></tr>';
		echo '<tr><td>Reaction MA (Magnitude)</td><td>'.$MA.' Nm</td></tr>';
		echo '<tr><td>BM at x=2 m</td><td>'.$pcp[0].' Nm</td></tr>';
		echo '<tr><td>SF at x= 1.5 m</td><td>'.$pcp[1].' N</td></tr>';
		echo '</table>';
	}
?>