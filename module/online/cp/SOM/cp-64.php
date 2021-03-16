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
	$Fb=$abp[0];		// kN
	$Fc=$abp[1];		// kN
	$theta=atan(4/6);

	$Ax=-(0.5*$Fb+$Fc)/tan($theta);
	$Ay=0.5*$Fb;
	$F_A=sqrt(pow($Ax,2)+pow($Ay,2));
	$pcp[0]=round($F_A,2);
	$pcp[1]=-round(((0.5*$Fb+$Fc)/sin($theta)),2);		//AE
	$pcp[2]=-round(($Fc/sin($theta)),2);		//AE
	$pcp[3]=round(($Ay/sin($theta)),2);		//AE
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Ax</td><td>'.$Ax.' kN</td></tr>';
		echo '<tr><td>Ay</td><td>'.$Ay.' kN</td></tr>';
		echo '<tr><td>By</td><td>'.$By.' kN</td></tr>';
		echo '<tr><td>F_A</td><td>'.$pcp[0].' kN</td></tr>';
		echo '<tr><td>F_ED</td><td>'.$pcp[1].' kN</td></tr>';
		echo '<tr><td>F_AD</td><td>'.$pcp[3].' kN</td></tr>';
		echo '</table>';
	}
?>