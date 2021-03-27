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
	$Fc=$abp[0];		// kN
	$Fd=$abp[1];		// kN
	$Ay=(2*$Fc+$Fd)/3;
	$By=($Fc+2*$Fd)/3;
	$theta=atan(1);
	$pcp[0]=round($By,2);
	$pcp[1]=-round((($Ay-$abp[0])/sin($theta)),2);		//AE
	$pcp[2]=round($Ay,2);			// BD
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Ay</td><td>'.$Ay.' kN</td></tr>';
		echo '<tr><td>By</td><td>'.$By.' kN</td></tr>';
		echo '<tr><td>By</td><td>'.$pcp[0].' kN</td></tr>';
		echo '<tr><td>F_ED</td><td>'.$pcp[1].' kN</td></tr>';
		echo '<tr><td>F_CD</td><td>'.$pcp[2].' kN</td></tr>';
		echo '</table>';
	}
?>