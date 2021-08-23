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
	$F=500+$abp[0];
	$Ax=-5*$F;
	$Ay=-$F;
	$Bx=5*$F;
	$By=2*$F;
	$Ex=-6*$F;
	$Ey=-2*$F;
	$pcp[0]=round(sqrt(pow($Ax,2)+pow($Ay,2)),2);	
	$pcp[1]=round(sqrt(pow($Bx,2)+pow($By,2)),2);	
	$pcp[2]=round(sqrt(pow($Ex,2)+pow($Ey,2)),2);	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Ax</td><td>'.$Ax.' N</td></tr>';
		echo '<tr><td>Ay</td><td>'.$Ay.' N</td></tr>';
		echo '<tr><td>Bx</td><td>'.$Bx.' N</td></tr>';
		echo '<tr><td>By</td><td>'.$By.' N</td></tr>';
		echo '<tr><td>Ex</td><td>'.$Ex.' N</td></tr>';
		echo '<tr><td>Ey</td><td>'.$Ey.' N</td></tr>';
		echo '<tr><td>Force at A</td><td>'.$pcp[0].' N</td></tr>';
		echo '<tr><td>Force at B</td><td>'.$pcp[1].' N</td></tr>';
		echo '<tr><td>Force at C</td><td>'.$pcp[2].' N</td></tr>';
		echo '</table>';
	}
?>