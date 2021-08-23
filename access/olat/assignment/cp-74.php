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
	$w1=$abp[0];		// kN/m
	$w2=$abp[1];		// kN/m
	$a=$abp[2];		// m

	$F1=(0.5)*6*($w1-2);
	$F2=(0.5)*$a*($w2-2);
	$F3=2*(6+$a);

	$x1=2;
	$x2=6+((2*$a)/3);
	$x3=0.5*(6+$a);
	$FR=$F1+$F2+$F3;
	$SumMA=$F1*$x1+$F2*$x2+$F3*$x3;
	$x=$SumMA/$FR;
	
	$By=$SumMA/(6+$a);
	$Ay=$FR-$By;
	
	$pcp[0]=round($FR,2);
	$pcp[1]=round($x,2);
	$pcp[2]=round($Ay,2);
	$pcp[3]=round($By,2);
	
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>F1</td><td>'.$F1.' N</td></tr>';
		echo '<tr><td>F2</td><td>'.$F2.' N</td></tr>';
		echo '<tr><td>F3 (rectangular of 2 kN/m)</td><td>'.$F3.' N</td></tr>';
		echo '<tr><td>x1</td><td>'.$x1.' m</td></tr>';
		echo '<tr><td>x2</td><td>'.$x2.' m</td></tr>';
		echo '<tr><td>x2</td><td>'.$x3.' m</td></tr>';
		echo '<tr><td>Resultant Load FR</td><td>'.$pcp[0].' kN</td></tr>';
		echo '<tr><td>x</td><td>'.$pcp[1].' m</td></tr>';
		echo '<tr><td>Reaction Ay</td><td>'.$pcp[2].' kN</td></tr>';
		echo '<tr><td>Reaction By</td><td>'.$pcp[3].' kN</td></tr>';
		echo '</table>';
	}
?>