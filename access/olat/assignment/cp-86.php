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
	$W=$abp[0];		// kN
	$w=$abp[1];		// kN/m
	$L=16;

	$Ay=1.143*$W+4.571*$w;
	$By=11.429*$w-0.143*$W;

	$a=8-(32*$w/$By);
	$Vx=$W+4*$w-$Ay;
	if($Vx<0)$Vx=-$Vx;
	$Mx1=$w*$a*$a*0.5;
	$Mx2=$w*0.5+$W;
	$Mx=max($Mx1,$Mx2);
	$pcp[0]=round($a,3);
	$pcp[1]=round($Vx,2);
	$pcp[2]=round($Mx,2);
	
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Reaction at A</td><td>'.$Ay.' kN</td></tr>';
		echo '<tr><td>a </td><td>'.$pcp[0].' m</td></tr>';
		echo '<tr><td>SF at x=4m </td><td>'.$pcp[1].' kN</td></tr>';
		echo '<tr><td>Max BM (kN.m) </td><td>'.$pcp[2].' kN.m</td></tr>';
		echo '</table>';
	}
?>