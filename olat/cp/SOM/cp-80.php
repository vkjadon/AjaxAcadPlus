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
	$w=$abp[0];		// kN/m
	$M=$abp[1];		// kN.m
	
	$Ay=(2*$w/3)+1.875+0.5*$M;
	$By=$w/3-9.375-0.5*$M;

	$VA=0.5*$w*2;
	$VB=$By+7.5;
	if($VB<0)$VB=-$VB;
	$V=max($VA, $VB, 7.5);

	$MB=7.5*0.5;
	$Mx=max($M, $MB);
	
	$pcp[0]=round($Ay,2);
	$pcp[1]=round($By,2);
	$pcp[2]=round($Mx,2);
	$pcp[3]=round($V,2);
	
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>SF at x= 1.5 m</td><td>'.$pcp[0].' kN</td></tr>';
		echo '<tr><td>BM at x=2 m</td><td>'.$pcp[1].' kNm</td></tr>';
		echo '</table>';
	}
?>