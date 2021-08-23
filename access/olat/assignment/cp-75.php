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
	$a=$abp[0];		// m
	$b=$abp[1];		// m
	$F1=$abp[2];		// N
	$w2=$abp[3];		// N/m

	$w1=2*$F1/$a;
	$F2=$b*$w2;

	$x1=2*$a/3;
	$x2=$b/2;

	$Cy=($F1*$x1+$F2*$x2)/$a;
	$Ay=$F1-$Cy;
	
	$pcp[0]=round($w1,2);
	$pcp[1]=round($F2,2);
	$pcp[2]=round($Ay,2);
	$pcp[3]=round($Cy,2);
	
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>w1</td><td>'.$w1.' N</td></tr>';
		echo '<tr><td>F2</td><td>'.$F2.' N</td></tr>';
		echo '<tr><td>x1</td><td>'.$x1.' m</td></tr>';
		echo '<tr><td>x2</td><td>'.$x2.' m</td></tr>';
		echo '<tr><td>Load Intensity </td><td>'.$pcp[0].' N/m</td></tr>';
		echo '<tr><td>Load F2</td><td>'.$pcp[1].' N</td></tr>';
		echo '<tr><td>Reaction Ay</td><td>'.$pcp[2].' N</td></tr>';
		echo '<tr><td>Reaction Cy</td><td>'.$pcp[3].' N</td></tr>';
		echo '</table>';
	}
?>