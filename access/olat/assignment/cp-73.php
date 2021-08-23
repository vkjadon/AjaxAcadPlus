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
	$w1=$abp[0];		// N/m
	$a=$abp[1];			// m
	$w2=$abp[2];		// N/m
	$b=$abp[3];			// m

	$F1=$w1*$a;
	$F2=$w2*$b;
	$x1=$a/2;
	$x2=($a+$b/2);
	$FR=-$F1+$F2;
	$MA=$F1*$x1-$F2*$x2;
	
	$By=($MA/($a+$b));
	$Ay=-$FR-$By;
	
	$pcp[0]=round($FR,2);
	$pcp[1]=round($MA,2);
	$pcp[2]=round($Ay,2);
	$pcp[3]=round($By,2);
	
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>F1</td><td>'.$F1.' N</td></tr>';
		echo '<tr><td>F2</td><td>'.$F2.' N</td></tr>';
		echo '<tr><td>x1</td><td>'.$x1.' m</td></tr>';
		echo '<tr><td>x2</td><td>'.$x2.' m</td></tr>';
		echo '<tr><td>Resultant Load FR</td><td>'.$pcp[0].' N</td></tr>';
		echo '<tr><td>Resultant Clockwise Moment MA</td><td>'.$pcp[1].' N.m</td></tr>';
		echo '<tr><td>Reaction Ay</td><td>'.$pcp[2].' N</td></tr>';
		echo '<tr><td>Reaction By</td><td>'.$pcp[3].' N</td></tr>';
		echo '</table>';
	}
?>