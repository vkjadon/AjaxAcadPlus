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
	$b=$abp[0];		// m
	$w1=$abp[1];		// N/m
	$a=$abp[2];		// m
	$w2=$abp[3];		// N/m

	$F1=(0.5)*$b*($w1-50);
	$F2=$a*$w2;
	$F3=50*$b;

	$FR=$F1+$F3;

	$x1=$b/3;
	$x2=$a/2;
	$x3=$b/2;
	
	$Ax=-($F1+$F3)*cos(pi()/6);

	$SumMA=$F1*$x1+$F2*($b*cos(pi()/3)+0.5*$a)+$F3*$x3;
	$By=$SumMA/($b*cos(pi()/3)+$a);
	$Ay=0.5*($F1+$F3)+$F2-$By;
	
	$pcp[0]=round($FR,2);
	$pcp[1]=round($Ax,2);
	$pcp[2]=round($Ay,2);
	$pcp[3]=round($By,2);
	
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>F1</td><td>'.$F1.' N</td></tr>';
		echo '<tr><td>F2 (rectangular of 50 N/m)</td><td>'.$F2.' N</td></tr>';
		echo '<tr><td>F3 (BC)</td><td>'.$F3.' N</td></tr>';
		echo '<tr><td>x1 Location F1</td><td>'.$x1.' m</td></tr>';
		echo '<tr><td>x2 Location F2 from B</td><td>'.$x2.' m</td></tr>';
		echo '<tr><td>x2 Location F3 from A</td><td>'.$x3.' m</td></tr>';
		echo '<tr><td>Transverse Load on AC </td><td>'.$pcp[0].' kN</td></tr>';
		echo '<tr><td>Reaction Ax</td><td>'.$pcp[1].' N</td></tr>';
		echo '<tr><td>Reaction Ay</td><td>'.$pcp[2].' N</td></tr>';
		echo '<tr><td>Reaction By</td><td>'.$pcp[3].' N</td></tr>';
		echo '</table>';
	}
?>